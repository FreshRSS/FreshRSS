#!/bin/sh

php -f ./cli/prepare.php > /dev/null

chown -R :www-data .
chmod -R g+r . && chmod -R g+w ./data/

find /etc/php*/ -name php.ini -exec sed -r -i "\#^;?date.timezone#s#^.*#date.timezone = $TZ#" {} \;

if [ -n "$CRON_MIN" ]; then
	(echo "export TZ=$TZ" ; echo "export COPY_SYSLOG_TO_STDERR=$COPY_SYSLOG_TO_STDERR") > /var/www/FreshRSS/Docker/env.txt
	crontab -l | sed -r "\#FreshRSS#s#^[^ ]+ #$CRON_MIN #" | crontab -
fi

exec "$@"
