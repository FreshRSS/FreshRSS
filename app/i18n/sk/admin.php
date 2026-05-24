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
		'allow_anonymous' => 'Povoliť čítanie článkov prednastaveného používateľa (%s) bez prihlásenia.',
		'allow_anonymous_refresh' => 'Povoliť obnovenie článkov bez prihlásenia',
		'api_enabled' => 'Povoliť prístup cez <abbr>API</abbr> <small>(vyžadujú mobilné aplikácie and sharing user queries)</small>',	// DIRTY
		'form' => 'Webový formulár (traditičný, vyžaduje JavaScript)',
		'http' => 'HTTP (advanced: managed by Web server, OIDC, SSO…)',	// TODO
		'none' => 'Žiadny (nebezpečné)',
		'title' => 'Prihlásenie',
		'token' => 'Hlavný prihlasovací token',
		'token_help' => 'Povoľuje prístup k všetkým RSS výstupom, a tiež k obnove kanálov bez prihlásenia:',
		'type' => 'Spôsob prihlásenia',
	),
	'extensions' => array(
		'author' => 'Autor',
		'community' => 'Rozšírenia od komunity',
		'description' => 'Popis',
		'disabled' => 'Zakázané',
		'empty_list' => 'Žiadne nainštalované rozšírenia',
		'empty_list_help' => 'Check the logs to determine the reason behind the empty extension list.',	// TODO
		'enabled' => 'Povolené',
		'is_compatible' => 'Is compatible',	// TODO
		'latest' => 'Nainštalované',
		'name' => 'Názov',
		'no_configure_view' => 'Toto rozšírenie nemá nastavenia.',
		'system' => array(
			'_' => 'Systémové rozšírenia',
			'no_rights' => 'Systémové rozšírenie (nemáte oprávnenia)',
		),
		'title' => 'Rozšírenia',
		'update' => 'Sú dostupné aktualizácie',
		'user' => 'Používateľské rozšírenia',
		'version' => 'Verzia',
	),
	'stats' => array(
		'_' => 'Štatistiky',
		'all_feeds' => 'Všetky kanály',
		'category' => 'Kategória',
		'date_published' => 'Publication date',	// TODO
		'date_received' => 'Received date',	// TODO
		'entry_count' => 'Počet položiek',
		'entry_per_category' => 'Položiek v kategórii',
		'entry_per_day' => 'Položiek za deň (posledných 30 dní)',
		'entry_per_day_of_week' => 'Za deň v týždni (priemer: %.2f správy)',
		'entry_per_hour' => 'Za hodinu (priemer: %.2f správy)',
		'entry_per_month' => 'Za mesiac (priemer: %.2f správy)',
		'entry_repartition' => 'Rozdelenie článkov',
		'feed' => 'Kanál',
		'feed_per_category' => 'Kanálov v kategórii',
		'idle' => 'Neaktívne kanály',
		'main' => 'Hlavné štatistiky',
		'main_stream' => 'Všetky kanály',
		'nb_unreads' => 'Number of unread articles',	// TODO
		'no_idle' => 'Žiadne neaktívne kanály!',
		'number_entries' => 'Počet článkov: %d',
		'overview' => 'Overview',	// TODO
		'percent_of_total' => 'Z celkového počtu: %',
		'repartition' => 'Rozdelenie článkov: %s',
		'status_favorites' => 'Obľúbené',
		'status_read' => 'Prečítané',
		'status_total' => 'Spolu',
		'status_unread' => 'Neprečítané',
		'title' => 'Štatistiky',
		'top_feed' => 'Top 10 kanálov',
		'unread_dates' => 'Dates with most unread articles',	// TODO
	),
	'system' => array(
		'_' => 'Nastavenia systému',
		'auto-update-url' => 'Odkaz na aktualizačný server',
		'base-url' => array(
			'_' => 'Základná URL',
			'recommendation' => 'Automatické odporúčanie: <kbd>%s</kbd>',
		),
		'closed_registration_message' => 'Message if registrations are closed',	// TODO
		'cookie-duration' => array(
			'help' => 'v sekundách',
			'number' => 'Dobra, počas ktorej ste prihlásený',
		),
		'default_closed_registration_message' => 'This server does not accept new registrations at the moment.',	// TODO
		'force_email_validation' => 'Vynútiť overenie e-mailovej adresy',
		'instance-name' => 'Názov inštancie',
		'max-categories' => 'Limit počtu kategórií pre používateľa',
		'max-feeds' => 'Limit počtu kanálov pre používateľov',
		'registration' => array(
			'number' => 'Maximálny počt účtov',
			'select' => array(
				'label' => 'Registračný formulár',
				'option' => array(
					'noform' => 'Zakázané: Žiadny registračný formulár',
					'nolimit' => 'Povolené: Bez obmedzenia účtov',
					'setaccountsnumber' => 'Určiť max. počet účtov',
				),
			),
			'status' => array(
				'disabled' => 'Formulár zakázaný',
				'enabled' => 'Formulár povolený',
			),
			'title' => 'Registračný formulár používateľa',
		),
		'sensitive-parameter' => 'Citlivý parameter. Upravte ručne v súbore <kbd>./data/config.php</kbd>',
		'tos' => array(
			'disabled' => 'nebol zadaný',
			'enabled' => '<a href="./?a=tos">je povolený</a>',
			'help' => '<a href="https://freshrss.github.io/FreshRSS/en/admins/12_User_management.html#enable-terms-of-service-tos" target="_blank">Ako povolit Podmienky služby</a>',
		),
		'websub' => array(
			'help' => 'O protokole <a href="https://freshrss.github.io/FreshRSS/en/users/WebSub.html" target="_blank">WebSub</a>',
		),
	),
	'update' => array(
		'_' => 'Aktualizácia systému',
		'apply' => 'Použiť',
		'changelog' => 'Zoznam zmien',
		'check' => 'Skontrolovať aktualizácie',
		'copiedFromURL' => 'update.php skopírovaný z %s do ./data',
		'current_version' => 'Vaša aktuálna verzia',
		'last' => 'Posledná kontrola',
		'loading' => 'Aktualizuje sa…',
		'none' => 'Žiadna nová aktualizácia',
		'releaseChannel' => array(
			'_' => 'Kanál verzií',
			'edge' => 'Vývojárska verzia (“edge”)',
			'latest' => 'Stabilná verzia (“latest”)',
		),
		'title' => 'Aktualizácia systému',
		'viaGit' => 'Začala sa aktualizácia prostredníctvom git a GitHub.com',
	),
	'user' => array(
		'admin' => 'Administrátor',
		'article_count' => 'Články',
		'back_to_manage' => '← Späť na zoznam používateľov',
		'create' => 'Vytvoriť nového používateľa',
		'database_size' => 'Veľkosť databázy',
		'email' => 'E-mailová adresa',
		'enabled' => 'Povolené',
		'feed_count' => 'Kanály',
		'is_admin' => 'Je admin',
		'language' => 'Jazyk',
		'last_user_activity' => 'Posledná aktivita používateľa',
		'list' => 'Zoznam používateľov',
		'number' => 'Je vytvorený používateľ: %d',
		'numbers' => 'Je vytvorených používateľov: %d',
		'password_form' => 'Heslo<br /><small>(pre spôsob prihlásenia cez webový formulár)</small>',
		'password_format' => 'Minimálne 7 znakov',
		'title' => 'Správa používateľov',
		'username' => 'Používateľské meno',
	),
);
