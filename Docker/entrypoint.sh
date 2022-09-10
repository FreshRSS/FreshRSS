#!/bin/sh

php -f ./cli/prepare.php >/dev/null

find /etc/php*/ -type f -name php.ini -exec sed -r -i "\\#^;?date.timezone#s#^.*#date.timezone = $TZ#" {} \;
find /etc/php*/ -type f -name php.ini -exec sed -r -i "\\#^;?post_max_size#s#^.*#post_max_size = 32M#" {} \;
find /etc/php*/ -type f -name php.ini -exec sed -r -i "\\#^;?upload_max_filesize#s#^.*#upload_max_filesize = 32M#" {} \;

if [ -n "$LISTEN" ]; then
	find /etc/apache2/ -type f -name FreshRSS.Apache.conf -exec sed -r -i "\\#^Listen#s#^.*#Listen $LISTEN#" {} \;
fi

if [ -n "$CRON_MIN" ]; then
	(
		echo "export TZ=$TZ"
		echo "export COPY_LOG_TO_SYSLOG=$COPY_LOG_TO_SYSLOG"
		echo "export COPY_SYSLOG_TO_STDERR=$COPY_SYSLOG_TO_STDERR"
		echo "export FRESHRSS_ENV=$FRESHRSS_ENV"
	) >/var/www/FreshRSS/Docker/env.txt
	sed </etc/crontab.freshrss.default \
		-r "s#^[^ ]+ #$CRON_MIN #" | crontab -
fi

if [ -n "$FRESHRSS_INSTALL" ]; then
	# shellcheck disable=SC2046
	php -f ./cli/do-install.php -- \
		$(echo "$FRESHRSS_INSTALL" | sed -r 's/[\r\n]+/\n/g' | paste -s -)
	EXITCODE=$?

	if [ $EXITCODE -eq 3 ]; then
		echo 'ℹ️ FreshRSS already installed; no change performed.'
	elif [ $EXITCODE -eq 0 ]; then
		echo '✅ FreshRSS successfully installed.'
	else
		echo '❌ FreshRSS error during installation!'
		exit $EXITCODE
	fi
fi

if [ -n "$FRESHRSS_USER" ]; then
	# shellcheck disable=SC2046
	php -f ./cli/create-user.php -- \
		$(echo "$FRESHRSS_USER" | sed -r 's/[\r\n]+/\n/g' | paste -s -)
	EXITCODE=$?

	if [ $EXITCODE -eq 3 ]; then
		echo 'ℹ️ FreshRSS user already exists; no change performed.'
	elif [ $EXITCODE -eq 0 ]; then
		echo '✅ FreshRSS user successfully created.'
		./cli/list-users.php | xargs -n1 ./cli/actualize-user.php --user
	else
		echo '❌ FreshRSS error during the creation of a user!'
		exit $EXITCODE
	fi
fi

chown -R :www-data .
chmod -R g+r . && chmod -R g+w ./data/

exec "$@"
