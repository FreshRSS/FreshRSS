#!/bin/sh
# Strips sensitive passwords from (Apache) logs

# For e.g. GNU systems such as Debian
# N.B.: `sed -u` is not available in BusyBox and without it there are buffering delays (even with stdbuf)
sed -Eu 's/([?&])(Passwd|token)=[^& \t]+/\1\2=redacted/ig' 2>/dev/null ||

	# For systems with gawk (not available by default in Docker of Debian or Alpine) or with BuzyBox such as Alpine
	$(which gawk || which awk) -v IGNORECASE=1 '{ print gensub(/([?&])(Passwd|token)=[^& \t]+/, "\\1\\2=redacted", "g") }'
