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
				$this->createController ('FreshRSS_' . Minz_Request::controllerName () . '_Controller');
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
		$filename = APP_PATH . self::CONTROLLERS_PATH_NAME . '/'
		          . $controller_name . '.php';

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
}
