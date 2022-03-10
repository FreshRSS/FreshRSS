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
	'archiving' => array(
		'_' => 'Arşiv',
		'exception' => 'Temizlik ifadeleri',
		'help' => 'Akış ayarlarında daha çok ayar bulabilirsiniz',
		'keep_favourites' => 'Favorileri asla silme',
		'keep_labels' => 'Etiketleri asla silme',
		'keep_max' => 'Bellekte tutulacak en fazla makale sayısı',
		'keep_min_by_feed' => 'Akışta en az tutulacak makale sayısı',
		'keep_period' => 'Bellekte tutulacak en eski makale tarihi',
		'keep_unreads' => 'Okunmamaış makaleleri asla silme',
		'maintenance' => 'Bakım',
		'optimize' => 'Veritabanı optimize et',
		'optimize_help' => 'Bu işlem bazen veritabanı boyutunu düşürmeye yardımcı olur',
		'policy' => 'Teimzleme politikası',
		'policy_warning' => 'Eğer temizleme politikası seçilmezse her makale bellekte tutulacaktır.',
		'purge_now' => 'Şimdi temizle',
		'title' => 'Arşiv',
		'ttl' => 'Şu süreden sık otomatik yenileme yapma',
	),
	'display' => array(
		'_' => 'Görünüm',
		'icon' => array(
			'bottom_line' => 'Alt çizgi',
			'display_authors' => 'Yazarlar',
			'entry' => 'Makale ikonları',
			'publication_date' => 'Yayınlama Tarihi',
			'related_tags' => 'İlgili etiketler',
			'sharing' => 'Paylaşım',
			'summary' => 'Summary',	// TODO
			'top_line' => 'Üst çizgi',
		),
		'language' => 'Dil',
		'notif_html5' => array(
			'seconds' => 'saniye (0 zaman aşımı yok demektir)',
			'timeout' => 'HTML5 bildirim zaman aşımı',
		),
		'show_nav_buttons' => 'Gezinti düğmelerini göster',
		'theme' => 'Tema',
		'theme_not_available' => 'The “%s” theme is not available anymore. Please choose another theme.',	// TODO
		'thumbnail' => array(
			'label' => 'Thumbnail',	// TODO
			'landscape' => 'Landscape',	// TODO
			'none' => 'None',	// TODO
			'portrait' => 'Portrait',	// TODO
			'square' => 'Square',	// TODO
		),
		'title' => 'Görünüm',
		'width' => array(
			'content' => 'İçerik genişliği',
			'large' => 'Geniş',
			'medium' => 'Orta',
			'no_limit' => 'Sınırsız',
			'thin' => 'Zayıf',
		),
	),
	'logs' => array(
		'loglist' => array(
			'level' => 'Log Level',	// TODO
			'message' => 'Log Message',	// TODO
			'timestamp' => 'Timestamp',	// TODO
		),
		'pagination' => array(
			'first' => 'İlk',
			'last' => 'Son',
			'next' => 'Sonraki',
			'previous' => 'Önceki',
	),
	),
	'profile' => array(
		'_' => 'Profil yönetimi',
		'api' => 'API yönetimi',
		'delete' => array(
			'_' => 'Hesap silme',
			'warn' => 'Hesabınız ve tüm verileriniz silinecek.',
		),
		'email' => 'Email adresleri',
		'password_api' => 'API Şifresi<br /><small>(ör. mobil uygulamalar için)</small>',
		'password_form' => 'Şifre<br /><small>(Tarayıcı girişi için)</small>',
		'password_format' => 'En az 7 karakter',
		'title' => 'Profil',
	),
	'query' => array(
		'_' => 'Kullanıcı sorguları',
		'deprecated' => 'Bu sorgu artık geçerli değil. İlgili akış veya kategori silinmiş.',
		'filter' => array(
			'_' => 'Filtre uygulandı:',
			'categories' => 'Kategoriye göre göster',
			'feeds' => 'Akışa göre göster',
			'order' => 'Tarihe göre göster',
			'search' => 'İfade',
			'state' => 'Durum',
			'tags' => 'Etikete göre göster',
			'type' => 'Tür',
		),
		'get_all' => 'Tüm makaleleri göster',
		'get_category' => '"%s" kategorisini göster',
		'get_favorite' => 'Favori makaleleri göster',
		'get_feed' => '"%s" akışını göster',
		'name' => 'İsim',
		'no_filter' => 'Filtre yok',
		'number' => 'Sorgu n°%d',
		'order_asc' => 'Önce eski makaleleri göster',
		'order_desc' => 'Önce yeni makaleleri göster',
		'search' => '"%s" için arama',
		'state_0' => 'Tüm makaleleri göster',
		'state_1' => 'Okunmuş makaleleri göster',
		'state_2' => 'Okunmamış makaleleri göster',
		'state_3' => 'Tüm makaleleri göster',
		'state_4' => 'Favori makaleleri göster',
		'state_5' => 'Okunmuş favori makaleleri göster',
		'state_6' => 'Okunmamış favori makaleleri göster',
		'state_7' => 'Favori makaleleri göster',
		'state_8' => 'Favori olmayan makaleleri göster',
		'state_9' => 'Favori olmayan okunmuş makaleleri göster',
		'state_10' => 'Favori olmayan okunmamış makaleleri göster',
		'state_11' => 'Favori olmayan makaleleri göster',
		'state_12' => 'Tüm makaleleri göster',
		'state_13' => 'Okunmuş makaleleri göster',
		'state_14' => 'Okunmamış makaleleri göster',
		'state_15' => 'Tüm makaleleri göster',
		'title' => 'Kullanıcı sorguları',
	),
	'reading' => array(
		'_' => 'Okuma',
		'after_onread' => '"Hepsini okundu say" dedinten sonra,',
		'always_show_favorites' => 'Öntanımlı olarak favori tüm makaleleri göster',
		'articles_per_page' => 'Sayfa başına makale sayısı',
		'auto_load_more' => 'Sayfa sonunda yeni makaleleri yükle',
		'auto_remove_article' => 'Okuduktan sonra makaleleri gizle',
		'confirm_enabled' => '"Hepsini okundu say" eylemi için onay iste',
		'display_articles_unfolded' => 'Katlaması açılmış makaleleri öntanımlı olarak göster',
		'display_categories_unfolded' => 'Katlaması açılacak kategoriler',
		'headline' => array(
			'articles' => 'Articles: Open/Close',	// TODO
			'categories' => 'Left navigation: Categories',	// TODO
			'mark_as_read' => 'Mark article as read',	// TODO
			'misc' => 'Miscellaneous',	// TODO
			'view' => 'View',	// TODO
		),
		'hide_read_feeds' => 'Okunmamış makalesi olmayan kategori veya akışı gizle ("Tüm makaleleri göster" komutunda çalışmaz)',
		'img_with_lazyload' => 'Resimleri yüklemek için "tembel modu" kullan',
		'jump_next' => 'Bir sonraki benzer okunmamışa geç (akış veya kategori)',
		'mark_updated_article_unread' => 'Güncellenen makaleleri okundu olarak işaretle',
		'number_divided_when_reader' => 'Okuma modunda ikiye bölünecek.',
		'read' => array(
			'article_open_on_website' => 'orijinal makale sitesi açıldığında',
			'article_viewed' => 'makale görüntülendiğinde',
			'keep_max_n_unread' => 'Max number of articles to keep unread',	// TODO
			'scroll' => 'kaydırma yapılırken',
			'upon_reception' => 'makale üzerinde gelince',
			'when' => 'Makaleyi okundu olarak işaretle…',
			'when_same_title' => 'if an identical title already exists in the top <i>n</i> newest articles',	// TODO
		),
		'show' => array(
			'_' => 'Gösterilecek makaleler',
			'active_category' => 'Mevcut kategori',
			'adaptive' => 'Ayarlanmış gösterim',
			'all_articles' => 'Tüm makaleleri göster',
			'all_categories' => 'Tüm kategoriler',
			'no_category' => 'Hiçbir kategori',
			'remember_categories' => 'Açık kategorileri hatırla',
			'unread' => 'Sadece okunmamış makaleleri göster',
		),
		'show_fav_unread_help' => 'Etiketlerde de uygula',
		'sides_close_article' => 'Makale dışında bir alana tıklamak makaleyi kapatır',
		'sort' => array(
			'_' => 'Sıralama',
			'newer_first' => 'Önce yeniler',
			'older_first' => 'Önce eskiler',
		),
		'sticky_post' => 'Makale açıldığında yukarı getir',
		'title' => 'Okuma',
		'view' => array(
			'default' => 'Öntanımlı görünüm',
			'global' => 'Evrensel görünüm',
			'normal' => 'Normal görünüm',
			'reader' => 'Okuma görünümü',
		),
	),
	'sharing' => array(
		'_' => 'Paylaşım',
		'add' => 'Bir paylaşım türü ekle',
		'blogotext' => 'Blogotext',	// IGNORE
		'diaspora' => 'Diaspora*',	// IGNORE
		'email' => 'Email',	// IGNORE
		'facebook' => 'Facebook',	// IGNORE
		'more_information' => 'Daha fazla bilgi',
		'print' => 'Yazdır',
		'raindrop' => 'Raindrop.io',	// IGNORE
		'remove' => 'Paylaşım türünü sil',
		'shaarli' => 'Shaarli',	// IGNORE
		'share_name' => 'Paylaşım ismi',
		'share_url' => 'Paylaşım URL si',
		'title' => 'Paylaşım',
		'twitter' => 'Twitter',	// IGNORE
		'wallabag' => 'wallabag',	// IGNORE
	),
	'shortcut' => array(
		'_' => 'Kısayollar',
		'article_action' => 'Makale eylemleri',
		'auto_share' => 'Paylaş',
		'auto_share_help' => 'Sadece 1 paylaşım modu varsa bu kullanılır. Yoksa kendi paylaşım numaraları ile kullanılır.',
		'close_dropdown' => 'Menüleri kapat',
		'collapse_article' => 'Kapat',
		'first_article' => 'İlk makaleyi atla',
		'focus_search' => 'Arama kutusuna eriş',
		'global_view' => 'Evrensel görünüme geç',
		'help' => 'Dokümantasyonu göster',
		'javascript' => 'Kısayolları kullanabilmek için JavaScript aktif olmalıdır',
		'last_article' => 'Son makaleyi atla',
		'load_more' => 'Daha fazla makale yükle',
		'mark_favorite' => 'Favori olarak işaretle',
		'mark_read' => 'Okundu olarak işaretle',
		'navigation' => 'Genel eylemler',
		'navigation_help' => '<kbd>⇧ Shift</kbd> tuşu ile kısayollar akışlar için geçerli olur.<br/><kbd>Alt ⎇</kbd> tuşu ile kısayollar kategoriler için geçerli olur.',
		'navigation_no_mod_help' => 'Aşağıdaki kısayollar değiştiricileri desteklenmemektedir.',
		'next_article' => 'Sonraki makaleye geç',
		'next_unread_article' => 'Open the next unread article',	// TODO
		'non_standard' => 'Bazı tuşlar (<kbd>%s</kbd>) kullanılamayabilir.',
		'normal_view' => 'Normal görünüme geç',
		'other_action' => 'Diğer eylemler',
		'previous_article' => 'Önceki makaleye geç',
		'reading_view' => 'Okuma görünümüne geç',
		'rss_view' => 'RSS beslemesi olarak aç',
		'see_on_website' => 'Orijinal sitede göster',
		'shift_for_all_read' => 'Önceki makaleyi okundu olarak işaretlemek için + <kbd>Alt ⎇</kbd> kısayolu<br />Tüm makaleleri okundu işaretlemek için + <kbd>⇧ Shift</kbd>kısayolu',
		'skip_next_article' => 'Açmadan bir sonraki makaleye geç',
		'skip_previous_article' => 'açmadan bir önceki makaleye geç',
		'title' => 'Kısayollar',
		'toggle_media' => 'Ortamı oynat/duraklat',
		'user_filter' => 'Kullanıcı filtrelerine eriş',
		'user_filter_help' => 'Eğer tek filtre varsa o kullanılır. Yoksa filtrelerin kendi numaralarıyla kullanılır.',
		'views' => 'Görüntülenme',
	),
	'user' => array(
		'articles_and_size' => '%s makale (%s)',
		'current' => 'Mevcut kullanıcı',
		'is_admin' => 'yöneticidir',
		'users' => 'Kullanıcılar',
	),
);
