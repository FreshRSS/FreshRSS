<?php

return array(
	'admin' => array(
		'optimization_complete' => 'Optimisation complete',	//TODO
	),
	'access' => array(
		'denied' => 'You don’t have permission to access this page',	//TODO
		'not_found' => 'You are looking for a page which doesn’t exist',	//TODO
	),
	'auth' => array(
		'form' => array(
			'not_set' => 'A problem occured during authentication system configuration. Please retry later.',	//TODO
			'set' => 'Form is now your default authentication system.',	//TODO
		),
		'login' => array(
			'invalid' => 'Login is invalid',	//TODO
			'success' => 'You are connected',	//TODO
		),
		'logout' => array(
			'success' => 'You are disconnected',	//TODO
		),
		'no_password_set' => 'Administrator password hasn’t been set. This feature isn’t available.',	//TODO
	),
	'conf' => array(
		'error' => 'An error occurred during configuration saving',	//TODO
		'query_created' => 'Query "%s" has been created.',	//TODO
		'shortcuts_updated' => 'Shortcuts have been updated',	//TODO
		'updated' => 'Configuration has been updated',	//TODO
	),
	'extensions' => array(
		'already_enabled' => '%s is already enabled',	//TODO
		'disable' => array(
			'ko' => '%s cannot be disabled. <a href="%s">Check FreshRSS logs</a> for details.',	//TODO
			'ok' => '%s is now disabled',	//TODO
		),
		'enable' => array(
			'ko' => '%s cannot be enabled. <a href="%s">Check FreshRSS logs</a> for details.',	//TODO
			'ok' => '%s is now enabled',	//TODO
		),
		'no_access' => 'You have no access on %s',	//TODO
		'not_enabled' => '%s is not enabled yet',	//TODO
		'not_found' => '%s does not exist',	//TODO
	),
	'import_export' => array(
		'export_no_zip_extension' => 'ZIP extension is not present on your server. Please try to export files one by one.',	//TODO
		'feeds_imported' => 'Your feeds have been imported and will now be updated',	//TODO
		'feeds_imported_with_errors' => 'Your feeds have been imported but some errors occurred',	//TODO
		'file_cannot_be_uploaded' => 'File cannot be uploaded!',	//TODO
		'no_zip_extension' => 'ZIP extension is not present on your server.',	//TODO
		'zip_error' => 'An error occured during ZIP import.',	//TODO
	),
	'sub' => array(
		'actualize' => 'Actualise',	//TODO
		'articles' => array(
			'marked_read' => 'The articles have been marked as read.',	//TODO
			'marked_unread' => 'The articles have been marked as unread.',	//TODO
		),
		'category' => array(
			'created' => 'Category %s has been created.',	//TODO
			'deleted' => 'Category has been deleted.',	//TODO
			'emptied' => 'Category has been emptied',	//TODO
			'error' => 'Category cannot be updated',	//TODO
			'name_exists' => 'Category name already exists.',	//TODO
			'no_id' => 'You must precise the id of the category.',	//TODO
			'no_name' => 'Category name cannot be empty.',	//TODO
			'not_delete_default' => 'You cannot delete the default category!',	//TODO
			'not_exist' => 'The category does not exist!',	//TODO
			'over_max' => 'You have reached your limit of categories (%d)',	//TODO
			'updated' => 'Category has been updated.',	//TODO
		),
		'feed' => array(
			'actualized' => '<em>%s</em> has been updated',	//TODO
			'actualizeds' => 'RSS feeds have been updated',	//TODO
			'added' => 'RSS feed <em>%s</em> has been added',	//TODO
			'already_subscribed' => 'You have already subscribed to <em>%s</em>',	//TODO
			'deleted' => 'Feed has been deleted',	//TODO
			'error' => 'Feed cannot be updated',	//TODO
			'internal_problem' => 'The newsfeed could not be added. <a href="%s">Check FreshRSS logs</a> for details. You can try force adding by appending <code>#force_feed</code> to the URL.',	//TODO
			'invalid_url' => 'URL <em>%s</em> is invalid',	//TODO
			'n_actualized' => '%d feeds have been updated',	//TODO
			'n_entries_deleted' => '%d articles have been deleted',	//TODO
			'no_refresh' => 'There is no feed to refresh…',	//TODO
			'not_added' => '<em>%s</em> could not be added',	//TODO
			'over_max' => 'You have reached your limit of feeds (%d)',	//TODO
			'updated' => 'Feed has been updated',	//TODO
		),
		'purge_completed' => 'Purge completed (%d articles deleted)',	//TODO
	),
	'update' => array(
		'can_apply' => 'FreshRSS will now be updated to the <strong>version %s</strong>.',	//TODO
		'error' => 'The update process has encountered an error: %s',	//TODO
		'file_is_nok' => 'New <strong>version %s</strong> available, but check permissions on <em>%s</em> directory. HTTP server must have rights to write into',	//TODO
		'finished' => 'Update completed!',	//TODO
		'none' => 'No update to apply',	//TODO
		'server_not_found' => 'Update server cannot be found. [%s]',	//TODO
	),
	'user' => array(
		'created' => array(
			'_' => 'User %s has been created',	//TODO
			'error' => 'User %s cannot be created',	//TODO
		),
		'deleted' => array(
			'_' => 'User %s has been deleted',	//TODO
			'error' => 'User %s cannot be deleted',	//TODO
		),
		'updated' => array(
			'_' => 'User %s has been updated', // TODO
			'error' => 'User %s has not been updated', // TODO
		),
	),
	'profile' => array(
		'error' => 'Your profile cannot be modified',	//TODO
		'updated' => 'Your profile has been modified',	//TODO
	),
);
