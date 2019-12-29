<?php

return array(
	'api' => array(
		'documentation' => 'Skopírujte tento odkaz a použite ho v inom programe.',
		'title' => 'API',
	),
	'bookmarklet' => array(
		'documentation' => 'Presunte toto tlačidlo do vašich záložiek, alebo kliknite pravým a zvoľte "Uložiť odkaz do záložiek". Potom kliknite na tlačidlo "Odoberať" na ktorejkoľvek stránke, ktorú chcete odoberať.',
		'label' => 'Odoberať',
		'title' => 'Záložka',
	),
	'category' => array(
		'add' => 'Pridať kategóriu',
		'archiving' => 'Archiving',	// TODO - Translation
		'empty' => 'Prázdna kategória',
		'information' => 'Informácia',
		'new' => 'Nová kategória',
		'position' => 'Display position',	// TODO - Translation
		'position_help' => 'To control category sort order',	// TODO - Translation
		'title' => 'Názov',
		'_' => 'Kategória',
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
		'css_help' => 'Stiahnuť skrátenú verziu RSS kanála (pozor, vyžaduje viac času!)',
		'css_path' => 'Pôvodný CSS súbor článku z webovej stránky',
		'description' => 'Popis',
		'empty' => 'Tento kanál je prázdny. Overte, prosím, či je ešte spravovaný autorom.',
		'error' => 'Vyskytol sa problém s týmto kanálom. Overte, prosím, či kanál stále existuje, potom ho obnovte.',
		'filteractions' => array(
			'help' => 'Napíšte jeden výraz hľadania na riadok.',
			'_' => 'Filtrovať akcie',
		),
		'information' => 'Informácia',
		'keep_min' => 'Minimálny počet článkov na uchovanie',
		'moved_category_deleted' => 'Keď vymažete kategóriu, jej kanály sa automaticky zaradia pod <em>%s</em>.',
		'mute' => 'stíšiť',
		'no_selected' => 'Nevybrali ste kanál.',
		'number_entries' => 'Počet článkov: %d',
		'priority' => array(
			'archived' => 'Nezobrazovať (archivované)',
			'main_stream' => 'Zobraziť v prehľade kanálov',
			'normal' => 'Zobraziť vo svojej kategórii',
			'_' => 'Viditeľnosť',
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
		'validator' => 'Skontrolovať platnosť kanála',
		'website' => 'Odkaz webovej stránky',
		'websub' => 'Okamžité oznámenia cez WebSub',
	),
	'firefox' => array(
		'documentation' => 'Pridajte RSS kanály do Firefoxu <a href="https://developer.mozilla.org/en-US/Firefox/Releases/2/Adding_feed_readers_to_Firefox#Adding_a_new_feed_reader_manually">pomocou tohto návodu</a>.',
		'obsolete_63' => 'From version 63 and onwards, Firefox has removed the ability to add your own subscription services that are not standalone programs.',	// TODO - Translation
		'title' => 'RSS čítačka vo Firefoxe',
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
		'title' => 'Import / export',
	),
	'menu' => array(
		'bookmark' => 'Odoberať (záložka FreshRSS)',
		'import_export' => 'Import / export',
		'subscription_management' => 'Správa odoberaných kanálov',
		'subscription_tools' => 'Nástroje na odoberanie kanálov',
	),
	'title' => array(
		'feed_management' => 'Správa RSS kanálov',
		'subscription_tools' => 'Nástroje na odoberanie kanálov',
		'_' => 'Správa odoberaných kanálov',
	),
);
