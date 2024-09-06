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
		'_' => 'Archiválás',
		'exception' => 'Takarítási kivételek',
		'help' => 'Több beállítás elérhető az egyes hírforrások beállításaiban',
		'keep_favourites' => 'Soha ne töröljön kedvenc cikkeket',
		'keep_labels' => 'Soha ne töröljön címkéket',
		'keep_max' => 'Maximum ennyi cikket tartson meg hírforrásonként',
		'keep_min_by_feed' => 'Minimum ennyi cikket tartson meg hírforrásonként',
		'keep_period' => 'Megtartandó cikkek maximális kora',
		'keep_unreads' => 'Soha ne töröljön olvasatlan cikkeket',
		'maintenance' => 'Karbantartás',
		'optimize' => 'Adatbázis optimalizálás',
		'optimize_help' => 'Néha érdemes futtatni az adatbázis méretének csökkentéséhez',
		'policy' => 'Törlési eljárás',
		'policy_warning' => 'Ha nincs törlési eljárás, akkor minden cikk meg lesz tartva.',
		'purge_now' => 'Tisztítás most',
		'title' => 'Archiválás',
		'ttl' => 'Ne frissítsen automatikusan sűrűbben mint',
	),
	'display' => array(
		'_' => 'Megjelenítés',
		'darkMode' => array(
			'_' => 'Automatikus sötét mód',
			'auto' => 'Automatikus',
			'help' => 'For compatible themes only',	// TODO
			'no' => 'Nem',
		),
		'icon' => array(
			'bottom_line' => 'Alsó sor',
			'display_authors' => 'Szerzők',
			'entry' => 'Cikk ikonok',
			'publication_date' => 'Kiadás ideje',
			'related_tags' => 'Cikk címkék',
			'sharing' => 'Megosztás',
			'summary' => 'Összegzés',
			'top_line' => 'Felső sor',
		),
		'language' => 'Nyelv',
		'notif_html5' => array(
			'seconds' => 'másodpercek (A 0 azt jelenti, hogy nincs időkorlát)',
			'timeout' => 'HTML5 értesítés hossza',
		),
		'show_nav_buttons' => 'Navigációs gombok megjelenítése',
		'theme' => array(
			'_' => 'Téma',
			'deprecated' => array(
				'_' => 'Elavult',
				'description' => 'Ez a téma már nem támogatott és nem lesz elérhető <a href="https://freshrss.github.io/FreshRSS/en/users/05_Configuration.html#theme" target="_blank">a FreshRSS következő verzióiban</a>',
			),
		),
		'theme_not_available' => 'A(z) „%s” téma már nem elérhető. Válassz egy másik témát.',
		'thumbnail' => array(
			'label' => 'Miniatűr',
			'landscape' => 'Fekvő',
			'none' => 'Nincs',
			'portrait' => 'Álló',
			'square' => 'Négyzet',
		),
		'timezone' => 'Időzóna',
		'title' => 'Megjelenítés',
		'website' => array(
			'full' => 'Ikon és név',
			'icon' => 'Csak ikon',
			'label' => 'Weblap',
			'name' => 'Csak név',
			'none' => 'Semmi',
		),
		'width' => array(
			'content' => 'Tartalom szélessége',
			'large' => 'Széles',
			'medium' => 'Közepes',
			'no_limit' => 'Teljes szélességű',
			'thin' => 'Vékony',
		),
	),
	'logs' => array(
		'loglist' => array(
			'level' => 'Log Szint',
			'message' => 'Log Üzenet',
			'timestamp' => 'Időbélyeg',
		),
		'pagination' => array(
			'first' => 'Első',
			'last' => 'Utolsó',
			'next' => 'Következő',
			'previous' => 'Előző',
		),
	),
	'profile' => array(
		'_' => 'Profil kezelés',
		'api' => 'API menedzsment',
		'delete' => array(
			'_' => 'Profil törlése',
			'warn' => 'A profilod és minden hozzá tartozó adat törölve lesz.',
		),
		'email' => 'Email cím',
		'password_api' => 'API jelszó<br /><small>(például mobil appoknak)</small>',
		'password_form' => 'Jelszó<br /><small>(a Web-form belépési módhoz)</small>',
		'password_format' => 'Legalább 7 karakter',
		'title' => 'Profil',
	),
	'query' => array(
		'_' => 'Felhasználói lekérdezések',
		'deprecated' => 'Ez a lekérdezés már nem érvényes. A hivatkozott kategória vagy hírforrás törölve lett.',
		'description' => 'Description',	// TODO
		'filter' => array(
			'_' => 'Alkalmazott szűrő:',
			'categories' => 'Rendezés kategória szerint',
			'feeds' => 'Rendezés hírforrás szerint',
			'order' => 'Rendezés dátum szerint',
			'search' => 'Kifejezés',
			'shareOpml' => 'Engedélyezze a megfelelő kategóriák és hírcsatornák OPML-alapú megosztását',
			'shareRss' => 'Engedélyezze a HTML &amp; RSS megosztást',
			'state' => 'Státusz',
			'tags' => 'Rendezés címke szerint',
			'type' => 'Típus',
		),
		'get_all' => 'Minden cikk megjelenítése',
		'get_all_labels' => 'Cikkek megjelenítése bármilyen címkével',
		'get_category' => '„%s” kategória megjelenítése',
		'get_favorite' => 'Kedvenc cikkek megjelenítése',
		'get_feed' => '„%s” hírforrás megjelenítése',
		'get_important' => 'Cikkek megjelenítése fontos hírforrásokból',
		'get_label' => ' „%s” címkével rendelkező cikkek megjelenítése',
		'help' => 'Lásd a <a href="https://freshrss.github.io/FreshRSS/en/users/user_queries.html" target="_blank"> dokumentációt a felhasználói lekérdezések és HTML/RSS/OPML megosztás témákban</a>.',
		'image_url' => 'Image URL',	// TODO
		'name' => 'Név',
		'no_filter' => 'Nincs szűrés',
		'number' => '%d lekérdezés',
		'order_asc' => 'Régebbi cikkek előre',
		'order_desc' => 'Újabb cikkek előre',
		'search' => 'Keresés erre „%s”',
		'share' => array(
			'_' => 'Lekérdezés megosztása linkkel',
			'greader' => 'Shareable link to the GReader JSON',	// TODO
			'help' => 'Ezt a linket küldd el hogy megoszd a lekérdezést bárkivel',
			'html' => 'Megosztható link a HTML oldalhoz',
			'opml' => 'Megosztható link az OPML hírforrás listához',
			'rss' => 'Megosztható link az RSS hírforráshoz',
		),
		'state_0' => 'Minden cikk megjelenítése',
		'state_1' => 'Olvasott cikkek megjelenítése',
		'state_2' => 'Olvasatlan cikkek megjelenítése',
		'state_3' => 'Minden cikk megjelenítése',
		'state_4' => 'Kedvenc cikkek megjelenítése',
		'state_5' => 'Kedvenc olvasott cikkek megjelenítése',
		'state_6' => 'Kedvenc olvasatlan cikkek megjelenítése',
		'state_7' => 'Kedvenc cikkek megjelenítése',
		'state_8' => 'Nem kedvenc cikkek megjelenítése',
		'state_9' => 'Nem kedvenc olvasott cikkek megjelenítése',
		'state_10' => 'Nem kedvenc olvasatlan cikkek megjelenítése',
		'state_11' => 'Nem kedvenc cikkek megjelenítése',
		'state_12' => 'Minden cikk megjelenítése',
		'state_13' => 'Olvasott cikkek megjelenítése',
		'state_14' => 'Olvasatlan cikkek megjelenítése',
		'state_15' => 'Minden cikk megjelenítése',
		'title' => 'Felhasználói lekérdezések',
	),
	'reading' => array(
		'_' => 'Olvasás',
		'after_onread' => 'Utána „minden megjelölése olvasottként”,',
		'always_show_favorites' => 'Minden cikk megjelenítése a kedvencekben alapértelmezetten',
		'article' => array(
			'authors_date' => array(
				'_' => 'Szerzők és dátum',
				'both' => 'Fejlécben és láblécben',
				'footer' => 'Láblécben',
				'header' => 'Fejlécben',
				'none' => 'Sehol',
			),
			'feed_name' => array(
				'above_title' => 'Cím/címke felett',
				'none' => 'Sehol',
				'with_authors' => 'A szerzők és dátum sorban',
			),
			'feed_title' => 'Hírforrás címe',
			'icons' => array(
				'_' => 'Article icons position<br /><small>(Reading view only)</small>',	// TODO
				'above_title' => 'Above title',	// TODO
				'with_authors' => 'In authors and date row',	// TODO
			),
			'tags' => array(
				'_' => 'Címkék',
				'both' => 'Fejlécben és láblécben',
				'footer' => 'Láblécben',
				'header' => 'Fejlécben',
				'none' => 'Sehol',
			),
			'tags_max' => array(
				'_' => 'Címkék maximális száma',
				'help' => '0 esetén: minden címke mutatása összecsukás nélkül',
			),
		),
		'articles_per_page' => 'Cikkek száma oldalanként',
		'auto_load_more' => 'Még több cikk betöltése, ha a lap aljához ért',
		'auto_remove_article' => 'Cikkek elrejtése elolvasás után',
		'confirm_enabled' => 'Megerősítő jóváhagyás a „jelölje mindet olvasottként” végrehajtása előtt',
		'display_articles_unfolded' => 'Legyenek a cikkek kibontva alapértelmezésben',
		'display_categories_unfolded' => 'Mely kategóriák legyenek kibontva',
		'headline' => array(
			'articles' => 'Cikkek: Nyitva/Zárva',
			'articles_header_footer' => 'Cikkek: fejléc/lábléc',
			'categories' => 'Baloldali navigáció: Kategóriák',
			'mark_as_read' => 'Cikk megjelölése olvasottnak',
			'misc' => 'Egyebek',
			'view' => 'Nézet',
		),
		'hide_read_feeds' => 'Rejtse el a kategóriákat és hírforrásokat ahol nincs olvasatlan cikk (nem működik egyszerre a „Minden cikk megjelenítése” beállítással)',
		'img_with_lazyload' => 'Használjon <em>lazy load</em> módot a képek betöltésére',
		'jump_next' => 'ugorjon a következő olvasatlan testvérre (hírforrás vagy kategória)',
		'mark_updated_article_unread' => 'Frissített cikkek megjelölése olvasatlanként',
		'number_divided_when_reader' => 'Olvasó módban 2-vel osztható szám.',
		'read' => array(
			'article_open_on_website' => 'ha a cikk megnyitásra került az eredeti weblapon',
			'article_viewed' => 'ha a cikk megtekintésre került',
			'focus' => 'amikor fókuszált (kivéve a fontos hírforrásokat)',
			'keep_max_n_unread' => 'Cikkek maximális száma olvasatlanként tartva',
			'scroll' => 'görgetés közben (kivéve a fontos hírforrásokat)',
			'upon_gone' => 'ha már nincs benne a hírforrásban',
			'upon_reception' => 'a cikk beérkezésekor',
			'when' => 'Jelöljön meg egy cikket olvasottként…',
			'when_same_title' => 'ha egy azonos című cikk már létezik a legújabb <i>n</i> számú cikk között',
		),
		'show' => array(
			'_' => 'Megjelenített cikkek',
			'active_category' => 'Aktív kategória',
			'adaptive' => 'Megjelenítés beállítása',
			'all_articles' => 'Mindegyik cikk megjelenítése',
			'all_categories' => 'Mindegyik kategória',
			'no_category' => 'Nincs kategória',
			'remember_categories' => 'Emlékezzen a kibontott kategóriákra',
			'unread' => 'Csak az olvasatlan cikkek',
		),
		'show_fav_unread_help' => 'A címkékre is vonatkozik',
		'sides_close_article' => 'A cikk szövegrészén kívüli kattintás bezárja a cikket',
		'sort' => array(
			'_' => 'Rendezési sorrend',
			'newer_first' => 'Újabb elöl',
			'older_first' => 'Régebbi elöl',
		),
		'star' => array(
			'when' => 'Mark an article as favourite…',	// TODO
		),
		'sticky_post' => 'A cikk gördüljön felülre, amikor megnyitásra kerül',
		'title' => 'Olvasás',
		'view' => array(
			'default' => 'Alapértelmezett nézet',
			'global' => 'Globális nézet',
			'normal' => 'Normál nézet',
			'reader' => 'Olvasó nézet',
		),
	),
	'sharing' => array(
		'_' => 'Megosztás',
		'add' => 'Megosztási mód hozzáadása',
		'deprecated' => 'Ez a szolgáltatás elavult, és el lesz távolítva a FreshRSS <a href="https://freshrss.github.io/FreshRSS/en/users/08_sharing_services.html" title="Dokumentáció további információkért" target="_blank">következő kiadásában.</a>.',
		'diaspora' => 'Diaspora*',	// IGNORE
		'email' => 'Email',	// IGNORE
		'facebook' => 'Facebook',	// IGNORE
		'more_information' => 'Több információ',
		'print' => 'Print',	// IGNORE
		'raindrop' => 'Raindrop.io',	// IGNORE
		'remove' => 'Megosztási mód eltávolítása',
		'shaarli' => 'Shaarli',	// IGNORE
		'share_name' => 'Megosztás neve',
		'share_url' => 'URL megosztása a használathoz',
		'title' => 'Sharing',	// IGNORE
		'twitter' => 'Twitter',	// IGNORE
		'wallabag' => 'wallabag',	// IGNORE
	),
	'shortcut' => array(
		'_' => 'Gyorsgombok',
		'article_action' => 'Cikk műveletek',
		'auto_share' => 'Megosztás',
		'auto_share_help' => 'Ha csak egy megosztási mód van, az lesz használva. Egyébként, a megosztási módok a számukkal elérhetőek.',
		'close_dropdown' => 'Menük bezárása',
		'collapse_article' => 'Összecsuk',
		'first_article' => 'Első cikk megnyitása',
		'focus_search' => 'Ugrás a keresődobozra',
		'global_view' => 'Váltás globális nézetre',
		'help' => 'Dokumentáció megjelenítése',
		'javascript' => 'A JavaScript-et engedélyezni kell a gyorsgombok használatához',
		'last_article' => 'Utolsó cikk megnyitása',
		'load_more' => 'Több cikk betöltése',
		'mark_favorite' => 'Legyen kedvenc',
		'mark_read' => 'Legyen olvasott',
		'navigation' => 'Navigáció',
		'navigation_help' => 'A <kbd>⇧ Shift</kbd> billentyűk lenyomásával a navigációs gyorsgombok a hírforrásokra vonatkoznak. <br/>A <kbd>Alt ⎇</kbd> billentyűk lenyomásával a navigációs gyorsgombok kategóriákra vonatkoznak.',
		'navigation_no_mod_help' => 'A következő navigációs gombok nem támogatják a módosítókat.',
		'next_article' => 'Következő cikk megnyitása',
		'next_unread_article' => 'Következő olvasatlan cikk megnyitása',
		'non_standard' => 'Néhány gomb (<kbd>%s</kbd>) nem használható gyorsgombként.',
		'normal_view' => 'Váltás normál nézetre',
		'other_action' => 'Egyéb műveletek',
		'previous_article' => 'Előző cikk megnyitása',
		'reading_view' => 'Váltás olvasó nézetre',
		'rss_view' => 'RSS hírforrás megnyitása',
		'see_on_website' => 'Eredeti weblap megnyitása',
		'shift_for_all_read' => '+ <kbd>Alt ⎇</kbd> az előző cikkek olvasottnak jelöléséhez<br />+ <kbd>⇧ Shift</kbd> összes cikk olvasottnak jelöléséhez',
		'skip_next_article' => 'Ugrás a következőre megnyitás nélkül',
		'skip_previous_article' => 'Ugrás az előzőre megnyitás nélkül',
		'title' => 'Gyorsgombok',
		'toggle_media' => 'Média indítás/megállítás',
		'user_filter' => 'Felhasználói lekérdezések elfogadása',
		'user_filter_help' => 'Ha csak egy felhasználói lekérdezés van, akkor az kerül felhasználásra. Ellenkező esetben a lekérdezések a számuk alapján érhetőek el.',
		'views' => 'Nézetek',
	),
	'user' => array(
		'articles_and_size' => '%s darab cikk (%s)',
		'current' => 'Jelenlegi felhasználó',
		'is_admin' => 'adminisztrátor',
		'users' => 'Felhasználók',
	),
);
