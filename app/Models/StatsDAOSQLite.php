<?php

class FreshRSS_StatsDAOSQLite extends FreshRSS_StatsDAO {

	protected function sqlFloor($s) {
		return "CAST(($s) AS INT)";
	}

	protected function calculateEntryRepartitionPerFeedPerPeriod($period, $feed = null) {
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

		$stm = $this->pdo->query($sql);
		$res = $stm->fetchAll(PDO::FETCH_NAMED);


		switch ($period) {
			case '%H':
				$periodMax = 23;
				break;
			case '%w':
				$periodMax = 6;
				break;
			case '%m':
				$periodMax = 12;
				break;
			default:
			$periodMax = 29;
		}

		$repartition = array_fill(1,$periodMax,0);
		$repartition[0] = 0;
		foreach ($res as $value) {
			$repartition[(int) $value['period']] = (int) $value['count'];
		}

		return $repartition;
	}

}
