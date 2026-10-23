#!/bin/sh

die() {
	echo "❌ $*" >&2
	exit 1
}

# shellcheck source=./Docker/entrypoint-common.sh
. ./Docker/entrypoint-common.sh || die 'Could not load the shared runtime helper.'
# shellcheck source=./Docker/entrypoint-standard.sh
. ./Docker/entrypoint-standard.sh || die 'Could not load the standard runtime helper.'
# shellcheck source=./Docker/entrypoint-rootless.sh
. ./Docker/entrypoint-rootless.sh || die 'Could not load the rootless runtime helper.'

# --- Identify the image profile and runtime identity ---
# Image profile describes the image's startup contract; it is independent of
# whether the process happens to run as root.
runtime_profile=${FRESHRSS_ENTRYPOINT_PROFILE:-standard}
case "$runtime_profile" in
	standard|rootless) ;;
	*) die "Unsupported FRESHRSS_ENTRYPOINT_PROFILE '$runtime_profile'. Use 'standard' or 'rootless'." ;;
esac

is_root=0
[ "$(id -u)" -eq 0 ] && is_root=1
if [ "$runtime_profile" = rootless ]; then
	[ "$is_root" -eq 0 ] || die 'The rootless image profile must not run as uid 0.'
fi

# --- Validate the runtime timezone ---
if [ -z "${TZ:-}" ]; then
	TZ=UTC
fi
case "$TZ" in
	''|*[!A-Za-z0-9_+./-]*) die "Invalid timezone name '$TZ'. Use an IANA timezone such as UTC or America/Los_Angeles." ;;
esac
[ -f "/usr/share/zoneinfo/$TZ" ] || die "Timezone data for '$TZ' is unavailable; install tzdata or choose an available timezone."
export TZ

# --- Prepare rootless runtime files before resolving its generated Apache config ---
if [ "$runtime_profile" = rootless ]; then
	prepare_rootless_runtime
fi

# --- Locate the Apache configuration after profile setup ---
if [ -z "${APACHE_CONFIG:-}" ]; then
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
fi

[ -f "${APACHE_CONFIG:-}" ] || die 'Apache configuration file not found!'

# --- Prepare the selected image profile's runtime configuration ---
if [ "$runtime_profile" = standard ]; then
	prepare_standard_configuration
fi

# --- Configure the shared OIDC capability ---
configure_oidc

# --- Prepare scheduled refresh and writable runtime paths ---
prepare_runtime_paths

# --- Initialise FreshRSS and apply optional operator setup ---
initialize_freshrss

# --- Finalise permissions and launch the requested command ---
finalize_freshrss
if [ "$runtime_profile" = rootless ] && [ "${1:-}" = apache2 ]; then
	shift
	set -- /bin/bash ./Docker/rootless-run.sh "$@"
fi
exec "$@"
