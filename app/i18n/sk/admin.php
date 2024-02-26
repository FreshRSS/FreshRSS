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
		'allow_anonymous' => 'Povoliť čítanie článkov prednastaveného používateľa (%s) bez prihlásenia.',
		'allow_anonymous_refresh' => 'Povoliť obnovenie článkov bez prihlásenia',
		'api_enabled' => 'Povoliť prístup cez <abbr>API</abbr> <small>(vyžadujú mobilné aplikácie)</small>',
		'form' => 'Webový formulár (traditičný, vyžaduje JavaScript)',
		'http' => 'HTTP (pre pokročilých používateľov s HTTPS)',
		'none' => 'Žiadny (nebezpečné)',
		'title' => 'Prihlásenie',
		'token' => 'Master authentication token',	// TODO
		'token_help' => 'Allows access to all RSS outputs of the user as well as refreshing feeds without authentication:',	// TODO
		'type' => 'Spôsob prihlásenia',
		'unsafe_autologin' => 'Povoliť nebezpečné automatické prihlásenie pomocou webového formulára: ',
	],
	'check_install' => [
		'cache' => [
			'nok' => 'Overte prístupové práva priečinka <em>./data/cache</em>. HTTP server musí mať právo doň zapisovať.',
			'ok' => 'Prístupové práva priečinka pre vyrovnávaciu pamäť sú OK.',
		],
		'categories' => [
			'nok' => 'Tabuľka kategórií je nesprávne nastavená.',
			'ok' => 'Tabuľka kategórií je OK.',
		],
		'connection' => [
			'nok' => 'Nepodarilo sa vytvoriť pripojenie k databáze.',
			'ok' => 'Pripojenie k databáze je OK.',
		],
		'ctype' => [
			'nok' => 'Nepodarilo sa nájsť požadovanú knižnicu na kontrolu typu znakov (php-ctype).',
			'ok' => 'Našla sa požadovaná knižnica na kontrolu typu znakov (ctype).',
		],
		'curl' => [
			'nok' => 'Nepodarilo sa nájsť knižnicu cURL (balík php-curl).',
			'ok' => 'Našla sa knižnica cURL.',
		],
		'data' => [
			'nok' => 'Skontrolujte oprávnenia prístupu do priečinku <em>./data</em>. HTTP server musí mať právo doň zapisovať.',
			'ok' => 'Oprávnenia prístupu do priečinku údajov sú OK.',
		],
		'database' => 'Inštalácia databázy',
		'dom' => [
			'nok' => 'Nepodarilo sa nájsť požadovanú knižnicu na prehliadanie DOM.',
			'ok' => 'Našla sa požadovaná knižnica na prehliadanie DOM.',
		],
		'entries' => [
			'nok' => 'Tabuľka článkov je nesprávne nastavená.',
			'ok' => 'Tabuľka článkov je OK.',
		],
		'favicons' => [
			'nok' => 'Skontrolujte oprávnenia prístupu do priečinku <em>./data/favicons</em>. HTTP server musí mať právo doň zapisovať.',
			'ok' => 'Oprávnenia prístupu do priečinku ikôn obľúbených sú OK.',
		],
		'feeds' => [
			'nok' => 'Tabuľka kanálov je nesprávne nastavená.',
			'ok' => 'Tabuľka kanálov je OK.',
		],
		'fileinfo' => [
			'nok' => 'Nepodarilo sa nájsť knižniuc PHP fileinfo (balík fileinfo).',
			'ok' => 'Našla sa knižnica fileinfo.',
		],
		'files' => 'Inštalácia súborov',
		'json' => [
			'nok' => 'Nepodarilo sa nájsť požadovanú knižnicu na spracovanie formátu JSON.',
			'ok' => 'Našla sa požadovaná knižnica na spracovanie formátu JSON.',
		],
		'mbstring' => [
			'nok' => 'Nepodarilo sa nájsť požadovanú knižnicu mbstring pre Unicode.',
			'ok' => 'Našla sa požadovaná knižnica mbstring pre Unicode.',
		],
		'pcre' => [
			'nok' => 'Nepodarilo sa nájsť požadovanú knižnicu pre regulárne výrazy (php-pcre).',
			'ok' => 'Našla sa požadovaná knižnica pre regulárne výrazy (PCRE).',
		],
		'pdo' => [
			'nok' => 'Nepodarilo sa nájsť PDO alebo niektorý z podporovaných ovládačov (pdo_mysql, pdo_sqlite, pdo_pgsql).',
			'ok' => 'Našiel sa PDO a aspoň jeden z podporovaných ovládačov (pdo_mysql, pdo_sqlite, pdo_pgsql).',
		],
		'php' => [
			'_' => 'Inštalácia PHP',
			'nok' => 'Vaša verzia PHP je %s, ale FreshRSS vyžaduje minimálne verziu %s.',
			'ok' => 'Vaša verzia PHP %s je kompatibilná s FreshRSS.',
		],
		'tables' => [
			'nok' => 'V databáze chýba jedna alebo viacero tabuliek.',
			'ok' => 'V databáze sa nachádzajú všetky potrebné tabuľky.',
		],
		'title' => 'Kontrola inštalácie',
		'tokens' => [
			'nok' => 'Skontrolujte oprávnenia prístupu do priečinku <em>./data/tokens</em>. HTTP server musí mať právo doň zapisovať.',
			'ok' => 'Oprávnenia prístupu do priečinku tokens sú OK.',
		],
		'users' => [
			'nok' => 'Skontrolujte oprávnenia prístupu do priečinku <em>./data/users</em>. HTTP server musí mať právo doň zapisovať.',
			'ok' => 'Oprávnenia prístupu do priečinku používateľov sú OK.',
		],
		'zip' => [
			'nok' => 'Nepodarilo sa nájsť rozšírenie ZIP (balík php-zip).',
			'ok' => 'Rozšírenie ZIP sa našlo.',
		],
	],
	'extensions' => [
		'author' => 'Autor',
		'community' => 'Rozšírenia od komunity',
		'description' => 'Popis',
		'disabled' => 'Zakázané',
		'empty_list' => 'Žiadne nainštalované rozšírenia',
		'enabled' => 'Povolené',
		'latest' => 'Nainštalované',
		'name' => 'Názov',
		'no_configure_view' => 'Toto rozšírenie nemá nastavenia.',
		'system' => [
			'_' => 'Systémové rozšírenia',
			'no_rights' => 'Systémové rozšírenie (nemáte oprávnenia)',
		],
		'title' => 'Rozšírenia',
		'update' => 'Sú dostupné aktualizácie',
		'user' => 'Používateľské rozšírenia',
		'version' => 'Verzia',
	],
	'stats' => [
		'_' => 'Štatistiky',
		'all_feeds' => 'Všetky kanály',
		'category' => 'Kategória',
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
		'no_idle' => 'Žiadne neaktívne kanály!',
		'number_entries' => 'Počet článkov: %d',
		'percent_of_total' => 'Z celkového počtu: %',
		'repartition' => 'Rozdelenie článkov',
		'status_favorites' => 'Obľúbené',
		'status_read' => 'Prečítané',
		'status_total' => 'Spolu',
		'status_unread' => 'Neprečítané',
		'title' => 'Štatistiky',
		'top_feed' => 'Top 10 kanálov',
	],
	'system' => [
		'_' => 'Nastavenia systému',
		'auto-update-url' => 'Odkaz na aktualizačný server',
		'base-url' => [
			'_' => 'Base URL',	// TODO
			'recommendation' => 'Automatic recommendation: <kbd>%s</kbd>',	// TODO
		],
		'cookie-duration' => [
			'help' => 'v sekundách',
			'number' => 'Dobra, počas ktorej ste prihlásený',
		],
		'force_email_validation' => 'Vynútiť overenie e-mailovej adresy',
		'instance-name' => 'Názov inštancie',
		'max-categories' => 'Limit počtu kategórií pre používateľa',
		'max-feeds' => 'Limit počtu kanálov pre používateľov',
		'registration' => [
			'number' => 'Maximálny počt účtov',
			'select' => [
				'label' => 'Registračný formulár',
				'option' => [
					'noform' => 'Zakázané: Žiadny registračný formulár',
					'nolimit' => 'Povolené: Bez obmedzenia účtov',
					'setaccountsnumber' => 'Určiť max. počet účtov',
				],
			],
			'status' => [
				'disabled' => 'Formulár zakázaný',
				'enabled' => 'Formulár povolený',
			],
			'title' => 'Registračný formulár používateľa',
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
		'_' => 'Aktualizácia systému',
		'apply' => 'Použiť',
		'changelog' => 'Changelog',	// TODO
		'check' => 'Skontrolovať aktualizácie',
		'copiedFromURL' => 'update.php copied from %s to ./data',	// TODO
		'current_version' => 'Vaša aktuálna verzia',
		'last' => 'Posledná kontrola',
		'loading' => 'Updating…',	// TODO
		'none' => 'Žiadna nová aktualizácia',
		'releaseChannel' => [
			'_' => 'Release channel',	// TODO
			'edge' => 'Rolling release (“edge”)',	// TODO
			'latest' => 'Stable release (“latest”)',	// TODO
		],
		'title' => 'Aktualizácia systému',
		'viaGit' => 'Update via git and Github.com started',	// TODO
	],
	'user' => [
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
	],
];
