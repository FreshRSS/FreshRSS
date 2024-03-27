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
		'_' => 'Archiving',	// TODO
		'exception' => 'Purge exception',	// TODO
		'help' => 'More options are available in the individual feed’s settings',	// TODO
		'keep_favourites' => 'Never delete favourites',	// TODO
		'keep_labels' => 'Never delete labels',	// TODO
		'keep_max' => 'Maximum number of articles to keep per feed',	// TODO
		'keep_min_by_feed' => 'Minimum number of articles to keep per feed',	// TODO
		'keep_period' => 'Maximum age of articles to keep',	// TODO
		'keep_unreads' => 'Never delete unread articles',	// TODO
		'maintenance' => 'Maintenance',	// TODO
		'optimize' => 'Optimize database',	// TODO
		'optimize_help' => 'Run occasionally to reduce the size of the database',	// TODO
		'policy' => 'Purge policy',	// TODO
		'policy_warning' => 'If no purge policy is selected, every article will be kept.',	// TODO
		'purge_now' => 'Purge now',	// TODO
		'title' => 'Archiving',	// TODO
		'ttl' => 'Do not automatically refresh more often than',	// TODO
	),
	'display' => array(
		'_' => 'Display',	// TODO
		'darkMode' => array(
			'_' => 'Automatic dark mode (beta)',	// TODO
			'auto' => 'Auto',	// TODO
			'no' => 'No',	// TODO
		),
		'icon' => array(
			'bottom_line' => 'Bottom line',	// TODO
			'display_authors' => 'Authors',	// TODO
			'entry' => 'Article icons',	// TODO
			'publication_date' => 'Date of publication',	// TODO
			'related_tags' => 'Article tags',	// TODO
			'sharing' => 'Sharing',	// TODO
			'summary' => 'Summary',	// TODO
			'top_line' => 'Top line',	// TODO
		),
		'language' => 'Language',	// TODO
		'notif_html5' => array(
			'seconds' => 'seconds (0 means no timeout)',	// TODO
			'timeout' => 'HTML5 notification timeout',	// TODO
		),
		'show_nav_buttons' => 'Show the navigation buttons',	// TODO
		'theme' => array(
			'_' => 'Theme',	// TODO
			'deprecated' => array(
				'_' => 'Deprecated',	// TODO
				'description' => 'This theme is no longer supported and will be not available anymore in a <a href="https://freshrss.github.io/FreshRSS/en/users/05_Configuration.html#theme" target="_blank">future release of FreshRSS</a>',	// TODO
			),
		),
		'theme_not_available' => 'The “%s” theme is not available anymore. Please choose another theme.',	// TODO
		'thumbnail' => array(
			'label' => 'Thumbnail',	// TODO
			'landscape' => 'Landscape',	// TODO
			'none' => 'None',	// TODO
			'portrait' => 'Portrait',	// TODO
			'square' => 'Square',	// TODO
		),
		'timezone' => 'Time zone',	// TODO
		'title' => 'Display',	// TODO
		'website' => array(
			'full' => 'Icon and name',	// TODO
			'icon' => 'Icon only',	// TODO
			'label' => 'Website',	// TODO
			'name' => 'Name only',	// TODO
			'none' => 'None',	// TODO
		),
		'width' => array(
			'content' => 'Content width',	// TODO
			'large' => 'Wide',	// TODO
			'medium' => 'Medium',	// TODO
			'no_limit' => 'Full Width',	// TODO
			'thin' => 'Narrow',	// TODO
		),
	),
	'logs' => array(
		'loglist' => array(
			'level' => 'Log Level',	// TODO
			'message' => 'Log Message',	// TODO
			'timestamp' => 'Timestamp',	// TODO
		),
		'pagination' => array(
			'first' => 'First',	// TODO
			'last' => 'Last',	// TODO
			'next' => 'Next',	// TODO
			'previous' => 'Previous',	// TODO
		),
	),
	'profile' => array(
		'_' => 'Profile management',	// TODO
		'api' => 'API management',	// TODO
		'delete' => array(
			'_' => 'Account deletion',	// TODO
			'warn' => 'Your account and all related data will be deleted.',	// TODO
		),
		'email' => 'Email address',	// TODO
		'password_api' => 'API password<br /><small>(e.g., for mobile apps)</small>',	// TODO
		'password_form' => 'Password<br /><small>(for the Web-form login method)</small>',	// TODO
		'password_format' => 'At least 7 characters',	// TODO
		'title' => 'Profile',	// TODO
	),
	'query' => array(
		'_' => 'User queries',	// TODO
		'deprecated' => 'This query is no longer valid. The referenced category or feed has been deleted.',	// TODO
		'filter' => array(
			'_' => 'Filter applied:',	// TODO
			'categories' => 'Display by category',	// TODO
			'feeds' => 'Display by feed',	// TODO
			'order' => 'Sort by date',	// TODO
			'search' => 'Expression',	// TODO
			'shareOpml' => 'Enable sharing by OPML of corresponding categories and feeds',	// TODO
			'shareRss' => 'Enable sharing by HTML &amp; RSS',	// TODO
			'state' => 'State',	// TODO
			'tags' => 'Display by label',	// TODO
			'type' => 'Type',	// TODO
		),
		'get_all' => 'Display all articles',	// TODO
		'get_all_labels' => 'Display articles with any label',	// TODO
		'get_category' => 'Display “%s” category',	// TODO
		'get_favorite' => 'Display favourite articles',	// TODO
		'get_feed' => 'Display “%s” feed',	// TODO
		'get_important' => 'Display articles from important feeds',	// TODO
		'get_label' => 'Display articles with “%s” label',	// TODO
		'help' => 'See the <a href="https://freshrss.github.io/FreshRSS/en/users/user_queries.html" target="_blank">documentation for user queries and resharing by HTML / RSS / OPML</a>.',	// TODO
		'name' => 'Name',	// TODO
		'no_filter' => 'No filter',	// TODO
		'number' => 'Query n°%d',	// TODO
		'order_asc' => 'Display oldest articles first',	// TODO
		'order_desc' => 'Display newest articles first',	// TODO
		'search' => 'Search for “%s”',	// TODO
		'share' => array(
			'_' => 'Share this query by link',	// TODO
			'help' => 'Give this link if you want to share this query with anyone',	// TODO
			'html' => 'Shareable link to the HTML page',	// TODO
			'opml' => 'Shareable link to the OPML list of feeds',	// TODO
			'rss' => 'Shareable link to the RSS feed',	// TODO
		),
		'state_0' => 'Display all articles',	// TODO
		'state_1' => 'Display read articles',	// TODO
		'state_2' => 'Display unread articles',	// TODO
		'state_3' => 'Display all articles',	// TODO
		'state_4' => 'Display favourite articles',	// TODO
		'state_5' => 'Display read favourite articles',	// TODO
		'state_6' => 'Display unread favourite articles',	// TODO
		'state_7' => 'Display favourite articles',	// TODO
		'state_8' => 'Display not favourite articles',	// TODO
		'state_9' => 'Display read not favourite articles',	// TODO
		'state_10' => 'Display unread not favourite articles',	// TODO
		'state_11' => 'Display not favourite articles',	// TODO
		'state_12' => 'Display all articles',	// TODO
		'state_13' => 'Display read articles',	// TODO
		'state_14' => 'Display unread articles',	// TODO
		'state_15' => 'Display all articles',	// TODO
		'title' => 'User queries',	// TODO
	),
	'reading' => array(
		'_' => 'Reading',	// TODO
		'after_onread' => 'After “mark all as read”,',	// TODO
		'always_show_favorites' => 'Show all articles in favourites by default',	// TODO
		'article' => array(
			'authors_date' => array(
				'_' => 'Authors and date',	// TODO
				'both' => 'In header and footer',	// TODO
				'footer' => 'In footer',	// TODO
				'header' => 'In header',	// TODO
				'none' => 'None',	// TODO
			),
			'feed_name' => array(
				'above_title' => 'Above title/tags',	// TODO
				'none' => 'None',	// TODO
				'with_authors' => 'In authors and date row',	// TODO
			),
			'feed_title' => 'Feed title',	// TODO
			'tags' => array(
				'_' => 'Tags',	// TODO
				'both' => 'In header and footer',	// TODO
				'footer' => 'In footer',	// TODO
				'header' => 'In header',	// TODO
				'none' => 'None',	// TODO
			),
			'tags_max' => array(
				'_' => 'Max number of tags shown',	// TODO
				'help' => '0 means: show all tags and do not collapse them',	// TODO
			),
		),
		'articles_per_page' => 'Number of articles per page',	// TODO
		'auto_load_more' => 'Load more articles at the bottom of the page',	// TODO
		'auto_remove_article' => 'Hide articles after reading',	// TODO
		'confirm_enabled' => 'Display a confirmation dialog on “mark all as read” actions',	// TODO
		'display_articles_unfolded' => 'Show articles unfolded by default',	// TODO
		'display_categories_unfolded' => 'Categories to unfold',	// TODO
		'headline' => array(
			'articles' => 'Articles: Open/Close',	// TODO
			'articles_header_footer' => 'Articles: header/footer',	// TODO
			'categories' => 'Left navigation: Categories',	// TODO
			'mark_as_read' => 'Mark article as read',	// TODO
			'misc' => 'Miscellaneous',	// TODO
			'view' => 'View',	// TODO
		),
		'hide_read_feeds' => 'Hide categories & feeds with no unread articles (does not work with “Show all articles” configuration)',	// TODO
		'img_with_lazyload' => 'Use <em>lazy load</em> mode to load pictures',	// TODO
		'jump_next' => 'jump to next unread sibling (feed or category)',	// TODO
		'mark_updated_article_unread' => 'Mark updated articles as unread',	// TODO
		'number_divided_when_reader' => 'Divide by 2 in the reading view.',	// TODO
		'read' => array(
			'article_open_on_website' => 'when the article is opened on its original website',	// TODO
			'article_viewed' => 'when the article is viewed',	// TODO
			'focus' => 'when focused (except for important feeds)',	// TODO
			'keep_max_n_unread' => 'Max number of articles to keep unread',	// TODO
			'scroll' => 'while scrolling (except for important feeds)',	// TODO
			'upon_gone' => 'when it is no longer in the upstream news feed',	// TODO
			'upon_reception' => 'upon receiving the article',	// TODO
			'when' => 'Mark an article as read…',	// TODO
			'when_same_title' => 'if an identical title already exists in the top <i>n</i> newest articles',	// TODO
		),
		'show' => array(
			'_' => 'Articles to display',	// TODO
			'active_category' => 'Active category',	// TODO
			'adaptive' => 'Adjust showing',	// TODO
			'all_articles' => 'Show all articles',	// TODO
			'all_categories' => 'All categories',	// TODO
			'no_category' => 'No category',	// TODO
			'remember_categories' => 'Remember open categories',	// TODO
			'unread' => 'Show only unread',	// TODO
		),
		'show_fav_unread_help' => 'Applies also on labels',	// TODO
		'sides_close_article' => 'Clicking outside of article text area closes the article',	// TODO
		'sort' => array(
			'_' => 'Sort order',	// TODO
			'newer_first' => 'Newest first',	// TODO
			'older_first' => 'Oldest first',	// TODO
		),
		'sticky_post' => 'Stick the article to the top when opened',	// TODO
		'title' => 'Reading',	// TODO
		'view' => array(
			'default' => 'Default view',	// TODO
			'global' => 'Global view',	// TODO
			'normal' => 'Normal view',	// TODO
			'reader' => 'Reading view',	// TODO
		),
	),
	'sharing' => array(
		'_' => 'Sharing',	// TODO
		'add' => 'Add a sharing method',	// TODO
		'blogotext' => 'Blogotext',	// TODO
		'deprecated' => 'This service is deprecated and will be removed from FreshRSS in a <a href="https://freshrss.github.io/FreshRSS/en/users/08_sharing_services.html" title="Open documentation for more information" target="_blank">future release</a>.',	// TODO
		'diaspora' => 'Diaspora*',	// TODO
		'email' => 'Email',	// TODO
		'facebook' => 'Facebook',	// TODO
		'more_information' => 'More information',	// TODO
		'print' => 'Print',	// TODO
		'raindrop' => 'Raindrop.io',	// TODO
		'remove' => 'Remove sharing method',	// TODO
		'shaarli' => 'Shaarli',	// TODO
		'share_name' => 'Share name to display',	// TODO
		'share_url' => 'Share URL to use',	// TODO
		'title' => 'Sharing',	// TODO
		'twitter' => 'Twitter',	// TODO
		'wallabag' => 'wallabag',	// TODO
	),
	'shortcut' => array(
		'_' => 'Shortcuts',	// TODO
		'article_action' => 'Article actions',	// TODO
		'auto_share' => 'Share',	// TODO
		'auto_share_help' => 'If there is only one sharing mode, it is used. Otherwise, modes are accessible by their number.',	// TODO
		'close_dropdown' => 'Close menus',	// TODO
		'collapse_article' => 'Collapse',	// TODO
		'first_article' => 'Open the first article',	// TODO
		'focus_search' => 'Access search box',	// TODO
		'global_view' => 'Switch to global view',	// TODO
		'help' => 'Display documentation',	// TODO
		'javascript' => 'JavaScript must be enabled in order to use shortcuts',	// TODO
		'last_article' => 'Open the last article',	// TODO
		'load_more' => 'Load more articles',	// TODO
		'mark_favorite' => 'Toggle favourite',	// TODO
		'mark_read' => 'Toggle read',	// TODO
		'navigation' => 'Navigation',	// TODO
		'navigation_help' => 'With the <kbd>⇧ Shift</kbd> modifier, navigation shortcuts apply on feeds.<br/>With the <kbd>Alt ⎇</kbd> modifier, navigation shortcuts apply on categories.',	// TODO
		'navigation_no_mod_help' => 'The following navigation shortcuts do not support modifiers.',	// TODO
		'next_article' => 'Open the next article',	// TODO
		'next_unread_article' => 'Open the next unread article',	// TODO
		'non_standard' => 'Some keys (<kbd>%s</kbd>) may not work as shortcuts.',	// TODO
		'normal_view' => 'Switch to normal view',	// TODO
		'other_action' => 'Other actions',	// TODO
		'previous_article' => 'Open the previous article',	// TODO
		'reading_view' => 'Switch to reading view',	// TODO
		'rss_view' => 'Open as RSS feed',	// TODO
		'see_on_website' => 'See on original website',	// TODO
		'shift_for_all_read' => '+ <kbd>Alt ⎇</kbd> to mark previous articles as read<br />+ <kbd>⇧ Shift</kbd> to mark all articles as read',	// TODO
		'skip_next_article' => 'Focus next without opening',	// TODO
		'skip_previous_article' => 'Focus previous without opening',	// TODO
		'title' => 'Shortcuts',	// TODO
		'toggle_media' => 'Play/pause media',	// TODO
		'user_filter' => 'Access user queries',	// TODO
		'user_filter_help' => 'If there is only one user query, it is used. Otherwise, queries are accessible by their number.',	// TODO
		'views' => 'Views',	// TODO
	),
	'user' => array(
		'articles_and_size' => '%s articles (%s)',	// TODO
		'current' => 'Current user',	// TODO
		'is_admin' => 'is administrator',	// TODO
		'users' => 'Users',	// TODO
	),
);
