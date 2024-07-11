<?php
declare(strict_types=1);

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

$migrations_path = APP_PATH . '/migrations';
$applied_migrations_path = DATA_PATH . '/applied_migrations.txt';

if (!file_exists($applied_migrations_path)) {
	require(APP_PATH . '/install.php');
} else {
	session_cache_limiter('');
	Minz_Session::init('FreshRSS');
	Minz_Session::_param('keepAlive', 1);	//To prevent the PHP session from expiring

	if (!file_exists(DATA_PATH . '/no-cache.txt')) {
		require(LIB_PATH . '/http-conditional.php');
		$currentUser = Minz_User::name();
		$dateLastModification = $currentUser === null ? time() : max(
			FreshRSS_UserDAO::ctime($currentUser),
			FreshRSS_UserDAO::mtime($currentUser),
			@filemtime(DATA_PATH . '/config.php') ?: 0
		);
		if (httpConditional($dateLastModification ?: time(), 0, 0, false, PHP_COMPRESSION, true)) {
			exit();	//No need to send anything
		}
	}

	$error = false;
	try {
		// Apply the migrations if any
		$result = Minz_Migrator::execute($migrations_path, $applied_migrations_path);
		if ($result === true) {
			FreshRSS_Context::initSystem();
			$front_controller = new FreshRSS();
			$front_controller->init();
			$front_controller->run();
		} else {
			$error = $result;
		}
	} catch (Exception $e) {
		$error = $e->getMessage();
	}

	if ($error !== false) {
		syslog(LOG_INFO, 'FreshRSS Fatal error! ' . $error);
		FreshRSS::killApp($error);
	}
}
