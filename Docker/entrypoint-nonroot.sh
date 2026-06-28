#!/bin/sh

# Non-root entrypoint for FreshRSS
# Timezone is handled via TZ environment variable (no system file modification needed)
# PHP configuration is done at build time

while read -r config_path _; do
	if [ -f "$config_path" ]; then
		APACHE_CONFIG="$config_path"
		break
	fi
done <<EOF
/etc/apache2/sites-available/FreshRSS.Apache.conf # Debian
/etc/apache2/conf.d/FreshRSS.Apache.conf          # Alpine
/etc/httpd/conf/conf.d/FreshRSS.Apache.conf       # Arch
EOF

if [ -z "$APACHE_CONFIG" ]; then
	echo '❌ Apache configuration file not found!'
	exit 11
fi

if [ -n "$LISTEN" ]; then
	sed -r -i "\\#^Listen#s#^.*#Listen $LISTEN#" "$APACHE_CONFIG"
fi

if [ -n "$TRUSTED_PROXY" ]; then
	if [ "$TRUSTED_PROXY" = "0" ]; then
		# Disable RemoteIPHeader and RemoteIPInternalProxy
		sed -r -i "/^\s*RemoteIP.*$/s/^/#/" "$APACHE_CONFIG"
	else
		# Custom list for RemoteIPInternalProxy
		sed -r -i "\\#^\s*RemoteIPInternalProxy#s#^.*#\tRemoteIPInternalProxy $TRUSTED_PROXY#" "$APACHE_CONFIG"
	fi
fi

if [ -n "$OIDC_ENABLED" ] && [ "$OIDC_ENABLED" -ne 0 ]; then
	# Default values
	export OIDC_SESSION_INACTIVITY_TIMEOUT="${OIDC_SESSION_INACTIVITY_TIMEOUT:-300}"
	export OIDC_SESSION_MAX_DURATION="${OIDC_SESSION_MAX_DURATION:-27200}"
	export OIDC_SESSION_TYPE="${OIDC_SESSION_TYPE:-server-cache}"

	# Alpine - move config back
	if [ -f /etc/apache2/conf.d/mod-auth-openidc.conf.bak ]; then
		mv /etc/apache2/conf.d/mod-auth-openidc.conf.bak /etc/apache2/conf.d/mod-auth-openidc.conf
		echo 'Enabling module auth_openidc.'
	fi

	if [ -n "$OIDC_SCOPES" ]; then
		# Compatibility with : as separator instead of space
		OIDC_SCOPES=$(echo "$OIDC_SCOPES" | tr ':' ' ')
		export OIDC_SCOPES
	fi
fi

if [ -n "$CRON_MIN" ]; then
	# Generate crontab with custom minute value for supercronic
	sed -r "s#^[^ ]+ #$CRON_MIN #" /var/www/FreshRSS/Docker/crontab.freshrss.default > /var/www/FreshRSS/Docker/crontab.freshrss
fi

# Ensure data directories exist (non-root safe)
data_path="${DATA_PATH:-./data}"
mkdir -p "${data_path}/users/_/" 2>/dev/null || true

php -f ./cli/prepare.php >/dev/null

if [ -n "$FRESHRSS_INSTALL" ]; then
	# shellcheck disable=SC2046
	php -f ./cli/do-install.php -- \
		$(eval "echo \"$FRESHRSS_INSTALL\"" | sed -r 's/[\r\n]+/\n/g' | paste -s -)
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
		$(eval "echo \"$FRESHRSS_USER\"" | sed -r 's/[\r\n]+/\n/g' | paste -s -)
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

exec "$@"

