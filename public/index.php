<?php
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

if (file_exists ('install.php')) {
	require('install.php');
} else {
	require('../constants.php');

	session_cache_limiter('');
	if (!file_exists(DATA_PATH . '/no-cache.txt')) {
		require (LIB_PATH . '/http-conditional.php');
		$dateLastModification = max(
			@filemtime(DATA_PATH . '/touch.txt') - 1,
			@filemtime(LOG_PATH . '/application.log') - 1,
			@filemtime(DATA_PATH . '/application.ini') - 1
		);
		if (httpConditional($dateLastModification, 0, 0, false, false, true)) {
			exit();	//No need to send anything
		}
	}

	set_include_path (get_include_path ()
		         . PATH_SEPARATOR
		         . LIB_PATH
		         . PATH_SEPARATOR
		         . LIB_PATH . '/minz'
		         . PATH_SEPARATOR
		         . APP_PATH);

	require (APP_PATH . '/App_FrontController.php');

	try {
		$front_controller = new App_FrontController ();
		$front_controller->init ();
		$front_controller->run ();
	} catch (Exception $e) {
		echo '### Fatal error! ###<br />', "\n";
		Minz_Log::record ($e->getMessage (), Minz_Log::ERROR);
		echo 'See logs files.';
	}
}
