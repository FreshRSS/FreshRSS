<?php

/**
 * MINZ - Copyright 2011 Marien Fressinaud
 * Sous licence AGPL3 <http://www.gnu.org/licenses/>
 */

/**
 * The Model_sql class represents the model for interacting with databases.
 */
class Minz_ModelPdo {

	/**
	 * Shares the connection to the database between all instances.
	 * @var bool
	 */
	public static $usesSharedPdo = true;

	/**
	 * @var Minz_Pdo|null
	 */
	private static $sharedPdo;

	/**
	 * @var string|null
	 */
	private static $sharedCurrentUser;

	/**
	 * @var Minz_Pdo
	 */
	protected $pdo;

	/**
	 * @var string|null
	 */
	protected $current_user;

	/**
	 * @throws Minz_ConfigurationNamespaceException
	 * @throws Minz_PDOConnectionException
	 * @throws PDOException
	 */
	private function dbConnect(): void {
		$db = Minz_Configuration::get('system')->db;
		$driver_options = isset($db['pdo_options']) && is_array($db['pdo_options']) ? $db['pdo_options'] : [];
		$driver_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_SILENT;
		$dbServer = parse_url('db://' . $db['host']);
		$dsn = '';
		$dsnParams = empty($db['connection_uri_params']) ? '' : (';' . $db['connection_uri_params']);

		switch ($db['type']) {
			case 'mysql':
				$dsn = 'mysql:';
				if (empty($dbServer['host'])) {
					$dsn .= 'unix_socket=' . $db['host'];
				} else {
					$dsn .= 'host=' . $dbServer['host'];
				}
				$dsn .= ';charset=utf8mb4';
				if (!empty($db['base'])) {
					$dsn .= ';dbname=' . $db['base'];
				}
				if (!empty($dbServer['port'])) {
					$dsn .= ';port=' . $dbServer['port'];
				}
				$driver_options[PDO::MYSQL_ATTR_INIT_COMMAND] = 'SET NAMES utf8mb4';
				$this->pdo = new Minz_PdoMysql($dsn . $dsnParams, $db['user'], $db['password'], $driver_options);
				$this->pdo->setPrefix($db['prefix'] . $this->current_user . '_');
				break;
			case 'sqlite':
				$dsn = 'sqlite:' . DATA_PATH . '/users/' . $this->current_user . '/db.sqlite';
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
				$this->pdo->setPrefix($db['prefix'] . $this->current_user . '_');
				break;
			default:
				throw new Minz_PDOConnectionException(
					'Invalid database type!',
					$db['user'], Minz_Exception::ERROR
				);
		}
		self::$sharedPdo = $this->pdo;
	}

	/**
	 * Create the connection to the database using the variables
	 * HOST, BASE, USER and PASS variables defined in the configuration file
	 * @param string|null $currentUser
	 * @param Minz_Pdo|null $currentPdo
	 * @throws Minz_ConfigurationNamespaceException
	 * @throws Minz_PDOConnectionException
	 */
	public function __construct(?string $currentUser = null, ?Minz_Pdo $currentPdo = null) {
		if ($currentUser === null) {
			$currentUser = Minz_User::name();
		}
		if ($currentPdo !== null) {
			$this->pdo = $currentPdo;
			return;
		}
		if ($currentUser == '') {
			throw new Minz_PDOConnectionException('Current user must not be empty!', '', Minz_Exception::ERROR);
		}
		if (self::$usesSharedPdo && self::$sharedPdo !== null && $currentUser === self::$sharedCurrentUser) {
			$this->pdo = self::$sharedPdo;
			$this->current_user = self::$sharedCurrentUser;
			return;
		}
		$this->current_user = $currentUser;
		self::$sharedCurrentUser = $currentUser;

		$ex = null;
		//Attempt a few times to connect to database
		for ($attempt = 1; $attempt <= 5; $attempt++) {
			try {
				$this->dbConnect();
				return;
			} catch (PDOException $e) {
				$ex = $e;
				if (empty($e->errorInfo[0]) || $e->errorInfo[0] !== '08006') {
					//We are only interested in: SQLSTATE connection exception / connection failure
					break;
				}
			} catch (Exception $e) {
				$ex = $e;
			}
			sleep(2);
		}

		$db = Minz_Configuration::get('system')->db;

		throw new Minz_PDOConnectionException(
				$ex->getMessage(),
				$db['user'], Minz_Exception::ERROR
			);
	}

	public function beginTransaction(): void {
		$this->pdo->beginTransaction();
	}

	public function inTransaction(): bool {
		return $this->pdo->inTransaction();
	}

	public function commit(): void {
		$this->pdo->commit();
	}

	public function rollBack(): void {
		$this->pdo->rollBack();
	}

	public static function clean(): void {
		self::$sharedPdo = null;
		self::$sharedCurrentUser = '';
	}

	/**
	 * @param array<string,int|string|null> $values
	 * @phpstan-return ($mode is PDO::FETCH_ASSOC ? array<array<string,int|string|null>>|null : array<int|string|null>|null)
	 * @return array<array<string,int|string|null>>|array<int|string|null>|null
	 */
	private function fetchAny(string $sql, array $values, int $mode, int $column = 0): ?array {
		$stm = $this->pdo->prepare($sql);
		$ok = $stm !== false;
		if ($ok && !empty($values)) {
			foreach ($values as $name => $value) {
				if (is_int($value)) {
					$type = PDO::PARAM_INT;
				} elseif (is_string($value)) {
					$type = PDO::PARAM_STR;
				} elseif (is_null($value)) {
					$type = PDO::PARAM_NULL;
				} else {
					$ok = false;
					break;
				}
				if (!$stm->bindValue($name, $value, $type)) {
					$ok = false;
					break;
				}
			}
		}
		if ($ok && $stm !== false && $stm->execute()) {
			switch ($mode) {
				case PDO::FETCH_COLUMN:
					$res = $stm->fetchAll(PDO::FETCH_COLUMN, $column);
					break;
				case PDO::FETCH_ASSOC:
				default:
					$res = $stm->fetchAll(PDO::FETCH_ASSOC);
					break;
			}
			if ($res !== false) {
				return $res;
			}
		}

		$callingFunction = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3)[2]['function'] ?? '??';
		$info = $stm == null ? $this->pdo->errorInfo() : $stm->errorInfo();
		Minz_Log::error('SQL error ' . $callingFunction . ' ' . json_encode($info));
		return null;
	}

	/**
	 * @param array<string,int|string|null> $values
	 * @return array<array<string,int|string|null>>|null
	 */
	public function fetchAssoc(string $sql, array $values = []): ?array {
		return $this->fetchAny($sql, $values, PDO::FETCH_ASSOC);
	}

	/**
	 * @param array<string,int|string|null> $values
	 * @return array<int|string|null>|null
	 */
	public function fetchColumn(string $sql, int $column, array $values = []): ?array {
		return $this->fetchAny($sql, $values, PDO::FETCH_COLUMN, $column);
	}
}
