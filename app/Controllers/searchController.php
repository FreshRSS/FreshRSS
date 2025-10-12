<?php
declare(strict_types=1);

/**
 * Controller to handle advanced search actions.
 */
class FreshRSS_search_Controller extends FreshRSS_ActionController {

	/**
	 * This action is called before every other action in that class. It is
	 * the common boilerplate for every action. It is triggered by the
	 * underlying framework.
	 */
	#[\Override]
	public function firstAction(): void {
		if (!FreshRSS_Auth::hasAccess()) {
			Minz_Error::error(403);
		}
	}

	/**
	 * Display the advanced search form.
	 */
	public function indexAction(): void {
		FreshRSS_View::prependTitle(_t('gen.menu.advanced_search') . ' · ');

		// Get categories and feeds for dropdowns
		$catDAO = FreshRSS_Factory::createCategoryDao();
		$this->view->categories = $catDAO->listCategories(true, true);

		$feedDAO = FreshRSS_Factory::createFeedDao();
		$this->view->feeds = $feedDAO->listFeeds();

		// Get labels
		$tagDAO = FreshRSS_Factory::createTagDao();
		$this->view->labels = $tagDAO->listTags(true);

		// Get user queries
		$this->view->userQueries = FreshRSS_Context::userConf()->queries;
	}

	/**
	 * Process the advanced search form submission.
	 */
	public function submitAction(): void {
		if (!Minz_Request::isPost()) {
			Minz_Request::forward(['c' => 'search', 'a' => 'index'], true);
			return;
		}

		// Build the search query from form parameters
		$searchTerms = [];

		// Free text search
		$freeText = trim(Minz_Request::paramString('free_text'));
		if ($freeText !== '') {
			$searchTerms[] = $freeText;
		}

		// Feed IDs
		$feedIds = Minz_Request::paramArray('feed_ids');
		if (!empty($feedIds)) {
			$searchTerms[] = 'f:' . implode(',', $feedIds);
		}

		// Category IDs
		$categoryIds = Minz_Request::paramArray('category_ids');
		if (!empty($categoryIds)) {
			$searchTerms[] = 'c:' . implode(',', $categoryIds);
		}

		// Author
		$author = trim(Minz_Request::paramString('author'));
		if ($author !== '') {
			if (strpos($author, ' ') !== false) {
				$searchTerms[] = "author:'$author'";
			} else {
				$searchTerms[] = "author:$author";
			}
		}

		// Title
		$title = trim(Minz_Request::paramString('title'));
		if ($title !== '') {
			if (strpos($title, ' ') !== false) {
				$searchTerms[] = "intitle:'$title'";
			} else {
				$searchTerms[] = "intitle:$title";
			}
		}

		// Content
		$content = trim(Minz_Request::paramString('content'));
		if ($content !== '') {
			if (strpos($content, ' ') !== false) {
				$searchTerms[] = "intext:'$content'";
			} else {
				$searchTerms[] = "intext:$content";
			}
		}

		// URL
		$url = trim(Minz_Request::paramString('url'));
		if ($url !== '') {
			if (strpos($url, ' ') !== false) {
				$searchTerms[] = "inurl:'$url'";
			} else {
				$searchTerms[] = "inurl:$url";
			}
		}

		// Tags
		$tags = trim(Minz_Request::paramString('tags'));
		if ($tags !== '') {
			$tagList = explode(',', $tags);
			foreach ($tagList as $tag) {
				$tag = trim($tag);
				if ($tag !== '') {
					if (strpos($tag, ' ') !== false) {
						$searchTerms[] = "#'$tag'";
					} else {
						$searchTerms[] = "#$tag";
					}
				}
			}
		}

		// Label IDs
		$labelIds = Minz_Request::paramArray('label_ids');
		if (!empty($labelIds)) {
			$searchTerms[] = 'L:' . implode(',', $labelIds);
		}

		// Date range
		$dateFrom = trim(Minz_Request::paramString('date_from'));
		$dateTo = trim(Minz_Request::paramString('date_to'));
		$dateNumber = Minz_Request::paramInt('date_number');
		$dateUnit = trim(Minz_Request::paramString('date_unit'));

		if ($dateNumber > 0 && $dateUnit !== '') {
			// Convert to ISO 8601 duration format: P1D, P1W, P1M, PT1H, etc.
			// Time units (H, M, S) require a T separator
			$prefix = ($dateUnit === 'H' || $dateUnit === 'M' || $dateUnit === 'S') ? 'PT' : 'P';
			$searchTerms[] = "date:{$prefix}{$dateNumber}{$dateUnit}";
		} elseif ($dateFrom !== '' || $dateTo !== '') {
			if ($dateFrom !== '' && $dateTo !== '') {
				$searchTerms[] = "date:$dateFrom/$dateTo";
			} elseif ($dateFrom !== '') {
				$searchTerms[] = "date:$dateFrom/";
			} elseif ($dateTo !== '') {
				$searchTerms[] = "date:/$dateTo";
			}
		}

		// Publication date range
		$pubDateFrom = trim(Minz_Request::paramString('pubdate_from'));
		$pubDateTo = trim(Minz_Request::paramString('pubdate_to'));
		$pubDateNumber = Minz_Request::paramInt('pubdate_number');
		$pubDateUnit = trim(Minz_Request::paramString('pubdate_unit'));

		if ($pubDateNumber > 0 && $pubDateUnit !== '') {
			// Convert to ISO 8601 duration format: P1D, P1W, P1M, PT1H, etc.
			// Time units (H, M, S) require a T separator
			$prefix = ($pubDateUnit === 'H' || $pubDateUnit === 'M' || $pubDateUnit === 'S') ? 'PT' : 'P';
			$searchTerms[] = "pubdate:{$prefix}{$pubDateNumber}{$pubDateUnit}";
		} elseif ($pubDateFrom !== '' || $pubDateTo !== '') {
			if ($pubDateFrom !== '' && $pubDateTo !== '') {
				$searchTerms[] = "pubdate:$pubDateFrom/$pubDateTo";
			} elseif ($pubDateFrom !== '') {
				$searchTerms[] = "pubdate:$pubDateFrom/";
			} elseif ($pubDateTo !== '') {
				$searchTerms[] = "pubdate:/$pubDateTo";
			}
		}

		// Entry IDs
		$entryIds = Minz_Request::paramString('entry_ids');
		if ($entryIds !== '') {
			$searchTerms[] = 'e:' . $entryIds;
		}

		// User query
		$userQuery = trim(Minz_Request::paramString('user_query'));
		if ($userQuery !== '') {
			if (ctype_digit($userQuery)) {
				$searchTerms[] = "S:$userQuery";
			} else {
				if (strpos($userQuery, ' ') !== false) {
					$searchTerms[] = "search:\"$userQuery\"";
				} else {
					$searchTerms[] = "search:$userQuery";
				}
			}
		}

		// Combine all search terms
		$searchQuery = implode(' ', $searchTerms);

		// Redirect to the main view with the search query
		Minz_Request::forward([
			'c' => 'index',
			'a' => 'index',
			'params' => [
				'search' => $searchQuery,
			],
		], true);
	}
}
