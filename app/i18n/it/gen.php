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
	'action' => array(
		'actualize' => 'Aggiorna feeds',
		'add' => 'Aggiungi',
		'back' => '← Torna indietro',
		'back_to_rss_feeds' => '← Indietro',
		'cancel' => 'Annulla',
		'create' => 'Crea',
		'delete_muted_feeds' => 'Cancella i feed mutati',
		'demote' => 'Retrocedi',
		'disable' => 'Disabilita',
		'empty' => 'Vuoto',
		'enable' => 'Abilita',
		'export' => 'Esporta',
		'filter' => 'Filtra',
		'import' => 'Importa',
		'load_default_shortcuts' => 'Carica le scorciatoie di default',
		'manage' => 'Gestisci',
		'mark_read' => 'Segna come letto',
		'menu' => array(
			'open' => 'Open menu',	// TODO
		),
		'nav_buttons' => array(
			'next' => 'Next article',	// TODO
			'prev' => 'Previous article',	// TODO
			'up' => 'Go up',	// TODO
		),
		'open_url' => 'Apri URL',
		'promote' => 'Promuovi',
		'purge' => 'Elimina',
		'refresh_opml' => 'Ricarica OPML',
		'remove' => 'Rimuovi',
		'rename' => 'Rinomina',
		'see_website' => 'Vai al sito',
		'submit' => 'Conferma',
		'truncate' => 'Cancella tutti gli articoli',
		'update' => 'Aggiorna',
	),
	'auth' => array(
		'accept_tos' => 'Accetto i <a href="%s">Termini e condizioni del servizio</a>.',
		'email' => 'Indirizzo email',
		'keep_logged_in' => 'Ricorda i dati <small>(%s giorni)</small>',
		'login' => 'Accedi',
		'logout' => 'Esci',
		'password' => array(
			'_' => 'Password',	// IGNORE
			'format' => '<small>almeno 7 caratteri</small>',
		),
		'registration' => array(
			'_' => 'Nuovo profilo',
			'ask' => 'Vuoi creare un nuovo profilo?',
			'title' => 'Creazione profilo',
		),
		'username' => array(
			'_' => 'Nome utente',
			'format' => '<small>Massimo 16 caratteri alfanumerici</small>',
		),
	),
	'date' => array(
		'Apr' => '\\A\\p\\r\\i\\l\\e',
		'Aug' => '\\A\\g\\o\\s\\t\\o',
		'Dec' => '\\D\\i\\c\\e\\m\\b\\r\\e',
		'Feb' => '\\F\\e\\b\\b\\r\\a\\i\\o',
		'Jan' => '\\G\\e\\n\\n\\a\\i\\o',
		'Jul' => '\\L\\u\\g\\l\\i\\o',
		'Jun' => '\\G\\i\\u\\g\\n\\o',
		'Mar' => '\\M\\a\\r\\z\\o',
		'May' => '\\M\\a\\g\\g\\i\\o',
		'Nov' => '\\N\\o\\v\\e\\m\\b\\r\\e',
		'Oct' => '\\O\\t\\t\\o\\b\\r\\e',
		'Sep' => '\\S\\e\\t\\t\\e\\m\\b\\r\\e',
		'apr' => 'apr.',
		'april' => 'aprile',
		'aug' => 'ag.',
		'august' => 'agosto',
		'before_yesterday' => 'Meno recenti',
		'dec' => 'dic.',
		'december' => 'dicembre',
		'feb' => 'febbr.',
		'february' => 'febbraio',
		'format_date' => 'j\\ %s Y',
		'format_date_hour' => 'j\\ %s Y \\o\\r\\e H\\:i',
		'fri' => 'Ven',
		'jan' => 'genn.',
		'january' => 'gennaio',
		'jul' => 'jul',
		'july' => 'luglio',
		'jun' => 'jun',
		'june' => 'giugno',
		'last_2_year' => 'Ultimi due anni',
		'last_3_month' => 'Ultimi tre mesi',
		'last_3_year' => 'Ultimi tre anni',
		'last_5_year' => 'Ultimi cinque anni',
		'last_6_month' => 'Ultimi sei mesi',
		'last_month' => 'Ultimo mese',
		'last_week' => 'Ultima settimana',
		'last_year' => 'Ultimo anno',
		'mar' => 'mar.',
		'march' => 'marzo',
		'may' => 'maggio',
		'may_' => 'Mag',
		'mon' => 'Lun',
		'month' => 'mesi',
		'nov' => 'nov.',
		'november' => 'novembre',
		'oct' => 'ott.',
		'october' => 'ottobre',
		'sat' => 'Sab',
		'sep' => 'sett.',
		'september' => 'settembre',
		'sun' => 'Dom',
		'thu' => 'Gio',
		'today' => 'Oggi',
		'tue' => 'Mar',
		'wed' => 'Mer',
		'yesterday' => 'Ieri',
	),
	'dir' => 'ltr',	// IGNORE
	'freshrss' => array(
		'_' => 'Feed RSS Reader',
		'about' => 'Informazioni',
	),
	'js' => array(
		'category_empty' => 'Categoria vuota',
		'confirm_action' => 'Sei sicuro di voler continuare?',
		'confirm_action_feed_cat' => 'Sei sicuro di voler continuare? Verranno persi i preferiti e le ricerche utente correlate!',
		'feedback' => array(
			'body_new_articles' => 'Ci sono %%d nuovi articoli da leggere.',
			'body_unread_articles' => '(non letti: %%d)',
			'request_failed' => 'Richiesta fallita, probabilmente a causa di problemi di connessione',
			'title_new_articles' => 'Feed RSS Reader: nuovi articoli!',
		),
		'labels_empty' => 'Nessun tag',
		'new_article' => 'Sono disponibili nuovi articoli, clicca qui per caricarli.',
		'should_be_activated' => 'JavaScript deve essere abilitato',
	),
	'lang' => array(
		'cs' => 'Čeština',	// IGNORE
		'de' => 'Deutsch',	// IGNORE
		'el' => 'Ελληνικά',	// IGNORE
		'en' => 'English',	// IGNORE
		'en-us' => 'English (United States)',	// IGNORE
		'es' => 'Español',	// IGNORE
		'fa' => 'فارسی',	// IGNORE
		'fr' => 'Français',	// IGNORE
		'he' => 'עברית',	// IGNORE
		'hu' => 'Magyar',	// IGNORE
		'id' => 'Bahasa Indonesia',	// IGNORE
		'it' => 'Italiano',	// IGNORE
		'ja' => '日本語',	// IGNORE
		'ko' => '한국어',	// IGNORE
		'lv' => 'Latviešu',	// IGNORE
		'nl' => 'Nederlands',	// IGNORE
		'oc' => 'Occitan',	// IGNORE
		'pl' => 'Polski',	// IGNORE
		'pt-br' => 'Português (Brasil)',	// IGNORE
		'ru' => 'Русский',	// IGNORE
		'sk' => 'Slovenčina',	// IGNORE
		'tr' => 'Türkçe',	// IGNORE
		'zh-cn' => '简体中文',	// IGNORE
		'zh-tw' => '正體中文',	// IGNORE
	),
	'menu' => array(
		'about' => 'Informazioni',
		'account' => 'Profilo',
		'admin' => 'Amministrazione',
		'archiving' => 'Archiviazione',
		'authentication' => 'Autenticazione',
		'check_install' => 'Installazione',
		'configuration' => 'Configurazione',
		'display' => 'Visualizzazione',
		'extensions' => 'Estensioni',
		'logs' => 'Log',
		'queries' => 'Ricerche personali',
		'reading' => 'Lettura',
		'search' => 'Ricerca parole o #tags',
		'search_help' => 'Vedi la documentazione per <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">parametri di ricerca avanzati</a>',
		'sharing' => 'Condivisione',
		'shortcuts' => 'Comandi tastiera',
		'stats' => 'Statistiche',
		'system' => 'Configurazione sistema',
		'update' => 'Aggiornamento',
		'user_management' => 'Gestione utenti',
		'user_profile' => 'Profilo',
	),
	'period' => array(
		'days' => 'giorni',
		'hours' => 'ore',
		'months' => 'mesi',
		'weeks' => 'settimane',
		'years' => 'anni',
	),
	'share' => array(
		'Known' => 'Siti basati su Known',
		'archiveIS' => 'archive.is',	// IGNORE
		'archiveORG' => 'archive.org',	// IGNORE
		'archivePH' => 'archive.ph',	// IGNORE
		'buffer' => 'Buffer',	// IGNORE
		'clipboard' => 'Appunti',
		'diaspora' => 'Diaspora*',	// IGNORE
		'email' => 'Email',	// IGNORE
		'email-webmail-firefox-fix' => 'Email (webmail - fix per Firefox)',
		'facebook' => 'Facebook',	// IGNORE
		'gnusocial' => 'GNU social',	// IGNORE
		'jdh' => 'Journal du hacker',	// IGNORE
		'lemmy' => 'Lemmy',	// IGNORE
		'linkding' => 'Linkding',	// IGNORE
		'linkedin' => 'LinkedIn',	// IGNORE
		'mastodon' => 'Mastodon',	// IGNORE
		'movim' => 'Movim',	// IGNORE
		'omnivore' => 'Omnivore',	// IGNORE
		'pinboard' => 'Pinboard',	// IGNORE
		'pinterest' => 'Pinterest',	// IGNORE
		'pocket' => 'Pocket',	// IGNORE
		'print' => 'Stampa',
		'raindrop' => 'Raindrop.io',	// IGNORE
		'reddit' => 'Reddit',	// IGNORE
		'shaarli' => 'Shaarli',	// IGNORE
		'twitter' => 'Twitter',	// IGNORE
		'wallabag' => 'wallabag v1',	// IGNORE
		'wallabagv2' => 'wallabag v2',	// IGNORE
		'web-sharing-api' => 'Condivisione di sistema',
		'whatsapp' => 'Whatsapp',	// IGNORE
		'xing' => 'Xing',	// IGNORE
	),
	'short' => array(
		'attention' => 'Attenzione!',
		'blank_to_disable' => 'Lascia vuoto per disabilitare',
		'by_author' => 'di:',
		'by_default' => 'predefinito',
		'damn' => 'Ops!',
		'default_category' => 'Senza categoria',
		'no' => 'No',	// IGNORE
		'not_applicable' => 'Non disponibile',
		'ok' => 'OK!',
		'or' => 'o',
		'yes' => 'Si',
	),
	'stream' => array(
		'load_more' => 'Carica altri articoli',
		'mark_all_read' => 'Segna tutto come letto',
		'nothing_to_load' => 'Non ci sono altri articoli',
	),
);
