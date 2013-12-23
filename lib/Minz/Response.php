<?php
/** 
 * MINZ - Copyright 2011 Marien Fressinaud
 * Sous licence AGPL3 <http://www.gnu.org/licenses/>
*/

/**
 * Response représente la requête http renvoyée à l'utilisateur
 */
class Minz_Response {
	private static $header = 'HTTP/1.0 200 OK';
	private static $body = '';
	
	/**
	 * Mets à jour le body de la Response
	 * @param $text le texte à incorporer dans le body
	 */
	public static function setBody ($text) {
		self::$body = $text;
	}
	
	/**
	 * Mets à jour le header de la Response
	 * @param $code le code HTTP, valeurs possibles
	 *	- 200 (OK)
	 *	- 403 (Forbidden)
	 *	- 404 (Forbidden)
	 *	- 500 (Forbidden) -> par défaut si $code erroné
	 *	- 503 (Forbidden)
	 */
	public static function setHeader ($code) {
		switch ($code) {
		case 200 :
			self::$header = 'HTTP/1.0 200 OK';
			break;
		case 403 :
			self::$header = 'HTTP/1.0 403 Forbidden';
			break;
		case 404 :
			self::$header = 'HTTP/1.0 404 Not Found';
			break;
		case 500 :
			self::$header = 'HTTP/1.0 500 Internal Server Error';
			break;
		case 503 :
			self::$header = 'HTTP/1.0 503 Service Unavailable';
			break;
		default :
			self::$header = 'HTTP/1.0 500 Internal Server Error';
		}
	}

	/**
	 * Envoie la Response à l'utilisateur
	 */
	public static function send () {
		header (self::$header);
		echo self::$body;
	}
}
