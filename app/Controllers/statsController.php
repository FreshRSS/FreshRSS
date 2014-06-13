<?php

class FreshRSS_stats_Controller extends Minz_ActionController {

        public function mainAction() {
                if (!$this->view->loginOk) {
                        Minz_Error::error(
                            403, array('error' => array(Minz_Translate::t('access_denied')))
                        );
                }

                Minz_View::prependTitle(Minz_Translate::t('stats') . ' · ');
                
                $statsDAO = new FreshRSS_StatsDAO ();
		Minz_View::appendScript (Minz_Url::display ('/scripts/flotr2.min.js?' . @filemtime(PUBLIC_PATH . '/scripts/flotr2.min.js')));
		$this->view->repartition = $statsDAO->calculateEntryRepartition();
		$this->view->count = ($statsDAO->calculateEntryCount());
		$this->view->feedByCategory = $statsDAO->calculateFeedByCategory();
		$this->view->entryByCategory = $statsDAO->calculateEntryByCategory();
		$this->view->topFeed = $statsDAO->calculateTopFeed();
        }

        public function idleAction() {
                if (!$this->view->loginOk) {
                        Minz_Error::error(
                            403, array('error' => array(Minz_Translate::t('access_denied')))
                        );
                }

                Minz_View::prependTitle(Minz_Translate::t('stats') . ' · ');

                $statsDAO = new FreshRSS_StatsDAO ();
                $feeds = $statsDAO->calculateFeedLastDate();
                $idleFeeds = array();
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
                        if ($feedDate < $lastWeek) {
                                $idleFeeds['lastWeek'][] = $feed['name'];
                        }
                        if ($feedDate < $lastMonth) {
                                $idleFeeds['lastMonth'][] = $feed['name'];
                        }
                        if ($feedDate < $last3Month) {
                                $idleFeeds['last3Month'][] = $feed['name'];
                        }
                        if ($feedDate < $last6Month) {
                                $idleFeeds['last6Month'][] = $feed['name'];
                        }
                        if ($feedDate < $lastYear) {
                                $idleFeeds['lastYear'][] = $feed['name'];
                        }
                }

                $this->view->idleFeeds = $idleFeeds;
        }

}
