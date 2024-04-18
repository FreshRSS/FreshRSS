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

return [
	'archiving' => [
		'_' => 'Archivovanie',
		'exception' => 'Výnimka mazania',
		'help' => 'Viac možností nájdete v nastaveniach kanála',
		'keep_favourites' => 'Nikdy nemazať obľúbené',
		'keep_labels' => 'Nikdy nemazať štítky',
		'keep_max' => 'Maximálny počet článkov na zachovanie',	// DIRTY
		'keep_min_by_feed' => 'Minimálny počet článkov kanála na zachovanie',
		'keep_period' => 'Maximálny vek článkov na zachovanie',
		'keep_unreads' => 'Nikdy nemazať neprečítané články',
		'maintenance' => 'Údržba',
		'optimize' => 'Optimalizovať databázu',
		'optimize_help' => 'Občas vykonajte na zmenšenie veľkosti databázy',
		'policy' => 'Politika mazania',
		'policy_warning' => 'Ak nie je vybrané politika mazania, bude zachovaný každý článok.',
		'purge_now' => 'Vyčistiť teraz',
		'title' => 'Archivovanie',
		'ttl' => 'Neaktualizovať častejšie ako',
	],
	'display' => [
		'_' => 'Zobrazenie',
		'darkMode' => [
			'_' => 'Automatic dark mode (beta)',	// TODO
			'auto' => 'Auto',	// TODO
			'no' => 'No',	// TODO
		],
		'icon' => [
			'bottom_line' => 'Spodný riadok',
			'display_authors' => 'Autori',
			'entry' => 'Ikony článku',
			'publication_date' => 'Dátum zverejnenia',
			'related_tags' => 'Značky článku',
			'sharing' => 'Zdieľanie',
			'summary' => 'Zhrnutie',
			'top_line' => 'Horný riadok',
		],
		'language' => 'Jazyk',
		'notif_html5' => [
			'seconds' => 'sekundy (0 znamená bez limitu)',
			'timeout' => 'Limit HTML5 oznámenia',
		],
		'show_nav_buttons' => 'Zobraziť tlačidlá oznámenia',
		'theme' => [
			'_' => 'Vzhľad',
			'deprecated' => [
				'_' => 'Deprecated',	// TODO
				'description' => 'This theme is no longer supported and will be not available anymore in a <a href="https://freshrss.github.io/FreshRSS/en/users/05_Configuration.html#theme" target="_blank">future release of FreshRSS</a>',	// TODO
			],
		],
		'theme_not_available' => 'Vzhľad “%s” už nie je dostupný. Prosím, vyberte si iný vzhľad.',
		'thumbnail' => [
			'label' => 'Miniatúra',
			'landscape' => 'Naležato',
			'none' => 'Žiadny',
			'portrait' => 'Nastojato',
			'square' => 'Štvorec',
		],
		'timezone' => 'Time zone',	// TODO
		'title' => 'Zobraziť',
		'website' => [
			'full' => 'Icon and name',	// TODO
			'icon' => 'Icon only',	// TODO
			'label' => 'Website',	// TODO
			'name' => 'Name only',	// TODO
			'none' => 'None',	// TODO
		],
		'width' => [
			'content' => 'Šírka obsahu',
			'large' => 'Veľká',
			'medium' => 'Stredná',
			'no_limit' => 'Bez obmedzenia',
			'thin' => 'Úzka',
		],
	],
	'logs' => [
		'loglist' => [
			'level' => 'Úroveň záznamu',
			'message' => 'Správa záznamu',
			'timestamp' => 'Časová značka',
		],
		'pagination' => [
			'first' => 'Prvý',
			'last' => 'Posledný',
			'next' => 'Ďalší',
			'previous' => 'Predošlý',
		],
	],
	'profile' => [
		'_' => 'Správca profilu',
		'api' => 'Správa API',
		'delete' => [
			'_' => 'Vymazanie účtu',
			'warn' => 'Váš účet a všetky údaje v ňom budú vymazané.',
		],
		'email' => 'E-mailová adresa',
		'password_api' => 'Heslo API<br /><small>(pre mobilné aplikácie)</small>',
		'password_form' => 'Heslo<br /><small>(pre spôsob prihlásenia cez webový formulár)</small>',
		'password_format' => 'Najmenej 7 znakov',
		'title' => 'Profil',
	],
	'query' => [
		'_' => 'Dopyty používateľa',
		'deprecated' => 'Tento dopyt už nie je platný. Kategória alebo kanál boli vymazané.',
		'filter' => [
			'_' => 'Použitý filter:',
			'categories' => 'Zobraziť podľa kategórie',
			'feeds' => 'Zobraziť podľa kanála',
			'order' => 'Zobraziť podľa dátumu',
			'search' => 'Výraz',
			'shareOpml' => 'Enable sharing by OPML of corresponding categories and feeds',	// TODO
			'shareRss' => 'Enable sharing by HTML &amp; RSS',	// TODO
			'state' => 'Štát',
			'tags' => 'Zobraziť podľa štítku',
			'type' => 'Typ',
		],
		'get_all' => 'Zobraziť všetky články',
		'get_all_labels' => 'Display articles with any label',	// TODO
		'get_category' => 'Zobraziť kategóriu “%s”',
		'get_favorite' => 'Zobraziť obľúbené články',
		'get_feed' => 'Zobraziť kanál “%s”',
		'get_important' => 'Display articles from important feeds',	// TODO
		'get_label' => 'Display articles with “%s” label',	// TODO
		'help' => 'See the <a href="https://freshrss.github.io/FreshRSS/en/users/user_queries.html" target="_blank">documentation for user queries and resharing by HTML / RSS / OPML</a>.',	// TODO
		'name' => 'Meno',
		'no_filter' => 'Žiadny filter',
		'number' => 'Dopyt číslo %d',
		'order_asc' => 'Zobraziť staršie články hore',
		'order_desc' => 'Zobraziť novšie články hore',
		'search' => 'Vyhľadáva sa: “%s”',
		'share' => [
			'_' => 'Share this query by link',	// TODO
			'help' => 'Give this link if you want to share this query with anyone',	// TODO
			'html' => 'Shareable link to the HTML page',	// TODO
			'opml' => 'Shareable link to the OPML list of feeds',	// TODO
			'rss' => 'Shareable link to the RSS feed',	// TODO
		],
		'state_0' => 'Zobraziť všetky články',
		'state_1' => 'Zobraziť prečítané články',
		'state_2' => 'Zobraziť neprečítané články',
		'state_3' => 'Zobraziť všetky články',
		'state_4' => 'Zobraziť obľúbené články',
		'state_5' => 'Zobraziť prečítané obľúbené články',
		'state_6' => 'Zobraziť neprečítané obľúbené články',
		'state_7' => 'Zobraziť obľúbené články',
		'state_8' => 'Zobraziť neobľúbené články',
		'state_9' => 'Zobraziť prečítané neobľúbené články',
		'state_10' => 'Zobraziť neprečítané neobľúbené články',
		'state_11' => 'Zobraziť neobľúbené články',
		'state_12' => 'Zobraziť všetky články',
		'state_13' => 'Zobraziť prečítané články',
		'state_14' => 'Zobraziť neprečítané články',
		'state_15' => 'Zobraziť všetky články',
		'title' => 'Používateľské dopyty',
	],
	'reading' => [
		'_' => 'Čítanie',
		'after_onread' => 'Po “Označiť všetko ako prečítané”,',
		'always_show_favorites' => 'Automaticky zobraziť všetky články v obľúbených',
		'article' => [
			'authors_date' => [
				'_' => 'Authori a dátum',
				'both' => 'V záhlaví a pätičke',
				'footer' => 'V pätičke',
				'header' => 'V záhlaví',
				'none' => 'Žiadne',
			],
			'feed_name' => [
				'above_title' => 'O zápise/značky',
				'none' => 'Žiadne',
				'with_authors' => 'V riadku autori a dátum',
			],
			'feed_title' => 'Nadpis kanála',
			'tags' => [
				'_' => 'Značky',
				'both' => 'V záhlaví a pätičke',
				'footer' => 'V pätičke',
				'header' => 'V záhlaví',
				'none' => 'Žiadne',
			],
			'tags_max' => [
				'_' => 'Maximálny počet zobrazených značiek',
				'help' => '0 znamená: zobraziť všetky značky a nerozbaľuj ich',
			],
		],
		'articles_per_page' => 'Počet článkov na jednu stranu',
		'auto_load_more' => 'Načítať ďalšie články dolu na stránke',
		'auto_remove_article' => 'Skryť články po prečítaní',
		'confirm_enabled' => 'Zobraziť potvrdzovací dialóg po kliknutí na “Označiť všetko ako prečítané”',
		'display_articles_unfolded' => 'Zobraziť články otvorené',
		'display_categories_unfolded' => 'Kategórie na rozbalenie',
		'headline' => [
			'articles' => 'Články: Otvoriť/Zatvoriť',
			'articles_header_footer' => 'Články: záhlavie/pätička',
			'categories' => 'Ľavé menu: Kategórie',
			'mark_as_read' => 'Označiť článok ako prečítaný',
			'misc' => 'Ostatné',
			'view' => 'Zobraziť',
		],
		'hide_read_feeds' => 'Skryť kategórie a kanály s nulovým počtom neprečítaných článkov (nefunguje s nastaveným “Zobraziť všetky články”)',
		'img_with_lazyload' => 'Pre načítanie obrázkov použiť <em>lazy load</em>',
		'jump_next' => 'skočiť na ďalší neprečítaný (kanál ale kategóriu)',
		'mark_updated_article_unread' => 'Označiť aktualizované články ako neprečítané',
		'number_divided_when_reader' => 'V režime čítania predeliť na dve časti.',
		'read' => [
			'article_open_on_website' => 'keď je článok otvorený na svojej webovej stránke',
			'article_viewed' => 'keď je článok zobrazený',
			'focus' => 'when focused (except for important feeds)',	// TODO
			'keep_max_n_unread' => 'Maximálny počet článkov ponechať ako neprečítané',
			'scroll' => 'počas skrolovania (except for important feeds)',	// DIRTY
			'upon_gone' => 'keď už nie je v hlavnom kanály noviniek',
			'upon_reception' => 'po načítaní článku',
			'when' => 'Označiť článok ako prečítaný…',
			'when_same_title' => 'ak rovnaký nadpis už existuje v TOP <i>n</i> najnovších článkoch',
		],
		'show' => [
			'_' => 'Článkov na zobrazenie',
			'active_category' => 'Aktívna kategória',
			'adaptive' => 'Vyberte zobrazenie',
			'all_articles' => 'Zobraziť všetky články',
			'all_categories' => 'Všetky kategórie',
			'no_category' => 'Bez kategŕie',
			'remember_categories' => 'Zapamätať otvorené kategórie',
			'unread' => 'Zobraziť iba neprečítané',
		],
		'show_fav_unread_help' => 'Týka sa aj štítkov',
		'sides_close_article' => 'Po kliknutí mimo textu článku sa článok zatvorí',
		'sort' => [
			'_' => 'Poradie',
			'newer_first' => 'Novšie hore',
			'older_first' => 'Staršie hore',
		],
		'sticky_post' => 'Po otvorení posunúť článok hore',
		'title' => 'Čítanie',
		'view' => [
			'default' => 'Prednastavené zobrazenie',
			'global' => 'Prehľadné zobrazenie',
			'normal' => 'Základné zobrazenie',
			'reader' => 'Zobrazenie na čítanie',
		],
	],
	'sharing' => [
		'_' => 'Zdieľanie',
		'add' => 'Pridať spôsob zdieľania',
		'blogotext' => 'Blogotext',	// IGNORE
		'deprecated' => 'This service is deprecated and will be removed from FreshRSS in a <a href="https://freshrss.github.io/FreshRSS/en/users/08_sharing_services.html" title="Open documentation for more information" target="_blank">future release</a>.',	// TODO
		'diaspora' => 'Diaspora*',	// IGNORE
		'email' => 'E-mail',	// IGNORE
		'facebook' => 'Facebook',	// IGNORE
		'more_information' => 'Viac informácií',
		'print' => 'Tlač',	// IGNORE
		'raindrop' => 'Raindrop.io',	// IGNORE
		'remove' => 'Odstrániť spôsob zdieľania',
		'shaarli' => 'Shaarli',	// IGNORE
		'share_name' => 'Meno pre zobrazenie',
		'share_url' => 'Zdieľaný odkaz',
		'title' => 'Zdieľanie',
		'twitter' => 'Twitter',	// IGNORE
		'wallabag' => 'wallabag',	// IGNORE
	],
	'shortcut' => [
		'_' => 'Skratky',
		'article_action' => 'Akcie článku',
		'auto_share' => 'Zdieľať',
		'auto_share_help' => 'Ak je nastavený iba jeden spôsob zdieľania, použije sa. Inak si spôsoby zdieľania vyberá používateľ podľa čísla.',
		'close_dropdown' => 'Zavrie menu',
		'collapse_article' => 'Zroluje článok',
		'first_article' => 'Otvorí prvý článok',
		'focus_search' => 'Vyhľadávanie',
		'global_view' => 'Prepne do prehľadného zobrazenia',
		'help' => 'Zobrazí dokumentáciu',
		'javascript' => 'JavaScript musí byť povolený, ak chcete používať skratky',
		'last_article' => 'Otvorí posledný článok',
		'load_more' => 'Načíta viac článkov',
		'mark_favorite' => 'O(d)značí ako obľúbené',
		'mark_read' => 'O(d)značí ako prečítané',
		'navigation' => 'Navigácia',
		'navigation_help' => 'Po stlačení skratky s klávesou <kbd>⇧ Shift</kbd>, sa skratky navigácie vzťahujú na kanály.<br/>Po stlačení skratky s klávesou <kbd>Alt ⎇</kbd>, sa skratky navigácie vzťahujú na kategórie.',
		'navigation_no_mod_help' => 'Tieto skratky navigácie nepodporujú klávesy “Shift” a “Alt”.',
		'next_article' => 'Otvorí ďalší článok',
		'next_unread_article' => 'Otvoriť ďalší neprečítaný článok',
		'non_standard' => 'Niektoré klávesy (<kbd>%s</kbd>) nemusia fungovať ako klávesové skratky.',
		'normal_view' => 'Prepne do základného zobrazenia',
		'other_action' => 'Ostatné akcie',
		'previous_article' => 'Otvorí predošlý článok',
		'reading_view' => 'Prepne do zobrazenia na čítanie',
		'rss_view' => 'Otvoriť ako kanál RSS',
		'see_on_website' => 'Zobrazí na webovej stránke',
		'shift_for_all_read' => '+ <kbd>Alt ⎇</kbd> na označené predošlých článkov ako prečítané<br />+ <kbd>⇧ Shift</kbd> na označenie všetkých článkov ako prečítané',
		'skip_next_article' => 'Prejde na ďalší bez otvorenia',
		'skip_previous_article' => 'Prejde na predošlý bez otvorenia',
		'title' => 'Skratky',
		'toggle_media' => 'Spustiť/zastaviť médium',
		'user_filter' => 'Použiť používateľské filtre',
		'user_filter_help' => 'Ak je nastavený iba jeden spôsob zdieľania, použije sa. Inak si spôsoby zdieľania vyberá používateľ podľa čísla.',
		'views' => 'Zobrazenia',
	],
	'user' => [
		'articles_and_size' => '%s článkov (%s)',
		'current' => 'Aktuálny používateľ',
		'is_admin' => 'je administrátor',
		'users' => 'Používatelia',
	],
];
