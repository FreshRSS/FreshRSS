<?php

class feedController extends ActionController {
	public function addAction () {
		if (Request::isPost ()) {
			$url = Request::param ('url_rss');
			
			try {
				$feed = new Feed ($url);
				$entries = $feed->loadEntries ();
				$feed_entries = array ();
				
				if ($entries !== false) {
					$entryDAO = new EntryDAO ();
					
					foreach ($entries as $entry) {
						$values = array (
							'id' => $entry->id (),
							'guid' => $entry->guid (),
							'title' => $entry->title (),
							'author' => $entry->author (),
							'content' => $entry->content (),
							'link' => $entry->link (),
							'date' => $entry->date (true),
							'is_read' => $entry->isRead (),
							'is_favorite' => $entry->isFavorite (),
						);
						$entryDAO->addEntry ($values);
						
						$feed_entries[] = $entry->id ();
					}
				}
				
				$feedDAO = new FeedDAO ();
				$values = array (
					'id' => $feed->id (),
					'url' => $feed->url (),
					'categories' => $feed->categories (),
					'entries' => $feed_entries
				);
				$feedDAO->addFeed ($values);
			} catch (Exception $e) {
				// TODO ajouter une erreur : url non valide
			}
			
			Request::forward (array (), true);
		}
	}
	
	public function actualizeAction () {
		$feedDAO = new FeedDAO ();
		$entryDAO = new EntryDAO ();
		
		$feeds = $feedDAO->listFeeds ();
		
		foreach ($feeds as $feed) {
			$entries = $feed->loadEntries ();
			$feed_entries = $feed->entries ();
				
			if ($entries !== false) {
				foreach ($entries as $entry) {
					$values = array (
						'id' => $entry->id (),
						'guid' => $entry->guid (),
						'title' => $entry->title (),
						'author' => $entry->author (),
						'content' => $entry->content (),
						'link' => $entry->link (),
						'date' => $entry->date (true),
						'is_read' => $entry->isRead (),
						'is_favorite' => $entry->isFavorite (),
					);
					$entryDAO->addEntry ($values);
					
					if (!in_array ($entry->id (), $feed_entries)) {
						$feed_entries[] = $entry->id ();
					}
				}
			}
			
			$values = array (
				'entries' => $feed_entries
			);
			$feedDAO->updateFeed ($values);
		}
		
		Request::forward (array (), true);
	}
}
