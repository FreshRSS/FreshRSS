<?php
declare(strict_types=1);

namespace FreshRss\Minz;

use FreshRss\Models\View;

/**
 * MINZ - Copyright 2011 Marien Fressinaud
 * Sous licence AGPL3 <http://www.gnu.org/licenses/>
*/

/**
 * The Dispatcher is in charge of initialising the Controller and execute the action as specified in the Request object.
 * It is a singleton.
 */
final class Dispatcher {

	/**
	 * Singleton
	 */
	private static ?Dispatcher $instance = null;
	private static bool $needsReset;
	/** @var array<string,string> */
	private static array $registrations = [];
	private ActionController $controller;

	/**
	 * Retrieves the Dispatcher instance
	 */
	public static function getInstance(): Dispatcher {
		if (self::$instance === null) {
			self::$instance = new Dispatcher();
		}
		return self::$instance;
	}

	/**
	 * Launches the controller specified in Request
	 * Fills the Response body from the View
	 * @throws Exception
	 */
	public function run(): void {
		do {
			self::$needsReset = false;

			try {
				$this->createController(Request::controllerName());
				$this->controller->init();
				$this->controller->firstAction();
				if (!self::$needsReset) {
					$this->launchAction(
						Request::actionName()
						. 'Action'
					);
				}
				$this->controller->lastAction();

				if (!self::$needsReset) {
					$model = $this->controller->view();
					if ($model instanceof View && $model->displaySlider) {
						View::prependScript(Url::display('/scripts/extra.js?' . @filemtime(PUBLIC_PATH . '/scripts/extra.js')));
					}
					$this->controller->declareCspHeader();
					$this->controller->view()->build();
				}
			} catch (Exception $e) {
				throw $e;
			}
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
	 * @throws ControllerNotExistException the controller does not exist
	 * @throws ControllerNotActionControllerException controller is not an instance of ActionController
	 */
	private function createController(string $base_name): void {
		if (self::isRegistered($base_name)) {
			self::loadController($base_name);
			// Extensions declare their controller in the global namespace, by convention.
			$controller_name = 'FreshExtension_' . $base_name . '_Controller';
		} else {
			$controller_name = 'FreshRss\\Controllers\\' . ucfirst($base_name) . 'Controller';
		}

		if (!class_exists($controller_name)) {
			throw new ControllerNotExistException(
				Exception::ERROR
			);
		}
		$controller = new $controller_name();

		if (!($controller instanceof ActionController)) {
			throw new ControllerNotActionControllerException(
				$controller_name,
				Exception::ERROR
			);
		}

		$this->controller = $controller;
	}

	/**
	 * Launch the action on the dispatcher’s controller
	 * @param string $action_name the name of the action
	 * @throws ActionException if the action cannot be executed on the controller
	 */
	private function launchAction(string $action_name): void {
		$call = [$this->controller, $action_name];
		if (!is_callable($call)) {
			throw new ActionException(
				get_class($this->controller),
				$action_name,
				Exception::ERROR
			);
		}
		if (ExtensionManager::callHook(HookType::ActionExecute, $this->controller) !== false) {
			call_user_func($call);
		}
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
