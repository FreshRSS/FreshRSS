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
	'api' => array(
		'documentation' => 'किसी बाहरी टूल में इस्तेमाल करने के लिए नीचे दिया URL कॉपी करें।',
		'title' => 'API',	// IGNORE
	),
	'bookmarklet' => array(
		'documentation' => 'इस बटन को अपने बुकमार्क टूलबार पर खींचें या इस पर राइट-क्लिक करके “इस लिंक को बुकमार्क करें” चुनें। फिर जिस भी पेज को सब्सक्राइब करना हो, वहां “सब्सक्राइब करें” बटन पर क्लिक करें।',
		'label' => 'सब्सक्राइब करें',
		'title' => 'बुकमार्कलेट',
	),
	'category' => array(
		'_' => 'श्रेणी',
		'add' => 'श्रेणी जोड़ें',
		'archiving' => 'आर्काइविंग',
		'dynamic_opml' => array(
			'_' => 'डायनेमिक OPML',
			'help' => 'इस श्रेणी में फ़ीड अपने-आप भरने के लिए किसी <a href="https://opml.org/" target="_blank">OPML फ़ाइल</a> का URL दें',
		),
		'empty' => 'खाली श्रेणी',
		'error' => 'इस डायनेमिक OPML श्रेणी में एक समस्या आई है। जांचें कि OPML URL अब भी पहुंच में है और हर यूज़र के लिए फ़ीड की अधिकतम संख्या पार नहीं हुई है।',
		'expand' => 'श्रेणी खोलें',
		'information' => 'जानकारी',
		'open' => 'श्रेणी खोलें',
		'opml_url' => 'OPML URL',	// IGNORE
		'position' => 'दिखाने की जगह',
		'position_help' => 'श्रेणियों का क्रम तय करने के लिए',
		'title' => 'शीर्षक',
	),
	'feed' => array(
		'accept_cookies' => 'कुकीज़ स्वीकार करें',
		'accept_cookies_help' => 'फ़ीड सर्वर को कुकीज़ सेट करने दें (सिर्फ़ रिक्वेस्ट की अवधि तक मेमोरी में रखी जाती हैं)',
		'add' => 'फ़ीड जोड़ें',
		'advanced' => 'एडवांस्ड',
		'archiving' => 'आर्काइविंग',
		'auth' => array(
			'configuration' => 'लॉगिन',
			'help' => 'HTTP से सुरक्षित RSS फ़ीड तक पहुंच देता है',
			'http' => 'HTTP प्रमाणीकरण',
			'password' => 'HTTP पासवर्ड',
			'username' => 'HTTP यूज़रनेम',
		),
		'change_favicon' => 'बदलें…',
		'clear_cache' => 'हमेशा कैश साफ़ करें',
		'content_action' => array(
			'_' => 'लेख का कंटेंट लाते समय कंटेंट के साथ क्या करें',
			'append' => 'मौजूदा कंटेंट के बाद जोड़ें',
			'prepend' => 'मौजूदा कंटेंट से पहले जोड़ें',
			'replace' => 'मौजूदा कंटेंट की जगह रखें',
		),
		'content_retrieval' => 'कंटेंट लाना',
		'css_cookie' => 'लेख का कंटेंट लाते समय कुकीज़ इस्तेमाल करें',
		'css_cookie_help' => 'उदाहरण: <kbd>foo=bar; gdpr_consent=true; cookie=value</kbd>',
		'css_help' => 'अधूरी RSS फ़ीड का पूरा कंटेंट लाता है (ध्यान दें, इसमें ज़्यादा समय लगता है!)',
		'css_path' => 'मूल वेबसाइट पर लेख का CSS सिलेक्टर',
		'css_path_filter' => array(
			'_' => 'हटाए जाने वाले एलिमेंट का CSS सिलेक्टर',
			'help' => 'CSS सिलेक्टर एक सूची भी हो सकता है, जैसे: <kbd>footer, aside, p[data-sanitized-class~="menu"]</kbd>',
		),
		'description' => 'विवरण',
		'empty' => 'यह फ़ीड खाली है। कृपया जांचें कि इसे अब भी अपडेट किया जा रहा है।',
		'error' => 'इस फ़ीड में एक समस्या आई है। अगर यह बनी रहे, तो कृपया जांचें कि यह अब भी पहुंच में है।',
		'export-as-opml' => array(
			'download' => 'डाउनलोड करें',
			'help' => 'XML फ़ाइल (डेटा का एक हिस्सा। <a href="https://freshrss.github.io/FreshRSS/en/developers/OPML.html" target="_blank">दस्तावेज़ देखें</a>)',
			'label' => 'OPML के रूप में एक्सपोर्ट करें',
		),
		'ext_favicon' => 'अपने-आप सेट करें',
		'favicon_changed_by_ext' => 'आइकन <b>%s</b> एक्सटेंशन ने सेट किया है।',
		'filteractions' => array(
			'_' => 'फ़िल्टर कार्रवाइयां',
			'help' => 'हर लाइन में एक खोज फ़िल्टर लिखें। ऑपरेटर के लिए <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">दस्तावेज़ देखें</a>।',
			'view_filter' => 'मौजूदा लेखों पर फ़िल्टर का प्रीव्यू देखें (नई विंडो)',
		),
		'global_hint' => 'हर फ़ीड में कितने लेख किसी स्थिति या खोज एक्सप्रेशन से मेल खाते हैं, यह देखने के लिए <a href="%s">ग्लोबल व्यू</a> इस्तेमाल करें',
		'http_headers' => 'HTTP हेडर',
		'http_headers_help' => 'हेडर नई लाइन से अलग किए जाते हैं, और हेडर का नाम और मान कोलन से अलग होते हैं (जैसे: <kbd><code>Accept: application/atom+xml<br />Authorization: Bearer some-token</code></kbd>)।',
		'icon' => 'आइकन',
		'information' => 'जानकारी',
		'keep_adding_feed' => 'फिर और फ़ीड जोड़ें',
		'keep_min' => 'रखे जाने वाले लेखों की न्यूनतम संख्या',
		'kind' => array(
			'_' => 'फ़ीड स्रोत का प्रकार',
			'html_json' => array(
				'_' => 'HTML + XPath + JSON डॉट नोटेशन (HTML में JSON)',
				'xpath' => array(
					'_' => 'HTML में JSON के लिए XPath',
					'help' => 'उदाहरण: <code>normalize-space(//script[@type="application/json"])</code> (एक JSON)<br />या: <code>//script[@type="application/ld+json"]</code> (हर लेख के लिए एक JSON ऑब्जेक्ट)',
				),
			),
			'html_xpath' => array(
				'_' => 'HTML + XPath (वेब स्क्रेपिंग)',
				'feed_title' => array(
					'_' => 'फ़ीड का शीर्षक',
					'help' => 'उदाहरण: <code>//title</code> या कोई स्थिर स्ट्रिंग: <code>"मेरी कस्टम फ़ीड"</code>',
				),
				'help' => '<dfn><a href="https://www.w3.org/TR/xpath-10/" target="_blank">XPath 1.0</a></dfn> एडवांस्ड यूज़र के लिए एक मानक क्वेरी भाषा है, जिसे FreshRSS वेब स्क्रेपिंग के लिए सपोर्ट करता है।',
				'item' => array(
					'_' => 'समाचार <strong>आइटम</strong> ढूंढना<br /><small>(सबसे ज़रूरी)</small>',
					'help' => 'उदाहरण: <code>//div[@class="news-item"]</code>',
				),
				'item_author' => array(
					'_' => 'आइटम का लेखक',
					'help' => 'यह एक स्थिर स्ट्रिंग भी हो सकती है। उदाहरण: <code>"अनाम"</code>',
				),
				'item_categories' => 'आइटम के टैग',
				'item_content' => array(
					'_' => 'आइटम का कंटेंट',
					'help' => 'पूरा आइटम लेने के लिए उदाहरण: <code>.</code>',
				),
				'item_thumbnail' => array(
					'_' => 'आइटम का थंबनेल',
					'help' => 'उदाहरण: <code>descendant::img/@src</code>',
				),
				'item_timeFormat' => array(
					'_' => 'कस्टम तारीख/समय फ़ॉर्मेट',
					'help' => 'वैकल्पिक। <a href="https://www.php.net/datetime.createfromformat" target="_blank"><code>DateTime::createFromFormat()</code></a> से समर्थित कोई फ़ॉर्मेट, जैसे <code>d-m-Y H:i:s</code>',
				),
				'item_timestamp' => array(
					'_' => 'आइटम की तारीख',
					'help' => 'नतीजे को <a href="https://www.php.net/strtotime" target="_blank"><code>strtotime()</code></a> से पार्स किया जाएगा',
				),
				'item_title' => array(
					'_' => 'आइटम का शीर्षक',
					'help' => 'खास तौर पर <a href="https://developer.mozilla.org/docs/Web/XML/XPath/Reference/Axes" target="_blank">XPath axis</a> <code>descendant::</code> इस्तेमाल करें, जैसे <code>descendant::h2</code>',
				),
				'item_uid' => array(
					'_' => 'आइटम की यूनिक ID',
					'help' => 'वैकल्पिक। उदाहरण: <code>descendant::div/@data-uri</code>',
				),
				'item_uri' => array(
					'_' => 'आइटम का लिंक (URL)',
					'help' => 'उदाहरण: <code>descendant::a/@href</code>',
				),
				'relative' => 'इसके लिए XPath (आइटम के सापेक्ष):',
				'xpath' => 'इसके लिए XPath:',
			),
			'json_dotnotation' => array(
				'_' => 'JSON (डॉट नोटेशन)',
				'feed_title' => array(
					'_' => 'फ़ीड का शीर्षक',
					'help' => 'उदाहरण: <code>meta.title</code> या कोई स्थिर स्ट्रिंग: <code>"मेरी कस्टम फ़ीड"</code>',
				),
				'help' => 'JSON डॉट नोटेशन में ऑब्जेक्ट के बीच डॉट और array के लिए ब्रैकेट इस्तेमाल होते हैं (जैसे <code>data.items[0].title</code>)',
				'item' => array(
					'_' => 'समाचार <strong>आइटम</strong> ढूंढना<br /><small>(सबसे ज़रूरी)</small>',
					'help' => 'आइटम वाली array का JSON पाथ, जैसे <code>$</code> या <code>newsItems</code>',
				),
				'item_author' => 'आइटम का लेखक',
				'item_categories' => 'आइटम के टैग',
				'item_content' => array(
					'_' => 'आइटम का कंटेंट',
					'help' => 'वह key जिसके नीचे कंटेंट मिलता है, जैसे <code>content</code>',
				),
				'item_thumbnail' => array(
					'_' => 'आइटम का थंबनेल',
					'help' => 'उदाहरण: <code>image</code>',
				),
				'item_timeFormat' => array(
					'_' => 'कस्टम तारीख/समय फ़ॉर्मेट',
					'help' => 'वैकल्पिक। <a href="https://www.php.net/datetime.createfromformat" target="_blank"><code>DateTime::createFromFormat()</code></a> से समर्थित कोई फ़ॉर्मेट, जैसे <code>d-m-Y H:i:s</code>',
				),
				'item_timestamp' => array(
					'_' => 'आइटम की तारीख',
					'help' => 'नतीजे को <a href="https://www.php.net/strtotime" target="_blank"><code>strtotime()</code></a> से पार्स किया जाएगा',
				),
				'item_title' => 'आइटम का शीर्षक',
				'item_uid' => 'आइटम की यूनिक ID',
				'item_uri' => array(
					'_' => 'आइटम का लिंक (URL)',
					'help' => 'उदाहरण: <code>permalink</code>',
				),
				'json' => 'इसके लिए डॉट नोटेशन:',
				'relative' => 'इसके लिए डॉट नोटेशन वाला पाथ (आइटम के सापेक्ष):',
			),
			'jsonfeed' => 'JSON Feed',	// IGNORE
			'rss' => 'RSS / Atom (डिफ़ॉल्ट)',
			'xml_xpath' => 'XML + XPath',	// IGNORE
		),
		'last-entry-publication-date' => 'आखिरी लेख प्रकाशित हुआ <time datetime="%1$s" title="%1$s">%2$s</time>।',
		'last-entry-received-date' => 'आखिरी लेख मिला <time datetime="%1$s" title="%1$s">%2$s</time>।',
		'last-error-date' => 'आखिरी विफल अपडेट <time datetime="%1$s" title="%1$s">%2$s</time>।',
		'last-update' => 'आखिरी सफल अपडेट <time datetime="%1$s" title="%1$s">%2$s</time>।',
		'maintenance' => array(
			'clear_cache' => 'कैश साफ़ करें',
			'clear_cache_help' => 'इस फ़ीड का कैश साफ़ करें।',
			'reload_articles' => 'लेख दोबारा लोड करें',
			'reload_articles_help' => 'इतने लेख दोबारा लोड करें, और अगर सिलेक्टर तय है तो पूरा कंटेंट लाएं।',
			'title' => 'रखरखाव',
		),
		'max_http_redir' => 'अधिकतम HTTP रीडायरेक्ट',
		'max_http_redir_help' => 'बंद करने के लिए 0 रखें या खाली छोड़ें, असीमित रीडायरेक्ट के लिए -1',
		'method' => array(
			'_' => 'HTTP मेथड',
		),
		'method_help' => 'POST पेलोड में <code>application/x-www-form-urlencoded</code> और <code>application/json</code> अपने-आप समर्थित हैं',
		'method_postparams' => 'POST के लिए पेलोड',
		'moved_category_deleted' => 'जब आप कोई श्रेणी हटाते हैं, तो उसकी फ़ीड अपने-आप <em>%s</em> में चली जाती हैं।',
		'mute' => array(
			'_' => 'म्यूट करें',
			'state_is_muted' => 'यह फ़ीड म्यूट है',
		),
		'no_selected' => 'कोई फ़ीड नहीं चुनी गई।',
		'number_entries' => '%d लेख',
		'open_feed' => 'फ़ीड %s खोलें',
		'path_entries_conditions' => 'कंटेंट लाने की शर्तें',
		'priority' => array(
			'_' => 'दिखना',
			'category' => 'अपनी श्रेणी में दिखाएं',
			'feed' => 'अपनी फ़ीड में दिखाएं',
			'hidden' => 'न दिखाएं',
			'important' => 'महत्वपूर्ण फ़ीड में दिखाएं',
			'main_stream' => 'मुख्य स्ट्रीम में दिखाएं',
		),
		'proxy' => 'इस फ़ीड को लाने के लिए प्रॉक्सी सेट करें',
		'proxy_help' => 'एक प्रोटोकॉल चुनें (जैसे: SOCKS5) और प्रॉक्सी का पता डालें (जैसे: <kbd>127.0.0.1:1080</kbd> या <kbd>username:password@127.0.0.1:1080</kbd>)',
		'reset_favicon' => 'डिफ़ॉल्ट पर रीसेट करें',
		'selector_preview' => array(
			'show_raw' => 'सोर्स कोड दिखाएं',
			'show_rendered' => 'कंटेंट दिखाएं',
		),
		'show' => array(
			'all' => 'सभी फ़ीड',
			'error' => 'सिर्फ़ त्रुटि वाली फ़ीड दिखाएं',
		),
		'showing' => array(
			'error' => 'सिर्फ़ त्रुटि वाली फ़ीड दिखाई जा रही हैं',
		),
		'ssl_verify' => 'SSL सुरक्षा की जांच करें',
		'stats' => 'आंकड़े',
		'think_to_add' => 'आप कुछ फ़ीड जोड़ सकते हैं।',
		'timeout' => 'टाइमआउट (सेकंड में)',
		'title' => 'शीर्षक',
		'title_add' => 'RSS फ़ीड जोड़ें',
		'ttl' => 'इससे ज़्यादा बार अपने-आप रीफ़्रेश न करें',
		'unicityCriteria' => array(
			'_' => 'लेख की अलग पहचान का आधार',
			'forced' => '<span title="फ़ीड में डुप्लिकेट लेख होने पर भी पहचान का आधार न बदलें">ज़बरदस्ती लागू</span>',
			'help' => 'अमान्य फ़ीड के लिए काम का।<br />⚠️ नीति बदलने पर डुप्लिकेट लेख बनेंगे।',
			'id' => 'मानक ID (डिफ़ॉल्ट)',
			'link' => 'लिंक',
			'sha1:content' => 'कंटेंट',
			'sha1:content_published' => 'कंटेंट + तारीख',
			'sha1:link_published' => 'लिंक + तारीख',
			'sha1:link_published_title' => 'लिंक + तारीख + शीर्षक',
			'sha1:link_published_title_content' => 'लिंक + तारीख + शीर्षक + कंटेंट',
			'sha1:published' => 'तारीख',
			'sha1:title' => 'शीर्षक',
			'sha1:title_published' => 'शीर्षक + तारीख',
			'sha1:title_published_content' => 'शीर्षक + तारीख + कंटेंट',
		),
		'url' => 'फ़ीड URL',
		'useragent' => 'इस फ़ीड को लाने के लिए यूज़र एजेंट सेट करें',
		'useragent_help' => 'उदाहरण: <kbd>Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:86.0)</kbd>',
		'validator' => 'फ़ीड की वैधता जांचें',
		'website' => 'वेबसाइट URL',
		'websub' => 'WebSub से तुरंत सूचनाएं',
		'websub_pending' => 'WebSub पर सब्सक्राइब हो गया। पहली सूचना का इंतज़ार है।',
	),
	'import_export' => array(
		'export' => array(
			'_' => 'एक्सपोर्ट',
			'sqlite' => 'यूज़र डेटाबेस SQLite के रूप में डाउनलोड करें',
		),
		'export_labelled' => 'लेबल वाले अपने लेख एक्सपोर्ट करें',
		'export_opml' => 'फ़ीड की सूची एक्सपोर्ट करें (OPML)',
		'export_starred' => 'अपने पसंदीदा लेख एक्सपोर्ट करें',
		'feed_list' => '%s के लेखों की सूची',
		'file_to_import' => 'इम्पोर्ट करने के लिए फ़ाइल<br />(OPML, JSON या ZIP)',
		'file_to_import_no_zip' => 'इम्पोर्ट करने के लिए फ़ाइल<br />(OPML या JSON)',
		'import' => 'इम्पोर्ट',
		'starred_list' => 'पसंदीदा लेखों की सूची',
		'title' => 'इम्पोर्ट / एक्सपोर्ट',
	),
	'menu' => array(
		'add' => 'फ़ीड या श्रेणी जोड़ें',
		'import_export' => 'इम्पोर्ट / एक्सपोर्ट',
		'label_management' => 'लेबल मैनेजमेंट',
		'stats' => array(
			'idle' => 'निष्क्रिय फ़ीड',
			'main' => 'मुख्य आंकड़े',
			'repartition' => 'लेखों का बंटवारा',
			'unread_dates' => 'अपठित तारीखें',
		),
		'subscription_management' => 'सब्सक्रिप्शन मैनेजमेंट',
		'subscription_tools' => 'सब्सक्रिप्शन टूल',
	),
	'tag' => array(
		'auto_label' => 'नए लेखों में यह लेबल जोड़ें',
		'name' => 'नाम',
		'new_name' => 'नया नाम',
		'old_name' => 'पुराना नाम',
	),
	'title' => array(
		'_' => 'सब्सक्रिप्शन मैनेजमेंट',
		'add' => 'फ़ीड या श्रेणी जोड़ें',
		'add_category' => 'श्रेणी जोड़ें',
		'add_dynamic_opml' => 'डायनेमिक OPML जोड़ें',
		'add_feed' => 'फ़ीड जोड़ें',
		'add_label' => 'लेबल जोड़ें',
		'add_opml_category' => 'OPML श्रेणी का नाम',
		'delete_label' => 'यह लेबल हटाएं',
		'feed_management' => 'RSS फ़ीड मैनेजमेंट',
		'subscription_tools' => 'सब्सक्रिप्शन टूल',
	),
);
