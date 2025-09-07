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
		'_' => 'אודות',
		'agpl3' => '<a href="https://www.gnu.org/licenses/agpl-3.0.html">AGPL 3</a>',	// IGNORE
		'bug_reports' => array(
			'environment_information' => array(
				'_' => 'System information',	// TODO
				'browser' => 'Browser',	// TODO
				'database' => 'Database',	// TODO
				'server_software' => 'Server software',	// TODO
				'version_curl' => 'cURL version',	// TODO
				'version_frss' => 'FreshRSS version',	// TODO
				'version_php' => 'PHP version',	// TODO
			),
		),
		'bugs_reports' => 'דיווח באגים',
		'documentation' => 'Documentation',	// TODO
		'freshrss_description' => 'FreshRSS הוא קורא RSS לאחסון עצמי .אינו צורך משאבים רבים, וקל לתפעול אך בו בזמן חזק וניתן להתאמה.',
		'github' => '<a href="https://github.com/FreshRSS/FreshRSS/issues">בגיטהאב</a>',
		'license' => 'רישיון',
		'project_website' => 'אתר',
		'title' => 'אודות',
		'version' => 'גרסה',
	),
	'feed' => array(
		'empty' => 'אין מאמר להצגה.',
		'received' => array(
			'before_yesterday' => 'Received before yesterday',	// TODO
			'today' => 'Received today',	// TODO
			'yesterday' => 'Received yesterday',	// TODO
		),
		'rss_of' => 'הזנת RSS של %s',
		'title' => 'הזנה ראשית',
		'title_fav' => 'מועדפים',
		'title_global' => 'תצוגה גלובלית',
	),
	'log' => array(
		'_' => 'לוגים',
		'clear' => 'ניקוי הלוגים',
		'empty' => 'קובץ הלוג ריק',
		'title' => 'לוגים',
	),
	'menu' => array(
		'about' => 'אודות FreshRSS',
		'before_one_day' => 'אתמול',
		'before_one_week' => 'לפני שבוע',
		'bookmark_query' => 'Bookmark current query',	// TODO
		'favorites' => 'מועדפים (%s)',
		'global_view' => 'תצוגה גלובלית',
		'important' => 'Important feeds',	// TODO
		'main_stream' => 'הזנה ראשית',
		'mark_all_read' => 'סימון הכל כנקרא',
		'mark_cat_read' => 'סימון קטגוריה כנקראה',
		'mark_feed_read' => 'סימון הזנה כנקראה',
		'mark_selection_unread' => 'Mark selection as unread',	// TODO
		'mylabels' => 'My labels',	// TODO
		'newer_first' => 'חדשים בראש',
		'non-starred' => 'הצגת הכל פרט למועדפים',
		'normal_view' => 'תצוגה רגילה',
		'older_first' => 'ישנים יותר בראש',
		'queries' => 'שאילתות',
		'read' => 'הצגת נקראו בלבד',
		'reader_view' => 'תצוגת קריאה',
		'rss_view' => 'הזנת RSS',
		'search_short' => 'חיפוש',
		'sort' => array(
			'_' => 'Sorting criteria',	// TODO
			'c' => array(
				'name_asc' => 'Category, feed titles A→Z',	// TODO
				'name_desc' => 'Category, feed titles Z→A',	// TODO
			),
			'date_asc' => 'Publication date 1→9',	// TODO
			'date_desc' => 'Publication date 9→1',	// TODO
			'f' => array(
				'name_asc' => 'Feed title A→Z',	// TODO
				'name_desc' => 'Feed title Z→A',	// TODO
			),
			'id_asc' => 'Freshly received last',	// TODO
			'id_desc' => 'Freshly received first',	// TODO
			'link_asc' => 'Link A→Z',	// TODO
			'link_desc' => 'Link Z→A',	// TODO
			'rand' => 'Random order',	// TODO
			'title_asc' => 'Title A→Z',	// TODO
			'title_desc' => 'Title Z→A',	// TODO
		),
		'starred' => 'הצגת מועדפים בלבד',
		'stats' => 'סטטיסטיקות',
		'subscription' => 'ניהול הרשמות',
		'unread' => 'הצגת מאמרים שלא נקראו בלבד',
	),
	'share' => 'שיתוף',
	'tag' => array(
		'related' => 'תגיות קשורות',
	),
	'tos' => array(
		'title' => 'Terms of Service',	// TODO
	),
);
