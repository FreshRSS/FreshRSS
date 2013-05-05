<?php
  
class apiController extends ActionController {
	public function firstAction() {
		header('Content-type: application/json');

		$this->view->_useLayout (false);
	}

	public function getPublicFeedAction () {
		$entryDAO = new EntryDAO ();
		$entryDAO->_nbItemsPerPage (-1);

		$entries_tmp = $entryDAO->listPublic ('low_to_high');

		$entries = array ();
		foreach ($entries_tmp as $e) {
			$author = $e->author ();

			$notes = $e->notes ();
			if ($notes == '') {
				$feed = $e->feed (true);
				if($author != '') {
					$notes = Translate::t ('article_published_on_author', $feed->website (), $feed->name (), $author);
				} else {
					$notes = Translate::t ('article_published_on', $feed->website (), $feed->name ());
				}
			}

			$id = $e->id ();
			$entries[$id] = array ();
			$entries[$id]['title'] = $e->title ();
			$entries[$id]['content'] = $notes;
			$entries[$id]['date'] = $e->date (true);
			$entries[$id]['lastUpdate'] = $e->lastUpdate (true);
			$entries[$id]['tags'] = $e->tags ();
			$entries[$id]['url'] = $e->link ();
			$entries[$id]['type'] = 'url';
		}

		$this->view->entries = $entries;
	}

	public function getNbNotReadAction() {
	}
}
