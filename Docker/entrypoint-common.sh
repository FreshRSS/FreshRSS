#!/bin/sh

# Shared FreshRSS setup for all image profiles. This file is sourced by
# entrypoint.sh so exported OIDC values and shell state carry into the command.

configure_oidc() {
	if [ -n "${OIDC_ENABLED:-}" ]; then
		case "$OIDC_ENABLED" in
			*[!0-9]*) die "OIDC_ENABLED must be empty, 0, or a non-negative integer; got '$OIDC_ENABLED'." ;;
		esac
	fi

	if [ -z "${OIDC_ENABLED:-}" ] || [ "$OIDC_ENABLED" -eq 0 ]; then
		return
	fi

	# Apache reads these values when it starts, regardless of process identity.
	export OIDC_SESSION_INACTIVITY_TIMEOUT="${OIDC_SESSION_INACTIVITY_TIMEOUT:-300}"
	export OIDC_SESSION_MAX_DURATION="${OIDC_SESSION_MAX_DURATION:-27200}"
	export OIDC_SESSION_TYPE="${OIDC_SESSION_TYPE:-server-cache}"
	export OIDC_DEFAULT_URL="${OIDC_DEFAULT_URL:-/i/}"

	if [ -n "${OIDC_SCOPES:-}" ]; then
		# Compatibility with ':' as a separator instead of spaces.
		OIDC_SCOPES=$(echo "$OIDC_SCOPES" | tr ':' ' ')
		export OIDC_SCOPES
	fi

	if [ "$is_root" -eq 1 ]; then
		if command -v a2enmod >/dev/null 2>&1; then
			a2enmod -q auth_openidc || die 'Failed to enable the Apache auth_openidc module.'
		elif [ -f /etc/apache2/conf.d/mod-auth-openidc.conf.bak ]; then
			mv /etc/apache2/conf.d/mod-auth-openidc.conf.bak /etc/apache2/conf.d/mod-auth-openidc.conf || die 'Failed to enable the Apache auth_openidc module.'
		else
			die 'Failed to enable the Apache auth_openidc module.'
		fi
	elif command -v a2query >/dev/null 2>&1; then
		a2query -m auth_openidc >/dev/null 2>&1 || die 'OIDC is enabled but auth_openidc is not pre-enabled in the image.'
	elif [ ! -f /etc/apache2/conf.d/mod-auth-openidc.conf ]; then
		die 'OIDC is enabled but auth_openidc is not pre-enabled in the image.'
	fi
}

prepare_runtime_paths() {
	if [ "$is_root" -eq 1 ]; then
		[ "$runtime_profile" = standard ] || die 'The rootless profile cannot prepare root-owned runtime paths.'
		prepare_standard_root_paths
		return
	fi

	data_path=${DATA_PATH:-$(php -r 'require "constants.php"; echo DATA_PATH;')}
	[ -n "$data_path" ] || die 'Could not determine FreshRSS DATA_PATH.'
	mkdir -p "$data_path" || die "Cannot create DATA_PATH '$data_path' as non-root."
	[ -w "$data_path" ] || die "DATA_PATH '$data_path' is not writable by uid $(id -u)."

	# The rootless profile uses the fixed www-data identity. The generic standard
	# profile instead must match Debian's configured account when launched as a
	# non-root user.
	if [ "$runtime_profile" = standard ] && [ -f /etc/apache2/envvars ]; then
		apache_user=$(sed -n 's/^export APACHE_RUN_USER=//p' /etc/apache2/envvars | head -n 1 | tr -d "'\"")
		if [ -n "$apache_user" ] && id "$apache_user" >/dev/null 2>&1 && [ "$(id -u "$apache_user")" != "$(id -u)" ]; then
			die "Apache is configured to run as '$apache_user', but the container runs as uid $(id -u). Use that account or configure Apache for the runtime uid."
		fi
	fi

	if [ "$runtime_profile" = standard ]; then
		prepare_standard_nonroot_apache
	fi
}

initialize_freshrss() {
	php -f ./cli/prepare.php >/dev/null || die 'FreshRSS storage preparation failed.'

	if [ -n "${FRESHRSS_INSTALL:-}" ]; then
		# shellcheck disable=SC2046
		php -f ./cli/do-install.php -- \
			$(eval "echo \"$FRESHRSS_INSTALL\"" | sed -r 's/[\r\n]+/\n/g' | paste -s -)
		EXITCODE=$?

		if [ "$EXITCODE" -eq 3 ]; then
			echo 'ℹ️ FreshRSS already installed; no change performed.'
		elif [ "$EXITCODE" -eq 0 ]; then
			echo '✅ FreshRSS successfully installed.'
		else
			die 'FreshRSS error during the installation.'
		fi
	fi

	if [ -n "${FRESHRSS_USER:-}" ]; then
		# shellcheck disable=SC2046
		php -f ./cli/create-user.php -- \
			$(eval "echo \"$FRESHRSS_USER\"" | sed -r 's/[\r\n]+/\n/g' | paste -s -)
		EXITCODE=$?

		if [ "$EXITCODE" -eq 3 ]; then
			echo 'ℹ️ FreshRSS user already exists; no change performed.'
		elif [ "$EXITCODE" -eq 0 ]; then
			echo '✅ FreshRSS user successfully created.'
			# A user without feeds may make this best-effort refresh exit nonzero.
			./cli/list-users.php | xargs -n1 ./cli/actualize-user.php --user
		else
			die 'FreshRSS error during the creation of a user.'
		fi
	fi
}

finalize_freshrss() {
	if [ "$is_root" -eq 1 ]; then
		[ "$runtime_profile" = standard ] || die 'The rootless profile cannot finalize root-owned permissions.'
		finalize_standard_root_permissions
	else
		data_path=${DATA_PATH:-$(php -r 'require "constants.php"; echo DATA_PATH;')}
		[ -w "$data_path" ] || die "FreshRSS DATA_PATH '$data_path' became unwritable during initialization."
	fi

	if [ "$runtime_profile" = rootless ]; then
		unset FRESHRSS_INSTALL FRESHRSS_USER
	fi
}
