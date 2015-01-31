<?php

/**
 * La classe Url permet de gérer les URL à travers MINZ
 */
class Minz_Url {
	/**
	 * Affiche une Url formatée
	 * @param $url l'url à formater définie comme un tableau :
	 *                    $url['c'] = controller
	 *                    $url['a'] = action
	 *                    $url['params'] = tableau des paramètres supplémentaires
	 *                    $url['protocol'] = protocole à utiliser (http par défaut)
	 *             ou comme une chaîne de caractère
	 * @param $encodage pour indiquer comment encoder les & (& ou &amp; pour html)
	 * @return l'url formatée
	 */
	public static function display ($url = array (), $encodage = 'html', $absolute = false) {
		$isArray = is_array($url);

		if ($isArray) {
			$url = self::checkUrl ($url);
		}

		$url_string = '';

		if ($absolute) {
			if ($isArray && isset ($url['protocol'])) {
				$protocol = $url['protocol'];
			} elseif (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
				$protocol = 'https:';
			} else {
				$protocol = 'http:';
			}
			$url_string = $protocol . '//' . Minz_Request::getDomainName () . Minz_Request::getBaseUrl ();
		} else {
			$url_string = $isArray ? '.' : PUBLIC_RELATIVE;
		}

		if ($isArray) {
			$url_string .= self::printUri ($url, $encodage);
		} else {
			$url_string .= $url;
		}

		return $url_string;
	}

	/**
	 * Construit l'URI d'une URL
	 * @param l'url sous forme de tableau
	 * @param $encodage pour indiquer comment encoder les & (& ou &amp; pour html)
	 * @return l'uri sous la forme ?key=value&key2=value2
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
			foreach ($url['params'] as $key => $param) {
				$uri .= $separator . urlencode($key) . '=' . urlencode($param);
				$separator = $and;
			}
		}

		return $uri;
	}

	/**
	 * Vérifie que les éléments du tableau représentant une url soit ok
	 * @param l'url sous forme de tableau (sinon renverra directement $url)
	 * @return l'url vérifié
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

function _url ($controller, $action) {
	$nb_args = func_num_args ();

	if($nb_args < 2 || $nb_args % 2 != 0) {
		return false;
	}

	$args = func_get_args ();
	$params = array ();
	for($i = 2; $i < $nb_args; $i = $i + 2) {
		$params[$args[$i]] = $args[$i + 1];
	}

	return Minz_Url::display (array ('c' => $controller, 'a' => $action, 'params' => $params));
}
