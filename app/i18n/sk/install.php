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
	'action' => array(
		'finish' => 'Dokončiť inštaláciu',
		'fix_errors_before' => 'Prosím, pred pokračovaním opravte chyby.',
		'keep_install' => 'Použiť predošlé nastavenia',
		'next_step' => 'Ďalší krok',
		'reinstall' => 'Preinštalovať FreshRSS',
	),
	'bdd' => array(
		'_' => 'Databáza',
		'conf' => array(
			'_' => 'Nastavenia databázy',
			'ko' => 'Skontrolovať vaše informácie o databáze.',
			'ok' => 'Nastavenia databázy boli uložené.',
		),
		'host' => 'Server',
		'password' => 'Heslo databázy',
		'prefix' => 'Predpona názvu tabuľky',
		'type' => 'Druh databázy',
		'username' => 'Používateľské meno databázy',
	),
	'check' => array(
		'_' => 'Kontrola',
		'already_installed' => 'Zistilo sa, že FreshRSS je už nainštalovaný!',
		'cache' => array(
			'nok' => 'Skontrolujte oprávnenia prístupu do priečinku <em>%s</em>. HTTP server musí mať právo doň zapisovať.',
			'ok' => 'Oprávnenia prístupu do priečinku vyrovnávacej pamäte sú OK.',
		),
		'ctype' => array(
			'nok' => 'Nepodarilo sa nájsť požadovanú knižnicu na kontrolu typu znakov (php-ctype).',
			'ok' => 'Našla sa požadovaná knižnica na kontrolu typu znakov (ctype).',
		),
		'curl' => array(
			'nok' => 'Nepodarilo sa nájsť knižnicu cURL (balík php-curl).',
			'ok' => 'Našla sa knižnica cURL.',
		),
		'data' => array(
			'nok' => 'Skontrolujte oprávnenia prístupu do priečinku <em>%s</em>. HTTP server musí mať právo doň zapisovať.',
			'ok' => 'Oprávnenia prístupu do priečinku údajov sú OK.',
		),
		'dom' => array(
			'nok' => 'Nepodarilo sa nájsť požadovanú knižnicu na prehliadanie DOM.',
			'ok' => 'Našla sa požadovaná knižnica na prehliadanie DOM.',
		),
		'favicons' => array(
			'nok' => 'Skontrolujte oprávnenia prístupu do priečinku <em>%s</em>. HTTP server musí mať právo doň zapisovať.',
			'ok' => 'Oprávnenia prístupu do priečinku ikôn obľúbených sú OK.',
		),
		'fileinfo' => array(
			'nok' => 'Nepodarilo sa nájsť knižniuc PHP fileinfo (balík fileinfo).',
			'ok' => 'Našla sa knižnica fileinfo.',
		),
		'json' => array(
			'nok' => 'Nepodarilo sa nájsť požadovanú knižnicu na spracovanie formátu JSON.',
			'ok' => 'Našla sa požadovaná knižnica na spracovanie formátu JSON.',
		),
		'mbstring' => array(
			'nok' => 'Nepodarilo sa nájsť požadovanú knižnicu mbstring pre Unicode.',
			'ok' => 'Našla sa požadovaná knižnica mbstring pre Unicode.',
		),
		'pcre' => array(
			'nok' => 'Nepodarilo sa nájsť požadovanú knižnicu pre regulárne výrazy (php-pcre).',
			'ok' => 'Našla sa požadovaná knižnica pre regulárne výrazy (PCRE).',
		),
		'pdo' => array(
			'nok' => 'Nepodarilo sa nájsť PDO alebo niektorý z podporovaných ovládačov (pdo_mysql, pdo_sqlite, pdo_pgsql).',
			'ok' => 'Našiel sa PDO a aspoň jeden z podporovaných ovládačov (pdo_mysql, pdo_sqlite, pdo_pgsql).',
		),
		'php' => array(
			'nok' => 'Vaša verzia PHP je %s, ale FreshRSS vyžaduje minimálne verziu %s.',
			'ok' => 'Vaša verzia PHP %s je kompatibilná s FreshRSS.',
		),
		'reload' => 'Tekrar kontrol et',
		'tmp' => array(
			'nok' => 'Skontrolujte oprávnenia prístupu do priečinku <em>%s</em>. HTTP server musí mať právo doň zapisovať.',
			'ok' => 'Oprávnenia pre dočasný priečinok sú OK.',
		),
		'unknown_process_username' => 'neznámy',
		'users' => array(
			'nok' => 'Skontrolujte oprávnenia prístupu do priečinku <em>%s</em>. HTTP server musí mať právo doň zapisovať.',
			'ok' => 'Oprávnenia prístupu do priečinku používateľov sú OK.',
		),
		'xml' => array(
			'nok' => 'Nepodarilo sa nájsť požadovanú knižnicu na spracovanie formátu XML.',
			'ok' => 'Našla sa požadovaná knižnica na spracovanie formátu XML.',
		),
	),
	'conf' => array(
		'_' => 'Hlavné nastavenia',
		'ok' => 'Hlavné nastavenia boli uložené.',
	),
	'congratulations' => 'Nastavenia!',
	'default_user' => array(
		'_' => 'Hlavné používateľské meno',
		'max_char' => 'najviac 16 alfanumerických znakov',
	),
	'fix_errors_before' => 'Prosím, pred pokračovaním opravte chyby.',
	'javascript_is_better' => 'FreshRSS si užijete viac, keď povolíte JavaScript',
	'js' => array(
		'confirm_reinstall' => 'Ak budete pokračovať v preinštalovaní FreshRSS, stratíte vaše predošlé nastavenia. Naozaj chcete pokračovať?',
	),
	'language' => array(
		'_' => 'Jazyk',
		'choose' => 'Vyberte jazyk pre FreshRSS',
		'defined' => 'Jazyk bol nastavený.',
	),
	'missing_applied_migrations' => 'Niečo sa nepodarilo. Ručne vytvorte prázdny súbor <em>%s</em>.',
	'ok' => 'Inštalácia bola úspešná.',
	'session' => array(
		'nok' => 'Webový server pravdepodobne nie je správne nastavený na použitie cookies pre relácie PHP!',
	),
	'step' => 'krok %d',
	'steps' => 'Kroky',
	'this_is_the_end' => 'Toto je koniec',
	'title' => 'Inštalácia · FreshRSS',
);
