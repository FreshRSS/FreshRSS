<?php
// > Error: FreshRSS requires PHP, which does not seem to be installed or configured correctly! <!--

# ***** BEGIN LICENSE BLOCK *****
# MINZ - A free PHP framework
# Copyright (C) 2011 Marien Fressinaud
#
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU Affero General Public License as
# published by the Free Software Foundation, either version 3 of the
# License, or (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU Affero General Public License for more details.
#
# You should have received a copy of the GNU Affero General Public License
# along with this program.  If not, see <http://www.gnu.org/licenses/>.
#
# ***** END LICENSE BLOCK *****

require(__DIR__ . '/../../constants.php');
require(LIB_PATH . '/lib_rss.php');	//Includes class autoloader

if (file_exists(DATA_PATH . '/do-install.txt')) {
	require(APP_PATH . '/install.php');
} else {
	session_cache_limiter('');
	Minz_Session::init('FreshRSS');
	Minz_Session::_param('keepAlive', 1);	//To prevent the PHP session from expiring

	if (!file_exists(DATA_PATH . '/no-cache.txt')) {
		require(LIB_PATH . '/http-conditional.php');
		$currentUser = Minz_Session::param('currentUser', '');
		$dateLastModification = $currentUser === '' ? time() : max(
			@filemtime(join_path(USERS_PATH, $currentUser, 'log.txt')),
			@filemtime(join_path(DATA_PATH, 'config.php'))
		);
		if (httpConditional($dateLastModification, 0, 0, false, PHP_COMPRESSION, true)) {
			exit();	//No need to send anything
		}
	}

	$migrations_path = APP_PATH . '/migrations';
	$migrations_version_path = DATA_PATH . '/migrations_version.txt';

	// The next line is temporary: the migrate method expects the migrations_version.txt
	// file to exist. This is because the install script creates this file, so
	// if it is missing, it means the application is not installed. But we
	// should also take care of applications installed before the new
	// migrations system (<1.16). Indeed, they are installed but the migrations
	// version file doesn't exist. So for now, we continue to check if the
	// application is installed with the do-install.txt file: if yes, we create
	// the version file. Starting from version 1.17, all the installed systems
	// will have the file and so we will be able to remove this temporary line
	// and stop using the do-install.txt file to check if FRSS is already
	// installed.
	touch($migrations_version_path);

	$error = false;
	try {
		// Apply the migrations if any
		$result = Minz_Migrator::execute($migrations_path, $migrations_version_path);
		if ($result === true) {
			$front_controller = new FreshRSS();
			$front_controller->init();
			$front_controller->run();
		} else {
			$error = $result;
		}
	} catch (Exception $e) {
		$error = $e->getMessage();
	}

	if ($error) {
		// TODO this should be definitely improved to display a nicer error
		// page to the users (especially non administrators).
		echo '### Fatal error! ###<br />', "\n";
		Minz_Log::error($error);
		echo 'See logs files.';
		syslog(LOG_INFO, 'FreshRSS Fatal error! ' . $error);
	}
}
