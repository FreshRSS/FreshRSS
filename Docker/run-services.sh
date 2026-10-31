#!/bin/sh
# Keep Apache and the optional scheduler together for container shutdown.

server_pid=''
scheduler_pid=''
stop_services() {
	trap '' INT TERM
	[ -z "$server_pid" ] || kill -TERM "$server_pid" 2>/dev/null
	[ -z "$scheduler_pid" ] || kill -TERM "$scheduler_pid" 2>/dev/null
	[ -z "$server_pid" ] || wait "$server_pid"
	[ -z "$scheduler_pid" ] || wait "$scheduler_pid"
	return 0
}
trap 'stop_services; exit 0' INT TERM

if [ -n "$CRON_MIN" ]; then
	supercronic /run/freshrss/crontab &
	scheduler_pid=$!
fi
"$@" &
server_pid=$!
wait "$server_pid"
status=$?
stop_services
exit "$status"
