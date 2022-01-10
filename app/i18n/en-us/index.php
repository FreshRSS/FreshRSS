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
		'bugs_reports' => 'Bug reports',	// IGNORE
		'credits' => 'Credits',	// IGNORE
		'credits_content' => 'Some design elements come from <a href="http://twitter.github.io/bootstrap/">Bootstrap</a> although FreshRSS doesn’t use this framework. <a href="https://git.gnome.org/browse/gnome-icon-theme-symbolic">Icons</a> come from <a href="https://www.gnome.org/">GNOME project</a>. <em>Open Sans</em> font police has been created by <a href="https://fonts.google.com/specimen/Open+Sans">Steve Matteson</a>. FreshRSS is based on <a href="https://github.com/marienfressinaud/MINZ">Minz</a>, a PHP framework.',	// IGNORE
		'freshrss_description' => 'FreshRSS is a RSS feeds aggregator to self-host like <a href="http://tontof.net/kriss/feed/">Kriss Feed</a> or <a href="https://github.com/LeedRSS/Leed">Leed</a>. It is light and easy to take in hand while being powerful and configurable tool.',	// IGNORE
		'github' => '<a href="https://github.com/FreshRSS/FreshRSS/issues">on Github</a>',	// IGNORE
		'license' => 'License',	// IGNORE
		'project_website' => 'Project website',	// IGNORE
		'title' => 'About',	// IGNORE
		'version' => 'Version',	// IGNORE
	),
	'feed' => array(
		'add' => 'Please add some feeds.',	// IGNORE
		'empty' => 'There are no articles to show.',	// IGNORE
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
		'main_stream' => 'Main stream',	// IGNORE
		'mark_all_read' => 'Mark all as read',	// IGNORE
		'mark_cat_read' => 'Mark category as read',	// IGNORE
		'mark_feed_read' => 'Mark feed as read',	// IGNORE
		'mark_selection_unread' => 'Mark selection as unread',	// IGNORE
		'newer_first' => 'Newer first',	// IGNORE
		'non-starred' => 'Show non-favorites',
		'normal_view' => 'Normal view',	// IGNORE
		'older_first' => 'Oldest first',	// IGNORE
		'queries' => 'User queries',	// IGNORE
		'read' => 'Show read',	// IGNORE
		'reader_view' => 'Reading view',	// IGNORE
		'rss_view' => 'RSS feed',	// IGNORE
		'search_short' => 'Search',	// IGNORE
		'starred' => 'Show favorites',
		'stats' => 'Statistics',	// IGNORE
		'subscription' => 'Subscription management',	// IGNORE
		'tags' => 'My labels',	// IGNORE
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
