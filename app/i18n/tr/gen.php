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
		'actualize' => 'Beslemeleri güncelle',
		'add' => 'Ekle',
		'back_to_rss_feeds' => '← RSS beslemelerinize geri dön',
		'cancel' => 'İptal et',
		'close' => 'Kapat',
		'create' => 'Oluştur',
		'delete_all_feeds' => 'Tüm beslemeleri sil',
		'delete_errored_feeds' => 'Hatalı beslemeleri sil',
		'delete_muted_feeds' => 'Sessize alınmış beslemeleri sil',
		'demote' => 'Düşür',
		'disable' => 'Devre dışı bırak',
		'download' => 'İndir',
		'empty' => 'Boşalt',
		'enable' => 'Etkinleştir',
		'export' => 'Dışa aktar',
		'filter' => 'Filtrele',
		'import' => 'İçe aktar',
		'load_default_shortcuts' => 'Varsayılan kısayolları yükle',
		'manage' => 'Yönet',
		'mark_read' => 'Okundu olarak işaretle',
		'menu' => array(
			'open' => 'Menüyü aç',
		),
		'nav_buttons' => array(
			'next' => 'Sonraki makale',
			'prev' => 'Önceki makale',
			'up' => 'Yukarı çık',
		),
		'open_url' => 'URL’yi aç',
		'promote' => 'Yükselt',
		'purge' => 'Temizle',
		'refresh_opml' => 'OPML’yi yenile',
		'remove' => 'Kaldır',
		'rename' => 'Yeniden adlandır',
		'see_website' => 'Web sitesini gör',
		'submit' => 'Gönder',
		'truncate' => 'Tüm makaleleri sil',
		'update' => 'Güncelle',
	),
	'auth' => array(
		'accept_tos' => '<a href="%s">Hizmet Şartları</a>’nı kabul ediyorum.',
		'email' => 'E-posta adresi',
		'keep_logged_in' => 'Beni oturumda tut <small>(%s gün)</small>',
		'login' => 'Giriş yap',
		'logout' => 'Çıkış yap',
		'password' => array(
			'_' => 'Parola',
			'format' => '<small>En az 7 karakter</small>',
		),
		'reauth' => array(
			'header' => 'Reauthentication is required',	// TODO
			'tip' => 'You won’t be asked to sign in again for <u>%d minutes</u>',	// TODO
			'title' => 'Reauthentication',	// TODO
		),
		'registration' => array(
			'_' => 'Yeni hesap',
			'ask' => 'Hesap oluştur?',
			'title' => 'Hesap oluşturma',
		),
		'username' => array(
			'_' => 'Kullanıcı adı',
			'format' => '<small>En fazla 16 alfanümerik karakter</small>',
		),
	),
	'date' => array(
		'Apr' => '\\N\\i\\s\\a\\n',
		'Aug' => '\\A\\ğ\\u\\s\\t\\o\\s',
		'Dec' => '\\A\\r\\a\\l\\ı\\k',
		'Feb' => '\\Ş\\u\\b\\a\\t',
		'Jan' => '\\O\\c\\a\\k',
		'Jul' => '\\T\\e\\m\\m\\u\\z',
		'Jun' => '\\H\\a\\z\\i\\r\\a\\n',
		'Mar' => '\\M\\a\\r\\t',
		'May' => '\\M\\a\\y\\ı\\s',
		'Nov' => '\\K\\a\\s\\ı\\m',
		'Oct' => '\\E\\k\\i\\m',
		'Sep' => '\\E\\y\\l\\ü\\l',
		'apr' => 'Nis.',
		'april' => 'Nisan',
		'aug' => 'Ağu.',
		'august' => 'Ağustos',
		'before_yesterday' => 'Dünden önceki gün',
		'dec' => 'Ara.',
		'december' => 'Aralık',
		'feb' => 'Şub.',
		'february' => 'Şubat',
		'format_date' => 'j %s Y',	// IGNORE
		'format_date_hour' => 'j %s Y \\s\\a\\a\\t H\\:i',
		'fri' => 'Cum',
		'jan' => 'Oca.',
		'january' => 'Ocak',
		'jul' => 'Tem.',
		'july' => 'Temmuz',
		'jun' => 'Haz.',
		'june' => 'Haziran',
		'last_2_year' => 'Son iki yıl',
		'last_3_month' => 'Son üç ay',
		'last_3_year' => 'Son üç yıl',
		'last_5_year' => 'Son beş yıl',
		'last_6_month' => 'Son altı ay',
		'last_month' => 'Son ay',
		'last_week' => 'Son hafta',
		'last_year' => 'Son yıl',
		'mar' => 'Mar.',	// IGNORE
		'march' => 'Mart',
		'may' => 'May.',
		'may_' => 'Mayıs',
		'mon' => 'Pzt',
		'month' => 'ay',
		'nov' => 'Kas.',
		'november' => 'Kasım',
		'oct' => 'Eki.',
		'october' => 'Ekim',
		'sat' => 'Cmt',
		'sep' => 'Eyl.',
		'september' => 'Eylül',
		'sun' => 'Paz',
		'thu' => 'Per',
		'today' => 'Bugün',
		'tue' => 'Sal',
		'wed' => 'Çar',
		'yesterday' => 'Dün',
	),
	'dir' => 'ltr',	// IGNORE
	'freshrss' => array(
		'_' => 'FreshRSS',	// IGNORE
		'about' => 'FreshRSS Hakkında',
	),
	'js' => array(
		'category_empty' => 'Boş kategori',
		'confirm_action' => 'Bu eylemi gerçekleştirmek istediğinizden emin misiniz? Bu işlem geri alınamaz!',
		'confirm_action_feed_cat' => 'Bu eylemi gerçekleştirmek istediğinizden emin misiniz? İlgili favoriler ve kullanıcı sorguları kaybolacak. Bu işlem geri alınamaz!',
		'confirm_exit_slider' => 'Are you sure you want to discard unsaved settings?',	// TODO
		'feedback' => array(
			'body_new_articles' => 'FreshRSS’de okunacak %%d yeni makale var.',
			'body_unread_articles' => '(okunmamış: %%d)',
			'request_failed' => 'Bir istek başarısız oldu, bu internet bağlantı sorunlarından kaynaklanmış olabilir.',
			'title_new_articles' => 'FreshRSS: yeni makaleler!',
		),
		'labels_empty' => 'Etiket yok',
		'new_article' => 'Yeni makaleler mevcut, sayfayı yenilemek için tıklayın.',
		'should_be_activated' => 'JavaScript etkinleştirilmiş olmalı',
		'unsafe_csp_header' => 'The CSP header in use is unsafe and FreshRSS may be vulnerable to XSS attacks. <a target="_blank" href="https://freshrss.github.io/FreshRSS/en/admins/10_ServerConfig.html#security">See documentation</a>',	// TODO
	),
	'lang' => array(
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
		'about' => 'Hakkında',
		'account' => 'Hesap',
		'admin' => 'Yönetim',
		'archiving' => 'Arşivleme',
		'authentication' => 'Kimlik doğrulama',
		'check_install' => 'Kurulum kontrolü',
		'configuration' => 'Yapılandırma',
		'display' => 'Görüntüleme',
		'extensions' => 'Eklentiler',
		'logs' => 'Günlükler',
		'privacy' => 'Gizlilik',
		'queries' => 'Kullanıcı sorguları',
		'reading' => 'Okuma',
		'search' => 'Kelime veya #etiket ara',
		'search_help' => 'Gelişmiş <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">arama parametreleri</a> için belgelere bakın',
		'sharing' => 'Paylaşım',
		'shortcuts' => 'Kısayollar',
		'stats' => 'İstatistikler',
		'system' => 'Sistem yapılandırması',
		'update' => 'Güncelle',
		'user_management' => 'Kullanıcıları yönet',
		'user_profile' => 'Profil',
	),
	'period' => array(
		'days' => 'gün',
		'hours' => 'saat',
		'months' => 'ay',
		'weeks' => 'hafta',
		'years' => 'yıl',
	),
	'readme' => array(
		'contribute' => 'contribute',	// IGNORE
		'language' => 'Language',	// IGNORE
		'translated' => 'Progress',	// IGNORE
	),
	'share' => array(
		'Known' => 'Bilinen tabanlı siteler',
		'archiveIS' => 'archive.is',	// IGNORE
		'archiveORG' => 'archive.org',	// IGNORE
		'archivePH' => 'archive.ph',	// IGNORE
		'bluesky' => 'Bluesky',	// IGNORE
		'buffer' => 'Buffer',	// IGNORE
		'clipboard' => 'Pano',
		'diaspora' => 'Diaspora*',	// IGNORE
		'email' => 'E-posta',
		'email-webmail-firefox-fix' => 'E-posta (webmail - Firefox için düzeltme)',
		'facebook' => 'Facebook',	// IGNORE
		'gnusocial' => 'GNU social',	// IGNORE
		'jdh' => 'Journal du hacker',	// IGNORE
		'lemmy' => 'Lemmy',	// IGNORE
		'linkding' => 'Linkding',	// IGNORE
		'linkedin' => 'LinkedIn',	// IGNORE
		'mastodon' => 'Mastodon',	// IGNORE
		'movim' => 'Movim',	// IGNORE
		'omnivore' => 'Omnivore',	// IGNORE
		'pinboard' => 'Pinboard',	// IGNORE
		'pinterest' => 'Pinterest',	// IGNORE
		'pocket' => 'Pocket',	// IGNORE
		'print' => 'Yazdır',
		'raindrop' => 'Raindrop.io',	// IGNORE
		'reddit' => 'Reddit',	// IGNORE
		'shaarli' => 'Shaarli',	// IGNORE
		'telegram' => 'Telegram',	// IGNORE
		'twitter' => 'Twitter',	// IGNORE
		'wallabag' => 'wallabag v1',	// IGNORE
		'wallabagv2' => 'wallabag v2',	// IGNORE
		'web-sharing-api' => 'Sistem paylaşımı',
		'whatsapp' => 'Whatsapp',	// IGNORE
		'xing' => 'Xing',	// IGNORE
	),
	'short' => array(
		'attention' => 'Uyarı!',
		'blank_to_disable' => 'Devre dışı bırakmak için boş bırakın',
		'by_author' => 'Yazar:',
		'by_default' => 'Varsayılan olarak',
		'damn' => 'Lanet olsun!',
		'default_category' => 'Kategorisiz',
		'no' => 'Hayır',
		'not_applicable' => 'Uygulanamaz',
		'ok' => 'Tamam!',
		'or' => 'veya',
		'yes' => 'Evet',
	),
	'stream' => array(
		'load_more' => 'Daha fazla makale yükle',
		'mark_all_read' => 'Tümünü okundu olarak işaretle',
		'nothing_to_load' => 'Yüklenecek başka makale yok',
	),
);
