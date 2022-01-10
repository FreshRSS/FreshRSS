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
		'_' => 'About',
		'agpl3' => '<a href="https://www.gnu.org/licenses/agpl-3.0.html">AGPL 3</a>',
		'bugs_reports' => 'Bug reports',
		'credits' => 'Credits',
		'credits_content' => 'Some design elements come from <a href="http://twitter.github.io/bootstrap/">Bootstrap</a> although FreshRSS doesn’t use this framework. <a href="https://git.gnome.org/browse/gnome-icon-theme-symbolic">Icons</a> come from <a href="https://www.gnome.org/">GNOME project</a>. <em>Open Sans</em> font police has been created by <a href="https://fonts.google.com/specimen/Open+Sans">Steve Matteson</a>. FreshRSS is based on <a href="https://github.com/marienfressinaud/MINZ">Minz</a>, a PHP framework.',
		'freshrss_description' => 'FreshRSS is a RSS feeds aggregator to self-host like <a href="http://tontof.net/kriss/feed/">Kriss Feed</a> or <a href="https://github.com/LeedRSS/Leed">Leed</a>. It is light and easy to take in hand while being powerful and configurable tool.',
		'github' => '<a href="https://github.com/FreshRSS/FreshRSS/issues">on Github</a>',
		'license' => 'License',
		'project_website' => 'Project website',
		'title' => 'About',
		'version' => 'Version',
	),
	'feed' => array(
		'add' => 'Please add some feeds.',
		'empty' => 'There are no articles to show.',
		'rss_of' => 'RSS feed of %s',
		'title' => 'Main stream',
		'title_fav' => 'Favourites',
		'title_global' => 'Global view',
	),
	'log' => array(
		'_' => 'Logs',
		'clear' => 'Clear the logs',
		'empty' => 'Log file is empty',
		'title' => 'Logs',
	),
	'menu' => array(
		'about' => 'About FreshRSS',
		'before_one_day' => 'Older than one day',
		'before_one_week' => 'Older than one week',
		'bookmark_query' => 'Bookmark current query',
		'favorites' => 'Favourites (%s)',
		'global_view' => 'Global view',
		'main_stream' => 'Main stream',
		'mark_all_read' => 'Mark all as read',
		'mark_cat_read' => 'Mark category as read',
		'mark_feed_read' => 'Mark feed as read',
		'mark_selection_unread' => 'Mark selection as unread',
		'newer_first' => 'Newer first',
		'non-starred' => 'Show non-favourites',
		'normal_view' => 'Normal view',
		'older_first' => 'Oldest first',
		'queries' => 'User queries',
		'read' => 'Show read',
		'reader_view' => 'Reading view',
		'rss_view' => 'RSS feed',
		'search_short' => 'Search',
		'starred' => 'Show favourites',
		'stats' => 'Statistics',
		'subscription' => 'Subscription management',
		'tags' => 'My labels',
		'unread' => 'Show unread',
	),
	'share' => 'Share',
	'tag' => array(
		'related' => 'Article tags',
	),
	'tos' => array(
		'title' => 'Terms of Service',
	),
);
