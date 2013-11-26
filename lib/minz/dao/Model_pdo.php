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
	 * Partage la connexion à la base de données entre toutes les instances.
	 */
	public static $useSharedBd = true;
	private static $sharedBd = null;
	private static $sharedPrefix;

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
		if (self::$useSharedBd && self::$sharedBd != null) {
			$this->bd = self::$sharedBd;
			$this->prefix = self::$sharedPrefix;
			return;
		}

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
				$string = $type . ':/' . DATA_PATH . $db['base'] . '.sqlite';	//TODO: DEBUG UTF-8 http://www.siteduzero.com/forum/sujet/sqlite-connexion-utf-8-18797
			}

			$this->bd = new FreshPDO (
				$string,
				$db['user'],
				$db['password'],
				$driver_options
			);
			self::$sharedBd = $this->bd;

			$userPrefix = Configuration::currentUser ();
			$this->prefix = $db['prefix'] . (empty($userPrefix) ? '' : ($userPrefix . '_'));
			self::$sharedPrefix = $this->prefix;
		} catch (Exception $e) {
			throw new PDOConnectionException (
				$string,
				$db['user'], MinzException::ERROR
			);
		}
	}

	public function beginTransaction() {
		$this->bd->beginTransaction();
	}
	public function commit() {
		$this->bd->commit();
	}
	public function rollBack() {
		$this->bd->rollBack();
	}
}

class FreshPDO extends PDO {
	private static function check($statement) {
		if (preg_match('/^(?:UPDATE|INSERT|DELETE)/i', $statement)) {
			touch(DATA_PATH . '/touch.txt');
		}
	}

	public function prepare ($statement, $driver_options = array()) {
		FreshPDO::check($statement);
		return parent::prepare($statement, $driver_options);
	}

	public function exec ($statement) {
		FreshPDO::check($statement);
		return parent::exec($statement);
	}
}
