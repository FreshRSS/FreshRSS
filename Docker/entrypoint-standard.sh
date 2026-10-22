#!/bin/sh

# Runtime preparation for the existing Debian, Alpine, and Arch image family.
# This file is sourced by entrypoint.sh so exports affect the final command.

# --- Apply timezone, PHP defaults, and Apache options ---
prepare_standard_configuration() {
	if [ "$is_root" -eq 1 ]; then
		# Configure system timezone, PHP defaults, and Apache options as root.
		ln -snf "/usr/share/zoneinfo/$TZ" /etc/localtime || die 'Could not set /etc/localtime.'
		echo "$TZ" >/etc/timezone || die 'Could not write /etc/timezone.'

		find /etc/php*/ -type f -name php.ini -exec sed -i -E \
			-e "\\#^;?date.timezone#s#^.*#date.timezone = $TZ#" \
			-e "\\#^;?post_max_size#s#^.*#post_max_size = 32M#" \
			-e "\\#^;?session.upload_progress.enabled#s#^.*#session.upload_progress.enabled = Off#" \
			-e "\\#^;?upload_max_filesize#s#^.*#upload_max_filesize = 32M#" {} \; || die 'Could not configure PHP ini files.'

		if [ "${ENABLE_ACCESS_LOG:-1}" = "0" ]; then
			sed -E -i '/^[ \t]*CustomLog[ \t]/s/^/#/' "$APACHE_CONFIG" || die 'Could not disable the Apache access log.'
		fi

		if [ -n "${LISTEN:-}" ]; then
			sed -r -i "\\#^Listen#s#^.*#Listen $LISTEN#" "$APACHE_CONFIG" || die 'Could not configure the Apache listener.'
		fi

		if [ -n "${TRUSTED_PROXY:-}" ]; then
			if [ "$TRUSTED_PROXY" = "0" ]; then
				sed -r -i "/^\\s*RemoteIP.*$/s/^/#/" "$APACHE_CONFIG" || die 'Could not disable trusted-proxy handling.'
			else
				sed -r -i "\\#^\\s*RemoteIPInternalProxy#s#^.*#\tRemoteIPInternalProxy $TRUSTED_PROXY#" "$APACHE_CONFIG" || die 'Could not configure the trusted-proxy range.'
			fi
		fi
		return
	fi

	# A generic nonroot launch cannot modify the image's Apache configuration.
	if [ -n "${CRON_MIN:-}" ]; then
		die 'The built-in cron daemon requires root. Run scheduled refresh as an external job using the application user.'
	fi
	if [ "${ENABLE_ACCESS_LOG:-1}" = "0" ] && grep -Eq '^[[:space:]]*CustomLog[[:space:]]' "$APACHE_CONFIG"; then
		die 'ENABLE_ACCESS_LOG=0 requires root or an image with the FreshRSS Apache access log disabled.'
	fi
	if [ -n "${LISTEN:-}" ] && ! grep -Eq "^[[:space:]]*Listen[[:space:]]+$LISTEN([[:space:]]|$)" "$APACHE_CONFIG"; then
		die "LISTEN='$LISTEN' is not preconfigured in $APACHE_CONFIG; configure it in the image before running as non-root."
	fi
	if [ -n "${TRUSTED_PROXY:-}" ]; then
		if [ "$TRUSTED_PROXY" = "0" ]; then
			if grep -Eq '^[[:space:]]*RemoteIP(Header|InternalProxy)[[:space:]]' "$APACHE_CONFIG"; then
				die 'TRUSTED_PROXY=0 is not preconfigured; disable RemoteIP directives in the image before running as non-root.'
			fi
		elif ! grep -Eq "^[[:space:]]*RemoteIPInternalProxy[[:space:]]+$TRUSTED_PROXY([[:space:]]|$)" "$APACHE_CONFIG"; then
			die "TRUSTED_PROXY='$TRUSTED_PROXY' is not preconfigured in $APACHE_CONFIG."
		fi
	fi

	# Preserve the distro scan directory while applying runtime PHP defaults.
	php_ini_dir=$(mktemp -d "${TMPDIR:-/tmp}/freshrss-php-ini.XXXXXX") || die 'Could not create a temporary PHP configuration directory.'
	chmod 700 "$php_ini_dir" || die 'Could not secure the temporary PHP configuration directory.'
	printf 'date.timezone = "%s"\npost_max_size = 32M\nsession.upload_progress.enabled = Off\nupload_max_filesize = 32M\n' "$TZ" >"$php_ini_dir/zz-freshrss-runtime.ini" || die 'Could not write the temporary PHP configuration.'
	if [ -n "${PHP_INI_SCAN_DIR:-}" ]; then
		PHP_INI_SCAN_DIR="$PHP_INI_SCAN_DIR:$php_ini_dir"
	else
		PHP_INI_SCAN_DIR=":$php_ini_dir"
	fi
	export PHP_INI_SCAN_DIR
}

# --- Configure writable Apache runtime paths for generic nonroot launches ---
prepare_standard_nonroot_apache() {
	# Debian apache2ctl defaults to root-owned /run and /var/lock paths. Redirect
	# runtime-only files without changing the image filesystem.
	tmp_base=${TMPDIR:-/tmp}
	apache_runtime="$tmp_base/freshrss-apache-$(id -u)"
	apache_wrapper_dir="$tmp_base/freshrss-apache-bin-$(id -u)"
	apache_binary=$(command -v apache2 || command -v httpd) || die 'Apache executable not found.'
	apache_command=${apache_binary##*/}
	mkdir -p "$apache_runtime/run" "$apache_runtime/lock" "$apache_runtime/log" "$apache_wrapper_dir" || die 'Could not create writable Apache runtime directories.'
	cat >"$apache_wrapper_dir/$apache_command" <<'EOF' || die 'Could not create the non-root Apache launcher.'
#!/bin/sh
export APACHE_RUN_DIR="$FRESHRSS_APACHE_RUNTIME/run"
export APACHE_PID_FILE="$FRESHRSS_APACHE_RUNTIME/run/apache2.pid"
export APACHE_LOCK_DIR="$FRESHRSS_APACHE_RUNTIME/lock"
export APACHE_LOG_DIR="$FRESHRSS_APACHE_RUNTIME/log"
exec "$FRESHRSS_APACHE_BINARY" "$@"
EOF
	chmod 755 "$apache_wrapper_dir/$apache_command" || die 'Could not enable the non-root Apache launcher.'
	export FRESHRSS_APACHE_RUNTIME="$apache_runtime"
	export FRESHRSS_APACHE_BINARY="$apache_binary"
	export PATH="$apache_wrapper_dir:$PATH"
}

# --- Configure the standard image's root cron and initial permissions ---
prepare_standard_root_paths() {
	if [ -n "${CRON_MIN:-}" ]; then
		awk -v RS='\0' '!/^(FRESHRSS_INSTALL|FRESHRSS_USER|HOME|PATH|PWD|SHLVL|TERM|_)=/ {gsub("\047", "\047\\\047\047"); print "export \047" $0 "\047"}' /proc/self/environ >/var/www/FreshRSS/Docker/env.txt || die 'Could not export the cron environment.'
		sed </etc/crontab.freshrss.default \
			-r "s#^[^ ]+ #$CRON_MIN #" | crontab - || die 'Could not install the FreshRSS cron schedule.'
	fi
	./cli/access-permissions.sh --only-userdirs || die 'Could not prepare FreshRSS data permissions.'
}

# --- Reapply standard root permissions after FreshRSS setup ---
finalize_standard_root_permissions() {
	./cli/access-permissions.sh --only-userdirs || die 'Could not finalize FreshRSS data permissions.'
}
