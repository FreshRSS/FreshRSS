<?php
declare(strict_types=1);

namespace FreshRss\Controllers;

use FreshRss\Minz\Error;
use FreshRss\Minz\Request;
use FreshRss\Models\ActionController;
use FreshRss\Models\Auth;
use FreshRss\Models\Context;
use FreshRss\Models\Factory;
use FreshRss\Models\UserQuery;
use FreshRss\Models\View;

/**
 * Controller to handle advanced search actions.
 */
class SearchController extends ActionController {

	#[\Override]
	public function firstAction(): void {
		if (!Auth::hasAccess()) {
			Error::error(403);
		}
	}

	/**
	 * Display the advanced search form.
	 */
	public function indexAction(): void {
		View::prependTitle(_t('gen.menu.advanced_search') . ' · ');

		// Get categories and feeds for dropdowns
		$catDAO = Factory::createCategoryDao();
		$this->view->categories = $catDAO->listCategories(true, true);

		$feedDAO = Factory::createFeedDao();
		$this->view->feeds = $feedDAO->listFeeds();

		// Get labels
		$tagDAO = Factory::createTagDao();
		$this->view->labels = $tagDAO->listTags(true);

		// Get user queries
		$this->view->queries = [];
		foreach (Context::userConf()->queries as $key => $query) {
			$this->view->queries[intval($key)] = new UserQuery($query, Context::categories(), Context::labels());
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
			$quoted = str_contains($line, ' ') && !str_starts_with($line, '/') ? "'$line'" : $line;
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
		if (!Request::isPost()) {
			Request::forward(['c' => 'search', 'a' => 'index'], true);
			return;
		}

		// Build the search query from form parameters
		$searchTerms = [];

		$freeTextClause = self::buildOrClause(Request::paramString('free_text'));
		if ($freeTextClause !== '') {
			$searchTerms[] = $freeTextClause;
		}

		$titleClause = self::buildOrClause(Request::paramString('title'), 'intitle:');
		if ($titleClause !== '') {
			$searchTerms[] = $titleClause;
		}

		$contentClause = self::buildOrClause(Request::paramString('content'), 'intext:');
		if ($contentClause !== '') {
			$searchTerms[] = $contentClause;
		}

		$urlClause = self::buildOrClause(Request::paramString('url'), 'inurl:');
		if ($urlClause !== '') {
			$searchTerms[] = $urlClause;
		}

		$authorClause = self::buildOrClause(Request::paramString('authors'), 'author:');
		if ($authorClause !== '') {
			$searchTerms[] = $authorClause;
		}

		$tagsClause = self::buildOrClause(Request::paramString('tags'), '#');
		if ($tagsClause !== '') {
			$searchTerms[] = $tagsClause;
		}

		// Received date
		$dateFrom = trim(Request::paramString('date_from'));
		$dateTo = trim(Request::paramString('date_to'));
		$dateNumber = Request::paramInt('date_number');
		$dateUnit = trim(Request::paramString('date_unit'));

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
		$pubDateFrom = trim(Request::paramString('pubdate_from'));
		$pubDateTo = trim(Request::paramString('pubdate_to'));
		$pubDateNumber = Request::paramInt('pubdate_number');
		$pubDateUnit = trim(Request::paramString('pubdate_unit'));

		if ($pubDateNumber > 0 && $pubDateUnit !== '') {
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

		// Server modification date
		$mDateFrom = trim(Request::paramString('mdate_from'));
		$mDateTo = trim(Request::paramString('mdate_to'));
		$mDateNumber = Request::paramInt('mdate_number');
		$mDateUnit = trim(Request::paramString('mdate_unit'));

		if ($mDateNumber > 0 && $mDateUnit !== '') {
			$prefix = ($mDateUnit === 'H' || $mDateUnit === 'M' || $mDateUnit === 'S') ? 'PT' : 'P';
			$searchTerms[] = "mdate:{$prefix}{$mDateNumber}{$mDateUnit}";
		} elseif ($mDateFrom !== '' || $mDateTo !== '') {
			if ($mDateFrom !== '' && $mDateTo !== '') {
				$searchTerms[] = "mdate:$mDateFrom/$mDateTo";
			} elseif ($mDateFrom !== '') {
				$searchTerms[] = "mdate:$mDateFrom/";
			} elseif ($mDateTo !== '') {
				$searchTerms[] = "mdate:/$mDateTo";
			}
		}

		// User modification date
		$userDateFrom = trim(Request::paramString('userdate_from'));
		$userDateTo = trim(Request::paramString('userdate_to'));
		$userDateNumber = Request::paramInt('userdate_number');
		$userDateUnit = trim(Request::paramString('userdate_unit'));

		if ($userDateNumber > 0 && $userDateUnit !== '') {
			$prefix = ($userDateUnit === 'H' || $userDateUnit === 'M' || $userDateUnit === 'S') ? 'PT' : 'P';
			$searchTerms[] = "userdate:{$prefix}{$userDateNumber}{$userDateUnit}";
		} elseif ($userDateFrom !== '' || $userDateTo !== '') {
			if ($userDateFrom !== '' && $userDateTo !== '') {
				$searchTerms[] = "userdate:$userDateFrom/$userDateTo";
			} elseif ($userDateFrom !== '') {
				$searchTerms[] = "userdate:$userDateFrom/";
			} elseif ($userDateTo !== '') {
				$searchTerms[] = "userdate:/$userDateTo";
			}
		}

		$feedIds = Request::paramArrayInt('feed_ids');
		if (!empty($feedIds)) {
			$searchTerms[] = 'f:' . implode(',', $feedIds);
		}

		$categoryIds = Request::paramArrayInt('category_ids');
		if (!empty($categoryIds)) {
			$searchTerms[] = 'c:' . implode(',', $categoryIds);
		}

		$labelIds = Request::paramArrayInt('label_ids');
		if (!empty($labelIds)) {
			$searchTerms[] = 'L:' . implode(',', $labelIds);
		}

		$userQueryIds = Request::paramArrayInt('user_query_ids');
		if (!empty($userQueryIds)) {
			$searchTerms[] = 'S:' . implode(',', $userQueryIds);
		}

		// Combine all search terms
		$searchQuery = implode(' ', $searchTerms);

		// Redirect to the main view with the search query
		Request::forward([
			'c' => 'index',
			'a' => 'index',
			'params' => [
				'search' => $searchQuery,
			],
		], redirect: true);
	}
}
