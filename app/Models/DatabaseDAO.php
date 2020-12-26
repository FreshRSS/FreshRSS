<?php

/**
 * This class is used to test database is well-constructed.
 */
class FreshRSS_DatabaseDAO extends Minz\ModelPdo {

	//MySQL error codes
	const ER_BAD_FIELD_ERROR = '42S22';
	const ER_BAD_TABLE_ERROR = '42S02';
	const ER_DATA_TOO_LONG = '1406';

	//MySQL InnoDB maximum index length for UTF8MB4
	//https://dev.mysql.com/doc/refman/8.0/en/innodb-restrictions.html
	const LENGTH_INDEX_UNICODE = 191;

	public function create() {
		require(APP_PATH . '/SQL/install.sql.' . $this->pdo->dbType() . '.php');
		$db = FreshRSS_Context::$system_conf->db;

		try {
			$sql = sprintf($SQL_CREATE_DB, empty($db['base']) ? '' : $db['base']);
			return $this->pdo->exec($sql) === false ? 'Error during CREATE DATABASE' : '';
		} catch (Exception $e) {
			syslog(LOG_DEBUG, __method__ . ' notice: ' . $e->getMessage());
			return $e->getMessage();
		}
	}

	public function testConnection() {
		try {
			$sql = 'SELECT 1';
			$stm = $this->pdo->query($sql);
			$res = $stm->fetchAll(PDO::FETCH_COLUMN, 0);
			return $res == false ? 'Error during SQL connection test!' : '';
		} catch (Exception $e) {
			syslog(LOG_DEBUG, __method__ . ' warning: ' . $e->getMessage());
			return $e->getMessage();
		}
	}

	public function tablesAreCorrect() {
		$stm = $this->pdo->query('SHOW TABLES');
		$res = $stm->fetchAll(PDO::FETCH_ASSOC);

		$tables = array(
			$this->pdo->prefix() . 'category' => false,
			$this->pdo->prefix() . 'feed' => false,
			$this->pdo->prefix() . 'entry' => false,
			$this->pdo->prefix() . 'entrytmp' => false,
			$this->pdo->prefix() . 'tag' => false,
			$this->pdo->prefix() . 'entrytag' => false,
		);
		foreach ($res as $value) {
			$tables[array_pop($value)] = true;
		}

		return count(array_keys($tables, true, true)) == count($tables);
	}

	public function getSchema($table) {
		$sql = 'DESC `_' . $table . '`';
		$stm = $this->pdo->query($sql);
		return $this->listDaoToSchema($stm->fetchAll(PDO::FETCH_ASSOC));
	}

	public function checkTable($table, $schema) {
		$columns = $this->getSchema($table);

		$ok = (count($columns) == count($schema));
		foreach ($columns as $c) {
			$ok &= in_array($c['name'], $schema);
		}

		return $ok;
	}

	public function categoryIsCorrect() {
		return $this->checkTable('category', array(
			'id', 'name',
		));
	}

	public function feedIsCorrect() {
		return $this->checkTable('feed', array(
			'id', 'url', 'category', 'name', 'website', 'description', 'lastUpdate',
			'priority', 'pathEntries', 'httpAuth', 'error', 'ttl', 'attributes',
			'cache_nbEntries', 'cache_nbUnreads',
		));
	}

	public function entryIsCorrect() {
		return $this->checkTable('entry', array(
			'id', 'guid', 'title', 'author', 'content_bin', 'link', 'date', 'lastSeen', 'hash', 'is_read',
			'is_favorite', 'id_feed', 'tags',
		));
	}

	public function entrytmpIsCorrect() {
		return $this->checkTable('entrytmp', array(
			'id', 'guid', 'title', 'author', 'content_bin', 'link', 'date', 'lastSeen', 'hash', 'is_read',
			'is_favorite', 'id_feed', 'tags',
		));
	}

	public function tagIsCorrect() {
		return $this->checkTable('tag', array(
			'id', 'name', 'attributes',
		));
	}

	public function entrytagIsCorrect() {
		return $this->checkTable('entrytag', array(
			'id_tag', 'id_entry',
		));
	}

	public function daoToSchema($dao) {
		return array(
			'name' => $dao['Field'],
			'type' => strtolower($dao['Type']),
			'notnull' => (bool)$dao['Null'],
			'default' => $dao['Default'],
		);
	}

	public function listDaoToSchema($listDAO) {
		$list = array();

		foreach ($listDAO as $dao) {
			$list[] = $this->daoToSchema($dao);
		}

		return $list;
	}

	public function size($all = false) {
		$db = FreshRSS_Context::$system_conf->db;
		$sql = 'SELECT SUM(data_length + index_length) FROM information_schema.TABLES WHERE table_schema=?';	//MySQL
		$values = array($db['base']);
		if (!$all) {
			$sql .= ' AND table_name LIKE ?';
			$values[] = $this->pdo->prefix() . '%';
		}
		$stm = $this->pdo->prepare($sql);
		$stm->execute($values);
		$res = $stm->fetchAll(PDO::FETCH_COLUMN, 0);
		return $res[0];
	}

	public function optimize() {
		$ok = true;
		$tables = array('category', 'feed', 'entry', 'entrytmp', 'tag', 'entrytag');

		foreach ($tables as $table) {
			$sql = 'OPTIMIZE TABLE `_' . $table . '`';	//MySQL
			$stm = $this->pdo->query($sql);
			if ($stm == false || $stm->fetchAll(PDO::FETCH_ASSOC) === false) {
				$ok = false;
				$info = $stm == null ? $this->pdo->errorInfo() : $stm->errorInfo();
				Minz\Log::warning(__METHOD__ . ' error: ' . $sql . ' : ' . json_encode($info));
			}
		}
		return $ok;
	}

	public function ensureCaseInsensitiveGuids() {
		$ok = true;
		if ($this->pdo->dbType() === 'mysql') {
			include(APP_PATH . '/SQL/install.sql.mysql.php');

			$ok = false;
			try {
				$ok = $this->pdo->exec($SQL_UPDATE_GUID_LATIN1_BIN) !== false;	//FreshRSS 1.12
			} catch (Exception $e) {
				$ok = false;
				Minz\Log::error(__METHOD__ . ' error: ' . $e->getMessage());
			}
		}
		return $ok;
	}

	public function minorDbMaintenance() {
		$catDAO = FreshRSS_Factory::createCategoryDao();
		$catDAO->resetDefaultCategoryName();

		$this->ensureCaseInsensitiveGuids();
	}

	private static function stdError($error) {
		if (defined('STDERR')) {
			fwrite(STDERR, $error . "\n");
		}
		Minz\Log::error($error);
		return false;
	}

	const SQLITE_EXPORT = 1;
	const SQLITE_IMPORT = 2;

	public function dbCopy($filename, $mode, $clearFirst = false) {
		$error = '';

		$userDAO = FreshRSS_Factory::createUserDao();
		$catDAO = FreshRSS_Factory::createCategoryDao();
		$feedDAO = FreshRSS_Factory::createFeedDao();
		$entryDAO = FreshRSS_Factory::createEntryDao();
		$tagDAO = FreshRSS_Factory::createTagDao();

		switch ($mode) {
			case self::SQLITE_EXPORT:
				if (@filesize($filename) > 0) {
					$error = 'Error: SQLite export file already exists: ' . $filename;
				}
				break;
			case self::SQLITE_IMPORT:
				if (!is_readable($filename)) {
					$error = 'Error: SQLite import file is not readable: ' . $filename;
				} elseif ($clearFirst) {
					$userDAO->deleteUser();
					if ($this->pdo->dbType() === 'sqlite') {
						//We cannot just delete the .sqlite file otherwise PDO gets buggy.
						//SQLite is the only one with database-level optimization, instead of at table level.
						$this->optimize();
					}
				} else {
					$nbEntries = $entryDAO->countUnreadRead();
					if (!empty($nbEntries['all'])) {
						$error = 'Error: Destination database already contains some entries!';
					}
				}
				break;
			default:
				$error = 'Invalid copy mode!';
				break;
		}
		if ($error != '') {
			return self::stdError($error);
		}

		$sqlite = null;

		try {
			$sqlite = new MinzPDOSQLite('sqlite:' . $filename);
		} catch (Exception $e) {
			$error = 'Error while initialising SQLite copy: ' . $e->getMessage();
			return self::stdError($error);
		}

		Minz\ModelPdo::clean();
		$userDAOSQLite = new FreshRSS_UserDAO('', $sqlite);
		$categoryDAOSQLite = new FreshRSS_CategoryDAOSQLite('', $sqlite);
		$feedDAOSQLite = new FreshRSS_FeedDAOSQLite('', $sqlite);
		$entryDAOSQLite = new FreshRSS_EntryDAOSQLite('', $sqlite);
		$tagDAOSQLite = new FreshRSS_TagDAOSQLite('', $sqlite);

		switch ($mode) {
			case self::SQLITE_EXPORT:
				$userFrom = $userDAO; $userTo = $userDAOSQLite;
				$catFrom = $catDAO; $catTo = $categoryDAOSQLite;
				$feedFrom = $feedDAO; $feedTo = $feedDAOSQLite;
				$entryFrom = $entryDAO; $entryTo = $entryDAOSQLite;
				$tagFrom = $tagDAO; $tagTo = $tagDAOSQLite;
				break;
			case self::SQLITE_IMPORT:
				$userFrom = $userDAOSQLite; $userTo = $userDAO;
				$catFrom = $categoryDAOSQLite; $catTo = $catDAO;
				$feedFrom = $feedDAOSQLite; $feedTo = $feedDAO;
				$entryFrom = $entryDAOSQLite; $entryTo = $entryDAO;
				$tagFrom = $tagDAOSQLite; $tagTo = $tagDAO;
				break;
		}

		$idMaps = [];

		if (defined('STDERR')) {
			fwrite(STDERR, "Start SQL copy…\n");
		}

		$userTo->createUser();

		$catTo->beginTransaction();
		foreach ($catFrom->selectAll() as $category) {
			$cat = $catTo->searchByName($category['name']);	//Useful for the default category
			if ($cat != null) {
				$catId = $cat->id();
			} else {
				$catId = $catTo->addCategory($category);
				if ($catId == false) {
					$error = 'Error during SQLite copy of categories!';
					return self::stdError($error);
				}
			}
			$idMaps['c' . $category['id']] = $catId;
		}
		foreach ($feedFrom->selectAll() as $feed) {
			$feed['category'] = empty($idMaps['c' . $feed['category']]) ? FreshRSS_CategoryDAO::DEFAULTCATEGORYID : $idMaps['c' . $feed['category']];
			$feedId = $feedTo->addFeed($feed);
			if ($feedId == false) {
				$error = 'Error during SQLite copy of feeds!';
				return self::stdError($error);
			}
			$idMaps['f' . $feed['id']] = $feedId;
		}
		$catTo->commit();

		$nbEntries = $entryFrom->count();
		$n = 0;
		$entryTo->beginTransaction();
		foreach ($entryFrom->selectAll() as $entry) {
			$n++;
			if (!empty($idMaps['f' . $entry['id_feed']])) {
				$entry['id_feed'] = $idMaps['f' . $entry['id_feed']];
				if (!$entryTo->addEntry($entry, false)) {
					$error = 'Error during SQLite copy of entries!';
					return self::stdError($error);
				}
			}
			if ($n % 100 === 1 && defined('STDERR')) {	//Display progression
				fwrite(STDERR, "\033[0G" . $n . '/' . $nbEntries);
			}
		}
		if (defined('STDERR')) {
			fwrite(STDERR, "\033[0G" . $n . '/' . $nbEntries . "\n");
		}
		$entryTo->commit();
		$feedTo->updateCachedValues();

		$idMaps = [];

		$tagTo->beginTransaction();
		foreach ($tagFrom->selectAll() as $tag) {
			$tagId = $tagTo->addTag($tag);
			if ($tagId == false) {
				$error = 'Error during SQLite copy of tags!';
				return self::stdError($error);
			}
			$idMaps['t' . $tag['id']] = $tagId;
		}
		foreach ($tagFrom->selectEntryTag() as $entryTag) {
			if (!empty($idMaps['t' . $entryTag['id_tag']])) {
				$entryTag['id_tag'] = $idMaps['t' . $entryTag['id_tag']];
				if (!$tagTo->tagEntry($entryTag['id_tag'], $entryTag['id_entry'])) {
					$error = 'Error during SQLite copy of entry-tags!';
					return self::stdError($error);
				}
			}
		}
		$tagTo->commit();

		return true;
	}
}
