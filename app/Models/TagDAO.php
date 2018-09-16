<?php

class FreshRSS_TagDAO extends Minz_ModelPdo implements FreshRSS_Searchable {

	public function createTagTable() {
		$ok = false;
		$hadTransaction = $this->bd->inTransaction();
		if ($hadTransaction) {
			$this->bd->commit();
		}
		try {
			$db = FreshRSS_Context::$system_conf->db;
			require_once(APP_PATH . '/SQL/install.sql.' . $db['type'] . '.php');
			Minz_Log::warning('SQL CREATE TABLE tag...');
			if (defined('SQL_CREATE_TABLE_TAGS')) {
				$sql = sprintf(SQL_CREATE_TABLE_TAGS, $this->prefix);
				$stm = $this->bd->prepare($sql);
				$ok = $stm && $stm->execute();
			} else {
				global $SQL_CREATE_TABLE_TAGS;
				$ok = !empty($SQL_CREATE_TABLE_TAGS);
				foreach ($SQL_CREATE_TABLE_TAGS as $instruction) {
					$sql = sprintf($instruction, $this->prefix);
					$stm = $this->bd->prepare($sql);
					$ok &= $stm && $stm->execute();
				}
			}
		} catch (Exception $e) {
			Minz_Log::error('FreshRSS_EntryDAO::createTagTable error: ' . $e->getMessage());
		}
		if ($hadTransaction) {
			$this->bd->beginTransaction();
		}
		return $ok;
	}

	protected function autoUpdateDb($errorInfo) {
		if (isset($errorInfo[0])) {
			if ($errorInfo[0] === '42S02' || $errorInfo[0] === '42P01') {	//ER_BAD_TABLE_ERROR (MySQL) or undefined_table (PostgreSQL)
				if (stripos($errorInfo[2], 'tag') !== false) {
					return $this->createTagTable();	//v1.12.0
				}
			}
		}
		return false;
	}

	public function addTag($valuesTmp) {
		$sql = 'INSERT INTO `' . $this->prefix . 'tag`(name) VALUES(?)';
		$stm = $this->bd->prepare($sql);

		$values = array(
			mb_strcut($valuesTmp['name'], 0, 63, 'UTF-8'),
		);

		if ($stm && $stm->execute($values)) {
			return $this->bd->lastInsertId('"' . $this->prefix . 'tag_id_seq"');
		} else {
			$info = $stm == null ? array(2 => 'syntax error') : $stm->errorInfo();
			Minz_Log::error('SQL error addTag: ' . $info[2]);
			return false;
		}
	}

	public function addTagObject($tag) {
		$tag = $this->searchByName($tag->name());
		if (!$tag) {
			$values = array(
				'name' => $tag->name(),
			);
			return $this->addTag($values);
		}
		return $tag->id();
	}

	public function updateTag($id, $valuesTmp) {
		$sql = 'UPDATE `' . $this->prefix . 'tag` SET name=? WHERE id=?';
		$stm = $this->bd->prepare($sql);

		$values = array(
			$valuesTmp['name'],
			$id,
		);

		if ($stm && $stm->execute($values)) {
			return $stm->rowCount();
		} else {
			$info = $stm == null ? array(2 => 'syntax error') : $stm->errorInfo();
			Minz_Log::error('SQL error updateTag: ' . $info[2]);
			return false;
		}
	}

	public function deleteTag($id) {
		if ($id <= 0) {
			return false;
		}
		$sql = 'DELETE FROM `' . $this->prefix . 'tag` WHERE id=?';
		$stm = $this->bd->prepare($sql);

		$values = array($id);

		if ($stm && $stm->execute($values)) {
			return $stm->rowCount();
		} else {
			$info = $stm == null ? array(2 => 'syntax error') : $stm->errorInfo();
			Minz_Log::error('SQL error deleteTag: ' . $info[2]);
			return false;
		}
	}

	public function searchById($id) {
		$sql = 'SELECT * FROM `' . $this->prefix . 'tag` WHERE id=?';
		$stm = $this->bd->prepare($sql);
		$values = array($id);
		$stm->execute($values);
		$res = $stm->fetchAll(PDO::FETCH_ASSOC);
		$tag = self::daoToTag($res);
		return isset($tag[0]) ? $tag[0] : null;
	}

	public function searchByName($name) {
		$sql = 'SELECT * FROM `' . $this->prefix . 'tag` WHERE name=?';
		$stm = $this->bd->prepare($sql);
		$values = array($name);
		$stm->execute($values);
		$res = $stm->fetchAll(PDO::FETCH_ASSOC);
		$tag = self::daoToTag($res);
		return isset($tag[0]) ? $tag[0] : null;
	}

	public function listTags($precounts = false) {
		if ($precounts) {
			$sql = 'SELECT t.id, t.name, count(e.id) AS unreads '
				 . 'FROM `' . $this->prefix . 'tag` t '
				 . 'LEFT OUTER JOIN `' . $this->prefix . 'entrytag` et ON et.id_tag = t.id '
				 . 'LEFT OUTER JOIN `' . $this->prefix . 'entry` e ON et.id_entry = e.id AND e.is_read = 0 '
				 . 'GROUP BY t.id '
				 . 'ORDER BY t.name';
		} else {
			$sql = 'SELECT * FROM `' . $this->prefix . 'tag` ORDER BY name';
		}

		$stm = $this->bd->prepare($sql);
		if ($stm && $stm->execute()) {
			return self::daoToTag($stm->fetchAll(PDO::FETCH_ASSOC));
		} else {
			$info = $stm == null ? array(0 => '', 1 => '', 2 => 'syntax error') : $stm->errorInfo();
			if ($this->autoUpdateDb($info)) {
				return $this->listTags($precounts);
			}
			Minz_Log::error('SQL error listTags: ' . $info[2]);
			return false;
		}
	}

	public function count() {
		$sql = 'SELECT COUNT(*) AS count FROM `' . $this->prefix . 'tag`';
		$stm = $this->bd->prepare($sql);
		$stm->execute();
		$res = $stm->fetchAll(PDO::FETCH_ASSOC);
		return $res[0]['count'];
	}

	public function countEntries($id) {
		$sql = 'SELECT COUNT(*) AS count FROM `' . $this->prefix . 'entrytag` WHERE id_tag=?';
		$stm = $this->bd->prepare($sql);
		$values = array($id);
		$stm->execute($values);
		$res = $stm->fetchAll(PDO::FETCH_ASSOC);
		return $res[0]['count'];
	}

	public function countNotRead($id) {
		$sql = 'SELECT COUNT(*) AS count FROM `' . $this->prefix . 'entrytag` et '
			 . 'INNER JOIN `' . $this->prefix . 'entry` e ON et.id_entry=e.id '
			 . 'WHERE et.id_tag=? AND e.is_read=0';
		$stm = $this->bd->prepare($sql);
		$values = array($id);
		$stm->execute($values);
		$res = $stm->fetchAll(PDO::FETCH_ASSOC);
		return $res[0]['count'];
	}

	public static function daoToTag($listDAO) {
		$list = array();
		if (!is_array($listDAO)) {
			$listDAO = array($listDAO);
		}
		foreach ($listDAO as $key => $dao) {
			$tag = new FreshRSS_Tag(
				$dao['name']
			);
			$tag->_id($dao['id']);
			if (isset($dao['unreads'])) {
				$tag->_nbUnread($dao['unreads']);
			}
			$list[$key] = $tag;
		}
		return $list;
	}
}
