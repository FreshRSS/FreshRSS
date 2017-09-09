<?php

class FreshRSS_CategoryDAO extends Minz_ModelPdo implements FreshRSS_Searchable {

	const DEFAULTCATEGORYID = 1;

	public function addCategory($valuesTmp) {
		$sql = 'INSERT INTO `' . $this->prefix . 'category`(name) VALUES(?)';
		$stm = $this->bd->prepare($sql);

		$values = array(
			substr($valuesTmp['name'], 0, 255),
		);

		if ($stm && $stm->execute($values)) {
			return $this->bd->lastInsertId('"' . $this->prefix . 'category_id_seq"');
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
		$sql = 'UPDATE `' . $this->prefix . 'category` SET name=? WHERE id=?';
		$stm = $this->bd->prepare($sql);

		$values = array(
			$valuesTmp['name'],
			$id
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
		$sql = 'DELETE FROM `' . $this->prefix . 'category` WHERE id=?';
		$stm = $this->bd->prepare($sql);

		$values = array($id);

		if ($stm && $stm->execute($values)) {
			return $stm->rowCount();
		} else {
			$info = $stm == null ? array(2 => 'syntax error') : $stm->errorInfo();
			Minz_Log::error('SQL error deleteCategory: ' . $info[2]);
			return false;
		}
	}

	public function searchById($id) {
		$sql = 'SELECT * FROM `' . $this->prefix . 'category` WHERE id=?';
		$stm = $this->bd->prepare($sql);

		$values = array($id);

		$stm->execute($values);
		$res = $stm->fetchAll(PDO::FETCH_ASSOC);
		$cat = self::daoToCategory($res);

		if (isset($cat[0])) {
			return $cat[0];
		} else {
			return null;
		}
	}
	public function searchByName($name) {
		$sql = 'SELECT * FROM `' . $this->prefix . 'category` WHERE name=?';
		$stm = $this->bd->prepare($sql);

		$values = array($name);

		$stm->execute($values);
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
			     . ($details ? 'f.* ' : 'f.id, f.name, f.url, f.website, f.priority, f.error, f.`cache_nbEntries`, f.`cache_nbUnreads` ')
			     . 'FROM `' . $this->prefix . 'category` c '
			     . 'LEFT OUTER JOIN `' . $this->prefix . 'feed` f ON f.category=c.id '
			     . 'GROUP BY f.id, c_id '
			     . 'ORDER BY c.name, f.name';
			$stm = $this->bd->prepare($sql);
			$stm->execute();
			return self::daoToCategoryPrepopulated($stm->fetchAll(PDO::FETCH_ASSOC));
		} else {
			$sql = 'SELECT * FROM `' . $this->prefix . 'category` ORDER BY name';
			$stm = $this->bd->prepare($sql);
			$stm->execute();
			return self::daoToCategory($stm->fetchAll(PDO::FETCH_ASSOC));
		}
	}

	public function getDefault() {
		$sql = 'SELECT * FROM `' . $this->prefix . 'category` WHERE id=' . self::DEFAULTCATEGORYID;
		$stm = $this->bd->prepare($sql);

		$stm->execute();
		$res = $stm->fetchAll(PDO::FETCH_ASSOC);
		$cat = self::daoToCategory($res);

		if (isset($cat[0])) {
			return $cat[0];
		} else {
			return false;
		}
	}
	public function checkDefault() {
		$def_cat = $this->searchById(self::DEFAULTCATEGORYID);

		if ($def_cat == null) {
			$cat = new FreshRSS_Category(_t('gen.short.default_category'));
			$cat->_id(self::DEFAULTCATEGORYID);

			$values = array(
				'id' => $cat->id(),
				'name' => $cat->name(),
			);

			$this->addCategory($values);
		}
	}

	public function count() {
		$sql = 'SELECT COUNT(*) AS count FROM `' . $this->prefix . 'category`';
		$stm = $this->bd->prepare($sql);
		$stm->execute();
		$res = $stm->fetchAll(PDO::FETCH_ASSOC);

		return $res[0]['count'];
	}

	public function countFeed($id) {
		$sql = 'SELECT COUNT(*) AS count FROM `' . $this->prefix . 'feed` WHERE category=?';
		$stm = $this->bd->prepare($sql);
		$values = array($id);
		$stm->execute($values);
		$res = $stm->fetchAll(PDO::FETCH_ASSOC);

		return $res[0]['count'];
	}

	public function countNotRead($id) {
		$sql = 'SELECT COUNT(*) AS count FROM `' . $this->prefix . 'entry` e INNER JOIN `' . $this->prefix . 'feed` f ON e.id_feed=f.id WHERE category=? AND e.is_read=0';
		$stm = $this->bd->prepare($sql);
		$values = array($id);
		$stm->execute($values);
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
			$list[$key] = $cat;
		}

		return $list;
	}
}
