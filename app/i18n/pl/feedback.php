<?php

return array(
	'access' => array(
		'denied' => 'Nie masz uprawnień dostępu do tej strony',
		'not_found' => 'You are looking for a page that doesn’t exist',	// TODO - Translation
	),
	'admin' => array(
		'optimization_complete' => 'Optymizacja ukończona',
	),
	'api' => array(
		'password' => array(
			'failed' => 'Your password cannot be modified',	// TODO - Translation
			'updated' => 'Your password has been modified',	// TODO - Translation
		),
	),
	'auth' => array(
		'form' => array(
			'not_set' => 'A problem occurred during authentication system configuration. Please try again later.',	// TODO - Translation
			'set' => 'Form is now your default authentication system.',	// TODO - Translation
		),
		'login' => array(
			'invalid' => 'Niepoprawne dane logowania',
			'success' => 'Zalogowałeś się',
		),
		'logout' => array(
			'success' => 'Zostałeś wylogowany',
		),
		'no_password_set' => 'Administrator password hasn’t been set. This feature isn’t available.',	// TODO - Translation
	),
	'conf' => array(
		'error' => 'An error occurred while saving configuration',	// TODO - Translation
		'query_created' => 'Query "%s" has been created.',	// TODO - Translation
		'shortcuts_updated' => 'Shortcuts have been updated',	// TODO - Translation
		'updated' => 'Ustawienia zostały zaktualizowane',
	),
	'extensions' => array(
		'already_enabled' => '%s is already enabled',	// TODO - Translation
		'cannot_remove' => '%s cannot be removed',	// TODO - Translation
		'disable' => array(
			'ko' => '%s cannot be disabled. <a href="%s">Check FreshRSS logs</a> for details.',	// TODO - Translation
			'ok' => '%s is now disabled',	// TODO - Translation
		),
		'enable' => array(
			'ko' => '%s cannot be enabled. <a href="%s">Check FreshRSS logs</a> for details.',	// TODO - Translation
			'ok' => '%s is now enabled',	// TODO - Translation
		),
		'no_access' => 'You have no access on %s',	// TODO - Translation
		'not_enabled' => '%s is not enabled',	// TODO - Translation
		'not_found' => '%s does not exist',	// TODO - Translation
		'removed' => '%s removed',	// TODO - Translation
	),
	'import_export' => array(
		'export_no_zip_extension' => 'The ZIP extension is not present on your server. Please try to export files one by one.',	// TODO - Translation
		'feeds_imported' => 'Your feeds have been imported and will now be updated',	// TODO - Translation
		'feeds_imported_with_errors' => 'Your feeds have been imported, but some errors occurred',	// TODO - Translation
		'file_cannot_be_uploaded' => 'File cannot be uploaded!',	// TODO - Translation
		'no_zip_extension' => 'The ZIP extension is not present on your server.',	// TODO - Translation
		'zip_error' => 'An error occurred during ZIP import.',	// TODO - Translation
	),
	'profile' => array(
		'error' => 'Your profile cannot be modified',	// TODO - Translation
		'updated' => 'Your profile has been modified',	// TODO - Translation
	),
	'sub' => array(
		'actualize' => 'Aktualizacja',
		'articles' => array(
			'marked_read' => 'Wiadomości zostały oznaczone jako przeczytane.',
			'marked_unread' => 'Wiadomości zostały oznaczone jako nieprzeczytane.',
		),
		'category' => array(
			'created' => 'Category %s has been created.',	// TODO - Translation
			'deleted' => 'Category has been deleted.',	// TODO - Translation
			'emptied' => 'Category has been emptied',	// TODO - Translation
			'error' => 'Category cannot be updated',	// TODO - Translation
			'name_exists' => 'Category name already exists.',	// TODO - Translation
			'no_id' => 'You must specify the id of the category.',	// TODO - Translation
			'no_name' => 'Category name cannot be empty.',	// TODO - Translation
			'not_delete_default' => 'You cannot delete the default category!',	// TODO - Translation
			'not_exist' => 'The category does not exist!',	// TODO - Translation
			'over_max' => 'You have reached your limit of categories (%d)',	// TODO - Translation
			'updated' => 'Category has been updated.',	// TODO - Translation
		),
		'feed' => array(
			'actualized' => '<em>%s</em> has been updated',	// TODO - Translation
			'actualizeds' => 'RSS feeds have been updated',	// TODO - Translation
			'added' => 'RSS feed <em>%s</em> has been added',	// TODO - Translation
			'already_subscribed' => 'You have already subscribed to <em>%s</em>',	// TODO - Translation
			'cache_cleared' => '<em>%s</em> cache has been cleared',	// TODO - Translation
			'deleted' => 'Feed has been deleted',	// TODO - Translation
			'error' => 'Feed cannot be updated',	// TODO - Translation
			'internal_problem' => 'The newsfeed could not be added. <a href="%s">Check FreshRSS logs</a> for details. You can try force adding by appending <code>#force_feed</code> to the URL.',	// TODO - Translation
			'invalid_url' => 'URL <em>%s</em> is invalid',	// TODO - Translation
			'n_actualized' => '%d feeds have been updated',	// TODO - Translation
			'n_entries_deleted' => '%d articles have been deleted',	// TODO - Translation
			'no_refresh' => 'There are no feeds to refresh',	// TODO - Translation
			'not_added' => '<em>%s</em> could not be added',	// TODO - Translation
			'not_found' => 'Feed cannot be found',	// TODO - Translation
			'over_max' => 'You have reached your limit of feeds (%d)',	// TODO - Translation
			'reloaded' => '<em>%s</em> has been reloaded',	// TODO - Translation
			'selector_preview' => array(
				'http_error' => 'Nie udało się załadować zawartości strony.',
				'no_entries' => 'Nie ma wiadomości na tym kanale. Potrzeba przynajmniej jednej wiadomości aby podgląd był dostępny.',
				'no_feed' => 'Błąd wewnętrzny (kanał nie został odnaleziony).',
				'no_result' => 'Selektor nie pasuje do żadnego elementu. W zastępstwie zostanie pokazana pierwotna zawartość kanału.',
				'selector_empty' => 'Selektor jest pusty. Aby podgląd był dostępny selektor musi być zdefiniowany.',
			),
			'updated' => 'Ustawienia kanału zostały zaktualizowane',
		),
		'purge_completed' => 'Purge completed (%d articles deleted)',	// TODO - Translation
	),
	'update' => array(
		'can_apply' => 'FreshRSS zostanie zaktualizowany do <strong>wersji %s</strong>.',
		'error' => 'Proces aktualizacji napotkał błąd: %s',
		'file_is_nok' => 'Nowa <strong>wersja %s</strong> jest dostępna, ale należy sprawdzić uprawnienia katalogu <em>%s</em>. Serwer HTTP musi mieć możliwość zapisu',
		'finished' => 'Aktualizacja ukończona!',
		'none' => 'Brak dostępnych aktualizacji',
		'server_not_found' => 'Serwer aktualizacji nie może zostać odnaleziony. [%s]',
	),
	'user' => array(
		'created' => array(
			'_' => 'User %s has been created',	// TODO - Translation
			'error' => 'User %s cannot be created',	// TODO - Translation
		),
		'deleted' => array(
			'_' => 'User %s has been deleted',	// TODO - Translation
			'error' => 'User %s cannot be deleted',	// TODO - Translation
		),
		'updated' => array(
			'_' => 'User %s has been updated',	// TODO - Translation
			'error' => 'User %s has not been updated',	// TODO - Translation
		),
	),
);
