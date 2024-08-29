<?php
declare(strict_types=1);

class FreshRSS_StatsDAOSQLite extends FreshRSS_StatsDAO {

	#[\Override]
	protected function sqlFloor(string $s): string {
		return "CAST(($s) AS INT)";
	}

	/**
	 * @return array<int,int>
	 */
	#[\Override]
	protected function calculateEntryRepartitionPerFeedPerPeriod(string $period, ?int $feed = null): array {
		if ($feed) {
			$restrict = "WHERE e.id_feed = {$feed}";
		} else {
			$restrict = '';
		}
		$sql = <<<SQL
SELECT strftime('{$period}', e.date, 'unixepoch') AS period
, COUNT(1) AS count
FROM `_entry` AS e
{$restrict}
GROUP BY period
ORDER BY period ASC
SQL;

		$res = $this->fetchAssoc($sql);
		if ($res == null) {
			return [];
		}

		$periodMax = match ($period) {
			'%H' => 24,
			'%w' => 7,
			'%m' => 12,
			default => 30,
		};

		$repartition = array_fill(0, $periodMax, 0);
		foreach ($res as $value) {
			$repartition[(int)$value['period']] = (int)$value['count'];
		}

		return $repartition;
	}
}
