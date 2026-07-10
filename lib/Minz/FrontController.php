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
# along with this program.  If not, see <https://www.gnu.org/licenses/>.
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
	 * Constructor
	 * Initializes the dispatcher and updates the request
	 */
	public function __construct() {
		try {
			$this->setReporting();

			Request::init();

			// Build the current request's URL and forward to it directly.
			// If needed, a redirect is issued instead to correct the public relative path.
			// Only GET parameters are part of the URL, and hence of the original request or of a redirect.
			Request::forward(Url::build(), redirect: Request::pathInfo() !== '');

			// POST parameters (which may contain passwords) are added afterwards so that they never end up in a URL.
			$post = array_filter($_POST, 'is_string', ARRAY_FILTER_USE_KEY);
			unset($post['rid']);	// Request ID is only taken from GET
			Request::_params(array_merge(Request::params(), $post));
		} catch (Exception $e) {
			Log::error($e->getMessage());
			self::killApp($e->getMessage());
		}

		$this->dispatcher = Dispatcher::getInstance();
	}

	/**
	 * Starts the application (runs the dispatcher and sends the response)
	 */
	public function run(): void {
		try {
			$this->dispatcher->run();
		} catch (BadRequestException $e) {
			Error::error(400, ['error' => [$e->getMessage()]], redirect: true);
		} catch (Exception $e) {
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
