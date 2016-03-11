<?php

class FreshRSS_StatsDAO extends Minz_ModelPdo {

	const ENTRY_COUNT_PERIOD = 30;

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
SELECT COUNT(1) AS `total`,
COUNT(1) - SUM(e.is_read) AS `unread`,
SUM(e.is_read) AS `read`,
SUM(e.is_favorite) AS `favorite`
FROM {$this->prefix}entry AS e
, {$this->prefix}feed AS f
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
	 * Returns the result as a JSON object.
	 *
	 * @return JSON object
	 */
	public function calculateEntryCount() {
		$count = $this->initEntryCountArray();
		$period = self::ENTRY_COUNT_PERIOD;

		// Get stats per day for the last 30 days
		$sql = <<<SQL
SELECT DATEDIFF(FROM_UNIXTIME(e.date), NOW()) AS day,
COUNT(1) AS count
FROM {$this->prefix}entry AS e
WHERE FROM_UNIXTIME(e.date, '%Y%m%d') BETWEEN DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -{$period} DAY), '%Y%m%d') AND DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -1 DAY), '%Y%m%d')
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
FROM {$this->prefix}entry AS e
WHERE FROM_UNIXTIME(e.date, '%Y%m%d') BETWEEN DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -{$period} DAY), '%Y%m%d') AND DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -1 DAY), '%Y%m%d')
SQL;
		$stm = $this->bd->prepare($sql);
		$stm->execute();
		$res = $stm->fetch(PDO::FETCH_NAMED);

		return round($res['average'], 2);
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
FROM {$this->prefix}entry AS e
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
FROM {$this->prefix}entry AS e
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
	 * Returns the result as a JSON object.
	 *
	 * @return JSON object
	 */
	public function calculateFeedByCategory() {
		$sql = <<<SQL
SELECT c.name AS label
, COUNT(f.id) AS data
FROM {$this->prefix}category AS c,
{$this->prefix}feed AS f
WHERE c.id = f.category
GROUP BY label
ORDER BY data DESC
SQL;
		$stm = $this->bd->prepare($sql);
		$stm->execute();
		$res = $stm->fetchAll(PDO::FETCH_ASSOC);

		return $this->convertToPieSerie($res);
	}

	/**
	 * Calculates entry count per category.
	 * Returns the result as a JSON string.
	 *
	 * @return JSON object
	 */
	public function calculateEntryByCategory() {
		$sql = <<<SQL
SELECT c.name AS label
, COUNT(e.id) AS data
FROM {$this->prefix}category AS c,
{$this->prefix}feed AS f,
{$this->prefix}entry AS e
WHERE c.id = f.category
AND f.id = e.id_feed
GROUP BY label
ORDER BY data DESC
SQL;
		$stm = $this->bd->prepare($sql);
		$stm->execute();
		$res = $stm->fetchAll(PDO::FETCH_ASSOC);

		return $this->convertToPieSerie($res);
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
FROM {$this->prefix}category AS c,
{$this->prefix}feed AS f,
{$this->prefix}entry AS e
WHERE c.id = f.category
AND f.id = e.id_feed
GROUP BY f.id
ORDER BY count DESC
LIMIT 10
SQL;
		$stm = $this->bd->prepare($sql);
		$stm->execute();
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
FROM {$this->prefix}feed AS f,
{$this->prefix}entry AS e
WHERE f.id = e.id_feed
GROUP BY f.id
ORDER BY name
SQL;
		$stm = $this->bd->prepare($sql);
		$stm->execute();
		return $stm->fetchAll(PDO::FETCH_ASSOC);
	}

	protected function convertToSerie($data) {
		$serie = array();

		foreach ($data as $key => $value) {
			$serie[] = array($key, $value);
		}

		return $serie;
	}

	protected function convertToPieSerie($data) {
		$serie = array();

		foreach ($data as $value) {
			$value['data'] = array(array(0, (int) $value['data']));
			$serie[] = $value;
		}

		return $serie;
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
			'may',
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
	 * @return JSON object
	 */
	private function convertToTranslatedJson($data = array()) {
		$translated = array_map(function($a) {
			return _t('gen.date.' . $a);
		}, $data);

		return $translated;
	}

}
