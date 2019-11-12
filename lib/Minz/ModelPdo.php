<?php

namespace Minz;

/**
 * MINZ - Copyright 2011 Marien Fressinaud
 * Sous licence AGPL3 <http://www.gnu.org/licenses/>
*/

/**
 * La classe Model_sql représente le modèle interragissant avec les bases de données
 */
class ModelPdo {

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
			$currentUser = Session::param('currentUser');
		}
		if ($currentPdo != null) {
			$this->pdo = $currentPdo;
			return;
		}
		if ($currentUser == '') {
			throw new PDOConnectionException('Current user must not be empty!', '', Minz_Exception::ERROR);
		}
		if (self::$usesSharedPdo && self::$sharedPdo != null &&
			($currentUser == '' || $currentUser === self::$sharedCurrentUser)) {
			$this->pdo = self::$sharedPdo;
			$this->current_user = self::$sharedCurrentUser;
			return;
		}
		$this->current_user = $currentUser;
		self::$sharedCurrentUser = $currentUser;

		$conf = Configuration::get('system');
		$db = $conf->db;

		$driver_options = isset($db['pdo_options']) && is_array($db['pdo_options']) ? $db['pdo_options'] : [];
		$dbServer = parse_url('db://' . $db['host']);
		$dsn = '';
		$dsnParams = empty($db['connection_uri_params']) ? '' : (';' . $db['connection_uri_params']);

		try {
			switch ($db['type']) {
				case 'mysql':
					$dsn = 'mysql:host=' . (empty($dbServer['host']) ? $db['host'] : $dbServer['host']) . ';charset=utf8mb4';
					if (!empty($db['base'])) {
						$dsn .= ';dbname=' . $db['base'];
					}
					if (!empty($dbServer['port'])) {
						$dsn .= ';port=' . $dbServer['port'];
					}
					$driver_options[PDO::MYSQL_ATTR_INIT_COMMAND] = 'SET NAMES utf8mb4';
					$this->pdo = new MinzPDOMySql($dsn . $dsnParams, $db['user'], $db['password'], $driver_options);
					$this->pdo->setPrefix($db['prefix'] . $currentUser . '_');
					break;
				case 'sqlite':
					$dsn = 'sqlite:' . join_path(DATA_PATH, 'users', $currentUser, 'db.sqlite');
					$this->pdo = new MinzPDOSQLite($dsn . $dsnParams, $db['user'], $db['password'], $driver_options);
					$this->pdo->setPrefix('');
					break;
				case 'pgsql':
					$dsn = 'pgsql:host=' . (empty($dbServer['host']) ? $db['host'] : $dbServer['host']);
					if (!empty($db['base'])) {
						$dsn .= ';dbname=' . $db['base'];
					}
					if (!empty($dbServer['port'])) {
						$dsn .= ';port=' . $dbServer['port'];
					}
					$this->pdo = new MinzPDOPGSQL($dsn . $dsnParams, $db['user'], $db['password'], $driver_options);
					$this->pdo->setPrefix($db['prefix'] . $currentUser . '_');
					break;
				default:
					throw new PDOConnectionException(
						'Invalid database type!',
						$db['user'], Exception::ERROR
					);
			}
			self::$sharedPdo = $this->pdo;
		} catch (Exception $e) {
			throw new PDOConnectionException(
				$dsn . $dsnParams,
				$db['user'], Exception::ERROR
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
			$name = $this->preSql($name);
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
