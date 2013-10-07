<?php
/** 
 * MINZ - Copyright 2011 Marien Fressinaud
 * Sous licence AGPL3 <http://www.gnu.org/licenses/>
*/

/**
 * La classe Model_sql représente le modèle interragissant avec les bases de données
 * Seul la connexion MySQL est prise en charge pour le moment
 */
class Model_pdo {
	/**
	 * $bd variable représentant la base de données
	 */
	protected $bd;

	protected $prefix;
	
	/**
	 * Créé la connexion à la base de données à l'aide des variables
	 * HOST, BASE, USER et PASS définies dans le fichier de configuration
	 */
	public function __construct () {
		$db = Configuration::dataBase ();
		$driver_options = null;

		try {
			$type = $db['type'];
			if($type == 'mysql') {
				$string = $type
				        . ':host=' . $db['host']
				        . ';dbname=' . $db['base']
				        . ';charset=utf8';
				$driver_options = array(
					PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
				);
			} elseif($type == 'sqlite') {
				$string = $type
				        . ':/' . PUBLIC_PATH
				        . '/data/' . $db['base'] . '.sqlite';	//TODO: DEBUG UTF-8 http://www.siteduzero.com/forum/sujet/sqlite-connexion-utf-8-18797
			}

			$this->bd = new PDO (
				$string,
				$db['user'],
				$db['password'],
				$driver_options
			);

			$this->prefix = $db['prefix'];
		} catch (Exception $e) {
			throw new PDOConnectionException (
				$string,
				$db['user'], MinzException::WARNING
			);
		}
	}
}
