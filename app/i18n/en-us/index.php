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
	'about' => array(
		'_' => 'About',	// IGNORE
		'agpl3' => '<a href="https://www.gnu.org/licenses/agpl-3.0.html">AGPL 3</a>',	// IGNORE
		'bug_reports' => array(
			'environment_information' => array(
				'_' => 'System information',	// IGNORE
				'browser' => 'Browser',	// IGNORE
				'database' => 'Database',	// IGNORE
				'server_software' => 'Server software',	// IGNORE
				'version_curl' => 'cURL version',	// IGNORE
				'version_frss' => 'FreshRSS version',	// IGNORE
				'version_php' => 'PHP version',	// IGNORE
			),
		),
		'bugs_reports' => 'Bug reports',	// IGNORE
		'documentation' => 'Documentation',	// IGNORE
		'freshrss_description' => 'FreshRSS is a self-hostable RSS aggregator and reader. It allows you to read and follow several news websites at a glance without the need to browse from one website to another. FreshRSS is lightweight, configurable, and easy to use.',	// IGNORE
		'github' => '<a href="https://github.com/FreshRSS/FreshRSS/issues">on GitHub</a>',	// IGNORE
		'license' => 'License',	// IGNORE
		'project_website' => 'Project website',	// IGNORE
		'title' => 'About',	// IGNORE
		'version' => 'Version',	// IGNORE
	),
	'feed' => array(
		'empty' => 'There are no articles to show.',	// IGNORE
		'received' => array(
			'before_yesterday' => 'Received before yesterday',	// IGNORE
			'today' => 'Received today',	// IGNORE
			'yesterday' => 'Received yesterday',	// IGNORE
		),
		'rss_of' => 'RSS feed of %s',	// IGNORE
		'title' => 'Main stream',	// IGNORE
		'title_fav' => 'Favorites',
		'title_global' => 'Global view',	// IGNORE
	),
	'log' => array(
		'_' => 'Logs',	// IGNORE
		'clear' => 'Clear the logs',	// IGNORE
		'empty' => 'Log file is empty',	// IGNORE
		'title' => 'Logs',	// IGNORE
	),
	'menu' => array(
		'about' => 'About FreshRSS',	// IGNORE
		'before_one_day' => 'Older than one day',	// IGNORE
		'before_one_week' => 'Older than one week',	// IGNORE
		'bookmark_query' => 'Bookmark current query',	// IGNORE
		'favorites' => 'Favorites (%s)',
		'global_view' => 'Global view',	// IGNORE
		'important' => 'Important feeds',	// IGNORE
		'main_stream' => 'Main stream',	// IGNORE
		'mark_all_read' => 'Mark all as read',	// IGNORE
		'mark_cat_read' => 'Mark category as read',	// IGNORE
		'mark_feed_read' => 'Mark feed as read',	// IGNORE
		'mark_selection_unread' => 'Mark selection as unread',	// IGNORE
		'mylabels' => 'My labels',	// IGNORE
		'newer_first' => 'Newer first',	// IGNORE
		'non-starred' => 'Show non-favorites',
		'normal_view' => 'Normal view',	// IGNORE
		'older_first' => 'Oldest first',	// IGNORE
		'queries' => 'User queries',	// IGNORE
		'read' => 'Show read',	// IGNORE
		'reader_view' => 'Reading view',	// IGNORE
		'rss_view' => 'RSS feed',	// IGNORE
		'search_short' => 'Search',	// IGNORE
		'sort' => array(
			'_' => 'Sorting criteria',	// IGNORE
			'c' => array(
				'name_asc' => 'Category, feed titles A→Z',	// IGNORE
				'name_desc' => 'Category, feed titles Z→A',	// IGNORE
			),
			'date_asc' => 'Publication date 1→9',	// IGNORE
			'date_desc' => 'Publication date 9→1',	// IGNORE
			'f' => array(
				'name_asc' => 'Feed title A→Z',	// IGNORE
				'name_desc' => 'Feed title Z→A',	// IGNORE
			),
			'id_asc' => 'Freshly received last',	// IGNORE
			'id_desc' => 'Freshly received first',	// IGNORE
			'link_asc' => 'Link A→Z',	// IGNORE
			'link_desc' => 'Link Z→A',	// IGNORE
			'rand' => 'Random order',	// IGNORE
			'title_asc' => 'Title A→Z',	// IGNORE
			'title_desc' => 'Title Z→A',	// IGNORE
		),
		'starred' => 'Show favorites',
		'stats' => 'Statistics',	// IGNORE
		'subscription' => 'Subscription management',	// IGNORE
		'unread' => 'Show unread',	// IGNORE
	),
	'share' => 'Share',	// IGNORE
	'tag' => array(
		'related' => 'Article tags',	// IGNORE
	),
	'tos' => array(
		'title' => 'Terms of Service',	// IGNORE
	),
);
