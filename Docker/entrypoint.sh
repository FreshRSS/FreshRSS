#!/bin/sh

ln -snf "/usr/share/zoneinfo/$TZ" /etc/localtime
echo "$TZ" >/etc/timezone

find /etc/php*/ -type f -name php.ini -exec sed -i -E \
	-e "\\#^;?date.timezone#s#^.*#date.timezone = $TZ#" \
	-e "\\#^;?post_max_size#s#^.*#post_max_size = 32M#" \
	-e "\\#^;?upload_max_filesize#s#^.*#upload_max_filesize = 32M#" {} \;

if [ -n "$LISTEN" ]; then
	find /etc/apache2/ -type f -name FreshRSS.Apache.conf -exec sed -r -i "\\#^Listen#s#^.*#Listen $LISTEN#" {} \;
fi

if [ -n "$TRUSTED_PROXY" ]; then
	if [ "$TRUSTED_PROXY" = "0" ]; then
		# Disable RemoteIPHeader and RemoteIPInternalProxy
		find /etc/apache2/ -type f -name FreshRSS.Apache.conf -exec sed -r -i "/^\s*RemoteIP.*$/s/^/#/" {} \;
	else
		# Custom list for RemoteIPInternalProxy
		find /etc/apache2/ -type f -name FreshRSS.Apache.conf -exec sed -r -i "\\#^\s*RemoteIPInternalProxy#s#^.*#\tRemoteIPInternalProxy $TRUSTED_PROXY#" {} \;
	fi
fi

if [ -n "$OIDC_ENABLED" ] && [ "$OIDC_ENABLED" -ne 0 ]; then
	# Default values
	export OIDC_SESSION_INACTIVITY_TIMEOUT="${OIDC_SESSION_INACTIVITY_TIMEOUT:-300}"
	export OIDC_SESSION_MAX_DURATION="${OIDC_SESSION_MAX_DURATION:-27200}"
	export OIDC_SESSION_TYPE="${OIDC_SESSION_TYPE:-server-cache}"

	# Debian
	(which a2enmod >/dev/null && a2enmod -q auth_openidc) ||
		# Alpine
		(mv /etc/apache2/conf.d/mod-auth-openidc.conf.bak /etc/apache2/conf.d/mod-auth-openidc.conf && echo 'Enabling module auth_openidc.')
	if [ -n "$OIDC_SCOPES" ]; then
		# Compatibility with : as separator instead of space
		OIDC_SCOPES=$(echo "$OIDC_SCOPES" | tr ':' ' ')
		export OIDC_SCOPES
	fi
fi

if [ -n "$CRON_MIN" ]; then
	awk -v RS='\0' '!/^(FRESHRSS_INSTALL|FRESHRSS_USER|HOME|PATH|PWD|SHLVL|TERM|_)=/ {gsub("\047", "\047\\\047\047"); print "export \047" $0 "\047"}' /proc/self/environ >/var/www/FreshRSS/Docker/env.txt
	sed </etc/crontab.freshrss.default \
		-r "s#^[^ ]+ #$CRON_MIN #" | crontab -
fi

./cli/access-permissions.sh

php -f ./cli/prepare.php >/dev/null

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

./cli/access-permissions.sh

exec "$@"
