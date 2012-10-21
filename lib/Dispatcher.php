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
class Dispatcher {
	const CONTROLLERS_PATH_NAME = '/controllers';
	
	/* singleton */
	private static $instance = null;
	
	private $router;
	private $controller;
	
	/**
	 * Récupère l'instance du Dispatcher
	 */
	public static function getInstance ($router) {
		if (is_null (self::$instance)) {
			self::$instance = new Dispatcher ($router);
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
	 * @exception MinzException
	 */
	public function run () {
		$cache = new Cache();
		
		if (Cache::isEnabled () && !$cache->expired ()) {
			ob_start ();
			$cache->render ();
			$text = ob_get_clean();
		} else {
			while (Request::$reseted) {
				Request::$reseted = false;
				
				try {
					$this->createController (
						Request::controllerName ()
						. 'Controller'
					);
				
					$this->controller->init ();
					$this->controller->firstAction ();
					$this->launchAction (
						Request::actionName ()
						. 'Action'
					);
					$this->controller->lastAction ();
					
					if (!Request::$reseted) {
						ob_start ();
						$this->controller->view ()->build ();
						$text = ob_get_clean();
					}
				} catch (MinzException $e) {
					throw $e;
				}
			}
		}
		
		Response::setBody ($text);
	}
	
	
	/**
	 * Instancie le Controller
	 * @param $controller_name le nom du controller à instancier
	 * @exception FileNotExistException le fichier correspondant au
	 *          > controller n'existe pas
	 * @exception ControllerNotExistException le controller n'existe pas
	 * @exception ControllerNotActionControllerException controller n'est
	 *          > pas une instance de ActionController
	 */
	private function createController ($controller_name) {
		$filename = APP_PATH . self::CONTROLLERS_PATH_NAME . '/'
		          . $controller_name . '.php';
		
		if (!file_exists ($filename)) {
			throw new FileNotExistException (
				$filename,
				MinzException::ERROR
			);
		}
		require_once ($filename);
		
		if (!class_exists ($controller_name)) {
			throw new ControllerNotExistException (
				$controller_name,
				MinzException::ERROR
			);
		}
		$this->controller = new $controller_name ($this->router);
		
		if (! ($this->controller instanceof ActionController)) {
			throw new ControllerNotActionControllerException (
				$controller_name,
				MinzException::ERROR
			);
		}
	}
	
	/**
	 * Lance l'action sur le controller du dispatcher
	 * @param $action_name le nom de l'action
	 * @exception ActionException si on ne peut pas exécuter l'action sur
	 *          > le controller
	 */
	private function launchAction ($action_name) {
		if (!Request::$reseted) {
			if (!is_callable (array (
				$this->controller,
				$action_name
			))) {
				throw new ActionException (
					get_class ($this->controller),
					$action_name,
					MinzException::ERROR
				);
			}
			call_user_func (array (
				$this->controller,
				$action_name
			));
		}
	}
}
