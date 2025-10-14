<?php
declare(strict_types=1);

/**
 * Controller to handle advanced search actions.
 */
class FreshRSS_search_Controller extends FreshRSS_ActionController {

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
		$this->view->queries = [];
		foreach (FreshRSS_Context::userConf()->queries as $key => $query) {
			$this->view->queries[intval($key)] = new FreshRSS_UserQuery($query, FreshRSS_Context::categories(), FreshRSS_Context::labels());
		}
	}

	/**
	 * Build an OR-separated clause from newline delimited values.
	 */
	private static function buildOrClause(string $rawValue, string $prefix = ''): string {
		$lines = preg_split('/[\r\n]+/', $rawValue);
		if ($lines === false) {
			$lines = [$rawValue];
		}

		$terms = [];
		foreach ($lines as $line) {
			$line = trim($line, " \n\r\t\v\0\"'");	// Also trim existing quotes
			if ($line === '') {
				continue;
			}
			$quoted = preg_match('/\s/', $line) === 1 ? "'$line'" : $line;
			$terms[] = $prefix . $quoted;
		}

		if (empty($terms)) {
			return '';
		}
		if (count($terms) === 1) {
			return $terms[0];
		}
		return '(' . implode(' OR ', $terms) . ')';
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

		$freeTextClause = self::buildOrClause(Minz_Request::paramString('free_text'));
		if ($freeTextClause !== '') {
			$searchTerms[] = $freeTextClause;
		}

		$titleClause = self::buildOrClause(Minz_Request::paramString('title'), 'intitle:');
		if ($titleClause !== '') {
			$searchTerms[] = $titleClause;
		}

		$contentClause = self::buildOrClause(Minz_Request::paramString('content'), 'intext:');
		if ($contentClause !== '') {
			$searchTerms[] = $contentClause;
		}

		$urlClause = self::buildOrClause(Minz_Request::paramString('url'), 'inurl:');
		if ($urlClause !== '') {
			$searchTerms[] = $urlClause;
		}

		$authorClause = self::buildOrClause(Minz_Request::paramString('authors'), 'author:');
		if ($authorClause !== '') {
			$searchTerms[] = $authorClause;
		}

		$tagsClause = self::buildOrClause(Minz_Request::paramString('tags'), '#');
		if ($tagsClause !== '') {
			$searchTerms[] = $tagsClause;
		}

		// Received date
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

		// Publication date
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

		$feedIds = Minz_Request::paramArrayInt('feed_ids');
		if (!empty($feedIds)) {
			$searchTerms[] = 'f:' . implode(',', $feedIds);
		}

		$categoryIds = Minz_Request::paramArrayInt('category_ids');
		if (!empty($categoryIds)) {
			$searchTerms[] = 'c:' . implode(',', $categoryIds);
		}

		$labelIds = Minz_Request::paramArrayInt('label_ids');
		if (!empty($labelIds)) {
			$searchTerms[] = 'L:' . implode(',', $labelIds);
		}

		$userQueryIds = Minz_Request::paramArrayInt('user_query_ids');
		if (!empty($userQueryIds)) {
			$searchTerms[] = 'S:' . implode(',', $userQueryIds);
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
		], redirect: true);
	}
}
