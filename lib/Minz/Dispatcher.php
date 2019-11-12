<?php

namespace Minz;

/**
 * MINZ - Copyright 2011 Marien Fressinaud
 * Sous licence AGPL3 <http://www.gnu.org/licenses/>
*/

/**
 * Le Dispatcher s'occupe d'initialiser le Controller et d'executer l'action
 * déterminée dans la Request
 * C'est un singleton
 */
class Dispatcher {

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
			self::$instance = new Dispatcher ();
		}
		return self::$instance;
	}

	/**
	 * Lance le controller indiqué dans Request
	 * Remplit le body de Response à partir de la Vue
	 * @exception Exception
	 */
	public function run () {
		do {
			self::$needsReset = false;

			try {
				$this->createController (Request::controllerName ());
				$this->controller->init ();
				$this->controller->firstAction ();
				if (!self::$needsReset) {
					$this->launchAction (
						Request::actionName ()
						. 'Action'
					);
				}
				$this->controller->lastAction ();

				if (!self::$needsReset) {
					$this->controller->view ()->build ();
				}
			} catch (Exception $e) {
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
	 * @param $base_name le nom du controller à instancier
	 * @exception ControllerNotExistException le controller n'existe pas
	 * @exception ControllerNotActionControllerException controller n'est
	 *          > pas une instance de ActionController
	 */
	private function createController ($base_name) {
		if (self::isRegistered($base_name)) {
			self::loadController($base_name);
			$controller_name = 'FreshExtension_' . $base_name . '_Controller';
		} else {
			$controller_name = '' . $base_name . '_Controller';
		}

		if (!class_exists ($controller_name)) {
			throw new ControllerNotExistException (
				$controller_name,
				Exception::ERROR
			);
		}
		$this->controller = new $controller_name ();

		if (! ($this->controller instanceof ActionController)) {
			throw new ControllerNotActionControllerException (
				$controller_name,
				Exception::ERROR
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
			throw new ActionException (
				get_class ($this->controller),
				$action_name,
				Exception::ERROR
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
	 * @param $base_path the base path where we should look into to find info.
	 */
	public static function registerController($base_name, $base_path) {
		if (!self::isRegistered($base_name)) {
			self::$registrations[$base_name] = $base_path;
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
	 * Load a controller file (include).
	 *
	 * @param $base_name the base name of the controller.
	 */
	private static function loadController($base_name) {
		$base_path = self::$registrations[$base_name];
		$controller_filename = $base_path . '/Controllers/' . $base_name . 'Controller.php';
		include_once $controller_filename;
	}

	private static function setViewPath($controller, $base_name) {
		$base_path = self::$registrations[$base_name];
		$controller->view()->setBasePathname($base_path);
	}
}
