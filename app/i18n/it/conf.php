<?php

/******************************************************************************/
/* Each entry of that file can be associated with a comment to indicate its   */
/* state. When there is no comment, it means the entry is fully translated.   */
/* The recognized comments are (comment matching is case-insensitive):        */
/*   + TODO: the entry has never been translated.                             */
/*   + DIRTY: the entry has been translated but needs to be updated.          */
/*   + IGNORE: the entry does not need to be translated.                      */
/* When a comment is not recognized, it is discarded.                         */
/******************************************************************************/

return array(
	'archiving' => array(
		'_' => 'Archiviazione',
		'exception' => 'Purge exception',	// TODO
		'help' => 'Altre opzioni sono disponibili nelle impostazioni dei singoli feed',
		'keep_favourites' => 'Never delete favourites',	// TODO
		'keep_labels' => 'Never delete labels',	// TODO
		'keep_max' => 'Maximum number of articles to keep',	// TODO
		'keep_min_by_feed' => 'Numero minimo di articoli da mantenere per feed',
		'keep_period' => 'Maximum age of articles to keep',	// TODO
		'keep_unreads' => 'Never delete unread articles',	// TODO
		'maintenance' => 'Maintenance',	// TODO
		'optimize' => 'Ottimizza database',
		'optimize_help' => 'Da fare occasionalmente per ridurre le dimensioni del database',
		'policy' => 'Purge policy',	// TODO
		'policy_warning' => 'If no purge policy is selected, every article will be kept.',	// TODO
		'purge_now' => 'Cancella ora',
		'title' => 'Archiviazione',
		'ttl' => 'Non effettuare aggiornamenti per più di',
	),
	'display' => array(
		'_' => 'Visualizzazione',
		'icon' => array(
			'bottom_line' => 'Barra in fondo',
			'display_authors' => 'Authors',	// TODO
			'entry' => 'Icone degli articoli',
			'publication_date' => 'Data di pubblicazione',
			'related_tags' => 'Tags correlati',
			'sharing' => 'Condivisione',
			'summary' => 'Summary',	// TODO
			'top_line' => 'Barra in alto',
		),
		'language' => 'Lingua',
		'notif_html5' => array(
			'seconds' => 'secondi (0 significa nessun timeout)',
			'timeout' => 'Notifica timeout HTML5',
		),
		'show_nav_buttons' => 'Show the navigation buttons',	// TODO
		'theme' => 'Tema',
		'theme_not_available' => 'The “%s” theme is not available anymore. Please choose another theme.',	// TODO
		'thumbnail' => array(
			'label' => 'Thumbnail',	// TODO
			'landscape' => 'Landscape',	// TODO
			'none' => 'None',	// TODO
			'portrait' => 'Portrait',	// TODO
			'square' => 'Square',	// TODO
		),
		'title' => 'Visualizzazione',
		'width' => array(
			'content' => 'Larghezza contenuto',
			'large' => 'Largo',
			'medium' => 'Medio',
			'no_limit' => 'Nessun limite',
			'thin' => 'Stretto',
		),
	),
	'logs' => array(
		'loglist' => array(
			'level' => 'Log Level',	// TODO
			'message' => 'Log Message',	// TODO
			'timestamp' => 'Timestamp',	// TODO
		),
		'pagination' => array(
			'first' => 'Prima',
			'last' => 'Ultima',
			'next' => 'Successiva',
			'previous' => 'Precedente',
		),
	),
	'profile' => array(
		'_' => 'Gestione profili',
		'api' => 'API management',	// TODO
		'delete' => array(
			'_' => 'Cancellazione account',
			'warn' => 'Il tuo account e tutti i dati associati saranno cancellati.',
		),
		'email' => 'Indirizzo email',
		'password_api' => 'Password API<br /><small>(e.g., per applicazioni mobili)</small>',
		'password_form' => 'Password<br /><small>(per il login classico)</small>',
		'password_format' => 'Almeno 7 caratteri',
		'title' => 'Profilo',
	),
	'query' => array(
		'_' => 'Ricerche personali',
		'deprecated' => 'Questa query non è più valida. La categoria o il feed di riferimento non stati cancellati.',
		'filter' => array(
			'_' => 'Filtro applicato:',
			'categories' => 'Display by category',	// TODO
			'feeds' => 'Display by feed',	// TODO
			'order' => 'Sort by date',	// TODO
			'search' => 'Expression',	// TODO
			'state' => 'State',	// TODO
			'tags' => 'Display by tag',	// TODO
			'type' => 'Type',	// TODO
		),
		'get_all' => 'Mostra tutti gli articoli',
		'get_category' => 'Mostra la categoria "%s" ',
		'get_favorite' => 'Mostra articoli preferiti',
		'get_feed' => 'Mostra feed "%s" ',
		'name' => 'Name',	// TODO
		'no_filter' => 'Nessun filtro',
		'number' => 'Ricerca n°%d',
		'order_asc' => 'Mostra prima gli articoli più vecchi',
		'order_desc' => 'Mostra prima gli articoli più nuovi',
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
	),
	'reading' => array(
		'_' => 'Lettura',
		'after_onread' => 'Dopo “segna tutto come letto”,',
		'always_show_favorites' => 'Show all articles in favourites by default',	// TODO
		'articles_per_page' => 'Numero di articoli per pagina',
		'auto_load_more' => 'Carica articoli successivi a fondo pagina',
		'auto_remove_article' => 'Nascondi articoli dopo la lettura',
		'confirm_enabled' => 'Mostra una conferma per “segna tutto come letto”',
		'display_articles_unfolded' => 'Mostra articoli aperti di predefinito',
		'display_categories_unfolded' => 'Categories to unfold',	// TODO
		'headline' => array(
			'articles' => 'Articles: Open/Close',	// TODO
			'categories' => 'Left navigation: Categories',	// TODO
			'mark_as_read' => 'Mark article as read',	// TODO
			'misc' => 'Miscellaneous',	// TODO
			'view' => 'View',	// TODO
		),
		'hide_read_feeds' => 'Nascondi categorie e feeds con articoli già letti (non funziona se “Mostra tutti gli articoli” è selezionato)',
		'img_with_lazyload' => 'Usa la modalità "caricamento ritardato" per le immagini',
		'jump_next' => 'Salta al successivo feed o categoria non letto',
		'mark_updated_article_unread' => 'Segna articoli aggiornati come non letti',
		'number_divided_when_reader' => 'Diviso 2 nella modalità di lettura.',
		'read' => array(
			'article_open_on_website' => 'Quando un articolo è aperto nel suo sito di origine',
			'article_viewed' => 'Quando un articolo viene letto',
			'keep_max_n_unread' => 'Max number of articles to keep unread',	// TODO
			'scroll' => 'Scorrendo la pagina',
			'upon_reception' => 'Alla ricezione del contenuto',
			'when' => 'Segna articoli come letti…',
			'when_same_title' => 'if an identical title already exists in the top <i>n</i> newest articles',	// TODO
		),
		'show' => array(
			'_' => 'Articoli da visualizzare',
			'active_category' => 'Active category',	// TODO
			'adaptive' => 'Adatta visualizzazione',
			'all_articles' => 'Mostra tutti gli articoli',
			'all_categories' => 'All categories',	// TODO
			'no_category' => 'No category',	// TODO
			'remember_categories' => 'Remember open categories',	// TODO
			'unread' => 'Mostra solo non letti',
		),
		'show_fav_unread_help' => 'Applies also on labels',	// TODO
		'sides_close_article' => 'Clicking outside of article text area closes the article',	// TODO
		'sort' => array(
			'_' => 'Ordinamento',
			'newer_first' => 'Prima i più recenti',
			'older_first' => 'Prima i più vecchi',
		),
		'sticky_post' => 'Blocca il contenuto a inizio pagina quando aperto',
		'title' => 'Lettura',
		'view' => array(
			'default' => 'Visualizzazione predefinita',
			'global' => 'Vista globale per categorie',
			'normal' => 'Vista elenco',
			'reader' => 'Modalità di lettura',
		),
	),
	'sharing' => array(
		'_' => 'Condivisione',
		'add' => 'Add a sharing method',	// TODO
		'blogotext' => 'Blogotext',	// IGNORE
		'diaspora' => 'Diaspora*',	// IGNORE
		'email' => 'Email',	// TODO
		'facebook' => 'Facebook',	// IGNORE
		'more_information' => 'Ulteriori informazioni',
		'print' => 'Stampa',
		'raindrop' => 'Raindrop.io',	// IGNORE
		'remove' => 'Remove sharing method',	// TODO
		'shaarli' => 'Shaarli',	// IGNORE
		'share_name' => 'Nome condivisione',
		'share_url' => 'URL condivisione',
		'title' => 'Condividi',
		'twitter' => 'Twitter',	// IGNORE
		'wallabag' => 'wallabag',	// IGNORE
	),
	'shortcut' => array(
		'_' => 'Comandi tastiera',
		'article_action' => 'Azioni sugli articoli',
		'auto_share' => 'Condividi',
		'auto_share_help' => 'Se è presente un solo servizio di condivisione verrà usato quello, altrimenti usare anche il numero associato.',
		'close_dropdown' => 'Chiudi menù',
		'collapse_article' => 'Collassa articoli',
		'first_article' => 'Salta al primo articolo',
		'focus_search' => 'Modulo di ricerca',
		'global_view' => 'Switch to global view',	// TODO
		'help' => 'Mostra documentazione',
		'javascript' => 'JavaScript deve essere abilitato per poter usare i comandi da tastiera',
		'last_article' => 'Salta all ultimo articolo',
		'load_more' => 'Carica altri articoli',
		'mark_favorite' => 'Segna come preferito',
		'mark_read' => 'Segna come letto',
		'navigation' => 'Navigazione',
		'navigation_help' => 'Con il tasto <kbd>⇧ Shift</kbd> i comandi di navigazione verranno applicati ai feeds.<br/>Con il tasto <kbd>Alt ⎇</kbd> i comandi di navigazione verranno applicati alle categorie.',
		'navigation_no_mod_help' => 'The following navigation shortcuts do not support modifiers.',	// TODO
		'next_article' => 'Salta al contenuto successivo',
		'next_unread_article' => 'Open the next unread article',	// TODO
		'non_standard' => 'Some keys (<kbd>%s</kbd>) may not work as shortcuts.',	// TODO
		'normal_view' => 'Switch to normal view',	// TODO
		'other_action' => 'Altre azioni',
		'previous_article' => 'Salta al contenuto precedente',
		'reading_view' => 'Switch to reading view',	// TODO
		'rss_view' => 'Open as RSS feed',	// TODO
		'see_on_website' => 'Vai al sito fonte',
		'shift_for_all_read' => '+ <kbd>Alt ⎇</kbd> to mark previous articles as read<br />+ <kbd>⇧ Shift</kbd> to mark all articles as read',	// TODO
		'skip_next_article' => 'Focus next without opening',	// TODO
		'skip_previous_article' => 'Focus previous without opening',	// TODO
		'title' => 'Comandi da tastiera',
		'toggle_media' => 'Play/pause media',	// TODO
		'user_filter' => 'Accedi alle ricerche personali',
		'user_filter_help' => 'Se è presente una sola ricerca personale verrà usata quella, altrimenti usare anche il numero associato.',
		'views' => 'Views',	// TODO
	),
	'user' => array(
		'articles_and_size' => '%s articoli (%s)',
		'current' => 'Utente connesso',
		'is_admin' => 'è amministratore',
		'users' => 'Utenti',
	),
);
