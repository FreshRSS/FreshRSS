#!/bin/sh

php -f ./cli/prepare.php >/dev/null

chown -R :www-data .
chmod -R g+r . && chmod -R g+w ./data/

find /etc/php*/ -name php.ini -exec sed -r -i "\\#^;?date.timezone#s#^.*#date.timezone = $TZ#" {} \;
find /etc/php*/ -name php.ini -exec sed -r -i "\\#^;?post_max_size#s#^.*#post_max_size = 32M#" {} \;
find /etc/php*/ -name php.ini -exec sed -r -i "\\#^;?upload_max_filesize#s#^.*#upload_max_filesize = 32M#" {} \;

if [ -n "$CRON_MIN" ]; then
	(
		echo "export TZ=$TZ"
		echo "export COPY_LOG_TO_SYSLOG=$COPY_LOG_TO_SYSLOG"
		echo "export COPY_SYSLOG_TO_STDERR=$COPY_SYSLOG_TO_STDERR"
		echo "export FRESHRSS_ENV=$FRESHRSS_ENV"
	) >/var/www/FreshRSS/Docker/env.txt
	crontab -l | sed -r "\\#FreshRSS#s#^[^ ]+ #$CRON_MIN #" | crontab -
fi

exec "$@"
