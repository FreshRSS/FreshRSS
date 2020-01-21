<?php

/**
 * Controller to handle every preview content.
 */
class FreshRSS_preview_Controller extends Minz_ContentController {

	public function init() {
		if (!FreshRSS_Auth::hasAccess()) {
			Minz_Error::error(403);
		}
	}


	/**
	 * This content creates a preview of a content-path.
	 *
	 * Parameters are:
	 *   - id (mandatory - no default): Feed ID
	 *   - path (mandatory - no default): Path to preview
	 *
	 */
	public function pathQueryContent() {
		header('Content-Type: text/html; charset=UTF-8');

		//Get parameters.
		$feed_id = Minz_Request::param('id');
		$content_path = Minz_Request::param('path');

		if (!$content_path) {
			echo 'path-not-set'; // FIXME: translate.
			return;
		}

		//Check Feed ID validity.
		$entryDAO = FreshRSS_Factory::createEntryDao();
		$entries = $entryDAO->listWhere('f', $feed_id);

		if (count($entries) == 0) {
			echo 'no-entries-found'; // FIXME: translate.
			return;
		}

		$entry = $entries[0];
		$feed = $entry->feed(true);

		if (!$feed) {
			echo 'no-feed-for-entry'; // FIXME: translate.
			return;
		}

		$feed->_pathEntries($content_path);
		$entry->loadCompleteContent(true);

		echo '<html><body>';
		echo $entry->content();
		echo '</body></html>';
	}
}
