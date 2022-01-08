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
	'auth' => array(
		'allow_anonymous' => 'Umožnit anonymně číst články výchozího uživatele (%s)',
		'allow_anonymous_refresh' => 'Umožnit anonymní obnovení článků',
		'api_enabled' => 'Povolit přístup k <abbr>API</abbr> <small>(vyžadováno mobilními aplikacemi)</small>',
		'form' => 'Webový formulář (tradiční, vyžaduje JavaScript)',
		'http' => 'HTTP (pro pokročilé uživatele s HTTPS)',
		'none' => 'Žádný (nebezpečné)',
		'title' => 'Přihlášení',
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
			'nok' => 'Nemáte cURL (balíček php-curl).',
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
		'fileinfo' => array(
			'nok' => 'Nemáte PHP fileinfo (balíček fileinfo).',
			'ok' => 'Máte rozšíření fileinfo.',
		),
		'files' => 'Instalace souborů',
		'json' => array(
			'nok' => 'Nemáte JSON (balíček php-json).',
			'ok' => 'Máte rozšíření JSON.',
		),
		'mbstring' => array(
			'nok' => 'Cannot find the recommended mbstring library for Unicode.',	// TODO
			'ok' => 'You have the recommended mbstring library for Unicode.',	// TODO
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
			'nok' => 'Nemáte rozšíření ZIP (balíček php-zip).',
			'ok' => 'Máte rozšíření ZIP.',
		),
	),
	'extensions' => array(
		'author' => 'Author',	// TODO
		'community' => 'Available community extensions',	// TODO
		'description' => 'Description',	// TODO
		'disabled' => 'Vypnuto',
		'empty_list' => 'Není naistalováno žádné rozšíření',
		'enabled' => 'Zapnuto',
		'latest' => 'Installed',	// TODO
		'name' => 'Name',	// TODO
		'no_configure_view' => 'Toto rozšíření nemá žádné možnosti nastavení.',
		'system' => array(
			'_' => 'Systémová rozšíření',
			'no_rights' => 'Systémová rozšíření (na ně nemáte oprávnění)',
		),
		'title' => 'Rozšíření',
		'update' => 'Update available',	// TODO
		'user' => 'Uživatelská rozšíření',
		'version' => 'Version',	// TODO
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
		'_' => 'System configuration',	// TODO
		'auto-update-url' => 'Auto-update server URL',	// TODO
		'cookie-duration' => array(
			'help' => 'in seconds',	// TODO
			'number' => 'Duration to keep logged in',	// TODO
		),
		'force_email_validation' => 'Force email address validation',	// TODO
		'instance-name' => 'Instance name',	// TODO
		'max-categories' => 'Max number of categories per user',	// TODO
		'max-feeds' => 'Max number of feeds per user',	// TODO
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
		'admin' => 'Administrator',	// TODO
		'article_count' => 'Articles',	// TODO
		'back_to_manage' => '← Return to user list',	// TODO
		'create' => 'Vytvořit nového uživatele',
		'database_size' => 'Database size',	// TODO
		'email' => 'Email address',	// TODO
		'enabled' => 'Enabled',	// TODO
		'feed_count' => 'Feeds',	// TODO
		'is_admin' => 'Is admin',	// TODO
		'language' => 'Jazyk',
		'last_user_activity' => 'Last user activity',	// TODO
		'list' => 'User list',	// TODO
		'number' => 'Zatím je vytvořen %d účet',
		'numbers' => 'Zatím je vytvořeno %d účtů',
		'password_form' => 'Heslo<br /><small>(pro přihlášení webovým formulářem)</small>',
		'password_format' => 'Alespoň 7 znaků',
		'title' => 'Správa uživatelů',
		'username' => 'Přihlašovací jméno',
	),
);
