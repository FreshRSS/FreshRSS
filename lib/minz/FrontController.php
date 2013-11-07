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
 * La classe FrontController est le noyau du framework, elle lance l'application
 * Elle est appelée en général dans le fichier index.php à la racine du serveur
 */
class FrontController {
	protected $dispatcher;
	protected $router;
	
	/**
	 * Constructeur
	 * Initialise le router et le dispatcher
	 */
	public function __construct () {
		$this->loadLib ();

		if (LOG_PATH === false) {
			$this->killApp ('Path doesn\'t exist : LOG_PATH');
		}
		
		try {
			Configuration::init ();

			Request::init ();
			
			$this->router = new Router ();
			$this->router->init ();
		} catch (RouteNotFoundException $e) {
			Minz_Log::record ($e->getMessage (), Minz_Log::ERROR);
			Error::error (
				404,
				array ('error' => array ($e->getMessage ()))
			);
		} catch (MinzException $e) {
			Minz_Log::record ($e->getMessage (), Minz_Log::ERROR);
			$this->killApp ();
		}
		
		$this->dispatcher = Dispatcher::getInstance ($this->router);
	}
	
	/**
	 * Inclue les fichiers de la librairie
	 */
	private function loadLib () {
		require ('ActionController.php');
		require ('Minz_Cache.php');
		require ('Configuration.php');
		require ('Dispatcher.php');
		require ('Error.php');
		require ('Helper.php');
		require ('Minz_Log.php');
		require ('Model.php');
		require ('Paginator.php');
		require ('Request.php');
		require ('Response.php');
		require ('Router.php');
		require ('Session.php');
		require ('Translate.php');
		require ('Url.php');
		require ('View.php');
		
		require ('dao/Model_pdo.php');
		require ('dao/Model_txt.php');
		require ('dao/Model_array.php');
		
		require ('exceptions/MinzException.php');
	}
	
	/**
	 * Démarre l'application (lance le dispatcher et renvoie la réponse
	 */
	public function run () {
		try {
			$this->dispatcher->run ();
			Response::send ();
		} catch (MinzException $e) {
			Minz_Log::record ($e->getMessage (), Minz_Log::ERROR);

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
		exit ('### Application problem ###'."\n".$txt);
	}
}
