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
		if ($currentUser == '') {
			throw new Minz_PDOConnectionException('Current user must not be empty!', '', Minz_Exception::ERROR);
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
					$this->pdo = new Minz_PdoMysql($dsn . $dsnParams, $db['user'], $db['password'], $driver_options);
					$this->pdo->setPrefix($db['prefix'] . $currentUser . '_');
					break;
				case 'sqlite':
					$dsn = 'sqlite:' . join_path(DATA_PATH, 'users', $currentUser, 'db.sqlite');
					$this->pdo = new Minz_PdoSqlite($dsn . $dsnParams, $db['user'], $db['password'], $driver_options);
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
					$this->pdo = new Minz_PdoPgsql($dsn . $dsnParams, $db['user'], $db['password'], $driver_options);
					$this->pdo->setPrefix($db['prefix'] . $currentUser . '_');
					break;
				default:
					throw new Minz_PDOConnectionException(
						'Invalid database type!',
						$db['user'], Minz_Exception::ERROR
					);
			}
			self::$sharedPdo = $this->pdo;
		} catch (Exception $e) {
			throw new Minz_PDOConnectionException(
				$e->getMessage(),
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
