<?php
/** 
 * MINZ - Copyright 2011 Marien Fressinaud
 * Sous licence AGPL3 <http://www.gnu.org/licenses/>
*/

/**
 * La classe Cache permet de gérer facilement les pages en cache
 */
class Cache {
	/**
	 * $expire timestamp auquel expire le cache de $url
	 */
	private $expire = 0;
	
	/**
	 * $file est le nom du fichier de cache
	 */
	private $file = '';
	
	/**
	 * $enabled permet de déterminer si le cache est activé
	 */
	private static $enabled = true;
	
	/**
	 * Constructeur
	 */
	public function __construct () {
		$this->_fileName ();
		$this->_expire ();
	}
	
	/**
	 * Setteurs
	 */
	public function _fileName () {
		$file = md5 (Request::getURI ());
		
		$this->file = CACHE_PATH . '/'.$file;
	}
	
	public function _expire () {
		if ($this->exist ()) {
			$this->expire = filemtime ($this->file)
			              + Configuration::delayCache ();
		}
	}
	
	/**
	 * Permet de savoir si le cache est activé
	 * @return true si activé, false sinon
	 */
	public static function isEnabled () {
		return Configuration::cacheEnabled () && self::$enabled;
	}
	
	/**
	 * Active / désactive le cache
	 */
	public static function switchOn () {
		self::$enabled = true;
	}
	public static function switchOff () {
		self::$enabled = false;
	}
	
	/**
	 * Détermine si le cache de $url a expiré ou non
	 * @return true si il a expiré, false sinon
	 */
	public function expired () {
		return time () > $this->expire;
	}
	
	/**
	 * Affiche le contenu du cache
	 * @print le code html du cache
	 */
	public function render () {
		if ($this->exist ()) {
			include ($this->file);
		}
	}
	
	/**
	 * Enregistre $html en cache
	 * @param $html le html à mettre en cache
	 */
	public function cache ($html) {
		file_put_contents ($this->file, $html);
	}
	
	/**
	 * Permet de savoir si le cache existence
	 * @return true si il existe, false sinon
	 */
	public function exist () {
		return file_exists ($this->file);
	}
	
	/**
	 * Nettoie le cache en supprimant tous les fichiers
	 */
	public static function clean () {
		$files = opendir (CACHE_PATH);
		
		while ($fic = readdir ($files)) {
			if ($fic != '.' && $fic != '..') {
				unlink (CACHE_PATH.'/'.$fic);
			}
		}
		
		closedir ($files);
	}
}
