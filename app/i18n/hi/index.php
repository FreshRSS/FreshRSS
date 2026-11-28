<?php

/******************************************************************************
 * Each entry of that file can be associated with a comment to indicate its   *
 * state. When there is no comment, it means the entry is fully translated.   *
 * The recognized comments are (comment matching is case-insensitive):        *
 *   + TODO: the entry has never been translated.                             *
 *   + DIRTY: the entry has been translated but needs to be updated.          *
 *   + IGNORE: the entry does not need to be translated.                      *
 * When a comment is not recognized, it is discarded.                         *
 ******************************************************************************/

return array(
	'about' => array(
		'_' => 'जानकारी',
		'agpl3' => '<a href="https://www.gnu.org/licenses/agpl-3.0.html">AGPL 3</a>',	// IGNORE
		'bug_reports' => array(
			'environment_information' => array(
				'_' => 'सिस्टम जानकारी',
				'browser' => 'ब्राउज़र',
				'database' => 'डेटाबेस',
				'server_software' => 'सर्वर सॉफ़्टवेयर',
				'version_curl' => 'cURL वर्शन',
				'version_frss' => 'FreshRSS वर्शन',
				'version_php' => 'PHP वर्शन',
			),
		),
		'bugs_reports' => 'बग रिपोर्ट',
		'documentation' => 'दस्तावेज़',
		'freshrss_description' => 'FreshRSS एक RSS एग्रीगेटर और रीडर है, जिसे आप खुद होस्ट कर सकते हैं। इससे आप एक वेबसाइट से दूसरी पर गए बिना, एक ही नज़र में कई न्यूज़ वेबसाइट पढ़ और फ़ॉलो कर सकते हैं। FreshRSS हल्का, कॉन्फ़िगर करने योग्य और इस्तेमाल में आसान है।',
		'github' => '<a href="https://github.com/FreshRSS/FreshRSS/issues">GitHub पर</a>',
		'license' => 'लाइसेंस',
		'project_website' => 'प्रोजेक्ट की वेबसाइट',
		'title' => 'जानकारी',
		'version' => 'वर्शन',
	),
	'feed' => array(
		'empty' => 'दिखाने के लिए कोई लेख नहीं है।',
		'published' => array(
			'_' => 'प्रकाशित',
			'future' => 'भविष्य की तारीख में प्रकाशित',
			'today' => 'आज प्रकाशित',
			'yesterday' => 'कल प्रकाशित',
		),
		'received' => array(
			'_' => 'मिला',
			'today' => 'आज मिला',
			'yesterday' => 'कल मिला',
		),
		'rss_of' => '%s की RSS फ़ीड',
		'title' => 'मुख्य स्ट्रीम',
		'title_fav' => 'पसंदीदा',
		'title_global' => 'ग्लोबल व्यू',
		'userModified' => array(
			'_' => 'यूज़र ने बदला',
			'today' => 'यूज़र ने आज बदला',
			'yesterday' => 'यूज़र ने कल बदला',
		),
	),
	'log' => array(
		'_' => 'लॉग',
		'clear' => 'लॉग साफ़ करें',
		'empty' => 'लॉग फ़ाइल खाली है',
		'title' => 'लॉग',
	),
	'menu' => array(
		'about' => 'FreshRSS के बारे में',
		'before_one_day' => 'एक दिन से पुराने',
		'before_one_week' => 'एक हफ़्ते से पुराने',
		'bookmark_query' => 'मौजूदा क्वेरी बुकमार्क करें',
		'favorites' => 'पसंदीदा (%s)',
		'global_view' => 'ग्लोबल व्यू',
		'important' => 'महत्वपूर्ण फ़ीड',
		'main_stream' => 'मुख्य स्ट्रीम',
		'mark_all_read' => 'सभी को पढ़ा हुआ मार्क करें',
		'mark_cat_read' => 'श्रेणी को पढ़ा हुआ मार्क करें',
		'mark_feed_read' => 'फ़ीड को पढ़ा हुआ मार्क करें',
		'mark_selection_unread' => 'चुने गए लेखों को अपठित मार्क करें',
		'mylabels' => 'मेरे लेबल',
		'non-starred' => 'जो पसंदीदा नहीं हैं, वे दिखाएं',
		'normal_view' => 'सामान्य व्यू',
		'queries' => 'यूज़र क्वेरी',
		'read' => 'पढ़े गए दिखाएं',
		'reader_view' => 'रीडिंग व्यू',
		'rss_view' => 'RSS फ़ीड',
		'search_short' => 'खोजें',
		'sort' => array(
			'asc' => 'आरोही क्रम',
			'c' => array(
				'name_asc' => 'श्रेणी, फ़ीड के शीर्षक A→Z',
				'name_desc' => 'श्रेणी, फ़ीड के शीर्षक Z→A',
			),
			'date_asc' => 'प्रकाशन की तारीख 1→9',
			'date_desc' => 'प्रकाशन की तारीख 9→1',
			'desc' => 'अवरोही क्रम',
			'f' => array(
				'name_asc' => 'फ़ीड का शीर्षक A→Z',
				'name_desc' => 'फ़ीड का शीर्षक Z→A',
			),
			'id_asc' => 'हाल में मिले लेख आखिर में',
			'id_desc' => 'हाल में मिले लेख पहले',
			'length_asc' => 'कंटेंट की लंबाई 1→9',
			'length_desc' => 'कंटेंट की लंबाई 9→1',
			'link_asc' => 'लिंक A→Z',
			'link_desc' => 'लिंक Z→A',
			'primary' => array(
				'_' => 'क्रम का आधार',
				'help' => 'एक जैसे नतीजों और बेहतर परफ़ॉर्मेंस के लिए ज़्यादातर मामलों में <em>मिलने</em> की तारीख से क्रम लगाने की सलाह दी जाती है',
			),
			'rand' => 'बेतरतीब क्रम',
			'secondary' => array(
				'_' => 'क्रम का दूसरा आधार',
				'help' => 'सिर्फ़ तब काम का है, जब क्रम का पहला आधार श्रेणियां या फ़ीड के शीर्षक हों',
			),
			'title_asc' => 'शीर्षक A→Z',
			'title_desc' => 'शीर्षक Z→A',
			'user_modified_asc' => 'यूज़र के बदलाव की तारीख 1→9',
			'user_modified_desc' => 'यूज़र के बदलाव की तारीख 9→1',
		),
		'starred' => 'पसंदीदा दिखाएं',
		'stats' => 'आंकड़े',
		'subscription' => 'सब्सक्रिप्शन मैनेजमेंट',
		'unread' => 'अपठित दिखाएं',
	),
	'share' => 'शेयर करें',
	'tag' => array(
		'related' => 'लेख के टैग',
	),
	'tos' => array(
		'title' => 'सेवा की शर्तें',
	),
);
