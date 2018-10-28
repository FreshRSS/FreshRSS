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
}
