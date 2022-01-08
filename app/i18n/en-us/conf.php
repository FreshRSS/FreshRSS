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
	'archiving' => array(
		'_' => 'Archiving',	// IGNORE
		'exception' => 'Purge exception',	// IGNORE
		'help' => 'More options are available in the individual feed’s settings',	// IGNORE
		'keep_favourites' => 'Never delete favorites',
		'keep_labels' => 'Never delete labels',	// IGNORE
		'keep_max' => 'Maximum number of articles to keep',	// IGNORE
		'keep_min_by_feed' => 'Minimum number of articles to keep per feed',	// IGNORE
		'keep_period' => 'Maximum age of articles to keep',	// IGNORE
		'keep_unreads' => 'Never delete unread articles',	// IGNORE
		'maintenance' => 'Maintenance',	// IGNORE
		'optimize' => 'Optimize database',	// IGNORE
		'optimize_help' => 'Run occasionally to reduce the size of the database',	// IGNORE
		'policy' => 'Purge policy',	// IGNORE
		'policy_warning' => 'If no purge policy is selected, every article will be kept.',	// IGNORE
		'purge_now' => 'Purge now',	// IGNORE
		'title' => 'Archiving',	// IGNORE
		'ttl' => 'Do not automatically refresh more often than',	// IGNORE
	),
	'display' => array(
		'_' => 'Display',	// IGNORE
		'icon' => array(
			'bottom_line' => 'Bottom line',	// IGNORE
			'display_authors' => 'Authors',	// IGNORE
			'entry' => 'Article icons',	// IGNORE
			'publication_date' => 'Date of publication',	// IGNORE
			'related_tags' => 'Article tags',	// IGNORE
			'sharing' => 'Sharing',	// IGNORE
			'summary' => 'Summary',	// IGNORE
			'top_line' => 'Top line',	// IGNORE
		),
		'language' => 'Language',	// IGNORE
		'notif_html5' => array(
			'seconds' => 'seconds (0 means no timeout)',	// IGNORE
			'timeout' => 'HTML5 notification timeout',	// IGNORE
		),
		'show_nav_buttons' => 'Show the navigation buttons',	// IGNORE
		'theme' => 'Theme',	// IGNORE
		'theme_not_available' => 'The “%s” theme is not available anymore. Please choose another theme.',	// IGNORE
		'thumbnail' => array(
			'label' => 'Thumbnail',	// IGNORE
			'landscape' => 'Landscape',	// IGNORE
			'none' => 'None',	// IGNORE
			'portrait' => 'Portrait',	// IGNORE
			'square' => 'Square',	// IGNORE
		),
		'title' => 'Display',	// IGNORE
		'width' => array(
			'content' => 'Content width',	// IGNORE
			'large' => 'Wide',	// IGNORE
			'medium' => 'Medium',	// IGNORE
			'no_limit' => 'Full Width',	// IGNORE
			'thin' => 'Narrow',	// IGNORE
		),
	),
	'profile' => array(
		'_' => 'Profile management',	// IGNORE
		'api' => 'API management',	// IGNORE
		'delete' => array(
			'_' => 'Account deletion',	// IGNORE
			'warn' => 'Your account and all related data will be deleted.',	// IGNORE
		),
		'email' => 'Email address',	// IGNORE
		'password_api' => 'API password<br /><small>(e.g., for mobile apps)</small>',	// IGNORE
		'password_form' => 'Password<br /><small>(for the Web-form login method)</small>',	// IGNORE
		'password_format' => 'At least 7 characters',	// IGNORE
		'title' => 'Profile',	// IGNORE
	),
	'query' => array(
		'_' => 'User queries',	// IGNORE
		'deprecated' => 'This query is no longer valid. The referenced category or feed has been deleted.',	// IGNORE
		'filter' => array(
			'_' => 'Filter applied:',	// IGNORE
			'categories' => 'Display by category',	// IGNORE
			'feeds' => 'Display by feed',	// IGNORE
			'order' => 'Sort by date',	// IGNORE
			'search' => 'Expression',	// IGNORE
			'state' => 'State',	// IGNORE
			'tags' => 'Display by tag',	// IGNORE
			'type' => 'Type',	// IGNORE
		),
		'get_all' => 'Display all articles',	// IGNORE
		'get_category' => 'Display "%s" category',	// IGNORE
		'get_favorite' => 'Display favorite articles',
		'get_feed' => 'Display "%s" feed',	// IGNORE
		'name' => 'Name',	// IGNORE
		'no_filter' => 'No filter',	// IGNORE
		'number' => 'Query n°%d',	// IGNORE
		'order_asc' => 'Display oldest articles first',	// IGNORE
		'order_desc' => 'Display newest articles first',	// IGNORE
		'search' => 'Search for "%s"',	// IGNORE
		'state_0' => 'Display all articles',	// IGNORE
		'state_1' => 'Display read articles',	// IGNORE
		'state_2' => 'Display unread articles',	// IGNORE
		'state_3' => 'Display all articles',	// IGNORE
		'state_4' => 'Display favorite articles',
		'state_5' => 'Display read favorite articles',
		'state_6' => 'Display unread favorite articles',
		'state_7' => 'Display favorite articles',
		'state_8' => 'Display not favorite articles',
		'state_9' => 'Display read not favorite articles',
		'state_10' => 'Display unread not favorite articles',
		'state_11' => 'Display not favorite articles',
		'state_12' => 'Display all articles',	// IGNORE
		'state_13' => 'Display read articles',	// IGNORE
		'state_14' => 'Display unread articles',	// IGNORE
		'state_15' => 'Display all articles',	// IGNORE
		'title' => 'User queries',	// IGNORE
	),
	'reading' => array(
		'_' => 'Reading',	// IGNORE
		'after_onread' => 'After “mark all as read”,',	// IGNORE
		'always_show_favorites' => 'Show all articles in favorites by default',
		'articles_per_page' => 'Number of articles per page',	// IGNORE
		'auto_load_more' => 'Load more articles at the bottom of the page',	// IGNORE
		'auto_remove_article' => 'Hide articles after reading',	// IGNORE
		'confirm_enabled' => 'Display a confirmation dialog on “mark all as read” actions',	// IGNORE
		'display_articles_unfolded' => 'Show articles unfolded by default',	// IGNORE
		'display_categories_unfolded' => 'Categories to unfold',	// IGNORE
		'hide_read_feeds' => 'Hide categories & feeds with no unread articles (does not work with “Show all articles” configuration)',	// IGNORE
		'img_with_lazyload' => 'Use "lazy load" mode to load pictures',	// IGNORE
		'jump_next' => 'jump to next unread sibling (feed or category)',	// IGNORE
		'mark_updated_article_unread' => 'Mark updated articles as unread',	// IGNORE
		'number_divided_when_reader' => 'Divide by 2 in the reading view.',	// IGNORE
		'read' => array(
			'article_open_on_website' => 'when the article is opened on its original website',	// IGNORE
			'article_viewed' => 'when the article is viewed',	// IGNORE
			'keep_max_n_unread' => 'Max number of articles to keep unread',	// IGNORE
			'scroll' => 'while scrolling',	// IGNORE
			'upon_reception' => 'upon receiving the article',	// IGNORE
			'when' => 'Mark an article as read…',	// IGNORE
			'when_same_title' => 'if an identical title already exists in the top <i>n</i> newest articles',	// IGNORE
		),
		'show' => array(
			'_' => 'Articles to display',	// IGNORE
			'active_category' => 'Active category',	// IGNORE
			'adaptive' => 'Adjust showing',	// IGNORE
			'all_articles' => 'Show all articles',	// IGNORE
			'all_categories' => 'All categories',	// IGNORE
			'no_category' => 'No category',	// IGNORE
			'remember_categories' => 'Remember open categories',	// IGNORE
			'unread' => 'Show only unread',	// IGNORE
		),
		'show_fav_unread_help' => 'Applies also on labels',	// IGNORE
		'sides_close_article' => 'Clicking outside of article text area closes the article',	// IGNORE
		'sort' => array(
			'_' => 'Sort order',	// IGNORE
			'newer_first' => 'Newest first',	// IGNORE
			'older_first' => 'Oldest first',	// IGNORE
		),
		'sticky_post' => 'Stick the article to the top when opened',	// IGNORE
		'title' => 'Reading',	// IGNORE
		'view' => array(
			'default' => 'Default view',	// IGNORE
			'global' => 'Global view',	// IGNORE
			'normal' => 'Normal view',	// IGNORE
			'reader' => 'Reading view',	// IGNORE
		),
	),
	'sharing' => array(
		'_' => 'Sharing',	// IGNORE
		'add' => 'Add a sharing method',	// IGNORE
		'blogotext' => 'Blogotext',	// IGNORE
		'diaspora' => 'Diaspora*',	// IGNORE
		'email' => 'Email',	// IGNORE
		'facebook' => 'Facebook',	// IGNORE
		'more_information' => 'More information',	// IGNORE
		'print' => 'Print',	// IGNORE
		'raindrop' => 'Raindrop.io',	// IGNORE
		'remove' => 'Remove sharing method',	// IGNORE
		'shaarli' => 'Shaarli',	// IGNORE
		'share_name' => 'Share name to display',	// IGNORE
		'share_url' => 'Share URL to use',	// IGNORE
		'title' => 'Sharing',	// IGNORE
		'twitter' => 'Twitter',	// IGNORE
		'wallabag' => 'wallabag',	// IGNORE
	),
	'shortcut' => array(
		'_' => 'Shortcuts',	// IGNORE
		'article_action' => 'Article actions',	// IGNORE
		'auto_share' => 'Share',	// IGNORE
		'auto_share_help' => 'If there is only one sharing mode, it is used. Otherwise, modes are accessible by their number.',	// IGNORE
		'close_dropdown' => 'Close menus',	// IGNORE
		'collapse_article' => 'Collapse',	// IGNORE
		'first_article' => 'Open the first article',	// IGNORE
		'focus_search' => 'Access search box',	// IGNORE
		'global_view' => 'Switch to global view',	// IGNORE
		'help' => 'Display documentation',	// IGNORE
		'javascript' => 'JavaScript must be enabled in order to use shortcuts',	// IGNORE
		'last_article' => 'Open the last article',	// IGNORE
		'load_more' => 'Load more articles',	// IGNORE
		'mark_favorite' => 'Toggle favorite',
		'mark_read' => 'Toggle read',	// IGNORE
		'navigation' => 'Navigation',	// IGNORE
		'navigation_help' => 'With the <kbd>⇧ Shift</kbd> modifier, navigation shortcuts apply on feeds.<br/>With the <kbd>Alt ⎇</kbd> modifier, navigation shortcuts apply on categories.',	// IGNORE
		'navigation_no_mod_help' => 'The following navigation shortcuts do not support modifiers.',	// IGNORE
		'next_article' => 'Open the next article',	// IGNORE
		'next_unread_article' => 'Open the next unread article',	// IGNORE
		'non_standard' => 'Some keys (<kbd>%s</kbd>) may not work as shortcuts.',	// IGNORE
		'normal_view' => 'Switch to normal view',	// IGNORE
		'other_action' => 'Other actions',	// IGNORE
		'previous_article' => 'Open the previous article',	// IGNORE
		'reading_view' => 'Switch to reading view',	// IGNORE
		'rss_view' => 'Open as RSS feed',	// IGNORE
		'see_on_website' => 'See on original website',	// IGNORE
		'shift_for_all_read' => '+ <kbd>Alt ⎇</kbd> to mark previous articles as read<br />+ <kbd>⇧ Shift</kbd> to mark all articles as read',	// IGNORE
		'skip_next_article' => 'Focus next without opening',	// IGNORE
		'skip_previous_article' => 'Focus previous without opening',	// IGNORE
		'title' => 'Shortcuts',	// IGNORE
		'toggle_media' => 'Play/pause media',	// IGNORE
		'user_filter' => 'Access user queries',	// IGNORE
		'user_filter_help' => 'If there is only one user query, it is used. Otherwise, queries are accessible by their number.',	// IGNORE
		'views' => 'Views',	// IGNORE
	),
	'user' => array(
		'articles_and_size' => '%s articles (%s)',	// IGNORE
		'current' => 'Current user',	// IGNORE
		'is_admin' => 'is administrator',	// IGNORE
		'users' => 'Users',	// IGNORE
	),
);
