<?php
declare(strict_types=1);

/**
 * MINZ - Copyright 2011 Marien Fressinaud
 * Sous licence AGPL3 <http://www.gnu.org/licenses/>
*/

/**
 * The Dispatcher is in charge of initialising the Controller and exectue the action as specified in the Request object.
 * It is a singleton.
 */
final class Minz_Dispatcher {

	/**
	 * Singleton
	 */
	private static ?Minz_Dispatcher $instance = null;
	private static bool $needsReset;
	/** @var array<string,string> */
	private static array $registrations = [];
	private Minz_ActionController $controller;

	/**
	 * Retrieves the Dispatcher instance
	 */
	public static function getInstance(): Minz_Dispatcher {
		if (self::$instance === null) {
			self::$instance = new Minz_Dispatcher();
		}
		return self::$instance;
	}

	/**
	 * Launches the controller specified in Request
	 * Fills the Response body from the View
	 * @throws Minz_Exception
	 */
	public function run(): void {
		do {
			self::$needsReset = false;

			try {
				$this->createController(Minz_Request::controllerName());
				$this->controller->init();
				$this->controller->firstAction();
				// @phpstan-ignore booleanNot.alwaysTrue
				if (!self::$needsReset) {
					$this->launchAction(
						Minz_Request::actionName()
						. 'Action'
					);
				}
				$this->controller->lastAction();

				// @phpstan-ignore booleanNot.alwaysTrue
				if (!self::$needsReset) {
					$this->controller->declareCspHeader();
					$this->controller->view()->build();
				}
			} catch (Minz_Exception $e) {
				throw $e;
			}
			// @phpstan-ignore doWhile.alwaysFalse
		} while (self::$needsReset);
	}

	/**
	 * Informs the controller that it must restart because the request has been modified
	 */
	public static function reset(): void {
		self::$needsReset = true;
	}

	/**
	 * Instantiates the Controller
	 * @param string $base_name the name of the controller to instantiate
	 * @throws Minz_ControllerNotExistException the controller does not exist
	 * @throws Minz_ControllerNotActionControllerException controller is not an instance of ActionController
	 */
	private function createController(string $base_name): void {
		if (self::isRegistered($base_name)) {
			self::loadController($base_name);
			$controller_name = 'FreshExtension_' . $base_name . '_Controller';
		} else {
			$controller_name = 'FreshRSS_' . $base_name . '_Controller';
		}

		if (!class_exists($controller_name)) {
			throw new Minz_ControllerNotExistException(
				Minz_Exception::ERROR
			);
		}
		$controller = new $controller_name();

		if (!($controller instanceof Minz_ActionController)) {
			throw new Minz_ControllerNotActionControllerException(
				$controller_name,
				Minz_Exception::ERROR
			);
		}

		$this->controller = $controller;
	}

	/**
	 * Launch the action on the dispatcher’s controller
	 * @param string $action_name the name of the action
	 * @throws Minz_ActionException if the action cannot be executed on the controller
	 */
	private function launchAction(string $action_name): void {
		$call = [$this->controller, $action_name];
		if (!is_callable($call)) {
			throw new Minz_ActionException(
				get_class($this->controller),
				$action_name,
				Minz_Exception::ERROR
			);
		}
		call_user_func($call);
	}

	/**
	 * Register a controller file.
	 *
	 * @param string $base_name the base name of the controller (i.e. ./?c=<base_name>)
	 * @param string $base_path the base path where we should look into to find info.
	 */
	public static function registerController(string $base_name, string $base_path): void {
		if (!self::isRegistered($base_name)) {
			self::$registrations[$base_name] = $base_path;
		}
	}

	/**
	 * Return if a controller is registered.
	 *
	 * @param string $base_name the base name of the controller.
	 * @return bool true if the controller has been registered, false else.
	 */
	public static function isRegistered(string $base_name): bool {
		return isset(self::$registrations[$base_name]);
	}

	/**
	 * Load a controller file (include).
	 *
	 * @param string $base_name the base name of the controller.
	 */
	private static function loadController(string $base_name): void {
		$base_path = self::$registrations[$base_name];
		$controller_filename = $base_path . '/Controllers/' . $base_name . 'Controller.php';
		include_once $controller_filename;
	}
}
