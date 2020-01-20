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
 * La classe FrontController est le Dispatcher du framework, elle lance l'application
 * Elle est appelée en général dans le fichier index.php à la racine du serveur
 */
class Minz_FrontController {
	protected $dispatcher;

	/**
	 * Constructeur
	 * Initialise le dispatcher, met à jour la Request
	 */
	public function __construct () {
		try {
			Minz_Configuration::register('system',
			                             DATA_PATH . '/config.php',
			                             FRESHRSS_PATH . '/config.default.php');
			$this->setReporting();

			Minz_Request::init();

			$url = $this->buildUrl();
			$url['params'] = array_merge (
				$url['params'],
				Minz_Request::fetchPOST ()
			);
			Minz_Request::forward ($url);
		} catch (Minz_Exception $e) {
			Minz_Log::error($e->getMessage());
			$this->killApp ($e->getMessage ());
		}

		$this->dispatcher = Minz_Dispatcher::getInstance();
	}

	/**
	 * Retourne un tableau représentant l'url passée par la barre d'adresses
	 * @return tableau représentant l'url
	 */
	private function buildUrl() {
		$url = array ();

		$url['c'] = Minz_Request::fetchGET (
			'c',
			Minz_Request::defaultControllerName ()
		);
		$url['a'] = Minz_Request::fetchGET (
			'a',
			Minz_Request::defaultActionName ()
		);
		if (Minz_Request::fetchGET('cont') !== false) {
			$url['cont'] = Minz_Request::fetchGET ('cont');
		}
		$url['params'] = Minz_Request::fetchGET ();

		// post-traitement
		unset ($url['params']['c']);
		unset ($url['params']['a']);
		unset ($url['params']['cont']);

		return $url;
	}

	/**
	 * Démarre l'application (lance le dispatcher et renvoie la réponse)
	 */
	public function run () {
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
					$e instanceof Minz_ActionException ||
					$e instanceof Minz_ContentException) {
				Minz_Error::error (
					404,
					array ('error' => array ($e->getMessage ())),
					true
				);
			} else {
				$this->killApp ();
			}
		}
	}

	/**
	* Permet d'arrêter le programme en urgence
	*/
	private function killApp ($txt = '') {
		if ($txt == '') {
			$txt = 'See logs files';
		}
		exit ('### Application problem ###<br />'."\n".$txt);
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
