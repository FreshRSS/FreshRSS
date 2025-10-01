<?php

/******************************************************************************
 * Each entry of that file can be associated with a comment to indicate its   *
 * state. When there is no comment, it means the entry is fully translated.   *
 * The recognized comments are (comment matching is case-insensitive):        *
 *   + TODO: the entry has never been translated.                             *
 *   + DIRTY: the entry has been translated but needs to be updated.          *
 *   + IGNORE: the entry does not need to be translated.                      *
 * When a comment is not recognized, it is discarded.                         *
 ******************************************************************************/

return array(
	'action' => array(
		'actualize' => 'Hírforrások frissítése',
		'add' => 'Hozzáad',
		'back_to_rss_feeds' => '← Vissza az RSS hírforrásokhoz',
		'cancel' => 'Mégsem',
		'close' => 'Bezár',
		'create' => 'Létrehoz',
		'delete_all_feeds' => 'Minden hírforrás törlése',
		'delete_errored_feeds' => 'Hibákkal rendelkező hírforrások törlése',
		'delete_muted_feeds' => 'Némított hírforrások törlése',
		'demote' => 'Lefokoz',
		'disable' => 'Kikapcsol',
		'download' => 'Letöltés',
		'empty' => 'Üres',
		'enable' => 'Bekapcsol',
		'export' => 'Exportálás',
		'filter' => 'Szűrő',
		'import' => 'Importálás',
		'load_default_shortcuts' => 'Alapértelmezett gyorsgombok visszaállítása',
		'manage' => 'Kezelés',
		'mark_read' => 'Megjelölés olvasottként',
		'menu' => array(
			'open' => 'Menü megnyitása',
		),
		'nav_buttons' => array(
			'next' => 'Következő cikk',
			'prev' => 'Előző cikk',
			'up' => 'Ugrás fel',
		),
		'open_url' => 'URL Megnyitása',
		'promote' => 'Előléptet',
		'purge' => 'Töröl',
		'refresh_opml' => 'OPML frissítése',
		'remove' => 'Eltávolít',
		'rename' => 'Átnevez',
		'see_website' => 'Ugrás a forrásra',
		'submit' => 'Mentés',
		'truncate' => 'Minden cikk törlése',
		'update' => 'Frissít',
	),
	'auth' => array(
		'accept_tos' => 'Elfogadom a <a href="%s">Szolgáltatási Feltételeket</a>.',
		'email' => 'Email cím',
		'keep_logged_in' => 'Tarts bejelentkezve <small>(%s napig)</small>',
		'login' => 'Bejelentkezés',
		'logout' => 'Kijelentkezés',
		'password' => array(
			'_' => 'Jelszó',
			'format' => '<small>Legalább 7 karakter hosszú</small>',
		),
		'reauth' => array(
			'header' => 'Be kell jelentkeznie újra',
			'tip' => 'Ezután <u>%d percig</u> nem kell újra bejelentkeznie',
			'title' => 'Bejelentkezés újra',
		),
		'registration' => array(
			'_' => 'Új fiók',
			'ask' => 'Létrehoz egy új fiókot?',
			'title' => 'Fiók létrehozása',
		),
		'username' => array(
			'_' => 'Felhasználó név',
			'format' => '<small>Maximum 16 alfanumerikus karakter</small>',
		),
	),
	'date' => array(
		'Apr' => '\\Á\\p\\r\\i\\l\\i\\s',
		'Aug' => '\\A\\u\\g\\u\\s\\z\\t\\u\\s',
		'Dec' => '\\D\\e\\c\\e\\m\\b\\e\\r',	// IGNORE
		'Feb' => '\\F\\e\\b\\r\\u\\á\\r',
		'Jan' => '\\J\\a\\n\\u\\á\\r',
		'Jul' => '\\J\\ú\\l\\i\\u\\s',
		'Jun' => '\\J\\ú\\n\\i\\u\\s',
		'Mar' => '\\M\\á\\r\\c\\i\\u\\s',
		'May' => '\\M\\á\\j\\u\\s',
		'Nov' => '\\N\\o\\v\\e\\m\\b\\e\\r',	// IGNORE
		'Oct' => '\\O\\k\\t\\ó\\b\\e\\r',
		'Sep' => '\\S\\z\\e\\p\\t\\e\\m\\b\\e\\r',
		'apr' => 'Ápr.',
		'april' => 'Április',
		'aug' => 'Aug.',	// IGNORE
		'august' => 'Augusztus',
		'before_yesterday' => 'Tegnapelőtt',
		'dec' => 'Dec.',	// IGNORE
		'december' => 'December',	// IGNORE
		'feb' => 'Feb.',	// IGNORE
		'february' => 'Február',
		'format_date' => 'j %s Y',	// IGNORE
		'format_date_hour' => 'Y %s j H\\:i',
		'fri' => 'Péntek',
		'jan' => 'Jan.',	// IGNORE
		'january' => 'Január',
		'jul' => 'Júl.',
		'july' => 'Július',
		'jun' => 'Jún.',
		'june' => 'Június',
		'last_2_year' => 'Utolsó két év',
		'last_3_month' => 'Utolsó három hónap',
		'last_3_year' => 'Utolsó három év',
		'last_5_year' => 'Utolsó öt év',
		'last_6_month' => 'Utolsó hat hónap',
		'last_month' => 'Múlt hónap',
		'last_week' => 'Múlt hét',
		'last_year' => 'Múlt év',
		'mar' => 'Már.',
		'march' => 'Március',
		'may' => 'Máj',
		'may_' => 'Május',
		'mon' => 'Hétfő',
		'month' => 'hónap',
		'nov' => 'Nov.',	// IGNORE
		'november' => 'November',	// IGNORE
		'oct' => 'Okt.',
		'october' => 'Október',
		'sat' => 'Szombat',
		'sep' => 'Szept.',
		'september' => 'Szeptember',
		'sun' => 'Vasárnap',
		'thu' => 'Csütörtök',
		'today' => 'Ma',
		'tue' => 'Kedd',
		'wed' => 'Szerda',
		'yesterday' => 'Tegnap',
	),
	'dir' => 'ltr',	// IGNORE
	'flag' => '🇭🇺',
	'freshrss' => array(
		'_' => 'FreshRSS',	// IGNORE
		'about' => 'FreshRSS névjegy',
	),
	'js' => array(
		'category_empty' => 'Üres kategória',
		'confirm_action' => 'Biztos vagy benne hogy végrehajtod ezt a műveletet? A művelet nem megszakítható!',
		'confirm_action_feed_cat' => 'Biztos hogy végrehajtod ezt a műveletet? Minden kapcsolódó kedvenc és lekérdezés törölve lesz. Nem lehet megszakítani!',
		'confirm_exit_slider' => 'Biztosan elveti a nem mentett beállításokat?',
		'feedback' => array(
			'body_new_articles' => '%%d db új cikk olvasható a FreshRSS-ben.',
			'body_unread_articles' => '(olvasatlan: %%d)',
			'request_failed' => 'Egy művelet nem sikerült, lehetséges hogy az internet kapcsolattal vannak problémák.',
			'title_new_articles' => 'FreshRSS: új cikkek!',
		),
		'labels_empty' => 'Nincsenek címkék',
		'new_article' => 'Új cikkek elérhetőek, kattints a lap frissítéséhez.',
		'should_be_activated' => 'A JavaScript futtatásának engedélyezve kell lennie',
		'unsafe_csp_header' => 'A CSP fejléc használata nem biztonságos és a FreshRSS sebezhető lehet az XSS támadásokkal szemben. <a target="_blank" href="https://freshrss.github.io/FreshRSS/en/admins/10_ServerConfig.html#security">Lásd dokumentáció</a>',
	),
	'lang' => array(
		'cs' => 'Čeština',	// IGNORE
		'de' => 'Deutsch',	// IGNORE
		'el' => 'Ελληνικά',	// IGNORE
		'en' => 'English',	// IGNORE
		'en-us' => 'English (United States)',	// IGNORE
		'es' => 'Español',	// IGNORE
		'fa' => 'فارسی',	// IGNORE
		'fi' => 'Suomi',	// IGNORE
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
		'pt-pt' => 'Português (Portugal)',	// IGNORE
		'ru' => 'Русский',	// IGNORE
		'sk' => 'Slovenčina',	// IGNORE
		'tr' => 'Türkçe',	// IGNORE
		'uk' => 'Українська',	// IGNORE
		'zh-cn' => '简体中文',	// IGNORE
		'zh-tw' => '正體中文',	// IGNORE
	),
	'menu' => array(
		'about' => 'Névjegy',
		'account' => 'Fiók',
		'admin' => 'Adminisztráció',
		'archiving' => 'Archiválás',
		'authentication' => 'Hitelesítés',
		'check_install' => 'Telepítés ellenőrzése',
		'configuration' => 'Konfiguráció',
		'display' => 'Megjelenítés',
		'extensions' => 'Kiegészítők',
		'logs' => 'Log-ok',
		'privacy' => 'Adatvédelem',
		'queries' => 'Felhasználói lekérdezések',
		'reading' => 'Olvasás',
		'search' => 'Szavak vagy #címkék keresése',
		'search_help' => 'Lásd a dokumentációt a haladó <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">keresési paraméterekhez</a>',
		'sharing' => 'Megosztás',
		'shortcuts' => 'Gyorsgombok',
		'stats' => 'Statisztika',
		'system' => 'Rendszer konfiguráció',
		'update' => 'Frissítés',
		'user_management' => 'Felhasználók kezelése',
		'user_profile' => 'Profil',
	),
	'period' => array(
		'days' => 'nap',
		'hours' => 'óra',
		'months' => 'hónap',
		'weeks' => 'hét',
		'years' => 'év',
	),
	'share' => array(
		'Known' => 'Ismert weboldalak',
		'archiveIS' => 'archive.is',	// IGNORE
		'archiveORG' => 'archive.org',	// IGNORE
		'archivePH' => 'archive.ph',	// IGNORE
		'bluesky' => 'Bluesky',	// IGNORE
		'buffer' => 'Buffer',	// IGNORE
		'clipboard' => 'Clipboard',	// IGNORE
		'diaspora' => 'Diaspora*',	// IGNORE
		'email' => 'Email',	// IGNORE
		'email-webmail-firefox-fix' => 'Email (webmail - fix for Firefox)',	// IGNORE
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
		'print' => 'Print',	// IGNORE
		'raindrop' => 'Raindrop.io',	// IGNORE
		'reddit' => 'Reddit',	// IGNORE
		'shaarli' => 'Shaarli',	// IGNORE
		'telegram' => 'Telegram',	// IGNORE
		'twitter' => 'Twitter',	// IGNORE
		'wallabag' => 'wallabag v1',	// IGNORE
		'wallabagv2' => 'wallabag v2',	// IGNORE
		'web-sharing-api' => 'System sharing',	// IGNORE
		'whatsapp' => 'Whatsapp',	// IGNORE
		'xing' => 'Xing',	// IGNORE
	),
	'short' => array(
		'attention' => 'Figyelmeztetés!',
		'blank_to_disable' => 'Hagyd üresen a kikapcsoláshoz',
		'by_author' => 'Készítette:',
		'by_default' => 'Alapértelmezés',
		'damn' => 'A fenébe!',
		'default_category' => 'Kategória nélküli',
		'no' => 'Nem',
		'not_applicable' => 'Nem elérhető',
		'ok' => 'Oké!',
		'or' => 'vagy',
		'yes' => 'Igen',
	),
	'stream' => array(
		'load_more' => 'Több cikk betöltése',
		'mark_all_read' => 'Minden megjelölése olvasottként',
		'nothing_to_load' => 'Nincs több cikk',
	),
);
