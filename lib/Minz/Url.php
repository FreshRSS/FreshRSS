<?php

/**
 * La classe Url permet de gérer les URL à travers MINZ
 */
class Minz_Url {
	/**
	 * Affiche une Url formatée
	 * @param array<string,string> $url l'url à formater définie comme un tableau :
	 *                    $url['c'] = controller
	 *                    $url['a'] = action
	 *                    $url['params'] = tableau des paramètres supplémentaires
	 *             ou comme une chaîne de caractère
	 * @param string $encodage pour indiquer comment encoder les & (& ou &amp; pour html)
	 * @param bool $absolute
	 * @return string url formatée
	 */
	public static function display ($url = array (), $encodage = 'html', $absolute = false) {
		$isArray = is_array($url);

		if ($isArray) {
			$url = self::checkUrl($url);
		}

		$url_string = '';

		if ($absolute) {
			$url_string = Minz_Request::getBaseUrl();
			if (strlen($url_string) < strlen('http://a.bc')) {
				$url_string = Minz_Request::guessBaseUrl();
				if (PUBLIC_RELATIVE === '..') {
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
			$url_string .= '/' . self::printUri($url, $encodage);
		} elseif ($encodage === 'html') {
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
	private static function printUri($url, $encodage) {
		$uri = '';
		$separator = '?';

		if ($encodage === 'html') {
			$and = '&amp;';
		} else {
			$and = '&';
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
				$uri .= $separator . urlencode($key) . '=' . urlencode($param);
				$separator = $and;
			}
		}

		return $uri;
	}

	/**
	 * Vérifie que les éléments du tableau représentant une url soit ok
	 * @param array<string,string>|string $url sous forme de tableau (sinon renverra directement $url)
	 * @return string url vérifié
	 */
	public static function checkUrl ($url) {
		$url_checked = $url;

		if (is_array ($url)) {
			if (!isset ($url['c'])) {
				$url_checked['c'] = Minz_Request::defaultControllerName ();
			}
			if (!isset ($url['a'])) {
				$url_checked['a'] = Minz_Request::defaultActionName ();
			}
			if (!isset ($url['params'])) {
				$url_checked['params'] = array ();
			}
		}

		return $url_checked;
	}
}

/**
 * @param string $controller
 * @param string $action
 * @param array<string,string> $args
 */
function _url ($controller, $action, ...$args) {
	$nb_args = count($args);

	if ($nb_args % 2 !== 0) {
		return false;
	}

	$params = array ();
	for ($i = 0; $i < $nb_args; $i += 2) {
		$params[$args[$i]] = $args[$i + 1];
	}

	return Minz_Url::display (array ('c' => $controller, 'a' => $action, 'params' => $params));
}
