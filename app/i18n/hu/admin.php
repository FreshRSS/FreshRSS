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
		'allow_anonymous' => 'Névtelen felhasználók olvashatják az alapértelmezett felhasználó cikkeit (%s)',
		'allow_anonymous_refresh' => 'Névtelen felhasználók frissíthetik a cikkeket',
		'api_enabled' => ' <abbr>API</abbr> elérés engedélyezése <small>(mobilalkalmazásokhoz és felhasználói lekérdezés megosztásához szükséges )</small>',
		'form' => 'Webes űrlap (hagyományos, JavaScript szükséges hozzá)',
		'http' => 'HTTP (haladó: Web szerver kezeli, OIDC, SSO…)',
		'none' => 'nincs (veszélyes)',
		'title' => 'Hitelesítés',
		'token' => 'Fő hitelesítési token',
		'token_help' => 'Lehetővé teszi a hozzáférést a felhasználó összes RSS-kimenetéhez, valamint a hírfolyamok frissítéséhez hitelesítés nélkül:',
		'type' => 'Hitelesítési módszer',
	),
	'extensions' => array(
		'author' => 'Szerző',
		'community' => 'Elérhető közösségi kiegészítők',
		'description' => 'Leírás',
		'disabled' => 'Kikapcsolva',
		'empty_list' => 'Nincsenek telepített kiegészítők',
		'empty_list_help' => 'Ellenőrizd a naplókat, hogy megállapítsd az üres bővítménylista mögött meghúzódó okot.',
		'enabled' => 'Bekapcsolva',
		'is_compatible' => 'Kompatibilis',
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
		'date_published' => 'Publikálás dátuma',
		'date_received' => 'Beérkezés dátuma',
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
		'nb_unreads' => 'Olvasatlan cikkek száma',
		'no_idle' => 'Nincsenek tétlen hírforrások!',
		'number_entries' => '%d cikk',
		'overview' => 'Áttekintés',
		'percent_of_total' => '% az összesből',
		'repartition' => 'Cikkek eloszlása: %s',
		'status_favorites' => 'Kedvencek',
		'status_read' => 'Olvasott',
		'status_total' => 'Összes',
		'status_unread' => 'Olvasatlan',
		'title' => 'Statisztika',
		'top_feed' => 'Top 10 hírforrás',
		'unread_dates' => 'Dátumok a legtöbb olvasatlan cikkel',
	),
	'system' => array(
		'_' => 'Rendszer konfiguráció',
		'auto-update-url' => 'Automatikus frissítés szerver URL',
		'base-url' => array(
			'_' => 'Alap URL',
			'recommendation' => 'Automatikus ajánlás: <kbd>%s</kbd>',
		),
		'closed_registration_message' => 'Message if registrations are closed',	// TODO
		'cookie-duration' => array(
			'help' => 'másodpercekben',
			'number' => 'Bejelentkezve maradás időtartam',
		),
		'default_closed_registration_message' => 'This server does not accept new registrations at the moment.',	// TODO
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
