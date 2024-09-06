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
		'exception' => 'Eccezioni all’eliminazione automatica',
		'help' => 'Altre opzioni sono disponibili nelle impostazioni dei singoli feed',
		'keep_favourites' => 'Non eliminare mai i preferiti',
		'keep_labels' => 'Non eliminare mai le etichette',
		'keep_max' => 'Numero massimo di articoli da mantenere per feed',
		'keep_min_by_feed' => 'Numero minimo di articoli da mantenere per feed',
		'keep_period' => 'Massima durata degli articoli da mantenere',
		'keep_unreads' => 'Non eliminare mai gli articoli non letti',
		'maintenance' => 'Manutenzione',
		'optimize' => 'Ottimizza database',
		'optimize_help' => 'Da fare occasionalmente per ridurre le dimensioni del database',
		'policy' => 'Politiche di eliminazione automatica',
		'policy_warning' => 'Se non viene selezionata una politica di eliminazione automatica, ogni articolo sarà mantenuto.',
		'purge_now' => 'Cancella ora',
		'title' => 'Archiviazione',
		'ttl' => 'Non effettuare aggiornamenti per più di',
	),
	'display' => array(
		'_' => 'Visualizzazione',
		'darkMode' => array(
			'_' => 'Modalità scura automatica',
			'auto' => 'Auto',	// IGNORE
			'help' => 'For compatible themes only',	// TODO
			'no' => 'No',	// IGNORE
		),
		'icon' => array(
			'bottom_line' => 'Barra in fondo',
			'display_authors' => 'Autori',
			'entry' => 'Icone degli articoli',
			'publication_date' => 'Data di pubblicazione',
			'related_tags' => 'Tags correlati',
			'sharing' => 'Condivisione',
			'summary' => 'Sommario',
			'top_line' => 'Barra in alto',
		),
		'language' => 'Lingua',
		'notif_html5' => array(
			'seconds' => 'secondi (0 significa nessun timeout)',
			'timeout' => 'Notifica timeout HTML5',
		),
		'show_nav_buttons' => 'Mostra i pulsanti di navigazione',
		'theme' => array(
			'_' => 'Tema',
			'deprecated' => array(
				'_' => 'Deprecato',
				'description' => 'Questo tema non è più supportato e non sarà più disponibile in un <a href="https://freshrss.github.io/FreshRSS/en/users/05_Configuration.html#theme" target="_blank">futuro rilascio di FreshRSS</a>',
			),
		),
		'theme_not_available' => 'Il tema “%s” non è più disponibile. Si prega di selezionarne un altro.',
		'thumbnail' => array(
			'label' => 'Miniatura',
			'landscape' => 'Panoramica',
			'none' => 'Nessuna',
			'portrait' => 'Ritratto',
			'square' => 'Squadrata',
		),
		'timezone' => 'Fuso orario',
		'title' => 'Visualizzazione',
		'website' => array(
			'full' => 'Icona e nome',
			'icon' => 'Solo icona',
			'label' => 'Sito web',
			'name' => 'Solo nome',
			'none' => 'Nessuno',
		),
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
			'level' => 'Livello di log',
			'message' => 'Messaggio di log',
			'timestamp' => 'Timestamp',	// IGNORE
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
		'api' => 'Gestione API',
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
		'description' => 'Description',	// TODO
		'filter' => array(
			'_' => 'Filtro applicato:',
			'categories' => 'Mostra per categoria',
			'feeds' => 'Mostra per feed',
			'order' => 'Ordina per data',
			'search' => 'Espressione',
			'shareOpml' => 'Abilita la condivisione di OPML di categorie e feed corrispondenti',
			'shareRss' => 'Abilita la condivisione di HTML &amp; RSS',
			'state' => 'Stato',
			'tags' => 'Tag',
			'type' => 'Tipo',
		),
		'get_all' => 'Mostra tutti gli articoli',
		'get_all_labels' => 'Mostra gli articoli con qualsiasi etichetta',
		'get_category' => 'Mostra la categoria “%s” ',
		'get_favorite' => 'Mostra articoli preferiti',
		'get_feed' => 'Mostra feed “%s” ',
		'get_important' => 'Mostra articoli dai feed importanti',
		'get_label' => 'Mostra articoli con l’etichetta “%s”',
		'help' => 'Vedi la <a href="https://freshrss.github.io/FreshRSS/en/users/user_queries.html" target="_blank">documentazione per le query utente e ricondivisioine tramite HTML / RSS / OPML</a>.',
		'image_url' => 'Image URL',	// TODO
		'name' => 'Nome',
		'no_filter' => 'Nessun filtro',
		'number' => 'Ricerca n°%d',
		'order_asc' => 'Mostra prima gli articoli più vecchi',
		'order_desc' => 'Mostra prima gli articoli più nuovi',
		'search' => 'Cerca per “%s”',
		'share' => array(
			'_' => 'Condividi questa query tramite un link',
			'greader' => 'Shareable link to the GReader JSON',	// TODO
			'help' => 'Fornisci questo link se vuoi condividere questa query con altre persone',
			'html' => 'Link condivisibile alla pagina HTML',
			'opml' => 'Link condivisibile alla lista OPML dei feed',
			'rss' => 'Link condivisibile al feed RSS',
		),
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
		'always_show_favorites' => 'Mostra tutti gli articoli nei preferiti di default',
		'article' => array(
			'authors_date' => array(
				'_' => 'Autori e data',
				'both' => 'Nell’intestazione e nel fondo pagina',
				'footer' => 'Nel fondo pagina',
				'header' => 'Nell’intestazione',
				'none' => 'Nessuno',
			),
			'feed_name' => array(
				'above_title' => 'Sopra il titolo/tag',
				'none' => 'Nessuno',
				'with_authors' => 'Nella riga degli autori e data',
			),
			'feed_title' => 'Titolo del feed',
			'icons' => array(
				'_' => 'Article icons position<br /><small>(Reading view only)</small>',	// TODO
				'above_title' => 'Above title',	// TODO
				'with_authors' => 'In authors and date row',	// TODO
			),
			'tags' => array(
				'_' => 'Tag',
				'both' => 'Nell’intestazione e nel fondo pagina',
				'footer' => 'Nel fondo pagina',
				'header' => 'Nell’intestazione',
				'none' => 'Nessuno',
			),
			'tags_max' => array(
				'_' => 'Numero massimo di tag mostrati',
				'help' => '0 significa: mostra tutti i tag e non raggrupparli',
			),
		),
		'articles_per_page' => 'Numero di articoli per pagina',
		'auto_load_more' => 'Carica articoli successivi a fondo pagina',
		'auto_remove_article' => 'Nascondi articoli dopo la lettura',
		'confirm_enabled' => 'Mostra una conferma per “segna tutto come letto”',
		'display_articles_unfolded' => 'Mostra articoli aperti di predefinito',
		'display_categories_unfolded' => 'Categorie da aprire',
		'headline' => array(
			'articles' => 'Articoli: Apri/Chiudi',
			'articles_header_footer' => 'Articoli: intestazione/fondo pagina',
			'categories' => 'Navigazione di sinistra: Categorie',
			'mark_as_read' => 'Segna gli articoli come letti',
			'misc' => 'Varie',
			'view' => 'Vista',
		),
		'hide_read_feeds' => 'Nascondi categorie e feed con articoli già letti (non funziona se “Mostra tutti gli articoli” è selezionato)',
		'img_with_lazyload' => 'Usa la modalità “caricamento ritardato” per le immagini',
		'jump_next' => 'Salta al successivo feed o categoria non letto',
		'mark_updated_article_unread' => 'Segna articoli aggiornati come non letti',
		'number_divided_when_reader' => 'Diviso 2 nella modalità di lettura.',
		'read' => array(
			'article_open_on_website' => 'Quando un articolo è aperto nel suo sito di origine',
			'article_viewed' => 'Quando un articolo viene letto',
			'focus' => 'quando l’articolo è in primo piano (eccetto per feed importanti)',
			'keep_max_n_unread' => 'Massimo numero di articoli da mantenere come non letti',
			'scroll' => 'Scorrendo la pagina (eccetto per feed importanti)',
			'upon_gone' => 'quando non si trova più nel feed di notizie in alto',
			'upon_reception' => 'Alla ricezione del contenuto',
			'when' => 'Segna articoli come letti…',
			'when_same_title' => 'se un titolo identico esiste già tra i <i>n</i> articoli più recenti',
		),
		'show' => array(
			'_' => 'Articoli da visualizzare',
			'active_category' => 'Categoria attiva',
			'adaptive' => 'Adatta visualizzazione',
			'all_articles' => 'Mostra tutti gli articoli',
			'all_categories' => 'Tutte le categorie',
			'no_category' => 'Nessuna categoria',
			'remember_categories' => 'Ricorda le categorie aperte',
			'unread' => 'Mostra solo non letti',
		),
		'show_fav_unread_help' => 'Si applica anche alle etichette',
		'sides_close_article' => 'Cliccare fuori dall’area di testo dell’articolo chiude l’articolo',
		'sort' => array(
			'_' => 'Ordinamento',
			'newer_first' => 'Prima i più recenti',
			'older_first' => 'Prima i più vecchi',
		),
		'star' => array(
			'when' => 'Mark an article as favourite…',	// TODO
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
		'add' => 'Aggiungi un metodo di condivisione',
		'deprecated' => 'Questo servizio è deprecato e sarà rimosso da FreshRSS in una <a href="https://freshrss.github.io/FreshRSS/en/users/08_sharing_services.html" title="Apri la documentazione per ulteriori informazioni" target="_blank">release successiva</a>.',
		'diaspora' => 'Diaspora*',	// IGNORE
		'email' => 'Email',	// IGNORE
		'facebook' => 'Facebook',	// IGNORE
		'more_information' => 'Ulteriori informazioni',
		'print' => 'Stampa',
		'raindrop' => 'Raindrop.io',	// IGNORE
		'remove' => 'Rimuovi metodo di condivisione',
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
		'global_view' => 'Passa alla vista globale',
		'help' => 'Mostra documentazione',
		'javascript' => 'JavaScript deve essere abilitato per poter usare i comandi da tastiera',
		'last_article' => 'Salta all ultimo articolo',
		'load_more' => 'Carica altri articoli',
		'mark_favorite' => 'Segna come preferito',
		'mark_read' => 'Segna come letto',
		'navigation' => 'Navigazione',
		'navigation_help' => 'Con il tasto <kbd>⇧ Shift</kbd> i comandi di navigazione verranno applicati ai feed.<br/>Con il tasto <kbd>Alt ⎇</kbd> i comandi di navigazione verranno applicati alle categorie.',
		'navigation_no_mod_help' => 'Le seguenti scorciatoie di navigazione non supportano i modificatori.',
		'next_article' => 'Salta al contenuto successivo',
		'next_unread_article' => 'Apri il prossimo articolo non letto',
		'non_standard' => 'Alcuni tasti (<kbd>%s</kbd>) potrebbero non funzionare come scorciatoie.',
		'normal_view' => 'Passa alla vista normale',
		'other_action' => 'Altre azioni',
		'previous_article' => 'Salta al contenuto precedente',
		'reading_view' => 'Passa alla modalità lettura',
		'rss_view' => 'Apri come feed RSS',
		'see_on_website' => 'Vai al sito fonte',
		'shift_for_all_read' => '+ <kbd>Alt ⎇</kbd> per segnare i precedenti articoli come già letti<br />+ <kbd>⇧ Shift</kbd> per segnare tutti gli articoli come già letti',
		'skip_next_article' => 'Evidenzia il prossimo senza aprire',
		'skip_previous_article' => 'Evidenzia il precedente senza aprire',
		'title' => 'Comandi da tastiera',
		'toggle_media' => 'Riproduci/Metti in pausa i media',
		'user_filter' => 'Accedi alle ricerche personali',
		'user_filter_help' => 'Se è presente una sola ricerca personale verrà usata quella, altrimenti usare anche il numero associato.',
		'views' => 'Viste',
	),
	'user' => array(
		'articles_and_size' => '%s articoli (%s)',
		'current' => 'Utente connesso',
		'is_admin' => 'è amministratore',
		'users' => 'Utenti',
	),
);
