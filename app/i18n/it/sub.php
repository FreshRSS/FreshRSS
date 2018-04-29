<?php

return array(
	'api' => array(
		'documentation' => 'Copy the following URL to use it within an external tool.',// TODO
		'title' => 'API',// TODO
	),
	'bookmarklet' => array(
		'documentation' => 'Drag this button to your bookmarks toolbar or right-click it and choose "Bookmark This Link". Then click "Subscribe" button in any page you want to subscribe to.',// TODO
		'label' => 'Subscribe',// TODO
		'title' => 'Bookmarklet',// TODO
	),
	'category' => array(
		'_' => 'Categoria',
		'add' => 'Aggiungi una categoria',
		'empty' => 'Categoria vuota',
		'new' => 'Nuova categoria',
	),
	'feed' => array(
		'add' => 'Aggiungi un Feed RSS',
		'advanced' => 'Avanzate',
		'archiving' => 'Archiviazione',
		'auth' => array(
			'configuration' => 'Autenticazione',
			'help' => 'Accesso per feeds protetti',
			'http' => 'Autenticazione HTTP',
			'password' => 'HTTP password',
			'username' => 'HTTP username',
		),
		'css_help' => 'In caso di RSS feeds troncati (attenzione, richiede molto tempo!)',
		'css_path' => 'Percorso del foglio di stile CSS del sito di origine',
		'description' => 'Descrizione',
		'empty' => 'Questo feed non contiene articoli. Per favore verifica il sito direttamente.',
		'error' => 'Questo feed ha generato un errore. Per favore verifica se ancora disponibile.',
		'informations' => 'Informazioni',
		'keep_history' => 'Numero minimo di articoli da mantenere',
		'moved_category_deleted' => 'Cancellando una categoria i feed al suo interno verranno classificati automaticamente come <em>%s</em>.',
		'mute' => 'mute', // TODO
		'no_selected' => 'Nessun feed selezionato.',
		'number_entries' => '%d articoli',
		'priority' => array(
			'_' => 'Visibility', // TODO
			'archived' => 'Do not show (archived)', // TODO
			'main_stream' => 'Mostra in homepage', // TODO
			'normal' => 'Show in its category', // TODO
		),
		'ssl_verify' => 'Verify SSL security',	//TODO
		'stats' => 'Statistiche',
		'think_to_add' => 'Aggiungi feed.',
		'timeout' => 'Timeout in seconds',	//TODO
		'title' => 'Titolo',
		'title_add' => 'Aggiungi RSS feed',
		'ttl' => 'Non aggiornare automaticamente piu di',
		'url' => 'Feed URL',
		'validator' => 'Controlla la validita del feed ',
		'website' => 'URL del sito',
		'pubsubhubbub' => 'Notifica istantanea con PubSubHubbub',
	),
	'firefox' => array(
		'documentation' => 'Follow the steps described <a href="https://developer.mozilla.org/en-US/Firefox/Releases/2/Adding_feed_readers_to_Firefox#Adding_a_new_feed_reader_manually">here</a> to add FreshRSS to Firefox feed reader list.',// TODO
		'title' => 'Firefox feed reader',// TODO
	),
	'import_export' => array(
		'export' => 'Esporta',
		'export_opml' => 'Esporta tutta la lista dei feed (OPML)',
		'export_starred' => 'Esporta i tuoi preferiti',
		'feed_list' => 'Elenco di %s articoli',
		'file_to_import' => 'File da importare<br />(OPML, JSON o ZIP)',
		'file_to_import_no_zip' => 'File da importare<br />(OPML o JSON)',
		'import' => 'Importa',
		'starred_list' => 'Elenco articoli preferiti',
		'title' => 'Importa / esporta',
	),
	'menu' => array(
		'bookmark' => 'Bookmark (trascina nei preferiti)',
		'import_export' => 'Importa / esporta',
		'subscription_management' => 'Gestione sottoscrizioni',
		'subscription_tools' => 'Subscription tools',// TODO
	),
	'title' => array(
		'_' => 'Gestione sottoscrizioni',
		'feed_management' => 'Gestione RSS feeds',
		'subscription_tools' => 'Subscription tools',// TODO
	),
);
