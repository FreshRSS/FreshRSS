#!/bin/bash
set -euo pipefail
umask 077

die() { echo "FreshRSS scheduler: $*" >&2; exit 1; }

# Strip leading zeroes before arithmetic, avoiding octal and integer overflow.
minute_number() {
	local number=${1#"${1%%[!0]*}"}
	[[ ${#number} -le 2 ]] || die 'Minute values and steps must be between 0 and 59.'
	printf '%d\n' "$((10#${number:-0}))"
}

translate_minutes() {
	local expression=$1 field base step first last minute result=''
	local -a fields selected=()
	[[ $expression =~ ^[0-9*/,-]+$ && $expression != ,* && $expression != *, && $expression != *,,* ]] ||
		die 'CRON_MIN must be a nonempty, single cron minute expression.'
	IFS=, read -r -a fields <<<"$expression"
	for field in "${fields[@]}"; do
		[[ $field =~ ^(\*|[0-9]+(-[0-9]+)?)(/([0-9]+))?$ ]] || die "Invalid CRON_MIN field '$field'."
		base=${BASH_REMATCH[1]}
		step=$(minute_number "${BASH_REMATCH[4]:-1}")
		(( step > 0 && step <= 59 )) || die 'CRON_MIN steps must be between 1 and 59.'
		if [[ $base = '*' ]]; then
			first=0
			last=59
		elif [[ $base = *-* ]]; then
			first=$(minute_number "${base%-*}")
			last=$(minute_number "${base#*-}")
		else
			first=$(minute_number "$base")
			last=$first
			# A stepped single value denotes that value through minute 59.
			[[ $field != */* ]] || last=59
		fi
		(( first <= last && last <= 59 )) || die "Invalid CRON_MIN range '$base'."
		for (( minute=first; minute<=last; minute+=step )); do selected[minute]=1; done
	done
	for (( minute=0; minute<60; minute++ )); do
		[[ ${selected[minute]:-0} = 0 ]] || result+="${result:+,}$minute"
	done
	printf '%s\n' "$result"
}

if [[ ${1:-} = --translate && $# = 2 ]]; then
	translate_minutes "$2"
	exit 0
fi
(( $# == 0 )) || die 'Usage: rootless-cron.sh [--translate MINUTES]'

IFS= read -r minutes <"$FRESHRSS_RUNTIME_DIR/cron-minutes"
[[ $minutes =~ ^[0-9]+(,[0-9]+)*$ ]] || die 'Missing or invalid translated minute list.'
child=''
stop_scheduler() {
	trap '' TERM INT
	if [[ -n $child ]]; then
		kill -TERM "$child" 2>/dev/null || true
		wait "$child" 2>/dev/null || true
	fi
	exit 0
}
trap stop_scheduler TERM INT

# Keep children in the supervisor's scheduler process group. Waiting on a
# background child lets Bash handle termination immediately, including mid-job.
run_child() {
	local status=0
	"$@" &
	child=$!
	wait "$child" || status=$?
	child=''
	return "$status"
}

last_minute=-1
echo "FreshRSS scheduler: enabled for minutes $minutes (TZ=${TZ:-UTC})." >&2
while :; do
	# Other fields are unrestricted; run at second zero in the inherited TZ.
	# No timefile means old schedules are not replayed after a long refresh.
	run_child /usr/bin/snooze -v -H '*' -M "$minutes" -S 0 || die 'snooze exited unsuccessfully.'
	now=$(date +%s)
	minute=$((now / 60))
	if (( minute == last_minute )); then
		# Prevent a fast job or an early wakeup from running twice in one minute.
		run_child sleep 1 || die 'Could not wait for the next scheduling interval.'
		continue
	fi
	last_minute=$minute
	echo "FreshRSS scheduler: refresh started at $(date -Iseconds)." >&2
	status=0
	run_child /usr/bin/php /var/www/FreshRSS/app/actualize_script.php || status=$?
	echo "FreshRSS scheduler: refresh finished at $(date -Iseconds), exit status $status." >&2
done
