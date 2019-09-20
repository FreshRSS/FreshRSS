<?php
/**
 * MINZ - Copyright 2011 Marien Fressinaud
 * Sous licence AGPL3 <http://www.gnu.org/licenses/>
*/

/**
 * Request représente la requête http
 */
class Minz_Request {
	private static $controller_name = '';
	private static $action_name = '';
	private static $params = array();

	private static $default_controller_name = 'index';
	private static $default_action_name = 'index';

	/**
	 * Getteurs
	 */
	public static function controllerName() {
		return self::$controller_name;
	}
	public static function actionName() {
		return self::$action_name;
	}
	public static function params() {
		return self::$params;
	}
	public static function param($key, $default = false, $specialchars = false) {
		if (isset(self::$params[$key])) {
			$p = self::$params[$key];
			if (is_object($p) || $specialchars) {
				return $p;
			} else {
				return Minz_Helper::htmlspecialchars_utf8($p);
			}
		} else {
			return $default;
		}
	}
	public static function paramTernary($key) {
		if (isset(self::$params[$key])) {
			$p = self::$params[$key];
			$tp = trim($p);
			if ($p === null || $tp === '' || $tp === 'null') {
				return null;
			} elseif ($p == false || $tp == '0' || $tp === 'false' || $tp === 'no') {
				return false;
			}
			return true;
		}
		return null;
	}
	public static function defaultControllerName() {
		return self::$default_controller_name;
	}
	public static function defaultActionName() {
		return self::$default_action_name;
	}
	public static function currentRequest() {
		return array(
			'c' => self::$controller_name,
			'a' => self::$action_name,
			'params' => self::$params,
		);
	}

	/**
	 * Setteurs
	 */
	public static function _controllerName($controller_name) {
		self::$controller_name = $controller_name;
	}
	public static function _actionName($action_name) {
		self::$action_name = $action_name;
	}
	public static function _params($params) {
		if (!is_array($params)) {
			$params = array($params);
		}

		self::$params = $params;
	}
	public static function _param($key, $value = false) {
		if ($value === false) {
			unset(self::$params[$key]);
		} else {
			self::$params[$key] = $value;
		}
	}

	/**
	 * Initialise la Request
	 */
	public static function init() {
		self::magicQuotesOff();
		self::initJSON();
	}

	public static function is($controller_name, $action_name) {
		return (
			self::$controller_name === $controller_name &&
			self::$action_name === $action_name
		);
	}

	/**
	 * Return true if the request is over HTTPS, false otherwise (HTTP)
	 */
	public static function isHttps() {
		if (isset($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
			return strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) === 'https';
		} else {
			return isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on';
		}
	}

	/**
	 * Try to guess the base URL from $_SERVER information
	 *
	 * @return the base url (e.g. http://example.com/)
	 */
	public static function guessBaseUrl() {
		$url = 'http';

		$https = self::isHttps();

		if (!empty($_SERVER['HTTP_X_FORWARDED_HOST'])) {
			$host = parse_url('http://' . $_SERVER['HTTP_X_FORWARDED_HOST'], PHP_URL_HOST);
		} elseif (!empty($_SERVER['HTTP_HOST'])) {
			//Might contain a port number, and mind IPv6 addresses
			$host = parse_url('http://' . $_SERVER['HTTP_HOST'], PHP_URL_HOST);
		} elseif (!empty($_SERVER['SERVER_NAME'])) {
			$host = $_SERVER['SERVER_NAME'];
		} else {
			$host = 'localhost';
		}

		if (!empty($_SERVER['HTTP_X_FORWARDED_PORT'])) {
			$port = intval($_SERVER['HTTP_X_FORWARDED_PORT']);
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
			$port = strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) === 'https' ? 443 : 80;
		} elseif (!empty($_SERVER['SERVER_PORT'])) {
			$port = intval($_SERVER['SERVER_PORT']);
		} else {
			$port = $https ? 443 : 80;
		}

		if ($https) {
			$url .= 's://' . $host . ($port == 443 ? '' : ':' . $port);
		} else {
			$url .= '://' . $host . ($port == 80 ? '' : ':' . $port);
		}
		if (!empty($_SERVER['HTTP_X_FORWARDED_PREFIX'])) {
			$url .= rtrim($_SERVER['HTTP_X_FORWARDED_PREFIX'], '/ ');
		}
		if (isset($_SERVER['REQUEST_URI'])) {
			$path = $_SERVER['REQUEST_URI'];
			$url .= substr($path, -1) === '/' ? substr($path, 0, -1) : dirname($path);
		}

		return filter_var($url, FILTER_SANITIZE_URL);
	}

	/**
	 * Return the base_url from configuration and add a suffix if given.
	 *
	 * @return the base_url with a suffix.
	 */
	public static function getBaseUrl() {
		$conf = Minz_Configuration::get('system');
		$url = rtrim($conf->base_url, '/\\');
		return filter_var($url, FILTER_SANITIZE_URL);
	}

	/**
	 * Relance une requête
	 * @param $url l'url vers laquelle est relancée la requête
	 * @param $redirect si vrai, force la redirection http
	 *                > sinon, le dispatcher recharge en interne
	 */
	public static function forward($url = array(), $redirect = false) {
		if (!is_array($url)) {
			header('Location: ' . $url);
			exit();
		}

		$url = Minz_Url::checkUrl($url);

		if ($redirect) {
			header('Location: ' . Minz_Url::display($url, 'php'));
			exit();
		} else {
			self::_controllerName($url['c']);
			self::_actionName($url['a']);
			self::_params(array_merge(
				self::$params,
				$url['params']
			));
			Minz_Dispatcher::reset();
		}
	}


	/**
	 * Wrappers good notifications + redirection
	 * @param $msg notification content
	 * @param $url url array to where we should be forwarded
	 */
	public static function good($msg, $url = array()) {
		Minz_Session::_param('notification', array(
			'type' => 'good',
			'content' => $msg
		));

		Minz_Request::forward($url, true);
	}

	public static function bad($msg, $url = array()) {
		Minz_Session::_param('notification', array(
			'type' => 'bad',
			'content' => $msg
		));

		Minz_Request::forward($url, true);
	}


	/**
	 * Permet de récupérer une variable de type $_GET
	 * @param $param nom de la variable
	 * @param $default valeur par défaut à attribuer à la variable
	 * @return $_GET[$param]
	 *         $_GET si $param = false
	 *         $default si $_GET[$param] n'existe pas
	 */
	public static function fetchGET($param = false, $default = false) {
		if ($param === false) {
			return $_GET;
		} elseif (isset($_GET[$param])) {
			return $_GET[$param];
		} else {
			return $default;
		}
	}

	/**
	 * Allows receiving POST data as application/json
	 */
	private static function initJSON() {
		$contentType = isset($_SERVER['CONTENT_TYPE']) ? $_SERVER['CONTENT_TYPE'] : '';
		if ($contentType == '') {	//PHP < 5.3.16
			$contentType = isset($_SERVER['HTTP_CONTENT_TYPE']) ? $_SERVER['HTTP_CONTENT_TYPE'] : '';
		}
		$contentType = strtolower(trim($contentType));
		if ($contentType === 'application/json') {
			$ORIGINAL_INPUT = file_get_contents('php://input', false, null, 0, 1048576);
			if ($ORIGINAL_INPUT != '') {
				$json = json_decode($ORIGINAL_INPUT, true);
				if ($json != null) {
					foreach ($json as $k => $v) {
						if (!isset($_POST[$k])) {
							$_POST[$k] = $v;
						}
					}
				}
			}
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
	public static function fetchPOST($param = false, $default = false) {
		if ($param === false) {
			return $_POST;
		} elseif (isset($_POST[$param])) {
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
	private static function magicQuotesOff() {
		if (get_magic_quotes_gpc()) {
			$_GET = Minz_Helper::stripslashes_r($_GET);
			$_POST = Minz_Helper::stripslashes_r($_POST);
			$_COOKIE = Minz_Helper::stripslashes_r($_COOKIE);
		}
	}

	public static function isPost() {
		return isset($_SERVER['REQUEST_METHOD']) &&
			$_SERVER['REQUEST_METHOD'] === 'POST';
	}
}
