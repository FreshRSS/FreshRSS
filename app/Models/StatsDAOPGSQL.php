<?php
declare(strict_types=1);

class FreshRSS_StatsDAOPGSQL extends FreshRSS_StatsDAO {

	/**
	 * Calculates the number of article per hour of the day per feed
	 *
	 * @param int $feed id
	 * @return array<int,int>
	 */
	public function calculateEntryRepartitionPerFeedPerHour(?int $feed = null): array {
		return $this->calculateEntryRepartitionPerFeedPerPeriod('hour', $feed);
	}

	/**
	 * Calculates the number of article per day of week per feed
	 * @return array<int,int>
	 */
	public function calculateEntryRepartitionPerFeedPerDayOfWeek(?int $feed = null): array {
		return $this->calculateEntryRepartitionPerFeedPerPeriod('day', $feed);
	}

	/**
	 * Calculates the number of article per month per feed
	 * @return array<int,int>
	 */
	public function calculateEntryRepartitionPerFeedPerMonth(?int $feed = null): array {
		return $this->calculateEntryRepartitionPerFeedPerPeriod('month', $feed);
	}

	/**
	 * Calculates the number of article per period per feed
	 * @param string $period format string to use for grouping
	 * @return array<int,int>
	 */
	protected function calculateEntryRepartitionPerFeedPerPeriod(string $period, ?int $feed = null): array {
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

		$res = $this->fetchAssoc($sql);
		if ($res == null) {
			return [];
		}

		switch ($period) {
			case 'hour':
				$periodMax = 24;
				break;
			case 'day':
				$periodMax = 7;
				break;
			case 'month':
				$periodMax = 12;
				break;
			default:
			$periodMax = 30;
		}

		$repartition = array_fill(0, $periodMax, 0);
		foreach ($res as $value) {
			$repartition[(int)$value['period']] = (int)$value['count'];
		}

		return $repartition;
	}

}
