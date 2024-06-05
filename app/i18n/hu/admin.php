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
		'allow_anonymous' => 'Névtelen felhasználók olvashatják az alapértelmezett felhasználó cikkeit (%s)',
		'allow_anonymous_refresh' => 'Névtelen felhasználok frissíthetik a cikkeket',
		'api_enabled' => ' <abbr>API</abbr> elérés engedélyezése <small>(mobilalkalmazásokhoz szükséges)</small>',
		'form' => 'Webes űrlap (hagyományos, JavaScript szükséges hozzá)',
		'http' => 'HTTP (haladó felhasználóknak HTTPS-el)',
		'none' => 'nincs (veszélyes)',
		'title' => 'Hitelesítés',
		'token' => 'Fő hitelesítési token',
		'token_help' => 'Lehetővé teszi a hozzáférést a felhasználó összes RSS-kimenetéhez, valamint a hírfolyamok frissítéséhez hitelesítés nélkül:',
		'type' => 'Hitelesítési módszer',
		'unsafe_autologin' => 'Engedélyezze a nem biztonságos automata bejelentkezést a következő formátummal: ',
	),
	'check_install' => array(
		'cache' => array(
			'nok' => 'Ellenőrizd a <em>./data/cache</em> könyvtárat. A HTTP szervernek írási jogosultságra van szüksége.',
			'ok' => 'A jogosultságok a gyorsítótár könyvtáron rendben vannak.',
		),
		'categories' => array(
			'nok' => 'A kategória tábla nincs helyesen konfigurálva.',
			'ok' => 'A kategória tábla rendben van.',
		),
		'connection' => array(
			'nok' => 'Nem lehet kapcsolódni az adatbázishoz.',
			'ok' => 'A kapcsolat az adatbázissal rendben van.',
		),
		'ctype' => array(
			'nok' => 'Nem található a karakter típus ellenőrző könyvtár (php-ctype).',
			'ok' => 'A karakter típus ellenőrző könyvtár rendben van (ctype).',
		),
		'curl' => array(
			'nok' => 'Nem található a cURL könyvtár (php-curl csomag).',
			'ok' => 'A cURL könyvtár rendben van.',
		),
		'data' => array(
			'nok' => 'Ellenőrizd a <em>./data</em> könyvtár jogosultságait. A HTTP szervernek szüksége van írási jogosultságra.',
			'ok' => 'A data könyvtár jogosultságai megfelelőek.',
		),
		'database' => 'Adatbázis telepítés',
		'dom' => array(
			'nok' => 'A DOM böngészéséhez nem található a könyvtár. (php-xml csomag).',
			'ok' => 'A DOM böngészésére való könyvtár telepítve van.',
		),
		'entries' => array(
			'nok' => 'A belépési tábla nincs helyesen konfigurálva.',
			'ok' => 'A belépési tábla rendben van.',
		),
		'favicons' => array(
			'nok' => 'Ellenőrizd a <em>./data/favicons</em> könyvtár jogosultságait.A HTTP szervernek szüksége van írási jogosultságra.',
			'ok' => 'A favicons könyvtár jogosultságai megfelelőek.',
		),
		'feeds' => array(
			'nok' => 'A hírforrás tábla nincs megfelelően konfigurálva.',
			'ok' => 'A hírforrás tábla ok.',
		),
		'fileinfo' => array(
			'nok' => 'A PHP fileinfo könyvtár nem található (fileinfo csomag).',
			'ok' => 'A fileinfo könyvtár rendben van.',
		),
		'files' => 'Fájl telepítés',
		'json' => array(
			'nok' => 'A JSON nem található (php-json csomag).',
			'ok' => 'A JSON kiegészítő telepítve van.',
		),
		'mbstring' => array(
			'nok' => 'Az ajánlott mbstring könyvtár nem található a Unicode kódoláshoz.',
			'ok' => 'Az ajánlott mbstring könyvtár a Unicode kódoláshoz megvan.',
		),
		'pcre' => array(
			'nok' => 'A reguláris kifejezésekhez használt könyvtár nem található (php-pcre).',
			'ok' => 'A reguláris kifejezésekhez használt könyvtár megvan (PCRE).',
		),
		'pdo' => array(
			'nok' => 'Nem található PDO vagy legalább egy támogató driver (pdo_mysql, pdo_sqlite, pdo_pgsql).',
			'ok' => 'A PDO telepítve és van legalább egy támogatott driver (pdo_mysql, pdo_sqlite, pdo_pgsql).',
		),
		'php' => array(
			'_' => 'PHP telepítés',
			'nok' => 'A PHP verzió %s de a FreshRSS számára szükséges verzió %s.',
			'ok' => 'A PHP verzió (%s) kompatibilis a FreshRSS-el.',
		),
		'tables' => array(
			'nok' => 'Egy vagy több tábla hiányzik az adatbázisból.',
			'ok' => 'A megfelelő táblák léteznek az adatbázisban.',
		),
		'title' => 'Telepítés ellenőrzése',
		'tokens' => array(
			'nok' => 'Ellenőrizd a <em>./data/tokens</em> könyvtár jogosultságait. A HTTP szervernek szüksége van írási jogosultságra.',
			'ok' => 'A token könyvtár írási jogosultságai rendben vannak.',
		),
		'users' => array(
			'nok' => 'Ellenőrizd a <em>./data/users</em> könyvtár írási jogosultságait. A HTTP szervernek szüksége van írási jogosultságra.',
			'ok' => 'A users könyvtár írási jogosultságai rendben vannak.',
		),
		'zip' => array(
			'nok' => 'Nem található ZIP kiegészítő (php-zip csomag).',
			'ok' => 'A ZIP kiegészítő telepítve van.',
		),
	),
	'extensions' => array(
		'author' => 'Szerző',
		'community' => 'Elérhető közösségi kiegészítők',
		'description' => 'Leírás',
		'disabled' => 'Kikapcsolva',
		'empty_list' => 'Nincsenek telepített kiegészítők',
		'enabled' => 'Bekapcsolva',
		'latest' => 'Telepítve',
		'name' => 'Név',
		'no_configure_view' => 'Ezt a kiegészítőt nem lehet konfigurálni.',
		'system' => array(
			'_' => 'Rendszer kiegészítők',
			'no_rights' => 'Rendszer kiegészítők (felhasználó nem jogosult a módosításhoz)',
		),
		'title' => 'Kiegészítők',
		'update' => 'Frissítés elérhető',
		'user' => 'Felhasználói kiegészítők',
		'version' => 'Verzió',
	),
	'stats' => array(
		'_' => 'Statisztika',
		'all_feeds' => 'Minden hírforrás',
		'category' => 'Kategória',
		'entry_count' => 'Bejegyzések száma',
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
		'number_entries' => '%d cikk',
		'percent_of_total' => '% az összesből',
		'repartition' => 'Cikkek eloszlása',
		'status_favorites' => 'Kedvencek',
		'status_read' => 'Olvasott',
		'status_total' => 'Összes',
		'status_unread' => 'Olvasatlan',
		'title' => 'Statisztika',
		'top_feed' => 'Top 10 hírforrás',
	),
	'system' => array(
		'_' => 'Rendszer konfiguráció',
		'auto-update-url' => 'Automatikus frissítés szerver URL',
		'base-url' => array(
			'_' => 'Alap URL',
			'recommendation' => 'Automatikus ajánlás: <kbd>%s</kbd>',
		),
		'cookie-duration' => array(
			'help' => 'másodpercekben',
			'number' => 'Bejelentkezve maradás időtartam',
		),
		'force_email_validation' => 'Kötelező email cím visszaigazolás',
		'instance-name' => 'Instance név',
		'max-categories' => 'Maximális kategóriák száma felhasználónkét',
		'max-feeds' => 'Maximális hírforrások száma felhasználónként',
		'registration' => array(
			'number' => 'Max felhasználó szám',
			'select' => array(
				'label' => 'Regisztrációs űrlap',
				'option' => array(
					'noform' => 'Kikapcsolva: Nincs regisztrációs űrlap',
					'nolimit' => 'Bekapcsolva: Korlátlan felhasználó szám',
					'setaccountsnumber' => 'Max felhasználó szám beállítása',
				),
			),
			'status' => array(
				'disabled' => 'Űrlap kikapcsolva',
				'enabled' => 'Űrlap bekapcsolva',
			),
			'title' => 'Felhasználó regisztrációs űrlap',
		),
		'sensitive-parameter' => 'Érzékeny paraméter. Szerkessze manuálisan itt <kbd>./data/config.php</kbd>',
		'tos' => array(
			'disabled' => 'nincs elfogadva',
			'enabled' => '<a href="./?a=tos">engedélyezve</a>',
			'help' => 'Hogyan kapcsoljuk be a <a href="https://freshrss.github.io/FreshRSS/en/admins/12_User_management.html#enable-terms-of-service-tos" target="_blank">Szolgáltatási feltételeket</a>',
		),
		'websub' => array(
			'help' => 'A <a href="https://freshrss.github.io/FreshRSS/en/users/WebSub.html" target="_blank">WebSub</a>-ról',
		),
	),
	'update' => array(
		'_' => 'FreshRSS Frissítése',
		'apply' => 'Frissítés indítása',
		'changelog' => 'Változások listája',
		'check' => 'Új frissítések lekérése',
		'copiedFromURL' => 'update.php átmásolva %s ide ./data',
		'current_version' => 'Jelenleg telepített verzió',
		'last' => 'Utolsó ellenőrzés',
		'loading' => 'Frissítés…',
		'none' => 'Nincs elérhető újabb frissítés',
		'releaseChannel' => array(
			'_' => 'Release channel',	// IGNORE
			'edge' => 'Rolling release (“edge”)',	// IGNORE
			'latest' => 'Stable release (“latest”)',	// IGNORE
		),
		'title' => 'FreshRSS frissítése',
		'viaGit' => 'Frissítés a git és GitHub.com-on keresztül elindult',
	),
	'user' => array(
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
		'number' => '%d fiók létrehozva',
		'numbers' => '%d fiók van létrehozva',
		'password_form' => 'Jelszó<br /><small>(a Webes űrlap belépési módszerhez)</small>',
		'password_format' => 'Legalább 7 karakter',
		'title' => 'Felhasználók kezelése',
		'username' => 'Felhasználó név',
	),
);
