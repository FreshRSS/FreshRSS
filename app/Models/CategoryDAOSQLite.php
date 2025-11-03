<?php
declare(strict_types=1);

class FreshRSS_CategoryDAOSQLite extends FreshRSS_CategoryDAO {

	#[\Override]
	public function sqlResetSequence(): bool {
		return true;	// Nothing to do for SQLite
	}

	/** @param array{0:string,1:int,2:string} $errorInfo */
	#[\Override]
	protected function autoUpdateDb(array $errorInfo): bool {
		if (isset($errorInfo[0])) {
			$errorLines = explode("\n", $errorInfo[2], 2);	// The relevant column name is on the first line, other lines are noise
			if (str_contains($errorLines[0], 'f.')) {	// Coming from a feed sub-query
				$feedDao = FreshRSS_Factory::createFeedDao();
				if ($feedDao->autoUpdateDb($errorInfo)) {
					return true;
				}
			}
		}
		if (($tableInfo = $this->pdo->query("PRAGMA table_info('category')")) !== false) {
			$columns = $tableInfo->fetchAll(PDO::FETCH_COLUMN, 1);
			foreach (['kind', 'lastUpdate', 'error', 'attributes'] as $column) {
				if (!in_array($column, $columns, true)) {
					return $this->addColumn($column);
				}
			}
		}
		return false;
	}
}
