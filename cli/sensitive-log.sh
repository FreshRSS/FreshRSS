#!/bin/sh
# Strips sensitive passwords from (Apache) logs

# For e.g. GNU systems such as Debian
# N.B.: `sed -u` is not available in BusyBox and without it there are buffering delays (even with stdbuf)
sed -Eu 's/([?&]Passwd)=[^& \t\n]+/\1=█/ig' 2>/dev/null ||

# For systems with gawk (not available by default in Docker of Debian or Alpine) or with BuzyBox such as Alpine
$(which gawk || which awk) -v IGNORECASE=1 '{ print gensub(/([?&]Passwd)=[^& \t\n]+/, "\\1=█", "g") }'
