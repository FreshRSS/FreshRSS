<?php

return array(
	'access' => array(
		'denied' => 'You don’t have permission to access this page',
		'not_found' => 'You are looking for a page that doesn’t exist',
	),
	'admin' => array(
		'optimization_complete' => 'Optimization complete',
	),
	'api' => array(
		'password' => array(
			'failed' => 'Your password cannot be modified',
			'updated' => 'Your password has been modified',
		),
	),
	'auth' => array(
		'form' => array(
			'not_set' => 'A problem occurred during authentication system configuration. Please try again later.',
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
		'error' => 'An error occurred while saving configuration',
		'query_created' => 'Query "%s" has been created.',
		'shortcuts_updated' => 'Shortcuts have been updated',
		'updated' => 'Configuration has been updated',
	),
	'extensions' => array(
		'already_enabled' => '%s is already enabled',
		'cannot_remove' => '%s cannot be removed',
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
		'removed' => '%s removed',
	),
	'import_export' => array(
		'export_no_zip_extension' => 'The ZIP extension is not present on your server. Please try to export files one by one.',
		'feeds_imported' => 'Your feeds have been imported and will now be updated',
		'feeds_imported_with_errors' => 'Your feeds have been imported, but some errors occurred',
		'file_cannot_be_uploaded' => 'File cannot be uploaded!',
		'no_zip_extension' => 'The ZIP extension is not present on your server.',
		'zip_error' => 'An error occurred during ZIP import.',
	),
	'profile' => array(
		'error' => 'Your profile cannot be modified',
		'updated' => 'Your profile has been modified',
	),
	'sub' => array(
		'actualize' => 'Updating',
		'articles' => array(
			'marked_read' => 'The selected articles have been marked as read.',
			'marked_unread' => 'The articles have been marked as unread.',
		),
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
			'cache_cleared' => '<em>%s</em> cache has been cleared',
			'deleted' => 'Feed has been deleted',
			'error' => 'Feed cannot be updated',
			'internal_problem' => 'The newsfeed could not be added. <a href="%s">Check FreshRSS logs</a> for details. You can try force adding by appending <code>#force_feed</code> to the URL.',
			'invalid_url' => 'URL <em>%s</em> is invalid',
			'n_actualized' => '%d feeds have been updated',
			'n_entries_deleted' => '%d articles have been deleted',
			'no_refresh' => 'There are no feeds to refresh',
			'not_added' => '<em>%s</em> could not be added',
			'not_found' => 'Feed cannot be found',
			'over_max' => 'You have reached your limit of feeds (%d)',
			'reloaded' => '<em>%s</em> has been reloaded',
			'selector_preview' => array(
				'http_error' => 'Failed to load website content.',
				'no_entries' => 'There are no articles in this feed. You need at least one article to create a preview.',
				'no_feed' => 'Internal error (feed cannot be found).',
				'no_result' => 'The selector didn\'t match anything. As a fallback the original feed text will be displayed instead.',
				'selector_empty' => 'The selector is empty. You need to define one to create a preview.',
			),
			'updated' => 'Feed has been updated',
		),
		'purge_completed' => 'Purge completed (%d articles deleted)',
	),
	'tag' => array(
		'created' => 'Tag "%s" has been created.',
		'name_exists' => 'Tag name already exists.',
		'renamed' => 'Tag "%s" has been renamed to "%s".',
	),
	'update' => array(
		'can_apply' => 'FreshRSS will now be updated to the <strong>version %s</strong>.',
		'error' => 'The update process has encountered an error: %s',
		'file_is_nok' => 'New <strong>version %s</strong> available, but check permissions on <em>%s</em> directory. HTTP server must have have write permission',
		'finished' => 'Update complete!',
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
);
