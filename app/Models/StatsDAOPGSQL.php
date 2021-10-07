<?php

class FreshRSS_StatsDAOPGSQL extends FreshRSS_StatsDAO {

	/**
	 * Calculates the number of article per hour of the day per feed
	 *
	 * @param integer $feed id
	 * @return string
	 */
	public function calculateEntryRepartitionPerFeedPerHour($feed = null) {
		return $this->calculateEntryRepartitionPerFeedPerPeriod('hour', $feed);
	}

	/**
	 * Calculates the number of article per day of week per feed
	 *
	 * @param integer $feed id
	 * @return string
	 */
	public function calculateEntryRepartitionPerFeedPerDayOfWeek($feed = null) {
		return $this->calculateEntryRepartitionPerFeedPerPeriod('day', $feed);
	}

	/**
	 * Calculates the number of article per month per feed
	 *
	 * @param integer $feed
	 * @return string
	 */
	public function calculateEntryRepartitionPerFeedPerMonth($feed = null) {
		return $this->calculateEntryRepartitionPerFeedPerPeriod('month', $feed);
	}

	/**
	 * Calculates the number of article per period per feed
	 *
	 * @param string $period format string to use for grouping
	 * @param integer $feed id
	 * @return string
	 */
	protected function calculateEntryRepartitionPerFeedPerPeriod($period, $feed = null) {
		$restrict = '';
		if ($feed) {
			$restrict = "WHERE e.id_feed = {$feed}";
		}
		$sql = <<<SQL
SELECT extract( {$period} from to_timestamp(e.date)) AS period
, COUNT(1) AS count
FROM `_entry` AS e
{$restrict}
GROUP BY period
ORDER BY period ASC
SQL;

		$stm = $this->pdo->query($sql);
		$res = $stm->fetchAll(PDO::FETCH_NAMED);

		switch ($period) {
			case 'hour':
				$periodMax = 23;
				break;
			case 'day':
				$periodMax = 6;
				break;
			case 'month':
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
