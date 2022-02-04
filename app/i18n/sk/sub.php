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
	'api' => array(
		'documentation' => 'Skopírujte tento odkaz a použite ho v inom programe.',
		'title' => 'API',	// IGNORE
	),
	'bookmarklet' => array(
		'documentation' => 'Presunte toto tlačidlo do vašich záložiek, alebo kliknite pravým a zvoľte "Uložiť odkaz do záložiek". Potom kliknite na tlačidlo "Odoberať" na ktorejkoľvek stránke, ktorú chcete odoberať.',
		'label' => 'Odoberať',
		'title' => 'Záložka',
	),
	'category' => array(
		'_' => 'Kategória',
		'add' => 'Pridať kategória',
		'archiving' => 'Archív',
		'empty' => 'Prázdna kategória',
		'information' => 'Informácia',
		'position' => 'Zobrazť pozíciu',
		'position_help' => 'Na kontrolu zoradenia kategórií',
		'title' => 'Názov',
	),
	'feed' => array(
		'add' => 'Pridať RSS kanál',
		'advanced' => 'Pokročilé',
		'archiving' => 'Archivovanie',
		'auth' => array(
			'configuration' => 'Prihlásenie',
			'help' => 'Povoliť prístup do kanálov chránených cez HTTP.',
			'http' => 'Prihlásenie cez HTTP',
			'password' => 'Heslo pre HTTP',
			'username' => 'Používateľské meno pre HTTP',
		),
		'clear_cache' => 'Vždy vymazať vyrovnávaciu pamäť',
		'content_action' => array(
			'_' => 'Akcia obsahu pri sťahovaní obsahu článku',
			'append' => 'Pridať za existujúci obsah',
			'prepend' => 'Pridať pred existujúci obsah',
			'replace' => 'Nahradiť existujúci obsh',
		),
		'css_cookie' => 'Pri sťahovaní obsahu článku použiť cookies',
		'css_cookie_help' => 'Príklad: <kbd>foo=bar; gdpr_consent=true; cookie=value</kbd>',
		'css_help' => 'Stiahnuť skrátenú verziu RSS kanála (pozor, vyžaduje viac času!)',
		'css_path' => 'Pôvodný CSS súbor článku z webovej stránky',
		'description' => 'Popis',
		'empty' => 'Tento kanál je prázdny. Overte, prosím, či je ešte spravovaný autorom.',
		'error' => 'Vyskytol sa problém s týmto kanálom. Overte, prosím, či kanál stále existuje, potom ho obnovte.',
		'filteractions' => array(
			'_' => 'Filtrovať akcie',
			'help' => 'Napíšte jeden výraz hľadania na riadok.',
		),
		'information' => 'Informácia',
		'keep_min' => 'Minimálny počet článkov na uchovanie',
		'maintenance' => array(
			'clear_cache' => 'Vymazať vyrovnáciu pamäť',
			'clear_cache_help' => 'Vymazať vyrovnáciu pamäť pre tento kanál.',
			'reload_articles' => 'Obnoviť články',
			'reload_articles_help' => 'Obnoviť články a stiahnuť kompletný obsah, ak je definovaný selektor.',
			'title' => 'Údržba',
		),
		'moved_category_deleted' => 'Keď vymažete kategóriu, jej kanály sa automaticky zaradia pod <em>%s</em>.',
		'mute' => 'stíšiť',
		'no_selected' => 'Nevybrali ste kanál.',
		'number_entries' => 'Počet článkov: %d',
		'priority' => array(
			'_' => 'Viditeľnosť',
			'archived' => 'Nezobrazovať (archivované)',
			'main_stream' => 'Zobraziť v prehľade kanálov',
			'normal' => 'Zobraziť vo svojej kategórii',
		),
		'proxy' => 'Na sťahovanie tohto kanálu nastaviť proxy',
		'proxy_help' => 'Vyberte protokol (napr.: SOCKS5) a zadajte adresu proxy servera (napr.: <kbd>127.0.0.1:1080</kbd>)',
		'selector_preview' => array(
			'show_raw' => 'Zobraziť zdrojový kód',
			'show_rendered' => 'Zobraziť obsah',
		),
		'show' => array(
			'all' => 'Zobraziť všetky kanály',
			'error' => 'Zobraziť iba kanály s chybou',
		),
		'showing' => array(
			'error' => 'Zobraziť iba kanály s chybou',
		),
		'ssl_verify' => 'Overiť bezpečnosť SSL',
		'stats' => 'Štatistiky',
		'think_to_add' => 'Mali by ste pridať kanály.',
		'timeout' => 'Doba platnosti dá v sekundách',
		'title' => 'Nadpis',
		'title_add' => 'Pridať kanál RSS',
		'ttl' => 'Automaticky neaktualizovať častejšie ako',
		'url' => 'Odkaz kanála',
		'useragent' => 'Nastaviť používateľského agenta na sťahovanie tohto kanála',
		'useragent_help' => 'Príklad: <kbd>Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:86.0)</kbd>',
		'validator' => 'Skontrolovať platnosť kanála',
		'website' => 'Odkaz webovej stránky',
		'websub' => 'Okamžité oznámenia cez WebSub',
	),
	'import_export' => array(
		'export' => 'Exportovať',
		'export_labelled' => 'Exportovať vaše označené články',
		'export_opml' => 'Exportovať zoznam kanálov (OPML)',
		'export_starred' => 'Exportovať vaše obľúbené',
		'feed_list' => 'Zoznam článkov %s',
		'file_to_import' => 'Súbor na import<br />(OPML, JSON alebo ZIP)',
		'file_to_import_no_zip' => 'Súbor na import<br />(OPML alebo JSON)',
		'import' => 'Importovať',
		'starred_list' => 'Zoznam obľúbených článkov',
		'title' => 'Import / export',	// IGNORE
	),
	'menu' => array(
		'add' => 'Pridať kanál alebo kategóriu',
		'import_export' => 'Import / export',	// IGNORE
		'label_management' => 'Správca štítkov',
		'stats' => array(
			'idle' => 'Neaktívne kanály',
			'main' => 'Hlavné štatistiky',
			'repartition' => 'Rozdelenie článkov',
		),
		'subscription_management' => 'Správa odoberaných kanálov',
		'subscription_tools' => 'Nástroje na odoberanie kanálov',
	),
	'tag' => array(
		'name' => 'Názov',
		'new_name' => 'Nový názov',
		'old_name' => 'Starý názov',
	),
	'title' => array(
		'_' => 'Správa odoberaných kanálov',
		'add' => 'Pridať kanál alebo kategóriu',
		'add_category' => 'Pridať kategóriu',
		'add_feed' => 'Pridať kanál',
		'add_label' => 'Pridať štítok',
		'delete_label' => 'Zmazať štítok',
		'feed_management' => 'Správa RSS kanálov',
		'rename_label' => 'Premenovať štítok',
		'subscription_tools' => 'Nástroje na odoberanie kanálov',
	),
);
