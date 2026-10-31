<?php
declare(strict_types=1);

class FreshRSS_FeedDAOSQLite extends FreshRSS_FeedDAOPGSQL {

	#[\Override]
	public function sqlResetSequence(): bool {
		return true;	// Nothing to do for SQLite
	}

	/** @param array{0:string,1:int,2:string} $errorInfo */
	#[\Override]
	public function autoUpdateDb(array $errorInfo): bool {
		$columns = $this->fetchColumn("PRAGMA table_info('feed')", 1);
		if ($columns !== null) {
			foreach (['kind'] as $column) {
				if (!in_array($column, $columns, true)) {
					return $this->addColumn($column);
				}
			}
		}
		return false;
	}
}
