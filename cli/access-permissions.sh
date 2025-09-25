#!/bin/sh
# Apply access permissions

if [ ! -f './constants.php' ] || [ ! -d './cli/' ]; then
	echo >&2 '⛔ It does not look like a FreshRSS directory; exiting!'
	exit 2
fi

if [ "$(id -u)" -ne 0 ]; then
	echo >&2 '⛔ Applying access permissions require running as root or sudo!'
	exit 3
fi

# Always fix permissions on the data and extensions directories
# If specified, only fix the data and extensions directories
data_path="${DATA_PATH:-./data}"
if [ "${1:-}" = "--only-userdirs" ]; then
	to_update="./extensions"
else
	to_update="."
fi

mkdir -p "${data_path}/users/_/"

# Based on group access
chown -R :www-data "$data_path" "$to_update"

# Read files, and directory traversal
chmod -R g+rX "$data_path" "$to_update"

# Write access to data
chmod -R g+w "$data_path"
