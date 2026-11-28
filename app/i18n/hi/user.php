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
	'email' => array(
		'feedback' => array(
			'invalid' => 'यह ईमेल पता अमान्य है।',
			'required' => 'ईमेल पता ज़रूरी है।',
		),
		'validation' => array(
			'change_email' => 'आप अपना ईमेल पता <a href="%s">प्रोफ़ाइल पेज पर</a> बदल सकते हैं।',
			'email_sent_to' => 'हमने आपको <strong>%s</strong> पर एक ईमेल भेजा है। अपना पता सत्यापित करने के लिए कृपया उसमें दिए निर्देशों का पालन करें।',
			'feedback' => array(
				'email_failed' => 'सर्वर कॉन्फ़िगरेशन में त्रुटि के कारण हम आपको ईमेल नहीं भेज सके।',
				'email_sent' => 'आपके पते पर एक ईमेल भेज दिया गया है।',
				'error' => 'ईमेल पते का सत्यापन विफल रहा।',
				'ok' => 'यह ईमेल पता सत्यापित हो गया है।',
				'unnecessary' => 'यह ईमेल पता पहले ही सत्यापित हो चुका था।',
				'wrong_token' => 'गलत टोकन के कारण इस ईमेल पते का सत्यापन नहीं हो सका।',
			),
			'need_to' => '%s इस्तेमाल करने से पहले आपको अपना ईमेल पता सत्यापित करना होगा।',
			'resend_email' => 'ईमेल फिर से भेजें',
			'title' => 'ईमेल पते का सत्यापन',
		),
	),
	'mailer' => array(
		'email_need_validation' => array(
			'body' => 'आपने अभी %s पर रजिस्टर किया है, लेकिन आपको अपना ईमेल पता अभी सत्यापित करना है। इसके लिए, बस इस लिंक पर जाएं:',
			'title' => 'आपको अपना खाता सत्यापित करना होगा',
			'welcome' => 'स्वागत है %s,',
		),
	),
	'password' => array(
		'invalid' => 'पासवर्ड अमान्य है।',
		'provided_password_too_long' => 'दिया गया पासवर्ड बहुत लंबा है।',
	),
	'tos' => array(
		'feedback' => array(
			'invalid' => 'रजिस्टर करने के लिए आपको सेवा की शर्तें स्वीकार करनी होंगी।',
		),
	),
	'username' => array(
		'invalid' => 'यह यूज़रनेम अमान्य है।',
		'taken' => 'यह यूज़रनेम, %s, पहले से लिया जा चुका है।',
	),
);
