<?php

/**
 * This class is used to test database is well-constructed.
 */
class FreshRSS_DatabaseDAO extends Minz_ModelPdo {

	//MySQL error codes
	const ER_BAD_FIELD_ERROR = '42S22';
	const ER_BAD_TABLE_ERROR = '42S02';
	const ER_TRUNCATED_WRONG_VALUE_FOR_FIELD = '1366';

	//MySQL InnoDB maximum index length for UTF8MB4
	//https://dev.mysql.com/doc/refman/8.0/en/innodb-restrictions.html
	const LENGTH_INDEX_UNICODE = 191;

	public function tablesAreCorrect() {
		$sql = 'SHOW TABLES';
		$stm = $this->bd->prepare($sql);
		$stm->execute();
		$res = $stm->fetchAll(PDO::FETCH_ASSOC);

		$tables = array(
			$this->prefix . 'category' => false,
			$this->prefix . 'feed' => false,
			$this->prefix . 'entry' => false,
			$this->prefix . 'entrytmp' => false,
			$this->prefix . 'tag' => false,
			$this->prefix . 'entrytag' => false,
		);
		foreach ($res as $value) {
			$tables[array_pop($value)] = true;
		}

		return count(array_keys($tables, true, true)) == count($tables);
	}

	public function getSchema($table) {
		$sql = 'DESC ' . $this->prefix . $table;
		$stm = $this->bd->prepare($sql);
		$stm->execute();

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
			'priority', 'pathEntries', 'httpAuth', 'error', 'keep_history', 'ttl', 'attributes',
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
			$values[] = $this->prefix . '%';
		}
		$stm = $this->bd->prepare($sql);
		$stm->execute($values);
		$res = $stm->fetchAll(PDO::FETCH_COLUMN, 0);
		return $res[0];
	}

	public function optimize() {
		$ok = true;
		$tables = array('category', 'feed', 'entry', 'entrytmp', 'tag', 'entrytag');

		foreach ($tables as $table) {
			$sql = 'OPTIMIZE TABLE `' . $this->prefix . $table . '`';	//MySQL
			$stm = $this->bd->prepare($sql);
			$ok &= $stm != false;
			if ($stm) {
				$ok &= $stm->execute();
			}
		}
		return $ok;
	}

	public function ensureCaseInsensitiveGuids() {
		$ok = true;
		$db = FreshRSS_Context::$system_conf->db;
		if ($db['type'] === 'mysql') {
			include_once(APP_PATH . '/SQL/install.sql.mysql.php');
			if (defined('SQL_UPDATE_GUID_LATIN1_BIN')) {	//FreshRSS 1.12
				try {
					$sql = sprintf(SQL_UPDATE_GUID_LATIN1_BIN, $this->prefix);
					$stm = $this->bd->prepare($sql);
					$ok = $stm->execute();
				} catch (Exception $e) {
					$ok = false;
					Minz_Log::error('FreshRSS_DatabaseDAO::ensureCaseInsensitiveGuids error: ' . $e->getMessage());
				}
			}
		}
		return $ok;
	}

	public function minorDbMaintenance() {
		$this->ensureCaseInsensitiveGuids();
	}

	const SQLITE_EXPORT = 1;
	const SQLITE_IMPORT = 2;

	public function dbCopy($filename, $mode) {
		$error = '';

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
				} else {
					$nbEntries = $entryDAO->countUnreadRead();
					if ($nbEntries['all'] > 0) {
						$error = 'Error: Destination database already contains some entries!';
					}
				}
				break;
			default:
				$error = 'Invalid copy mode!';
				break;
		}
		if ($error != '') {
			goto done;
		}

		$sqlite = null;

		try {
			$sqlite = new MinzPDOSQLite('sqlite:' . $filename);
			$sqlite->exec('PRAGMA foreign_keys = ON;');

			if ($mode === self::SQLITE_EXPORT) {
				require_once(APP_PATH . '/SQL/install.sql.sqlite.php');

				global $SQL_CREATE_TABLES, $SQL_CREATE_TABLE_ENTRYTMP, $SQL_CREATE_TABLE_TAGS;
				if (is_array($SQL_CREATE_TABLES)) {
					$instructions = array_merge($SQL_CREATE_TABLES, $SQL_CREATE_TABLE_ENTRYTMP, $SQL_CREATE_TABLE_TAGS,
					array('DELETE FROM entrytag', 'DELETE FROM tag', 'DELETE FROM entrytmp', 'DELETE FROM entry',
					'DELETE FROM feed', 'DELETE FROM category'));
					foreach ($instructions as $instruction) {
						$sql = sprintf($instruction, '', _t('gen.short.default_category'));
						$stm = $sqlite->prepare($sql);
						$stm->execute();
					}
				}
			}
		} catch (Exception $e) {
			$error .= ' Error while initialising SQLite copy: ' . $e->getMessage();
			goto done;
		}

		Minz_ModelPdo::clean();
		$categoryDAOSQLite = new FreshRSS_CategoryDAO('', '', $sqlite);
		$feedDAOSQLite = new FreshRSS_FeedDAOSQLite('', '', $sqlite);
		$entryDAOSQLite = new FreshRSS_EntryDAOSQLite('', '', $sqlite);
		$tagDAOSQLite = new FreshRSS_TagDAOSQLite('', '', $sqlite);

		switch ($mode) {
			case self::SQLITE_EXPORT:
				$catFrom = $catDAO; $catTo = $categoryDAOSQLite;
				$feedFrom = $feedDAO; $feedTo = $feedDAOSQLite;
				$entryFrom = $entryDAO; $entryTo = $entryDAOSQLite;
				$tagFrom = $tagDAO; $tagTo = $tagDAOSQLite;
				break;
			case self::SQLITE_IMPORT:
				$catFrom = $categoryDAOSQLite; $catTo = $catDAO;
				$feedFrom = $feedDAOSQLite; $feedTo = $feedDAO;
				$entryFrom = $entryDAOSQLite; $entryTo = $entryDAO;
				$tagFrom = $tagDAOSQLite; $tagTo = $tagDAO;
				break;
		}

		$idMaps = [];

		$catTo->beginTransaction();
		foreach ($catFrom->select() as $category) {
			$catId = $catTo->addCategory($category);
			if ($catId == false) {
				$error .= ' Error during SQLite copy of categories!';
				goto done;
			}
			$idMaps['c' . $category['id']] = $catId;
		}
		foreach ($feedFrom->select() as $feed) {
			$feed['category'] = empty($idMaps['c' . $feed['category']]) ?
				FreshRSS_CategoryDAO::DEFAULTCATEGORYID : $idMaps['c' . $feed['category']];
			$feedId = $feedTo->addFeed($feed);
			if ($feedId == false) {
				$error .= ' Error during SQLite copy of feeds!';
				goto done;
			}
			$idMaps['f' . $feed['id']] = $feedId;
		}
		$catTo->commit();

		$nbEntries = $entryFrom->countUnreadRead();
		$total = $nbEntries['all'];
		$n = 0;
		$entryTo->beginTransaction();
		foreach ($entryFrom->select() as $entry) {
			$n++;
			if (!empty($idMaps['f' . $entry['id_feed']])) {
				$entry['id_feed'] = $idMaps['f' . $entry['id_feed']];
				if (!$entryTo->addEntry($entry, false)) {
					$error .= ' Error during SQLite copy of entries!';
					goto done;
				}
			}
			if ($n % 100 === 1 && defined('STDERR')) {
				fwrite(STDERR, "\033[0G" . $n . '/' . $total);
				sleep(1);
			}
		}
		if (defined('STDERR')) {
			fwrite(STDERR, "\033[0G" . $n . '/' . $total . "\n");
		}
		$entryTo->commit();
		$feedTo->updateCachedValues();

		$idMaps = [];

		$tagTo->beginTransaction();
		foreach ($tagFrom->select() as $tag) {
			$tagId = $tagTo->addTag($tag);
			if ($tagId == false) {
				$error .= ' Error during SQLite copy of tags!';
				goto done;
			}
			$idMaps['t' . $tag['id']] = $tagId;
		}
		foreach ($tagFrom->selectEntryTag() as $entryTag) {
			if (!empty($idMaps['t' . $entryTag['id_tag']])) {
				$entryTag['id_tag'] = $idMaps['t' . $entryTag['id_tag']];
				if (!$tagTo->tagEntry($entryTag['id_tag'], $entryTag['id_entry'])) {
					$error .= ' Error during SQLite copy of entry-tags!';
					goto done;
				}
			}
		}
		$tagTo->commit();

	done:
		if ($error != '') {
			if (defined('STDERR')) {
				fwrite(STDERR, $error . "\n");
			}
			Minz_Log::error($error);
			return false;
		} else {
			return true;
		}
	}
}
