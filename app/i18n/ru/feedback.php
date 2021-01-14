<?php

return array(
	'access' => array(
		'denied' => 'You don’t have permission to access this page',	// TODO - Translation
		'not_found' => 'You are looking for a page that doesn’t exist',	// TODO - Translation
	),
	'admin' => array(
		'optimization_complete' => 'Optimisation complete',
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
			'invalid' => 'Login is invalid',	// TODO - Translation
			'success' => 'You are connected',	// TODO - Translation
		),
		'logout' => array(
			'success' => 'You are disconnected',	// TODO - Translation
		),
		'no_password_set' => 'Administrator password hasn’t been set. This feature isn’t available.',	// TODO - Translation
	),
	'conf' => array(
		'error' => 'An error occurred while saving configuration',	// TODO - Translation
		'query_created' => 'Query "%s" has been created.',	// TODO - Translation
		'shortcuts_updated' => 'Shortcuts have been updated',	// TODO - Translation
		'updated' => 'Configuration has been updated',	// TODO - Translation
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
		'not_enabled' => '%s is not enabled yet',
		'not_found' => '%s does not exist',	// TODO - Translation
		'removed' => '%s removed',	// TODO - Translation
	),
	'import_export' => array(
		'export_no_zip_extension' => 'The ZIP extension is not present on your server. Please try to export files one by one.',	// TODO - Translation
		'feeds_imported' => 'Your feeds have been imported and will now be updated',	// TODO - Translation
		'feeds_imported_with_errors' => 'Your feeds have been imported but some errors occurred',
		'file_cannot_be_uploaded' => 'File cannot be uploaded!',	// TODO - Translation
		'no_zip_extension' => 'The ZIP extension is not present on your server.',	// TODO - Translation
		'zip_error' => 'An error occurred during ZIP import.',	// TODO - Translation
	),
	'profile' => array(
		'error' => 'Your profile cannot be modified',	// TODO - Translation
		'updated' => 'Your profile has been modified',	// TODO - Translation
	),
	'sub' => array(
		'actualize' => 'Actualise',
		'articles' => array(
			'marked_read' => 'The selected articles have been marked as read.',	// TODO - Translation
			'marked_unread' => 'The articles have been marked as unread.',	// TODO - Translation
		),
		'category' => array(
			'created' => 'Category %s has been created.',	// TODO - Translation
			'deleted' => 'Category has been deleted.',	// TODO - Translation
			'emptied' => 'Category has been emptied',	// TODO - Translation
			'error' => 'Category cannot be updated',	// TODO - Translation
			'name_exists' => 'Category name already exists.',	// TODO - Translation
			'no_id' => 'You must precise the id of the category.',
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
				'http_error' => 'Failed to load website content.',	// TODO - Translation
				'no_entries' => 'There are no articles in this feed. You need at least one article to create a preview.',	// TODO - Translation
				'no_feed' => 'Internal error (feed cannot be found).',	// TODO - Translation
				'no_result' => 'The selector didn\'t match anything. As a fallback the original feed text will be displayed instead.',	// TODO - Translation
				'selector_empty' => 'The selector is empty. You need to define one to create a preview.',	// TODO - Translation
			),
			'updated' => 'Feed has been updated',	// TODO - Translation
		),
		'purge_completed' => 'Purge completed (%d articles deleted)',	// TODO - Translation
	),
	'tag' => array(
		'created' => 'Tag "%s" has been created.',	// TODO - Translation
		'name_exists' => 'Tag name already exists.',	// TODO - Translation
		'renamed' => 'Tag "%s" has been renamed to "%s".',	// TODO - Translation
	),
	'update' => array(
		'can_apply' => 'FreshRSS will now be updated to the <strong>version %s</strong>.',	// TODO - Translation
		'error' => 'The update process has encountered an error: %s',	// TODO - Translation
		'file_is_nok' => 'New <strong>version %s</strong> available, but check permissions on <em>%s</em> directory. HTTP server must have have write permission',	// TODO - Translation
		'finished' => 'Update complete!',	// TODO - Translation
		'none' => 'No update to apply',	// TODO - Translation
		'server_not_found' => 'Update server cannot be found. [%s]',	// TODO - Translation
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
