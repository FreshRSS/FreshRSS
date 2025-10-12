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
		'actualize' => 'Päivitä syötteet',
		'add' => 'Lisää',
		'back_to_rss_feeds' => '← Palaa RSS-syötteisiin',
		'cancel' => 'Peruuta',
		'close' => 'Sulje',
		'create' => 'Luo',
		'delete_all_feeds' => 'Poista kaikki syötteet',
		'delete_errored_feeds' => 'Poista virheelliset syötteet',
		'delete_muted_feeds' => 'Poista vaimennetut syötteet',
		'demote' => 'Laske tärkeyttä',
		'disable' => 'Poista käytöstä',
		'download' => 'Lataa',
		'empty' => 'Tyhjennä',
		'enable' => 'Ota käyttöön',
		'export' => 'Vie',
		'filter' => 'Suodata',
		'import' => 'Tuo',
		'load_default_shortcuts' => 'Lataa oletuspikanäppäimet',
		'manage' => 'Hallinnoi',
		'mark_read' => 'Merkitse luetuksi',
		'menu' => array(
			'open' => 'Avaa valikko',
		),
		'nav_buttons' => array(
			'next' => 'Seuraava artikkeli',
			'prev' => 'Edellinen artikkeli',
			'up' => 'Siirry ylöspäin',
		),
		'open_url' => 'Avaa URL-osoite',
		'promote' => 'Nosta tärkeyttä',
		'purge' => 'Tyhjennä',
		'refresh_opml' => 'Päivitä OPML',
		'remove' => 'Poista',
		'rename' => 'Nimeä uudelleen',
		'see_website' => 'Siirry sivustolle',
		'submit' => 'Lähetä',
		'truncate' => 'Poista kaikki artikkelit',
		'update' => 'Päivitä',
	),
	'auth' => array(
		'accept_tos' => 'Hyväksyn <a href="%s">käyttöehdot</a>.',
		'email' => 'Sähköpostiosoite',
		'keep_logged_in' => 'Pidä minut kirjautuneena <small>(%s päivää)</small>',
		'login' => 'Kirjaudu sisään',
		'logout' => 'Kirjaudu ulos',
		'password' => array(
			'_' => 'Salasana',
			'format' => '<small>Vähintään 7 merkkiä</small>',
		),
		'reauth' => array(
			'header' => 'Uudelleentodentaminen tarvitaan',
			'tip' => 'Sinun ei tarvitse kirjautua uudelleen sisään <u>%d minuuttiin</u>',
			'title' => 'Uudelleentodentaminen',
		),
		'registration' => array(
			'_' => 'Uusi tili',
			'ask' => 'Haluatko luoda tilin?',
			'title' => 'Tilin luonti',
		),
		'username' => array(
			'_' => 'Käyttäjätunnus',
			'format' => '<small>Enintään 16 aakkosnumeerista merkkiä</small>',
		),
	),
	'date' => array(
		'Apr' => '\\h\\u\\h\\t\\i\\k\\u\\u',
		'Aug' => '\\e\\l\\o\\k\\u\\u',
		'Dec' => '\\j\\o\\u\\l\\u\\k\\u\\u',
		'Feb' => '\\h\\e\\l\\m\\i\\k\\u\\u',
		'Jan' => '\\t\\a\\m\\m\\i\\k\\u\\u',
		'Jul' => '\\h\\e\\i\\n\\ä\\k\\u\\u',
		'Jun' => '\\k\\e\\s\\ä\\k\\u\\u',
		'Mar' => '\\m\\a\\a\\l\\i\\s\\k\\u\\u',
		'May' => '\\t\\o\\u\\k\\o\\k\\u\\u',
		'Nov' => '\\m\\a\\r\\r\\a\\s\\k\\u\\u',
		'Oct' => '\\l\\o\\k\\a\\k\\u\\u',
		'Sep' => '\\s\\y\\y\\s\\k\\u\\u',
		'apr' => 'huhti',
		'april' => 'huhtikuu',
		'aug' => 'elo',
		'august' => 'elokuu',
		'before_yesterday' => 'Ennen eilistä',
		'dec' => 'joulu',
		'december' => 'joulukuu',
		'feb' => 'helmi',
		'february' => 'helmikuu',
		'format_date' => 'j\\. %s\\t\\a Y',
		'format_date_hour' => 'j\\. %s\\t\\a Y \\k\\l\\o H\\:i',
		'fri' => 'pe',
		'jan' => 'tammi',
		'january' => 'tammikuu',
		'jul' => 'heinä',
		'july' => 'heinäkuu',
		'jun' => 'kesä',
		'june' => 'kesäkuu',
		'last_2_year' => 'Edelliset kaksi vuotta',
		'last_3_month' => 'Edelliset kolme kuukautta',
		'last_3_year' => 'Edelliset kolme vuotta',
		'last_5_year' => 'Edelliset viisi vuotta',
		'last_6_month' => 'Edelliset kuusi kuukautta',
		'last_month' => 'Viime kuukausi',
		'last_week' => 'Viime viikko',
		'last_year' => 'Viime vuosi',
		'mar' => 'maalis',
		'march' => 'maaliskuu',
		'may' => 'touko',
		'may_' => 'toukokuu',
		'mon' => 'ma',
		'month' => 'kuukautta',
		'nov' => 'marras',
		'november' => 'marraskuu',
		'oct' => 'loka',
		'october' => 'lokakuu',
		'sat' => 'la',
		'sep' => 'syys',
		'september' => 'syyskuu',
		'sun' => 'su',
		'thu' => 'to',
		'today' => 'Tänään',
		'tue' => 'ti',
		'wed' => 'ke',
		'yesterday' => 'Eilen',
	),
	'dir' => 'ltr',	// IGNORE
	'freshrss' => array(
		'_' => 'FreshRSS',	// IGNORE
		'about' => 'Tietoja FreshRSS-sovelluksesta',
	),
	'js' => array(
		'category_empty' => 'Tyhjennä luokka',
		'confirm_action' => 'Haluatko varmasti toteuttaa toiminnon? Sitä ei voi peruuttaa!',
		'confirm_action_feed_cat' => 'Haluatko varmasti toteuttaa toiminnon? Luokkaan kuuluvat suosikit ja kyselyt poistetaan. Tätä ei voi peruuttaa!',
		'confirm_exit_slider' => 'Haluatko varmasti hylätä muutetut asetukset?',
		'feedback' => array(
			'body_new_articles' => 'FreshRSS-sovelluksessa on %%d uutta artikkelia luettavana.',
			'body_unread_articles' => '(lukematta: %%d)',
			'request_failed' => 'Pyyntö epäonnistui. Internetyhteydessä on ehkä ollut ongelmia.',
			'title_new_articles' => 'FreshRSS: uusia artikkeleita!',
		),
		'labels_empty' => 'Ei tunnisteita',
		'new_article' => 'Uusia artikkeleita on saatavilla. Päivitä sivu napsauttamalla.',
		'should_be_activated' => 'JavaScriptin on oltava käytössä',
		'unsafe_csp_header' => 'Käytössä oleva CSP-otsikko on turvaton, ja FreshRSS saattaa olla altis XSS-hyökkäyksille. <a target="_blank" href="https://freshrss.github.io/FreshRSS/en/admins/10_ServerConfig.html#security">Lisätietoja ohjeessa</a>',
	),
	'lang' => array(
		'cs' => 'Čeština',	// IGNORE
		'de' => 'Deutsch',	// IGNORE
		'el' => 'Ελληνικά',	// IGNORE
		'en' => 'English',	// IGNORE
		'en-US' => 'English (United States)',	// IGNORE
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
		'pt-BR' => 'Português (Brasil)',	// IGNORE
		'pt-PT' => 'Português (Portugal)',	// IGNORE
		'ru' => 'Русский',	// IGNORE
		'sk' => 'Slovenčina',	// IGNORE
		'tr' => 'Türkçe',	// IGNORE
		'uk' => 'Українська',	// IGNORE
		'zh-CN' => '简体中文',	// IGNORE
		'zh-TW' => '正體中文',	// IGNORE
	),
	'menu' => array(
		'about' => 'Tietoja',
		'account' => 'Tili',
		'admin' => 'Hallinta',
		'advanced_search' => 'Advanced Search',	// TODO
		'archiving' => 'Arkistointi',
		'authentication' => 'Todentaminen',
		'check_install' => 'Asennuksen tarkistus',
		'configuration' => 'Määritys',
		'display' => 'Näkymä',
		'extensions' => 'Laajennukset',
		'logs' => 'Lokit',
		'privacy' => 'Tietosuoja',
		'queries' => 'Käyttäjän kyselyt',
		'reading' => 'Lukeminen',
		'search' => 'Hae sanoja tai #tunnisteita',
		'search_help' => 'Ohjeessa on tietoja <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">haun lisäparametreista</a>',
		'sharing' => 'Jakaminen',
		'shortcuts' => 'Pikanäppäimet',
		'stats' => 'Tilastot',
		'system' => 'Järjestelmän määritys',
		'update' => 'Päivitys',
		'user_management' => 'Hallinnoi käyttäjiä',
		'user_profile' => 'Profiili',
	),
	'period' => array(
		'days' => 'päivää',
		'hours' => 'tuntia',
		'months' => 'kuukautta',
		'weeks' => 'viikkoa',
		'years' => 'vuotta',
	),
	'readme' => array(
		'contribute' => 'contribute',	// IGNORE
		'language' => 'Language',	// IGNORE
		'translated' => 'Progress',	// IGNORE
	),
	'search' => array(
		'advanced_search_help' => 'This form helps construct search queries, but manual queries are even more powerful.',	// TODO
		'authors' => 'Authors',	// TODO
		'categories' => 'Categories',	// TODO
		'content' => 'Content',	// TODO
		'date_from' => 'From',	// TODO
		'date_past' => 'In the past',	// TODO
		'date_published' => 'Publication Date',	// TODO
		'date_range' => 'Date Range',	// TODO
		'date_received' => 'Received Date',	// TODO
		'date_to' => 'To',	// TODO
		'feeds' => 'Feeds',	// TODO
		'free_text' => 'Free Text',	// TODO
		'free_text_help' => 'Search both in title and content',	// TODO
		'full_documentation' => 'View <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">full search documentation</a>',	// TODO
		'labels' => 'My Labels',	// TODO
		'multiple_help' => 'Select one or more (hold <kbd>Ctrl</kbd> or <kbd>Cmd</kbd>)',	// TODO
		'sources' => 'Sources',	// TODO
		'tags' => 'Article Tags',	// TODO
		'text' => 'Text Search',	// TODO
		'text_help' => 'Multiple lines are combined by a logical <i>or</i>. Also supports <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#regex" target="_blank">regular expressions</a>.',	// TODO
		'text_placeholder' => 'Keyword',	// TODO
		'title' => 'Title',	// TODO
		'url' => 'URL',	// TODO
		'user_queries' => 'User Queries',	// TODO
	),
	'share' => array(
		'Known' => 'Known-sivustot',
		'archiveIS' => 'archive.is',	// IGNORE
		'archiveORG' => 'archive.org',	// IGNORE
		'archivePH' => 'archive.ph',	// IGNORE
		'bluesky' => 'Bluesky',	// IGNORE
		'buffer' => 'Buffer',	// IGNORE
		'clipboard' => 'Clipboard',	// IGNORE
		'diaspora' => 'Diaspora*',	// IGNORE
		'email' => 'Sähköposti',
		'email-webmail-firefox-fix' => 'Sähköposti (webposti - korjaus Firefoxia varten)',
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
		'print' => 'Tulostus',
		'raindrop' => 'Raindrop.io',	// IGNORE
		'reddit' => 'Reddit',	// IGNORE
		'shaarli' => 'Shaarli',	// IGNORE
		'telegram' => 'Telegram',	// IGNORE
		'twitter' => 'Twitter',	// IGNORE
		'wallabag' => 'wallabag v1',	// IGNORE
		'wallabagv2' => 'wallabag v2',	// IGNORE
		'web-sharing-api' => 'Järjestelmän oma jakovalikko',
		'whatsapp' => 'WhatsApp',
		'xing' => 'Xing',	// IGNORE
	),
	'short' => array(
		'attention' => 'Varoitus!',
		'blank_to_disable' => 'Poista käytöstä jättämällä tämä tyhjäksi',
		'by_author' => 'Kirjoittaja:',
		'by_default' => 'Oletusarvo',
		'damn' => 'Pahus!',
		'default_category' => 'Luokittelematon',
		'no' => 'Ei',
		'not_applicable' => 'Ei käytettävissä',
		'ok' => 'Selvä!',
		'or' => 'tai',
		'yes' => 'Kyllä',
	),
	'stream' => array(
		'load_more' => 'Lataa lisää artikkeleita',
		'mark_all_read' => 'Merkitse kaikki luetuiksi',
		'nothing_to_load' => 'Artikkeleita ei ole enempää',
	),
);
