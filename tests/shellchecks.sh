#!/usr/bin/env bash
# Based on https://github.com/koreader/koreader/blob/master/.ci/helper_shellchecks.sh

mapfile -t shellscript_locations < <({ git grep -lE '^#!(/usr)?/bin/(env )?(bash|sh)' && git ls-files ./*.sh; } | sort | uniq)

SHELLSCRIPT_ERROR=0

for shellscript in "${shellscript_locations[@]}"; do
	echo -e "${ANSI_GREEN}Running shellcheck on ${shellscript}"
	shellcheck "${shellscript}" || SHELLSCRIPT_ERROR=1
	echo -e "${ANSI_GREEN}Running shfmt on ${shellscript}"
	if ! shfmt "${shellscript}" >/dev/null 2>&1; then
		echo -e "${ANSI_RED}Warning: ${shellscript} contains the following problem:"
		shfmt "${shellscript}" || SHELLSCRIPT_ERROR=1
		continue
	fi
	if [ "$(cat "${shellscript}")" != "$(shfmt "${shellscript}")" ]; then
		echo -e "${ANSI_RED}Warning: ${shellscript} does not abide by coding style, diff for expected style:"
		shfmt "${shellscript}" | diff "${shellscript}" - || SHELLSCRIPT_ERROR=1
	fi
done

exit "${SHELLSCRIPT_ERROR}"
