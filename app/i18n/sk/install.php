<?php

return array(
	'action' => array(
		'finish' => 'Dokončiť inštaláciu',
		'fix_errors_before' => 'Prosím, pred pokračovaním opravte chyby.',
		'keep_install' => 'Použiť predošlé nastavenia',
		'next_step' => 'Ďalší krok',
		'reinstall' => 'Preinštalovať FreshRSS',
	),
	'auth' => array(
		'form' => 'Webový formulár (tradičný, vyžaduje JavaScript)',
		'http' => 'HTTP (pre pokročilých používateľov s HTTPS)',
		'none' => 'Žiadny (nebezpečné)',
		'password_form' => 'Heslo<br /><small>(pre prihlásenie cez webový formulár)</small>',
		'password_format' => 'Najmenej 7 znakov',
		'type' => 'Spôsob prihlásenia',
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
		'tmp' => array(
			'nok' => 'Skontrolujte oprávnenia prístupu do priečinku <em>%s</em>. HTTP server musí mať právo doň zapisovať.',
			'ok' => 'Permissions on the temp directory are good.',	// TODO - Translation
		),
		'unknown_process_username' => 'unknown',	// TODO - Translation
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
	'default_user' => 'Hlavné používateľské meno <small>(najviac 16 alfanumerických znakov)</small>',
	'delete_articles_after' => 'Vymazať články po',
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
	'not_deleted' => 'Niečo sa nepodarilo. Musíte ručne zmazať súbor <em>%s</em>.',
	'ok' => 'Inštalácia bola úspešná.',
	'session' => array(
		'nok' => 'The web server seems to be incorrectly configured for cookies required for PHP sessions!',	// TODO - Translation
	),
	'step' => 'krok %d',
	'steps' => 'Kroky',
	'this_is_the_end' => 'Toto je koniec',
	'title' => 'Inštalácia · FreshRSS',
);
