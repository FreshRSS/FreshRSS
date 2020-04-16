<?php

return array(
	'archiving' => array(
		'delete_after' => 'Rimuovi articoli dopo',
		'exception' => 'Purge exception',	// TODO - Translation
		'help' => 'Altre opzioni sono disponibili nelle impostazioni dei singoli feed',
		'keep_favourites' => 'Never delete favourites',	// TODO - Translation
		'keep_labels' => 'Never delete labels',	// TODO - Translation
		'keep_max' => 'Maximum number of articles to keep',	// TODO - Translation
		'keep_min_by_feed' => 'Numero minimo di articoli da mantenere per feed',
		'keep_period' => 'Maximum age of articles to keep',	// TODO - Translation
		'keep_unreads' => 'Never delete unreads',	// TODO - Translation
		'maintenance' => 'Maintenance',	// TODO - Translation
		'optimize' => 'Ottimizza database',
		'optimize_help' => 'Da fare occasionalmente per ridurre le dimensioni del database',
		'policy' => 'Purge policy',	// TODO - Translation
		'policy_warning' => 'If no purge policy is selected, every article will be kept.',	// TODO - Translation
		'purge_now' => 'Cancella ora',
		'title' => 'Archiviazione',
		'ttl' => 'Non effettuare aggiornamenti per più di',
		'_' => 'Archiviazione',
	),
	'display' => array(
		'icon' => array(
			'bottom_line' => 'Barra in fondo',
			'display_authors' => 'Authors',	// TODO - Translation
			'entry' => 'Icone degli articoli',
			'publication_date' => 'Data di pubblicazione',
			'related_tags' => 'Tags correlati',
			'sharing' => 'Condivisione',
			'top_line' => 'Barra in alto',
		),
		'language' => 'Lingua',
		'notif_html5' => array(
			'seconds' => 'secondi (0 significa nessun timeout)',
			'timeout' => 'Notifica timeout HTML5',
		),
		'show_nav_buttons' => 'Show the navigation buttons',	// TODO - Translation
		'theme' => 'Tema',
		'title' => 'Visualizzazione',
		'width' => array(
			'content' => 'Larghezza contenuto',
			'large' => 'Largo',
			'medium' => 'Medio',
			'no_limit' => 'Nessun limite',
			'thin' => 'Stretto',
		),
		'_' => 'Visualizzazione',
	),
	'profile' => array(
		'api' => 'API management',	// TODO - Translation
		'delete' => array(
			'warn' => 'Il tuo account e tutti i dati associati saranno cancellati.',
			'_' => 'Cancellazione account',
		),
		'email' => 'Indirizzo email',
		'password_api' => 'Password API<br /><small>(e.g., per applicazioni mobili)</small>',
		'password_form' => 'Password<br /><small>(per il login classico)</small>',
		'password_format' => 'Almeno 7 caratteri',
		'title' => 'Profilo',
		'_' => 'Gestione profili',
	),
	'query' => array(
		'deprecated' => 'Questa query non è più valida. La categoria o il feed di riferimento non stati cancellati.',
		'display' => 'Display user query results',	// TODO - Translation
		'filter' => 'Filtro applicato:',
		'get_all' => 'Mostra tutti gli articoli',
		'get_category' => 'Mostra la categoria "%s" ',
		'get_favorite' => 'Mostra articoli preferiti',
		'get_feed' => 'Mostra feed "%s" ',
		'none' => 'Non hai creato nessuna ricerca personale.',
		'no_filter' => 'Nessun filtro',
		'number' => 'Ricerca n°%d',
		'order_asc' => 'Mostra prima gli articoli più vecchi',
		'order_desc' => 'Mostra prima gli articoli più nuovi',
		'remove' => 'Remove user query',	// TODO - Translation
		'search' => 'Cerca per "%s"',
		'state_0' => 'Mostra tutti gli articoli',
		'state_1' => 'Mostra gli articoli letti',
		'state_2' => 'Mostra gli articoli non letti',
		'state_3' => 'Mostra tutti gli articoli',
		'state_4' => 'Mostra gli articoli preferiti',
		'state_5' => 'Mostra gli articoli preferiti letti',
		'state_6' => 'Mostra gli articoli preferiti non letti',
		'state_7' => 'Mostra gli articoli preferiti',
		'state_8' => 'Non mostrare gli articoli preferiti',
		'state_9' => 'Mostra gli articoli letti non preferiti',
		'state_10' => 'Mostra gli articoli non letti e non preferiti',
		'state_11' => 'Non mostrare gli articoli preferiti',
		'state_12' => 'Mostra tutti gli articoli',
		'state_13' => 'Mostra gli articoli letti',
		'state_14' => 'Mostra gli articoli non letti',
		'state_15' => 'Mostra tutti gli articoli',
		'title' => 'Ricerche personali',
		'_' => 'Ricerche personali',
	),
	'reading' => array(
		'after_onread' => 'Dopo “segna tutto come letto”,',
		'always_show_favorites' => 'Show all articles in favorites by default',	// TODO - Translation
		'articles_per_page' => 'Numero di articoli per pagina',
		'auto_load_more' => 'Carica articoli successivi a fondo pagina',
		'auto_remove_article' => 'Nascondi articoli dopo la lettura',
		'confirm_enabled' => 'Mostra una conferma per “segna tutto come letto”',
		'display_articles_unfolded' => 'Mostra articoli aperti di predefinito',
		'display_categories_unfolded' => 'Categories to unfold',	// TODO - Translation
		'hide_read_feeds' => 'Nascondi categorie e feeds con articoli già letti (non funziona se “Mostra tutti gli articoli” è selezionato)',
		'img_with_lazyload' => 'Usa la modalità "caricamento ritardato" per le immagini',
		'jump_next' => 'Salta al successivo feed o categoria non letto',
		'mark_updated_article_unread' => 'Segna articoli aggiornati come non letti',
		'number_divided_when_reader' => 'Diviso 2 nella modalità di lettura.',
		'read' => array(
			'article_open_on_website' => 'Quando un articolo è aperto nel suo sito di origine',
			'article_viewed' => 'Quando un articolo viene letto',
			'scroll' => 'Scorrendo la pagina',
			'upon_reception' => 'Alla ricezione del contenuto',
			'when' => 'Segna articoli come letti…',
		),
		'show' => array(
			'adaptive' => 'Adatta visualizzazione',
			'all_articles' => 'Mostra tutti gli articoli',
			'unread' => 'Mostra solo non letti',
			'_' => 'Articoli da visualizzare',
		),
		'sides_close_article' => 'Clicking outside of article text area closes the article',	// TODO - Translation
		'sort' => array(
			'newer_first' => 'Prima i più recenti',
			'older_first' => 'Prima i più vecchi',
			'_' => 'Ordinamento',
		),
		'sticky_post' => 'Blocca il contenuto a inizio pagina quando aperto',
		'title' => 'Lettura',
		'view' => array(
			'default' => 'Visualizzazione predefinita',
			'global' => 'Vista globale per categorie',
			'normal' => 'Vista elenco',
			'reader' => 'Modalità di lettura',
		),
		'_' => 'Lettura',
	),
	'sharing' => array(
		'add' => 'Add a sharing method',	// TODO - Translation
		'blogotext' => 'Blogotext',	// TODO - Translation
		'diaspora' => 'Diaspora*',	// TODO - Translation
		'email' => 'Email',	// TODO - Translation
		'facebook' => 'Facebook',	// TODO - Translation
		'more_information' => 'Ulteriori informazioni',
		'print' => 'Stampa',
		'remove' => 'Remove sharing method',	// TODO - Translation
		'shaarli' => 'Shaarli',	// TODO - Translation
		'share_name' => 'Nome condivisione',
		'share_url' => 'URL condivisione',
		'title' => 'Condividi',
		'twitter' => 'Twitter',	// TODO - Translation
		'wallabag' => 'wallabag',	// TODO - Translation
		'_' => 'Condivisione',
	),
	'shortcut' => array(
		'article_action' => 'Azioni sugli articoli',
		'auto_share' => 'Condividi',
		'auto_share_help' => 'Se è presente un solo servizio di condivisione verrà usato quello, altrimenti usare anche il numero associato.',
		'close_dropdown' => 'Chiudi menù',
		'collapse_article' => 'Collassa articoli',
		'first_article' => 'Salta al primo articolo',
		'focus_search' => 'Modulo di ricerca',
		'global_view' => 'Switch to global view',	// TODO - Translation
		'help' => 'Mostra documentazione',
		'javascript' => 'JavaScript deve essere abilitato per poter usare i comandi da tastiera',
		'last_article' => 'Salta all ultimo articolo',
		'load_more' => 'Carica altri articoli',
		'mark_favorite' => 'Segna come preferito',
		'mark_read' => 'Segna come letto',
		'navigation' => 'Navigazione',
		'navigation_help' => 'Con il tasto <kbd>⇧ Shift</kbd> i comandi di navigazione verranno applicati ai feeds.<br/>Con il tasto <kbd>Alt ⎇</kbd> i comandi di navigazione verranno applicati alle categorie.',
		'navigation_no_mod_help' => 'The following navigation shortcuts do not support modifiers.',	// TODO - Translation
		'next_article' => 'Salta al contenuto successivo',
		'normal_view' => 'Switch to normal view',	// TODO - Translation
		'other_action' => 'Altre azioni',
		'previous_article' => 'Salta al contenuto precedente',
		'reading_view' => 'Switch to reading view',	// TODO - Translation
		'rss_view' => 'Open RSS view in a new tab',	// TODO - Translation
		'see_on_website' => 'Vai al sito fonte',
		'shift_for_all_read' => '+ <kbd>Alt ⎇</kbd> to mark previous articles as read<br />+ <kbd>⇧ Shift</kbd> per segnare tutti gli articoli come letti',	// TODO - Translation
		'skip_next_article' => 'Focus next without opening',	// TODO - Translation
		'skip_previous_article' => 'Focus previous without opening',	// TODO - Translation
		'title' => 'Comandi da tastiera',
		'user_filter' => 'Accedi alle ricerche personali',
		'user_filter_help' => 'Se è presente una sola ricerca personale verrà usata quella, altrimenti usare anche il numero associato.',
		'views' => 'Views',	// TODO - Translation
		'_' => 'Comandi tastiera',
	),
	'user' => array(
		'articles_and_size' => '%s articoli (%s)',
		'current' => 'Utente connesso',
		'is_admin' => 'è amministratore',
		'users' => 'Utenti',
	),
);
