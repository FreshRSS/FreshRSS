#!/bin/sh

# Read a variable from a file (Docker/Kubernetes secret), following the same
# `*_FILE` convention as the official postgres/mysql Docker images.
# e.g. `OIDC_CLIENT_SECRET_FILE=/run/secrets/oidc_client_secret` sets `OIDC_CLIENT_SECRET` from that file.
# Only kept for variables that are read directly by Apache/mod_auth_openidc from the
# container's runtime environment. NOT used for FRESHRSS_INSTALL/FRESHRSS_USER parameters
# (e.g. DB_*, ADMIN_*), because those are interpolated by `docker compose` on the host
# before the container starts, so a `_FILE`-only value would silently resolve to blank.
file_env() {
	# shellcheck disable=SC3043 # 'local' is supported by dash, ash, and bash, which are the shells used to run this script
	local var file_var var_value file_value
	var="$1"
	case "$var" in
		''|*[!_0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ]*)
			echo "❌ Invalid variable name: $var"
			exit 15
			;;
	esac
	file_var="${var}_FILE"
	eval "var_value=\${$var:-}"
	eval "file_value=\${$file_var:-}"
	if [ -n "$var_value" ] && [ -n "$file_value" ]; then
		echo "❌ Both $var and $file_var are set, please define only one of them!"
		exit 13
	fi
	if [ -n "$file_value" ]; then
		var_value=$(cat <"$file_value") || {
			echo "❌ Could not read secret file $file_value for $file_var!"
			exit 14
		}
		export "$var=$var_value"
		unset "$file_var"
	fi
}

for secret_var in OIDC_CLIENT_SECRET OIDC_CLIENT_ID OIDC_CLIENT_CRYPTO_KEY; do
	file_env "$secret_var"
done

ln -snf "/usr/share/zoneinfo/$TZ" /etc/localtime
echo "$TZ" >/etc/timezone

find /etc/php*/ -type f -name php.ini -exec sed -i -E \
	-e "\\#^;?date.timezone#s#^.*#date.timezone = $TZ#" \
	-e "\\#^;?post_max_size#s#^.*#post_max_size = 32M#" \
	-e "\\#^;?upload_max_filesize#s#^.*#upload_max_filesize = 32M#" {} \;

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

if [ "$ENABLE_ACCESS_LOG" = "0" ]; then
	sed -E -i '/^[ \t]*CustomLog[ \t]/s/^/#/' "$APACHE_CONFIG"
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
	export OIDC_DEFAULT_URL="${OIDC_DEFAULT_URL:-/i/}"

	# Debian
	(which a2enmod >/dev/null && a2enmod -q auth_openidc) ||
		# Alpine
		(mv /etc/apache2/conf.d/mod-auth-openidc.conf.bak /etc/apache2/conf.d/mod-auth-openidc.conf && echo 'Enabling module auth_openidc.') ||
		# Misc.
		(echo '❌ Failed to enable auth_openidc module!' && exit 12)

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

./cli/access-permissions.sh --only-userdirs

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

# Fix permissions of data added by prepare.php as well as a potential
# installation/user setup
./cli/access-permissions.sh --only-userdirs

exec "$@"
