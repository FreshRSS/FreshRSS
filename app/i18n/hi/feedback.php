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
	'access' => array(
		'denied' => 'आपके पास यह पेज देखने की अनुमति नहीं है',
		'not_found' => 'आप ऐसा पेज ढूंढ रहे हैं जो मौजूद नहीं है',
	),
	'admin' => array(
		'optimization_complete' => 'ऑप्टिमाइज़ेशन पूरा हुआ',
	),
	'api' => array(
		'password' => array(
			'failed' => 'आपका पासवर्ड बदला नहीं जा सकता',
			'updated' => 'आपका पासवर्ड बदल दिया गया है',
		),
	),
	'auth' => array(
		'login' => array(
			'invalid' => 'लॉगिन अमान्य है',
			'success' => 'आप कनेक्ट हो गए हैं',
		),
		'logout' => array(
			'success' => 'आप डिस्कनेक्ट हो गए हैं',
		),
	),
	'conf' => array(
		'error' => 'कॉन्फ़िगरेशन सहेजते समय एक त्रुटि हुई',
		'query_created' => 'क्वेरी “%s” बना दी गई है।',
		'shortcuts_updated' => 'शॉर्टकट अपडेट कर दिए गए हैं',
		'updated' => 'कॉन्फ़िगरेशन अपडेट कर दिया गया है',
	),
	'extensions' => array(
		'already_enabled' => '%s पहले से चालू है',
		'cannot_remove' => '%s को हटाया नहीं जा सकता',
		'disable' => array(
			'ko' => '%s को बंद नहीं किया जा सकता। विवरण के लिए <a href="%s">FreshRSS लॉग देखें</a>।',
			'ok' => '%s अब बंद है',
		),
		'enable' => array(
			'ko' => '%s को चालू नहीं किया जा सकता। विवरण के लिए <a href="%s">FreshRSS लॉग देखें</a>।',
			'ok' => '%s अब चालू है',
		),
		'invalid_view_mode' => 'अमान्य व्यू मोड “%s”! “सामान्य व्यू” इस्तेमाल किया जा रहा है।',
		'no_access' => 'आपके पास %s का एक्सेस नहीं है',
		'not_enabled' => '%s चालू नहीं है',
		'not_found' => '%s मौजूद नहीं है',
		'removed' => '%s हटा दिया गया',
	),
	'import_export' => array(
		'export_no_zip_extension' => 'आपके सर्वर पर ZIP एक्सटेंशन मौजूद नहीं है। कृपया फ़ाइलें एक-एक करके एक्सपोर्ट करें।',
		'feeds_imported' => 'आपकी फ़ीड इम्पोर्ट हो गई हैं। अगर इम्पोर्ट पूरा हो गया है, तो अब आप <i>फ़ीड अपडेट करें</i> बटन पर क्लिक कर सकते हैं।',
		'feeds_imported_with_errors' => 'आपकी फ़ीड इम्पोर्ट हो गई हैं, लेकिन कुछ त्रुटियां हुईं। अगर इम्पोर्ट पूरा हो गया है, तो अब आप <i>फ़ीड अपडेट करें</i> बटन पर क्लिक कर सकते हैं।',
		'file_cannot_be_uploaded' => 'फ़ाइल अपलोड नहीं हो सकती!',
		'no_zip_extension' => 'आपके सर्वर पर ZIP एक्सटेंशन मौजूद नहीं है।',
		'zip_error' => 'ZIP प्रोसेस करते समय एक त्रुटि हुई।',
	),
	'profile' => array(
		'error' => 'आपकी प्रोफ़ाइल बदली नहीं जा सकती',
		'passwords_dont_match' => 'पासवर्ड मेल नहीं खाते',
		'updated' => 'आपकी प्रोफ़ाइल बदल दी गई है',
	),
	'sub' => array(
		'actualize' => 'अपडेट हो रहा है',
		'articles' => array(
			'marked_read' => 'चुने गए लेख पढ़े हुए मार्क कर दिए गए हैं।',
			'marked_unread' => 'लेख अपठित मार्क कर दिए गए हैं।',
		),
		'category' => array(
			'created' => 'श्रेणी %s बना दी गई है।',
			'deleted' => 'श्रेणी हटा दी गई है।',
			'emptied' => 'श्रेणी खाली कर दी गई है',
			'error' => 'श्रेणी अपडेट नहीं हो सकती',
			'name_exists' => 'इस नाम की श्रेणी पहले से मौजूद है।',
			'no_id' => 'आपको श्रेणी की id बतानी होगी।',
			'no_name' => 'श्रेणी का नाम खाली नहीं हो सकता।',
			'not_delete_default' => 'आप डिफ़ॉल्ट श्रेणी नहीं हटा सकते!',
			'not_exist' => 'यह श्रेणी मौजूद नहीं है!',
			'over_max' => 'आप श्रेणियों की अपनी सीमा (%d) तक पहुंच गए हैं',
			'updated' => 'श्रेणी अपडेट कर दी गई है।',
		),
		'feed' => array(
			'actualized' => '<em>%s</em> अपडेट कर दी गई है',
			'actualizeds' => 'RSS फ़ीड अपडेट कर दी गई हैं',
			'added' => 'RSS फ़ीड <em>%s</em> जोड़ दी गई है',
			'already_subscribed' => 'आप <em>%s</em> को पहले से सब्सक्राइब कर चुके हैं',
			'cache_cleared' => '<em>%s</em> का कैश साफ़ कर दिया गया है',
			'deleted' => 'फ़ीड हटा दी गई है',
			'error' => 'फ़ीड अपडेट नहीं हो सकती',
			'favicon' => array(
				'too_large' => 'अपलोड किया गया आइकन बहुत बड़ा है। फ़ाइल का अधिकतम आकार <em>%s</em> है।',
				'unsupported_format' => 'इमेज फ़ाइल का फ़ॉर्मेट समर्थित नहीं है!',
			),
			'internal_problem' => 'न्यूज़ फ़ीड जोड़ी नहीं जा सकी। विवरण के लिए <a href="%s">FreshRSS लॉग देखें</a>। आप URL के आखिर में <code>#force_feed</code> जोड़कर इसे ज़बरदस्ती जोड़ने की कोशिश कर सकते हैं।',
			'invalid_url' => 'URL <em>%s</em> अमान्य है',
			'n_actualized' => '%d फ़ीड अपडेट कर दी गई हैं',
			'n_entries_deleted' => '%d लेख हटा दिए गए हैं',
			'no_refresh' => 'रीफ़्रेश करने के लिए कोई फ़ीड नहीं है',
			'not_added' => '<em>%s</em> जोड़ी नहीं जा सकी',
			'not_found' => 'फ़ीड नहीं मिली',
			'over_max' => 'आप फ़ीड की अपनी सीमा (%d) तक पहुंच गए हैं',
			'reloaded' => '<em>%s</em> दोबारा लोड कर दी गई है',
			'selector_preview' => array(
				'http_error' => 'वेबसाइट का कंटेंट लोड नहीं हो सका।',
				'no_entries' => 'इस फ़ीड में कोई लेख नहीं है। प्रीव्यू बनाने के लिए कम से कम एक लेख चाहिए।',
				'no_feed' => 'आंतरिक त्रुटि (फ़ीड नहीं मिली)।',
				'no_result' => 'सिलेक्टर किसी चीज़ से मेल नहीं खाया। इसकी जगह फ़ीड का मूल टेक्स्ट दिखाया जाएगा।',
				'selector_empty' => 'सिलेक्टर खाली है। प्रीव्यू बनाने के लिए आपको एक सिलेक्टर देना होगा।',
			),
			'updated' => 'फ़ीड अपडेट कर दी गई है',
		),
		'purge_completed' => 'सफ़ाई पूरी हुई (%d लेख हटाए गए)',
	),
	'tag' => array(
		'created' => 'लेबल “%s” बना दिया गया है।',
		'error' => 'लेबल अपडेट नहीं हो सका!',
		'name_exists' => 'इस नाम का लेबल पहले से मौजूद है।',
		'renamed' => 'लेबल “%s” का नाम बदलकर “%s” कर दिया गया है।',
		'updated' => 'लेबल अपडेट कर दिया गया है।',
	),
	'update' => array(
		'can_apply' => 'FreshRSS का एक अपडेट उपलब्ध है: <strong>वर्शन %s</strong>।',
		'error' => 'अपडेट के दौरान एक त्रुटि हुई: %s',
		'file_is_nok' => 'FreshRSS का एक अपडेट उपलब्ध है (<strong>वर्शन %s</strong>), लेकिन <em>%s</em> डायरेक्टरी की अनुमतियां जांचें। HTTP सर्वर के पास लिखने की अनुमति होनी चाहिए',
		'finished' => 'अपडेट पूरा हुआ!',
		'none' => 'कोई अपडेट उपलब्ध नहीं है',
		'server_not_found' => 'अपडेट सर्वर नहीं मिला। [%s]',
	),
	'user' => array(
		'created' => array(
			'_' => 'यूज़र %s बना दिया गया है',
			'error' => 'यूज़र %s नहीं बनाया जा सका',
		),
		'deleted' => array(
			'_' => 'यूज़र %s हटा दिया गया है',
			'error' => 'यूज़र %s नहीं हटाया जा सका',
		),
		'updated' => array(
			'_' => 'यूज़र %s अपडेट कर दिया गया है',
			'error' => 'यूज़र %s अपडेट नहीं हुआ',
		),
	),
);
