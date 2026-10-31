#!/bin/sh
# Integration smoke test: build an image first, then pass its tag as argument.
set -eu

image=${1:?Usage: ./tests/docker-rootless.sh IMAGE}
name="freshrss-rootless-test-$$"
volume="$name-data"
fixtures="$name-fixtures"
cleanup() {
	docker rm -f "$name" "$name-custom" "$name-cron" >/dev/null 2>&1 || true
	docker volume rm "$volume" "$fixtures" >/dev/null 2>&1 || true
}
trap cleanup EXIT
trap 'exit 1' INT TERM

fail() {
	docker logs "$name" >&2 2>/dev/null || true
	echo >&2 "FAIL: $*"
	exit 1
}

wait_http() {
	i=0
	until docker exec "$1" php -r 'exit(@file_get_contents("http://127.0.0.1:8080/") === false);' >/dev/null 2>&1; do
		i=$((i + 1))
		[ "$i" -lt 30 ] || fail 'HTTP server did not start'
		sleep 1
	done
}

docker run -d --name "$name" -p 127.0.0.1::8080 \
	-v "$volume:/var/www/FreshRSS/data" \
	-e TZ=Europe/Paris "$image" >/dev/null
wait_http "$name"
[ "$(docker exec "$name" id -u)" = 1000 ] || fail 'wrong application UID'
docker exec "$name" sh -ec '
	for status in /proc/[0-9]*/status; do
		awk "/^Uid:/ { if (\$2 != 1000) exit 1 }" "$status" || exit 1
	done
	test -d data/PubSubHubbub/keys
	test -d data/Retry-After
	test -d data/users/_
	! pidof supercronic
	printf preserved >data/rootless-test
	rm data/Retry-After/index.html
	rmdir data/Retry-After
' || fail 'identity, storage, timezone, or disabled scheduling'
docker exec "$name" php -r 'exit(date_default_timezone_get() !== "Europe/Paris" || ini_get("upload_max_filesize") !== "32M");'
docker restart "$name" >/dev/null
wait_http "$name"
docker exec "$name" sh -ec 'test -d data/Retry-After; test "$(cat data/rootless-test)" = preserved'

# Install and create a user via the same environment-driven startup as operators.
docker rm -f "$name" >/dev/null
docker run -d --name "$name" -p 127.0.0.1::8080 \
	-v "$volume:/var/www/FreshRSS/data" \
	-e 'FRESHRSS_INSTALL=--default-user tester --db-type sqlite --auth-type form' \
	-e 'FRESHRSS_USER=--user tester --password test-password --no-default-feeds' \
	-e 'CRON_MIN=*/15' "$image" >/dev/null
wait_http "$name"
docker exec "$name" sh -ec 'test -f data/users/tester/config.php; pidof supercronic'
docker exec "$name" php app/actualize_script.php >/dev/null

# Validate expressions with the real scheduler rather than duplicating its parser.
for minute in '*' '1,31' '0-59/15' '*/5' '05'; do
	docker exec "$name" sh -c 'printf "%s * * * * true\n" "$1" >/run/freshrss/test-crontab; supercronic -test /run/freshrss/test-crontab' sh "$minute"
done
if docker run --rm -e CRON_MIN=invalid "$image" true; then
	fail 'invalid schedule accepted'
fi
if docker run --rm -e DATA_PATH=/root/unwritable "$image" true; then
	fail 'unwritable storage accepted'
fi
docker run --rm -e DATA_PATH=/tmp/custom-data "$image" sh -ec 'test -d /tmp/custom-data/PubSubHubbub/keys'

# Prepared bind storage and a read-only custom configuration remain supported.
docker run --rm --user 0 --entrypoint sh -v "$fixtures:/fixtures" "$image" -ec '
	mkdir /fixtures/data
	chown 1000 /fixtures/data
	printf "<?php return [\"title\" => \"Rootless fixture\"];\n" >/fixtures/config.custom.php
	chmod 644 /fixtures/config.custom.php
'
fixtures_path=$(docker volume inspect -f '{{.Mountpoint}}' "$fixtures")
docker run --rm --mount "type=bind,src=$fixtures_path/data,dst=/custom-data" \
	--mount "type=bind,src=$fixtures_path/config.custom.php,dst=/custom-data/config.custom.php,readonly" \
	-e DATA_PATH=/custom-data -e 'FRESHRSS_INSTALL=--default-user tester --db-type sqlite' "$image" php -r '
	require "cli/_cli.php";
	exit(FreshRSS_Context::systemConf()->title !== "Rootless fixture" || !is_dir(DATA_PATH . "/tokens"));
'

# LISTEN and proxy/log settings remain configurable as non-root.
docker run -d --name "$name-custom" -p 127.0.0.1::8080 \
	-e LISTEN=0.0.0.0:8080 -e TRUSTED_PROXY=0 -e ENABLE_ACCESS_LOG=0 "$image" >/dev/null
wait_http "$name-custom"

# Accelerated scheduler checks use supercronic's seconds field, without waiting
# for a wall-clock minute. Apache stays available in the same container while
# jobs inherit the environment and recover after failure.
docker run -d --name "$name-cron" -e CRON_MIN='*' \
	-e ROOTLESS_TEST_VALUE=inherited "$image" sh -ec '
	printf "* * * * * * * echo \$ROOTLESS_TEST_VALUE >>/run/freshrss/ticks; exit 1\n" >/run/freshrss/crontab
	exec ./Docker/run-services.sh httpd -D FOREGROUND
' >/dev/null
wait_http "$name-cron"
i=0
until [ "$(docker exec "$name-cron" sh -c 'wc -l </run/freshrss/ticks' 2>/dev/null || echo 0)" -ge 2 ]; do
	i=$((i + 1))
	[ "$i" -lt 15 ] || fail 'scheduler did not recover after job failure'
	sleep 1
done
docker exec "$name-cron" grep -q inherited /run/freshrss/ticks
wait_http "$name-cron"
for container in "$name" "$name-cron"; do
	docker stop -t 10 "$container" >/dev/null
	[ "$(docker inspect -f '{{.State.ExitCode}}' "$container")" = 0 ] || fail 'unclean shutdown'
done
# Stopping during an active job allows supercronic to finish it gracefully.
docker rm "$name-cron" >/dev/null
docker run -d --name "$name-cron" -e CRON_MIN='*' "$image" sh -ec '
	printf "* * * * * * * touch /run/freshrss/started; sleep 2; touch /run/freshrss/completed\n" >/run/freshrss/crontab
	exec ./Docker/run-services.sh httpd -D FOREGROUND
' >/dev/null
wait_http "$name-cron"
i=0
until docker exec "$name-cron" test -f /run/freshrss/started; do
	i=$((i + 1))
	[ "$i" -lt 15 ] || fail 'active scheduler job did not start'
	sleep 1
done
docker stop -t 10 "$name-cron" >/dev/null
docker cp "$name-cron:/run/freshrss/completed" - >/dev/null || fail 'active job did not complete on shutdown'
echo "PASS: $image"
