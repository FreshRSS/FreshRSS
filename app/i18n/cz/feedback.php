<?php

return array(
	'access' => array(
		'denied' => 'Nemáte oprávnění přistupovat na tuto stránku',
		'not_found' => 'Tato stránka neexistuje',
	),
	'admin' => array(
		'optimization_complete' => 'Optimalizace dokončena',
	),
	'api' => array(
		'password' => array(
			'failed' => 'Your password cannot be modified',	// TODO - Translation
			'updated' => 'Your password has been modified',	// TODO - Translation
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
		'not_enabled' => '%s není ještě zapnut',
		'not_found' => '%s neexistuje',
		'no_access' => 'Nemáte přístup k %s',
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
			'marked_read' => 'The selected articles have been marked as read.',	// TODO - Translation
			'marked_unread' => 'The articles have been marked as unread.',	// TODO - Translation
		),
		'category' => array(
			'created' => 'Kategorie %s byla vytvořena.',
			'deleted' => 'Kategorie byla smazána.',
			'emptied' => 'Kategorie byla vyprázdněna',
			'error' => 'Kategorii nelze aktualizovat',
			'name_exists' => 'Název kategorie již existuje.',
			'not_delete_default' => 'Nelze smazat výchozí kategorii!',
			'not_exist' => 'Tato kategorie neexistuje!',
			'no_id' => 'Musíte upřesnit id kategorie.',
			'no_name' => 'Název kategorie nemůže být prázdný.',
			'over_max' => 'Dosáhl jste maximálního počtu kategorií (%d)',
			'updated' => 'Kategorie byla aktualizována.',
		),
		'feed' => array(
			'actualized' => '<em>%s</em> bylo aktualizováno',
			'actualizeds' => 'RSS kanály byly aktualizovány',
			'added' => 'RSS kanál <em>%s</em> byl přidán',
			'already_subscribed' => 'Již jste přihlášen k odběru <em>%s</em>',
			'cache_cleared' => '<em>%s</em> cache has been cleared',	// TODO - Translation
			'deleted' => 'Kanál byl smazán',
			'error' => 'Kanál nelze aktualizovat',
			'internal_problem' => 'RSS kanál nelze přidat. Pro detaily <a href="%s">zkontrolujte logy FreshRSS</a>.',
			'invalid_url' => 'URL <em>%s</em> není platné',
			'not_added' => '<em>%s</em> nemůže být přidán',
			'not_found' => 'Feed cannot be found',	// TODO - Translation
			'no_refresh' => 'Nelze obnovit žádné kanály…',
			'n_actualized' => '%d kanálů bylo aktualizováno',
			'n_entries_deleted' => '%d článků bylo smazáno',
			'over_max' => 'Dosáhl jste maximálního počtu kanálů (%d)',
			'reloaded' => '<em>%s</em> has been reloaded',	// TODO - Translation
			'selector_preview' => array(
				'http_error' => 'Failed to load website content.',	// TODO - Translation
				'no_entries' => 'There is no entries in your feed. You need at least one entry to create a preview.',	// TODO - Translation
				'no_feed' => 'Internal error (no feed to entry).',	// TODO - Translation
				'no_result' => 'The selector didn\'t match anything. As a fallback the original feed text will be displayed instead.',	// TODO - Translation
				'selector_empty' => 'The selector is empty. You need to define one to create a preview.',	// TODO - Translation
			),
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
			'error' => 'Uživatele %s nelze vytvořit',
			'_' => 'Uživatel %s byl vytvořen',
		),
		'deleted' => array(
			'error' => 'Uživatele %s nelze smazat',
			'_' => 'Uživatel %s byl smazán',
		),
		'updated' => array(
			'error' => 'User %s has not been updated',	// TODO - Translation
			'_' => 'User %s has been updated',	// TODO - Translation
		),
	),
);
