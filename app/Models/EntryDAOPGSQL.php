<?php

class FreshRSS_EntryDAOPGSQL extends FreshRSS_EntryDAOSQLite {

	public function hasNativeHex(): bool {
		return true;
	}

	public function sqlHexDecode(string $x): string {
		return 'decode(' . $x . ", 'hex')";
	}

	public function sqlHexEncode(string $x): string {
		return 'encode(' . $x . ", 'hex')";
	}

	public function sqlIgnoreConflict(string $sql): string {
		return rtrim($sql, ' ;') . ' ON CONFLICT DO NOTHING';
	}

	protected function autoUpdateDb(array $errorInfo) {
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

	protected function addColumn(string $name) {
		return false;
	}

	public function commitNewEntries() {
		//TODO: Update to PostgreSQL 9.5+ syntax with ON CONFLICT DO NOTHING
		$sql = 'DO $$
DECLARE
maxrank bigint := (SELECT MAX(id) FROM `_entrytmp`);
rank bigint := (SELECT maxrank - COUNT(*) FROM `_entrytmp`);
BEGIN
	INSERT INTO `_entry`
		(id, guid, title, author, content, link, date, `lastSeen`, hash, is_read, is_favorite, id_feed, tags)
		(SELECT rank + row_number() OVER(ORDER BY date, id) AS id, guid, title, author, content,
			link, date, `lastSeen`, hash, is_read, is_favorite, id_feed, tags
			FROM `_entrytmp` AS etmp
			WHERE NOT EXISTS (
				SELECT 1 FROM `_entry` AS ereal
				WHERE (etmp.id = ereal.id) OR (etmp.id_feed = ereal.id_feed AND etmp.guid = ereal.guid))
			ORDER BY date, id);
	DELETE FROM `_entrytmp` WHERE id <= maxrank;
END $$;';
		$hadTransaction = $this->pdo->inTransaction();
		if (!$hadTransaction) {
			$this->pdo->beginTransaction();
		}
		$result = $this->pdo->exec($sql) !== false;
		if (!$hadTransaction) {
			$this->pdo->commit();
		}
		return $result;
	}
}
