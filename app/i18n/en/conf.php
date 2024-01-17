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

return [
	'archiving' => [
		'_' => 'Archiving',
		'exception' => 'Purge exception',
		'help' => 'More options are available in the individual feed’s settings',
		'keep_favourites' => 'Never delete favourites',
		'keep_labels' => 'Never delete labels',
		'keep_max' => 'Maximum number of articles to keep per feed',
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
	],
	'display' => [
		'_' => 'Display',
		'darkMode' => [
			'_' => 'Automatic dark mode (beta)',
			'auto' => 'Auto',
			'no' => 'No',
		],
		'icon' => [
			'bottom_line' => 'Bottom line',
			'display_authors' => 'Authors',
			'entry' => 'Article icons',
			'publication_date' => 'Date of publication',
			'related_tags' => 'Article tags',
			'sharing' => 'Sharing',
			'summary' => 'Summary',
			'top_line' => 'Top line',
		],
		'language' => 'Language',
		'notif_html5' => [
			'seconds' => 'seconds (0 means no timeout)',
			'timeout' => 'HTML5 notification timeout',
		],
		'show_nav_buttons' => 'Show the navigation buttons',
		'theme' => [
			'_' => 'Theme',
			'deprecated' => [
				'_' => 'Deprecated',
				'description' => 'This theme is no longer supported and will be not available anymore in a <a href="https://freshrss.github.io/FreshRSS/en/users/05_Configuration.html#theme" target="_blank">future release of FreshRSS</a>',
			],
		],
		'theme_not_available' => 'The “%s” theme is not available anymore. Please choose another theme.',
		'thumbnail' => [
			'label' => 'Thumbnail',
			'landscape' => 'Landscape',
			'none' => 'None',
			'portrait' => 'Portrait',
			'square' => 'Square',
		],
		'timezone' => 'Time zone',
		'title' => 'Display',
		'website' => [
			'full' => 'Icon and name',
			'icon' => 'Icon only',
			'label' => 'Website',
			'name' => 'Name only',
			'none' => 'None',
		],
		'width' => [
			'content' => 'Content width',
			'large' => 'Wide',
			'medium' => 'Medium',
			'no_limit' => 'Full Width',
			'thin' => 'Narrow',
		],
	],
	'logs' => [
		'loglist' => [
			'level' => 'Log Level',
			'message' => 'Log Message',
			'timestamp' => 'Timestamp',
		],
		'pagination' => [
			'first' => 'First',
			'last' => 'Last',
			'next' => 'Next',
			'previous' => 'Previous',
		],
	],
	'profile' => [
		'_' => 'Profile management',
		'api' => 'API management',
		'delete' => [
			'_' => 'Account deletion',
			'warn' => 'Your account and all related data will be deleted.',
		],
		'email' => 'Email address',
		'password_api' => 'API password<br /><small>(e.g., for mobile apps)</small>',
		'password_form' => 'Password<br /><small>(for the Web-form login method)</small>',
		'password_format' => 'At least 7 characters',
		'title' => 'Profile',
	],
	'query' => [
		'_' => 'User queries',
		'deprecated' => 'This query is no longer valid. The referenced category or feed has been deleted.',
		'filter' => [
			'_' => 'Filter applied:',
			'categories' => 'Display by category',
			'feeds' => 'Display by feed',
			'order' => 'Sort by date',
			'search' => 'Expression',
			'state' => 'State',
			'tags' => 'Display by label',
			'type' => 'Type',
		],
		'get_all' => 'Display all articles',
		'get_category' => 'Display “%s” category',
		'get_favorite' => 'Display favourite articles',
		'get_feed' => 'Display “%s” feed',
		'name' => 'Name',
		'no_filter' => 'No filter',
		'number' => 'Query n°%d',
		'order_asc' => 'Display oldest articles first',
		'order_desc' => 'Display newest articles first',
		'search' => 'Search for “%s”',
		'state_0' => 'Display all articles',
		'state_1' => 'Display read articles',
		'state_2' => 'Display unread articles',
		'state_3' => 'Display all articles',
		'state_4' => 'Display favourite articles',
		'state_5' => 'Display read favourite articles',
		'state_6' => 'Display unread favourite articles',
		'state_7' => 'Display favourite articles',
		'state_8' => 'Display not favourite articles',
		'state_9' => 'Display read not favourite articles',
		'state_10' => 'Display unread not favourite articles',
		'state_11' => 'Display not favourite articles',
		'state_12' => 'Display all articles',
		'state_13' => 'Display read articles',
		'state_14' => 'Display unread articles',
		'state_15' => 'Display all articles',
		'title' => 'User queries',
	],
	'reading' => [
		'_' => 'Reading',
		'after_onread' => 'After “mark all as read”,',
		'always_show_favorites' => 'Show all articles in favourites by default',
		'article' => [
			'authors_date' => [
				'_' => 'Authors and date',
				'both' => 'In header and footer',
				'footer' => 'In footer',
				'header' => 'In header',
				'none' => 'None',
			],
			'feed_name' => [
				'above_title' => 'Above title/tags',
				'none' => 'None',
				'with_authors' => 'In authors and date row',
			],
			'feed_title' => 'Feed title',
			'tags' => [
				'_' => 'Tags',
				'both' => 'In header and footer',
				'footer' => 'In footer',
				'header' => 'In header',
				'none' => 'None',
			],
			'tags_max' => [
				'_' => 'Max number of tags shown',
				'help' => '0 means: show all tags and do not collapse them',
			],
		],
		'articles_per_page' => 'Number of articles per page',
		'auto_load_more' => 'Load more articles at the bottom of the page',
		'auto_remove_article' => 'Hide articles after reading',
		'confirm_enabled' => 'Display a confirmation dialog on “mark all as read” actions',
		'display_articles_unfolded' => 'Show articles unfolded by default',
		'display_categories_unfolded' => 'Categories to unfold',
		'headline' => [
			'articles' => 'Articles: Open/Close',
			'articles_header_footer' => 'Articles: header/footer',
			'categories' => 'Left navigation: Categories',
			'mark_as_read' => 'Mark article as read',
			'misc' => 'Miscellaneous',
			'view' => 'View',
		],
		'hide_read_feeds' => 'Hide categories & feeds with no unread articles (does not work with “Show all articles” configuration)',
		'img_with_lazyload' => 'Use <em>lazy load</em> mode to load pictures',
		'jump_next' => 'jump to next unread sibling (feed or category)',
		'mark_updated_article_unread' => 'Mark updated articles as unread',
		'number_divided_when_reader' => 'Divide by 2 in the reading view.',
		'read' => [
			'article_open_on_website' => 'when the article is opened on its original website',
			'article_viewed' => 'when the article is viewed',
			'focus' => 'when focused (except for important feeds)',
			'keep_max_n_unread' => 'Max number of articles to keep unread',
			'scroll' => 'while scrolling (except for important feeds)',
			'upon_gone' => 'when it is no longer in the upstream news feed',
			'upon_reception' => 'upon receiving the article',
			'when' => 'Mark an article as read…',
			'when_same_title' => 'if an identical title already exists in the top <i>n</i> newest articles',
		],
		'show' => [
			'_' => 'Articles to display',
			'active_category' => 'Active category',
			'adaptive' => 'Adjust showing',
			'all_articles' => 'Show all articles',
			'all_categories' => 'All categories',
			'no_category' => 'No category',
			'remember_categories' => 'Remember open categories',
			'unread' => 'Show only unread',
		],
		'show_fav_unread_help' => 'Applies also on labels',
		'sides_close_article' => 'Clicking outside of article text area closes the article',
		'sort' => [
			'_' => 'Sort order',
			'newer_first' => 'Newest first',
			'older_first' => 'Oldest first',
		],
		'sticky_post' => 'Stick the article to the top when opened',
		'title' => 'Reading',
		'view' => [
			'default' => 'Default view',
			'global' => 'Global view',
			'normal' => 'Normal view',
			'reader' => 'Reading view',
		],
	],
	'sharing' => [
		'_' => 'Sharing',
		'add' => 'Add a sharing method',
		'blogotext' => 'Blogotext',
		'deprecated' => 'This service is deprecated and will be removed from FreshRSS in a <a href="https://freshrss.github.io/FreshRSS/en/users/08_sharing_services.html" title="Open documentation for more information" target="_blank">future release</a>.',
		'diaspora' => 'Diaspora*',
		'email' => 'Email',
		'facebook' => 'Facebook',
		'more_information' => 'More information',
		'print' => 'Print',
		'raindrop' => 'Raindrop.io',
		'remove' => 'Remove sharing method',
		'shaarli' => 'Shaarli',
		'share_name' => 'Share name to display',
		'share_url' => 'Share URL to use',
		'title' => 'Sharing',
		'twitter' => 'Twitter',
		'wallabag' => 'wallabag',
	],
	'shortcut' => [
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
		'mark_favorite' => 'Toggle favourite',
		'mark_read' => 'Toggle read',
		'navigation' => 'Navigation',
		'navigation_help' => 'With the <kbd>⇧ Shift</kbd> modifier, navigation shortcuts apply on feeds.<br/>With the <kbd>Alt ⎇</kbd> modifier, navigation shortcuts apply on categories.',
		'navigation_no_mod_help' => 'The following navigation shortcuts do not support modifiers.',
		'next_article' => 'Open the next article',
		'next_unread_article' => 'Open the next unread article',
		'non_standard' => 'Some keys (<kbd>%s</kbd>) may not work as shortcuts.',
		'normal_view' => 'Switch to normal view',
		'other_action' => 'Other actions',
		'previous_article' => 'Open the previous article',
		'reading_view' => 'Switch to reading view',
		'rss_view' => 'Open as RSS feed',
		'see_on_website' => 'See on original website',
		'shift_for_all_read' => '+ <kbd>Alt ⎇</kbd> to mark previous articles as read<br />+ <kbd>⇧ Shift</kbd> to mark all articles as read',
		'skip_next_article' => 'Focus next without opening',
		'skip_previous_article' => 'Focus previous without opening',
		'title' => 'Shortcuts',
		'toggle_media' => 'Play/pause media',
		'user_filter' => 'Access user queries',
		'user_filter_help' => 'If there is only one user query, it is used. Otherwise, queries are accessible by their number.',
		'views' => 'Views',
	],
	'user' => [
		'articles_and_size' => '%s articles (%s)',
		'current' => 'Current user',
		'is_admin' => 'is administrator',
		'users' => 'Users',
	],
];
