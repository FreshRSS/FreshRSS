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
	private static $sharedCurrentUser;
	protected static $sharedDbType;

	/**
	 * $bd variable représentant la base de données
	 */
	protected $bd;

	protected $current_user;
	protected $prefix;

	public function dbType() {
		return self::$sharedDbType;
	}

	/**
	 * Créé la connexion à la base de données à l'aide des variables
	 * HOST, BASE, USER et PASS définies dans le fichier de configuration
	 */
	public function __construct($currentUser = null) {
		if (self::$useSharedBd && self::$sharedBd != null && $currentUser === null) {
			$this->bd = self::$sharedBd;
			$this->prefix = self::$sharedPrefix;
			$this->current_user = self::$sharedCurrentUser;
			return;
		}

		$conf = Minz_Configuration::get('system');
		$db = $conf->db;

		if ($currentUser === null) {
			$currentUser = Minz_Session::param('currentUser', '_');
		}
		$this->current_user = $currentUser;
		self::$sharedCurrentUser = $currentUser;

		$driver_options = isset($conf->db['pdo_options']) && is_array($conf->db['pdo_options']) ? $conf->db['pdo_options'] : array();

		try {
			switch ($db['type']) {
				case 'mysql':
					$string = 'mysql:host=' . $db['host'] . ';dbname=' . $db['base'] . ';charset=utf8mb4';
					$driver_options[PDO::MYSQL_ATTR_INIT_COMMAND] = 'SET NAMES utf8mb4';
					$this->prefix = $db['prefix'] . $currentUser . '_';
					$this->bd = new MinzPDOMySql($string, $db['user'], $db['password'], $driver_options);
					//TODO Consider: $this->bd->exec("SET SESSION sql_mode = 'ANSI_QUOTES';");
					break;
				case 'sqlite':
					$string = 'sqlite:' . join_path(DATA_PATH, 'users', $currentUser, 'db.sqlite');
					$this->prefix = '';
					$this->bd = new MinzPDOMSQLite($string, $db['user'], $db['password'], $driver_options);
					$this->bd->exec('PRAGMA foreign_keys = ON;');
					break;
				case 'pgsql':
					$string = 'pgsql:host=' . $db['host'] . ';dbname=' . $db['base'];
					$this->prefix = $db['prefix'] . $currentUser . '_';
					$this->bd = new MinzPDOPGSQL($string, $db['user'], $db['password'], $driver_options);
					$this->bd->exec("SET NAMES 'UTF8';");
					break;
				default:
					throw new Minz_PDOConnectionException(
						'Invalid database type!',
						$db['user'], Minz_Exception::ERROR
					);
					break;
			}
			self::$sharedBd = $this->bd;
			self::$sharedDbType = $db['type'];
			self::$sharedPrefix = $this->prefix;
		} catch (Exception $e) {
			throw new Minz_PDOConnectionException(
				$string,
				$db['user'], Minz_Exception::ERROR
			);
		}
	}

	public function beginTransaction() {
		$this->bd->beginTransaction();
	}
	public function inTransaction() {
		return $this->bd->inTransaction();	//requires PHP >= 5.3.3
	}
	public function commit() {
		$this->bd->commit();
	}
	public function rollBack() {
		$this->bd->rollBack();
	}

	public static function clean() {
		self::$sharedBd = null;
		self::$sharedPrefix = '';
	}
}

class MinzPDO extends PDO {
	private static function check($statement) {
		if (preg_match('/^(?:UPDATE|INSERT|DELETE)/i', $statement)) {
			invalidateHttpCache();
		}
	}

	protected function compatibility($statement) {
		return $statement;
	}

	public function prepare($statement, $driver_options = array()) {
		MinzPDO::check($statement);
		$statement = $this->compatibility($statement);
		return parent::prepare($statement, $driver_options);
	}

	public function exec($statement) {
		MinzPDO::check($statement);
		$statement = $this->compatibility($statement);
		return parent::exec($statement);
	}

	public function query($statement) {
		MinzPDO::check($statement);
		$statement = $this->compatibility($statement);
		return parent::query($statement);
	}
}

class MinzPDOMySql extends PDO {
	public function lastInsertId($name = null) {
		return parent::lastInsertId();	//We discard the name, only used by PostgreSQL
	}
}

class MinzPDOMSQLite extends PDO {
	public function lastInsertId($name = null) {
		return parent::lastInsertId();	//We discard the name, only used by PostgreSQL
	}
}

class MinzPDOPGSQL extends MinzPDO {
	protected function compatibility($statement) {
		return str_replace(
			array('`', 'lastUpdate', 'pathEntries', 'httpAuth', 'cache_nbEntries', 'cache_nbUnreads', 'lastSeen'),
			array('"', '"lastUpdate"', '"pathEntries"', '"httpAuth"', '"cache_nbEntries"', '"cache_nbUnreads"', '"lastSeen"'),
			$statement);
	}
}
