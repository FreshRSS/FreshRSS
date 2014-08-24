<?php

class FreshRSS_stats_Controller extends Minz_ActionController {

	public function indexAction() {
		$statsDAO = FreshRSS_Factory::createStatsDAO();
		Minz_View::appendScript(Minz_Url::display('/scripts/flotr2.min.js?' . @filemtime(PUBLIC_PATH . '/scripts/flotr2.min.js')));
		$this->view->repartition = $statsDAO->calculateEntryRepartition();
		$this->view->count = $statsDAO->calculateEntryCount();
		$this->view->feedByCategory = $statsDAO->calculateFeedByCategory();
		$this->view->entryByCategory = $statsDAO->calculateEntryByCategory();
		$this->view->topFeed = $statsDAO->calculateTopFeed();
	}

	public function idleAction() {
		$statsDAO = FreshRSS_Factory::createStatsDAO();
		$feeds = $statsDAO->calculateFeedLastDate();
		$idleFeeds = array(
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

		foreach ($feeds as $feed) {
			$feedDate->setTimestamp($feed['last_date']);
			if ($feedDate >= $lastWeek) {
				continue;
			}
			if ($feedDate < $lastYear) {
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

	public function repartitionAction() {
		$statsDAO = FreshRSS_Factory::createStatsDAO();
		$categoryDAO = new FreshRSS_CategoryDAO();
		$feedDAO = FreshRSS_Factory::createFeedDao();
		Minz_View::appendScript(Minz_Url::display('/scripts/flotr2.min.js?' . @filemtime(PUBLIC_PATH . '/scripts/flotr2.min.js')));
		$id = Minz_Request::param ('id', null);
		$this->view->categories = $categoryDAO->listCategories();
		$this->view->feed = $feedDAO->searchById($id);
		$this->view->days = $statsDAO->getDays();
		$this->view->months = $statsDAO->getMonths();
		$this->view->repartitionHour = $statsDAO->calculateEntryRepartitionPerFeedPerHour($id);
		$this->view->repartitionDayOfWeek = $statsDAO->calculateEntryRepartitionPerFeedPerDayOfWeek($id);
		$this->view->repartitionMonth = $statsDAO->calculateEntryRepartitionPerFeedPerMonth($id);
	}

	public function firstAction() {
		if (!$this->view->loginOk) {
			Minz_Error::error(
			    403, array('error' => array(Minz_Translate::t('access_denied')))
			);
		}

		Minz_View::prependTitle(Minz_Translate::t('stats') . ' · ');
	}

}
