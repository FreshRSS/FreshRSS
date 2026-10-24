#!/bin/bash
set -uo pipefail

apache=(/usr/sbin/apache2 -f "$FRESHRSS_RUNTIME_DIR/apache2.conf")
if [[ -n ${OIDC_ENABLED:-} && $OIDC_ENABLED -ne 0 ]]; then
	apache+=(-D OIDC_ENABLED)
fi
"${apache[@]}" -t || exit 1

pids=()
stop_services() {
	trap '' TERM INT
	for pid in "${pids[@]}"; do kill -TERM -- "-$pid" 2>/dev/null || true; done
	deadline=$((SECONDS + 8))
	while ((SECONDS < deadline)); do
		alive=0
		for pid in "${pids[@]}"; do kill -0 -- "-$pid" 2>/dev/null && alive=1; done
		((alive)) || break
		sleep 0.1
	done
	for pid in "${pids[@]}"; do kill -KILL -- "-$pid" 2>/dev/null || true; done
	for pid in "${pids[@]}"; do wait "$pid" 2>/dev/null || true; done
}
trap 'stop_services; exit 0' TERM INT

# Each service and its children form a separate process group for shutdown.
setsid "${apache[@]}" -D FOREGROUND "$@" &
pids+=("$!")
if [[ -n ${CRON_MIN:-} ]]; then
	setsid /bin/bash ./Docker/rootless-cron.sh &
	pids+=("$!")
fi
status=0
wait -n "${pids[@]}" || status=$?
echo "FreshRSS: a required service exited (status $status); stopping the container." >&2
stop_services
((status != 0)) || status=1
exit "$status"
