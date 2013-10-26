<?php

/**
 * La classe Url permet de gérer les URL à travers MINZ
 */
class Url {
	/**
	 * Affiche une Url formatée selon que l'on utilise l'url_rewriting ou non
	 * si oui, on cherche dans la table de routage la correspondance pour formater
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
		$url = self::checkUrl ($url);
		
		$url_string = '';
		
		if ($absolute) {
			if (is_array ($url) && isset ($url['protocol'])) {
				$protocol = $url['protocol'];
			} elseif (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
				$protocol = 'https:';
			} else {
				$protocol = 'http:';
			}
			$url_string = $protocol . '//' . Request::getDomainName () . Request::getBaseUrl ();
		}
		else {
			$url_string = '.';
		}
		
		if (is_array ($url)) {
			$router = new Router ();
			
			if (Configuration::useUrlRewriting ()) {
				$url_string .= $router->printUriRewrited ($url);
			} else {
				$url_string .= self::printUri ($url, $encodage);
			}
		} else {
			$url_string .= $url;
		}
		
		return $url_string;
	}
	
	/**
	 * Construit l'URI d'une URL sans url rewriting
	 * @param l'url sous forme de tableau
	 * @param $encodage pour indiquer comment encoder les & (& ou &amp; pour html)
	 * @return l'uri sous la forme ?key=value&key2=value2
	 */
	private static function printUri ($url, $encodage) {
		$uri = '';
		$separator = '/?';
		
		if($encodage == 'html') {
			$and = '&amp;';
		} else {
			$and = '&';
		}
		
		if (isset ($url['c'])
		 && $url['c'] != Request::defaultControllerName ()) {
			$uri .= $separator . 'c=' . $url['c'];
			$separator = $and;
		}
		
		if (isset ($url['a'])
		 && $url['a'] != Request::defaultActionName ()) {
			$uri .= $separator . 'a=' . $url['a'];
			$separator = $and;
		}
		
		if (isset ($url['params'])) {
			foreach ($url['params'] as $key => $param) {
				$uri .= $separator . $key . '=' . $param;
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
				$url_checked['c'] = Request::defaultControllerName ();
			}
			if (!isset ($url['a'])) {
				$url_checked['a'] = Request::defaultActionName ();
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

	return Url::display (array ('c' => $controller, 'a' => $action, 'params' => $params));
}
