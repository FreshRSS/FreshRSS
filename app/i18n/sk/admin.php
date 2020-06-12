<?php

return array(
	'auth' => array(
		'allow_anonymous' => 'Povoliť čítanie článkov prednastaveného používateľa (%s) bez prihlásenia.',
		'allow_anonymous_refresh' => 'Povoliť obnovenie článkov bez prihlásenia',
		'api_enabled' => 'Povoliť prístup cez <abbr>API</abbr> <small>(vyžadujú mobilné aplikácie)</small>',
		'form' => 'Webový formulár (traditičný, vyžaduje JavaScript)',
		'http' => 'HTTP (pre pokročilých používateľov s HTTPS)',
		'none' => 'Žiadny (nebezpečné)',
		'title' => 'Prihlásenie',
		'title_reset' => 'Reset prihlásenia',
		'token' => 'Token prihlásenia',
		'token_help' => 'Povoliť prístup k výstupu RSS prednastaveného používateľa bez prihlásenia:',
		'type' => 'Spôsob prihlásenia',
		'unsafe_autologin' => 'Povoliť nebezpečné automatické prihlásenie pomocou webového formulára: ',
	),
	'check_install' => array(
		'cache' => array(
			'nok' => 'Overte prístupové práva priečinka <em>./data/cache</em>. HTTP server musí mať právo doň zapisovať.',
			'ok' => 'Prístupové práva priečinka pre vyrovnávaciu pamäť sú OK.',
		),
		'categories' => array(
			'nok' => 'Tabuľka kategórií je nesprávne nastavená.',
			'ok' => 'Tabuľka kategórií je OK.',
		),
		'connection' => array(
			'nok' => 'Nepodarilo sa vytvoriť pripojenie k databáze.',
			'ok' => 'Pripojenie k databáze je OK.',
		),
		'ctype' => array(
			'nok' => 'Nepodarilo sa nájsť požadovanú knižnicu na kontrolu typu znakov (php-ctype).',
			'ok' => 'Našla sa požadovaná knižnica na kontrolu typu znakov (ctype).',
		),
		'curl' => array(
			'nok' => 'Nepodarilo sa nájsť knižnicu cURL (balík php-curl).',
			'ok' => 'Našla sa knižnica cURL.',
		),
		'data' => array(
			'nok' => 'Skontrolujte oprávnenia prístupu do priečinku <em>./data</em>. HTTP server musí mať právo doň zapisovať.',
			'ok' => 'Oprávnenia prístupu do priečinku údajov sú OK.',
		),
		'database' => 'Inštalácia databázy',
		'dom' => array(
			'nok' => 'Nepodarilo sa nájsť požadovanú knižnicu na prehliadanie DOM.',
			'ok' => 'Našla sa požadovaná knižnica na prehliadanie DOM.',
		),
		'entries' => array(
			'nok' => 'Tabuľka článkov je nesprávne nastavená.',
			'ok' => 'Tabuľka článkov je OK.',
		),
		'favicons' => array(
			'nok' => 'Skontrolujte oprávnenia prístupu do priečinku <em>./data/favicons</em>. HTTP server musí mať právo doň zapisovať.',
			'ok' => 'Oprávnenia prístupu do priečinku ikôn obľúbených sú OK.',
		),
		'feeds' => array(
			'nok' => 'Tabuľka kanálov je nesprávne nastavená.',
			'ok' => 'Tabuľka kanálov je OK.',
		),
		'fileinfo' => array(
			'nok' => 'Nepodarilo sa nájsť knižniuc PHP fileinfo (balík fileinfo).',
			'ok' => 'Našla sa knižnica fileinfo.',
		),
		'files' => 'Inštalácia súborov',
		'json' => array(
			'nok' => 'Nepodarilo sa nájsť požadovanú knižnicu na spracovanie formátu JSON.',
			'ok' => 'Našla sa požadovaná knižnica na spracovanie formátu JSON.',
		),
		'mbstring' => array(
			'nok' => 'Nepodarilo sa nájsť požadovanú knižnicu mbstring pre Unicode.',
			'ok' => 'Našla sa požadovaná knižnica mbstring pre Unicode.',
		),
		'minz' => array(
			'nok' => 'Nepodarilo sa nájsť framework Minz.',
			'ok' => 'Našiel sa framework Minz.',
		),
		'pcre' => array(
			'nok' => 'Nepodarilo sa nájsť požadovanú knižnicu pre regulárne výrazy (php-pcre).',
			'ok' => 'Našla sa požadovaná knižnica pre regulárne výrazy (PCRE).',
		),
		'pdo' => array(
			'nok' => 'Nepodarilo sa nájsť PDO alebo niektorý z podporovaných ovládačov (pdo_mysql, pdo_sqlite, pdo_pgsql).',
			'ok' => 'Našiel sa PDO a aspoň jeden z podporovaných ovládačov (pdo_mysql, pdo_sqlite, pdo_pgsql).',
		),
		'php' => array(
			'_' => 'Inštalácia PHP',
			'nok' => 'Vaša verzia PHP je %s, ale FreshRSS vyžaduje minimálne verziu %s.',
			'ok' => 'Vaša verzia PHP %s je kompatibilná s FreshRSS.',
		),
		'tables' => array(
			'nok' => 'V databáze chýba jedna alebo viacero tabuliek.',
			'ok' => 'V databáze sa nachádzajú všetky potrebné tabuľky.',
		),
		'title' => 'Kontrola inštalácie',
		'tokens' => array(
			'nok' => 'Skontrolujte oprávnenia prístupu do priečinku <em>./data/tokens</em>. HTTP server musí mať právo doň zapisovať.',
			'ok' => 'Oprávnenia prístupu do priečinku tokens sú OK.',
		),
		'users' => array(
			'nok' => 'Skontrolujte oprávnenia prístupu do priečinku <em>./data/users</em>. HTTP server musí mať právo doň zapisovať.',
			'ok' => 'Oprávnenia prístupu do priečinku používateľov sú OK.',
		),
		'zip' => array(
			'nok' => 'Nepodarilo sa nájsť rozšírenie ZIP (balík php-zip).',
			'ok' => 'Rozšírenie ZIP sa našlo.',
		),
	),
	'extensions' => array(
		'author' => 'Autor',
		'available' => 'Available',	// TODO - Translation
		'community' => 'Rozšírenia od komunity',
		'description' => 'Popis',
		'disabled' => 'Zakázané',
		'empty_list' => 'Žiadne nainštalované rozšírenia',
		'enabled' => 'Povolené',
		'latest' => 'Nainštalované',
		'name' => 'Názov',
		'no_configure_view' => 'Toto rozšírenie nemá nastavenia.',
		'status' => 'Status',	// TODO - Translation
		'system' => array(
			'_' => 'Systémové rozšírenia',
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
		'menu' => array(
			'idle' => 'Neaktívne kanály',
			'main' => 'Hlavné štatistiky',
			'repartition' => 'Rozdelenie článkov',
		),
		'no_idle' => 'Žiadne neaktívne kanály!',
		'number_entries' => 'Počet článkov: %d',
		'percent_of_total' => 'Z celkového počtu: %%',
		'repartition' => 'Rozdelenie článkov',
		'status_favorites' => 'Obľúbené',
		'status_read' => 'Prečítané',
		'status_total' => 'Spolu',
		'status_unread' => 'Neprečítané',
		'title' => 'Štatistiky',
		'top_feed' => 'Top 10 kanálov',
	),
	'system' => array(
		'_' => 'Nastavenia systému',
		'auto-update-url' => 'Odkaz na aktualizačný server',
		'cookie-duration' => array(
			'help' => 'v sekundách',
			'number' => 'Dobra, počas ktorej ste prihlásený',
		),
		'force_email_validation' => 'Force email addresses validation',	// TODO - Translation
		'instance-name' => 'Názov inštancie',
		'max-categories' => 'Limit počtu kategórií pre používateľa',
		'max-feeds' => 'Limit počtu kanálov pre používateľov',
		'registration' => array(
			'help' => '0 znamená žiadny limit počtu účtov',
			'number' => 'Maximálny počt účtov',
		),
	),
	'update' => array(
		'_' => 'Aktualizácia systému',
		'apply' => 'Použiť',
		'check' => 'Skontrolovať aktualizácie',
		'current_version' => 'Vaša aktuálna verzia FreshRSS: %s',
		'last' => 'Posledná kontrola: %s',
		'none' => 'Žiadna nová aktualizácia',
		'title' => 'Aktualizácia systému',
	),
	'user' => array(
		'admin' => 'Administrator',	// TODO - Translation
		'article_count' => 'Articles',	// TODO - Translation
		'articles_and_size' => '%s článkov (%s)',
		'back_to_manage' => '← Return to user list',	// TODO - Translation
		'create' => 'Vytvoriť nového používateľa',
		'database_size' => 'Database size',	// TODO - Translation
		'delete_users' => 'Zmazať používateľa',
		'email' => 'Email address',	// TODO - Translation
		'enabled' => 'Enabled',	// TODO - Translation
		'feed_count' => 'Feeds',	// TODO - Translation
		'is_admin' => 'Is admin',	// TODO - Translation
		'language' => 'Jazyk',
		'last_user_activity' => 'Last user activity',	// TODO - Translation
		'list' => 'User list',	// TODO - Translation
		'number' => 'Je vytvorený používateľ: %d',
		'numbers' => 'Je vytvorených používateľov: %d',
		'password_form' => 'Heslo<br /><small>(pre spôsob prihlásenia cez webový formulár)</small>',
		'password_format' => 'Minimálne 7 znakov',
		'selected' => 'Označený používateľ',
		'title' => 'Správa používateľov',
		'update_users' => 'Sktualizovať používateľov',
		'user_list' => 'Zoznam používateľov',
		'username' => 'Používateľské meno',
		'users' => 'Používatelia',
	),
);
