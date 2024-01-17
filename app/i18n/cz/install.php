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

return [
	'action' => [
		'finish' => 'Dokončit instalaci',
		'fix_errors_before' => 'Opravte prosím všechny chyby před přechodem na další krok.',
		'keep_install' => 'Zachovat předchozí nastavení',
		'next_step' => 'Přejít na další krok',
		'reinstall' => 'Přeinstalovat FreshRSS',
	],
	'auth' => [
		'form' => 'Webový formulář (tradiční, vyžaduje JavaScript)',
		'http' => 'HTTP (pro pokročilé uživatele s HTTPS)',
		'none' => 'Žádný (nebezpečné)',
		'password_form' => 'Heslo<br /><small>(pro přihlášení webovým formulářem)</small>',
		'password_format' => 'Alespoň 7 znaků',
		'type' => 'Metoda ověřování',
	],
	'bdd' => [
		'_' => 'Databáze',
		'conf' => [
			'_' => 'Nastavení databáze',
			'ko' => 'Ověřte nastavení své databáze.',
			'ok' => 'Nastavení databáze bylo uloženo.',
		],
		'host' => 'Hostitel',
		'password' => 'Heslo databáze',
		'prefix' => 'Předpona tabulek',
		'type' => 'Typ databáze',
		'username' => 'Uživatel databáze',
	],
	'check' => [
		'_' => 'Kontrola',
		'already_installed' => 'Zjistili jsme, že FreshRSS je již nainstalováno!',
		'cache' => [
			'nok' => 'Zkontrolujte oprávnění adresáře <em>%s</em>. Server HTTP musí mít oprávnění pro zápis.',
			'ok' => 'Oprávnění adresáře cache jsou v pořádku.',
		],
		'ctype' => [
			'nok' => 'Nelze nalézt požadovanou knihovnu pro kontrolu typu znaků (php-ctype).',
			'ok' => 'Máte požadovanou knihovnu pro kontrolu typu znaků (ctype).',
		],
		'curl' => [
			'nok' => 'Nelze nalézt knihovnu cURL (balíček php-curl).',
			'ok' => 'Máte knihovnu cURL.',
		],
		'data' => [
			'nok' => 'Zkontrolujte oprávnění adresáře <em>%1$s</em> pro uživatele <em>%2$s</em>. Server HTTP musí mít oprávnění pro zápis.',
			'ok' => 'Oprávnění adresáře data jsou v pořádku.',
		],
		'dom' => [
			'nok' => 'Nelze nalézt požadovanou knihovnu pro procházení DOM.',
			'ok' => 'Máte požadovanou knihovnu pro procházení DOM.',
		],
		'favicons' => [
			'nok' => 'Zkontrolujte oprávnění adresáře <em>%1$s</em> pro uživatele <em>%2$s</em>. Server HTTP musí mít oprávnění pro zápis.',
			'ok' => 'Oprávnění adresáře favicons jsou v pořádku.',
		],
		'fileinfo' => [
			'nok' => 'Nelze nalézt knihovnu PHP fileinfo (balíček fileinfo).',
			'ok' => 'Máte knihovnu fileinfo.',
		],
		'json' => [
			'nok' => 'Nelze nalézt doporučenou knihovnu pro analýzu JSON.',
			'ok' => 'Máte doporučenou knihovnu pro analýzu JSON.',
		],
		'mbstring' => [
			'nok' => 'Nelze nalézt doporučenou knihovnu mbstring pro Unicode.',
			'ok' => 'Máte doporučenou knihovnu mbstring pro Unicode.',
		],
		'pcre' => [
			'nok' => 'Nelze nalézt požadovanou knihovnu pro regulární výrazy (php-pcre).',
			'ok' => 'Máte požadovanou knihovnu pro regulární výrazy (PCRE).',
		],
		'pdo' => [
			'nok' => 'Nelze nalézt PDO nebo některý z podporovaných ovladačů (pdo_mysql, pdo_sqlite, pdo_pgsql).',
			'ok' => 'Máte PDO a alespoň jeden z podporovaných ovladačů (pdo_mysql, pdo_sqlite, pdo_pgsql).',
		],
		'php' => [
			'nok' => 'Vaše verze PHP je %s, ale FreshRSS vyžaduje alespoň verzi %s.',
			'ok' => 'Vaše verze PHP %s je kompatibilní s FreshRSS.',
		],
		'reload' => 'Znovu zkontrolujte',
		'tmp' => [
			'nok' => 'Zkontrolujte oprávnění adresáře <em>%1$s</em> pro uživatele <em>%2$s</em>. Server HTTP musí mít oprávnění pro zápis.',
			'ok' => 'Oprávnění adresáře temp jsou v pořádku.',
		],
		'unknown_process_username' => 'neznámý',
		'users' => [
			'nok' => 'Zkontrolujte oprávnění adresáře <em>%1$s</em> pro uživatele <em>%2$s</em>. Server HTTP musí mít oprávnění pro zápis.',
			'ok' => 'Oprávnění adresáře users jsou v pořádku.',
		],
		'xml' => [
			'nok' => 'Nelze nalézt požadovanou knihovnu pro analýzu XML.',
			'ok' => 'Máte požadovanou knihovnu pro analýzu XML.',
		],
	],
	'conf' => [
		'_' => 'Obecná nastavení',
		'ok' => 'Obecná nastavení byla uložena.',
	],
	'congratulations' => 'Gratulujeme!',
	'default_user' => [
		'_' => 'Uživatelské jméno výchozího uživatele',
		'max_char' => 'maximálně 16 alfanumerických znaků',
	],
	'fix_errors_before' => 'Opravte prosím všechny chyby před přechodem na další krok.',
	'javascript_is_better' => 'Práce s FreshRSS je příjemnější se zapnutým JavaScript',
	'js' => [
		'confirm_reinstall' => 'Přeinstalací FreshRSS ztratíte předchozí nastavení. Opravdu chcete pokračovat?',
	],
	'language' => [
		'_' => 'Jazyk',
		'choose' => 'Zvolte jazyk pro FreshRSS',
		'defined' => 'Jazyk byl nastaven.',
	],
	'missing_applied_migrations' => 'Něco se pokazilo; měli byste vytvořit prázdný soubor <em>%s</em> ručně.',
	'ok' => 'Instalace byla úspěšná.',
	'session' => [
		'nok' => 'Webový server se zdá být nesprávně nastavený pro cookies vyžadované pro relace PHP!',
	],
	'step' => '%d. krok',
	'steps' => 'Kroky',
	'this_is_the_end' => 'Toto je konec',
	'title' => 'Instalace · FreshRSS',
];
