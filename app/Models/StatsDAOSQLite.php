<?php

class FreshRSS_StatsDAOSQLite extends FreshRSS_StatsDAO {

	/**
	 * Calculates entry count per day on a 30 days period.
	 * Returns the result as a JSON string.
	 *
	 * @return string
	 */
	public function calculateEntryCount() {
		$count = $this->initEntryCountArray();
		$period = parent::ENTRY_COUNT_PERIOD;

		// Get stats per day for the last 30 days
		$sql = <<<SQL
SELECT round(julianday(e.date, 'unixepoch') - julianday('now')) AS day,
COUNT(1) AS count
FROM {$this->prefix}entry AS e
WHERE strftime('%Y%m%d', e.date, 'unixepoch')
	BETWEEN strftime('%Y%m%d', 'now', '-{$period} days')
	AND strftime('%Y%m%d', 'now', '-1 day')
GROUP BY day
ORDER BY day ASC
SQL;
		$stm = $this->bd->prepare($sql);
		$stm->execute();
		$res = $stm->fetchAll(PDO::FETCH_ASSOC);

		foreach ($res as $value) {
			$count[(int)$value['day']] = (int) $value['count'];
		}

		return $this->convertToSerie($count);
	}

}
