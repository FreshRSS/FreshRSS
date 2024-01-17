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
		'allow_anonymous' => 'Névtelen felhasználók olvashatják az alapértelmezett felhasználó cikkeit (%s)',
		'allow_anonymous_refresh' => 'Névtelen felhasználok frissíthetik a cikkeket',
		'api_enabled' => ' <abbr>API</abbr> elérés engedélyezése <small>(mobil alkalmazás szükséges)</small>',
		'form' => 'Webes űrlap (hagyományos, JavaScript szükséges hozzá)',
		'http' => 'HTTP (haladó felhasználóknak HTTPS-el)',
		'none' => 'nincs (veszélyes)',
		'title' => 'Hitelesítés',
		'token' => 'Hitelesítő token',
		'token_help' => 'Engedélyezi az alapértelmezett felhasználó RSS-ének olvasását hitelesítés nélkül:',
		'type' => 'Hitelesítési módszer',
		'unsafe_autologin' => 'Engedélyezze a nem biztonságos automata bejelentkezést a következő formátummal: ',
	],
	'check_install' => [
		'cache' => [
			'nok' => 'Ellenőrizd a <em>./data/cache</em> könyvtárat. HTTP szervernek írási jogosultságra van szüksége.',
			'ok' => 'Jogosultságok a gyorsítótár könyvtáron rendben vannak.',
		],
		'categories' => [
			'nok' => 'Kategória tábla nincs helyesen konfigurálva.',
			'ok' => 'Kategória tábla rendben van.',
		],
		'connection' => [
			'nok' => 'Nem lehet kapcsolódni az adatbázishoz.',
			'ok' => 'Kapcsolat az adatbázissal rendben van.',
		],
		'ctype' => [
			'nok' => 'Nem található a karakter típus ellenőrző könyvtár (php-ctype).',
			'ok' => 'Karakter típus ellenőrző könyvtár rendben (ctype).',
		],
		'curl' => [
			'nok' => 'Nem található a cURL könyvtár (php-curl csomag).',
			'ok' => 'cURL könyvtár rendben van.',
		],
		'data' => [
			'nok' => 'Ellenőrizd a <em>./data</em> könyvtár jogosultságait. A HTTP szervernek szüksége van írási jogosultságra.',
			'ok' => 'A data könyvtár jogosultságai megfelelőek.',
		],
		'database' => 'Adatbázis telepítés',
		'dom' => [
			'nok' => 'A DOM böngészéséhez nem található a könyvtár. (php-xml csomag).',
			'ok' => 'A DOM böngészésére való könyvtár telepítve van.',
		],
		'entries' => [
			'nok' => 'Belépési tábla nincs helyesen konfigurálva.',
			'ok' => 'Belépési tábla rendben.',
		],
		'favicons' => [
			'nok' => 'Ellenőrizd a <em>./data/favicons</em> könyvtár jogosultságait.A HTTP szervernek szüksége van írási jogosultságra.',
			'ok' => 'A favicons könyvtár jogosultságai megfelelőek.',
		],
		'feeds' => [
			'nok' => 'Hírforrás tábla nincs megfelelően konfigurálva.',
			'ok' => 'Hírforrás tábla ok.',
		],
		'fileinfo' => [
			'nok' => 'Fileinfo könyvtár nem található (fileinfo csomag).',
			'ok' => 'Fileinfo könyvtár rendben van.',
		],
		'files' => 'Fájl telepítés',
		'json' => [
			'nok' => 'JSON nem található (php-json csomag).',
			'ok' => 'JSON kiegészítő telepítve.',
		],
		'mbstring' => [
			'nok' => 'Az ajánlott mbstring könyvtár nem található a Unicode kódoláshoz.',
			'ok' => 'Az ajánlott mbstring könyvtár a Unicode kódoláshoz megvan.',
		],
		'pcre' => [
			'nok' => 'A reguláris kifejezésekhez használt könyvtár nem található (php-pcre).',
			'ok' => 'A reguláris kifejezésekhez használt könyvtár megvan (PCRE).',
		],
		'pdo' => [
			'nok' => 'Nem található PDO vagy legalább egy támogató driver (pdo_mysql, pdo_sqlite, pdo_pgsql).',
			'ok' => 'PDO telepítve és legalább egy támogatott driver (pdo_mysql, pdo_sqlite, pdo_pgsql).',
		],
		'php' => [
			'_' => 'PHP telepítés',
			'nok' => 'A PHP verzió %s de a FreshRSS számára szükséges verzió %s.',
			'ok' => 'A PHP verzió (%s) kompatibilis a FreshRSS-el.',
		],
		'tables' => [
			'nok' => 'Egy vagy több tábla hiányzik az adatbázisból.',
			'ok' => 'A megfelelő táblák léteznek az adatbázisban.',
		],
		'title' => 'Telepítés ellenőrzése',
		'tokens' => [
			'nok' => 'Ellenőrizd a <em>./data/tokens</em> könyvtár jogosultságait. A HTTP szervernek szüksége van írási jogosultságra.',
			'ok' => 'Token könyvtár írási jogosultságai rendben.',
		],
		'users' => [
			'nok' => 'Ellenőrizd a <em>./data/users</em> könyvtár írási jogosultságait. A HTTP szervernek szüksége van írási jogosultságra.',
			'ok' => 'Users könyvtár írási jogosultságai rendben.',
		],
		'zip' => [
			'nok' => 'Nem található ZIP kiegészítő (php-zip csomag).',
			'ok' => 'ZIP kiegészítő telepítve.',
		],
	],
	'extensions' => [
		'author' => 'Szerző',
		'community' => 'Elérhető közösségi kiegészítők',
		'description' => 'Leírás',
		'disabled' => 'Kikapcsolva',
		'empty_list' => 'Nincsenek telepített kiegészítők',
		'enabled' => 'Bekapcsolva',
		'latest' => 'Telepítve',
		'name' => 'Név',
		'no_configure_view' => 'Ezt a kiegészítőt nem lehet konfigurálni.',
		'system' => [
			'_' => 'Rendszer kiegészítők',
			'no_rights' => 'Rendszer kiegészítők (felhasználó nem jogosult a módosításhoz)',
		],
		'title' => 'Kiegészítők',
		'update' => 'Frissítés elérhető',
		'user' => 'Felhasználói kiegészítők',
		'version' => 'Verzió',
	],
	'stats' => [
		'_' => 'Statisztika',
		'all_feeds' => 'Minden hírforrás',
		'category' => 'Kategória',
		'entry_count' => 'Újak száma',
		'entry_per_category' => 'Bejegyzések kategóriánként',
		'entry_per_day' => 'Bejegyzések naponta (utolsó 30 nap)',
		'entry_per_day_of_week' => 'A hét napjain (átlag: %.2f bejegyzés)',
		'entry_per_hour' => 'Óránként (átlag: %.2f bejegyzés)',
		'entry_per_month' => 'Havonta (átlag: %.2f bejegyzés)',
		'entry_repartition' => 'Bejegyzések eloszlása',
		'feed' => 'Hírforrás',
		'feed_per_category' => 'Hírforrások kategóriánként',
		'idle' => 'Tétlen hírforrások',
		'main' => 'Fő statisztika',
		'main_stream' => 'Minden cikk',
		'no_idle' => 'Nincsenek tétlen hírforrások!',
		'number_entries' => '%d cikkek',
		'percent_of_total' => '% az összesből',
		'repartition' => 'Cikkek eloszlása',
		'status_favorites' => 'Kedvencek',
		'status_read' => 'Olvasott',
		'status_total' => 'Összes',
		'status_unread' => 'Olvasatlan',
		'title' => 'Statisztika',
		'top_feed' => 'Top 10 hírforrás',
	],
	'system' => [
		'_' => 'Rendszer konfiguráció',
		'auto-update-url' => 'Szerver URL automata frissítése',
		'base-url' => [
			'_' => 'Alap URL',
			'recommendation' => 'Automatikus ajánlás: <kbd>%s</kbd>',
		],
		'cookie-duration' => [
			'help' => 'másodpercekben',
			'number' => 'Bejelentkezési sütik megtartási ideje',
		],
		'force_email_validation' => 'Kötelező email cím visszaigazolás',
		'instance-name' => 'Instance név',
		'max-categories' => 'Maximális kategóriák száma felhasználónkét',
		'max-feeds' => 'Maximális hírforrások száma felhasználónként',
		'registration' => [
			'number' => 'Max felhasználó szám',
			'select' => [
				'label' => 'Regisztrációs űrlap',
				'option' => [
					'noform' => 'Kikapcsolva: Nincs regisztrációs űrlap',
					'nolimit' => 'Bekapcsolva: Korlátlan felhasználó szám',
					'setaccountsnumber' => 'Max felhasználó szám beállítása',
				],
			],
			'status' => [
				'disabled' => 'Űrlap kikapcsolva',
				'enabled' => 'Űrlap bekapcsolva',
			],
			'title' => 'Felhasználó regisztrációs űrlap',
		],
		'sensitive-parameter' => 'Érzékeny paraméter. Szerkessze manuálisan itt <kbd>./data/config.php</kbd>',
		'tos' => [
			'disabled' => 'nincs elfogadva',
			'enabled' => '<a href="./?a=tos">engedélyezve</a>',
			'help' => 'Hogyan kapcsoljuk be a <a href="https://freshrss.github.io/FreshRSS/en/admins/12_User_management.html#enable-terms-of-service-tos" target="_blank">Szolgáltatási feltételeket</a>',
		],
		'websub' => [
			'help' => 'A <a href="https://freshrss.github.io/FreshRSS/en/users/WebSub.html" target="_blank">WebSub</a>-ról',
		],
	],
	'update' => [
		'_' => 'FreshRSS Frissítése',
		'apply' => 'Frissítés indítása',
		'changelog' => 'Változások listája',
		'check' => 'Új frissítések lekérése',
		'copiedFromURL' => 'update.php átmásolva %s ide ./data',
		'current_version' => 'Jelenleg telepített verzió',
		'last' => 'Utolsó ellenőrzés',
		'loading' => 'Frissítés…',
		'none' => 'Nincs elérhető újabb frissítés',
		'releaseChannel' => [
			'_' => 'Release channel',	// IGNORE
			'edge' => 'Rolling release (“edge”)',	// IGNORE
			'latest' => 'Stable release (“latest”)',	// IGNORE
		],
		'title' => 'FreshRSS frissítése',
		'viaGit' => 'Frissítés a git és GitHub.com-on keresztül elindult',
	],
	'user' => [
		'admin' => 'Adminisztrátor',
		'article_count' => 'Cikkek',
		'back_to_manage' => '← Vissza a felhasználók listájához',
		'create' => 'Új felhasználó létrehozása',
		'database_size' => 'Adatbázis méret',
		'email' => 'Email cím',
		'enabled' => 'Engedélyezve',
		'feed_count' => 'Hírforrások',
		'is_admin' => 'Adminisztrátor',
		'language' => 'Nyelv',
		'last_user_activity' => 'Utolsó felhasználói aktivitás',
		'list' => 'Felhasználói lista',
		'number' => ' %d fiók létrehozva',
		'numbers' => ' %d fiók van létrehozva',
		'password_form' => 'Jelszó<br /><small>(a Webes űrlap belépési módszerhez)</small>',
		'password_format' => 'Legalább 7 karakter',
		'title' => 'Felhasználók kezelése',
		'username' => 'Felhasználó név',
	],
];
