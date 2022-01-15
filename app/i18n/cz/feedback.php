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
		'denied' => 'Nemáte oprávnění přistupovat na tuto stránku',
		'not_found' => 'Hledáte stránku, která neexistuje',
	),
	'admin' => array(
		'optimization_complete' => 'Optimalizace dokončena',
	),
	'api' => array(
		'password' => array(
			'failed' => 'Vaše heslo nemůže být změněno',
			'updated' => 'Vaše heslo bylo změněno',
		),
	),
	'auth' => array(
		'login' => array(
			'invalid' => 'Přihlašovací údaje jsou neplatné',
			'success' => 'Jste přihlášeni',
		),
		'logout' => array(
			'success' => 'Jste odhlášeni',
		),
	),
	'conf' => array(
		'error' => 'Během ukládání nastavení došlo k chybě',
		'query_created' => 'Dotaz „%s“ byl vytvořen.',
		'shortcuts_updated' => 'Zkratky byly aktualizovány',
		'updated' => 'Nastavení bylo aktualizováno',
	),
	'extensions' => array(
		'already_enabled' => '%s je již povoleno',
		'cannot_remove' => '%s nelze odebrat',
		'disable' => array(
			'ko' => '%s nelze zakázat. Pro podrobnosti <a href="%s">zkontrolujte protokoly FreshRSS</a>.',
			'ok' => '%s je nyní zakázáno',
		),
		'enable' => array(
			'ko' => '%s nelze povolit. Pro podrobnosti <a href="%s">zkontrolujte protokoly FreshRSS</a>.',
			'ok' => '%s je nyní povoleno',
		),
		'no_access' => 'Nemáte přístup k %s',
		'not_enabled' => '%s není povoleno',
		'not_found' => '%s neexistuje',
		'removed' => '%s odebráno',
	),
	'import_export' => array(
		'export_no_zip_extension' => 'Na serveru není přítomno rozšíření ZIP. Zkuste exportovat soubory jeden po druhém.',
		'feeds_imported' => 'Vaše kanály byly naimportovány a budou nyní aktualizovány',
		'feeds_imported_with_errors' => 'Vaše kanály byly naimportovány, došlo ale k nějakým chybám',
		'file_cannot_be_uploaded' => 'Soubor nelze nahrát!',
		'no_zip_extension' => 'Na serveru není přítomno rozšíření ZIP.',
		'zip_error' => 'Během importu ZIP došlo k chybě.',
	),
	'profile' => array(
		'error' => 'Váš profil nelze změnit',
		'updated' => 'Váš profil byl změněn',
	),
	'sub' => array(
		'actualize' => 'Aktualizace',
		'articles' => array(
			'marked_read' => 'Vybrané články byly označeny jako přečtené.',
			'marked_unread' => 'Články byly označeny jako nepřečtené.',
		),
		'category' => array(
			'created' => 'Kategorie %s byla vytvořena.',
			'deleted' => 'Kategorie byla odstraněna.',
			'emptied' => 'Kategorie byla vyprázdněna',
			'error' => 'Kategorii nelze aktualizovat',
			'name_exists' => 'Název kategorie již existuje.',
			'no_id' => 'Musíte zadat ID kategorie.',
			'no_name' => 'Název kategorie nemůže být prázdný.',
			'not_delete_default' => 'Nemůžete odstranit výchozí kategorii!',
			'not_exist' => 'Tato kategorie neexistuje!',
			'over_max' => 'Dosáhli jste maximálního počtu kategorií (%d)',
			'updated' => 'Kategorie byla aktualizována.',
		),
		'feed' => array(
			'actualized' => '<em>%s</em> bylo aktualizováno',
			'actualizeds' => 'Kanály RSS byly aktualizovány',
			'added' => 'Kanál RSS <em>%s</em> byl přidán',
			'already_subscribed' => 'Již jste přihlášeni k odběru <em>%s</em>',
			'cache_cleared' => '<em>%s</em> mezipaměť byla vymazána',
			'deleted' => 'Kanál byl odstraněn',
			'error' => 'Kanál nelze aktualizovat',
			'internal_problem' => 'Informační kanál nelze přidat. Pro podrobnosti <a href="%s">zkontrolujte protokoly FreshRSS</a>. Můžete zkusit vynucení přidání připojením <code>#force_feed</code> k adrese URL.',
			'invalid_url' => 'Adresa URL <em>%s</em> je neplatná',
			'n_actualized' => '%d kanálů bylo aktualizováno',
			'n_entries_deleted' => '%d článků bylo odstraněno',
			'no_refresh' => 'Nejsou žádné kanály k obnovení',
			'not_added' => '<em>%s</em> nelze přidat',
			'not_found' => 'Kanál nelze nalézt',
			'over_max' => 'Dosáhli jste maximálního počtu kanálů (%d)',
			'reloaded' => '<em>%s</em> byl znovu načten',
			'selector_preview' => array(
				'http_error' => 'Nepodařilo se načíst obsah webové stránky.',
				'no_entries' => 'V tomto kanále nejsou žádné články. Pro vytvoření náhledu potřebujete alespoň jeden článek.',
				'no_feed' => 'Interní chyba (kanál nelze nalézt).',
				'no_result' => 'Přepínač ničemu neodpovídá. Jako záložní akce bude namísto toho zobrazen původní text kanálu.',
				'selector_empty' => 'Přepínač je prázdný. Pro vytvoření náhledu potřebujete alespoň jeden definovat.',
			),
			'updated' => 'Kanál byl aktualizován',
		),
		'purge_completed' => 'Vymazání dokončeno (odstraněno %d článků)',
	),
	'tag' => array(
		'created' => 'Štítek „%s“ byl vytvořen.',
		'name_exists' => 'Název štítku již existuje.',
		'renamed' => 'Štítek „%s“ byl přejmenován na „%s“.',
	),
	'update' => array(
		'can_apply' => 'FreshRSS bude nyní aktualizováno na <strong>verzi %s</strong>.',
		'error' => 'Během procesu aktualizace došlo k chybě: %s',
		'file_is_nok' => 'Je dostupná nová <strong>verze %s</strong>, ale zkontrolujte oprávnění adresáře <em>%s</em>. Server HTTP musí mít oprávnění pro zápis',
		'finished' => 'Aktualizace dokončena!',
		'none' => 'Není dostupná žádná aktualizace',
		'server_not_found' => 'Nelze nalézt server s aktualizací. [%s]',
	),
	'user' => array(
		'created' => array(
			'_' => 'Uživatel %s byl vytvořen',
			'error' => 'Uživatele %s nelze vytvořit',
		),
		'deleted' => array(
			'_' => 'Uživatel %s byl odstraněn',
			'error' => 'Uživatele %s nelze odstranit',
		),
		'updated' => array(
			'_' => 'Uživatel %s byl aktualizován',
			'error' => 'Uživatel %s nelze aktualizovat',
		),
	),
);
