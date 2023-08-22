<?php
/**
 * MINZ - Copyright 2011 Marien Fressinaud
 * Sous licence AGPL3 <http://www.gnu.org/licenses/>
*/

/**
 * Request représente la requête http
 */
class Minz_Request {
	/** @var string */
	private static $controller_name = '';
	/** @var string */
	private static $action_name = '';
	/** @var array<string,mixed> */
	private static $params = array();

	/** @var string */
	private static $default_controller_name = 'index';
	/** @var string */
	private static $default_action_name = 'index';

	/** @var array{'c'?:string,'a'?:string,'params'?:array<string,mixed>} */
	private static $originalRequest = [];

	/**
	 * Getteurs
	 */
	public static function controllerName(): string {
		return self::$controller_name;
	}
	public static function actionName(): string {
		return self::$action_name;
	}
	/** @return array<string,mixed> */
	public static function params(): array {
		return self::$params;
	}
	/**
	 * Read the URL parameter
	 * @param string $key Key name
	 * @param mixed $default default value, if no parameter is given
	 * @param bool $specialchars special characters
	 * @return mixed value of the parameter
	 * @deprecated use typed versions instead
	 */
	public static function param(string $key, $default = false, bool $specialchars = false) {
		if (isset(self::$params[$key])) {
			$p = self::$params[$key];
			if (is_object($p) || $specialchars) {
				return $p;
			} elseif (is_string($p) || is_array($p)) {
				return Minz_Helper::htmlspecialchars_utf8($p);
			} else {
				return $p;
			}
		} else {
			return $default;
		}
	}

	/** @return array<string|int,string|array<string,string>> */
	public static function paramArray(string $key, bool $specialchars = false): array {
		if (empty(self::$params[$key]) || !is_array(self::$params[$key])) {
			return [];
		}

		return $specialchars ? Minz_Helper::htmlspecialchars_utf8(self::$params[$key]) : self::$params[$key];
	}

	public static function paramTernary(string $key): ?bool {
		if (isset(self::$params[$key])) {
			$p = self::$params[$key];
			$tp = is_string($p) ? trim($p) : true;
			if ($tp === '' || $tp === 'null') {
				return null;
			} elseif ($p == false || $tp == '0' || $tp === 'false' || $tp === 'no') {
				return false;
			}
			return true;
		}
		return null;
	}

	public static function paramBoolean(string $key): bool {
		if (null === $value = self::paramTernary($key)) {
			return false;
		}
		return $value;
	}

	public static function paramInt(string $key): int {
		if (!empty(self::$params[$key])) {
			return intval(self::$params[$key]);
		}
		return 0;
	}

	public static function paramString(string $key, bool $specialchars = false): string {
		if (isset(self::$params[$key])) {
			$s = self::$params[$key];
			if (is_string($s)) {
				$s = trim($s);
				return $specialchars ? $s : htmlspecialchars($s, ENT_COMPAT, 'UTF-8');
			}
			if (is_int($s) || is_bool($s)) {
				return (string)$s;
			}
		}
		return '';
	}

	/**
	 * Extract text lines to array.
	 *
	 * It will return an array where each cell contains one line of a text. The new line
	 * character is used to break the text into lines. This method is well suited to use
	 * to split textarea content.
	 * @param array<string> $default
	 * @return array<string>
	 */
	public static function paramTextToArray(string $key, array $default = []): array {
		if (isset(self::$params[$key])) {
			return preg_split('/\R/', self::$params[$key]) ?: [];
		}
		return $default;
	}

	public static function defaultControllerName(): string {
		return self::$default_controller_name;
	}
	public static function defaultActionName(): string {
		return self::$default_action_name;
	}
	/** @return array{'c':string,'a':string,'params':array<string,mixed>} */
	public static function currentRequest(): array {
		return [
			'c' => self::$controller_name,
			'a' => self::$action_name,
			'params' => self::$params,
		];
	}

	/** @return array{'c'?:string,'a'?:string,'params'?:array<string,mixed>} */
	public static function originalRequest() {
		return self::$originalRequest;
	}

	/**
	 * @param array<string,mixed>|null $extraParams
	 * @return array{'c':string,'a':string,'params':array<string,mixed>}
	 */
	public static function modifiedCurrentRequest(?array $extraParams = null): array {
		unset(self::$params['ajax']);
		$currentRequest = self::currentRequest();
		if (null !== $extraParams) {
			$currentRequest['params'] = array_merge($currentRequest['params'], $extraParams);
		}
		return $currentRequest;
	}

	/**
	 * Setteurs
	 */
	public static function _controllerName(string $controller_name): void {
		self::$controller_name = $controller_name;
	}

	public static function _actionName(string $action_name): void {
		self::$action_name = $action_name;
	}

	/** @param array<string,string> $params */
	public static function _params(array $params): void {
		self::$params = $params;
	}

	/** @param array|mixed $value */
	public static function _param(string $key, $value = false): void {
		if ($value === false) {
			unset(self::$params[$key]);
		} else {
			self::$params[$key] = $value;
		}
	}

	/**
	 * Initialise la Request
	 */
	public static function init(): void {
		self::initJSON();
	}

	public static function is(string $controller_name, string $action_name): bool {
		return self::$controller_name === $controller_name &&
			self::$action_name === $action_name;
	}

	/**
	 * Return true if the request is over HTTPS, false otherwise (HTTP)
	 */
	public static function isHttps(): bool {
		$header = $_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '';
		if ('' != $header) {
			return 'https' === strtolower($header);
		}
		return 'on' === ($_SERVER['HTTPS'] ?? '');
	}

	/**
	 * Try to guess the base URL from $_SERVER information
	 *
	 * @return string base url (e.g. http://example.com)
	 */
	public static function guessBaseUrl(): string {
		$protocol = self::extractProtocol();
		$host = self::extractHost();
		$port = self::extractPortForUrl();
		$prefix = self::extractPrefix();
		$path = self::extractPath();

		return filter_var("{$protocol}://{$host}{$port}{$prefix}{$path}", FILTER_SANITIZE_URL) ?: '';
	}

	private static function extractProtocol(): string {
		if (self::isHttps()) {
			return 'https';
		}
		return 'http';
	}

	private static function extractHost(): string {
		if ('' != $host = ($_SERVER['HTTP_X_FORWARDED_HOST'] ?? '')) {
			return parse_url("http://{$host}", PHP_URL_HOST) ?: 'localhost';
		}
		if ('' != $host = ($_SERVER['HTTP_HOST'] ?? '')) {
			// Might contain a port number, and mind IPv6 addresses
			return parse_url("http://{$host}", PHP_URL_HOST) ?: 'localhost';
		}
		if ('' != $host = ($_SERVER['SERVER_NAME'] ?? '')) {
			return $host;
		}
		return 'localhost';
	}

	private static function extractPort(): int {
		if ('' != $port = ($_SERVER['HTTP_X_FORWARDED_PORT'] ?? '')) {
			return intval($port);
		}
		if ('' != $proto = ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '')) {
			return 'https' === strtolower($proto) ? 443 : 80;
		}
		if ('' != $port = ($_SERVER['SERVER_PORT'] ?? '')) {
			return intval($port);
		}
		return self::isHttps() ? 443 : 80;
	}

	private static function extractPortForUrl(): string {
		if (self::isHttps() && 443 !== $port = self::extractPort()) {
			return ":{$port}";
		}
		if (!self::isHttps() && 80 !== $port = self::extractPort()) {
			return ":{$port}";
		}
		return '';
	}

	private static function extractPrefix(): string {
		if ('' != $prefix = ($_SERVER['HTTP_X_FORWARDED_PREFIX'] ?? '')) {
			return rtrim($prefix, '/ ');
		}
		return '';
	}

	private static function extractPath(): string {
		$path = $_SERVER['REQUEST_URI'] ?? '';
		if ($path != '') {
			$path = parse_url($path, PHP_URL_PATH) ?: '';
			return substr($path, -1) === '/' ? rtrim($path, '/') : dirname($path);
		}
		return '';
	}

	/**
	 * Return the base_url from configuration
	 */
	public static function getBaseUrl(): string {
		$conf = Minz_Configuration::get('system');
		$url = trim($conf->base_url, ' /\\"');
		return filter_var($url, FILTER_SANITIZE_URL) ?: '';
	}

	/**
	 * Test if a given server address is publicly accessible.
	 *
	 * Note: for the moment it tests only if address is corresponding to a
	 * localhost address.
	 *
	 * @param string $address the address to test, can be an IP or a URL.
	 * @return bool true if server is accessible, false otherwise.
	 * @todo improve test with a more valid technique (e.g. test with an external server?)
	 */
	public static function serverIsPublic(string $address): bool {
		if (strlen($address) < strlen('http://a.bc')) {
			return false;
		}
		$host = parse_url($address, PHP_URL_HOST);
		if (!is_string($host)) {
			return false;
		}

		$is_public = !in_array($host, [
			'localhost',
			'localhost.localdomain',
			'[::1]',
			'ip6-localhost',
			'localhost6',
			'localhost6.localdomain6',
		], true);

		if ($is_public) {
			$is_public &= !preg_match('/^(10|127|172[.]16|192[.]168)[.]/', $host);
			$is_public &= !preg_match('/^(\[)?(::1$|fc00::|fe80::)/i', $host);
		}

		return (bool)$is_public;
	}

	private static function requestId(): string {
		if (empty($_GET['rid']) || !ctype_xdigit($_GET['rid'])) {
			$_GET['rid'] = uniqid();
		}
		return $_GET['rid'];
	}

	private static function setNotification(string $type, string $content): void {
		Minz_Session::lock();
		$requests = Minz_Session::param('requests', []);
		$requests[self::requestId()] = [
				'time' => time(),
				'notification' => [ 'type' => $type, 'content' => $content ],
			];
		Minz_Session::_param('requests', $requests);
		Minz_Session::unlock();
	}

	public static function setGoodNotification(string $content): void {
		self::setNotification('good', $content);
	}

	public static function setBadNotification(string $content): void {
		self::setNotification('bad', $content);
	}

	/** @return array<string,string>|null */
	public static function getNotification(): ?array {
		$notif = null;
		Minz_Session::lock();
		$requests = Minz_Session::param('requests');
		if (is_array($requests)) {
			//Delete abandoned notifications
			$requests = array_filter($requests, static function (array $r) { return isset($r['time']) && $r['time'] > time() - 3600; });

			$requestId = self::requestId();
			if (!empty($requests[$requestId]['notification'])) {
				$notif = $requests[$requestId]['notification'];
				unset($requests[$requestId]);
			}
			Minz_Session::_param('requests', $requests);
		}
		Minz_Session::unlock();
		return $notif;
	}

	/**
	 * Restart a request
	 * @param array{'c'?:string,'a'?:string,'params'?:array<string,mixed>} $url an array presentation of the URL to route to
	 * @param bool $redirect If true, uses an HTTP redirection, and if false (default), performs an internal dispatcher redirection.
	 */
	public static function forward($url = [], bool $redirect = false): void {
		if (empty(Minz_Request::originalRequest())) {
			self::$originalRequest = $url;
		}

		$url = Minz_Url::checkControllerUrl($url);
		$url['params']['rid'] = self::requestId();

		if ($redirect) {
			header('Location: ' . Minz_Url::display($url, 'php', 'root'));
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
	 * @param string $msg notification content
	 * @param array{'c'?:string,'a'?:string,'params'?:array<string,mixed>} $url url array to where we should be forwarded
	 */
	public static function good(string $msg, array $url = []): void {
		Minz_Request::setGoodNotification($msg);
		Minz_Request::forward($url, true);
	}

	/**
	 * Wrappers bad notifications + redirection
	 * @param string $msg notification content
	 * @param array{'c'?:string,'a'?:string,'params'?:array<string,mixed>} $url url array to where we should be forwarded
	 */
	public static function bad(string $msg, array $url = []): void {
		Minz_Request::setBadNotification($msg);
		Minz_Request::forward($url, true);
	}

	/**
	 * Allows receiving POST data as application/json
	 */
	private static function initJSON(): void {
		if ('application/json' !== self::extractContentType()) {
			return;
		}
		$ORIGINAL_INPUT = file_get_contents('php://input', false, null, 0, 1048576);
		if ($ORIGINAL_INPUT == false) {
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

	private static function extractContentType(): string {
		return strtolower(trim($_SERVER['CONTENT_TYPE'] ?? ''));
	}

	public static function isPost(): bool {
		return 'POST' === ($_SERVER['REQUEST_METHOD'] ?? '');
	}

	/**
	 * @return array<string>
	 */
	public static function getPreferredLanguages(): array {
		if (preg_match_all('/(^|,)\s*(?P<lang>[^;,]+)/', $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '', $matches) > 0) {
			return $matches['lang'];
		}
		return array('en');
	}
}
