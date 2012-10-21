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
	 * @return l'url formatée
	 */
	public static function display ($url = array ()) {
		$url = self::checkUrl ($url);
		
		$url_string = '';
		
		if (is_array ($url) && isset ($url['protocol'])) {
			$protocol = $url['protocol'];
		} else {
			$protocol = 'http';
		}
		$url_string .= $protocol . '://';
		
		$url_string .= Request::getDomainName ();
		
		$url_string .= Request::getBaseUrl ();
		
		if (is_array ($url)) {
			$router = new Router ();
			
			if (Configuration::useUrlRewriting ()) {
				$url_string .= $router->printUriRewrited ($url);
			} else {
				$url_string .= self::printUri ($url);
			}
		} else {
			$url_string .= $url;
		}
		
		return $url_string;
	}
	
	/**
	 * Construit l'URI d'une URL sans url rewriting
	 * @param l'url sous forme de tableau
	 * @return l'uri sous la forme ?key=value&key2=value2
	 */
	private static function printUri ($url) {
		$uri = '';
		$separator = '/?';
		
		if (isset ($url['c'])
		 && $url['c'] != Request::defaultControllerName ()) {
			$uri .= $separator . 'c=' . $url['c'];
			$separator = '&';
		}
		
		if (isset ($url['a'])
		 && $url['a'] != Request::defaultActionName ()) {
			$uri .= $separator . 'a=' . $url['a'];
			$separator = '&';
		}
		
		if (isset ($url['params'])) {
			foreach ($url['params'] as $key => $param) {
				$uri .= $separator . $key . '=' . $param;
				$separator = '&';
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
