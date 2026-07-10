<?php
declare(strict_types=1);

namespace FreshRss\Minz;

# ***** BEGIN LICENSE BLOCK *****
# MINZ - a free PHP Framework like Zend Framework
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

/**
 * The FrontController class is the framework Dispatcher.
 * It runs the application.
 * It is generally invoqued by an index.php file at the root.
 */
class FrontController {

	protected Dispatcher $dispatcher;

	/**
	 * Constructeur
	 * Initialise le dispatcher, met à jour la Request
	 */
	public function __construct() {
		try {
			$this->setReporting();

			Request::init();

			// Build the current request's URL and forward to it directly.
			// If needed, a redirect is issued instead to correct the public relative path.
			$url = Url::build();
			$url['params'] = array_merge(
				empty($url['params']) || !is_array($url['params']) ? [] : $url['params'],
				array_filter($_POST, 'is_string', ARRAY_FILTER_USE_KEY)
			);
			$pathInfo = $_SERVER['PATH_INFO'] ?? $_SERVER['ORIG_PATH_INFO'] ?? '';
			Request::forward($url, redirect: $pathInfo !== '');
		} catch (\Exception $e) {
			Log::error($e->getMessage());
			self::killApp($e->getMessage());
		}

		$this->dispatcher = Dispatcher::getInstance();
	}

	/**
	 * Démarre l'application (lance le dispatcher et renvoie la réponse)
	 */
	public function run(): void {
		try {
			$this->dispatcher->run();
		} catch (\Exception $e) {
			try {
				Log::error($e->getMessage());
			} catch (PermissionDeniedException $e) {
				self::killApp($e->getMessage());
			}

			if ($e instanceof FileNotExistException ||
					$e instanceof ControllerNotExistException ||
					$e instanceof ControllerNotActionControllerException ||
					$e instanceof ActionException) {
				Error::error(404, ['error' => [$e->getMessage()]], true);
			} else {
				self::killApp($e->getMessage());
			}
		}
	}

	/**
	 * Kills the programme
	 */
	public static function killApp(string $txt = ''): never {
		header('HTTP/1.1 500 Internal Server Error', true, 500);
		if (function_exists('errorMessageInfo')) {
			//If the application has defined a custom error message function
			die(errorMessageInfo('Application problem', $txt));
		}
		die('### Application problem ###<br />' . "\n" . $txt);
	}

	private function setReporting(): void {
		$envType = getenv('FRESHRSS_ENV');
		if ($envType == '') {
			$conf = Configuration::get('system');
			$envType = $conf->environment;
		}
		switch ($envType) {
			case 'development':
				error_reporting(E_ALL);
				ini_set('display_errors', 'On');
				ini_set('log_errors', 'On');
				break;
			case 'silent':
				error_reporting(0);
				break;
			case 'production':
			default:
				error_reporting(E_ALL);
				ini_set('display_errors', 'Off');
				ini_set('log_errors', 'On');
				break;
		}
	}
}
