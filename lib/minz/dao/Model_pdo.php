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

		try {
			$type = $db['type'];
			if($type == 'mysql') {
				$string = $type
				        . ':host=' . $db['host']
				        . ';dbname=' . $db['base'];
			} elseif($type == 'sqlite') {
				$string = $type
				        . ':/' . PUBLIC_PATH
				        . '/data/' . $db['base'] . '.sqlite';
			}

			$this->bd = new PDO (
				$string,
				$db['user'],
				$db['password']
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
