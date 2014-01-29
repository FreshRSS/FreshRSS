<?php
/**
 * MINZ - Copyright 2011 Marien Fressinaud
 * Sous licence AGPL3 <http://www.gnu.org/licenses/>
*/

/**
 * La classe Model_sql représente le modèle interragissant avec les bases de données
 * Seul la connexion MySQL est prise en charge pour le moment
 */
class Minz_ModelPdo {

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

		$db = Minz_Configuration::dataBase ();
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

			$this->prefix = $db['prefix'] . Minz_Session::param('currentUser', '_') . '_';
			self::$sharedPrefix = $this->prefix;
		} catch (Exception $e) {
			throw new Minz_PDOConnectionException (
				$string,
				$db['user'], Minz_Exception::ERROR
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

	public function size($all = false) {
		$db = Minz_Configuration::dataBase ();
		$sql = 'SELECT SUM(data_length + index_length) FROM information_schema.TABLES WHERE table_schema = ?';
		$values = array ($db['base']);
		if (!$all) {
			$sql .= ' AND table_name LIKE ?';
			$values[] = $this->prefix . '%';
		}
		$stm = $this->bd->prepare ($sql);
		$stm->execute ($values);
		$res = $stm->fetchAll(PDO::FETCH_COLUMN, 0);
		return $res[0];
	}

	public static function clean() {
		self::$sharedBd = null;
		self::$sharedPrefix = '';
	}
}

class FreshPDO extends PDO {
	private static function check($statement) {
		if (preg_match('/^(?:UPDATE|INSERT|DELETE)/i', $statement)) {
			invalidateHttpCache();
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
