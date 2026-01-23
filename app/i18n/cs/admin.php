<?php

/******************************************************************************
 * Each entry of that file can be associated with a comment to indicate its   *
 * state. When there is no comment, it means the entry is fully translated.   *
 * The recognized comments are (comment matching is case-insensitive):        *
 *   + TODO: the entry has never been translated.                             *
 *   + DIRTY: the entry has been translated but needs to be updated.          *
 *   + IGNORE: the entry does not need to be translated.                      *
 * When a comment is not recognized, it is discarded.                         *
 ******************************************************************************/

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
	),
	'extensions' => array(
		'author' => 'Autor',
		'community' => 'Dostupná komunitní rozšíření',
		'description' => 'Popis',
		'disabled' => 'Zakázáno',
		'empty_list' => 'Nejsou naistalována žádná rozšíření',
		'empty_list_help' => 'Check the logs to determine the reason behind the empty extension list.',	// TODO
		'enabled' => 'Povoleno',
		'is_compatible' => 'Is compatible',	// TODO
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
		'date_published' => 'Publication date',	// TODO
		'date_received' => 'Received date',	// TODO
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
		'nb_unreads' => 'Number of unread articles',	// TODO
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
		'unread_dates' => 'Dates with most unread articles',	// TODO
	),
	'system' => array(
		'_' => 'Nastavení systému',
		'auto-update-url' => 'Adresa URL serveru pro automatické aktualizace',
		'base-url' => array(
			'_' => 'Základní adresa URL',
			'recommendation' => 'Automatické doporučení: <kbd>%s</kbd>',
		),
		'closed_registration_message' => 'Message if registrations are closed',	// TODO
		'cookie-duration' => array(
			'help' => 'v sekundách',
			'number' => 'Trvání ponechání přihlášení',
		),
		'default_closed_registration_message' => 'This server does not accept new registrations at the moment.',	// TODO
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
