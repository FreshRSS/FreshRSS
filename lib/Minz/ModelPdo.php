<?php
/**
 * MINZ - Copyright 2011 Marien Fressinaud
 * Sous licence AGPL3 <http://www.gnu.org/licenses/>
*/

/**
 * La classe Model_sql représente le modèle interragissant avec les bases de données
 */
class Minz_ModelPdo {

	/**
	 * Partage la connexion à la base de données entre toutes les instances.
	 */
	public static $usesSharedPdo = true;
	private static $sharedPdo = null;
	private static $sharedPrefix;
	private static $sharedCurrentUser;

	protected $pdo;
	protected $current_user;

	/**
	 * Créé la connexion à la base de données à l'aide des variables
	 * HOST, BASE, USER et PASS définies dans le fichier de configuration
	 */
	public function __construct($currentUser = null, $currentPdo = null) {
		if ($currentUser === null) {
			$currentUser = Minz_Session::param('currentUser');
		}
		if ($currentPdo != null) {
			$this->pdo = $currentPdo;
			return;
		}
		if (self::$usesSharedPdo && self::$sharedPdo != null &&
			($currentUser == '' || $currentUser === self::$sharedCurrentUser)) {
			$this->pdo = self::$sharedPdo;
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
					$this->pdo = new MinzPDOMySql($string, $db['user'], $db['password'], $driver_options);
					$this->pdo->setPrefix($db['prefix'] . $currentUser . '_');
					break;
				case 'sqlite':
					$string = 'sqlite:' . join_path(DATA_PATH, 'users', $currentUser, 'db.sqlite');
					$this->pdo = new MinzPDOSQLite($string, $db['user'], $db['password'], $driver_options);
					$this->pdo->setPrefix('');
					break;
				case 'pgsql':
					$string = 'pgsql:host=' . (empty($dbServer['host']) ? $db['host'] : $dbServer['host']) . ';dbname=' . $db['base'];
					if (!empty($dbServer['port'])) {
						$string .= ';port=' . $dbServer['port'];
					}
					$this->pdo = new MinzPDOPGSQL($string, $db['user'], $db['password'], $driver_options);
					$this->pdo->setPrefix($db['prefix'] . $currentUser . '_');
					break;
				default:
					throw new Minz_PDOConnectionException(
						'Invalid database type!',
						$db['user'], Minz_Exception::ERROR
					);
					break;
			}
			self::$sharedPdo = $this->pdo;
		} catch (Exception $e) {
			throw new Minz_PDOConnectionException(
				$string,
				$db['user'], Minz_Exception::ERROR
			);
		}
	}

	public function beginTransaction() {
		$this->pdo->beginTransaction();
	}
	public function inTransaction() {
		return $this->pdo->inTransaction();
	}
	public function commit() {
		$this->pdo->commit();
	}
	public function rollBack() {
		$this->pdo->rollBack();
	}

	public static function clean() {
		self::$sharedPdo = null;
		self::$sharedCurrentUser = '';
	}
}

abstract class MinzPDO extends PDO {
	public function __construct($dsn, $username = null, $passwd = null, $options = null) {
		parent::__construct($dsn, $username, $passwd, $options);
		$this->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }
	
	abstract public function dbType();

	private $prefix = '';
	public function prefix() { return $this->prefix; }
	public function setPrefix($prefix) { $this->prefix = $prefix; }

	private function autoPrefix($sql) {
		return str_replace('`_', '`' . $this->prefix, $sql);
	}

	protected function preSql($statement) {
		if (preg_match('/^(?:UPDATE|INSERT|DELETE)/i', $statement)) {
			invalidateHttpCache();
		}
		return $this->autoPrefix($statement);
	}

	public function lastInsertId($name = null) {
		if ($name != null) {
			$name = $this->autoPrefix($name);
		}
		return parent::lastInsertId($name);
	}

	public function prepare($statement, $driver_options = array()) {
		$statement = $this->preSql($statement);
		return parent::prepare($statement, $driver_options);
	}

	public function exec($statement) {
		$statement = $this->preSql($statement);
		return parent::exec($statement);
	}

	public function query($statement) {
		$statement = $this->preSql($statement);
		return parent::query($statement);
	}
}

class MinzPDOMySql extends MinzPDO {
	public function __construct($dsn, $username = null, $passwd = null, $options = null) {
		parent::__construct($dsn, $username, $passwd, $options);
		$this->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);
    }
	
	public function dbType() {
		return 'mysql';
	}

	public function lastInsertId($name = null) {
		return parent::lastInsertId();	//We discard the name, only used by PostgreSQL
	}
}

class MinzPDOSQLite extends MinzPDO {
	public function __construct($dsn, $username = null, $passwd = null, $options = null) {
		parent::__construct($dsn, $username, $passwd, $options);
		$this->exec('PRAGMA foreign_keys = ON;');
    }

	public function dbType() {
		return 'sqlite';
	}

	public function lastInsertId($name = null) {
		return parent::lastInsertId();	//We discard the name, only used by PostgreSQL
	}
}

class MinzPDOPGSQL extends MinzPDO {
	public function __construct($dsn, $username = null, $passwd = null, $options = null) {
		parent::__construct($dsn, $username, $passwd, $options);
		$this->exec("SET NAMES 'UTF8';");
    }

	public function dbType() {
		return 'pgsql';
	}

	protected function preSql($statement) {
		$statement = parent::preSql($statement);
		return str_replace(array('`', ' LIKE '), array('"', ' ILIKE '), $statement);
	}
}
