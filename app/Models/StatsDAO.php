<?php

class FreshRSS_StatsDAO extends Minz_ModelPdo {

	const ENTRY_COUNT_PERIOD = 30;

	protected function sqlFloor($s) {
		return "FLOOR($s)";
	}

	/**
	 * Calculates entry repartition for all feeds and for main stream.
	 *
	 * @return array
	 */
	public function calculateEntryRepartition() {
		return array(
			'main_stream' => $this->calculateEntryRepartitionPerFeed(null, true),
			'all_feeds' => $this->calculateEntryRepartitionPerFeed(null, false),
		);
	}

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
COUNT(1) - SUM(e.is_read) AS count_unreads,
SUM(e.is_read) AS count_reads,
SUM(e.is_favorite) AS count_favorites
FROM `_entry` AS e, `_feed` AS f
WHERE e.id_feed = f.id
{$filter}
SQL;
		$stm = $this->pdo->query($sql);
		$res = $stm->fetchAll(PDO::FETCH_ASSOC);

		return $res[0];
	}

	/**
	 * Calculates entry count per day on a 30 days period.
	 *
	 * @return array
	 */
	public function calculateEntryCount() {
		$count = $this->initEntryCountArray();
		$midnight = mktime(0, 0, 0);
		$oldest = $midnight - (self::ENTRY_COUNT_PERIOD * 86400);

		// Get stats per day for the last 30 days
		$sqlDay = $this->sqlFloor("(date - $midnight) / 86400");
		$sql = <<<SQL
SELECT {$sqlDay} AS day,
COUNT(*) as count
FROM `_entry`
WHERE date >= {$oldest} AND date < {$midnight}
GROUP BY day
ORDER BY day ASC
SQL;
		$stm = $this->pdo->query($sql);
		$res = $stm->fetchAll(PDO::FETCH_ASSOC);

		foreach ($res as $value) {
			$count[$value['day']] = (int) $value['count'];
		}

		return $count;
	}

	/**
	 * Initialize an array for the entry count.
	 *
	 * @return array
	 */
	protected function initEntryCountArray() {
		return $this->initStatsArray(-self::ENTRY_COUNT_PERIOD, -1);
	}

	/**
	 * Calculates the number of article per hour of the day per feed
	 *
	 * @param integer $feed id
	 * @return string
	 */
	public function calculateEntryRepartitionPerFeedPerHour($feed = null) {
		return $this->calculateEntryRepartitionPerFeedPerPeriod('%H', $feed);
	}

	/**
	 * Calculates the number of article per day of week per feed
	 *
	 * @param integer $feed id
	 * @return string
	 */
	public function calculateEntryRepartitionPerFeedPerDayOfWeek($feed = null) {
		return $this->calculateEntryRepartitionPerFeedPerPeriod('%w', $feed);
	}

	/**
	 * Calculates the number of article per month per feed
	 *
	 * @param integer $feed
	 * @return string
	 */
	public function calculateEntryRepartitionPerFeedPerMonth($feed = null) {
		return $this->calculateEntryRepartitionPerFeedPerPeriod('%m', $feed);
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
SELECT DATE_FORMAT(FROM_UNIXTIME(e.date), '{$period}') AS period
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
				$periodMax = 7;
				break;
			case '%m':
				$periodMax = 12;
				break;
			default:
			$periodMax = 30;
		}

		$repartition = $this->initStatsArray(1, $periodMax);
		foreach ($res as $value) {
			$repartition[(int) $value['period']] = (int) $value['count'];
		}

		return $repartition;
	}

	/**
	 * Calculates the average number of article per hour per feed
	 *
	 * @param integer $feed id
	 * @return integer
	 */
	public function calculateEntryAveragePerFeedPerHour($feed = null) {
		return $this->calculateEntryAveragePerFeedPerPeriod(1 / 24, $feed);
	}

	/**
	 * Calculates the average number of article per day of week per feed
	 *
	 * @param integer $feed id
	 * @return integer
	 */
	public function calculateEntryAveragePerFeedPerDayOfWeek($feed = null) {
		return $this->calculateEntryAveragePerFeedPerPeriod(7, $feed);
	}

	/**
	 * Calculates the average number of article per month per feed
	 *
	 * @param integer $feed id
	 * @return integer
	 */
	public function calculateEntryAveragePerFeedPerMonth($feed = null) {
		return $this->calculateEntryAveragePerFeedPerPeriod(30, $feed);
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
FROM `_entry` AS e
{$restrict}
SQL;
		$stm = $this->pdo->query($sql);
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

	/**
	 * Initialize an array for statistics depending on a range
	 *
	 * @param integer $min
	 * @param integer $max
	 * @return array
	 */
	protected function initStatsArray($min, $max) {
		return array_map(function () {
			return 0;
		}, array_flip(range($min, $max)));
	}

	/**
	 * Calculates feed count per category.
	 * @return array
	 */
	public function calculateFeedByCategory() {
		$sql = <<<SQL
SELECT c.name AS label
, COUNT(f.id) AS data
FROM `_category` AS c, `_feed` AS f
WHERE c.id = f.category
GROUP BY label
ORDER BY data DESC
SQL;
		$stm = $this->pdo->query($sql);
		$res = $stm->fetchAll(PDO::FETCH_ASSOC);

		return $res;
	}

	/**
	 * Calculates entry count per category.
	 * @return array
	 */
	public function calculateEntryByCategory() {
		$sql = <<<SQL
SELECT c.name AS label
, COUNT(e.id) AS data
FROM `_category` AS c, `_feed` AS f, `_entry` AS e
WHERE c.id = f.category
AND f.id = e.id_feed
GROUP BY label
ORDER BY data DESC
SQL;
		$stm = $this->pdo->query($sql);
		$res = $stm->fetchAll(PDO::FETCH_ASSOC);

		return $res;
	}

	/**
	 * Calculates the 10 top feeds based on their number of entries
	 *
	 * @return array
	 */
	public function calculateTopFeed() {
		$sql = <<<SQL
SELECT f.id AS id
, MAX(f.name) AS name
, MAX(c.name) AS category
, COUNT(e.id) AS count
FROM `_category` AS c, `_feed` AS f, `_entry` AS e
WHERE c.id = f.category
AND f.id = e.id_feed
GROUP BY f.id
ORDER BY count DESC
LIMIT 10
SQL;
		$stm = $this->pdo->query($sql);
		return $stm->fetchAll(PDO::FETCH_ASSOC);
	}

	/**
	 * Calculates the last publication date for each feed
	 *
	 * @return array
	 */
	public function calculateFeedLastDate() {
		$sql = <<<SQL
SELECT MAX(f.id) as id
, MAX(f.name) AS name
, MAX(date) AS last_date
, COUNT(*) AS nb_articles
FROM `_feed` AS f, `_entry` AS e
WHERE f.id = e.id_feed
GROUP BY f.id
ORDER BY name
SQL;
		$stm = $this->pdo->query($sql);
		return $stm->fetchAll(PDO::FETCH_ASSOC);
	}

	/**
	 * Gets days ready for graphs
	 *
	 * @return string
	 */
	public function getDays() {
		return $this->convertToTranslatedJson(array(
			'sun',
			'mon',
			'tue',
			'wed',
			'thu',
			'fri',
			'sat',
		));
	}

	/**
	 * Gets months ready for graphs
	 *
	 * @return string
	 */
	public function getMonths() {
		return $this->convertToTranslatedJson(array(
			'jan',
			'feb',
			'mar',
			'apr',
			'may_',
			'jun',
			'jul',
			'aug',
			'sep',
			'oct',
			'nov',
			'dec',
		));
	}

	/**
	 * Translates array content
	 *
	 * @param array $data
	 * @return array
	 */
	private function convertToTranslatedJson($data = array()) {
		$translated = array_map(function($a) {
			return _t('gen.date.' . $a);
		}, $data);

		return $translated;
	}

}
