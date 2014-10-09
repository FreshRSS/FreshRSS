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

require('../../constants.php');
require(LIB_PATH . '/lib_rss.php');	//Includes class autoloader

if (file_exists(DATA_PATH . '/do-install.txt')) {
	require(APP_PATH . '/install.php');
} else {
	session_cache_limiter('');
	Minz_Session::init('FreshRSS');
	Minz_Session::_param('keepAlive', 1);	//For Persona

	if (!file_exists(DATA_PATH . '/no-cache.txt')) {
		require(LIB_PATH . '/http-conditional.php');
		$currentUser = Minz_Session::param('currentUser', '');
		$dateLastModification = $currentUser === '' ? time() : max(
			@filemtime(LOG_PATH . '/' . $currentUser . '.log'),
			@filemtime(DATA_PATH . '/config.php')
		);
		if (httpConditional($dateLastModification, 0, 0, false, PHP_COMPRESSION, true)) {
			exit();	//No need to send anything
		}
	}

	try {
		$front_controller = new FreshRSS();
		$front_controller->init();
		$front_controller->run();
	} catch (Exception $e) {
		echo '### Fatal error! ###<br />', "\n";
		Minz_Log::record($e->getMessage(), Minz_Log::ERROR);
		echo 'See logs files.';
	}
}
