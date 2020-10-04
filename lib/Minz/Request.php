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
	public static function paramBoolean($key) {
		if (null === $value = self::paramTernary($key)) {
			return false;
		}
		return $value;
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
	 *
	 * @return boolean
	 */
	public static function isHttps() {
		$header = static::getHeader('HTTP_X_FORWARDED_PROTO');
		if (null !== $header) {
			return 'https' === strtolower($header);
		}
		return 'on' === static::getHeader('HTTPS');
	}

	/**
	 * Try to guess the base URL from $_SERVER information
	 *
	 * @return the base url (e.g. http://example.com/)
	 */
	public static function guessBaseUrl() {
		$protocol = static::extractProtocol();
		$host = static::extractHost();
		$port = static::extractPortForUrl();
		$prefix = static::extractPrefix();
		$path = static::extractPath();

		return filter_var("{$protocol}://{$host}{$port}{$prefix}{$path}", FILTER_SANITIZE_URL);
	}

	/**
	 * @return string
	 */
	private static function extractProtocol() {
		if (static::isHttps()) {
			return 'https';
		}
		return 'http';
	}

	/**
	 * @return string
	 */
	private static function extractHost() {
		if (null !== $host = static::getHeader('HTTP_X_FORWARDED_HOST')) {
			return parse_url("http://{$host}", PHP_URL_HOST);
		}
		if (null !== $host = static::getHeader('HTTP_HOST')) {
			// Might contain a port number, and mind IPv6 addresses
			return parse_url("http://{$host}", PHP_URL_HOST);
		}
		if (null !== $host = static::getHeader('SERVER_NAME')) {
			return $host;
		}
		return 'localhost';
	}

	/**
	 * @return integer
	 */
	private static function extractPort() {
		if (null !== $port = static::getHeader('HTTP_X_FORWARDED_PORT')) {
			return intval($port);
		}
		if (null !== $proto = static::getHeader('HTTP_X_FORWARDED_PROTO')) {
			return 'https' === strtolower($proto) ? 443 : 80;
		}
		if (null !== $port = static::getHeader('SERVER_PORT')) {
			return intval($port);
		}
		return static::isHttps() ? 443 : 80;
	}

	/**
	 * @return string
	 */
	private static function extractPortForUrl() {
		if (static::isHttps() && 443 !== $port = static::extractPort()) {
			return ":{$port}";
		}
		if (!static::isHttps() && 80 !== $port = static::extractPort()) {
			return ":{$port}";
		}
		return '';
	}

	/**
	 * @return string
	 */
	private static function extractPrefix() {
		if (null !== $prefix = static::getHeader('HTTP_X_FORWARDED_PREFIX')) {
			return rtrim($prefix, '/ ');
		}
		return '';
	}

	/**
	 * @return string
	 */
	private static function extractPath() {
		if (null !== $path = static::getHeader('REQUEST_URI')) {
			return '/' === substr($path, -1) ? substr($path, 0, -1) : dirname($path);
		}
		return '';
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
	 * Test if a given server address is publicly accessible.
	 *
	 * Note: for the moment it tests only if address is corresponding to a
	 * localhost address.
	 *
	 * @param $address the address to test, can be an IP or a URL.
	 * @return true if server is accessible, false otherwise.
	 * @todo improve test with a more valid technique (e.g. test with an external server?)
	 */
	public static function serverIsPublic($address) {
		if (strlen($address) < strlen('http://a.bc')) {
			return false;
		}
		$host = parse_url($address, PHP_URL_HOST);
		if (!$host) {
			return false;
		}

		$is_public = !in_array($host, array(
			'localhost',
			'localhost.localdomain',
			'[::1]',
			'ip6-localhost',
			'localhost6',
			'localhost6.localdomain6',
		));

		if ($is_public) {
			$is_public &= !preg_match('/^(10|127|172[.]16|192[.]168)[.]/', $host);
			$is_public &= !preg_match('/^(\[)?(::1$|fc00::|fe80::)/i', $host);
		}

		return (bool)$is_public;
	}

	private static function requestId() {
		if (empty($_GET['rid']) || !ctype_xdigit($_GET['rid'])) {
			$_GET['rid'] = uniqid();
		}
		return $_GET['rid'];
	}

	private static function setNotification($type, $content) {
		Minz_Session::_param('notification', [ 'type' => $type, 'content' => $content ]);
	}

	public static function setGoodNotification($content) {
		self::setNotification('good', $content);
	}

	public static function setBadNotification($content) {
		self::setNotification('bad', $content);
	}

	public static function getNotification() {
		//Restore forwarded notifications
		//TODO: Will need to ensure non-concurrency when landing https://github.com/FreshRSS/FreshRSS/pull/3096
		$requests = Minz_Session::param('requests');
		if ($requests) {
			//Delete abandonned notifications
			foreach ($requests as $fid => $request) {
				if (empty($request['time']) || $request['time'] < time() - 3600) {
					unset($requests[$fid]);
				}
			}

			$requestId = self::requestId();
			if (!empty($requests[$requestId]['notification'])) {
				$notif = $requests[$requestId]['notification'];
				unset($requests[$requestId]);
				Minz_Session::_param('requests', $requests);
				return $notif;
			}
		}

		$notif = Minz_Session::param('notification');
		Minz_Session::_param('notification');
		return $notif;
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
		$requestId = self::requestId();
		$url['params']['rid'] = $requestId;

		//Forward request data such as notifications
		$notif = Minz_Request::getNotification();
		if ($notif) {
			//TODO: Will need to ensure non-concurrency when landing https://github.com/FreshRSS/FreshRSS/pull/3096
			$requests = Minz_Session::param('requests', []);
			$requests[$requestId] = [
					'time' => time(),
					'notification' => $notif,
				];
			Minz_Session::_param('requests', $requests);
		}

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
		Minz_Request::setGoodNotification($msg);
		Minz_Request::forward($url, true);
	}

	public static function bad($msg, $url = array()) {
		Minz_Request::setBadNotification($msg);
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
		if (false === $param) {
			return $_GET;
		}
		if (isset($_GET[$param])) {
			return $_GET[$param];
		}
		return $default;
	}

	/**
	 * Allows receiving POST data as application/json
	 */
	private static function initJSON() {
		if ('application/json' !== static::extractContentType()) {
			return;
		}
		if ('' === $ORIGINAL_INPUT = file_get_contents('php://input', false, null, 0, 1048576)) {
			return;
		}
		if (null === $json = json_decode($ORIGINAL_INPUT, true)) {
			return;
		}

		foreach ($json as $k => $v) {
			if (!isset($_POST[$k])) {
				$_POST[$k] = $v;
			}
		}
	}

	/**
	 * @return string
	 */
	private static function extractContentType() {
		return strtolower(trim(static::getHeader('CONTENT_TYPE')));
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
		if (false === $param) {
			return $_POST;
		}
		if (isset($_POST[$param])) {
			return $_POST[$param];
		}
		return $default;
	}

	/**
	 * @return mixed
	 */
	public static function getHeader($header, $default = null) {
		return isset($_SERVER[$header]) ? $_SERVER[$header] : $default;
	}

	/**
	 * @return boolean
	 */
	public static function isPost() {
		return 'POST' === static::getHeader('REQUEST_METHOD');
	}

	/**
	 * @return array
	 */
	public static function getPreferredLanguages() {
		if (preg_match_all('/(^|,)\s*(?P<lang>[^;,]+)/', static::getHeader('HTTP_ACCEPT_LANGUAGE'), $matches)) {
			return $matches['lang'];
		}
		return array('en');
	}
}
