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
	'action' => array(
		'finish' => 'Telepítés befejeződött',
		'fix_errors_before' => 'Javíts meg minden hibát mielőtt továbblépnél a következő lépésre.',
		'keep_install' => 'Előző konfiguráció megtartása',
		'next_step' => 'Ugrás a következő lépésre',
		'reinstall' => 'FreshRSS újratelepítése',
	),
	'bdd' => array(
		'_' => 'Adatbázis',
		'conf' => array(
			'_' => 'Adatbázis beállítása',
			'ko' => 'Ellenőrizd az adatbázis konfigurációdat.',
			'ok' => 'Adatbázis konfiguráció elmentve.',
		),
		'host' => 'Host',	// IGNORE
		'password' => 'Adatbázis jelszó',
		'prefix' => 'Táblázat előtagja (Table prefix)',
		'type' => 'Adatbázis típusa',
		'username' => 'Adatbázis felhasználói név',
	),
	'check' => array(
		'_' => 'Ellenőrzés',
		'already_installed' => 'Azt észleltük, hogy a FreshRSS már telepítve van!',
		'cache' => array(
			'nok' => 'Ellenőrizd a jogosultságokat a(z) <em>%1$s</em> könyvtáron a(z) <em>%2$s</em> felhasználónak. A HTTP szervernek szüksége van írási jogosultságra.',
			'ok' => 'A cache könyvtár jogosultságai rendben vannak.',
		),
		'ctype' => array(
			'nok' => 'Nem található a karakter típus ellenőrzésre való könyvtár (php-ctype).',
			'ok' => 'A karakter típus ellenőrzésre való könyvtár telepítve van (ctype).',
		),
		'curl' => array(
			'nok' => 'Nem található a cURL könyvtár (php-curl csomag).',
			'ok' => 'A cURL könyvtár telepítve van.',
		),
		'data' => array(
			'nok' => 'Ellenőrizd a(z) <em>%1$s</em> könyvtáron a(z) <em>%2$s</em> felhasználónak. A HTTP szervernek szüksége van írási jogosultságra.',
			'ok' => 'A data könyvtár jogosultságai rendben vannak.',
		),
		'dom' => array(
			'nok' => 'A DOM böngészéséhez nem található a könyvtár.',
			'ok' => 'A DOM böngészésére való könyvtár telepítve van.',
		),
		'favicons' => array(
			'nok' => 'Ellenőrizd a(z) <em>%1$s</em> könyvtár jogosultságait a(z) <em>%2$s</em> felhasználónak. A HTTP szervernek szüksége van írási jogosultságra.',
			'ok' => 'A favicons könyvtár jogosultságai rendben vannak.',
		),
		'fileinfo' => array(
			'nok' => 'A PHP fileinfo könyvtár nem található (fileinfo csomag).',
			'ok' => 'A fileinfo könyvtár telepítve van.',
		),
		'json' => array(
			'nok' => 'Nem található a JSON elemző könyvtár.',
			'ok' => 'A JSON elemző könyvtár telepítve van.',
		),
		'mbstring' => array(
			'nok' => 'Az ajánlott mbstring könyvtár nem található a Unicode kódoláshoz',
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
			'nok' => 'A PHP verzió %s, de a FreshRSS számára szükséges verzió %s.',
			'ok' => 'A PHP verzió, %s, kompatibilis a FreshRSS-el.',
		),
		'reload' => 'Újra ellenőrzés',
		'tmp' => array(
			'nok' => 'Ellenőrizd a(z) <em>%1$s</em> könyvtár jogosultságait a(z) <em>%2$s</em> felhasználónak. A HTTP szervernek szüksége van írási jogosultságra.',
			'ok' => 'A temp könyvtár jogosultságai rendben vannak.',
		),
		'unknown_process_username' => 'ismeretlen',
		'users' => array(
			'nok' => 'Ellenőrizd a(z) <em>%1$s</em> könyvtár jogosultságait a(z) <em>%2$s</em> felhasználónak. A HTTP szervernek szüksége van írási jogosultságra.',
			'ok' => 'A users könyvtár jogosultságai rendben vannak.',
		),
		'xml' => array(
			'nok' => 'Nem található az XML elemző könyvtár.',
			'ok' => 'Az XML elemző könyvtár telepítve van.',
		),
	),
	'conf' => array(
		'_' => 'Általános beállítások',
		'ok' => 'Általános beállítások mentése megtörtént.',
	),
	'congratulations' => 'Gratulálunk!',
	'default_user' => array(
		'_' => 'Alapértelmezett felhasználó neve',
		'max_char' => 'maximum 16 alfanumerikus karakter',
	),
	'fix_errors_before' => 'Javíts meg minden hibát mielőtt továbblépnél a következő lépésre.',
	'javascript_is_better' => 'A FreshRSS sokkal jobban élvezhető ha a JavaScript engedélyezve van.',
	'js' => array(
		'confirm_reinstall' => 'Az előző konfiguráció elveszik ha újratelepíted a FreshRSS-t. Biztos vagy benne hogy folytatod?',
	),
	'language' => array(
		'_' => 'Nyelv',
		'choose' => 'Válassz egy nyelvet a FreshRSS felületéhez',
		'defined' => 'Nyelv beállítása megtörtént.',
	),
	'missing_applied_migrations' => 'Valami rosszul sült el; hozd létre az üres fájlt manuálisan <em>%s</em> .',
	'ok' => 'A telepítés sikeresen befejeződött.',
	'session' => array(
		'nok' => 'A web szerver helytelenül van konfigurálva a PHP session által igényelt sütikhez!',
	),
	'step' => 'Lépés %d',
	'steps' => 'Lépések',
	'this_is_the_end' => 'Itt a vége',
	'title' => 'Telepítés · FreshRSS',
);
