#!/bin/bash

MINZ_REPO_URL="https://github.com/marienfressinaud/MINZ.git"
MINZ_CLONE_PATH="./minz_tmp"
LIB_MINZ_PATH="./minz_tmp/lib/*"
LIB_PATH="./lib/minz"
LOG_PATH="./log"
CACHE_PATH="./cache"

git_check() {
	printf "Vérification de la présence de git... "

	EXE_PATH=$(which "git" 2>/dev/null)
	if [ $? -ne 0 ]; then
		printf "git n'est pas présent sur votre système. Veuillez l'installer avant de continuer\n";
		exit 1
	else
		printf "git a été trouvé\n"
	fi
}

dir_check() {
	test -d $LOG_PATH
	if [ $? -ne 0 ]; then
		mkdir $LOG_PATH
	fi

	test -d $CACHE_PATH
	if [ $? -ne 0 ]; then
		mkdir $CACHE_PATH
	fi
}

clone_minz() {
	printf "Récupération de Minz...\n"

	git clone $MINZ_REPO_URL $MINZ_CLONE_PATH
	test -d $LIB_PATH
	if [ $? -ne 0 ]; then
		mkdir -p $LIB_PATH
	fi
	mv $LIB_MINZ_PATH $LIB_PATH
	rm -rf $MINZ_CLONE_PATH

	printf "Récupération de Minz terminée...\n"
}

git_check
dir_check
clone_minz
