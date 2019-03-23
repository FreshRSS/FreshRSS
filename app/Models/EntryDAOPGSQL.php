<?php

class FreshRSS_EntryDAOPGSQL extends FreshRSS_EntryDAOSQLite {

	public function sqlHexDecode($x) {
		return 'decode(' . $x . ", 'hex')";
	}

	public function sqlHexEncode($x) {
		return 'encode(' . $x . ", 'hex')";
	}

	protected function autoUpdateDb($errorInfo) {
		if (isset($errorInfo[0])) {
			if ($errorInfo[0] === FreshRSS_DatabaseDAOPGSQL::UNDEFINED_TABLE) {
				if (stripos($errorInfo[2], 'tag') !== false) {
					$tagDAO = FreshRSS_Factory::createTagDao();
					return $tagDAO->createTagTable();	//v1.12.0
				} elseif (stripos($errorInfo[2], 'entrytmp') !== false) {
					return $this->createEntryTempTable();	//v1.7.0
				}
			}
		}
		return false;
	}

	protected function addColumn($name) {
		return false;
	}

	public function commitNewEntries() {
		$sql = 'DO $$
DECLARE
maxrank bigint := (SELECT MAX(id) FROM `' . $this->prefix . 'entrytmp`);
rank bigint := (SELECT maxrank - COUNT(*) FROM `' . $this->prefix . 'entrytmp`);
BEGIN
	INSERT INTO `' . $this->prefix . 'entry` (id, guid, title, author, content, link, date, `lastSeen`, hash, is_read, is_favorite, id_feed, tags)
		(SELECT rank + row_number() OVER(ORDER BY date) AS id, guid, title, author, content, link, date, `lastSeen`, hash, is_read, is_favorite, id_feed, tags
			FROM `' . $this->prefix . 'entrytmp` AS etmp
			WHERE NOT EXISTS (
				SELECT 1 FROM `' . $this->prefix . 'entry` AS ereal
				WHERE (etmp.id = ereal.id) OR (etmp.id_feed = ereal.id_feed AND etmp.guid = ereal.guid))
			ORDER BY date);
	DELETE FROM `' . $this->prefix . 'entrytmp` WHERE id <= maxrank;
END $$;';
		$hadTransaction = $this->bd->inTransaction();
		if (!$hadTransaction) {
			$this->bd->beginTransaction();
		}
		$result = $this->bd->exec($sql) !== false;
		if (!$hadTransaction) {
			$this->bd->commit();
		}
		return $result;
	}
}
