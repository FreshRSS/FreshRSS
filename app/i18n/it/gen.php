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
		'add' => 'Add',	// TODO
		'back' => '← Go back',	// TODO
		'back_to_rss_feeds' => '← Indietro',
		'cancel' => 'Annulla',
		'create' => 'Crea',
		'demote' => 'Demote',	// TODO
		'disable' => 'Disabilita',
		'empty' => 'Vuoto',
		'enable' => 'Abilita',
		'export' => 'Esporta',
		'filter' => 'Filtra',
		'import' => 'Importa',
		'load_default_shortcuts' => 'Load default shortcuts',	// TODO
		'manage' => 'Gestisci',
		'mark_read' => 'Segna come letto',
		'promote' => 'Promote',	// TODO
		'purge' => 'Purge',	// TODO
		'remove' => 'Rimuovi',
		'rename' => 'Rename',	// TODO
		'see_website' => 'Vai al sito',
		'submit' => 'Conferma',
		'truncate' => 'Cancella tutti gli articoli',
		'update' => 'Update',	// TODO
	),
	'auth' => array(
		'accept_tos' => 'I accept the <a href="%s">Terms of Service</a>.',	// TODO
		'email' => 'Indirizzo email',
		'keep_logged_in' => 'Ricorda i dati <small>(%s giorni)</small>',
		'login' => 'Accedi',
		'logout' => 'Esci',
		'password' => array(
			'_' => 'Password',	// TODO
			'format' => '<small>almeno 7 caratteri</small>',
		),
		'registration' => array(
			'_' => 'Nuovo profilo',
			'ask' => 'Vuoi creare un nuovo profilo?',
			'title' => 'Creazione profilo',
		),
		'username' => array(
			'_' => 'Username',	// TODO
			'format' => '<small>Massimo 16 caratteri alfanumerici</small>',
		),
	),
	'date' => array(
		'Apr' => '\\A\\p\\r\\i\\l\\e',
		'Aug' => '\\A\\g\\o\\s\\t\\o',
		'Dec' => '\\D\\i\\c\\e\\m\\b\\r\\e',
		'Feb' => '\\F\\e\\b\\b\\r\\a\\i\\o',
		'Jan' => '\\G\\e\\n\\u\\a\\i\\o',
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
		'fri' => 'Fri',	// TODO
		'jan' => 'genn.',
		'january' => 'gennaio',
		'jul' => 'jul',
		'july' => 'luglio',
		'jun' => 'jun',
		'june' => 'giugno',
		'last_2_year' => 'Last two years',	// TODO
		'last_3_month' => 'Ultimi 3 mesi',
		'last_3_year' => 'Last three years',	// TODO
		'last_5_year' => 'Last five years',	// TODO
		'last_6_month' => 'Ultimi 6 mesi',
		'last_month' => 'Ultimo mese',
		'last_week' => 'Ultima settimana',
		'last_year' => 'Ultimo anno',
		'mar' => 'mar.',
		'march' => 'marzo',
		'may' => 'maggio',
		'may_' => 'May',	// TODO
		'mon' => 'Mon',	// TODO
		'month' => 'mesi',
		'nov' => 'nov.',
		'november' => 'novembre',
		'oct' => 'ott.',
		'october' => 'ottobre',
		'sat' => 'Sat',	// TODO
		'sep' => 'sett.',
		'september' => 'settembre',
		'sun' => 'Sun',	// TODO
		'thu' => 'Thu',	// TODO
		'today' => 'Oggi',
		'tue' => 'Tue',	// TODO
		'wed' => 'Wed',	// TODO
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
			'body_unread_articles' => '(unread: %%d)',	// TODO
			'request_failed' => 'Richiesta fallita, probabilmente a causa di problemi di connessione',
			'title_new_articles' => 'Feed RSS Reader: nuovi articoli!',
		),
		'new_article' => 'Sono disponibili nuovi articoli, clicca qui per caricarli.',
		'should_be_activated' => 'JavaScript deve essere abilitato',
	),
	'lang' => array(
		'cz' => 'Čeština',	// IGNORE
		'de' => 'Deutsch',	// IGNORE
		'en' => 'English',	// IGNORE
		'en-us' => 'English (United States)',	// IGNORE
		'es' => 'Español',	// IGNORE
		'fr' => 'Français',	// IGNORE
		'he' => 'עברית',	// IGNORE
		'it' => 'Italiano',	// IGNORE
		'ja' => '日本語',	// IGNORE
		'ko' => '한국어',	// IGNORE
		'nl' => 'Nederlands',	// IGNORE
		'oc' => 'Occitan',	// IGNORE
		'pl' => 'Polski',	// IGNORE
		'pt-br' => 'Português (Brasil)',	// IGNORE
		'ru' => 'Русский',	// IGNORE
		'sk' => 'Slovenčina',	// IGNORE
		'tr' => 'Türkçe',	// IGNORE
		'zh-cn' => '简体中文',	// IGNORE
	),
	'menu' => array(
		'about' => 'Informazioni',
		'account' => 'Account',	// TODO
		'admin' => 'Amministrazione',
		'archiving' => 'Archiviazione',
		'authentication' => 'Autenticazione',
		'check_install' => 'Installazione',
		'configuration' => 'Configurazione',
		'display' => 'Visualizzazione',
		'extensions' => 'Estensioni',
		'logs' => 'Logs',	// TODO
		'queries' => 'Ricerche personali',
		'reading' => 'Lettura',
		'search' => 'Ricerca parole o #tags',
		'sharing' => 'Condivisione',
		'shortcuts' => 'Comandi tastiera',
		'stats' => 'Statistiche',
		'system' => 'Configurazione sistema',
		'update' => 'Aggiornamento',
		'user_management' => 'Gestione utenti',
		'user_profile' => 'Profilo',
	),
	'pagination' => array(
		'first' => 'Prima',
		'last' => 'Ultima',
		'next' => 'Successiva',
		'previous' => 'Precedente',
	),
	'period' => array(
		'days' => 'days',	// TODO
		'hours' => 'hours',	// TODO
		'months' => 'months',	// TODO
		'weeks' => 'weeks',	// TODO
		'years' => 'years',	// TODO
	),
	'share' => array(
		'Known' => 'Siti basati su Known',
		'blogotext' => 'Blogotext',	// IGNORE
		'clipboard' => 'Clipboard',	// TODO
		'diaspora' => 'Diaspora*',	// IGNORE
		'email' => 'Email',	// TODO
		'facebook' => 'Facebook',	// IGNORE
		'gnusocial' => 'GNU social',	// IGNORE
		'jdh' => 'Journal du hacker',	// IGNORE
		'lemmy' => 'Lemmy',	// IGNORE
		'linkedin' => 'LinkedIn',	// IGNORE
		'mastodon' => 'Mastodon',	// IGNORE
		'movim' => 'Movim',	// IGNORE
		'pinboard' => 'Pinboard',	// IGNORE
		'pocket' => 'Pocket',	// IGNORE
		'print' => 'Stampa',
		'raindrop' => 'Raindrop.io',	// IGNORE
		'reddit' => 'Reddit',	// TODO
		'shaarli' => 'Shaarli',	// IGNORE
		'twitter' => 'Twitter',	// IGNORE
		'wallabag' => 'wallabag v1',	// IGNORE
		'wallabagv2' => 'wallabag v2',	// IGNORE
		'xing' => 'Xing',	// TODO
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
