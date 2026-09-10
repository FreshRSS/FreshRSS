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
	'action' => array(
		'finish' => 'Užbaigti diegimą',
		'fix_errors_before' => 'Prieš pereidami prie kito žingsnio, ištaisykite visas klaidas.',
		'keep_install' => 'Palikti ankstesnę konfigūraciją',
		'next_step' => 'Pereiti prie kito žingsnio',
		'reinstall' => 'Įdiegti FreshRSS iš naujo',
	),
	'bdd' => array(
		'_' => 'Duomenų bazė',
		'conf' => array(
			'_' => 'Duomenų bazės konfigūracija',
			'ko' => 'Patikrinkite duomenų bazės konfigūraciją.',
			'ok' => 'Duomenų bazės konfigūracija išsaugota.',
		),
		'host' => 'Serveris (host)',
		'password' => 'Duomenų bazės slaptažodis',
		'prefix' => 'Lentelių priešdėlis',
		'type' => 'Duomenų bazės tipas',
		'username' => 'Duomenų bazės naudotojo vardas',
	),
	'check' => array(
		'_' => 'Patikros',
		'already_installed' => 'Aptikome, kad FreshRSS jau įdiegtas!',
		'cache' => array(
			'nok' => 'Patikrinkite katalogo <em>%1$s</em> teises naudotojui <em>%2$s</em>. HTTP serveris turi turėti rašymo teisę.',
			'ok' => 'Podėlio (cache) katalogo teisės tinkamos.',
		),
		'ctype' => array(
			'nok' => 'Nepavyksta rasti reikalingos simbolių tipo tikrinimo bibliotekos (php-ctype).',
			'ok' => 'Turite reikalingą simbolių tipo tikrinimo biblioteką (ctype).',
		),
		'curl' => array(
			'nok' => 'Nepavyksta rasti reikalingos cURL bibliotekos (php-curl paketas).',
			'ok' => 'Turite reikalingą cURL biblioteką.',
		),
		'data' => array(
			'nok' => 'Patikrinkite katalogo <em>%1$s</em> teises naudotojui <em>%2$s</em>. HTTP serveris turi turėti rašymo teisę.',
			'ok' => 'Duomenų (data) katalogo teisės tinkamos.',
		),
		'database-connection' => array(
			'nok' => 'Duomenų bazės ryšio klaida.',
			'ok' => 'Duomenų bazės ryšys tinkamas.',
		),
		'database-table' => array(
			'nok' => 'Duomenų bazės lentelė „%s“ nepilna.',
			'ok' => 'Duomenų bazės lentelė „%s“ tinkama.',
		),
		'database-tables' => array(
			'nok' => 'Trūksta kai kurių duomenų bazės lentelių.',
			'ok' => 'Visos duomenų bazės lentelės yra.',
		),
		'database-title' => 'Duomenų bazė',
		'docroot' => array(
			'nok' => 'Atrodo, kad jūsų žiniatinklio serverio šakninis katalogas (document root) nenurodo į aplanką <code>./p/</code>. Kiti aplankai, pvz. <code>./data/</code>, gali būti viešai pasiekiami.',
			'ok' => 'Jūsų žiniatinklio serverio šakninis katalogas teisingai nurodo į aplanką <code>./p/</code>.',
		),
		'dom' => array(
			'nok' => 'Nepavyksta rasti reikalingos bibliotekos DOM naršymui.',
			'ok' => 'Turite reikalingą biblioteką DOM naršymui.',
		),
		'favicons' => array(
			'nok' => 'Patikrinkite katalogo <em>%1$s</em> teises naudotojui <em>%2$s</em>. HTTP serveris turi turėti rašymo teisę.',
			'ok' => 'Piktogramų (favicons) katalogo teisės tinkamos.',
		),
		'fileinfo' => array(
			'nok' => 'Nepavyksta rasti rekomenduojamos PHP fileinfo bibliotekos (fileinfo paketas).',
			'ok' => 'Turite rekomenduojamą PHP fileinfo biblioteką (fileinfo paketas).',
		),
		'files' => 'Failų diegimas',
		'gmp' => array(
			'nok' => 'Nepavyksta rasti reikalingo GMP plėtinio 32 bitų PHP (php-gmp paketas).',
			'ok' => 'Turite GMP plėtinį, reikalingą 32 bitų PHP.',
		),
		'intl' => array(
			'nok' => 'Nepavyksta rasti rekomenduojamos bibliotekos php-intl internacionalizacijai.',
			'ok' => 'Turite rekomenduojamą biblioteką php-intl internacionalizacijai.',
		),
		'json' => array(
			'nok' => 'Nepavyksta rasti reikalingos bibliotekos JSON apdorojimui.',
			'ok' => 'Turite reikalingą biblioteką JSON apdorojimui.',
		),
		'mbstring' => array(
			'nok' => 'Nepavyksta rasti rekomenduojamos bibliotekos mbstring Unikodui.',
			'ok' => 'Turite rekomenduojamą biblioteką mbstring Unikodui.',
		),
		'pcre' => array(
			'nok' => 'Nepavyksta rasti reikalingos reguliariųjų reiškinių bibliotekos (php-pcre).',
			'ok' => 'Turite reikalingą reguliariųjų reiškinių biblioteką (PCRE).',
		),
		'pdo-mysql' => array(
			'nok' => 'Nepavyksta rasti reikalingos PDO tvarkyklės MySQL/MariaDB.',
		),
		'pdo-pgsql' => array(
			'nok' => 'Nepavyksta rasti reikalingos PDO tvarkyklės PostgreSQL.',
		),
		'pdo-sqlite' => array(
			'nok' => 'Nepavyksta rasti PDO tvarkyklės SQLite.',
			'ok' => 'Turite PDO tvarkyklę SQLite.',
		),
		'pdo' => array(
			'nok' => 'Nepavyksta rasti PDO ar vienos iš palaikomų tvarkyklių (pdo_sqlite, pdo_pgsql, pdo_mysql).',
			'ok' => 'Turite PDO ir bent vieną iš palaikomų tvarkyklių (pdo_sqlite, pdo_pgsql, pdo_mysql).',
		),
		'php' => array(
			'_' => 'PHP diegimas',
			'nok' => 'Jūsų PHP versija yra %s, tačiau FreshRSS reikia bent %s versijos.',
			'ok' => 'Jūsų PHP versija (%s) suderinama su FreshRSS.',
		),
		'reload' => 'Tikrinti dar kartą',
		'tmp' => array(
			'nok' => 'Patikrinkite katalogo <em>%1$s</em> teises naudotojui <em>%2$s</em>. HTTP serveris turi turėti rašymo teises.',
			'ok' => 'Laikinojo (temp) katalogo teisės tinkamos.',
		),
		'tokens' => array(
			'nok' => 'Patikrinkite katalogo <em>./data/tokens</em> teises. HTTP serveris turi turėti rašymo teisę',
			'ok' => 'Prieigos raktų (tokens) katalogo teisės tinkamos.',
		),
		'unknown_process_username' => 'nežinomas',
		'users' => array(
			'nok' => 'Patikrinkite katalogo <em>%1$s</em> teises naudotojui <em>%2$s</em>. HTTP serveris turi turėti rašymo teises.',
			'ok' => 'Naudotojų (users) katalogo teisės tinkamos.',
		),
		'xml' => array(
			'nok' => 'Nepavyksta rasti reikalingos bibliotekos XML apdorojimui.',
			'ok' => 'Turite reikalingą biblioteką XML apdorojimui.',
		),
		'zip' => array(
			'nok' => 'Nepavyksta rasti rekomenduojamo ZIP plėtinio (php-zip paketas).',
			'ok' => 'Turite rekomenduojamą ZIP plėtinį (php-zip paketas).',
		),
	),
	'conf' => array(
		'_' => 'Bendroji konfigūracija',
		'ok' => 'Bendroji konfigūracija išsaugota.',
	),
	'congratulations' => 'Sveikiname!',
	'default_user' => array(
		'_' => 'Numatytojo naudotojo vardas',
		'max_char' => '1–39 simboliai: raidės, skaitmenys ir <code>. _ @ -</code>',
	),
	'fix_errors_before' => 'Prieš pereidami prie kito žingsnio, ištaisykite klaidas.',
	'javascript_is_better' => 'FreshRSS malonesnis įjungus „JavaScript“',
	'js' => array(
		'confirm_reinstall' => 'Įdiegdami FreshRSS iš naujo prarasite ankstesnę konfigūraciją. Ar tikrai norite tęsti?',
	),
	'language' => array(
		'_' => 'Kalba',
		'choose' => 'Pasirinkite FreshRSS kalbą',
		'defined' => 'Kalba nustatyta.',
	),
	'missing_applied_migrations' => 'Kažkas nepavyko; turėtumėte rankiniu būdu sukurti tuščią failą <em>%s</em>.',
	'ok' => 'Diegimas sėkmingas.',
	'session' => array(
		'nok' => 'Atrodo, kad žiniatinklio serveris neteisingai sukonfigūruotas slapukams (cookies), kurie reikalingi PHP sesijoms!',
	),
	'step' => '%d žingsnis',
	'steps' => 'Žingsniai',
	'this_is_the_end' => 'Tai pabaiga',
	'title' => 'Diegimas · FreshRSS',
);
