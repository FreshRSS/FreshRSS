<?php

class FreshRSS_CategoryDAO extends Minz_ModelPdo implements FreshRSS_Searchable {

	const DEFAULTCATEGORYID = 1;

	public function addCategory($valuesTmp) {
		$sql = 'INSERT INTO `_category`(name) '
		     . 'SELECT * FROM (SELECT TRIM(?)) c2 '	//TRIM() to provide a type hint as text for PostgreSQL
		     . 'WHERE NOT EXISTS (SELECT 1 FROM `_tag` WHERE name = TRIM(?))';	//No tag of the same name
		$stm = $this->pdo->prepare($sql);

		$valuesTmp['name'] = mb_strcut(trim($valuesTmp['name']), 0, FreshRSS_DatabaseDAO::LENGTH_INDEX_UNICODE, 'UTF-8');
		$values = array(
			$valuesTmp['name'],
			$valuesTmp['name'],
		);

		if ($stm && $stm->execute($values)) {
			return $this->pdo->lastInsertId('`_category_id_seq`');
		} else {
			$info = $stm == null ? array(2 => 'syntax error') : $stm->errorInfo();
			Minz_Log::error('SQL error addCategory: ' . $info[2]);
			return false;
		}
	}

	public function addCategoryObject($category) {
		$cat = $this->searchByName($category->name());
		if (!$cat) {
			// Category does not exist yet in DB so we add it before continue
			$values = array(
				'name' => $category->name(),
			);
			return $this->addCategory($values);
		}

		return $cat->id();
	}

	public function updateCategory($id, $valuesTmp) {
		$sql = 'UPDATE `_category` SET name=? WHERE id=? '
		     . 'AND NOT EXISTS (SELECT 1 FROM `_tag` WHERE name = ?)';	//No tag of the same name
		$stm = $this->pdo->prepare($sql);

		$valuesTmp['name'] = mb_strcut(trim($valuesTmp['name']), 0, FreshRSS_DatabaseDAO::LENGTH_INDEX_UNICODE, 'UTF-8');
		$values = array(
			$valuesTmp['name'],
			$id,
			$valuesTmp['name'],
		);

		if ($stm && $stm->execute($values)) {
			return $stm->rowCount();
		} else {
			$info = $stm == null ? array(2 => 'syntax error') : $stm->errorInfo();
			Minz_Log::error('SQL error updateCategory: ' . $info[2]);
			return false;
		}
	}

	public function deleteCategory($id) {
		if ($id <= self::DEFAULTCATEGORYID) {
			return false;
		}
		$sql = 'DELETE FROM `_category` WHERE id=:id';
		$stm = $this->pdo->prepare($sql);
		$stm->bindParam(':id', $id, PDO::PARAM_INT);
		if ($stm && $stm->execute()) {
			return $stm->rowCount();
		} else {
			$info = $stm == null ? array(2 => 'syntax error') : $stm->errorInfo();
			Minz_Log::error('SQL error deleteCategory: ' . $info[2]);
			return false;
		}
	}

	public function selectAll() {
		$sql = 'SELECT id, name FROM `_category`';
		$stm = $this->pdo->query($sql);
		while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {
			yield $row;
		}
	}

	public function searchById($id) {
		$sql = 'SELECT * FROM `_category` WHERE id=:id';
		$stm = $this->pdo->prepare($sql);
		$stm->bindParam(':id', $id, PDO::PARAM_INT);
		$stm->execute();
		$res = $stm->fetchAll(PDO::FETCH_ASSOC);
		$cat = self::daoToCategory($res);

		if (isset($cat[0])) {
			return $cat[0];
		} else {
			return null;
		}
	}
	public function searchByName($name) {
		$sql = 'SELECT * FROM `_category` WHERE name=:name';
		$stm = $this->pdo->prepare($sql);
		if ($stm == false) {
			return false;
		}
		$stm->bindParam(':name', $name);
		$stm->execute();
		$res = $stm->fetchAll(PDO::FETCH_ASSOC);
		$cat = self::daoToCategory($res);
		if (isset($cat[0])) {
			return $cat[0];
		} else {
			return null;
		}
	}

	public function listCategories($prePopulateFeeds = true, $details = false) {
		if ($prePopulateFeeds) {
			$sql = 'SELECT c.id AS c_id, c.name AS c_name, '
			     . ($details ? 'f.* ' : 'f.id, f.name, f.url, f.website, f.priority, f.error, f.`cache_nbEntries`, f.`cache_nbUnreads`, f.ttl ')
			     . 'FROM `_category` c '
			     . 'LEFT OUTER JOIN `_feed` f ON f.category=c.id '
			     . 'WHERE f.priority >= :priority_normal '
			     . 'GROUP BY f.id, c_id '
			     . 'ORDER BY c.name, f.name';
			$stm = $this->pdo->prepare($sql);
			$stm->bindValue(':priority_normal', FreshRSS_Feed::PRIORITY_NORMAL, PDO::PARAM_INT);
			$stm->execute();
			return self::daoToCategoryPrepopulated($stm->fetchAll(PDO::FETCH_ASSOC));
		} else {
			$sql = 'SELECT * FROM `_category` ORDER BY name';
			$stm = $this->pdo->query($sql);
			return self::daoToCategory($stm->fetchAll(PDO::FETCH_ASSOC));
		}
	}

	public function getDefault() {
		$sql = 'SELECT * FROM `_category` WHERE id=:id';
		$stm = $this->pdo->prepare($sql);
		$stm->bindValue(':id', self::DEFAULTCATEGORYID, PDO::PARAM_INT);
		$stm->execute();
		$res = $stm->fetchAll(PDO::FETCH_ASSOC);
		$cat = self::daoToCategory($res);

		if (isset($cat[0])) {
			return $cat[0];
		} else {
			if (FreshRSS_Context::$isCli) {
				fwrite(STDERR, 'FreshRSS database error: Default category not found!' . "\n");
			}
			Minz_Log::error('FreshRSS database error: Default category not found!');
			return null;
		}
	}
	public function checkDefault() {
		$def_cat = $this->searchById(self::DEFAULTCATEGORYID);

		if ($def_cat == null) {
			$cat = new FreshRSS_Category(_t('gen.short.default_category'));
			$cat->_id(self::DEFAULTCATEGORYID);

			$sql = 'INSERT INTO `_category`(id, name) VALUES(?, ?)';
			if ($this->pdo->dbType() === 'pgsql') {
				//Force call to nextval()
				$sql .= ' RETURNING nextval(`_category_id_seq`);';
			}
			$stm = $this->pdo->prepare($sql);

			$values = array(
				$cat->id(),
				$cat->name(),
			);

			if ($stm && $stm->execute($values)) {
				return $this->pdo->lastInsertId('`_category_id_seq`');
			} else {
				$info = $stm == null ? array(2 => 'syntax error') : $stm->errorInfo();
				Minz_Log::error('SQL error check default category: ' . json_encode($info));
				return false;
			}
		}
		return true;
	}

	public function count() {
		$sql = 'SELECT COUNT(*) AS count FROM `_category`';
		$stm = $this->pdo->query($sql);
		$res = $stm->fetchAll(PDO::FETCH_ASSOC);
		return $res[0]['count'];
	}

	public function countFeed($id) {
		$sql = 'SELECT COUNT(*) AS count FROM `_feed` WHERE category=:id';
		$stm = $this->pdo->prepare($sql);
		$stm->bindParam(':id', $id, PDO::PARAM_INT);
		$stm->execute();
		$res = $stm->fetchAll(PDO::FETCH_ASSOC);
		return $res[0]['count'];
	}

	public function countNotRead($id) {
		$sql = 'SELECT COUNT(*) AS count FROM `_entry` e INNER JOIN `_feed` f ON e.id_feed=f.id WHERE category=:id AND e.is_read=0';
		$stm = $this->pdo->prepare($sql);
		$stm->bindParam(':id', $id, PDO::PARAM_INT);
		$stm->execute();
		$res = $stm->fetchAll(PDO::FETCH_ASSOC);
		return $res[0]['count'];
	}

	public static function findFeed($categories, $feed_id) {
		foreach ($categories as $category) {
			foreach ($category->feeds() as $feed) {
				if ($feed->id() === $feed_id) {
					return $feed;
				}
			}
		}
		return null;
	}

	public static function CountUnreads($categories, $minPriority = 0) {
		$n = 0;
		foreach ($categories as $category) {
			foreach ($category->feeds() as $feed) {
				if ($feed->priority() >= $minPriority) {
					$n += $feed->nbNotRead();
				}
			}
		}
		return $n;
	}

	public static function daoToCategoryPrepopulated($listDAO) {
		$list = array();

		if (!is_array($listDAO)) {
			$listDAO = array($listDAO);
		}

		$previousLine = null;
		$feedsDao = array();
		$feedDao = FreshRSS_Factory::createFeedDAO();
		foreach ($listDAO as $line) {
			if ($previousLine['c_id'] != null && $line['c_id'] !== $previousLine['c_id']) {
				// End of the current category, we add it to the $list
				$cat = new FreshRSS_Category(
					$previousLine['c_name'],
					$feedDao->daoToFeed($feedsDao, $previousLine['c_id'])
				);
				$cat->_id($previousLine['c_id']);
				$list[$previousLine['c_id']] = $cat;

				$feedsDao = array();	//Prepare for next category
			}

			$previousLine = $line;
			$feedsDao[] = $line;
		}

		// add the last category
		if ($previousLine != null) {
			$cat = new FreshRSS_Category(
				$previousLine['c_name'],
				$feedDao->daoToFeed($feedsDao, $previousLine['c_id'])
			);
			$cat->_id($previousLine['c_id']);
			$list[$previousLine['c_id']] = $cat;
		}

		return $list;
	}

	public static function daoToCategory($listDAO) {
		$list = array();

		if (!is_array($listDAO)) {
			$listDAO = array($listDAO);
		}

		foreach ($listDAO as $key => $dao) {
			$cat = new FreshRSS_Category(
				$dao['name']
			);
			$cat->_id($dao['id']);
			$cat->_isDefault(static::DEFAULTCATEGORYID === intval($dao['id']));
			$list[$key] = $cat;
		}

		return $list;
	}
}
