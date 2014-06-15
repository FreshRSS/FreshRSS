<?php

class FreshRSS_StatsDAO extends Minz_ModelPdo {

	/**
	 * Calculates entry repartition for all feeds and for main stream.
	 * The repartition includes:
	 *   - total entries
	 *   - read entries
	 *   - unread entries
	 *   - favorite entries
	 * 
	 * @return type
	 */
	public function calculateEntryRepartition() {
		$repartition = array();

		// Generates the repartition for the main stream of entry
		$sql = <<<SQL
SELECT COUNT(1) AS `total`,
COUNT(1) - SUM(e.is_read) AS `unread`,
SUM(e.is_read) AS `read`,
SUM(e.is_favorite) AS `favorite`
FROM {$this->prefix}entry AS e
, {$this->prefix}feed AS f
WHERE e.id_feed = f.id
AND f.priority = 10
SQL;
		$stm = $this->bd->prepare($sql);
		$stm->execute();
		$res = $stm->fetchAll(PDO::FETCH_ASSOC);
		$repartition['main_stream'] = $res[0];

		// Generates the repartition for all entries
		$sql = <<<SQL
SELECT COUNT(1) AS `total`,
COUNT(1) - SUM(e.is_read) AS `unread`,
SUM(e.is_read) AS `read`,
SUM(e.is_favorite) AS `favorite`
FROM {$this->prefix}entry AS e
SQL;
		$stm = $this->bd->prepare($sql);
		$stm->execute();
		$res = $stm->fetchAll(PDO::FETCH_ASSOC);
		$repartition['all_feeds'] = $res[0];

		return $repartition;
	}

	/**
	 * Calculates entry count per day on a 30 days period.
	 * Returns the result as a JSON string.
	 * 
	 * @return string
	 */
	public function calculateEntryCount() {
		$count = array();

		// Generates a list of 30 last day to be sure we always have 30 days.
		// If we do not do that kind of thing, we'll end up with holes in the
		// days if the user do not have a lot of feeds.
		$sql = <<<SQL
SELECT - (tens.val + units.val + 1) AS day
FROM (
    SELECT 0 AS val
    UNION ALL SELECT 1
    UNION ALL SELECT 2
    UNION ALL SELECT 3
    UNION ALL SELECT 4
    UNION ALL SELECT 5
    UNION ALL SELECT 6
    UNION ALL SELECT 7
    UNION ALL SELECT 8
    UNION ALL SELECT 9
) AS units
CROSS JOIN (
    SELECT 0 AS val
    UNION ALL SELECT 10
    UNION ALL SELECT 20
) AS tens
ORDER BY day ASC
SQL;
		$stm = $this->bd->prepare($sql);
		$stm->execute();
		$res = $stm->fetchAll(PDO::FETCH_ASSOC);
		foreach ($res as $value) {
			$count[$value['day']] = 0;
		}

		// Get stats per day for the last 30 days and applies the result on 
		// the array created with the last query.
		$sql = <<<SQL
SELECT DATEDIFF(FROM_UNIXTIME(e.date), NOW()) AS day,
COUNT(1) AS count
FROM {$this->prefix}entry AS e
WHERE FROM_UNIXTIME(e.date, '%Y%m%d') BETWEEN DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -30 DAY), '%Y%m%d') AND DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -1 DAY), '%Y%m%d')
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
	 * Calculates feed count per category.
	 * Returns the result as a JSON string.
	 * 
	 * @return string
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
	 * @return string
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
GROUP BY id
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
SELECT MAX(f.name) AS name
, MAX(date) AS last_date
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

	private function convertToSerie($data) {
		$serie = array();

		foreach ($data as $key => $value) {
			$serie[] = array($key, $value);
		}

		return json_encode($serie);
	}

	private function convertToPieSerie($data) {
		$serie = array();

		foreach ($data as $value) {
			$value['data'] = array(array(0, (int) $value['data']));
			$serie[] = $value;
		}

		return json_encode($serie);
	}

}
