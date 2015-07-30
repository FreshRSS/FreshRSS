<?php

return array(
	'action' => array(
		'finish' => 'Dokončit instalaci',
		'fix_errors_before' => 'Chyby prosím před přechodem na další krok opravte.',
		'keep_install' => 'Zachovat předchozí instalaci',
		'next_step' => 'Přejít na další krok',
		'reinstall' => 'Reinstalovat FreshRSS',
	),
	'auth' => array(
		'email_persona' => 'Email pro přihlášení<br /><small>(pro <a href="https://persona.org/" rel="external">Mozilla Persona</a>)</small>',
		'form' => 'Webový formulář (tradiční, vyžaduje JavaScript)',
		'http' => 'HTTP (pro pokročilé uživatele s HTTPS)',
		'none' => 'Žádný (nebezpečné)',
		'password_form' => 'Heslo<br /><small>(pro přihlášení webovým formulářem)</small>',
		'password_format' => 'Alespoň 7 znaků',
		'persona' => 'Mozilla Persona (moderní, vyžaduje JavaScript)',
		'type' => 'Způsob přihlášení',
	),
	'bdd' => array(
		'_' => 'Databáze',
		'conf' => array(
			'_' => 'Nastavení databáze',
			'ko' => 'Ověřte informace o databázi.',
			'ok' => 'Nastavení databáze bylo uloženo.',
		),
		'host' => 'Hostitel',
		'prefix' => 'Prefix tabulky',
		'password' => 'Heslo',
		'type' => 'Typ databáze',
		'username' => 'Uživatel',
	),
	'check' => array(
		'_' => 'Kontrola',
		'already_installed' => 'Zjistili jsme, že FreshRSS je již nainstalován!',
		'cache' => array(
			'nok' => 'Zkontrolujte oprávnění adresáře <em>./data/cache</em>. HTTP server musí mít do tohoto adresáře práva zápisu',
			'ok' => 'Oprávnění adresáře cache jsou v pořádku.',
		),
		'ctype' => array(
			'nok' => 'Není nainstalována požadovaná knihovna pro ověřování znaků (php-ctype).',
			'ok' => 'Je nainstalována požadovaná knihovna pro ověřování znaků (ctype).',
		),
		'curl' => array(
			'nok' => 'Nemáte cURL (balíček php5-curl).',
			'ok' => 'Máte rozšíření cURL.',
		),
		'data' => array(
		'nok' => 'Zkontrolujte oprávnění adresáře <em>./data</em>. HTTP server musí mít do tohoto adresáře práva zápisu',
			'ok' => 'Oprávnění adresáře data jsou v pořádku.',
		),
		'dom' => array(
			'nok' => 'Nemáte požadovanou knihovnu pro procházení DOM (balíček php-xml).',
			'ok' => 'Máte požadovanou knihovnu pro procházení DOM.',
		),
		'favicons' => array(
			'nok' => 'Zkontrolujte oprávnění adresáře <em>./data/favicons</em>. HTTP server musí mít do tohoto adresáře práva zápisu',
			'ok' => 'Oprávnění adresáře favicons jsou v pořádku.',
		),
		'http_referer' => array(
			'nok' => 'Zkontrolujte prosím že neměníte HTTP REFERER.',
			'ok' => 'Váš HTTP REFERER je znám a odpovídá Vašemu serveru.',
		),
		'minz' => array(
			'nok' => 'Nemáte framework Minz.',
			'ok' => 'Máte framework Minz.',
		),
		'pcre' => array(
			'nok' => 'Nemáte požadovanou knihovnu pro regulární výrazy (php-pcre).',
			'ok' => 'Máte požadovanou knihovnu pro regulární výrazy (PCRE).',
		),
		'pdo' => array(
			'nok' => 'Nemáte PDO nebo některý z podporovaných ovladačů (pdo_mysql, pdo_sqlite).',
			'ok' => 'Máte PDO a alespoň jeden z podporovaných ovladačů (pdo_mysql, pdo_sqlite).',
		),
		'persona' => array(
			'nok' => 'Zkontrolujte oprávnění adresáře <em>./data/persona</em>. HTTP server musí mít do tohoto adresáře práva zápisu',
			'ok' => 'Oprávnění adresáře Mozilla Persona jsou v pořádku.',
		),
		'php' => array(
			'nok' => 'Vaše verze PHP je %s, ale FreshRSS vyžaduje alespoň verzi %s.',
			'ok' => 'Vaše verze PHP je %s a je kompatibilní s FreshRSS.',
		),
		'users' => array(
			'nok' => 'Zkontrolujte oprávnění adresáře <em>./data/users</em>. HTTP server musí mít do tohoto adresáře práva zápisu',
			'ok' => 'Oprávnění adresáře users jsou v pořádku.',
		),
	),
	'conf' => array(
		'_' => 'Obecná nastavení',
		'ok' => 'Nastavení bylo uloženo.',
	),
	'congratulations' => 'Gratulujeme!',
	'default_user' => 'Jméno výchozího uživatele <small>(maximálně 16 alfanumerických znaků)</small>',
	'delete_articles_after' => 'Smazat články starší než',
	'fix_errors_before' => 'Chyby prosím před přechodem na další krok opravte.',
	'javascript_is_better' => 'Práce s FreshRSS je příjemnější se zapnutým JavaScriptem',
	'js' => array(
		'confirm_reinstall' => 'Reinstalací FreshRSS ztratíte předchozí konfiguraci. Opravdu chcete pokračovat?',
	),
	'language' => array(
		'_' => 'Jazyk',
		'choose' => 'Vyberte jazyk FreshRSS',
		'defined' => 'Jazyk byl nastaven.',
	),
	'not_deleted' => 'Nastala chyba, soubor <em>%s</em> musíte smazat ručně.',
	'ok' => 'Instalace byla úspěšná.',
	'step' => 'krok %d',
	'steps' => 'Kroky',
	'title' => 'Instalace · FreshRSS',
	'this_is_the_end' => 'Konec',
);
