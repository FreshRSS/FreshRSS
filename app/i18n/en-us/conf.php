<?php

return array(
	'archiving' => array(
		'_' => 'Archiving',
		'delete_after' => 'Remove articles after',
		'exception' => 'Purge exception',
		'help' => 'More options are available in the individual feed\'s settings',
		'keep_favourites' => 'Never delete favorites',
		'keep_labels' => 'Never delete labels',
		'keep_max' => 'Maximum number of articles to keep',
		'keep_min_by_feed' => 'Minimum number of articles to keep per feed',
		'keep_period' => 'Maximum age of articles to keep',
		'keep_unreads' => 'Never delete unread articles',
		'maintenance' => 'Maintenance',
		'optimize' => 'Optimize database',
		'optimize_help' => 'Run occasionally to reduce the size of the database',
		'policy' => 'Purge policy',
		'policy_warning' => 'If no purge policy is selected, every article will be kept.',
		'purge_now' => 'Purge now',
		'title' => 'Archiving',
		'ttl' => 'Do not automatically refresh more often than',
	),
	'display' => array(
		'_' => 'Display',
		'icon' => array(
			'bottom_line' => 'Bottom line',
			'display_authors' => 'Authors',
			'entry' => 'Article icons',
			'publication_date' => 'Date of publication',
			'related_tags' => 'Article tags',
			'sharing' => 'Sharing',
			'top_line' => 'Top line',
		),
		'language' => 'Language',
		'notif_html5' => array(
			'seconds' => 'seconds (0 means no timeout)',
			'timeout' => 'HTML5 notification timeout',
		),
		'show_nav_buttons' => 'Show the navigation buttons',
		'theme' => 'Theme',
		'title' => 'Display',
		'width' => array(
			'content' => 'Content width',
			'large' => 'Wide',
			'medium' => 'Medium',
			'no_limit' => 'Full Width',
			'thin' => 'Narrow',
		),
	),
	'profile' => array(
		'_' => 'Profile management',
		'api' => 'API management',
		'delete' => array(
			'_' => 'Account deletion',
			'warn' => 'Your account and all related data will be deleted.',
		),
		'email' => 'Email address',
		'password_api' => 'API password<br /><small>(e.g., for mobile apps)</small>',
		'password_form' => 'Password<br /><small>(for the Web-form login method)</small>',
		'password_format' => 'At least 7 characters',
		'title' => 'Profile',
	),
	'query' => array(
		'_' => 'User queries',
		'deprecated' => 'This query is no longer valid. The referenced category or feed has been deleted.',
		'display' => 'Display user query results',
		'filter' => 'Filter applied:',
		'get_all' => 'Display all articles',
		'get_category' => 'Display "%s" category',
		'get_favorite' => 'Display favorite articles',
		'get_feed' => 'Display "%s" feed',
		'get_tag' => 'Display "%s" label',	// TODO - Translation
		'name' => 'Name',	// TODO - Translation
		'no_filter' => 'No filter',
		'none' => 'You haven’t created any user queries yet.',
		'number' => 'Query n°%d',
		'order_asc' => 'Display oldest articles first',
		'order_desc' => 'Display newest articles first',
		'remove' => 'Remove user query',
		'search' => 'Search for "%s"',
		'state_0' => 'Display all articles',
		'state_1' => 'Display read articles',
		'state_2' => 'Display unread articles',
		'state_3' => 'Display all articles',
		'state_4' => 'Display favorite articles',
		'state_5' => 'Display read favorite articles',
		'state_6' => 'Display unread favorite articles',
		'state_7' => 'Display favorite articles',
		'state_8' => 'Display not favorite articles',
		'state_9' => 'Display read not favorite articles',
		'state_10' => 'Display unread not favorite articles',
		'state_11' => 'Display not favorite articles',
		'state_12' => 'Display all articles',
		'state_13' => 'Display read articles',
		'state_14' => 'Display unread articles',
		'state_15' => 'Display all articles',
		'title' => 'User queries',
		'url' => 'URL',	// TODO - Translation
	),
	'reading' => array(
		'_' => 'Reading',
		'after_onread' => 'After “mark all as read”,',
		'always_show_favorites' => 'Show all articles in favorites by default',
		'articles_per_page' => 'Number of articles per page',
		'auto_load_more' => 'Load more articles at the bottom of the page',
		'auto_remove_article' => 'Hide articles after reading',
		'confirm_enabled' => 'Display a confirmation dialog on “mark all as read” actions',
		'display_articles_unfolded' => 'Show articles unfolded by default',
		'display_categories_unfolded' => 'Categories to unfold',
		'hide_read_feeds' => 'Hide categories & feeds with no unread articles (does not work with “Show all articles” configuration)',
		'img_with_lazyload' => 'Use "lazy load" mode to load pictures',
		'jump_next' => 'jump to next unread sibling (feed or category)',
		'mark_updated_article_unread' => 'Mark updated articles as unread',
		'number_divided_when_reader' => 'Divide by 2 in the reading view.',
		'read' => array(
			'article_open_on_website' => 'when the article is opened on its original website',
			'article_viewed' => 'when the article is viewed',
			'scroll' => 'while scrolling',
			'upon_reception' => 'upon receiving the article',
			'when' => 'Mark an article as read…',
		),
		'show' => array(
			'_' => 'Articles to display',
			'active_category' => 'Active category',
			'adaptive' => 'Adjust showing',
			'all_articles' => 'Show all articles',
			'all_categories' => 'All categories',
			'no_category' => 'No category',
			'remember_categories' => 'Remember open categories',
			'unread' => 'Show only unread',
		),
		'sides_close_article' => 'Clicking outside of article text area closes the article',
		'sort' => array(
			'_' => 'Sort order',
			'newer_first' => 'Newest first',
			'older_first' => 'Oldest first',
		),
		'sticky_post' => 'Stick the article to the top when opened',
		'title' => 'Reading',
		'view' => array(
			'default' => 'Default view',
			'global' => 'Global view',
			'normal' => 'Normal view',
			'reader' => 'Reading view',
		),
	),
	'sharing' => array(
		'_' => 'Sharing',
		'add' => 'Add a sharing method',
		'blogotext' => 'Blogotext',
		'diaspora' => 'Diaspora*',
		'email' => 'Email',
		'facebook' => 'Facebook',
		'more_information' => 'More information',
		'print' => 'Print',
		'remove' => 'Remove sharing method',
		'shaarli' => 'Shaarli',
		'share_name' => 'Share name to display',
		'share_url' => 'Share URL to use',
		'title' => 'Sharing',
		'twitter' => 'Twitter',
		'wallabag' => 'wallabag',
	),
	'shortcut' => array(
		'_' => 'Shortcuts',
		'article_action' => 'Article actions',
		'auto_share' => 'Share',
		'auto_share_help' => 'If there is only one sharing mode, it is used. Otherwise, modes are accessible by their number.',
		'close_dropdown' => 'Close menus',
		'collapse_article' => 'Collapse',
		'first_article' => 'Open the first article',
		'focus_search' => 'Access search box',
		'global_view' => 'Switch to global view',
		'help' => 'Display documentation',
		'javascript' => 'JavaScript must be enabled in order to use shortcuts',
		'last_article' => 'Open the last article',
		'load_more' => 'Load more articles',
		'mark_favorite' => 'Toggle favorite',
		'mark_read' => 'Toggle read',
		'navigation' => 'Navigation',
		'navigation_help' => 'With the <kbd>⇧ Shift</kbd> modifier, navigation shortcuts apply on feeds.<br/>With the <kbd>Alt ⎇</kbd> modifier, navigation shortcuts apply on categories.',
		'navigation_no_mod_help' => 'The following navigation shortcuts do not support modifiers.',
		'next_article' => 'Open the next article',
		'normal_view' => 'Switch to normal view',
		'other_action' => 'Other actions',
		'previous_article' => 'Open the previous article',
		'reading_view' => 'Switch to reading view',
		'rss_view' => 'Open RSS view in a new tab',
		'see_on_website' => 'See on original website',
		'shift_for_all_read' => '+ <kbd>Alt ⎇</kbd> to mark previous articles as read<br />+ <kbd>⇧ Shift</kbd> to mark all articles as read',
		'skip_next_article' => 'Focus next without opening',
		'skip_previous_article' => 'Focus previous without opening',
		'title' => 'Shortcuts',
		'toggle_media' => 'Play/pause media',
		'user_filter' => 'Access user queries',
		'user_filter_help' => 'If there is only one user query, it is used. Otherwise, queries are accessible by their number.',
		'views' => 'Views',
	),
	'user' => array(
		'articles_and_size' => '%s articles (%s)',
		'current' => 'Current user',
		'is_admin' => 'is administrator',
		'users' => 'Users',
	),
);
