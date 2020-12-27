<?php

use Minz\Pdo\ModelPdo;

class FreshRSS_TagDAO extends ModelPdo implements FreshRSS_Searchable {

	public function sqlIgnore() {
		return 'IGNORE';
	}

	public function createTagTable() {
		$ok = false;
		$hadTransaction = $this->pdo->inTransaction();
		if ($hadTransaction) {
			$this->pdo->commit();
		}
		try {
			require(APP_PATH . '/SQL/install.sql.' . $this->pdo->dbType() . '.php');

			Minz\Log::warning('SQL ALTER GUID case sensitivity...');
			$databaseDAO = FreshRSS_Factory::createDatabaseDAO();
			$databaseDAO->ensureCaseInsensitiveGuids();

			Minz\Log::warning('SQL CREATE TABLE tag...');
			$ok = $this->pdo->exec($SQL_CREATE_TABLE_TAGS) !== false;
		} catch (Exception $e) {
			Minz\Log::error('FreshRSS_EntryDAO::createTagTable error: ' . $e->getMessage());
		}
		if ($hadTransaction) {
			$this->pdo->beginTransaction();
		}
		return $ok;
	}

	protected function autoUpdateDb($errorInfo) {
		if (isset($errorInfo[0])) {
			if ($errorInfo[0] === FreshRSS_DatabaseDAO::ER_BAD_TABLE_ERROR || $errorInfo[0] === FreshRSS_DatabaseDAOPGSQL::UNDEFINED_TABLE) {
				if (stripos($errorInfo[2], 'tag') !== false) {
					return $this->createTagTable();	//v1.12.0
				}
			}
		}
		return false;
	}

	public function addTag($valuesTmp) {
		$sql = 'INSERT INTO `_tag`(name, attributes) '
		     . 'SELECT * FROM (SELECT TRIM(?) as name, TRIM(?) as attributes) t2 '	//TRIM() gives a text type hint to PostgreSQL
		     . 'WHERE NOT EXISTS (SELECT 1 FROM `_category` WHERE name = TRIM(?))';	//No category of the same name
		$stm = $this->pdo->prepare($sql);

		$valuesTmp['name'] = mb_strcut(trim($valuesTmp['name']), 0, 63, 'UTF-8');
		if (!isset($valuesTmp['attributes'])) {
			$valuesTmp['attributes'] = [];
		}
		$values = array(
			$valuesTmp['name'],
			is_string($valuesTmp['attributes']) ? $valuesTmp['attributes'] : json_encode($valuesTmp['attributes'], JSON_UNESCAPED_SLASHES),
			$valuesTmp['name'],
		);

		if ($stm && $stm->execute($values)) {
			return $this->pdo->lastInsertId('`_tag_id_seq`');
		} else {
			$info = $stm == null ? $this->pdo->errorInfo() : $stm->errorInfo();
			Minz\Log::error('SQL error addTag: ' . $info[2]);
			return false;
		}
	}

	public function addTagObject($tag) {
		$tag = $this->searchByName($tag->name());
		if (!$tag) {
			$values = array(
				'name' => $tag->name(),
				'attributes' => $tag->attributes(),
			);
			return $this->addTag($values);
		}
		return $tag->id();
	}

	public function updateTag($id, $valuesTmp) {
		$sql = 'UPDATE `_tag` SET name=?, attributes=? WHERE id=? '
		     . 'AND NOT EXISTS (SELECT 1 FROM `_category` WHERE name = ?)';	//No category of the same name
		$stm = $this->pdo->prepare($sql);

		$valuesTmp['name'] = mb_strcut(trim($valuesTmp['name']), 0, 63, 'UTF-8');
		if (!isset($valuesTmp['attributes'])) {
			$valuesTmp['attributes'] = [];
		}
		$values = array(
			$valuesTmp['name'],
			is_string($valuesTmp['attributes']) ? $valuesTmp['attributes'] : json_encode($valuesTmp['attributes'], JSON_UNESCAPED_SLASHES),
			$id,
			$valuesTmp['name'],
		);

		if ($stm && $stm->execute($values)) {
			return $stm->rowCount();
		} else {
			$info = $stm == null ? $this->pdo->errorInfo() : $stm->errorInfo();
			Minz\Log::error('SQL error updateTag: ' . $info[2]);
			return false;
		}
	}

	public function updateTagAttribute($tag, $key, $value) {
		if ($tag instanceof FreshRSS_Tag) {
			$tag->_attributes($key, $value);
			return $this->updateTag(
					$tag->id(),
					[ 'attributes' => $tag->attributes() ]
				);
		}
		return false;
	}

	public function deleteTag($id) {
		if ($id <= 0) {
			return false;
		}
		$sql = 'DELETE FROM `_tag` WHERE id=?';
		$stm = $this->pdo->prepare($sql);

		$values = array($id);

		if ($stm && $stm->execute($values)) {
			return $stm->rowCount();
		} else {
			$info = $stm == null ? $this->pdo->errorInfo() : $stm->errorInfo();
			Minz\Log::error('SQL error deleteTag: ' . $info[2]);
			return false;
		}
	}

	public function selectAll() {
		$sql = 'SELECT id, name, attributes FROM `_tag`';
		$stm = $this->pdo->query($sql);
		while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {
			yield $row;
		}
	}

	public function selectEntryTag() {
		$sql = 'SELECT id_tag, id_entry FROM `_entrytag`';
		$stm = $this->pdo->query($sql);
		while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {
			yield $row;
		}
	}

	public function updateEntryTag($oldTagId, $newTagId) {
		$sql = 'DELETE FROM `_entrytag` WHERE EXISTS (SELECT 1 FROM `_entrytag` AS e WHERE e.id_entry = `_entrytag`.id_entry AND e.id_tag = ? AND `_entrytag`.id_tag = ?)';
		$stm = $this->pdo->prepare($sql);

		if (!($stm && $stm->execute([$newTagId, $oldTagId]))) {
			$info = $stm == null ? $this->pdo->errorInfo() : $stm->errorInfo();
			Minz\Log::error('SQL error moveTag: ' . $info[2]);
			return false;
		}

		$sql = 'UPDATE `_entrytag` SET id_tag = ? WHERE id_tag = ?';
		$stm = $this->pdo->prepare($sql);

		if ($stm && $stm->execute([$newTagId, $oldTagId])) {
			return $stm->rowCount();
		} else {
			$info = $stm == null ? $this->pdo->errorInfo() : $stm->errorInfo();
			Minz\Log::error('SQL error moveTag: ' . $info[2]);
			return false;
		}
	}

	public function searchById($id) {
		$sql = 'SELECT * FROM `_tag` WHERE id=?';
		$stm = $this->pdo->prepare($sql);
		$values = array($id);
		$stm->execute($values);
		$res = $stm->fetchAll(PDO::FETCH_ASSOC);
		$tag = self::daoToTag($res);
		return isset($tag[0]) ? $tag[0] : null;
	}

	public function searchByName($name) {
		$sql = 'SELECT * FROM `_tag` WHERE name=?';
		$stm = $this->pdo->prepare($sql);
		$values = array($name);
		$stm->execute($values);
		$res = $stm->fetchAll(PDO::FETCH_ASSOC);
		$tag = self::daoToTag($res);
		return isset($tag[0]) ? $tag[0] : null;
	}

	public function listTags($precounts = false) {
		if ($precounts) {
			$sql = 'SELECT t.id, t.name, count(e.id) AS unreads '
				 . 'FROM `_tag` t '
				 . 'LEFT OUTER JOIN `_entrytag` et ON et.id_tag = t.id '
				 . 'LEFT OUTER JOIN `_entry` e ON et.id_entry = e.id AND e.is_read = 0 '
				 . 'GROUP BY t.id '
				 . 'ORDER BY t.name';
		} else {
			$sql = 'SELECT * FROM `_tag` ORDER BY name';
		}

		$stm = $this->pdo->query($sql);
		if ($stm !== false) {
			return self::daoToTag($stm->fetchAll(PDO::FETCH_ASSOC));
		} else {
			$info = $stm == null ? $this->pdo->errorInfo() : $stm->errorInfo();
			if ($this->autoUpdateDb($info)) {
				return $this->listTags($precounts);
			}
			Minz\Log::error('SQL error listTags: ' . $info[2]);
			return false;
		}
	}

	public function listTagsNewestItemUsec($id_tag = null) {
		$sql = 'SELECT t.id AS id_tag, MAX(e.id) AS newest_item_us '
			 . 'FROM `_tag` t '
			 . 'LEFT OUTER JOIN `_entrytag` et ON et.id_tag = t.id '
			 . 'LEFT OUTER JOIN `_entry` e ON et.id_entry = e.id ';
		if ($id_tag === null) {
			$sql .= 'GROUP BY t.id';
		} else {
			$sql .= 'WHERE t.id=' . intval($id_tag);
		}
		$stm = $this->pdo->query($sql);
		$res = $stm->fetchAll(PDO::FETCH_ASSOC);
		$newestItemUsec = [];
		foreach ($res as $line) {
			$newestItemUsec['t_' . $line['id_tag']] = $line['newest_item_us'];
		}
		return $newestItemUsec;
	}

	public function count() {
		$sql = 'SELECT COUNT(*) AS count FROM `_tag`';
		$stm = $this->pdo->query($sql);
		if ($stm !== false) {
			$res = $stm->fetchAll(PDO::FETCH_ASSOC);
			return $res[0]['count'];
		} else {
			$info = $stm == null ? $this->pdo->errorInfo() : $stm->errorInfo();
			if ($this->autoUpdateDb($info)) {
				return $this->count();
			}
			Minz\Log::error('SQL error TagDAO::count: ' . $info[2]);
			return false;
		}
	}

	public function countEntries($id) {
		$sql = 'SELECT COUNT(*) AS count FROM `_entrytag` WHERE id_tag=?';
		$stm = $this->pdo->prepare($sql);
		$values = array($id);
		$stm->execute($values);
		$res = $stm->fetchAll(PDO::FETCH_ASSOC);
		return $res[0]['count'];
	}

	public function countNotRead($id) {
		$sql = 'SELECT COUNT(*) AS count FROM `_entrytag` et '
			 . 'INNER JOIN `_entry` e ON et.id_entry=e.id '
			 . 'WHERE et.id_tag=? AND e.is_read=0';
		$stm = $this->pdo->prepare($sql);
		$values = array($id);
		$stm->execute($values);
		$res = $stm->fetchAll(PDO::FETCH_ASSOC);
		return $res[0]['count'];
	}

	public function tagEntry($id_tag, $id_entry, $checked = true) {
		if ($checked) {
			$sql = 'INSERT ' . $this->sqlIgnore() . ' INTO `_entrytag`(id_tag, id_entry) VALUES(?, ?)';
		} else {
			$sql = 'DELETE FROM `_entrytag` WHERE id_tag=? AND id_entry=?';
		}
		$stm = $this->pdo->prepare($sql);
		$values = array($id_tag, $id_entry);

		if ($stm && $stm->execute($values)) {
			return true;
		} else {
			$info = $stm == null ? $this->pdo->errorInfo() : $stm->errorInfo();
			Minz\Log::error('SQL error tagEntry: ' . $info[2]);
			return false;
		}
	}

	public function getTagsForEntry($id_entry) {
		$sql = 'SELECT t.id, t.name, et.id_entry IS NOT NULL as checked '
			 . 'FROM `_tag` t '
			 . 'LEFT OUTER JOIN `_entrytag` et ON et.id_tag = t.id AND et.id_entry=? '
			 . 'ORDER BY t.name';

		$stm = $this->pdo->prepare($sql);
		$values = array($id_entry);

		if ($stm && $stm->execute($values)) {
			$lines = $stm->fetchAll(PDO::FETCH_ASSOC);
			for ($i = count($lines) - 1; $i >= 0; $i--) {
				$lines[$i]['id'] = intval($lines[$i]['id']);
				$lines[$i]['checked'] = !empty($lines[$i]['checked']);
			}
			return $lines;
		} else {
			$info = $stm == null ? $this->pdo->errorInfo() : $stm->errorInfo();
			if ($this->autoUpdateDb($info)) {
				return $this->getTagsForEntry($id_entry);
			}
			Minz\Log::error('SQL error getTagsForEntry: ' . $info[2]);
			return false;
		}
	}

	public function getTagsForEntries($entries) {
		$sql = 'SELECT et.id_entry, et.id_tag, t.name '
			 . 'FROM `_tag` t '
			 . 'INNER JOIN `_entrytag` et ON et.id_tag = t.id';

		$values = array();
		if (is_array($entries) && count($entries) > 0) {
			$sql .= ' AND et.id_entry IN (' . str_repeat('?,', count($entries) - 1). '?)';
			if (is_array($entries[0])) {
				foreach ($entries as $entry) {
					$values[] = $entry['id'];
				}
			} elseif (is_object($entries[0])) {
				foreach ($entries as $entry) {
					$values[] = $entry->id();
				}
			} else {
				foreach ($entries as $entry) {
					$values[] = $entry;
				}
			}
		}
		$stm = $this->pdo->prepare($sql);

		if ($stm && $stm->execute($values)) {
			return $stm->fetchAll(PDO::FETCH_ASSOC);
		} else {
			$info = $stm == null ? $this->pdo->errorInfo() : $stm->errorInfo();
			if ($this->autoUpdateDb($info)) {
				return $this->getTagsForEntries($entries);
			}
			Minz\Log::error('SQL error getTagsForEntries: ' . $info[2]);
			return false;
		}
	}

	//For API
	public function getEntryIdsTagNames($entries) {
		$result = array();
		foreach ($this->getTagsForEntries($entries) as $line) {
			$entryId = 'e_' . $line['id_entry'];
			$tagName = $line['name'];
			if (empty($result[$entryId])) {
				$result[$entryId] = array();
			}
			$result[$entryId][] = $tagName;
		}
		return $result;
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
			if (!empty($dao['attributes'])) {
				$tag->_attributes('', $dao['attributes']);
			}
			if (isset($dao['unreads'])) {
				$tag->_nbUnread($dao['unreads']);
			}
			$list[$key] = $tag;
		}
		return $list;
	}
}
