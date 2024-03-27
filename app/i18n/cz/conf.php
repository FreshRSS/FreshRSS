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
		'exception' => 'Výjimka vymazání',
		'help' => 'Více možností je dostupných v nastavení jednotlivých kanálů',
		'keep_favourites' => 'Nikdy neodstraňovat oblíbené',
		'keep_labels' => 'Nikdy neodstraňovat popisky',
		'keep_max' => 'Maximální počet článků k ponechání na kanál',
		'keep_min_by_feed' => 'Minimální počet článků k ponechání na kanál',
		'keep_period' => 'Maximální stáří článků k ponechání',
		'keep_unreads' => 'Nikdy neodstraňovat nepřečtené články',
		'maintenance' => 'Údržba',
		'optimize' => 'Optimalizovat databázi',
		'optimize_help' => 'Občas spusťte pro zmenšení velikosti databáze',
		'policy' => 'Zásady vymazání',
		'policy_warning' => 'Pokud není vybrána žádná zásada vymazání, budou ponechány všechny články.',
		'purge_now' => 'Vymazat nyní',
		'title' => 'Archivace',
		'ttl' => 'Neobnovovat automaticky častěji než',
	),
	'display' => array(
		'_' => 'Zobrazení',
		'darkMode' => array(
			'_' => 'Automatic dark mode (beta)',	// TODO
			'auto' => 'Auto',	// TODO
			'no' => 'No',	// TODO
		),
		'icon' => array(
			'bottom_line' => 'Spodní řádek',
			'display_authors' => 'Autoři',
			'entry' => 'Ikony článků',
			'publication_date' => 'Datum vydání',
			'related_tags' => 'Štítky článků',
			'sharing' => 'Sdílení',
			'summary' => 'Souhrn',
			'top_line' => 'Horní řádek',
		),
		'language' => 'Jazyk',
		'notif_html5' => array(
			'seconds' => 'sekund (0 znamená žádný časový limit)',
			'timeout' => 'Časový limit HTML5 oznámení',
		),
		'show_nav_buttons' => 'Zobrazit navigační tlačítka',
		'theme' => array(
			'_' => 'Motiv',
			'deprecated' => array(
				'_' => 'Deprecated',	// TODO
				'description' => 'This theme is no longer supported and will be not available anymore in a <a href="https://freshrss.github.io/FreshRSS/en/users/05_Configuration.html#theme" target="_blank">future release of FreshRSS</a>',	// TODO
			),
		),
		'theme_not_available' => 'Motiv „%s“ již není dostupný. Zvolte jiný motiv, prosím.',
		'thumbnail' => array(
			'label' => 'Náhled',
			'landscape' => 'Na šířku',
			'none' => 'Žádný',
			'portrait' => 'Na výšku',
			'square' => 'Čtverec',
		),
		'timezone' => 'Time zone',	// TODO
		'title' => 'Zobrazení',
		'website' => array(
			'full' => 'Icon and name',	// TODO
			'icon' => 'Icon only',	// TODO
			'label' => 'Website',	// TODO
			'name' => 'Name only',	// TODO
			'none' => 'None',	// TODO
		),
		'width' => array(
			'content' => 'Šířka obsahu',
			'large' => 'Široká',
			'medium' => 'Střední',
			'no_limit' => 'Plná šířka',
			'thin' => 'Úzká',
		),
	),
	'logs' => array(
		'loglist' => array(
			'level' => 'Úroveň protokolování',
			'message' => 'Záznam protokolu',
			'timestamp' => 'Časová značka',
		),
		'pagination' => array(
			'first' => 'První',
			'last' => 'Poslední',
			'next' => 'Další',
			'previous' => 'Předchozí',
		),
	),
	'profile' => array(
		'_' => 'Správa profilu',
		'api' => 'Správa API',
		'delete' => array(
			'_' => 'Odstranění účtu',
			'warn' => 'Váš účet bude odstraněn spolu se všemi souvisejícími daty.',
		),
		'email' => 'E-mailová adresa',
		'password_api' => 'Heslo API<br /><small>(např. pro mobilní aplikace)</small>',
		'password_form' => 'Heslo<br /><small>(pro přihlášení webovým formulářem)</small>',
		'password_format' => 'Alespoň 7 znaků',
		'title' => 'Profil',
	),
	'query' => array(
		'_' => 'Uživatelské dotazy',
		'deprecated' => 'Tento dotaz již není platný. Odkazovaná kategorie nebo kanál byly odstraněny.',
		'filter' => array(
			'_' => 'Použitý filtr:',
			'categories' => 'Zobrazit podle kategorie',
			'feeds' => 'Zobrazit podle kanálu',
			'order' => 'Seřadit podle data',
			'search' => 'Výraz',
			'shareOpml' => 'Enable sharing by OPML of corresponding categories and feeds',	// TODO
			'shareRss' => 'Enable sharing by HTML &amp; RSS',	// TODO
			'state' => 'Stav',
			'tags' => 'Zobrazit podle štítku',
			'type' => 'Typ',
		),
		'get_all' => 'Zobrazit všechny články',
		'get_all_labels' => 'Display articles with any label',	// TODO
		'get_category' => 'Zobrazit kategorii „%s“',
		'get_favorite' => 'Zobrazit oblíbené články',
		'get_feed' => 'Zobrazit kanál „%s“',
		'get_important' => 'Display articles from important feeds',	// TODO
		'get_label' => 'Display articles with “%s” label',	// TODO
		'help' => 'See the <a href="https://freshrss.github.io/FreshRSS/en/users/user_queries.html" target="_blank">documentation for user queries and resharing by HTML / RSS / OPML</a>.',	// TODO
		'name' => 'Název',
		'no_filter' => 'Žádný filtr',
		'number' => 'Dotaz č. %d',
		'order_asc' => 'Zobrazit nejdříve nejstarší články',
		'order_desc' => 'Zobrazit nejdříve nejnovější články',
		'search' => 'Hledat „%s“',
		'share' => array(
			'_' => 'Share this query by link',	// TODO
			'help' => 'Give this link if you want to share this query with anyone',	// TODO
			'html' => 'Shareable link to the HTML page',	// TODO
			'opml' => 'Shareable link to the OPML list of feeds',	// TODO
			'rss' => 'Shareable link to the RSS feed',	// TODO
		),
		'state_0' => 'Zobrazit všechny články',
		'state_1' => 'Zobrazit přečtené články',
		'state_2' => 'Zobrazit nepřečtené články',
		'state_3' => 'Zobrazit všechny články',
		'state_4' => 'Zobrazit oblíbené články',
		'state_5' => 'Zobrazit přečtené oblíbené články',
		'state_6' => 'Zobrazit nepřečtené oblíbené články',
		'state_7' => 'Zobrazit oblíbené články',
		'state_8' => 'Zobrazit neoblíbené články',
		'state_9' => 'Zobrazit přečtené neoblíbené články',
		'state_10' => 'Zobrazit nepřečtené neoblíbené články',
		'state_11' => 'Zobrazit neoblíbené články',
		'state_12' => 'Zobrazit všechny články',
		'state_13' => 'Zobrazit přečtené články',
		'state_14' => 'Zobrazit nepřečtené články',
		'state_15' => 'Zobrazit všechny články',
		'title' => 'Uživatelské dotazy',
	),
	'reading' => array(
		'_' => 'Čtení',
		'after_onread' => 'Po „označit vše jako přečtené“',
		'always_show_favorites' => 'Ve výchozím nastavení zobrazit všechny články v oblíbených',
		'article' => array(
			'authors_date' => array(
				'_' => 'Autoři a datum',
				'both' => 'V záhlaví a zápatí',
				'footer' => 'V zápatí',
				'header' => 'V záhlaví',
				'none' => 'Žádný',
			),
			'empty_article_title' => array(
				'firstWords' => 'first words',	// TODO
				'guid' => 'GUID',	// TODO
				'label' => 'if feed title is empty, show…',	// TODO
				'noGUID' => '(no GUID)',	// TODO
				'noText' => '(no text)',	// TODO
				'noTitle' => '(no title)',	// TODO
			),
			'feed_name' => array(
				'above_title' => 'Nad názvem/štítky',
				'none' => 'Žádný',
				'with_authors' => 'V řádku s autory a datem',
			),
			'feed_title' => 'Název feedu',
			'tags' => array(
				'_' => 'Štítky',
				'both' => 'V záhlaví a zápatí',
				'footer' => 'V zápatí',
				'header' => 'V záhlaví',
				'none' => 'Žádné',
			),
			'tags_max' => array(
				'_' => 'Maximální počet zobrazených štítků',
				'help' => '0 znamená: zobrazit všechny značky a nesbalovat je.',
			),
		),
		'articles_per_page' => 'Počet článků na stránku',
		'auto_load_more' => 'Načítat další články dole na stránce',
		'auto_remove_article' => 'Po přečtení články skrýt',
		'confirm_enabled' => 'Zobrazit potvrzovací dialové okno pro akce „označit vše jako přečtené“',
		'display_articles_unfolded' => 'Ve výchozím nastavení zobrazovat články rozbalené',
		'display_categories_unfolded' => 'Kategorii, které rozbalovat',
		'headline' => array(
			'articles' => 'Články: Otevřít/zavřít',
			'articles_header_footer' => 'Články: záhlaví/zápatí',
			'categories' => 'Navigace vlevo: Kategorie',
			'mark_as_read' => 'Označit článek jako přečtený',
			'misc' => 'Různé',
			'view' => 'Zobrazit',
		),
		'hide_read_feeds' => 'Skrýt kategorie a kanály bez nepřečtených článků (nefunguje s nastavením „Zobrazit všechny články“)',
		'img_with_lazyload' => 'Použít režim „líné načítání“ pro načítaní obrázků',
		'jump_next' => 'skočit na další nepřečtenou položku na stejné úrovni (kanál nebo kategorie)',
		'mark_updated_article_unread' => 'Označit aktualizované články jako nepřečtené',
		'number_divided_when_reader' => 'Děleno dvěma v zobrazení pro čtení.',
		'read' => array(
			'article_open_on_website' => 'když je článek otevřen na své původní webové stránce',
			'article_viewed' => 'když je článek zobrazen',
			'focus' => 'when focused (except for important feeds)',	// TODO
			'keep_max_n_unread' => 'Maximální počet článků, které ponechat jako nepřečtené',
			'scroll' => 'během posouvání (except for important feeds)',	// DIRTY
			'upon_gone' => 'když se již nenachází v upstreamu zpráv.',
			'upon_reception' => 'po obdržení článku',
			'when' => 'Označit článek jako přečtený…',
			'when_same_title' => 'když shodný název již existuje v top <i>n</i> nejnovějších článcích',
		),
		'show' => array(
			'_' => 'Počet zobrazených článků',
			'active_category' => 'Aktivní kategorie',
			'adaptive' => 'Vyberte zobrazení',
			'all_articles' => 'Zobrazit všechny články',
			'all_categories' => 'Všechny kategorie',
			'no_category' => 'Žádná kategorie',
			'remember_categories' => 'Zapamatovat otevřené kategorie',
			'unread' => 'Zobrazit pouze nepřečtené',
		),
		'show_fav_unread_help' => 'Použije se také na popisky',
		'sides_close_article' => 'Kliknutí mimo oblast textu článku zavře článek',
		'sort' => array(
			'_' => 'Pořadí řazení',
			'newer_first' => 'Nejdříve nejnovější',
			'older_first' => 'Nejdříve nejstarší',
		),
		'sticky_post' => 'Při otevření připnout článek na začátek',
		'title' => 'Čtení',
		'view' => array(
			'default' => 'Výchozí zobrazení',
			'global' => 'Zobrazení přehledu',
			'normal' => 'Normální zobrazení',
			'reader' => 'Zobrazení pro čtení',
		),
	),
	'sharing' => array(
		'_' => 'Sdílení',
		'add' => 'Přidat metodu sdílení',
		'blogotext' => 'Blogotext',	// IGNORE
		'deprecated' => 'Tato služba je zastaralá a bude ze služby FreshRSS odstraněna v <a href="https://freshrss.github.io/FreshRSS/en/users/08_sharing_services.html" title="Otevřete dokumentaci pro další informace" target="_blank">budoucím vydání</a>.',
		'diaspora' => 'Diaspora*',	// IGNORE
		'email' => 'E-mail',
		'facebook' => 'Facebook',	// IGNORE
		'more_information' => 'Více informací',
		'print' => 'Tisknout',
		'raindrop' => 'Raindrop.io',	// IGNORE
		'remove' => 'Odebrat metodu sdílení',
		'shaarli' => 'Shaarli',	// IGNORE
		'share_name' => 'Zobrazený název pro sdílení',
		'share_url' => 'Použitá adresa URL pro sdílení',
		'title' => 'Sdílení',
		'twitter' => 'Twitter',	// IGNORE
		'wallabag' => 'Wallabag',	// IGNORE
	),
	'shortcut' => array(
		'_' => 'Zkratky',
		'article_action' => 'Akce článku',
		'auto_share' => 'Sdílet',
		'auto_share_help' => 'Pokud je pouze jeden režim sdílení, je použit. Jinak jsou režimy dostupné podle jejich čísla.',
		'close_dropdown' => 'Zavřít nabídky',
		'collapse_article' => 'Sbalit',
		'first_article' => 'Otevřít první článek',
		'focus_search' => 'Vstoupit do vyhledávacího pole',
		'global_view' => 'Přepnout na zobrazení přehledu',
		'help' => 'Zobrazit dokumentaci',
		'javascript' => 'Pro použití zkratek musí být povolen JavaScript',
		'last_article' => 'Otevřít poslední článek',
		'load_more' => 'Načíst více článků',
		'mark_favorite' => 'Přepnout oblíbené',
		'mark_read' => 'Přepnout přečtené',
		'navigation' => 'Navigace',
		'navigation_help' => 'S přepínačem <kbd>⇧ Shift</kbd> se navigační zkratky použijí na kanály.<br/>S přepínačem <kbd>Alt ⎇</kbd> se navigační zkratky použijí na kategorie.',
		'navigation_no_mod_help' => 'Následující navigační zkratky nepodporují přepínače.',
		'next_article' => 'Otevřít další článek',
		'next_unread_article' => 'Otevřít další nepřečtený článek',
		'non_standard' => 'Některé klávesy (<kbd>%s</kbd>) nemusí fungovat jako zkratky.',
		'normal_view' => 'Přepnout na normální zobrazení',
		'other_action' => 'Ostatní akce',
		'previous_article' => 'Otevřít předchozí článek',
		'reading_view' => 'Přepnout na zobrazení pro čtení',
		'rss_view' => 'Otevřít jako kanál RSS',
		'see_on_website' => 'Navštívit původní webovou stránku',
		'shift_for_all_read' => '+ <kbd>Alt ⎇</kbd> pro označení předchozích článků jako přečtených<br />+ <kbd>⇧ Shift</kbd> pro označení všech článků jako přečtených',
		'skip_next_article' => 'Zaměřit na další bez otevření',
		'skip_previous_article' => 'Zaměřit na předchozí bez otevření',
		'title' => 'Zkratky',
		'toggle_media' => 'Přehrát/pozastavit médium',
		'user_filter' => 'Přístup k uživatelským dotazům',
		'user_filter_help' => 'Pokud je pouze jeden uživatelský dotaz, je použit. Jinak jsou dotazy dostupné podle jejich čísla.',
		'views' => 'Zobrazení',
	),
	'user' => array(
		'articles_and_size' => '%s článků (%s)',
		'current' => 'Aktuální uživatel',
		'is_admin' => 'je administrátor',
		'users' => 'Uživatelé',
	),
);
