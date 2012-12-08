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
						'lastUpdate' => time ()
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
					
					// notif
					$notif = array (
						'type' => 'good',
						'content' => 'Le flux <em>' . $feed->url () . '</em> a bien été ajouté'
					);
					Session::_param ('notification', $notif);
				} catch (Exception $e) {
					// notif
					$notif = array (
						'type' => 'bad',
						'content' => 'L\'url <em>' . $url . '</em> est invalide'
					);
					Session::_param ('notification', $notif);
				}
			
				Request::forward (array (), true);
			}
		}
	}
	
	public function actualizeAction () {
		$feedDAO = new FeedDAO ();
		$entryDAO = new EntryDAO ();
		
		$feeds = $feedDAO->listFeedsOrderUpdate ();
		
		// pour ne pas ajouter des entrées trop anciennes
		$nb_month_old = $this->view->conf->oldEntries ();
		$date_min = time () - (60 * 60 * 24 * 30 * $nb_month_old);
		
		$i = 0;
		foreach ($feeds as $feed) {
			$feed->load ();
			$entries = $feed->entries ();
			
			foreach ($entries as $entry) {
				if ($entry->date (true) >= $date_min) {
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
			
			$feedDAO->updateLastUpdate ($feed->id ());
			
			$i++;
			if ($i >= 10) {
				break;
			}
		}
		
		$entryDAO->cleanOldEntries ($nb_month_old);
		
		// notif
		$notif = array (
			'type' => 'good',
			'content' => 'Les flux ont été mis à jour'
		);
		Session::_param ('notification', $notif);
		
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
			
			$nb_month_old = $this->view->conf->oldEntries ();
			$date_min = time () - (60 * 60 * 24 * 30 * $nb_month_old);
		
			$i = 0;
			foreach ($feeds as $feed) {
				$feed->load ();
				
				// on ajoute les entrées que de 10 flux pour limiter un peu la charge
				// si on ajoute pas les entrées du flux, alors on met la date du dernier update à 0
				$update = 0;
				$i++;
				if ($i < 10) {
					$update = time ();
					$entries = $feed->entries ();
					foreach ($entries as $entry) {
						if ($entry->date (true) >= $date_min) {
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
				}
			
				// Enregistrement du flux
				$values = array (
					'id' => $feed->id (),
					'url' => $feed->url (),
					'category' => $feed->category (),
					'name' => $feed->name (),
					'website' => $feed->website (),
					'description' => $feed->description (),
					'lastUpdate' => $update
				);
				$feedDAO->addFeed ($values);
			}
			
			// notif
			$notif = array (
				'type' => 'good',
				'content' => 'Les flux ont été importés'
			);
			Session::_param ('notification', $notif);
	
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
			
			// notif
			$notif = array (
				'type' => 'good',
				'content' => 'Le flux a été supprimé'
			);
			Session::_param ('notification', $notif);
		
			Request::forward (array ('c' => 'configure', 'a' => 'feed'), true);
		}
	}
}
