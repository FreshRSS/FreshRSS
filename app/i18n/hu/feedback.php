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
	'access' => array(
		'denied' => 'Nincs jogosultságod megnézni ezt az oldalt',
		'not_found' => 'A kért oldal nem található',
	),
	'admin' => array(
		'optimization_complete' => 'Optimalizáció kész',
	),
	'api' => array(
		'password' => array(
			'failed' => 'A jelszó nem módosítható',
			'updated' => 'A jelszó módosítása megtörtént',
		),
	),
	'auth' => array(
		'login' => array(
			'invalid' => 'Érvénytelen belépés',
			'success' => 'Csatlakozott',
		),
		'logout' => array(
			'success' => 'Lecsatlakozott',
		),
	),
	'conf' => array(
		'error' => 'Hiba történt a konfiguráció mentése közben',
		'query_created' => 'A(z) „%s” lekérdezés létrehozása megtörtént.',
		'shortcuts_updated' => 'Gyorsgombok frissítve',
		'updated' => 'Beállítások frissítve',
	),
	'extensions' => array(
		'already_enabled' => 'A(z) %s már be van kapcsolva',
		'cannot_remove' => 'A(z) %s nem távolítható el',
		'disable' => array(
			'ko' => 'A(z) %s nem kapcsolható ki. <a href="%s">nézd meg a FreshRSS log-okat</a> a részletekért.',
			'ok' => 'A(z) %s kikapcsolása sikeres',
		),
		'enable' => array(
			'ko' => 'A(z) %s nem kapcsolható be. <a href="%s">nézd meg a FreshRSS log-okat</a> a részletekért.',
			'ok' => 'A(z) %s bekapcsolása sikeres',
		),
		'no_access' => 'Nincs hozzáférésed ehhez: %s',
		'not_enabled' => 'A(z) %s nincs bekapcsolva',
		'not_found' => 'A(z) %s nem létezik',
		'removed' => 'A(z) %s eltávolítva',
	),
	'import_export' => array(
		'export_no_zip_extension' => 'A ZIP kiterjesztés nem létezik a szerveren. Exportáld a fájlokat egyesével.',
		'feeds_imported' => 'A hírlisták importálása megtörtént és most frissítésre kerülnek / A hírlistáit importáltuk. Ha végzett az importálással, most rákattinthat a <i>Hírlisták frissítése</i> gombra.',
		'feeds_imported_with_errors' => 'A hírlisták importálása megtörtént, de néhány hiba történt / A hírlistáit importáltuk, de néhány hiba történt. Ha végzett az importálással, most rákattinthat a <i>Hírlisták frissítése</i> gombra.',
		'file_cannot_be_uploaded' => 'A fájl nem feltölthető!',
		'no_zip_extension' => 'A ZIP kiterjesztés nem létezik a szerveren.',
		'zip_error' => 'Hiba történt a ZIP feldolgozása közben.',
	),
	'profile' => array(
		'error' => 'A profilod nem módosítható',
		'updated' => 'A profilod módosítása megtörtént',
	),
	'sub' => array(
		'actualize' => 'Frissítés',
		'articles' => array(
			'marked_read' => 'A kiválasztott cikkek megjelölése olvasottként megtörtént.',
			'marked_unread' => 'A kiválasztott cikkek megjelölése olvasatlanként megtörtént.',
		),
		'category' => array(
			'created' => 'Kategória %s létrehozva.',
			'deleted' => 'Kategória törölve.',
			'emptied' => 'Kategória kiürítve',
			'error' => 'Kategória nem frissíthető',
			'name_exists' => 'Kategória név már létezik.',
			'no_id' => 'Meg kell adnod a kategória id-t.',
			'no_name' => 'Kategória név nem lehet üres.',
			'not_delete_default' => 'Nem törölheted az alapértelmezett kategóriát!',
			'not_exist' => 'A kategória nem létezik!',
			'over_max' => 'Elérted a maximális kategória számot (%d)',
			'updated' => 'Kategória frissítése megtörtént.',
		),
		'feed' => array(
			'actualized' => '<em>%s</em> frissítése megtörtént',
			'actualizeds' => 'RSS hírforrások frissítése megtörtént',
			'added' => 'RSS hírforrás <em>%s</em> hozzáadása megtörtént',
			'already_subscribed' => 'Már fel vagy iratkozva a(z) <em>%s</em> hírforrásra',
			'cache_cleared' => '<em>%s</em> gyorsítótára kiürítve',
			'deleted' => 'Hírforrás törlése megtörtént',
			'error' => 'Hírforrás frissítése nem lehetséges',
			'internal_problem' => 'A hírforrást nem sikerült hozzáadni. <a href="%s">Nézd meg a FreshRSS logokat</a> a részletekért. Megpróbálhatod mindenképp hozzáadni, ha az <code>#force_feed</code> szöveget az URL után írod.',
			'invalid_url' => 'URL <em>%s</em> érvénytelen',
			'n_actualized' => '%d hírforrások frissítése kész',
			'n_entries_deleted' => '%d cikk törlése kész',
			'no_refresh' => 'Nincs több frissíthető hírforrás',
			'not_added' => '<em>%s</em> nem adható hozzá',
			'not_found' => 'Hírforrás nem található',
			'over_max' => 'Elérted a maximális hírforrások számát (%d)',
			'reloaded' => '<em>%s</em> újratöltése kész',
			'selector_preview' => array(
				'http_error' => 'Weblap tartalom betöltése sikertelen',
				'no_entries' => 'Nincsenek cikkek ebben a hírforrásban. Legalább egy cikk szükséges az előnézet elkészítéséhez.',
				'no_feed' => 'Belső hiba (hírforrás nem található.',
				'no_result' => 'A kiválasztó nem egyezett semmivel. Az eredeti hírforrás szövege lesz megjelenítve helyette.',
				'selector_empty' => 'A kiválasztó üres. Meg kell határozni egyet, hogy az előnézet létrehozható legyen.',
			),
			'updated' => 'Hírforrás frissítve',
		),
		'purge_completed' => 'Törlés kész (%d cikkek törölve)',
	),
	'tag' => array(
		'created' => 'Címke „%s” létrehozva.',
		'error' => 'Nem sikerült a címke frissítése!',
		'name_exists' => 'Címke név már létezik.',
		'renamed' => 'Címke „%s” átnevezve „%s”.',
		'updated' => 'Címke frissítése megtörtént.',
	),
	'update' => array(
		'can_apply' => 'Egy FreshRSS frissítés elérhető : <strong>Verzió %s</strong>.',
		'error' => 'A frissítési folyamat hibába ütközött: %s',
		'file_is_nok' => 'Egy frissítés elérhető a FreshRSS-hez (<strong>Verzió %s</strong>), de ellenőrizd a jogosultságokat a(z) <em>%s</em> könyvtáron. A HTTP szervernek szüksége van írási jogosultságra.',
		'finished' => 'Frissítés kész!',
		'none' => 'Nem áll rendelkezésre új frissítés',
		'server_not_found' => 'Frissítési szerver nem található. [%s]',
	),
	'user' => array(
		'created' => array(
			'_' => 'Felhasználó %s létrehozva',
			'error' => 'Felhasználó %s nem lehet létrehozni',
		),
		'deleted' => array(
			'_' => 'Felhasználó %s törlése kész',
			'error' => 'Felhasználó %s nem lehet törölni',
		),
		'updated' => array(
			'_' => 'Felhasználó %s frissítése kész',
			'error' => 'Felhasználó %s nem lehet frissíteni',
		),
	),
);
