<?php
declare(strict_types=1);

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
	 */
	public static bool $usesSharedPdo = true;

	private static ?Minz_Pdo $sharedPdo = null;

	private static string $sharedCurrentUser = '';

	protected Minz_Pdo $pdo;

	protected ?string $current_user;

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
				$this->pdo = new Minz_PdoSqlite($dsn . $dsnParams, null, null, $driver_options);
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
		if (self::$usesSharedPdo) {
			self::$sharedPdo = $this->pdo;
		}
	}

	/**
	 * Create the connection to the database using the variables
	 * HOST, BASE, USER and PASS variables defined in the configuration file
	 * @param string|null $currentUser
	 * @param Minz_Pdo|null $currentPdo
	 * @throws Minz_ConfigurationException
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
		if ($currentUser == null) {
			throw new Minz_PDOConnectionException('Current user must not be empty!', '', Minz_Exception::ERROR);
		}
		if (self::$usesSharedPdo && self::$sharedPdo !== null && $currentUser === self::$sharedCurrentUser) {
			$this->pdo = self::$sharedPdo;
			$this->current_user = self::$sharedCurrentUser;
			return;
		}
		$this->current_user = $currentUser;
		if (self::$usesSharedPdo) {
			self::$sharedCurrentUser = $currentUser;
		}

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
				$ex === null ? '' : $ex->getMessage(),
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

	public function close(): void {
		if ($this->current_user === self::$sharedCurrentUser) {
			self::clean();
		}
		$this->current_user = '';
		unset($this->pdo);
		gc_collect_cycles();
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

		$backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 6);
		$calling = '';
		for ($i = 2; $i < 6; $i++) {
			if (empty($backtrace[$i]['function'])) {
				break;
			}
			$calling .= '|' . $backtrace[$i]['function'];
		}
		$calling = trim($calling, '|');
		$info = $stm == null ? $this->pdo->errorInfo() : $stm->errorInfo();
		Minz_Log::error('SQL error ' . $calling . ' ' . json_encode($info));
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

	/** For retrieving a single value without prepared statement such as `SELECT version()` */
	public function fetchValue(string $sql): ?string {
		$stm = $this->pdo->query($sql);
		if ($stm === false) {
			Minz_Log::error('SQL error ' . json_encode($this->pdo->errorInfo()) . ' during ' . $sql);
			return null;
		}
		$columns = $stm->fetchAll(PDO::FETCH_COLUMN, 0);
		if ($columns === false) {
			Minz_Log::error('SQL error ' . json_encode($stm->errorInfo()) . ' during ' . $sql);
			return null;
		}
		return isset($columns[0]) ? (string)$columns[0] : null;
	}
}
