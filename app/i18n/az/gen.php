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
	'action' => array(
		'actualize' => 'Lentləri yenilə',
		'add' => 'Əlavə et',
		'back_to_rss_feeds' => '← RSS lentlərinizə qayıdın',
		'cancel' => 'Ləğv et',
		'close' => 'Bağla',
		'create' => 'Yarat',
		'delete_all_feeds' => 'Bütün lentləri sil',
		'delete_errored_feeds' => 'Xətalı lentləri sil',
		'delete_muted_feeds' => 'Səssiz lentləri sil',
		'demote' => 'Aşağı sal',
		'disable' => 'Deaktiv et',
		'download' => 'Endir',
		'empty' => 'Boşalt',
		'enable' => 'Aktivləşdir',
		'export' => 'İxrac et',
		'filter' => 'Süzgəc',
		'import' => 'İdxal et',
		'load_default_shortcuts' => 'Standart qısayolları yüklə',
		'manage' => 'İdarə et',
		'mark_read' => 'Oxunmuş kimi işarələ',
		'menu' => array(
			'open' => 'Menyunu aç',
		),
		'nav_buttons' => array(
			'next' => 'Növbəti məqalə',
			'prev' => 'Əvvəlki məqalə',
			'up' => 'Yuxarı get',
		),
		'open_url' => 'URL-i aç',
		'promote' => 'Yüksəlt',
		'purge' => 'Təmizlə',
		'refresh_opml' => 'OPML-i yenilə',
		'remove' => 'Çıxar',
		'rename' => 'Adını dəyiş',
		'see_website' => 'Veb sayta bax',
		'submit' => 'Göndər',
		'truncate' => 'Bütün məqalələri sil',
		'update' => 'Yenilə',
	),
	'auth' => array(
		'accept_tos' => '<a href="%s">Xidmət şərtlərini</a> qəbul edirəm.',
		'email' => 'E-poçt ünvanı',
		'keep_logged_in' => 'Məni sistemdə saxla <small>(%s gün)</small>',
		'login' => 'Giriş',
		'logout' => 'Çıxış',
		'password' => array(
			'_' => 'Parol',
			'format' => '<small>Ən azı 7 simvol</small>',
		),
		'reauth' => array(
			'header' => 'Yenidən kimlik doğrulama tələb olunur',
			'tip' => 'Növbəti <u>%d dəqiqə</u> ərzində sizdən yenidən daxil olmaq istənilməyəcək',
			'title' => 'Yenidən kimlik doğrulama',
		),
		'registration' => array(
			'_' => 'Yeni hesab',
			'ask' => 'Hesab yaradılsın?',
			'title' => 'Hesabın yaradılması',
		),
		'username' => array(
			'_' => 'İstifadəçi adı',
			'format' => '<small>1-39 simvol: hərflər, rəqəmlər və <code>. _ @ -</code></small>',
		),
	),
	'date' => array(
		'Apr' => '\\A\\p\\r\\e\\l',
		'Aug' => '\\A\\v\\q\\u\\s\\t',
		'Dec' => '\\D\\e\\k\\a\\b\\r',
		'Feb' => '\\F\\e\\v\\r\\a\\l',
		'Jan' => '\\Y\\a\\n\\v\\a\\r',
		'Jul' => '\\İ\\y\\u\\l',
		'Jun' => '\\İ\\y\\u\\n',
		'Mar' => '\\M\\a\\r\\t',
		'May' => '\\M\\a\\y',	// IGNORE
		'Nov' => '\\N\\o\\y\\a\\b\\r',
		'Oct' => '\\O\\k\\t\\y\\a\\b\\r',
		'Sep' => '\\S\\e\\n\\t\\y\\a\\b\\r',
		'apr' => 'Apr.',	// IGNORE
		'april' => 'Aprel',
		'aug' => 'Avq.',
		'august' => 'Avqust',
		'before_yesterday' => 'Srağagün',
		'dec' => 'Dek.',
		'december' => 'Dekabr',
		'feb' => 'Fev.',
		'february' => 'Fevral',
		'format_date' => 'j %s Y',	// IGNORE
		'format_date_hour' => 'j %s Y \\s\\a\\a\\t H\\:i',
		'fri' => 'C',
		'jan' => 'Yan.',
		'january' => 'Yanvar',
		'jul' => 'İyul',
		'july' => 'İyul',
		'jun' => 'İyun',
		'june' => 'İyun',
		'last_2_year' => 'Son iki il',
		'last_3_month' => 'Son üç ay',
		'last_3_year' => 'Son üç il',
		'last_5_year' => 'Son beş il',
		'last_6_month' => 'Son altı ay',
		'last_month' => 'Son ay',
		'last_week' => 'Son həftə',
		'last_year' => 'Son il',
		'mar' => 'Mar.',	// IGNORE
		'march' => 'Mart',
		'may' => 'May',	// IGNORE
		'may_' => 'May',	// IGNORE
		'mon' => 'B.e',
		'month' => 'aylar',
		'nov' => 'Noy.',
		'november' => 'Noyabr',
		'oct' => 'Okt.',
		'october' => 'Oktyabr',
		'sat' => 'Ş',
		'sep' => 'Sen.',
		'september' => 'Sentyabr',
		'sun' => 'B',
		'thu' => 'C.a',
		'today' => 'Bu gün',
		'tue' => 'Ç.a',
		'wed' => 'Ç',
		'yesterday' => 'Dünən',
	),
	'dir' => 'ltr',	// IGNORE
	'freshrss' => array(
		'_' => 'FreshRSS',	// IGNORE
		'about' => 'FreshRSS haqqında',
	),
	'interval' => array(
		'day' => array(
			0 => '%d gün əvvəl',
			1 => '%d gün əvvəl',
		),
		'hour' => array(
			0 => '%d saat əvvəl',
			1 => '%d saat əvvəl',
		),
		'justnow' => 'indicə',
		'minute' => array(
			0 => '%d dəqiqə əvvəl',
			1 => '%d dəqiqə əvvəl',
		),
		'month' => array(
			0 => '%d ay əvvəl',
			1 => '%d ay əvvəl',
		),
		'second' => array(
			0 => '%d saniyə əvvəl',
			1 => '%d saniyə əvvəl',
		),
		'year' => array(
			0 => '%d il əvvəl',
			1 => '%d il əvvəl',
		),
	),
	'js' => array(
		'category_empty' => 'Boş kateqoriya',
		'confirm_action' => 'Bu əməliyyatı yerinə yetirmək istədiyinizə əminsiniz? Onu ləğv etmək mümkün deyil!',
		'confirm_action_feed_cat' => 'Bu əməliyyatı yerinə yetirmək istədiyinizə əminsiniz? Əlaqəli seçilmişləri və istifadəçi sorğularını itirəcəksiniz. Onu ləğv etmək mümkün deyil!',
		'confirm_exit_slider' => 'Yadda saxlanmamış parametrlərdən imtina etmək istədiyinizə əminsiniz?',
		'feedback' => array(
			'body_new_articles' => array(
				0 => 'FreshRSS-də oxumaq üçün %d yeni məqalə var.',
				1 => 'FreshRSS-də oxumaq üçün %d yeni məqalə var.',
			),
			'body_unread_articles' => array(
				0 => '(oxunmamış: %d)',
				1 => '(oxunmamış: %d)',
			),
			'request_failed' => 'Sorğu alınmadı, səbəbi internet əlaqəsi problemləri ola bilər.',
			'title_new_articles' => 'FreshRSS: yeni məqalələr!',
		),
		'labels_empty' => 'Etiket yoxdur',
		'new_article' => 'Yeni məqalələr mövcuddur, səhifəni yeniləmək üçün klikləyin.',
		'should_be_activated' => 'JavaScript aktiv olmalıdır',
		'unsafe_csp_header' => 'İstifadə olunan CSP başlığı təhlükəsiz deyil və FreshRSS XSS hücumlarına qarşı həssas ola bilər. <a target="_blank" href="https://freshrss.github.io/FreshRSS/en/admins/10_ServerConfig.html#security">Sənədləşməyə baxın</a>',
	),
	'lang' => array(
		'az' => 'Azərbaycanca',	// IGNORE
		'cs' => 'Čeština',	// IGNORE
		'de' => 'Deutsch',	// IGNORE
		'el' => 'Ελληνικά',	// IGNORE
		'en' => 'English',	// IGNORE
		'en-US' => 'English (United States)',	// IGNORE
		'es' => 'Español',	// IGNORE
		'fa' => 'فارسی',	// IGNORE
		'fi' => 'Suomi',	// IGNORE
		'fr' => 'Français',	// IGNORE
		'he' => 'עברית',	// IGNORE
		'hu' => 'Magyar',	// IGNORE
		'id' => 'Bahasa Indonesia',	// IGNORE
		'it' => 'Italiano',	// IGNORE
		'ja' => '日本語',	// IGNORE
		'ko' => '한국어',	// IGNORE
		'lt' => 'Lietuvių',	// IGNORE
		'lv' => 'Latviešu',	// IGNORE
		'nl' => 'Nederlands',	// IGNORE
		'oc' => 'Occitan',	// IGNORE
		'pl' => 'Polski',	// IGNORE
		'pt-BR' => 'Português (Brasil)',	// IGNORE
		'pt-PT' => 'Português (Portugal)',	// IGNORE
		'ru' => 'Русский',	// IGNORE
		'sk' => 'Slovenčina',	// IGNORE
		'tr' => 'Türkçe',	// IGNORE
		'uk' => 'Українська',	// IGNORE
		'zh-CN' => '简体中文',	// IGNORE
		'zh-TW' => '正體中文',	// IGNORE
	),
	'menu' => array(
		'about' => 'Haqqında',
		'account' => 'Hesab',
		'admin' => 'İdarəetmə',
		'advanced_search' => 'Ətraflı axtarış',
		'archiving' => 'Arxivləmə',
		'authentication' => 'Kimlik doğrulama',
		'check_install' => 'Quraşdırma yoxlaması',
		'configuration' => 'Parametrlər',
		'display' => 'Görünüş',
		'extensions' => 'Genişlənmələr',
		'logs' => 'Jurnallar',
		'privacy' => 'Məxfilik',
		'queries' => 'İstifadəçi sorğuları',
		'reading' => 'Oxuma',
		'search' => 'Söz və ya #etiket axtarın',
		'search_help' => 'Ətraflı <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">axtarış parametrləri</a> üçün sənədləşməyə baxın',
		'sharing' => 'Paylaşma',
		'shortcuts' => 'Qısayollar',
		'stats' => 'Statistika',
		'system' => 'Sistem parametrləri',
		'update' => 'Yeniləmə',
		'user_management' => 'İstifadəçiləri idarə et',
		'user_profile' => 'Profil',
	),
	'period' => array(
		'days' => 'gün',
		'hours' => 'saat',
		'months' => 'ay',
		'weeks' => 'həftə',
		'years' => 'il',
	),
	'readme' => array(
		'contribute' => 'töhfə ver',
		'language' => 'Dil',
		'translated' => 'İrəliləyiş',
	),
	'search' => array(
		'advanced_search_help' => 'Bu forma axtarış sorğuları qurmağa kömək edir, lakin əl ilə yazılan sorğular daha da güclüdür.',
		'authors' => 'Müəlliflər',
		'categories' => 'Kateqoriyalar',
		'content' => 'Məzmun',
		'date_from' => 'Başlanğıc',
		'date_modified' => 'Serverdə dəyişdirilmə tarixi',
		'date_past' => 'Keçmişdə',
		'date_published' => 'Dərc tarixi',
		'date_range' => 'Tarix aralığı',
		'date_received' => 'Alınma tarixi',
		'date_to' => 'Son',
		'date_user' => 'İstifadəçi tərəfindən dəyişdirilmə tarixi',
		'feeds' => 'Lentlər',
		'free_text' => 'Sərbəst mətn',
		'free_text_help' => 'Həm başlıqda, həm də məzmunda axtarır',
		'full_documentation' => '<a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">Tam axtarış sənədləşməsinə</a> baxın',
		'labels' => 'Etiketlərim',
		'multiple_help' => 'Bir və ya bir neçəsini seçin (<kbd>Ctrl</kbd> və ya <kbd>Cmd</kbd> saxlayın)',
		'sources' => 'Mənbələr',
		'tags' => 'Məqalə etiketləri',
		'text' => 'Mətn axtarışı',
		'text_help' => 'Bir neçə sətir məntiqi <i>və ya</i> ilə birləşdirilir. Həmçinin <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#regex" target="_blank">müntəzəm ifadələri</a> dəstəkləyir.',
		'text_placeholder' => 'Açar söz',
		'title' => 'Başlıq',
		'url' => 'URL',	// IGNORE
		'user_queries' => 'İstifadəçi sorğuları',
	),
	'share' => array(
		'Known' => 'Known əsaslı saytlar',
		'archiveIS' => 'archive.is',	// IGNORE
		'archiveORG' => 'archive.org',	// IGNORE
		'archivePH' => 'archive.ph',	// IGNORE
		'bluesky' => 'Bluesky',	// IGNORE
		'buffer' => 'Buffer',	// IGNORE
		'clipboard' => 'Mübadilə buferi',
		'diaspora' => 'Diaspora*',	// IGNORE
		'email' => 'E-poçt',
		'email-webmail-firefox-fix' => 'E-poçt (veb poçt, Firefox üçün düzəliş)',
		'facebook' => 'Facebook',	// IGNORE
		'gnusocial' => 'GNU social',	// IGNORE
		'jdh' => 'Journal du hacker',	// IGNORE
		'lemmy' => 'Lemmy',	// IGNORE
		'linkace' => 'LinkAce',	// IGNORE
		'linkding' => 'Linkding',	// IGNORE
		'linkedin' => 'LinkedIn',	// IGNORE
		'mastodon' => 'Mastodon',	// IGNORE
		'movim' => 'Movim',	// IGNORE
		'nextcloud-bookmarks' => 'Nextcloud Bookmarks',	// IGNORE
		'omnivore' => 'Omnivore',	// IGNORE
		'pinboard' => 'Pinboard',	// IGNORE
		'pinterest' => 'Pinterest',	// IGNORE
		'print' => 'Çap et',
		'raindrop' => 'Raindrop.io',	// IGNORE
		'reddit' => 'Reddit',	// IGNORE
		'shaarli' => 'Shaarli',	// IGNORE
		'telegram' => 'Telegram',	// IGNORE
		'twitter' => 'Twitter',	// IGNORE
		'wallabag' => 'wallabag v1',	// IGNORE
		'wallabagv2' => 'wallabag v2',	// IGNORE
		'web-sharing-api' => 'Sistem paylaşması',
		'whatsapp' => 'Whatsapp',	// IGNORE
		'xing' => 'Xing',	// IGNORE
	),
	'short' => array(
		'attention' => 'Xəbərdarlıq!',
		'blank_to_disable' => 'Deaktiv etmək üçün boş buraxın',
		'by_author' => 'Müəllif:',
		'by_default' => 'Standart olaraq',
		'damn' => 'Eyvah!',
		'default_category' => 'Kateqoriyasız',
		'no' => 'Xeyr',
		'not_applicable' => 'Mövcud deyil',
		'ok' => 'Oldu!',
		'or' => 'və ya',
		'yes' => 'Bəli',
	),
	'stream' => array(
		'load_more' => 'Daha çox məqalə yüklə',
		'mark_all_read' => 'Hamısını oxunmuş kimi işarələ',
		'nothing_to_load' => 'Başqa məqalə yoxdur',
	),
);
