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
		'denied' => 'You don’t have permission to access this page',	// TODO
		'not_found' => 'You are looking for a page that doesn’t exist',	// TODO
	),
	'admin' => array(
		'optimization_complete' => 'Optimization complete',	// TODO
	),
	'api' => array(
		'password' => array(
			'failed' => 'Your password cannot be modified',	// TODO
			'updated' => 'Your password has been modified',	// TODO
		),
	),
	'auth' => array(
		'login' => array(
			'invalid' => 'Login is invalid',	// TODO
			'success' => 'You are connected',	// TODO
		),
		'logout' => array(
			'success' => 'You are disconnected',	// TODO
		),
	),
	'conf' => array(
		'error' => 'An error occurred while saving configuration',	// TODO
		'query_created' => 'Query “%s” has been created.',	// TODO
		'shortcuts_updated' => 'Shortcuts have been updated',	// TODO
		'updated' => 'Configuration has been updated',	// TODO
	),
	'extensions' => array(
		'already_enabled' => '%s is already enabled',	// TODO
		'cannot_remove' => '%s cannot be removed',	// TODO
		'disable' => array(
			'ko' => '%s cannot be disabled. <a href="%s">Check FreshRSS logs</a> for details.',	// TODO
			'ok' => '%s is now disabled',	// TODO
		),
		'enable' => array(
			'ko' => '%s cannot be enabled. <a href="%s">Check FreshRSS logs</a> for details.',	// TODO
			'ok' => '%s is now enabled',	// TODO
		),
		'no_access' => 'You have no access on %s',	// TODO
		'not_enabled' => '%s is not enabled',	// TODO
		'not_found' => '%s does not exist',	// TODO
		'removed' => '%s removed',	// TODO
	),
	'import_export' => array(
		'export_no_zip_extension' => 'The ZIP extension is not present on your server. Please try to export files one by one.',	// TODO
		'feeds_imported' => 'Your feeds have been imported. If you are done importing, you can now click the <i>Update feeds</i> button.',	// TODO
		'feeds_imported_with_errors' => 'Your feeds have been imported, but some errors occurred. If you are done importing, you can now click the <i>Update feeds</i> button.',	// TODO
		'file_cannot_be_uploaded' => 'File cannot be uploaded!',	// TODO
		'no_zip_extension' => 'The ZIP extension is not present on your server.',	// TODO
		'zip_error' => 'An error occurred during ZIP processing.',	// TODO
	),
	'profile' => array(
		'error' => 'Your profile cannot be modified',	// TODO
		'updated' => 'Your profile has been modified',	// TODO
	),
	'sub' => array(
		'actualize' => 'Updating',	// TODO
		'articles' => array(
			'marked_read' => 'The selected articles have been marked as read.',	// TODO
			'marked_unread' => 'The articles have been marked as unread.',	// TODO
		),
		'category' => array(
			'created' => 'Category %s has been created.',	// TODO
			'deleted' => 'Category has been deleted.',	// TODO
			'emptied' => 'Category has been emptied',	// TODO
			'error' => 'Category cannot be updated',	// TODO
			'name_exists' => 'Category name already exists.',	// TODO
			'no_id' => 'You must specify the id of the category.',	// TODO
			'no_name' => 'Category name cannot be empty.',	// TODO
			'not_delete_default' => 'You cannot delete the default category!',	// TODO
			'not_exist' => 'The category does not exist!',	// TODO
			'over_max' => 'You have reached your limit of categories (%d)',	// TODO
			'updated' => 'Category has been updated.',	// TODO
		),
		'feed' => array(
			'actualized' => '<em>%s</em> has been updated',	// TODO
			'actualizeds' => 'RSS feeds have been updated',	// TODO
			'added' => 'RSS feed <em>%s</em> has been added',	// TODO
			'already_subscribed' => 'You have already subscribed to <em>%s</em>',	// TODO
			'cache_cleared' => '<em>%s</em> cache has been cleared',	// TODO
			'deleted' => 'Feed has been deleted',	// TODO
			'error' => 'Feed cannot be updated',	// TODO
			'internal_problem' => 'The newsfeed could not be added. <a href="%s">Check FreshRSS logs</a> for details. You can try force adding by appending <code>#force_feed</code> to the URL.',	// TODO
			'invalid_url' => 'URL <em>%s</em> is invalid',	// TODO
			'n_actualized' => '%d feeds have been updated',	// TODO
			'n_entries_deleted' => '%d articles have been deleted',	// TODO
			'no_refresh' => 'There are no feeds to refresh',	// TODO
			'not_added' => '<em>%s</em> could not be added',	// TODO
			'not_found' => 'Feed cannot be found',	// TODO
			'over_max' => 'You have reached your limit of feeds (%d)',	// TODO
			'reloaded' => '<em>%s</em> has been reloaded',	// TODO
			'selector_preview' => array(
				'http_error' => 'Failed to load website content.',	// TODO
				'no_entries' => 'There are no articles in this feed. You need at least one article to create a preview.',	// TODO
				'no_feed' => 'Internal error (feed cannot be found).',	// TODO
				'no_result' => 'The selector didn’t match anything. As a fallback the original feed text will be displayed instead.',	// TODO
				'selector_empty' => 'The selector is empty. You need to define one to create a preview.',	// TODO
			),
			'updated' => 'Feed has been updated',	// TODO
		),
		'purge_completed' => 'Purge completed (%d articles deleted)',	// TODO
	),
	'tag' => array(
		'created' => 'Label “%s” has been created.',	// TODO
		'error' => 'Label could not be updated!',	// TODO
		'name_exists' => 'Label name already exists.',	// TODO
		'renamed' => 'Label “%s” has been renamed to “%s”.',	// TODO
		'updated' => 'Label has been updated.',	// TODO
	),
	'update' => array(
		'can_apply' => 'FreshRSS will now be updated to the <strong>version %s</strong>.',	// DIRTY
		'error' => 'The update process has encountered an error: %s',	// TODO
		'file_is_nok' => 'New <strong>version %s</strong> available, but check permissions on <em>%s</em> directory. HTTP server must have have write permission',	// DIRTY
		'finished' => 'Update complete!',	// TODO
		'none' => 'No update to apply',	// DIRTY
		'server_not_found' => 'Update server cannot be found. [%s]',	// TODO
	),
	'user' => array(
		'created' => array(
			'_' => 'User %s has been created',	// TODO
			'error' => 'User %s cannot be created',	// TODO
		),
		'deleted' => array(
			'_' => 'User %s has been deleted',	// TODO
			'error' => 'User %s cannot be deleted',	// TODO
		),
		'updated' => array(
			'_' => 'User %s has been updated',	// TODO
			'error' => 'User %s has not been updated',	// TODO
		),
	),
);
