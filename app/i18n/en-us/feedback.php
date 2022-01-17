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
		'denied' => 'You don’t have permission to access this page',	// IGNORE
		'not_found' => 'You are looking for a page that doesn’t exist',	// IGNORE
	),
	'admin' => array(
		'optimization_complete' => 'Optimization complete',	// IGNORE
	),
	'api' => array(
		'password' => array(
			'failed' => 'Your password cannot be modified',	// IGNORE
			'updated' => 'Your password has been modified',	// IGNORE
		),
	),
	'auth' => array(
		'login' => array(
			'invalid' => 'Login is invalid',	// IGNORE
			'success' => 'You are connected',	// IGNORE
		),
		'logout' => array(
			'success' => 'You are disconnected',	// IGNORE
		),
	),
	'conf' => array(
		'error' => 'An error occurred while saving configuration',	// IGNORE
		'query_created' => 'Query "%s" has been created.',	// IGNORE
		'shortcuts_updated' => 'Shortcuts have been updated',	// IGNORE
		'updated' => 'Configuration has been updated',	// IGNORE
	),
	'extensions' => array(
		'already_enabled' => '%s is already enabled',	// IGNORE
		'cannot_remove' => '%s cannot be removed',	// IGNORE
		'disable' => array(
			'ko' => '%s cannot be disabled. <a href="%s">Check FreshRSS logs</a> for details.',	// IGNORE
			'ok' => '%s is now disabled',	// IGNORE
		),
		'enable' => array(
			'ko' => '%s cannot be enabled. <a href="%s">Check FreshRSS logs</a> for details.',	// IGNORE
			'ok' => '%s is now enabled',	// IGNORE
		),
		'no_access' => 'You have no access on %s',	// IGNORE
		'not_enabled' => '%s is not enabled',	// IGNORE
		'not_found' => '%s does not exist',	// IGNORE
		'removed' => '%s removed',	// IGNORE
	),
	'import_export' => array(
		'export_no_zip_extension' => 'The ZIP extension is not present on your server. Please try to export files one by one.',	// IGNORE
		'feeds_imported' => 'Your feeds have been imported and will now be updated',	// IGNORE
		'feeds_imported_with_errors' => 'Your feeds have been imported, but some errors occurred',	// IGNORE
		'file_cannot_be_uploaded' => 'File cannot be uploaded!',	// IGNORE
		'no_zip_extension' => 'The ZIP extension is not present on your server.',	// IGNORE
		'zip_error' => 'An error occurred during ZIP import.',	// IGNORE
	),
	'profile' => array(
		'error' => 'Your profile cannot be modified',	// IGNORE
		'updated' => 'Your profile has been modified',	// IGNORE
	),
	'sub' => array(
		'actualize' => 'Updating',	// IGNORE
		'articles' => array(
			'marked_read' => 'The selected articles have been marked as read.',	// IGNORE
			'marked_unread' => 'The articles have been marked as unread.',	// IGNORE
		),
		'category' => array(
			'created' => 'Category %s has been created.',	// IGNORE
			'deleted' => 'Category has been deleted.',	// IGNORE
			'emptied' => 'Category has been emptied',	// IGNORE
			'error' => 'Category cannot be updated',	// IGNORE
			'name_exists' => 'Category name already exists.',	// IGNORE
			'no_id' => 'You must specify the id of the category.',	// IGNORE
			'no_name' => 'Category name cannot be empty.',	// IGNORE
			'not_delete_default' => 'You cannot delete the default category!',	// IGNORE
			'not_exist' => 'The category does not exist!',	// IGNORE
			'over_max' => 'You have reached your limit of categories (%d)',	// IGNORE
			'updated' => 'Category has been updated.',	// IGNORE
		),
		'feed' => array(
			'actualized' => '<em>%s</em> has been updated',	// IGNORE
			'actualizeds' => 'RSS feeds have been updated',	// IGNORE
			'added' => 'RSS feed <em>%s</em> has been added',	// IGNORE
			'already_subscribed' => 'You have already subscribed to <em>%s</em>',	// IGNORE
			'cache_cleared' => '<em>%s</em> cache has been cleared',	// IGNORE
			'deleted' => 'Feed has been deleted',	// IGNORE
			'error' => 'Feed cannot be updated',	// IGNORE
			'internal_problem' => 'The newsfeed could not be added. <a href="%s">Check FreshRSS logs</a> for details. You can try force adding by appending <code>#force_feed</code> to the URL.',	// IGNORE
			'invalid_url' => 'URL <em>%s</em> is invalid',	// IGNORE
			'n_actualized' => '%d feeds have been updated',	// IGNORE
			'n_entries_deleted' => '%d articles have been deleted',	// IGNORE
			'no_refresh' => 'There are no feeds to refresh',	// IGNORE
			'not_added' => '<em>%s</em> could not be added',	// IGNORE
			'not_found' => 'Feed cannot be found',	// IGNORE
			'over_max' => 'You have reached your limit of feeds (%d)',	// IGNORE
			'reloaded' => '<em>%s</em> has been reloaded',	// IGNORE
			'selector_preview' => array(
				'http_error' => 'Failed to load website content.',	// IGNORE
				'no_entries' => 'There are no articles in this feed. You need at least one article to create a preview.',	// IGNORE
				'no_feed' => 'Internal error (feed cannot be found).',	// IGNORE
				'no_result' => 'The selector didn’t match anything. As a fallback the original feed text will be displayed instead.',	// IGNORE
				'selector_empty' => 'The selector is empty. You need to define one to create a preview.',	// IGNORE
			),
			'updated' => 'Feed has been updated',	// IGNORE
		),
		'purge_completed' => 'Purge completed (%d articles deleted)',	// IGNORE
	),
	'tag' => array(
		'created' => 'Tag "%s" has been created.',	// IGNORE
		'name_exists' => 'Tag name already exists.',	// IGNORE
		'renamed' => 'Tag "%s" has been renamed to "%s".',	// IGNORE
	),
	'update' => array(
		'can_apply' => 'FreshRSS will now be updated to the <strong>version %s</strong>.',	// IGNORE
		'error' => 'The update process has encountered an error: %s',	// IGNORE
		'file_is_nok' => 'New <strong>version %s</strong> available, but check permissions on <em>%s</em> directory. HTTP server must have have write permission',	// IGNORE
		'finished' => 'Update complete!',	// IGNORE
		'none' => 'No update to apply',	// IGNORE
		'server_not_found' => 'Update server cannot be found. [%s]',	// IGNORE
	),
	'user' => array(
		'created' => array(
			'_' => 'User %s has been created',	// IGNORE
			'error' => 'User %s cannot be created',	// IGNORE
		),
		'deleted' => array(
			'_' => 'User %s has been deleted',	// IGNORE
			'error' => 'User %s cannot be deleted',	// IGNORE
		),
		'updated' => array(
			'_' => 'User %s has been updated',	// IGNORE
			'error' => 'User %s has not been updated',	// IGNORE
		),
	),
);
