<?php

return array(
	'admin' => array(
		'optimization_complete' => 'Optimization complete',
	),
	'access' => array(
		'denied' => 'You don’t have permission to access this page',
		'not_found' => 'You are looking for a page which doesn’t exist',
	),
	'auth' => array(
		'form' => array(
			'not_set' => 'A problem occured during authentication system configuration. Please retry later.',
			'set' => 'Form is now your default authentication system.',
		),
		'login' => array(
			'invalid' => 'Login is invalid',
			'success' => 'You are connected',
		),
		'logout' => array(
			'success' => 'You are disconnected',
		),
		'no_password_set' => 'Administrator password hasn’t been set. This feature isn’t available.',
	),
	'conf' => array(
		'error' => 'An error occurred during configuration saving',
		'query_created' => 'Query "%s" has been created.',
		'shortcuts_updated' => 'Shortcuts have been updated',
		'updated' => 'Configuration has been updated',
	),
	'extensions' => array(
		'already_enabled' => '%s is already enabled',
		'disable' => array(
			'ko' => '%s cannot be disabled. <a href="%s">Check FreshRSS logs</a> for details.',
			'ok' => '%s is now disabled',
		),
		'enable' => array(
			'ko' => '%s cannot be enabled. <a href="%s">Check FreshRSS logs</a> for details.',
			'ok' => '%s is now enabled',
		),
		'no_access' => 'You have no access on %s',
		'not_enabled' => '%s is not enabled',
		'not_found' => '%s does not exist',
	),
	'import_export' => array(
		'export_no_zip_extension' => 'ZIP extension is not present on your server. Please try to export files one by one.',
		'feeds_imported' => 'Your feeds have been imported and will now be updated',
		'feeds_imported_with_errors' => 'Your feeds have been imported, but some errors occurred',
		'file_cannot_be_uploaded' => 'File cannot be uploaded!',
		'no_zip_extension' => 'ZIP extension is not present on your server.',
		'zip_error' => 'An error occured during ZIP import.',
	),
	'sub' => array(
		'actualize' => 'Updating',
		'category' => array(
			'created' => 'Category %s has been created.',
			'deleted' => 'Category has been deleted.',
			'emptied' => 'Category has been emptied',
			'error' => 'Category cannot be updated',
			'name_exists' => 'Category name already exists.',
			'no_id' => 'You must specify the id of the category.',
			'no_name' => 'Category name cannot be empty.',
			'not_delete_default' => 'You cannot delete the default category!',
			'not_exist' => 'The category does not exist!',
			'over_max' => 'You have reached your limit of categories (%d)',
			'updated' => 'Category has been updated.',
		),
		'feed' => array(
			'actualized' => '<em>%s</em> has been updated',
			'actualizeds' => 'RSS feeds have been updated',
			'added' => 'RSS feed <em>%s</em> has been added',
			'already_subscribed' => 'You have already subscribed to <em>%s</em>',
			'deleted' => 'Feed has been deleted',
			'error' => 'Feed cannot be updated',
			'internal_problem' => 'The newsfeed could not be added. <a href="%s">Check FreshRSS logs</a> for details. You can try force adding by appending <code>#force_feed</code> to the URL.',
			'invalid_url' => 'URL <em>%s</em> is invalid',
			'marked_read' => 'Feeds have been marked as read',
			'n_actualized' => '%d feeds have been updated',
			'n_entries_deleted' => '%d articles have been deleted',
			'no_refresh' => 'There is no feed to refresh…',
			'not_added' => '<em>%s</em> could not be added',
			'over_max' => 'You have reached your limit of feeds (%d)',
			'updated' => 'Feed has been updated',
		),
		'purge_completed' => 'Purge completed (%d articles deleted)',
	),
	'update' => array(
		'can_apply' => 'FreshRSS will now be updated to the <strong>version %s</strong>.',
		'error' => 'The update process has encountered an error: %s',
		'file_is_nok' => 'New <strong>version %s</strong> available, but check permissions on <em>%s</em> directory. HTTP server must have rights to write into',
		'finished' => 'Update completed!',
		'none' => 'No update to apply',
		'server_not_found' => 'Update server cannot be found. [%s]',
	),
	'user' => array(
		'created' => array(
			'_' => 'User %s has been created',
			'error' => 'User %s cannot be created',
		),
		'deleted' => array(
			'_' => 'User %s has been deleted',
			'error' => 'User %s cannot be deleted',
		),
		'updated' => array(
			'_' => 'User %s has been updated',
			'error' => 'User %s has not been updated',
		),
	),
	'profile' => array(
		'error' => 'Your profile cannot be modified',
		'updated' => 'Your profile has been modified',
	),
);
