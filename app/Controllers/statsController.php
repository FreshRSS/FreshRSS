<?php

/**
 * Controller to handle application statistics.
 */
class FreshRSS_stats_Controller extends Minz_ActionController {

	/**
	 * This action is called before every other action in that class. It is
	 * the common boiler plate for every action. It is triggered by the
	 * underlying framework.
	 */
	public function firstAction() {
		if (!FreshRSS_Auth::hasAccess()) {
			Minz_Error::error(403);
		}

		$this->_csp([
			'default-src' => "'self'",
			'style-src' => "'self' 'unsafe-inline'",
		]);

		Minz_View::prependTitle(_t('admin.stats.title') . ' · ');
	}

	private function convertToSerie($data) {
		$serie = array();

		foreach ($data as $key => $value) {
			$serie[] = array($key, $value);
		}

		return $serie;
	}

	private function convertToPieSerie($data) {
		$serie = array();

		foreach ($data as $value) {
			$value['data'] = array(array(0, (int) $value['data']));
			$serie[] = $value;
		}

		return $serie;
	}

	/**
	 * This action handles the statistic main page.
	 *
	 * It displays the statistic main page.
	 * The values computed to display the page are:
	 *   - repartition of read/unread/favorite/not favorite (repartition)
	 *   - number of article per day (entryCount)
	 *   - number of feed by category (feedByCategory)
	 *   - number of article by category (entryByCategory)
	 *   - list of most prolific feed (topFeed)
	 */
	public function indexAction() {
		$statsDAO = FreshRSS_Factory::createStatsDAO();
		Minz_View::appendScript(Minz_Url::display('/scripts/vendor/chart.js?' . @filemtime(PUBLIC_PATH . '/scripts/vendor/chart.js')));
		
		$this->view->repartition = $statsDAO->calculateEntryRepartition();

		$entryCount = $statsDAO->calculateEntryCount();
		$this->view->entryCount = $entryCount;
		$this->view->average = round(array_sum(array_values($entryCount)) / count($entryCount), 2);
		
		$feedByCategory_calculated = $statsDAO->calculateFeedByCategory();
		for ( $i = 0; $i < count($feedByCategory_calculated); $i++) {
			$feedByCategory['label'][$i] 	= $feedByCategory_calculated[$i]['label'];
			$feedByCategory['data'][$i] 	= $feedByCategory_calculated[$i]['data'];
		}
		$this->view->feedByCategory = $feedByCategory;

		$entryByCategory_calculated = $statsDAO->calculateEntryByCategory();
		for ( $i = 0; $i < count($entryByCategory_calculated); $i++) {
			$entryByCategory['label'][$i] 	= $entryByCategory_calculated[$i]['label'];
			$entryByCategory['data'][$i] 	= $entryByCategory_calculated[$i]['data'];
		}
		$this->view->entryByCategory = $entryByCategory;

		$this->view->topFeed = $statsDAO->calculateTopFeed();

		for ($i = 0; $i < 30; $i++) {
			$last30DaysLabels[$i] = date("d.m.Y", strtotime((-30+$i)." days"));
		}

		$this->view->last30DaysLabels = $last30DaysLabels;
	}

	/**
	 * This action handles the idle feed statistic page.
	 *
	 * It displays the list of idle feed for different period. The supported
	 * periods are:
	 *   - last 5 years
	 *   - last 3 years
	 *   - last 2 years
	 *   - last year
	 *   - last 6 months
	 *   - last 3 months
	 *   - last month
	 *   - last week
	 */
	public function idleAction() {
		$statsDAO = FreshRSS_Factory::createStatsDAO();
		$feeds = $statsDAO->calculateFeedLastDate();
		$idleFeeds = array(
			'last_5_year' => array(),
			'last_3_year' => array(),
			'last_2_year' => array(),
			'last_year' => array(),
			'last_6_month' => array(),
			'last_3_month' => array(),
			'last_month' => array(),
			'last_week' => array(),
		);
		$now = new \DateTime();
		$feedDate = clone $now;
		$lastWeek = clone $now;
		$lastWeek->modify('-1 week');
		$lastMonth = clone $now;
		$lastMonth->modify('-1 month');
		$last3Month = clone $now;
		$last3Month->modify('-3 month');
		$last6Month = clone $now;
		$last6Month->modify('-6 month');
		$lastYear = clone $now;
		$lastYear->modify('-1 year');
		$last2Year = clone $now;
		$last2Year->modify('-2 year');
		$last3Year = clone $now;
		$last3Year->modify('-3 year');
		$last5Year = clone $now;
		$last5Year->modify('-5 year');

		foreach ($feeds as $feed) {
			$feedDate->setTimestamp($feed['last_date']);
			if ($feedDate >= $lastWeek) {
				continue;
			}
			if ($feedDate < $last5Year) {
				$idleFeeds['last_5_year'][] = $feed;
			} elseif ($feedDate < $last3Year) {
				$idleFeeds['last_3_year'][] = $feed;
			} elseif ($feedDate < $last2Year) {
				$idleFeeds['last_2_year'][] = $feed;
			} elseif ($feedDate < $lastYear) {
				$idleFeeds['last_year'][] = $feed;
			} elseif ($feedDate < $last6Month) {
				$idleFeeds['last_6_month'][] = $feed;
			} elseif ($feedDate < $last3Month) {
				$idleFeeds['last_3_month'][] = $feed;
			} elseif ($feedDate < $lastMonth) {
				$idleFeeds['last_month'][] = $feed;
			} elseif ($feedDate < $lastWeek) {
				$idleFeeds['last_week'][] = $feed;
			}
		}

		$this->view->idleFeeds = $idleFeeds;
	}

	/**
	 * This action handles the article repartition statistic page.
	 *
	 * It displays the number of article and the average of article for the
	 * following periods:
	 *   - hour of the day
	 *   - day of the week
	 *   - month
	 *
	 * @todo verify that the metrics used here make some sense. Especially
	 *       for the average.
	 */
	public function repartitionAction() {
		$statsDAO 		= FreshRSS_Factory::createStatsDAO();
		$categoryDAO 	= FreshRSS_Factory::createCategoryDao();
		$feedDAO 		= FreshRSS_Factory::createFeedDao();
		
		Minz_View::appendScript(Minz_Url::display('/scripts/vendor/chart.js?' . @filemtime(PUBLIC_PATH . '/scripts/vendor/chart.js')));
		
		$id = Minz_Request::param('id', null);

		$this->view->categories 	= $categoryDAO->listCategories();
		$this->view->feed 			= $feedDAO->searchById($id);
		$this->view->days 			= $statsDAO->getDays();
		$this->view->months 		= $statsDAO->getMonths();

		$this->view->repartition 			= $statsDAO->calculateEntryRepartitionPerFeed($id);

		$this->view->repartitionHour 		= $statsDAO->calculateEntryRepartitionPerFeedPerHour($id);
		$this->view->averageHour 			= $statsDAO->calculateEntryAveragePerFeedPerHour($id);

		$this->view->repartitionDayOfWeek 	= $statsDAO->calculateEntryRepartitionPerFeedPerDayOfWeek($id);
		$this->view->averageDayOfWeek 		= $statsDAO->calculateEntryAveragePerFeedPerDayOfWeek($id);

		$this->view->repartitionMonth 		= $statsDAO->calculateEntryRepartitionPerFeedPerMonth($id);
		$this->view->averageMonth 			= $statsDAO->calculateEntryAveragePerFeedPerMonth($id);

		for ($i = 0; $i < 24; $i++) {
			$hours24Labels[$i] = $i.":xx";
		}

		$this->view->hours24Labels = $hours24Labels;
	}
}
