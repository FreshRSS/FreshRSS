<?php

class feedController extends ActionController {
	public function addAction () {
		if (login_is_conf ($this->view->conf) && !is_logged ()) {
			Error::error (
				403,
				array ('error' => array ('Vous n\'avez pas le droit d\'accéder à cette page'))
			);
		} else {
			if (Request::isPost ()) {
				$url = Request::param ('url_rss');
			
				try {
					$feed = new Feed ($url);
					$feed->load ();
				
					$feedDAO = new FeedDAO ();
					$values = array (
						'id' => $feed->id (),
						'url' => $feed->url (),
						'category' => null,
						'name' => $feed->name (),
						'website' => $feed->website (),
						'description' => $feed->description (),
					);
					$feedDAO->addFeed ($values);
				
					$entryDAO = new EntryDAO ();
					$entries = $feed->entries ();
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
							'id_feed' => $feed->id ()
						);
						$entryDAO->addEntry ($values);
					}
				} catch (Exception $e) {
					// TODO ajouter une erreur : url non valide
				}
			
				Request::forward (array (), true);
			}
		}
	}
	
	public function actualizeAction () {
		$feedDAO = new FeedDAO ();
		$entryDAO = new EntryDAO ();
		
		$feeds = $feedDAO->listFeeds ();
		
		foreach ($feeds as $feed) {
			$feed->load ();
			$entries = $feed->entries ();
			
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
					'id_feed' => $feed->id ()
				);
				$entryDAO->addEntry ($values);
			}
		}
		
		$entryDAO->cleanOldEntries ($this->view->conf->oldEntries ());
		
		Request::forward (array (), true);
	}
	
	public function massiveImportAction () {
		if (login_is_conf ($this->view->conf) && !is_logged ()) {
			Error::error (
				403,
				array ('error' => array ('Vous n\'avez pas le droit d\'accéder à cette page'))
			);
		} else {
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
			}
		
			foreach ($feeds as $feed) {
				$feed->load ();
				$entries = $feed->entries ();
			
				// Chargement du flux
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
						'id_feed' => $feed->id ()
					);
					$entryDAO->addEntry ($values);
				}
			
				// Enregistrement du flux
				$values = array (
					'id' => $feed->id (),
					'url' => $feed->url (),
					'category' => $feed->category (),
					'name' => $feed->name (),
					'website' => $feed->website (),
					'description' => $feed->description (),
				);
				$feedDAO->addFeed ($values);
			}
	
			Request::forward (array ('c' => 'configure', 'a' => 'importExport'));
		}
	}
	
	public function deleteAction () {
		if (login_is_conf ($this->view->conf) && !is_logged ()) {
			Error::error (
				403,
				array ('error' => array ('Vous n\'avez pas le droit d\'accéder à cette page'))
			);
		} else {
			$id = Request::param ('id');
		
			$feedDAO = new FeedDAO ();
			$feedDAO->deleteFeed ($id);
		
			Request::forward (array ('c' => 'configure', 'a' => 'feed'), true);
		}
	}
}
