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
	'auth' => [
		'allow_anonymous' => 'Povolit anonymní čtení článků výchozího uživatele (%s)',
		'allow_anonymous_refresh' => 'Povolit anonymní obnovení článků',
		'api_enabled' => 'Povolit přístup k <abbr>API</abbr> <small>(vyžadováno pro mobilní aplikace)</small>',
		'form' => 'Webový formulář (tradiční, vyžaduje JavaScript)',
		'http' => 'HTTP (pro pokročilé uživatele s HTTPS)',
		'none' => 'Žádný (nebezpečné)',
		'title' => 'Ověřování',
		'token' => 'Master authentication token',	// TODO
		'token_help' => 'Allows access to all RSS outputs of the user as well as refreshing feeds without authentication:',	// TODO
		'type' => 'Metoda ověřování',
		'unsafe_autologin' => 'Povolit nebezpečné automatické přihlášení pomocí formátu: ',
	],
	'check_install' => [
		'cache' => [
			'nok' => 'Zkontrolujte oprávnění adresáře <em>./data/cache</em>. Server HTTP musí mít oprávnění pro zápis.',
			'ok' => 'Oprávnění adresáře cache jsou v pořádku.',
		],
		'categories' => [
			'nok' => 'Tabulka kategorií je nastavena špatně.',
			'ok' => 'Tabulka kategorií je v pořádku.',
		],
		'connection' => [
			'nok' => 'Nelze navázat spojení s databází.',
			'ok' => 'Spojení s databází je v pořádku.',
		],
		'ctype' => [
			'nok' => 'Nelze nalézt požadovanou knihovnu pro ověřování typu znaků (php-ctype).',
			'ok' => 'Máte požadovanou knihovnu pro ověřování typu znaků (ctype).',
		],
		'curl' => [
			'nok' => 'Nelze nalézt knihovnu cURL (balíček php-curl).',
			'ok' => 'Máte knihovnu cURL.',
		],
		'data' => [
			'nok' => 'Zkontrolujte oprávnění adresáře <em>./data</em>. Server HTTP musí mít oprávnění pro zápis.',
			'ok' => 'Oprávnění adresáře data jsou v pořádku.',
		],
		'database' => 'Instalace databáze',
		'dom' => [
			'nok' => 'Nelze nalézt požadovanou knihovnu pro procházení DOM (balíček php-xml).',
			'ok' => 'Máte požadovanou knihovnu pro procházení DOM.',
		],
		'entries' => [
			'nok' => 'Tabulka položek je nastavena špatně.',
			'ok' => 'Tabulka položek je v pořádku.',
		],
		'favicons' => [
			'nok' => 'Zkontrolujte oprávnění adresáře <em>./data/favicons</em>. Server HTTP musí mít oprávnění pro zápis.',
			'ok' => 'Oprávnění adresáře favicons jsou v pořádku.',
		],
		'feeds' => [
			'nok' => 'Tabulka kanálů je nastavena špatně.',
			'ok' => 'Tabulka kanálů je v pořádku.',
		],
		'fileinfo' => [
			'nok' => 'Nelze nalézt knihovnu PHP fileinfo (balíček fileinfo).',
			'ok' => 'Máte knihovnu fileinfo.',
		],
		'files' => 'Instalace souborů',
		'json' => [
			'nok' => 'Nelze nalézt JSON (balíček php-json).',
			'ok' => 'Máte rozšíření JSON.',
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
			'_' => 'Instalace PHP',
			'nok' => 'Vaše verze PHP je %s, ale FreshRSS vyžaduje alespoň verzi %s.',
			'ok' => 'Vaše verze PHP je %s a je kompatibilní s FreshRSS.',
		],
		'tables' => [
			'nok' => 'V databázi chybí jedna nevo více tabulek.',
			'ok' => 'V databázi jsou všechny tabulky.',
		],
		'title' => 'Kontrola instalace',
		'tokens' => [
			'nok' => 'Zkontrolujte oprávnění adresáře <em>./data/tokens</em>. Server HTTP musí mít oprávnění pro zápis.',
			'ok' => 'Oprávnění adresáře tokens jsou v pořádku.',
		],
		'users' => [
			'nok' => 'Zkontrolujte oprávnění adresáře <em>./data/users</em>. Server HTTP musí mít oprávnění pro zápis.',
			'ok' => 'Oprávnění adresáře users jsou v pořádku.',
		],
		'zip' => [
			'nok' => 'Nelze nalézt rozšíření ZIP (balíček php-zip).',
			'ok' => 'Máte rozšíření ZIP.',
		],
	],
	'extensions' => [
		'author' => 'Autor',
		'community' => 'Dostupná komunitní rozšíření',
		'description' => 'Popis',
		'disabled' => 'Zakázáno',
		'empty_list' => 'Nejsou naistalována žádná rozšíření',
		'enabled' => 'Povoleno',
		'latest' => 'Nainstalováno',
		'name' => 'Název',
		'no_configure_view' => 'Toto rozšíření nemá žádná nastavení.',
		'system' => [
			'_' => 'Systémová rozšíření',
			'no_rights' => 'Systémová rozšíření (nemáte požadovaná oprávnění)',
		],
		'title' => 'Rozšíření',
		'update' => 'Dostupná aktualizace',
		'user' => 'Uživatelská rozšíření',
		'version' => 'Verze',
	],
	'stats' => [
		'_' => 'Statistika',
		'all_feeds' => 'Všechny kanály',
		'category' => 'Kategorie',
		'entry_count' => 'Počet položek',
		'entry_per_category' => 'Položek na kategorii',
		'entry_per_day' => 'Položek za den (posledních 30 dní)',
		'entry_per_day_of_week' => 'Za den v týdnu (průměr: %.2f zpráv)',
		'entry_per_hour' => 'Za hodinu (průměr: %.2f zpráv)',
		'entry_per_month' => 'Za měsíc (průměr: %.2f zpráv)',
		'entry_repartition' => 'Přerozdělení položek',
		'feed' => 'Kanál',
		'feed_per_category' => 'Kanálů na kategorii',
		'idle' => 'Nečinné kanály',
		'main' => 'Hlavní statistika',
		'main_stream' => 'Všechny kanály',
		'no_idle' => 'Nejsou žádné nečinné kanály!',
		'number_entries' => '%d článků',
		'percent_of_total' => '% ze všech',
		'repartition' => 'Přerozdělení článků',
		'status_favorites' => 'Oblíbené',
		'status_read' => 'Přečtené',
		'status_total' => 'Celkem',
		'status_unread' => 'Nepřečtené',
		'title' => 'Statistika',
		'top_feed' => 'Top 10 kanálů',
	],
	'system' => [
		'_' => 'Nastavení systému',
		'auto-update-url' => 'Adresa URL serveru pro automatické aktualizace',
		'base-url' => [
			'_' => 'Base URL',	// TODO
			'recommendation' => 'Automatic recommendation: <kbd>%s</kbd>',	// TODO
		],
		'cookie-duration' => [
			'help' => 'v sekundách',
			'number' => 'Trvání ponechání přihlášení',
		],
		'force_email_validation' => 'Vynutit ověření e-mailové adresy',
		'instance-name' => 'Název instance',
		'max-categories' => 'Maximální počet kategorií na uživatele',
		'max-feeds' => 'Maximální počet kanálů na uživatele',
		'registration' => [
			'number' => 'Maximální počet účtů',
			'select' => [
				'label' => 'Registrační formulář',
				'option' => [
					'noform' => 'Zakazáno: Žádný registrační formulář',
					'nolimit' => 'Povoleno: Bez omezení počtu účtů',
					'setaccountsnumber' => 'also it can be: Nastavit maximální počet účtů',
				],
			],
			'status' => [
				'disabled' => 'Formulář zakázán',
				'enabled' => 'Formulář povolen',
			],
			'title' => 'Registrační formulář uživatele',
		],
		'sensitive-parameter' => 'Sensitive parameter. Edit manually in <kbd>./data/config.php</kbd>',	// TODO
		'tos' => [
			'disabled' => 'is not given',	// TODO
			'enabled' => '<a href="./?a=tos">is enabled</a>',	// TODO
			'help' => 'How to <a href="https://freshrss.github.io/FreshRSS/en/admins/12_User_management.html#enable-terms-of-service-tos" target="_blank">enable the Terms of Service</a>',	// TODO
		],
		'websub' => [
			'help' => 'About <a href="https://freshrss.github.io/FreshRSS/en/users/WebSub.html" target="_blank">WebSub</a>',	// TODO
		],
	],
	'update' => [
		'_' => 'Aktualizace systému',
		'apply' => 'Použít',
		'changelog' => 'Changelog',	// TODO
		'check' => 'Zkontrolovat aktualizace',
		'copiedFromURL' => 'update.php copied from %s to ./data',	// TODO
		'current_version' => 'Vaše aktuální verze',
		'last' => 'Poslední kontrola',
		'loading' => 'Updating…',	// TODO
		'none' => 'Žádné nové aktualizace',
		'releaseChannel' => [
			'_' => 'Release channel',	// TODO
			'edge' => 'Rolling release (“edge”)',	// TODO
			'latest' => 'Stable release (“latest”)',	// TODO
		],
		'title' => 'Aktualizovat systém',
		'viaGit' => 'Update via git and Github.com started',	// TODO
	],
	'user' => [
		'admin' => 'Administrátor',
		'article_count' => 'Článků',
		'back_to_manage' => '← Zpět na seznam uživatelů',
		'create' => 'Vytvořit nového uživatele',
		'database_size' => 'Velikost databáze',
		'email' => 'E-mailová adresa',
		'enabled' => 'Povolen',
		'feed_count' => 'Kanálů',
		'is_admin' => 'Je admin',
		'language' => 'Jazyk',
		'last_user_activity' => 'Poslední aktivita uživatele',
		'list' => 'Seznam uživatelů',
		'number' => 'Zatím je vytvořen %d účet',
		'numbers' => 'Zatím je vytvořeno %d účtů',
		'password_form' => 'Heslo<br /><small>(pro přihlášení webovým formulářem)</small>',
		'password_format' => 'Alespoň 7 znaků',
		'title' => 'Správa uživatelů',
		'username' => 'Uživatelské jméno',
	],
];
