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

# Based on group access
chown -R :www-data .

# Read files, and directory traversal
chmod -R g+rX .

# Write access
mkdir -p ./data/users/_/
chmod -R g+w ./data/
