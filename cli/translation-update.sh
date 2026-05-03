#!/bin/bash
# This script performs the following:
# - Generate configuration file for po4a (can be configured in CONFIGFILE)
# - Generate POT file from pages/<DIRECTORY>/*.md
# - Update PO files in i18n directory with POT file
# - Generate localized pages.XX/<DIRECTORY>/*.md (where XX is the language code)
# - Remove unneeded new lines from generated pages

# Name of the po4a configuration file
CONFIGFILE='po4a.conf'

# List of supported languages
LANGS=(fr)

# Check if po4a is installed
if [ -z "$(command -v po4a)" ]; then
	echo 'It seems that po4a is not installed on your system.'
	echo 'Please install po4a to use this script.'
	exit 1
fi

# Generate po4a.conf file with list of TLDR pages
echo 'Generating configuration file for po4a…'
{
	echo '# WARNING: this file is generated with translation-update.sh'
	echo '# DO NOT modify this file manually!'
	echo "[po4a_langs] ${LANGS[*]}"
	# shellcheck disable=SC2016
	echo '[po4a_paths] i18n/templates/freshrss.pot $lang:i18n/freshrss.$lang.po'
} >$CONFIGFILE

# Skip the admins/ section (no FR translation maintained) and the three EN
# root files whose FR equivalents are intentionally hand-maintained with a
# different structure than EN: index.md, contributing.md, internationalization.md.
for FILE in $(cd en && tree -f -i | grep ".md" | grep -v "admins" | grep -v -E "^\./(index|contributing|internationalization)\.md$"); do
	echo "[type: text] en/$FILE \$lang:\$lang/$FILE opt:\"-o markdown\" opt:\"-M utf-8\"" >>$CONFIGFILE
done

# Generate POT file, PO files, and pages.XX pages
echo 'Generating POT file and translated pages…'
po4a -k 0 --msgid-bugs-address 'https://github.com/FreshRSS/FreshRSS/issues' $CONFIGFILE
