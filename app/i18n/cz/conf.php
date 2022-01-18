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
		'_' => 'Archivace',
		'exception' => 'Purge exception',	// TODO
		'help' => 'Více možností je dostupných v nastavení jednotlivých kanálů',
		'keep_favourites' => 'Never delete favourites',	// TODO
		'keep_labels' => 'Never delete labels',	// TODO
		'keep_max' => 'Maximum number of articles to keep',	// TODO
		'keep_min_by_feed' => 'Zachovat tento minimální počet článků v každém kanálu',
		'keep_period' => 'Maximum age of articles to keep',	// TODO
		'keep_unreads' => 'Never delete unread articles',	// TODO
		'maintenance' => 'Maintenance',	// TODO
		'optimize' => 'Optimalizovat databázi',
		'optimize_help' => 'Občasná údržba zmenší velikost databáze',
		'policy' => 'Purge policy',	// TODO
		'policy_warning' => 'If no purge policy is selected, every article will be kept.',	// TODO
		'purge_now' => 'Vyčistit nyní',
		'title' => 'Archivace',
		'ttl' => 'Neaktualizovat častěji než',
	),
	'display' => array(
		'_' => 'Zobrazení',
		'icon' => array(
			'bottom_line' => 'Spodní řádek',
			'display_authors' => 'Authors',	// TODO
			'entry' => 'Ikony článků',
			'publication_date' => 'Datum vydání',
			'related_tags' => 'Související tagy',
			'sharing' => 'Sdílení',
			'summary' => 'Summary',	// TODO
			'top_line' => 'Horní řádek',
		),
		'language' => 'Jazyk',
		'notif_html5' => array(
			'seconds' => 'sekund (0 znamená žádný timeout)',
			'timeout' => 'Timeout HTML5 notifikací',
		),
		'show_nav_buttons' => 'Show the navigation buttons',	// TODO
		'theme' => 'Vzhled',
		'theme_not_available' => 'The “%s” theme is not available anymore. Please choose another theme.',	// TODO
		'thumbnail' => array(
			'label' => 'Thumbnail',	// TODO
			'landscape' => 'Landscape',	// TODO
			'none' => 'None',	// TODO
			'portrait' => 'Portrait',	// TODO
			'square' => 'Square',	// TODO
		),
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
		'api' => 'API management',	// TODO
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
		'filter' => array(
			'_' => 'Filtr aplikován:',
			'categories' => 'Display by category',	// TODO
			'feeds' => 'Display by feed',	// TODO
			'order' => 'Sort by date',	// TODO
			'search' => 'Expression',	// TODO
			'state' => 'State',	// TODO
			'tags' => 'Display by tag',	// TODO
			'type' => 'Type',	// TODO
		),
		'get_all' => 'Zobrazit všechny články',
		'get_category' => 'Zobrazit "%s" kategorii',
		'get_favorite' => 'Zobrazit oblíbené články',
		'get_feed' => 'Zobrazit "%s" článkek',
		'name' => 'Name',	// TODO
		'no_filter' => 'Zrušit filtr',
		'number' => 'Dotaz n°%d',
		'order_asc' => 'Zobrazit nejdříve nejstarší články',
		'order_desc' => 'Zobrazit nejdříve nejnovější články',
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
		'always_show_favorites' => 'Show all articles in favourites by default',	// TODO
		'articles_per_page' => 'Počet článků na stranu',
		'auto_load_more' => 'Načítat další články dole na stránce',
		'auto_remove_article' => 'Po přečtení články schovat',
		'confirm_enabled' => 'Vyžadovat potvrzení pro akci “označit vše jako přečtené”',
		'display_articles_unfolded' => 'Ve výchozím stavu zobrazovat články otevřené',
		'display_categories_unfolded' => 'Categories to unfold',	// TODO
		'headline' => array(
			'articles' => 'Articles: Open/Close',	// TODO
			'categories' => 'Left navigation: Categories',	// TODO
			'mark_as_read' => 'Mark article as read',	// TODO
			'misc' => 'Miscellaneous',	// TODO
			'view' => 'View',	// TODO
		),
		'hide_read_feeds' => 'Schovat kategorie a kanály s nulovým počtem nepřečtených článků (nefunguje s nastavením “Zobrazit všechny články”)',
		'img_with_lazyload' => 'Použít "lazy load" mód pro načítaní obrázků',
		'jump_next' => 'skočit na další nepřečtený (kanál nebo kategorii)',
		'mark_updated_article_unread' => 'Označte aktualizované položky jako nepřečtené',
		'number_divided_when_reader' => 'V režimu “Čtení” děleno dvěma.',
		'read' => array(
			'article_open_on_website' => 'když je otevřen původní web s článkem',
			'article_viewed' => 'během čtení článku',
			'keep_max_n_unread' => 'Max number of articles to keep unread',	// TODO
			'scroll' => 'během skrolování',
			'upon_reception' => 'po načtení článku',
			'when' => 'Označit článek jako přečtený…',
			'when_same_title' => 'if an identical title already exists in the top <i>n</i> newest articles',	// TODO
		),
		'show' => array(
			'_' => 'Počet zobrazených článků',
			'active_category' => 'Active category',	// TODO
			'adaptive' => 'Vyberte zobrazení',
			'all_articles' => 'Zobrazit všechny články',
			'all_categories' => 'All categories',	// TODO
			'no_category' => 'No category',	// TODO
			'remember_categories' => 'Remember open categories',	// TODO
			'unread' => 'Zobrazit jen nepřečtené',
		),
		'show_fav_unread_help' => 'Applies also on labels',	// TODO
		'sides_close_article' => 'Clicking outside of article text area closes the article',	// TODO
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
		'add' => 'Add a sharing method',	// TODO
		'blogotext' => 'Blogotext',	// IGNORE
		'diaspora' => 'Diaspora*',	// IGNORE
		'email' => 'Email',	// TODO
		'facebook' => 'Facebook',	// IGNORE
		'more_information' => 'Více informací',
		'print' => 'Tisk',
		'raindrop' => 'Raindrop.io',	// IGNORE
		'remove' => 'Remove sharing method',	// TODO
		'shaarli' => 'Shaarli',	// IGNORE
		'share_name' => 'Jméno pro zobrazení',
		'share_url' => 'Jakou URL použít pro sdílení',
		'title' => 'Sdílení',
		'twitter' => 'Twitter',	// IGNORE
		'wallabag' => 'wallabag',	// IGNORE
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
		'global_view' => 'Switch to global view',	// TODO
		'help' => 'Zobrazit documentaci',
		'javascript' => 'Pro použití zkratek musí být povolen JavaScript',
		'last_article' => 'Skočit na poslední článek',
		'load_more' => 'Načíst více článků',
		'mark_favorite' => 'Označit jako oblíbené',
		'mark_read' => 'Označit jako přečtené',
		'navigation' => 'Navigace',
		'navigation_help' => 'Pomocí přepínače <kbd>⇧ Shift</kbd> fungují navigační zkratky v rámci kanálů.<br/>Pomocí přepínače <kbd>Alt ⎇</kbd> fungují v rámci kategorií.',
		'navigation_no_mod_help' => 'The following navigation shortcuts do not support modifiers.',	// TODO
		'next_article' => 'Skočit na další článek',
		'next_unread_article' => 'Open the next unread article',	// TODO
		'non_standard' => 'Some keys (<kbd>%s</kbd>) may not work as shortcuts.',	// TODO
		'normal_view' => 'Switch to normal view',	// TODO
		'other_action' => 'Ostatní akce',
		'previous_article' => 'Skočit na předchozí článek',
		'reading_view' => 'Switch to reading view',	// TODO
		'rss_view' => 'Open as RSS feed',	// TODO
		'see_on_website' => 'Navštívit původní webovou stránku',
		'shift_for_all_read' => '+ <kbd>Alt ⎇</kbd> to mark previous articles as read<br />+ <kbd>⇧ Shift</kbd> to mark all articles as read',	// TODO
		'skip_next_article' => 'Focus next without opening',	// TODO
		'skip_previous_article' => 'Focus previous without opening',	// TODO
		'title' => 'Zkratky',
		'toggle_media' => 'Play/pause media',	// TODO
		'user_filter' => 'Aplikovat uživatelské filtry',
		'user_filter_help' => 'Je-li nastaven pouze jeden filtr, bude použit. Další filtry jsou dostupné pomocí jejich čísla.',
		'views' => 'Views',	// TODO
	),
	'user' => array(
		'articles_and_size' => '%s článků (%s)',
		'current' => 'Aktuální uživatel',
		'is_admin' => 'je administrátor',
		'users' => 'Uživatelé',
	),
);
