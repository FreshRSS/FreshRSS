#!/bin/sh

php -f ./cli/prepare.php > /dev/null

chown -R :www-data .
chmod -R g+r . && chmod -R g+w ./data/

if [ -n "$CRON_MIN" ]; then
	sed -r -i "\#FreshRSS#s#^[^ ]+ #$CRON_MIN #" /var/spool/cron/crontabs/root
fi

exec "$@"
