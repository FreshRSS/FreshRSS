<?php
declare(strict_types=1);

class FreshRSS_TagDAOSQLite extends FreshRSS_TagDAO {

	#[\Override]
	public static function sqlIgnoreConflict(string $sql): string {
		return str_replace('INSERT INTO ', 'INSERT OR IGNORE INTO ', $sql);
	}

	#[\Override]
	public function sqlResetSequence(): bool {
		return true;	// Nothing to do for SQLite
	}
}
