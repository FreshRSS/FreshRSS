<?php
/** 
 * MINZ - Copyright 2011 Marien Fressinaud
 * Sous licence AGPL3 <http://www.gnu.org/licenses/>
*/

/**
 * Le Dispatcher s'occupe d'initialiser le Controller et d'executer l'action
 * déterminée dans la Request
 * C'est un singleton
 */
class Minz_Dispatcher {
	const CONTROLLERS_PATH_NAME = '/Controllers';

	/* singleton */
	private static $instance = null;
	private static $needsReset;
	private static $registrations = array();

	private $controller;

	/**
	 * Récupère l'instance du Dispatcher
	 */
	public static function getInstance () {
		if (self::$instance === null) {
			self::$instance = new Minz_Dispatcher ();
		}
		return self::$instance;
	}

	/**
	 * Lance le controller indiqué dans Request
	 * Remplit le body de Response à partir de la Vue
	 * @exception Minz_Exception
	 */
	public function run () {
		do {
			self::$needsReset = false;

			try {
				$this->createController (Minz_Request::controllerName ());
				$this->controller->init ();
				$this->controller->firstAction ();
				if (!self::$needsReset) {
					$this->launchAction (
						Minz_Request::actionName ()
						. 'Action'
					);
				}
				$this->controller->lastAction ();

				if (!self::$needsReset) {
					$this->controller->view ()->build ();
				}
			} catch (Minz_Exception $e) {
				throw $e;
			}
		} while (self::$needsReset);
	}

	/**
	 * Informe le contrôleur qu'il doit recommancer car la requête a été modifiée
	 */
	public static function reset() {
		self::$needsReset = true;
	}

	/**
	 * Instancie le Controller
	 * @param $controller_name le nom du controller à instancier
	 * @exception ControllerNotExistException le controller n'existe pas
	 * @exception ControllerNotActionControllerException controller n'est
	 *          > pas une instance de ActionController
	 */
	private function createController ($controller_name) {
		if (self::isRegistered($controller_name)) {
			$controller_name = self::loadController($controller_name);
		} else {
			$controller_name = 'FreshRSS_' . $controller_name . '_Controller';
		}

		if (!class_exists ($controller_name)) {
			throw new Minz_ControllerNotExistException (
				$controller_name,
				Minz_Exception::ERROR
			);
		}
		$this->controller = new $controller_name ();

		if (! ($this->controller instanceof Minz_ActionController)) {
			throw new Minz_ControllerNotActionControllerException (
				$controller_name,
				Minz_Exception::ERROR
			);
		}
	}

	/**
	 * Lance l'action sur le controller du dispatcher
	 * @param $action_name le nom de l'action
	 * @exception ActionException si on ne peut pas exécuter l'action sur
	 *  le controller
	 */
	private function launchAction ($action_name) {
		if (!is_callable (array (
			$this->controller,
			$action_name
		))) {
			throw new Minz_ActionException (
				get_class ($this->controller),
				$action_name,
				Minz_Exception::ERROR
			);
		}
		call_user_func (array (
			$this->controller,
			$action_name
		));
	}

	/**
	 * Register a controller file.
	 *
	 * @param $base_name the base name of the controller (i.e. ./?c=<base_name>)
	 * @param $controller_name the name of the controller (e.g. HelloWorldController).
	 * @param $filename the file which contains the controller.
	 */
	public static function registerController($base_name, $controller_name, $filename) {
		if (file_exists($filename)) {
			self::$registrations[$base_name] = array(
				$controller_name,
				$filename,
			);
		}
	}

	/**
	 * Return if a controller is registered.
	 *
	 * @param $base_name the base name of the controller.
	 * @return true if the controller has been registered, false else.
	 */
	public static function isRegistered($base_name) {
		return isset(self::$registrations[$base_name]);
	}

	/**
	 * Load a controller file (include) and return its name.
	 *
	 * @param $base_name the base name of the controller.
	 */
	private static function loadController($base_name) {
		list($controller_name, $filename) = self::$registrations[$base_name];
		include($filename);
		return $controller_name;
	}
}
