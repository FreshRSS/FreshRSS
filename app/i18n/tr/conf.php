<?php

return array(
	'archiving' => array(
		'_' => 'Arşiv',
		'delete_after' => 'Makelelerin tutulacağı süre',
		'exception' => 'Purge exception',	// TODO - Translation
		'help' => 'Akış ayarlarında daha çok ayar bulabilirsiniz',
		'keep_favourites' => 'Never delete favourites',	// TODO - Translation
		'keep_labels' => 'Never delete labels',	// TODO - Translation
		'keep_max' => 'Maximum number of articles to keep',	// TODO - Translation
		'keep_min_by_feed' => 'Akışta en az tutulacak makale sayısı',
		'keep_period' => 'Maximum age of articles to keep',	// TODO - Translation
		'keep_unreads' => 'Never delete unread articles',	// TODO - Translation
		'maintenance' => 'Maintenance',	// TODO - Translation
		'optimize' => 'Veritabanı optimize et',
		'optimize_help' => 'Bu işlem bazen veritabanı boyutunu düşürmeye yardımcı olur',
		'policy' => 'Purge policy',	// TODO - Translation
		'policy_warning' => 'If no purge policy is selected, every article will be kept.',	// TODO - Translation
		'purge_now' => 'Şimdi temizle',
		'title' => 'Arşiv',
		'ttl' => 'Şu süreden sık otomatik yenileme yapma',
	),
	'display' => array(
		'_' => 'Görünüm',
		'icon' => array(
			'bottom_line' => 'Alt çizgi',
			'display_authors' => 'Authors',	// TODO - Translation
			'entry' => 'Makale ikonları',
			'publication_date' => 'Yayınlama Tarihi',
			'related_tags' => 'İlgili etiketler',
			'sharing' => 'Paylaşım',
			'top_line' => 'Üst çizgi',
		),
		'language' => 'Dil',
		'notif_html5' => array(
			'seconds' => 'saniye (0 zaman aşımı yok demektir)',
			'timeout' => 'HTML5 bildirim zaman aşımı',
		),
		'show_nav_buttons' => 'Show the navigation buttons',	// TODO - Translation
		'theme' => 'Tema',
		'themes_are_extensions' => 'Themes are now extensions and need to be enabled. You have selected the <em>%s</em> theme but it is not enabled at the moment. You can enable it <a href="%s">here</a>.',	// TODO - Translation
		'title' => 'Görünüm',
		'width' => array(
			'content' => 'İçerik genişliği',
			'large' => 'Geniş',
			'medium' => 'Orta',
			'no_limit' => 'Sınırsız',
			'thin' => 'Zayıf',
		),
	),
	'profile' => array(
		'_' => 'Profil yönetimi',
		'api' => 'API management',	// TODO - Translation
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
		'display' => 'Display user query results',	// TODO - Translation
		'filter' => array(
			'_' => 'Filtre uygulandı:',
			'categories' => 'Display by category',	// TODO - Translation
			'feeds' => 'Display by feed',	// TODO - Translation
			'order' => 'Sort by date',	// TODO - Translation
			'search' => 'Expression',	// TODO - Translation
			'state' => 'State',	// TODO - Translation
			'tags' => 'Display by tag',	// TODO - Translation
			'type' => 'Type',	// TODO - Translation
		),
		'get_all' => 'Tüm makaleleri göster',
		'get_category' => '"%s" kategorisini göster',
		'get_favorite' => 'Favori makaleleri göster',
		'get_feed' => '"%s" akışını göster',
		'get_tag' => 'Display "%s" label',	// TODO - Translation
		'name' => 'Name',	// TODO - Translation
		'no_filter' => 'Filtre yok',
		'none' => 'Henüz hiç kullanıcı sorgusu oluşturmadınız.',
		'number' => 'Sorgu n°%d',
		'order_asc' => 'Önce eski makaleleri göster',
		'order_desc' => 'Önce yeni makaleleri göster',
		'remove' => 'Remove user query',	// TODO - Translation
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
		'always_show_favorites' => 'Show all articles in favourites by default',	// TODO - Translation
		'articles_per_page' => 'Sayfa başına makale sayısı',
		'auto_load_more' => 'Sayfa sonunda yeni makaleleri yükle',
		'auto_remove_article' => 'Okuduktan sonra makaleleri gizle',
		'confirm_enabled' => '"Hepsini okundu say" eylemi için onay iste',
		'display_articles_unfolded' => 'Show articles unfolded by default',	// TODO - Translation
		'display_categories_unfolded' => 'Categories to unfold',	// TODO - Translation
		'hide_read_feeds' => 'Okunmamış makalesi olmayan kategori veya akışı gizle ("Tüm makaleleri göster" komutunda çalışmaz)',
		'img_with_lazyload' => 'Resimleri yüklemek için "tembel modu" kullan',
		'jump_next' => 'Bir sonraki benzer okunmamışa geç (akış veya kategori)',
		'mark_updated_article_unread' => 'Güncellenen makaleleri okundu olarak işaretle',
		'number_divided_when_reader' => 'Okuma modunda ikiye bölünecek.',
		'read' => array(
			'article_open_on_website' => 'orijinal makale sitesi açıldığında',
			'article_viewed' => 'makale görüntülendiğinde',
			'scroll' => 'kaydırma yapılırken',
			'upon_reception' => 'makale üzerinde gelince',
			'when' => 'Makaleyi okundu olarak işaretle…',
		),
		'show' => array(
			'_' => 'Gösterilecek makaleler',
			'active_category' => 'Active category',	// TODO - Translation
			'adaptive' => 'Ayarlanmış gösterim',
			'all_articles' => 'Tüm makaleleri göster',
			'all_categories' => 'All categories',	// TODO - Translation
			'no_category' => 'No category',	// TODO - Translation
			'remember_categories' => 'Remember open categories',	// TODO - Translation
			'unread' => 'Sadece okunmamış makaleleri göster',
		),
		'sides_close_article' => 'Clicking outside of article text area closes the article',	// TODO - Translation
		'sort' => array(
			'_' => 'Sıralama',
			'newer_first' => 'Önce yeniler',
			'older_first' => 'Önce eskiler',
		),
		'sticky_post' => 'Makale açıldığında yukarı getir',
		'title' => 'Okuma',
		'view' => array(
			'default' => 'Öntanımlı görünüm',
			'global' => 'Global görünüm',
			'normal' => 'Normal görünüm',
			'reader' => 'Okuma görünümü',
		),
	),
	'sharing' => array(
		'_' => 'Paylaşım',
		'add' => 'Add a sharing method',	// TODO - Translation
		'blogotext' => 'Blogotext',	// TODO - Translation
		'diaspora' => 'Diaspora*',	// TODO - Translation
		'email' => 'Email',	// TODO - Translation
		'facebook' => 'Facebook',	// TODO - Translation
		'more_information' => 'Daha fazla bilgi',
		'print' => 'Yazdır',
		'remove' => 'Remove sharing method',	// TODO - Translation
		'shaarli' => 'Shaarli',	// TODO - Translation
		'share_name' => 'Paylaşım ismi',
		'share_url' => 'Paylaşım URL si',
		'title' => 'Paylaşım',
		'twitter' => 'Twitter',	// TODO - Translation
		'wallabag' => 'wallabag',	// TODO - Translation
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
		'global_view' => 'Switch to global view',	// TODO - Translation
		'help' => 'Dokümantasyonu göster',
		'javascript' => 'Kısayolları kullanabilmek için JavaScript aktif olmalıdır',
		'last_article' => 'Son makaleyi atla',
		'load_more' => 'Daha fazla makale yükle',
		'mark_favorite' => 'Favori olarak işaretle',
		'mark_read' => 'Okundu olarak işaretle',
		'navigation' => 'Genel eylemler',
		'navigation_help' => '<kbd>⇧ Shift</kbd> tuşu ile kısayollar akışlar için geçerli olur.<br/><kbd>Alt ⎇</kbd> tuşu ile kısayollar kategoriler için geçerli olur.',
		'navigation_no_mod_help' => 'The following navigation shortcuts do not support modifiers.',	// TODO - Translation
		'next_article' => 'Sonraki makaleye geç',
		'normal_view' => 'Switch to normal view',	// TODO - Translation
		'other_action' => 'Diğer eylemler',
		'previous_article' => 'Önceki makaleye geç',
		'reading_view' => 'Switch to reading view',	// TODO - Translation
		'rss_view' => 'Open RSS view in a new tab',	// TODO - Translation
		'see_on_website' => 'Orijinal sitede göster',
		'shift_for_all_read' => '+ <kbd>Alt ⎇</kbd> to mark previous articles as read<br />+ <kbd>⇧ Shift</kbd> to mark all articles as read',	// TODO - Translation
		'skip_next_article' => 'Focus next without opening',	// TODO - Translation
		'skip_previous_article' => 'Focus previous without opening',	// TODO - Translation
		'title' => 'Kısayollar',
		'toggle_media' => 'Play/pause media',	// TODO - Translation
		'user_filter' => 'Kullanıcı filtrelerine eriş',
		'user_filter_help' => 'Eğer tek filtre varsa o kullanılır. Yoksa filtrelerin kendi numaralarıyla kullanılır.',
		'views' => 'Views',	// TODO - Translation
	),
	'user' => array(
		'articles_and_size' => '%s makale (%s)',
		'current' => 'Mevcut kullanıcı',
		'is_admin' => 'yöneticidir',
		'users' => 'Kullanıcılar',
	),
);
