<?php

return array(
	'archiving' => array(
		'_' => 'Archivace',
		'delete_after' => 'Smazat články starší než',
		'exception' => 'Purge exception',	// TODO - Translation
		'help' => 'Více možností je dostupných v nastavení jednotlivých kanálů',
		'keep_favourites' => 'Never delete favourites',	// TODO - Translation
		'keep_labels' => 'Never delete labels',	// TODO - Translation
		'keep_max' => 'Maximum number of articles to keep',	// TODO - Translation
		'keep_min_by_feed' => 'Zachovat tento minimální počet článků v každém kanálu',
		'keep_period' => 'Maximum age of articles to keep',	// TODO - Translation
		'keep_unreads' => 'Never delete unread articles',	// TODO - Translation
		'maintenance' => 'Maintenance',	// TODO - Translation
		'optimize' => 'Optimalizovat databázi',
		'optimize_help' => 'Občasná údržba zmenší velikost databáze',
		'policy' => 'Purge policy',	// TODO - Translation
		'policy_warning' => 'If no purge policy is selected, every article will be kept.',	// TODO - Translation
		'purge_now' => 'Vyčistit nyní',
		'title' => 'Archivace',
		'ttl' => 'Neaktualizovat častěji než',
	),
	'display' => array(
		'_' => 'Zobrazení',
		'icon' => array(
			'bottom_line' => 'Spodní řádek',
			'display_authors' => 'Authors',	// TODO - Translation
			'entry' => 'Ikony článků',
			'publication_date' => 'Datum vydání',
			'related_tags' => 'Související tagy',
			'sharing' => 'Sdílení',
			'top_line' => 'Horní řádek',
		),
		'language' => 'Jazyk',
		'notif_html5' => array(
			'seconds' => 'sekund (0 znamená žádný timeout)',
			'timeout' => 'Timeout HTML5 notifikací',
		),
		'show_nav_buttons' => 'Show the navigation buttons',	// TODO - Translation
		'theme' => 'Vzhled',
		'title' => 'Zobrazení',
		'width' => array(
			'content' => 'Šířka obsahu',
			'large' => 'Velká',
			'medium' => 'Střední',
			'no_limit' => 'Bez limitu',
			'thin' => 'Tenká',
		),
	),
	'profile' => array(
		'_' => 'Správa profilu',
		'api' => 'API management',	// TODO - Translation
		'delete' => array(
			'_' => 'Smazání účtu',
			'warn' => 'Váš účet bude smazán spolu se všemi souvisejícími daty',
		),
		'email' => 'Email',
		'password_api' => 'Password API<br /><small>(tzn. pro mobilní aplikace)</small>',
		'password_form' => 'Heslo<br /><small>(pro přihlášení webovým formulářem)</small>',
		'password_format' => 'Alespoň 7 znaků',
		'title' => 'Profil',
	),
	'query' => array(
		'_' => 'Uživatelské dotazy',
		'deprecated' => 'Tento dotaz již není platný. Odkazovaná kategorie nebo kanál byly smazány.',
		'display' => 'Display user query results',	// TODO - Translation
		'filter' => 'Filtr aplikován:',
		'get_all' => 'Zobrazit všechny články',
		'get_category' => 'Zobrazit "%s" kategorii',
		'get_favorite' => 'Zobrazit oblíbené články',
		'get_feed' => 'Zobrazit "%s" článkek',
		'get_tag' => 'Display "%s" label',	// TODO - Translation
		'no_filter' => 'Zrušit filtr',
		'none' => 'Ještě jste nevytvořil žádný uživatelský dotaz.',
		'number' => 'Dotaz n°%d',
		'order_asc' => 'Zobrazit nejdříve nejstarší články',
		'order_desc' => 'Zobrazit nejdříve nejnovější články',
		'remove' => 'Remove user query',	// TODO - Translation
		'search' => 'Hledat "%s"',
		'state_0' => 'Zobrazit všechny články',
		'state_1' => 'Zobrazit přečtené články',
		'state_2' => 'Zobrazit nepřečtené články',
		'state_3' => 'Zobrazit všechny články',
		'state_4' => 'Zobrazit oblíbené články',
		'state_5' => 'Zobrazit oblíbené přečtené články',
		'state_6' => 'Zobrazit oblíbené nepřečtené články',
		'state_7' => 'Zobrazit oblíbené články',
		'state_8' => 'Zobrazit všechny články vyjma oblíbených',
		'state_9' => 'Zobrazit všechny přečtené články vyjma oblíbených',
		'state_10' => 'Zobrazit všechny nepřečtené články vyjma oblíbených',
		'state_11' => 'Zobrazit všechny články vyjma oblíbených',
		'state_12' => 'Zobrazit všechny články',
		'state_13' => 'Zobrazit přečtené články',
		'state_14' => 'Zobrazit nepřečtené články',
		'state_15' => 'Zobrazit všechny články',
		'title' => 'Uživatelské dotazy',
	),
	'reading' => array(
		'_' => 'Čtení',
		'after_onread' => 'Po “označit vše jako přečtené”,',
		'always_show_favorites' => 'Show all articles in favourites by default',	// TODO - Translation
		'articles_per_page' => 'Počet článků na stranu',
		'auto_load_more' => 'Načítat další články dole na stránce',
		'auto_remove_article' => 'Po přečtení články schovat',
		'confirm_enabled' => 'Vyžadovat potvrzení pro akci “označit vše jako přečtené”',
		'display_articles_unfolded' => 'Ve výchozím stavu zobrazovat články otevřené',
		'display_categories_unfolded' => 'Categories to unfold',	// TODO - Translation
		'hide_read_feeds' => 'Schovat kategorie a kanály s nulovým počtem nepřečtených článků (nefunguje s nastavením “Zobrazit všechny články”)',
		'img_with_lazyload' => 'Použít "lazy load" mód pro načítaní obrázků',
		'jump_next' => 'skočit na další nepřečtený (kanál nebo kategorii)',
		'mark_updated_article_unread' => 'Označte aktualizované položky jako nepřečtené',
		'number_divided_when_reader' => 'V režimu “Čtení” děleno dvěma.',
		'read' => array(
			'article_open_on_website' => 'když je otevřen původní web s článkem',
			'article_viewed' => 'během čtení článku',
			'keep_max_n_unread' => 'Keep at max <i>n</i> articles unread',	// TODO - Translation
			'scroll' => 'během skrolování',
			'upon_reception' => 'po načtení článku',
			'when' => 'Označit článek jako přečtený…',
			'when_same_title' => 'if an identical title already exists in the top <i>n</i> newest articles',	// TODO - Translation
		),
		'show' => array(
			'_' => 'Počet zobrazených článků',
			'active_category' => 'Active category',	// TODO - Translation
			'adaptive' => 'Vyberte zobrazení',
			'all_articles' => 'Zobrazit všechny články',
			'all_categories' => 'All categories',	// TODO - Translation
			'no_category' => 'No category',	// TODO - Translation
			'remember_categories' => 'Remember open categories',	// TODO - Translation
			'unread' => 'Zobrazit jen nepřečtené',
		),
		'sides_close_article' => 'Clicking outside of article text area closes the article',	// TODO - Translation
		'sort' => array(
			'_' => 'Řazení',
			'newer_first' => 'Nejdříve nejnovější',
			'older_first' => 'Nejdříve nejstarší',
		),
		'sticky_post' => 'Při otevření posunout článek nahoru',
		'title' => 'Čtení',
		'view' => array(
			'default' => 'Výchozí',
			'global' => 'Přehled',
			'normal' => 'Normální',
			'reader' => 'Čtení',
		),
	),
	'sharing' => array(
		'_' => 'Sdílení',
		'add' => 'Add a sharing method',	// TODO - Translation
		'blogotext' => 'Blogotext',	// TODO - Translation
		'diaspora' => 'Diaspora*',	// TODO - Translation
		'email' => 'Email',	// TODO - Translation
		'facebook' => 'Facebook',	// TODO - Translation
		'more_information' => 'Více informací',
		'print' => 'Tisk',
		'remove' => 'Remove sharing method',	// TODO - Translation
		'shaarli' => 'Shaarli',	// TODO - Translation
		'share_name' => 'Jméno pro zobrazení',
		'share_url' => 'Jakou URL použít pro sdílení',
		'title' => 'Sdílení',
		'twitter' => 'Twitter',	// TODO - Translation
		'wallabag' => 'wallabag',	// TODO - Translation
	),
	'shortcut' => array(
		'_' => 'Zkratky',
		'article_action' => 'Články - akce',
		'auto_share' => 'Sdílet',
		'auto_share_help' => 'Je-li nastavena pouze jedna možnost sdílení, bude použita. Další možnosti jsou dostupné pomocí jejich čísla.',
		'close_dropdown' => 'Zavřít menu',
		'collapse_article' => 'Srolovat',
		'first_article' => 'Skočit na první článek',
		'focus_search' => 'Hledání',
		'global_view' => 'Switch to global view',	// TODO - Translation
		'help' => 'Zobrazit documentaci',
		'javascript' => 'Pro použití zkratek musí být povolen JavaScript',
		'last_article' => 'Skočit na poslední článek',
		'load_more' => 'Načíst více článků',
		'mark_favorite' => 'Označit jako oblíbené',
		'mark_read' => 'Označit jako přečtené',
		'navigation' => 'Navigace',
		'navigation_help' => 'Pomocí přepínače <kbd>⇧ Shift</kbd> fungují navigační zkratky v rámci kanálů.<br/>Pomocí přepínače <kbd>Alt ⎇</kbd> fungují v rámci kategorií.',
		'navigation_no_mod_help' => 'The following navigation shortcuts do not support modifiers.',	// TODO - Translation
		'next_article' => 'Skočit na další článek',
		'normal_view' => 'Switch to normal view',	// TODO - Translation
		'other_action' => 'Ostatní akce',
		'previous_article' => 'Skočit na předchozí článek',
		'reading_view' => 'Switch to reading view',	// TODO - Translation
		'rss_view' => 'Open RSS view in a new tab',	// TODO - Translation
		'see_on_website' => 'Navštívit původní webovou stránku',
		'shift_for_all_read' => '+ <kbd>Alt ⎇</kbd> to mark previous articles as read<br />+ <kbd>⇧ Shift</kbd> to mark all articles as read',	// TODO - Translation
		'skip_next_article' => 'Focus next without opening',	// TODO - Translation
		'skip_previous_article' => 'Focus previous without opening',	// TODO - Translation
		'title' => 'Zkratky',
		'toggle_media' => 'Play/pause media',	// TODO - Translation
		'user_filter' => 'Aplikovat uživatelské filtry',
		'user_filter_help' => 'Je-li nastaven pouze jeden filtr, bude použit. Další filtry jsou dostupné pomocí jejich čísla.',
		'views' => 'Views',	// TODO - Translation
	),
	'user' => array(
		'articles_and_size' => '%s článků (%s)',
		'current' => 'Aktuální uživatel',
		'is_admin' => 'je administrátor',
		'users' => 'Uživatelé',
	),
);
