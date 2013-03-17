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
				$notes = 'Article publié initialement sur <a href="' . $feed->website () . '">' . $feed->name () . '</a>';
				if($author != '') {
					$notes .= ' par ' . $author;
				}
				$notes .= ', mis en favoris dans <a href="https://github.com/marienfressinaud/FreshRSS">FreshRSS</a>';
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
