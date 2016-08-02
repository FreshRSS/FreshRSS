<?php

class FreshRSS_StatsDAOPGSQL extends FreshRSS_StatsDAO {

	/**
	 * Calculates entry repartition for the selection.
	 * The repartition includes:
	 *   - total entries
	 *   - read entries
	 *   - unread entries
	 *   - favorite entries
	 *
	 * @param null|integer $feed feed id
	 * @param boolean $only_main
	 * @return array
	 */
	public function calculateEntryRepartitionPerFeed($feed = null, $only_main = false) {
		$filter = '';
		if ($only_main) {
			$filter .= 'AND f.priority = 10';
		}
		if (!is_null($feed)) {
			$filter .= "AND e.id_feed = {$feed}";
		}
		$sql = <<<SQL
SELECT COUNT(1) AS total,
COUNT(1) - SUM(case when e.is_read then 1 else 0 end) AS unread,
SUM(case when e.is_read then 1 else 0 end) AS read,
SUM(case when e.is_favorite then 1 else 0 end) AS favorite
FROM "{$this->prefix}entry" AS e
, "{$this->prefix}feed" AS f
WHERE e.id_feed = f.id
{$filter}
SQL;
		$stm = $this->bd->prepare($sql);
		$stm->execute();
		$res = $stm->fetchAll(PDO::FETCH_ASSOC);

		return $res[0];
	}

	/**
	 * Calculates entry count per day on a 30 days period.
	 * Returns the result as a JSON string.
	 *
	 * @return string
	 */
	public function calculateEntryCount() {
		$count = $this->initEntryCountArray();
		$period = self::ENTRY_COUNT_PERIOD;

		// Get stats per day for the last 30 days
		$sql = <<<SQL
SELECT to_timestamp(e.date) - NOW() AS day,
COUNT(1) AS count
FROM "{$this->prefix}entry" AS e
WHERE to_timestamp(e.date) BETWEEN NOW() - INTERVAL '{$period} DAYS' AND NOW() - INTERVAL '1 DAY'
GROUP BY day
ORDER BY day ASC
SQL;
		$stm = $this->bd->prepare($sql);
		$stm->execute();
		$res = $stm->fetchAll(PDO::FETCH_ASSOC);

		foreach ($res as $value) {
			$count[$value['day']] = (int) $value['count'];
		}

		return $this->convertToSerie($count);
	}

	/**
	 * Calculates entry average per day on a 30 days period.
	 *
	 * @return integer
	 */
	public function calculateEntryAverage() {
		$period = self::ENTRY_COUNT_PERIOD;

		// Get stats per day for the last 30 days
		$sql = <<<SQL
SELECT COUNT(1) / {$period} AS average
FROM "{$this->prefix}entry" AS e
WHERE to_timestamp(e.date) BETWEEN NOW() - INTERVAL '{$period} DAYS' AND NOW() - INTERVAL '1 DAY'
SQL;
		$stm = $this->bd->prepare($sql);
		$stm->execute();
		$res = $stm->fetch(PDO::FETCH_NAMED);

		return round($res['average'], 2);
	}

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
FROM "{$this->prefix}entry" AS e
{$restrict}
GROUP BY period
ORDER BY period ASC
SQL;

		$stm = $this->bd->prepare($sql);
		$stm->execute();
		$res = $stm->fetchAll(PDO::FETCH_NAMED);

		foreach ($res as $value) {
			$repartition[(int) $value['period']] = (int) $value['count'];
		}

		return $this->convertToSerie($repartition);
	}

	/**
	 * Calculates the average number of article per feed
	 *
	 * @param float $period number used to divide the number of day in the period
	 * @param integer $feed id
	 * @return integer
	 */
	protected function calculateEntryAveragePerFeedPerPeriod($period, $feed = null) {
		$restrict = '';
		if ($feed) {
			$restrict = "WHERE e.id_feed = {$feed}";
		}
		$sql = <<<SQL
SELECT COUNT(1) AS count
, MIN(date) AS date_min
, MAX(date) AS date_max
FROM "{$this->prefix}entry" AS e
{$restrict}
SQL;
		$stm = $this->bd->prepare($sql);
		$stm->execute();
		$res = $stm->fetch(PDO::FETCH_NAMED);
		$date_min = new \DateTime();
		$date_min->setTimestamp($res['date_min']);
		$date_max = new \DateTime();
		$date_max->setTimestamp($res['date_max']);
		$interval = $date_max->diff($date_min, true);
		$interval_in_days = $interval->format('%a');
		if ($interval_in_days <= 0) {
			// Surely only one article.
			// We will return count / (period/period) == count.
			$interval_in_days = $period;
		}

		return $res['count'] / ($interval_in_days / $period);
	}

}
