<?php
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
 * The Minz_FrontController class is the framework Dispatcher.
 * It runs the application.
 * It is generally invoqued by an index.php file at the root.
 */
class Minz_FrontController {
	protected $dispatcher;

	/**
	 * Constructeur
	 * Initialise le dispatcher, met à jour la Request
	 */
	public function __construct () {
		try {
			$this->setReporting();

			Minz_Request::init();

			$url = $this->buildUrl();
			$url['params'] = array_merge (
				$url['params'],
				$_POST
			);
			Minz_Request::forward ($url);
		} catch (Minz_Exception $e) {
			Minz_Log::error($e->getMessage());
			$this->killApp ($e->getMessage());
		}

		$this->dispatcher = Minz_Dispatcher::getInstance();
	}

	/**
	 * Returns an array representing the URL as passed in the address bar
	 * @return array URL representation
	 */
	private function buildUrl() {
		$url = array();

		$url['c'] = $_GET['c'] ?? Minz_Request::defaultControllerName();
		$url['a'] = $_GET['a'] ?? Minz_Request::defaultActionName();
		$url['params'] = $_GET;

		// post-traitement
		unset($url['params']['c']);
		unset($url['params']['a']);

		return $url;
	}

	/**
	 * Démarre l'application (lance le dispatcher et renvoie la réponse)
	 */
	public function run() {
		try {
			$this->dispatcher->run();
		} catch (Minz_Exception $e) {
			try {
				Minz_Log::error($e->getMessage());
			} catch (Minz_PermissionDeniedException $e) {
				$this->killApp ($e->getMessage ());
			}

			if ($e instanceof Minz_FileNotExistException ||
					$e instanceof Minz_ControllerNotExistException ||
					$e instanceof Minz_ControllerNotActionControllerException ||
					$e instanceof Minz_ActionException) {
				Minz_Error::error (
					404,
					array('error' => array ($e->getMessage ())),
					true
				);
			} else {
				$this->killApp($e->getMessage());
			}
		}
	}

	/**
	* Permet d'arrêter le programme en urgence
	*/
	private function killApp ($txt = '') {
		if (function_exists('errorMessageInfo')) {
			//If the application has defined a custom error message function
			exit(errorMessageInfo('Application problem', $txt));
		}
		exit('### Application problem ###<br />' . "\n" . $txt);
	}

	private function setReporting() {
		$envType = getenv('FRESHRSS_ENV');
		if ($envType == '') {
			$conf = Minz_Configuration::get('system');
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
