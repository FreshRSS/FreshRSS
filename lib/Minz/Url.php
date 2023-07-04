<?php

/**
 * The Minz_Url class handles URLs across the MINZ framework
 */
class Minz_Url {
	/**
	 * Display a formatted URL
	 * @param string|array<string,string|array<string,mixed>> $url The URL to format, defined as an array:
	 *                    $url['c'] = controller
	 *                    $url['a'] = action
	 *                    $url['params'] = array of additional parameters
	 *             or as a string
	 * @param string $encoding how to encode & (& ou &amp; pour html)
	 * @param bool|string $absolute
	 * @return string Formatted URL
	 */
	public static function display($url = [], string $encoding = 'html', $absolute = false): string {
		$isArray = is_array($url);

		if ($isArray) {
			$url = self::checkControllerUrl($url);
		}

		$url_string = '';

		if ($absolute) {
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
	 * @param array<string,mixed> $url l'url sous forme de tableau
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

		if (!empty($url['params']['#'])) {
			$anchor = '#' . ($encodage === 'html' ? htmlspecialchars($url['params']['#'], ENT_QUOTES, 'UTF-8') : $url['params']['#']);
			unset($url['params']['#']);
		}

		if (isset($url['c'])
		 && $url['c'] != Minz_Request::defaultControllerName()) {
			$uri .= $separator . 'c=' . $url['c'];
			$separator = $and;
		}

		if (isset($url['a'])
		 && $url['a'] != Minz_Request::defaultActionName()) {
			$uri .= $separator . 'a=' . $url['a'];
			$separator = $and;
		}

		if (isset($url['params'])) {
			unset($url['params']['c']);
			unset($url['params']['a']);
			foreach ($url['params'] as $key => $param) {
				if (!is_string($key) || (!is_string($param) && !is_int($param))) {
					continue;
				}
				$uri .= $separator . urlencode($key) . '=' . urlencode((string)$param);
				$separator = $and;
			}
		}

		if (!empty($url['#'])) {
			$uri .= '#' . ($encodage === 'html' ? htmlspecialchars($url['#'], ENT_QUOTES, 'UTF-8') : $url['#']);
		}

		$uri .= $anchor;

		return $uri;
	}

	/**
	 * Check that all array elements representing the controller URL are OK
	 * @param array<string,string|array<string,mixed>> $url controller URL as array
	 * @return array{'c':string,'a':string,'params':array<string,mixed>} Verified controller URL as array
	 */
	public static function checkControllerUrl(array $url): array {
		return [
			'c' => empty($url['c']) || !is_string($url['c']) ? Minz_Request::defaultControllerName() : $url['c'],
			'a' => empty($url['a']) || !is_string($url['a']) ? Minz_Request::defaultActionName() : $url['a'],
			'params' => empty($url['params']) || !is_array($url['params']) ? [] : $url['params'],
		];
	}

	/** @param array{'c'?:string,'a'?:string,'params'?:array<string,mixed>} $url */
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

	/**
	 * @phpstan-return array{'c'?:string,'a'?:string,'params'?:array<string,mixed>}
	 * @return array<string,string|array<string,string>>
	 */
	public static function unserialize(string $url = ''): array {
		try {
			return json_decode(base64_decode($url, true) ?: '', true, JSON_THROW_ON_ERROR) ?? [];
		} catch (\Throwable $exception) {
			return [];
		}
	}

	/**
	 * Returns an array representing the URL as passed in the address bar
	 * @return array{'c'?:string,'a'?:string,'params'?:array<string,mixed>} URL representation
	 */
	public static function build(): array {
		$url = [
			'c' => $_GET['c'] ?? Minz_Request::defaultControllerName(),
			'a' => $_GET['a'] ?? Minz_Request::defaultActionName(),
			'params' => $_GET,
		];

		// post-traitement
		unset($url['params']['c']);
		unset($url['params']['a']);

		return $url;
	}
}

/**
 * @param string $controller
 * @param string $action
 * @param string|int ...$args
 * @return string|false
 */
function _url(string $controller, string $action, ...$args) {
	$nb_args = count($args);

	if ($nb_args % 2 !== 0) {
		return false;
	}

	$params = array ();
	for ($i = 0; $i < $nb_args; $i += 2) {
		$arg = '' . $args[$i];
		$params[$arg] = '' . $args[$i + 1];
	}

	return Minz_Url::display (array ('c' => $controller, 'a' => $action, 'params' => $params));
}
