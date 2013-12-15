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

	private $router;
	private $controller;

	/**
	 * Récupère l'instance du Dispatcher
	 */
	public static function getInstance ($router) {
		if (is_null (self::$instance)) {
			self::$instance = new Minz_Dispatcher ($router);
		}
		return self::$instance;
	}

	/**
	 * Constructeur
	 */
	private function __construct ($router) {
		$this->router = $router;
	}

	/**
	 * Lance le controller indiqué dans Request
	 * Remplit le body de Response à partir de la Vue
	 * @exception Minz_Exception
	 */
	public function run () {
		$cache = new Minz_Cache();
		// Le ob_start est dupliqué : sans ça il y a un bug sous Firefox
		// ici on l'appelle avec 'ob_gzhandler', après sans.
		// Vraisemblablement la compression fonctionne mais c'est sale
		// J'ignore les effets de bord :(
		ob_start ('ob_gzhandler');

		if (Minz_Cache::isEnabled () && !$cache->expired ()) {
			ob_start ();
			$cache->render ();
			$text = ob_get_clean();
		} else {
			while (Minz_Request::$reseted) {
				Minz_Request::$reseted = false;

				try {
					$this->createController ('FreshRSS_' . Minz_Request::controllerName () . '_Controller');
					$this->controller->init ();
					$this->controller->firstAction ();
					$this->launchAction (
						Minz_Request::actionName ()
						. 'Action'
					);
					$this->controller->lastAction ();

					if (!Minz_Request::$reseted) {
						ob_start ();
						$this->controller->view ()->build ();
						$text = ob_get_clean();
					}
				} catch (Minz_Exception $e) {
					throw $e;
				}
			}

			if (Minz_Cache::isEnabled ()) {
				$cache->cache ($text);
			}
		}

		Minz_Response::setBody ($text);
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
		$this->controller = new $controller_name ($this->router);

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
		if (!Minz_Request::$reseted) {
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
}
