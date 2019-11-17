<?php

return array(
	'admin' => array(
		'optimization_complete' => 'Optimalizace dokončena',
	),
	'access' => array(
		'denied' => 'Nemáte oprávnění přistupovat na tuto stránku',
		'not_found' => 'Tato stránka neexistuje',
	),
	'api' => array(
		'password' => array(
			'failed' => 'Your password cannot be modified', // TODO - Translation
			'updated' => 'Your password has been modified', // TODO - Translation
		),
	),
	'auth' => array(
		'form' => array(
			'not_set' => 'Nastal problém s konfigurací přihlašovacího systému. Zkuste to prosím později.',
			'set' => 'Webový formulář je nyní výchozí přihlašovací systém.',
		),
		'login' => array(
			'invalid' => 'Login není platný',
			'success' => 'Jste přihlášen',
		),
		'logout' => array(
			'success' => 'Jste odhlášen',
		),
		'no_password_set' => 'Heslo administrátora nebylo nastaveno. Tato funkce není k dispozici.',
	),
	'conf' => array(
		'error' => 'Během ukládání nastavení došlo k chybě',
		'query_created' => 'Dotaz "%s" byl vytvořen.',
		'shortcuts_updated' => 'Zkratky byly aktualizovány',
		'updated' => 'Nastavení bylo aktualizováno',
	),
	'extensions' => array(
		'already_enabled' => '%s je již zapnut',
		'disable' => array(
			'ko' => '%s nelze vypnout. Pro více detailů <a href="%s">zkontrolujte logy FreshRSS</a>.',
			'ok' => '%s je nyní vypnut',
		),
		'enable' => array(
			'ko' => '%s nelze zapnout. Pro více detailů <a href="%s">zkontrolujte logy FreshRSS</a>.',
			'ok' => '%s je nyní zapnut',
		),
		'no_access' => 'Nemáte přístup k %s',
		'not_enabled' => '%s není ještě zapnut',
		'not_found' => '%s neexistuje',
	),
	'import_export' => array(
		'export_no_zip_extension' => 'Na serveru není naistalována podpora ZIP. Zkuste prosím exportovat soubory jeden po druhém.',
		'feeds_imported' => 'Vaše kanály byly naimportovány a nyní budou aktualizovány',
		'feeds_imported_with_errors' => 'Vaše kanály byly naimportovány, došlo ale k nějakým chybám',
		'file_cannot_be_uploaded' => 'Soubor nelze nahrát!',
		'no_zip_extension' => 'Na serveru není naistalována podpora ZIP.',
		'zip_error' => 'Během importu ZIP souboru došlo k chybě.',
	),
	'profile' => array(
		'error' => 'Váš profil nelze změnit',
		'updated' => 'Váš profil byl změněn',
	),
	'sub' => array(
		'actualize' => 'Aktualizovat',
		'articles' => array(
			'marked_read' => 'The selected articles have been marked as read.',	//TODO - Translation
			'marked_unread' => 'The articles have been marked as unread.',	//TODO - Translation
		),
		'category' => array(
			'created' => 'Kategorie %s byla vytvořena.',
			'deleted' => 'Kategorie byla smazána.',
			'emptied' => 'Kategorie byla vyprázdněna',
			'error' => 'Kategorii nelze aktualizovat',
			'name_exists' => 'Název kategorie již existuje.',
			'no_id' => 'Musíte upřesnit id kategorie.',
			'no_name' => 'Název kategorie nemůže být prázdný.',
			'not_delete_default' => 'Nelze smazat výchozí kategorii!',
			'not_exist' => 'Tato kategorie neexistuje!',
			'over_max' => 'Dosáhl jste maximálního počtu kategorií (%d)',
			'updated' => 'Kategorie byla aktualizována.',
		),
		'feed' => array(
			'actualized' => '<em>%s</em> bylo aktualizováno',
			'actualizeds' => 'RSS kanály byly aktualizovány',
			'added' => 'RSS kanál <em>%s</em> byl přidán',
			'already_subscribed' => 'Již jste přihlášen k odběru <em>%s</em>',
			'deleted' => 'Kanál byl smazán',
			'error' => 'Kanál nelze aktualizovat',
			'internal_problem' => 'RSS kanál nelze přidat. Pro detaily <a href="%s">zkontrolujte logy FreshRSS</a>.',	//TODO - Translation
			'invalid_url' => 'URL <em>%s</em> není platné',
			'n_actualized' => '%d kanálů bylo aktualizováno',
			'n_entries_deleted' => '%d článků bylo smazáno',
			'no_refresh' => 'Nelze obnovit žádné kanály…',
			'not_added' => '<em>%s</em> nemůže být přidán',
			'over_max' => 'Dosáhl jste maximálního počtu kanálů (%d)',
			'updated' => 'Kanál byl aktualizován',
		),
		'purge_completed' => 'Vyprázdněno (smazáno %d článků)',
	),
	'update' => array(
		'can_apply' => 'FreshRSS bude nyní upgradováno na <strong>verzi %s</strong>.',
		'error' => 'Během upgrade došlo k chybě: %s',
		'file_is_nok' => '<strong>Verzi %s</strong>. Zkontrolujte oprávnění adresáře <em>%s</em>. HTTP server musí mít do tohoto adresáře práva zápisu',
		'finished' => 'Upgrade hotov!',
		'none' => 'Novější verze není k dispozici',
		'server_not_found' => 'Nelze nalézt server s instalačním souborem. [%s]',
	),
	'user' => array(
		'created' => array(
			'_' => 'Uživatel %s byl vytvořen',
			'error' => 'Uživatele %s nelze vytvořit',
		),
		'deleted' => array(
			'_' => 'Uživatel %s byl smazán',
			'error' => 'Uživatele %s nelze smazat',
		),
		'updated' => array(
			'_' => 'User %s has been updated',	//TODO - Translation
			'error' => 'User %s has not been updated',	//TODO - Translation
		),
	),
);
