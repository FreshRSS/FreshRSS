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

// Constantes de chemins
define ('PUBLIC_PATH', realpath (dirname (__FILE__)));
define ('LIB_PATH', realpath (PUBLIC_PATH . '/../lib'));
define ('APP_PATH', realpath (PUBLIC_PATH . '/../app'));
define ('LOG_PATH', realpath (PUBLIC_PATH . '/../log'));
define ('CACHE_PATH', realpath (PUBLIC_PATH . '/../cache'));

if (file_exists (PUBLIC_PATH . '/install.php')) {
	include ('install.php');
} else {
	session_cache_limiter('');
	require (LIB_PATH . '/http-conditional.php');
	$dateLastModification = max(filemtime(PUBLIC_PATH . '/data/touch.txt'),
		filemtime(LOG_PATH . '/application.log'),
		filemtime(PUBLIC_PATH . '/data/Configuration.array.php'),
		filemtime(APP_PATH . '/configuration/application.ini'),
		time() - 14400);
	if (httpConditional($dateLastModification, 0, 0, false, false, true)) {
		exit();	//No need to send anything
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
	} catch (PDOConnectionException $e) {
		Minz_Log::record ($e->getMessage (), Minz_Log::ERROR);
		print '### Application problem ###'."\n".'See logs files';
	}
}
