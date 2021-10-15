<?php

return array(
	'archiving' => array(
		'_' => 'Archivovanie',
		'exception' => 'Purge exception',	// TODO - Translation
		'help' => 'Viac možností nájdete v nastaveniach kanála',
		'keep_favourites' => 'Never delete favourites',	// TODO - Translation
		'keep_labels' => 'Never delete labels',	// TODO - Translation
		'keep_max' => 'Maximum number of articles to keep',	// TODO - Translation
		'keep_min_by_feed' => 'Minimálny počet článkov kanála na zachovanie',
		'keep_period' => 'Maximum age of articles to keep',	// TODO - Translation
		'keep_unreads' => 'Never delete unread articles',	// TODO - Translation
		'maintenance' => 'Maintenance',	// TODO - Translation
		'optimize' => 'Optimalizovať databázu',
		'optimize_help' => 'Občas vykonajte na zmenšenie veľkosti databázy',
		'policy' => 'Purge policy',	// TODO - Translation
		'policy_warning' => 'If no purge policy is selected, every article will be kept.',	// TODO - Translation
		'purge_now' => 'Vyčistiť teraz',
		'title' => 'Archivovanie',
		'ttl' => 'Neaktualizovať častejšie ako',
	),
	'display' => array(
		'_' => 'Zobrazenie',
		'icon' => array(
			'bottom_line' => 'Spodný riadok',
			'display_authors' => 'Autori',
			'entry' => 'Ikony článku',
			'publication_date' => 'Dátum zverejnenia',
			'related_tags' => 'Značky článku',
			'sharing' => 'Zdieľanie',
			'summary' => 'Summary',	// TODO - Translation
			'top_line' => 'Horný riadok',
		),
		'language' => 'Jazyk',
		'notif_html5' => array(
			'seconds' => 'sekundy (0 znamená bez limitu)',
			'timeout' => 'Limit HTML5 oznámenia',
		),
		'show_nav_buttons' => 'Zobraziť tlačidlá oznámenia',
		'theme' => 'Vzhľad',
		'thumbnail' => array(
			'label' => 'Thumbnail',	// TODO - Translation
			'landscape' => 'Landscape',	// TODO - Translation
			'none' => 'None',	// TODO - Translation
			'portrait' => 'Portrait',	// TODO - Translation
			'square' => 'Square',	// TODO - Translation
		),
		'title' => 'Zobraziť',
		'width' => array(
			'content' => 'Šírka obsahu',
			'large' => 'Veľká',
			'medium' => 'Stredná',
			'no_limit' => 'Bez obmedzenia',
			'thin' => 'Úzka',
		),
	),
	'profile' => array(
		'_' => 'Správca profilu',
		'api' => 'API management',	// TODO - Translation
		'delete' => array(
			'_' => 'Vymazanie účtu',
			'warn' => 'Váš účet a všetky údaje v ňom budú vymazané.',
		),
		'email' => 'Email address',	// TODO - Translation
		'password_api' => 'Heslo API<br /><small>(pre mobilné aplikácie)</small>',
		'password_form' => 'Heslo<br /><small>(pre spôsob prihlásenia cez webový formulár)</small>',
		'password_format' => 'Najmenej 7 znakov',
		'title' => 'Profil',
	),
	'query' => array(
		'_' => 'Dopyty používateľa',
		'deprecated' => 'Tento dopyt už nie je platný. Kategória alebo kanál boli vymazané.',
		'filter' => array(
			'_' => 'Použitý filter:',
			'categories' => 'Display by category',	// TODO - Translation
			'feeds' => 'Display by feed',	// TODO - Translation
			'order' => 'Sort by date',	// TODO - Translation
			'search' => 'Expression',	// TODO - Translation
			'state' => 'State',	// TODO - Translation
			'tags' => 'Display by tag',	// TODO - Translation
			'type' => 'Type',	// TODO - Translation
		),
		'get_all' => 'Zobraziť všetky články',
		'get_category' => 'Zobraziť kategóriu "%s"',
		'get_favorite' => 'Zobraziť obľúbené články',
		'get_feed' => 'Zobraziť kanál "%s"',
		'name' => 'Name',	// TODO - Translation
		'no_filter' => 'Žiadny filter',
		'number' => 'Dopyt číslo %d',
		'order_asc' => 'Zobraziť staršie články hore',
		'order_desc' => 'Zobraziť novšie články hore',
		'search' => 'Vyhľadáva sa: "%s"',
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
	),
	'reading' => array(
		'_' => 'Čítanie',
		'after_onread' => 'Po “Označiť všetko ako prečítané”,',
		'always_show_favorites' => 'Show all articles in favourites by default',	// TODO - Translation
		'articles_per_page' => 'Počet článkov na jednu stranu',
		'auto_load_more' => 'Načítať ďalšie články dolu na stránke',
		'auto_remove_article' => 'Skryť články po prečítaní',
		'confirm_enabled' => 'Zobraziť potvrdzovací dialóg po kliknutí na “Označiť všetko ako prečítané”',
		'display_articles_unfolded' => 'Zobraziť články otvorené',
		'display_categories_unfolded' => 'Categories to unfold',	// TODO - Translation
		'hide_read_feeds' => 'Skryť kategórie a kanály s nulovým počtom neprečítaných článkov (nefunguje s nastaveným “Zobraziť všetky články”)',
		'img_with_lazyload' => 'Pre načítanie obrázkov použiť "lazy load"',
		'jump_next' => 'skočiť na ďalší neprečítaný (kanál ale kategóriu)',
		'mark_updated_article_unread' => 'Označiť aktualizované články ako neprečítané',
		'number_divided_when_reader' => 'V režime čítania predeliť na dve časti.',
		'read' => array(
			'article_open_on_website' => 'keď je článok otvorený na svojej webovej stránke',
			'article_viewed' => 'keď je článok zobrazený',
			'keep_max_n_unread' => 'Max number of articles to keep unread',	// TODO - Translation
			'scroll' => 'počas skrolovania',
			'upon_reception' => 'po načítaní článku',
			'when' => 'Označiť článok ako prečítaný…',
			'when_same_title' => 'if an identical title already exists in the top <i>n</i> newest articles',	// TODO - Translation
		),
		'show' => array(
			'_' => 'Článkov na zobrazenie',
			'active_category' => 'Active category',	// TODO - Translation
			'adaptive' => 'Vyberte zobrazenie',
			'all_articles' => 'Zobraziť všetky články',
			'all_categories' => 'All categories',	// TODO - Translation
			'no_category' => 'No category',	// TODO - Translation
			'remember_categories' => 'Remember open categories',	// TODO - Translation
			'unread' => 'Zobraziť iba neprečítané',
		),
		'show_fav_unread_help' => 'Applies also on labels',	// TODO - Translation
		'sides_close_article' => 'Po kliknutí mimo textu článku sa článok zatvorí',
		'sort' => array(
			'_' => 'Poradie',
			'newer_first' => 'Novšie hore',
			'older_first' => 'Staršie hore',
		),
		'sticky_post' => 'Po otvorení posunúť článok hore',
		'title' => 'Čítanie',
		'view' => array(
			'default' => 'Prednastavené zobrazenie',
			'global' => 'Prehľadné zobrazenie',
			'normal' => 'Základné zobrazenie',
			'reader' => 'Zobrazenie na čítanie',
		),
	),
	'sharing' => array(
		'_' => 'Zdieľanie',
		'add' => 'Pridať spôsob zdieľania',
		'blogotext' => 'Blogotext',
		'diaspora' => 'Diaspora*',
		'email' => 'E-mail',
		'facebook' => 'Facebook',
		'more_information' => 'Viac informácií',
		'print' => 'Tlač',
		'raindrop' => 'Raindrop.io',
		'remove' => 'Odstrániť spôsob zdieľania',
		'shaarli' => 'Shaarli',
		'share_name' => 'Meno pre zobrazenie',
		'share_url' => 'Zdieľaný odkaz',
		'title' => 'Zdieľanie',
		'twitter' => 'Twitter',
		'wallabag' => 'wallabag',
	),
	'shortcut' => array(
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
		'navigation_no_mod_help' => 'Tieto skratky navigácie nepodporujú klávesy "Shift" a "Alt".',
		'next_article' => 'Otvorí ďalší článok',
		'next_unread_article' => 'Open the next unread article',  // TODO - Translation
		'non_standard' => 'Some keys (<kbd>%s</kbd>) may not work as shortcuts.',	// TODO - Translation
		'normal_view' => 'Prepne do základného zobrazenia',
		'other_action' => 'Ostatné akcie',
		'previous_article' => 'Otvorí predošlý článok',
		'reading_view' => 'Prepne do zobrazenia na čítanie',
		'rss_view' => 'Otvorí zobrazenie RSS v novej záložke',
		'see_on_website' => 'Zobrazí na webovej stránke',
		'shift_for_all_read' => '+ <kbd>Alt ⎇</kbd> to mark previous articles as read<br />+ <kbd>⇧ Shift</kbd> to mark all articles as read',	// TODO - Translation
		'skip_next_article' => 'Prejde na ďalší bez otvorenia',
		'skip_previous_article' => 'Prejde na predošlý bez otvorenia',
		'title' => 'Skratky',
		'toggle_media' => 'Play/pause media',	// TODO - Translation
		'user_filter' => 'Použiť používateľské filtre',
		'user_filter_help' => 'Ak je nastavený iba jeden spôsob zdieľania, použije sa. Inak si spôsoby zdieľania vyberá používateľ podľa čísla.',
		'views' => 'Zobrazenia',
	),
	'user' => array(
		'articles_and_size' => '%s článkov (%s)',
		'current' => 'Aktuálny používateľ',
		'is_admin' => 'je administrátor',
		'users' => 'Používatelia',
	),
);
