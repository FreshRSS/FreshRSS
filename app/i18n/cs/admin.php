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
		'allow_anonymous' => 'Povolit anonymní čtení článků výchozího uživatele (%s)',
		'allow_anonymous_refresh' => 'Povolit anonymní obnovení článků',
		'api_enabled' => 'Povolit přístup k <abbr>API</abbr> <small>(vyžadováno pro mobilní aplikace and sharing user queries)</small>',	// DIRTY
		'form' => 'Webový formulář (tradiční, vyžaduje JavaScript)',
		'http' => 'HTTP (advanced: managed by Web server, OIDC, SSO…)',	// TODO
		'none' => 'Žádný (nebezpečné)',
		'title' => 'Ověřování',
		'token' => 'Hlavní ověřovací token',
		'token_help' => 'Umožňuje přístup ke všem výstupům RSS uživatele i obnovování kanálů bez ověřování:',
		'type' => 'Metoda ověřování',
		'unsafe_autologin' => 'Povolit nebezpečné automatické přihlášení pomocí formátu: ',
	),
	'check_install' => array(
		'cache' => array(
			'nok' => 'Zkontrolujte oprávnění adresáře <em>./data/cache</em>. Server HTTP musí mít oprávnění pro zápis.',
			'ok' => 'Oprávnění adresáře cache jsou v pořádku.',
		),
		'categories' => array(
			'nok' => 'Tabulka kategorií je nastavena špatně.',
			'ok' => 'Tabulka kategorií je v pořádku.',
		),
		'connection' => array(
			'nok' => 'Nelze navázat spojení s databází.',
			'ok' => 'Spojení s databází je v pořádku.',
		),
		'ctype' => array(
			'nok' => 'Nelze nalézt požadovanou knihovnu pro ověřování typu znaků (php-ctype).',
			'ok' => 'Máte požadovanou knihovnu pro ověřování typu znaků (ctype).',
		),
		'curl' => array(
			'nok' => 'Nelze nalézt knihovnu cURL (balíček php-curl).',
			'ok' => 'Máte knihovnu cURL.',
		),
		'data' => array(
			'nok' => 'Zkontrolujte oprávnění adresáře <em>./data</em>. Server HTTP musí mít oprávnění pro zápis.',
			'ok' => 'Oprávnění adresáře data jsou v pořádku.',
		),
		'database' => 'Instalace databáze',
		'dom' => array(
			'nok' => 'Nelze nalézt požadovanou knihovnu pro procházení DOM (balíček php-xml).',
			'ok' => 'Máte požadovanou knihovnu pro procházení DOM.',
		),
		'entries' => array(
			'nok' => 'Tabulka položek je nastavena špatně.',
			'ok' => 'Tabulka položek je v pořádku.',
		),
		'favicons' => array(
			'nok' => 'Zkontrolujte oprávnění adresáře <em>./data/favicons</em>. Server HTTP musí mít oprávnění pro zápis.',
			'ok' => 'Oprávnění adresáře favicons jsou v pořádku.',
		),
		'feeds' => array(
			'nok' => 'Tabulka kanálů je nastavena špatně.',
			'ok' => 'Tabulka kanálů je v pořádku.',
		),
		'fileinfo' => array(
			'nok' => 'Nelze nalézt knihovnu PHP fileinfo (balíček fileinfo).',
			'ok' => 'Máte knihovnu fileinfo.',
		),
		'files' => 'Instalace souborů',
		'json' => array(
			'nok' => 'Nelze nalézt JSON (balíček php-json).',
			'ok' => 'Máte rozšíření JSON.',
		),
		'mbstring' => array(
			'nok' => 'Nelze nalézt doporučenou knihovnu mbstring pro Unicode.',
			'ok' => 'Máte doporučenou knihovnu mbstring pro Unicode.',
		),
		'pcre' => array(
			'nok' => 'Nelze nalézt požadovanou knihovnu pro regulární výrazy (php-pcre).',
			'ok' => 'Máte požadovanou knihovnu pro regulární výrazy (PCRE).',
		),
		'pdo' => array(
			'nok' => 'Nelze nalézt PDO nebo některý z podporovaných ovladačů (pdo_mysql, pdo_sqlite, pdo_pgsql).',
			'ok' => 'Máte PDO a alespoň jeden z podporovaných ovladačů (pdo_mysql, pdo_sqlite, pdo_pgsql).',
		),
		'php' => array(
			'_' => 'Instalace PHP',
			'nok' => 'Vaše verze PHP je %s, ale FreshRSS vyžaduje alespoň verzi %s.',
			'ok' => 'Vaše verze PHP je %s a je kompatibilní s FreshRSS.',
		),
		'tables' => array(
			'nok' => 'V databázi chybí jedna nevo více tabulek.',
			'ok' => 'V databázi jsou všechny tabulky.',
		),
		'title' => 'Kontrola instalace',
		'tokens' => array(
			'nok' => 'Zkontrolujte oprávnění adresáře <em>./data/tokens</em>. Server HTTP musí mít oprávnění pro zápis.',
			'ok' => 'Oprávnění adresáře tokens jsou v pořádku.',
		),
		'users' => array(
			'nok' => 'Zkontrolujte oprávnění adresáře <em>./data/users</em>. Server HTTP musí mít oprávnění pro zápis.',
			'ok' => 'Oprávnění adresáře users jsou v pořádku.',
		),
		'zip' => array(
			'nok' => 'Nelze nalézt rozšíření ZIP (balíček php-zip).',
			'ok' => 'Máte rozšíření ZIP.',
		),
	),
	'extensions' => array(
		'author' => 'Autor',
		'community' => 'Dostupná komunitní rozšíření',
		'description' => 'Popis',
		'disabled' => 'Zakázáno',
		'empty_list' => 'Nejsou naistalována žádná rozšíření',
		'empty_list_help' => 'Check the logs to determine the reason behind the empty extension list.',	// TODO
		'enabled' => 'Povoleno',
		'latest' => 'Nainstalováno',
		'name' => 'Název',
		'no_configure_view' => 'Toto rozšíření nemá žádná nastavení.',
		'system' => array(
			'_' => 'Systémová rozšíření',
			'no_rights' => 'Systémová rozšíření (nemáte požadovaná oprávnění)',
		),
		'title' => 'Rozšíření',
		'update' => 'Dostupná aktualizace',
		'user' => 'Uživatelská rozšíření',
		'version' => 'Verze',
	),
	'stats' => array(
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
		'overview' => 'Overview',	// TODO
		'percent_of_total' => '% ze všech',
		'repartition' => 'Přerozdělení článků: %s',
		'status_favorites' => 'Oblíbené',
		'status_read' => 'Přečtené',
		'status_total' => 'Celkem',
		'status_unread' => 'Nepřečtené',
		'title' => 'Statistika',
		'top_feed' => 'Top 10 kanálů',
	),
	'system' => array(
		'_' => 'Nastavení systému',
		'auto-update-url' => 'Adresa URL serveru pro automatické aktualizace',
		'base-url' => array(
			'_' => 'Základní adresa URL',
			'recommendation' => 'Automatické doporučení: <kbd>%s</kbd>',
		),
		'cookie-duration' => array(
			'help' => 'v sekundách',
			'number' => 'Trvání ponechání přihlášení',
		),
		'force_email_validation' => 'Vynutit ověření e-mailové adresy',
		'instance-name' => 'Název instance',
		'max-categories' => 'Maximální počet kategorií na uživatele',
		'max-feeds' => 'Maximální počet kanálů na uživatele',
		'registration' => array(
			'number' => 'Maximální počet účtů',
			'select' => array(
				'label' => 'Registrační formulář',
				'option' => array(
					'noform' => 'Zakazáno: Žádný registrační formulář',
					'nolimit' => 'Povoleno: Bez omezení počtu účtů',
					'setaccountsnumber' => 'also it can be: Nastavit maximální počet účtů',
				),
			),
			'status' => array(
				'disabled' => 'Formulář zakázán',
				'enabled' => 'Formulář povolen',
			),
			'title' => 'Registrační formulář uživatele',
		),
		'sensitive-parameter' => 'Citlivý parametr. Upravte ručně v souboru <kbd>./data/config.php</kbd>',
		'tos' => array(
			'disabled' => 'není uveden',
			'enabled' => '<a href="./?a=tos">je povolen</a>',
			'help' => 'Jak povolit <a href="https://freshrss.github.io/FreshRSS/en/admins/12_User_management.html#enable-terms-of-service-tos" target="_blank">podmínky poskytování služby</a>',
		),
		'websub' => array(
			'help' => 'O <a href="https://freshrss.github.io/FreshRSS/en/users/WebSub.html" target="_blank">WebSub</a>',
		),
	),
	'update' => array(
		'_' => 'Aktualizace systému',
		'apply' => 'Použít',
		'changelog' => 'Seznam změn',
		'check' => 'Zkontrolovat aktualizace',
		'copiedFromURL' => 'update.php zkopírováno z %s do ./data',
		'current_version' => 'Vaše aktuální verze',
		'last' => 'Poslední kontrola',
		'loading' => 'Aktualizuje se…',
		'none' => 'Žádné nové aktualizace',
		'releaseChannel' => array(
			'_' => 'Kanál pro vydání',
			'edge' => 'Vydání "Rolling" / Nepřetržitě aktualizované vydání (“edge”)',
			'latest' => 'Stabilní vydání (“latest”)',
		),
		'title' => 'Aktualizovat systém',
		'viaGit' => 'Aktualizace přes git a GitHub.com začala',
	),
	'user' => array(
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
	),
);
