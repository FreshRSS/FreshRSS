<?php

return array(
	'auth' => array(
		'allow_anonymous' => 'Umožnit anonymně číst články výchozího uživatele (%s)',
		'allow_anonymous_refresh' => 'Umožnit anonymní obnovení článků',
		'api_enabled' => 'Povolit přístup k <abbr>API</abbr> <small>(vyžadováno mobilními aplikacemi)</small>',
		'form' => 'Webový formulář (tradiční, vyžaduje JavaScript)',
		'http' => 'HTTP (pro pokročilé uživatele s HTTPS)',
		'none' => 'Žádný (nebezpečné)',
		'persona' => 'Mozilla Persona (moderní, vyžaduje JavaScript)',
		'title' => 'Přihlášení',
		'title_reset' => 'Reset přihlášení',
		'token' => 'Authentizační token',
		'token_help' => 'Umožňuje přístup k RSS kanálu článků výchozího uživatele bez přihlášení:',
		'type' => 'Způsob přihlášení',
		'unsafe_autologin' => 'Povolit nebezpečné automatické přihlášení přes: ',
	),
	'check_install' => array(
		'cache' => array(
			'nok' => 'Zkontrolujte oprávnění adresáře <em>./data/cache</em>. HTTP server musí mít do tohoto adresáře práva zápisu',
			'ok' => 'Oprávnění adresáře cache jsou v pořádku.',
		),
		'categories' => array(
			'nok' => 'Tabulka kategorií je nastavena špatně.',
			'ok' => 'Tabulka kategorií je v pořádku.',
		),
		'connection' => array(
			'nok' => 'Nelze navázat spojení s databází.',
			'ok' => 'Připojení k databázi je v pořádku.',
		),
		'ctype' => array(
			'nok' => 'Nemáte požadovanou knihovnu pro ověřování znaků (php-ctype).',
			'ok' => 'Máte požadovanou knihovnu pro ověřování znaků (ctype).',
		),
		'curl' => array(
			'nok' => 'Nemáte cURL (balíček php5-curl).',
			'ok' => 'Máte rozšíření cURL.',
		),
		'data' => array(
			'nok' => 'Zkontrolujte oprávnění adresáře <em>./data</em>. HTTP server musí mít do tohoto adresáře práva zápisu',
			'ok' => 'Oprávnění adresáře data jsou v pořádku.',
		),
		'database' => 'Instalace databáze',
		'dom' => array(
			'nok' => 'Nemáte požadovanou knihovnu pro procházení DOM (balíček php-xml).',
			'ok' => 'Máte požadovanou knihovnu pro procházení DOM.',
		),
		'entries' => array(
			'nok' => 'Tabulka článků je nastavena špatně.',
			'ok' => 'Tabulka kategorií je v pořádku.',
		),
		'favicons' => array(
			'nok' => 'Zkontrolujte oprávnění adresáře <em>./data/favicons</em>. HTTP server musí mít do tohoto adresáře práva zápisu',
			'ok' => 'Oprávnění adresáře favicons jsou v pořádku.',
		),
		'feeds' => array(
			'nok' => 'Tabulka kanálů je nastavena špatně.',
			'ok' => 'Tabulka kanálů je v pořádku.',
		),
		'files' => 'Instalace souborů',
		'json' => array(
			'nok' => 'Nemáte JSON (balíček php5-json).',
			'ok' => 'Máte rozšíření JSON.',
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
			'_' => 'PHP instalace',
			'nok' => 'Vaše verze PHP je %s, ale FreshRSS vyžaduje alespoň verzi %s.',
			'ok' => 'Vaše verze PHP je %s a je kompatibilní s FreshRSS.',
		),
		'tables' => array(
			'nok' => 'V databázi chybí jedna nevo více tabulek.',
			'ok' => 'V databázi jsou všechny tabulky.',
		),
		'title' => 'Kontrola instalace',
		'tokens' => array(
			'nok' => 'Zkontrolujte oprávnění adresáře <em>./data/tokens</em>. HTTP server musí mít do tohoto adresáře práva zápisu',
			'ok' => 'Oprávnění adresáře tokens jsou v pořádku.',
		),
		'users' => array(
			'nok' => 'Zkontrolujte oprávnění adresáře <em>./data/users</em>. HTTP server musí mít do tohoto adresáře práva zápisu',
			'ok' => 'Oprávnění adresáře users jsou v pořádku.',
		),
		'zip' => array(
			'nok' => 'Nemáte rozšíření ZIP (balíček php5-zip).',
			'ok' => 'Máte rozšíření ZIP.',
		),
	),
	'extensions' => array(
		'disabled' => 'Vypnuto',
		'empty_list' => 'Není naistalováno žádné rozšíření',
		'enabled' => 'Zapnuto',
		'no_configure_view' => 'Toto rozšíření nemá žádné možnosti nastavení.',
		'system' => array(
			'_' => 'Systémová rozšíření',
			'no_rights' => 'Systémová rozšíření (na ně nemáte oprávnění)',
		),
		'title' => 'Rozšíření',
		'user' => 'Uživatelská rozšíření',
	),
	'stats' => array(
		'_' => 'Statistika',
		'all_feeds' => 'Všechny kanály',
		'category' => 'Kategorie',
		'entry_count' => 'Počet článků',
		'entry_per_category' => 'Článků na kategorii',
		'entry_per_day' => 'Článků za den (posledních 30 dní)',
		'entry_per_day_of_week' => 'Za den v týdnu (průměr: %.2f zprávy)',
		'entry_per_hour' => 'Za hodinu (průměr: %.2f zprávy)',
		'entry_per_month' => 'Za měsíc (průměr: %.2f zprávy)',
		'entry_repartition' => 'Rozdělení článků',
		'feed' => 'Kanál',
		'feed_per_category' => 'Článků na kategorii',
		'idle' => 'Neaktivní kanály',
		'main' => 'Přehled',
		'main_stream' => 'Všechny kanály',
		'menu' => array(
			'idle' => 'Neaktivní kanály',
			'main' => 'Přehled',
			'repartition' => 'Rozdělení článků',
		),
		'no_idle' => 'Žádné neaktivní kanály!',
		'number_entries' => '%d článků',
		'percent_of_total' => '%% ze všech',
		'repartition' => 'Rozdělení článků',
		'status_favorites' => 'Oblíbené',
		'status_read' => 'Přečtené',
		'status_total' => 'Celkem',
		'status_unread' => 'Nepřečtené',
		'title' => 'Statistika',
		'top_feed' => 'Top ten kanálů',
	),
	'system' => array(
		'_' => 'System configuration', // @todo translate
		'auto-update-url' => 'Auto-update server URL', // @todo translate
		'instance-name' => 'Instance name', // @todo translate
		'max-categories' => 'Categories per user limit', // @todo translate
		'max-feeds' => 'Feeds per user limit', // @todo translate
		'registration' => array(
			'help' => '0 znamená žádná omezení účtu',
			'number' => 'Maximální počet účtů',
		),
	),
	'update' => array(
		'_' => 'Aktualizace systému',
		'apply' => 'Použít',
		'check' => 'Zkontrolovat aktualizace',
		'current_version' => 'Vaše instalace FreshRSS je verze %s.',
		'last' => 'Poslední kontrola: %s',
		'none' => 'Žádné nové aktualizace',
		'title' => 'Aktualizovat systém',
	),
	'user' => array(
		'articles_and_size' => '%s článků (%s)',
		'create' => 'Vytvořit nového uživatele',
		'email_persona' => 'Email pro přihlášení<br /><small>(pro <a href="https://persona.org/" rel="external">Mozilla Persona</a>)</small>',
		'language' => 'Jazyk',
		'number' => 'Zatím je vytvořen %d účet',
		'numbers' => 'Zatím je vytvořeno %d účtů',
		'password_form' => 'Heslo<br /><small>(pro přihlášení webovým formulářem)</small>',
		'password_format' => 'Alespoň 7 znaků',
		'title' => 'Správa uživatelů',
		'user_list' => 'Seznam uživatelů',
		'username' => 'Přihlašovací jméno',
		'users' => 'Uživatelé',
	),
);
