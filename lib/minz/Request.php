<?php
/** 
 * MINZ - Copyright 2011 Marien Fressinaud
 * Sous licence AGPL3 <http://www.gnu.org/licenses/>
*/

/**
 * Request représente la requête http
 */
class Request {
	private static $controller_name = '';
	private static $action_name = '';
	private static $params = array ();
	
	private static $default_controller_name = 'index';
	private static $default_action_name = 'index';
	
	public static $reseted = true;
	
	/**
	 * Getteurs
	 */
	public static function controllerName () {
		return self::$controller_name;
	}
	public static function actionName () {
		return self::$action_name;
	}
	public static function params () {
		return self::$params;
	}
	public static function param ($key, $default = false, $specialchars = false) {
		if (isset (self::$params[$key])) {
			$p = self::$params[$key];
			if(is_object($p) || $specialchars) {
				return $p;
			} elseif(is_array($p)) {
				return array_map('htmlspecialchars', $p);	//TODO: Should use explicit UTF-8
			} else {
				return htmlspecialchars($p, ENT_NOQUOTES, 'UTF-8');
			}
		} else {
			return $default;
		}
	}
	public static function defaultControllerName () {
		return self::$default_controller_name;
	}
	public static function defaultActionName () {
		return self::$default_action_name;
	}
	
	/**
	 * Setteurs
	 */
	public static function _controllerName ($controller_name) {
		self::$controller_name = $controller_name;
	}
	public static function _actionName ($action_name) {
		self::$action_name = $action_name;
	}
	public static function _params ($params) {
		if (!is_array($params)) {
			$params = array ($params);
		}
		
		self::$params = $params;
	}
	public static function _param ($key, $value = false) {
		if ($value === false) {
			unset (self::$params[$key]);
		} else {
			self::$params[$key] = $value;
		}
	}
	
	/**
	 * Initialise la Request
	 */
	public static function init () {
		self::magicQuotesOff ();
	}
	
	/**
	 * Retourn le nom de domaine du site
	 */
	public static function getDomainName () {
		return $_SERVER['HTTP_HOST'];
	}
	
	/**
	 * Détermine la base de l'url
	 * @return la base de l'url
	 */
	public static function getBaseUrl () {
		return Configuration::baseUrl ();
	}
	
	/**
	 * Récupère l'URI de la requête
	 * @return l'URI
	 */
	public static function getURI () {
		if (isset ($_SERVER['REQUEST_URI'])) {
			$base_url = self::getBaseUrl ();
			$uri = $_SERVER['REQUEST_URI'];
			
			$len_base_url = strlen ($base_url);
			$real_uri = substr ($uri, $len_base_url); 
		} else {
			$real_uri = '';
		}
		
		return $real_uri;
	}
	
	/**
	 * Relance une requête
	 * @param $url l'url vers laquelle est relancée la requête
	 * @param $redirect si vrai, force la redirection http
	 *                > sinon, le dispatcher recharge en interne
	 */
	public static function forward ($url = array (), $redirect = false) {
		$url = Url::checkUrl ($url);
		
		if ($redirect) {
			header ('Location: ' . Url::display ($url, 'php'));
			exit ();
		} else {
			self::$reseted = true;
		
			self::_controllerName ($url['c']);
			self::_actionName ($url['a']);
			self::_params (array_merge (
				self::$params,
				$url['params']
			));
		}
	}
	
	/**
	 * Permet de récupérer une variable de type $_GET
	 * @param $param nom de la variable
	 * @param $default valeur par défaut à attribuer à la variable
	 * @return $_GET[$param]
	 *         $_GET si $param = false
	 *         $default si $_GET[$param] n'existe pas
	 */
	public static function fetchGET ($param = false, $default = false) {
		if ($param === false) {
			return $_GET;
		} elseif (isset ($_GET[$param])) {
			return $_GET[$param];
		} else {
			return $default;
		}
	}
	
	/**
	 * Permet de récupérer une variable de type $_POST
	 * @param $param nom de la variable
	 * @param $default valeur par défaut à attribuer à la variable
	 * @return $_POST[$param]
	 *         $_POST si $param = false
	 *         $default si $_POST[$param] n'existe pas
	 */
	public static function fetchPOST ($param = false, $default = false) {
		if ($param === false) {
			return $_POST;
		} elseif (isset ($_POST[$param])) {
			return $_POST[$param];
		} else {
			return $default;
		}
	}
	
	/**
	 * Méthode désactivant les magic_quotes pour les variables
	 *   $_GET
	 *   $_POST
	 *   $_COOKIE
	 */
	private static function magicQuotesOff () {
		if (get_magic_quotes_gpc ()) {
			$_GET = Helper::stripslashes_r ($_GET);
			$_POST = Helper::stripslashes_r ($_POST);
			$_COOKIE = Helper::stripslashes_r ($_COOKIE);
		}
	}
	
	public static function isPost () {
		return !empty ($_POST) || !empty ($_FILES);
	}
}


