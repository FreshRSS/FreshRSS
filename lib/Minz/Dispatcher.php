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
	 * @throws Minz_Exception
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
					$this->controller->declareCspHeader();
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
	 * @param string $base_name le nom du controller à instancier
	 * @throws Minz_ControllerNotExistException le controller n'existe pas
	 * @throws Minz_ControllerNotActionControllerException controller n'est pas une instance de ActionController
	 */
	private function createController ($base_name) {
		if (self::isRegistered($base_name)) {
			self::loadController($base_name);
			$controller_name = 'FreshExtension_' . $base_name . '_Controller';
		} else {
			$controller_name = 'FreshRSS_' . $base_name . '_Controller';
		}

		if (!class_exists ($controller_name)) {
			throw new Minz_ControllerNotExistException (
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
	 * @param string $action_name le nom de l'action
	 * @throws Minz_ActionException si on ne peut pas exécuter l'action sur le controller
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
	 * @param string $base_name the base name of the controller (i.e. ./?c=<base_name>)
	 * @param string $base_path the base path where we should look into to find info.
	 */
	public static function registerController($base_name, $base_path) {
		if (!self::isRegistered($base_name)) {
			self::$registrations[$base_name] = $base_path;
		}
	}

	/**
	 * Return if a controller is registered.
	 *
	 * @param string $base_name the base name of the controller.
	 * @return boolean true if the controller has been registered, false else.
	 */
	public static function isRegistered($base_name) {
		return isset(self::$registrations[$base_name]);
	}

	/**
	 * Load a controller file (include).
	 *
	 * @param string $base_name the base name of the controller.
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
