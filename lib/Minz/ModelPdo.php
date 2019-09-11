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

	/**
	 * $bd variable représentant la base de données
	 */
	protected $bd;

	protected $current_user;
	protected $prefix;

	/**
	 * Créé la connexion à la base de données à l'aide des variables
	 * HOST, BASE, USER et PASS définies dans le fichier de configuration
	 */
	public function __construct($currentUser = null, $currentPrefix = null, $currentDb = null) {
		if ($currentUser === null) {
			$currentUser = Minz_Session::param('currentUser');
		}
		if ($currentPrefix !== null) {
			$this->prefix = $currentPrefix;
		}
		if ($currentDb != null) {
			$this->bd = $currentDb;
			return;
		}
		if (self::$useSharedBd && self::$sharedBd != null &&
			($currentUser == null || $currentUser === self::$sharedCurrentUser)) {
			$this->bd = self::$sharedBd;
			$this->prefix = self::$sharedPrefix;
			$this->current_user = self::$sharedCurrentUser;
			return;
		}
		$this->current_user = $currentUser;
		self::$sharedCurrentUser = $currentUser;

		$conf = Minz_Configuration::get('system');
		$db = $conf->db;

		$driver_options = isset($conf->db['pdo_options']) && is_array($conf->db['pdo_options']) ? $conf->db['pdo_options'] : array();
		$dbServer = parse_url('db://' . $db['host']);

		try {
			switch ($db['type']) {
				case 'mysql':
					$string = 'mysql:host=' . (empty($dbServer['host']) ? $db['host'] : $dbServer['host']) . ';dbname=' . $db['base'] . ';charset=utf8mb4';
					if (!empty($dbServer['port'])) {
						$string .= ';port=' . $dbServer['port'];
					}
					$driver_options[PDO::MYSQL_ATTR_INIT_COMMAND] = 'SET NAMES utf8mb4';
					$this->prefix = $db['prefix'] . $currentUser . '_';
					$this->bd = new MinzPDOMySql($string, $db['user'], $db['password'], $driver_options);
					$this->bd->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);
					break;
				case 'sqlite':
					$string = 'sqlite:' . join_path(DATA_PATH, 'users', $currentUser, 'db.sqlite');
					$this->prefix = '';
					$this->bd = new MinzPDOSQLite($string, $db['user'], $db['password'], $driver_options);
					$this->bd->exec('PRAGMA foreign_keys = ON;');
					break;
				case 'pgsql':
					$string = 'pgsql:host=' . (empty($dbServer['host']) ? $db['host'] : $dbServer['host']) . ';dbname=' . $db['base'];
					if (!empty($dbServer['port'])) {
						$string .= ';port=' . $dbServer['port'];
					}
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
		return $this->bd->inTransaction();
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

abstract class MinzPDO extends PDO {
	private static function check($statement) {
		if (preg_match('/^(?:UPDATE|INSERT|DELETE)/i', $statement)) {
			invalidateHttpCache();
		}
	}

	protected function compatibility($statement) {
		return $statement;
	}

	abstract public function dbType();

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

class MinzPDOMySql extends MinzPDO {
	public function dbType() {
		return 'mysql';
	}

	public function lastInsertId($name = null) {
		return parent::lastInsertId();	//We discard the name, only used by PostgreSQL
	}
}

class MinzPDOSQLite extends MinzPDO {
	public function dbType() {
		return 'sqlite';
	}

	public function lastInsertId($name = null) {
		return parent::lastInsertId();	//We discard the name, only used by PostgreSQL
	}
}

class MinzPDOPGSQL extends MinzPDO {
	public function dbType() {
		return 'pgsql';
	}

	protected function compatibility($statement) {
		return str_replace(array('`', ' LIKE '), array('"', ' ILIKE '), $statement);
	}
}
