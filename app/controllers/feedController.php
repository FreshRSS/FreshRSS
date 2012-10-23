<?php

class feedController extends ActionController {
	public function addAction () {
		if (Request::isPost ()) {
			$url = Request::param ('url_rss');
			
			try {
				$feed = new Feed ($url);
				$feed->load ();
				$entries = $feed->entries (false);
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
							'feed' => $feed->id ()
						);
						$entryDAO->addEntry ($values);
						
						$feed_entries[] = $entry->id ();
					}
				}
				
				$feedDAO = new FeedDAO ();
				$values = array (
					'id' => $feed->id (),
					'url' => $feed->url (),
					'category' => $feed->category (),
					'entries' => $feed_entries,
					'name' => $feed->name (),
					'website' => $feed->website (),
					'description' => $feed->description (),
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
			$feed->load ();
			$entries = $feed->entries (false);
			$feed_entries = $feed->entries ();
				
			if ($entries !== false) {
				foreach ($entries as $entry) {
					if (!in_array ($entry->id (), $feed_entries)) {
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
							'feed' => $feed->id ()
						);
						$entryDAO->addEntry ($values);
					
						$feed_entries[] = $entry->id ();
					}
					
					// TODO gérer suppression des articles trop vieux (à paramétrer)
				}
			}
			
			$values = array (
				'entries' => $feed_entries
			);
			$feedDAO->updateFeed ($values);
		}
		
		Request::forward (array (), true);
	}
	
	public function massiveImportAction () {
		$entryDAO = new EntryDAO ();
		$feedDAO = new FeedDAO ();
		$catDAO = new CategoryDAO ();
		
		$categories = Request::param ('categories', array ());
		$feeds = Request::param ('feeds', array ());
		
		foreach ($categories as $cat) {
			$values = array (
				'id' => $cat->id (),
				'name' => $cat->name (),
				'color' => $cat->color ()
			);
			$catDAO->addCategory ($values);
			$catDAO->save ();
		}
		
		foreach ($feeds as $feed) {
			$feed->load ();
			$entries = $feed->entries (false);
			$feed_entries = array ();
			
			// Chargement du flux
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
						'feed' => $feed->id ()
					);
					$entryDAO->addEntry ($values);
					
					$feed_entries[] = $entry->id ();
				}
			}
			
			// Enregistrement du flux
			$values = array (
				'id' => $feed->id (),
				'url' => $feed->url (),
				'category' => $feed->category (),
				'entries' => $feed_entries,
				'name' => $feed->name (),
				'website' => $feed->website (),
				'description' => $feed->description (),
			);
			$feedDAO->addFeed ($values);
		}
	
		Request::forward (array ('c' => 'configure', 'a' => 'importExport'));
	}
}
