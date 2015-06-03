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
	private static $has_transaction = false;
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
			$type = $db['type'];
			if ($type === 'mysql') {
				$string = 'mysql:host=' . $db['host']
				        . ';dbname=' . $db['base']
				        . ';charset=utf8';
				$driver_options[PDO::MYSQL_ATTR_INIT_COMMAND] = 'SET NAMES utf8';
				$this->prefix = $db['prefix'] . $currentUser . '_';
			} elseif ($type === 'sqlite') {
				$string = 'sqlite:' . join_path(DATA_PATH, 'users', $currentUser, 'db.sqlite');
				//$driver_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
				$this->prefix = '';
			} else {
				throw new Minz_PDOConnectionException(
					'Invalid database type!',
					$db['user'], Minz_Exception::ERROR
				);
			}
			self::$sharedDbType = $type;
			self::$sharedPrefix = $this->prefix;

			$this->bd = new MinzPDO(
				$string,
				$db['user'],
				$db['password'],
				$driver_options
			);
			if ($type === 'sqlite') {
				$this->bd->exec('PRAGMA foreign_keys = ON;');
			}
			self::$sharedBd = $this->bd;
		} catch (Exception $e) {
			throw new Minz_PDOConnectionException(
				$string,
				$db['user'], Minz_Exception::ERROR
			);
		}
	}

	public function beginTransaction() {
		$this->bd->beginTransaction();
		self::$has_transaction = true;
	}
	public function hasTransaction() {
		return self::$has_transaction;
	}
	public function commit() {
		$this->bd->commit();
		self::$has_transaction = false;
	}
	public function rollBack() {
		$this->bd->rollBack();
		self::$has_transaction = false;
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

	public function prepare($statement, $driver_options = array()) {
		MinzPDO::check($statement);
		return parent::prepare($statement, $driver_options);
	}

	public function exec($statement) {
		MinzPDO::check($statement);
		return parent::exec($statement);
	}

	public function query($statement) {
		MinzPDO::check($statement);
		return parent::query($statement);
	}
}
