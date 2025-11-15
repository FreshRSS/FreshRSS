<?php
declare(strict_types=1);

/**
 * The Minz_Url class handles URLs across the MINZ framework
 */
class Minz_Url {
	/**
	 * Display a formatted URL
	 * @param string|array{c?:string,a?:string,params?:array<string,mixed>} $url The URL to format, defined as an array:
	 *                    $url['c'] = controller
	 *                    $url['a'] = action
	 *                    $url['params'] = array of additional parameters
	 *             or as a string
	 * @param string $encoding how to encode & (& ou &amp; pour html)
	 * @param array{c?:string,a?:string,params?:array<string,mixed>} $amend Parameters to add or replace in the URL in its array form
	 * @return string Formatted URL
	 * @throws Minz_ConfigurationException
	 */
	public static function display(string|array $url = [], string $encoding = 'html', bool|string $absolute = false, array $amend = []): string {
		$isArray = is_array($url);

		if ($isArray) {
			if (!empty($amend)) {
				/** @var array{c?:string,a?:string,params?:array<string,mixed>} $url */
				$url = array_replace_recursive($url, $amend);
			}
			$url = self::checkControllerUrl($url);
		}

		$url_string = '';

		if ($absolute !== false) {
			$url_string = Minz_Request::getBaseUrl();
			if (strlen($url_string) < strlen('http://a.bc')) {
				$url_string = Minz_Request::guessBaseUrl();
				if (PUBLIC_RELATIVE === '..' && preg_match('%' . PUBLIC_TO_INDEX_PATH . '(/|$)%', $url_string)) {
					//TODO: Implement proper resolver of relative parts such as /test/./../
					$url_string = dirname($url_string);
				}
			}
			if ($isArray) {
				$url_string .= PUBLIC_TO_INDEX_PATH;
			}
			if ($absolute === 'root') {
				$url_string = parse_url($url_string, PHP_URL_PATH);
			}
		} else {
			$url_string = $isArray ? '.' : PUBLIC_RELATIVE;
		}

		if ($isArray) {
			$url_string .= '/' . self::printUri($url, $encoding);
		} elseif ($encoding === 'html') {
			$url_string = Minz_Helper::htmlspecialchars_utf8($url_string . $url);
		} else {
			$url_string .= $url;
		}

		return $url_string;
	}

	/**
	 * Construit l'URI d'une URL
	 * @param array{c:string,a:string,params:array<string,mixed>} $url URL as array definition
	 * @param string $encodage pour indiquer comment encoder les & (& ou &amp; pour html)
	 * @return string uri sous la forme ?key=value&key2=value2
	 */
	private static function printUri(array $url, string $encodage): string {
		$uri = '';
		$separator = '?';
		$anchor = '';

		if ($encodage === 'html') {
			$and = '&amp;';
		} else {
			$and = '&';
		}

		if (!empty($url['params']) && is_array($url['params']) && !empty($url['params']['#'])) {
			if (is_string($url['params']['#'])) {
				$anchor = '#' . ($encodage === 'html' ? htmlspecialchars($url['params']['#'], ENT_QUOTES, 'UTF-8') : $url['params']['#']);
			}
			unset($url['params']['#']);
		}

		if (isset($url['c']) && is_string($url['c'])
			&& $url['c'] != Minz_Request::defaultControllerName()) {
			$uri .= $separator . 'c=' . $url['c'];
			$separator = $and;
		}

		if (isset($url['a']) && is_string($url['a'])
			&& $url['a'] != Minz_Request::defaultActionName()) {
			$uri .= $separator . 'a=' . $url['a'];
			$separator = $and;
		}

		if (isset($url['params']) && is_array($url['params'])) {
			unset($url['params']['c']);
			unset($url['params']['a']);
			foreach ($url['params'] as $key => $param) {
				if (!is_string($key) || (!is_string($param) && !is_int($param) && !is_bool($param))) {
					continue;
				}
				$uri .= $separator . urlencode($key) . '=' . urlencode((string)$param);
				$separator = $and;
			}
		}

		$uri .= $anchor;

		return $uri;
	}

	/**
	 * Check that all array elements representing the controller URL are OK
	 * @param array{c?:string,a?:string,params?:array<string,mixed>} $url controller URL as array
	 * @return array{c:string,a:string,params:array<string,mixed>} Verified controller URL as array
	 */
	public static function checkControllerUrl(array $url): array {
		return [
			'c' => empty($url['c']) || !is_string($url['c']) ? Minz_Request::defaultControllerName() : $url['c'],
			'a' => empty($url['a']) || !is_string($url['a']) ? Minz_Request::defaultActionName() : $url['a'],
			'params' => empty($url['params']) || !is_array($url['params']) ? [] : $url['params'],
		];
	}

	/** @param array{c?:string,a?:string,params?:array<string,mixed>} $url */
	public static function serialize(?array $url = []): string {
		if (empty($url)) {
			return '';
		}
		try {
			return base64_encode(json_encode($url, JSON_THROW_ON_ERROR));
		} catch (\Throwable $exception) {
			return '';
		}
	}

	/** @return array{c?:string,a?:string,params?:array<string,mixed>} */
	public static function unserialize(string $url = ''): array {
		$result = json_decode(base64_decode($url, true) ?: '', true, JSON_THROW_ON_ERROR) ?? [];
		/** @var array{c?:string,a?:string,params?:array<string,mixed>} $result */
		return $result;
	}

	/**
	 * Returns an array representing the URL as passed in the address bar
	 * @return array{c?:string,a?:string,params?:array<string,string>} URL representation
	 */
	public static function build(): array {
		$get = [];
		foreach ($_GET as $key => $value) {
			if (is_string($key) && is_string($value)) {
				$get[$key] = $value;
			}
		}
		$url = [
			'c' => is_string($_GET['c'] ?? null) ? $_GET['c'] : Minz_Request::defaultControllerName(),
			'a' => is_string($_GET['a'] ?? null) ? $_GET['a'] : Minz_Request::defaultActionName(),
			'params' => $get,
		];

		// post-traitement
		unset($url['params']['c']);
		unset($url['params']['a']);

		return $url;
	}
}

function _url(string $controller, string $action, int|string ...$args): string {
	$nb_args = count($args);

	if ($nb_args % 2 !== 0) {
		return '';
	}

	$params = [];
	for ($i = 0; $i < $nb_args; $i += 2) {
		$arg = '' . $args[$i];
		$params[$arg] = '' . $args[$i + 1];
	}

	return Minz_Url::display(['c' => $controller, 'a' => $action, 'params' => $params]);
}
