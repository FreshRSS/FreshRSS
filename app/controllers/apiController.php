<?php
  
class apiController extends ActionController {
	public function firstAction() {
		header('Content-type: application/json');

		$this->view->_useLayout (false);
	}

	public function getFavoritesAction () {
		$entryDAO = new EntryDAO ();
		$entryDAO->_nbItemsPerPage (-1);

		$entries_tmp = $entryDAO->listFavorites ('all', 'low_to_high');

		$entries = array ();
		foreach ($entries_tmp as $e) {
			$author = $e->author ();
			$feed = $e->feed (true);
			$content = 'Article publié initialement sur <a href="' . $feed->website () . '">' . $feed->name () . '</a>';
			if($author != '') {
				$content .= ' par ' . $author;
			}
			$content .= ', mis en favoris dans <a href="https://github.com/marienfressinaud/FreshRSS">FreshRSS</a>';

			$id = $e->id ();
			$entries[$id] = array ();
			$entries[$id]['title'] = $e->title ();
			$entries[$id]['content'] = $content;
			$entries[$id]['date'] = $e->date (true);
			$entries[$id]['lastUpdate'] = $e->date (true);
			$entries[$id]['tags'] = array ();
			$entries[$id]['url'] = $e->link ();
			$entries[$id]['type'] = 'url';
		}

		$this->view->entries = $entries;
	}

	public function getNbNotReadAction() {
	}
}
