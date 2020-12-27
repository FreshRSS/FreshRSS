<?php

namespace Minz\Controller;

use Minz\Configuration;
use Minz\Dispatcher;
use Minz\Exception\ActionException;
use Minz\Exception\ControllerNotActionControllerException;
use Minz\Exception\ControllerNotExistException;
use Minz\Exception\FileNotExistException;
use Minz\Exception\PermissionDeniedException;
use Minz\Request;
use Minz\View;

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
class FrontController {
	protected $dispatcher;

	/**
	 * Constructeur
	 * Initialise le dispatcher, met à jour la Request
	 */
	public function __construct () {
		try {
			Configuration::register('system',
			                             DATA_PATH . '/config.php',
			                             FRESHRSS_PATH . '/config.default.php');
			$this->setReporting();

			Request::init();

			$url = $this->buildUrl();
			$url['params'] = array_merge (
				$url['params'],
				Request::fetchPOST ()
			);
			Request::forward ($url);
		} catch (Exception $e) {
			Log::error($e->getMessage());
			$this->killApp ($e->getMessage ());
		}

		$this->dispatcher = Dispatcher::getInstance();
	}

	/**
	 * Retourne un tableau représentant l'url passée par la barre d'adresses
	 * @return tableau représentant l'url
	 */
	private function buildUrl() {
		$url = array ();

		$url['c'] = Request::fetchGET (
			'c',
			Request::defaultControllerName ()
		);
		$url['a'] = Request::fetchGET (
			'a',
			Request::defaultActionName ()
		);
		$url['params'] = Request::fetchGET ();

		// post-traitement
		unset ($url['params']['c']);
		unset ($url['params']['a']);

		return $url;
	}

	/**
	 * Démarre l'application (lance le dispatcher et renvoie la réponse)
	 */
	public function run () {
		try {
			$this->dispatcher->run();
		} catch (Exception $e) {
			try {
				Log::error($e->getMessage());
			} catch (PermissionDeniedException $e) {
				$this->killApp ($e->getMessage ());
			}

			if ($e instanceof FileNotExistException ||
					$e instanceof ControllerNotExistException ||
					$e instanceof ControllerNotActionControllerException ||
					$e instanceof ActionException) {
				Error::error (
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
