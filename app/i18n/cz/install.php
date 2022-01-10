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
		'finish' => 'Dokončit instalaci',
		'fix_errors_before' => 'Chyby prosím před přechodem na další krok opravte.',
		'keep_install' => 'Zachovat předchozí instalaci',
		'next_step' => 'Přejít na další krok',
		'reinstall' => 'Reinstalovat FreshRSS',
	),
	'auth' => array(
		'form' => 'Webový formulář (tradiční, vyžaduje JavaScript)',
		'http' => 'HTTP (pro pokročilé uživatele s HTTPS)',
		'none' => 'Žádný (nebezpečné)',
		'password_form' => 'Heslo<br /><small>(pro přihlášení webovým formulářem)</small>',
		'password_format' => 'Alespoň 7 znaků',
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
		'password' => 'Heslo',
		'prefix' => 'Prefix tabulky',
		'type' => 'Typ databáze',
		'username' => 'Uživatel',
	),
	'check' => array(
		'_' => 'Kontrola',
		'already_installed' => 'Zjistili jsme, že FreshRSS je již nainstalován!',
		'cache' => array(
			'nok' => 'Zkontrolujte oprávnění adresáře <em>%s</em>. HTTP server musí mít do tohoto adresáře práva zápisu.',
			'ok' => 'Oprávnění adresáře cache jsou v pořádku.',
		),
		'ctype' => array(
			'nok' => 'Není nainstalována požadovaná knihovna pro ověřování znaků (php-ctype).',
			'ok' => 'Je nainstalována požadovaná knihovna pro ověřování znaků (ctype).',
		),
		'curl' => array(
			'nok' => 'Nemáte cURL (balíček php-curl).',
			'ok' => 'Máte rozšíření cURL.',
		),
		'data' => array(
			'nok' => 'Zkontrolujte oprávnění adresáře <em>%s</em>. HTTP server musí mít do tohoto adresáře práva zápisu.',
			'ok' => 'Oprávnění adresáře data jsou v pořádku.',
		),
		'dom' => array(
			'nok' => 'Nemáte požadovanou knihovnu pro procházení DOM.',
			'ok' => 'Máte požadovanou knihovnu pro procházení DOM.',
		),
		'favicons' => array(
			'nok' => 'Zkontrolujte oprávnění adresáře <em>%s</em>. HTTP server musí mít do tohoto adresáře práva zápisu.',
			'ok' => 'Oprávnění adresáře favicons jsou v pořádku.',
		),
		'fileinfo' => array(
			'nok' => 'Nemáte PHP fileinfo (balíček fileinfo).',
			'ok' => 'Máte rozšíření fileinfo.',
		),
		'json' => array(
			'nok' => 'Pro parsování JSON chybí doporučená knihovna.',
			'ok' => 'Máte doporučenou knihovnu pro parsování JSON.',
		),
		'mbstring' => array(
			'nok' => 'Cannot find the recommended library mbstring for Unicode.',	// TODO
			'ok' => 'You have the recommended library mbstring for Unicode.',	// TODO
		),
		'pcre' => array(
			'nok' => 'Nemáte požadovanou knihovnu pro regulární výrazy (php-pcre).',
			'ok' => 'Máte požadovanou knihovnu pro regulární výrazy (PCRE).',
		),
		'pdo' => array(
			'nok' => 'Nemáte PDO nebo některý z podporovaných ovladačů (pdo_mysql, pdo_sqlite, pdo_pgsql).',
			'ok' => 'Máte PDO a alespoň jeden z podporovaných ovladačů (pdo_mysql, pdo_sqlite, pdo_pgsql).',
		),
		'php' => array(
			'nok' => 'Vaše verze PHP je %s, ale FreshRSS vyžaduje alespoň verzi %s.',
			'ok' => 'Vaše verze PHP je %s a je kompatibilní s FreshRSS.',
		),
		'reload' => 'Check again',	// TODO
		'tmp' => array(
			'nok' => 'Zkontrolujte oprávnění adresáře <em>%s</em>. HTTP server musí mít do tohoto adresáře práva zápisu.',
			'ok' => 'Permissions on the temp directory are good.',	// TODO
		),
		'unknown_process_username' => 'unknown',	// TODO
		'users' => array(
			'nok' => 'Zkontrolujte oprávnění adresáře <em>%s</em>. HTTP server musí mít do tohoto adresáře práva zápisu.',
			'ok' => 'Oprávnění adresáře users jsou v pořádku.',
		),
		'xml' => array(
			'nok' => 'Pro parsování XML chybí požadovaná knihovna.',
			'ok' => 'Máte požadovanou knihovnu pro parsování XML.',
		),
	),
	'conf' => array(
		'_' => 'Obecná nastavení',
		'ok' => 'Nastavení bylo uloženo.',
	),
	'congratulations' => 'Gratulujeme!',
	'default_user' => 'Jméno výchozího uživatele <small>(maximálně 16 alfanumerických znaků)</small>',
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
	'missing_applied_migrations' => 'Something went wrong; you should create an empty file <em>%s</em> manually.',	// TODO
	'ok' => 'Instalace byla úspěšná.',
	'session' => array(
		'nok' => 'The web server seems to be incorrectly configured for cookies required for PHP sessions!',	// TODO
	),
	'step' => 'krok %d',
	'steps' => 'Kroky',
	'this_is_the_end' => 'Konec',
	'title' => 'Instalace · FreshRSS',
);
