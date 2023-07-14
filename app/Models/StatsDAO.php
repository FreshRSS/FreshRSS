<?php

class FreshRSS_StatsDAO extends Minz_ModelPdo {

	public const ENTRY_COUNT_PERIOD = 30;

	protected function sqlFloor(string $s): string {
		return "FLOOR($s)";
	}

	/**
	 * Calculates entry repartition for all feeds and for main stream.
	 *
	 * @return array{'main_stream':array{'total':int,'count_unreads':int,'count_reads':int,'count_favorites':int}|false,'all_feeds':array{'total':int,'count_unreads':int,'count_reads':int,'count_favorites':int}|false}
	 */
	public function calculateEntryRepartition(): array {
		return [
			'main_stream' => $this->calculateEntryRepartitionPerFeed(null, true),
			'all_feeds' => $this->calculateEntryRepartitionPerFeed(null, false),
		];
	}

	/**
	 * Calculates entry repartition for the selection.
	 * The repartition includes:
	 *   - total entries
	 *   - read entries
	 *   - unread entries
	 *   - favorite entries
	 *
	 * @return array{'total':int,'count_unreads':int,'count_reads':int,'count_favorites':int}|false
	 */
	public function calculateEntryRepartitionPerFeed(?int $feed = null, bool $only_main = false) {
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
		$res = $this->fetchAssoc($sql);
		/** @var array<array{'total':int,'count_unreads':int,'count_reads':int,'count_favorites':int}>|null $res */
		return $res[0] ?? false;
	}

	/**
	 * Calculates entry count per day on a 30 days period.
	 * @return array<int,int>
	 */
	public function calculateEntryCount(): array {
		$count = $this->initEntryCountArray();
		$midnight = mktime(0, 0, 0) ?: 0;
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
		$res = $this->fetchAssoc($sql);
		if ($res == false) {
			return [];
		}
		/** @var array<array{'day':int,'count':int}> $res */
		foreach ($res as $value) {
			$count[(int)($value['day'])] = (int)($value['count']);
		}
		return $count;
	}

	/**
	 * Initialize an array for the entry count.
	 * @return array<int,int>
	 */
	protected function initEntryCountArray(): array {
		return $this->initStatsArray(-self::ENTRY_COUNT_PERIOD, -1);
	}

	/**
	 * Calculates the number of article per hour of the day per feed
	 * @return array<int,int>
	 */
	public function calculateEntryRepartitionPerFeedPerHour(?int $feed = null): array {
		return $this->calculateEntryRepartitionPerFeedPerPeriod('%H', $feed);
	}

	/**
	 * Calculates the number of article per day of week per feed
	 * @return array<int,int>
	 */
	public function calculateEntryRepartitionPerFeedPerDayOfWeek(?int $feed = null): array {
		return $this->calculateEntryRepartitionPerFeedPerPeriod('%w', $feed);
	}

	/**
	 * Calculates the number of article per month per feed
	 * @return array<int,int>
	 */
	public function calculateEntryRepartitionPerFeedPerMonth(?int $feed = null): array {
		$monthRepartition = $this->calculateEntryRepartitionPerFeedPerPeriod('%m', $feed);
		// cut out the 0th month (Jan=1, Dec=12)
		\array_splice($monthRepartition, 0, 1);
		return $monthRepartition;
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
SELECT DATE_FORMAT(FROM_UNIXTIME(e.date), '{$period}') AS period
, COUNT(1) AS count
FROM `_entry` AS e
{$restrict}
GROUP BY period
ORDER BY period ASC
SQL;

		$res = $this->fetchAssoc($sql);
		if ($res == false) {
			return [];
		}
		switch ($period) {
			case '%H':
				$periodMax = 24;
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

		$repartition = array_fill(0, $periodMax, 0);
		foreach ($res as $value) {
			$repartition[(int)$value['period']] = (int)$value['count'];
		}

		return $repartition;
	}

	/**
	 * Calculates the average number of article per hour per feed
	 */
	public function calculateEntryAveragePerFeedPerHour(?int $feed = null): float {
		return $this->calculateEntryAveragePerFeedPerPeriod(1 / 24, $feed);
	}

	/**
	 * Calculates the average number of article per day of week per feed
	 */
	public function calculateEntryAveragePerFeedPerDayOfWeek(?int $feed = null): float {
		return $this->calculateEntryAveragePerFeedPerPeriod(7, $feed);
	}

	/**
	 * Calculates the average number of article per month per feed
	 */
	public function calculateEntryAveragePerFeedPerMonth(?int $feed = null): float {
		return $this->calculateEntryAveragePerFeedPerPeriod(30, $feed);
	}

	/**
	 * Calculates the average number of article per feed
	 * @param float $period number used to divide the number of day in the period
	 */
	protected function calculateEntryAveragePerFeedPerPeriod(float $period, ?int $feed = null): float {
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
		$res = $this->fetchAssoc($sql);
		if ($res == null || empty($res[0])) {
			return -1.0;
		}
		$date_min = new \DateTime();
		$date_min->setTimestamp((int)($res[0]['date_min']));
		$date_max = new \DateTime();
		$date_max->setTimestamp((int)($res[0]['date_max']));
		$interval = $date_max->diff($date_min, true);
		$interval_in_days = (float)($interval->format('%a'));
		if ($interval_in_days <= 0) {
			// Surely only one article.
			// We will return count / (period/period) == count.
			$interval_in_days = $period;
		}

		return intval($res[0]['count']) / ($interval_in_days / $period);
	}

	/**
	 * Initialize an array for statistics depending on a range
	 * @return array<int,int>
	 */
	protected function initStatsArray(int $min, int $max): array {
		return array_map(function () {
			return 0;
		}, array_flip(range($min, $max)));
	}

	/**
	 * Calculates feed count per category.
	 * @return array<array{'label':string,'data':int}>
	 */
	public function calculateFeedByCategory(): array {
		$sql = <<<SQL
SELECT c.name AS label
, COUNT(f.id) AS data
FROM `_category` AS c, `_feed` AS f
WHERE c.id = f.category
GROUP BY label
ORDER BY data DESC
SQL;
		$res = $this->fetchAssoc($sql);
		/** @var array<array{'label':string,'data':int}>|null @res */
		return $res == null ? [] : $res;
	}

	/**
	 * Calculates entry count per category.
	 * @return array<array{'label':string,'data':int}>
	 */
	public function calculateEntryByCategory(): array {
		$sql = <<<SQL
SELECT c.name AS label
, COUNT(e.id) AS data
FROM `_category` AS c, `_feed` AS f, `_entry` AS e
WHERE c.id = f.category
AND f.id = e.id_feed
GROUP BY label
ORDER BY data DESC
SQL;
		$res = $this->fetchAssoc($sql);
		/** @var array<array{'label':string,'data':int}>|null $res */
		return $res == null ? [] : $res;
	}

	/**
	 * Calculates the 10 top feeds based on their number of entries
	 * @return array<array{'id':int,'name':string,'category':string,'count':int}>
	 */
	public function calculateTopFeed(): array {
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
		$res = $this->fetchAssoc($sql);
		/** @var array<array{'id':int,'name':string,'category':string,'count':int}>|null $res */
		return $res == null ? [] : $res;
	}

	/**
	 * Calculates the last publication date for each feed
	 * @return array<array{'id':int,'name':string,'last_date':int,'nb_articles':int}>
	 */
	public function calculateFeedLastDate(): array {
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
		$res = $this->fetchAssoc($sql);
		/** @var array<array{'id':int,'name':string,'last_date':int,'nb_articles':int}>|null $res */
		return $res == null ? [] : $res;
	}

	/**
	 * Gets days ready for graphs
	 * @return array<string>
	 */
	public function getDays(): array {
		return $this->convertToTranslatedJson([
			'sun',
			'mon',
			'tue',
			'wed',
			'thu',
			'fri',
			'sat',
		]);
	}

	/**
	 * Gets months ready for graphs
	 * @return array<string>
	 */
	public function getMonths(): array {
		return $this->convertToTranslatedJson([
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
		]);
	}

	/**
	 * Translates array content
	 * @param array<string> $data
	 * @return array<string>
	 */
	private function convertToTranslatedJson(array $data = []): array {
		$translated = array_map(static function (string $a) {
			return _t('gen.date.' . $a);
		}, $data);

		return $translated;
	}

}
