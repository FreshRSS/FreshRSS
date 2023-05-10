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
	'api' => array(
		'documentation' => 'URL’yi harici bir araçla kullanmak için kopyala.',
		'title' => 'API',	// IGNORE
	),
	'bookmarklet' => array(
		'documentation' => 'Bu butonu yer imleri araç çubuğunuza sürükleyerek veya sağ tıklayıp “Bağlantıyı yer imlerine ekle” seçeneğini seçerek yer imlerine ekleyin. Eklemek istediğiniz sitedeyken oluşturulan bu “Abone Ol” butonu ile akış ekleyebilirsiniz.',
		'label' => 'Abone ol',
		'title' => 'Bookmarklet',	// IGNORE
	),
	'category' => array(
		'_' => 'Kategori',
		'add' => 'Kategori ekle',
		'archiving' => 'Arşiv',
		'dynamic_opml' => array(
			'_' => 'Dinamik OPML',
			'help' => 'Dinamik olarak bu kategoriyi akışla doldurmak için bir link <a href="http://opml.org/" target="_blank">OPML file</a> sağla',
		),
		'empty' => 'Boş kategori',
		'information' => 'Bilgi',
		'opml_url' => 'OPML linki',
		'position' => 'Konumu göster',
		'position_help' => 'Kategori sıralama düzenini kontrol etmek için',
		'title' => 'Başlık',
	),
	'feed' => array(
		'accept_cookies' => 'Cookieleri kabul et',
		'accept_cookies_help' => 'Akış sağlayıcısının cookieler oluşturmasına izin ver. (Sadece istek süresince bellekte depolanmak üzere)',
		'add' => 'RSS akışı ekle',
		'advanced' => 'Gelişmiş',
		'archiving' => 'Arşiv',
		'auth' => array(
			'configuration' => 'Giriş',
			'help' => 'HTTP korumalı RSS akışlarına bağlantı izni sağlar',
			'http' => 'HTTP Kimlik Doğrulama',
			'password' => 'HTTP şifre',
			'username' => 'HTTP kullanıcı adı',
		),
		'clear_cache' => 'Önbelleği her zaman temizle',
		'content_action' => array(
			'_' => 'Metin içeriğini getirirken içerik aksiyonu',
			'append' => 'Mevcut içeriğin sonrasına ekle',
			'prepend' => 'Mevcut içeriğin öncesine ekle',
			'replace' => 'Mevcut içerikle değiştir',
		),
		'css_cookie' => 'Makale içeriğini yüklerken çerez kullan',
		'css_cookie_help' => 'Örnek: <kbd>foo=bar; gdpr_consent=true; cookie=value</kbd>',
		'css_help' => 'Dikkat, daha çok zaman gerekir!',
		'css_path' => 'Makaleleri kendi CSS görünümü ile göster',
		'css_path_filter' => array(
			'_' => 'Kaldırılacak elemana ait CSS seçicisi',
			'help' => 'CSS seçicisi şu şekilde olabilir: <kbd>.footer, .aside</kbd>',
		),
		'description' => 'Tanım',
		'empty' => 'Bu akış boş. Lütfen akışın aktif olduğuna emin olun.',
		'error' => 'Bu akışda bir hatayla karşılaşıldı. Lütfen akışın sürekli ulaşılabilir olduğuna emin olun.',
		'filteractions' => array(
			'_' => 'Eylemi filtrele',
			'help' => 'Her satıra tek arama filtresi yaz. Operators <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">see documentation</a>.',	// DIRTY
		),
		'information' => 'Bilgi',
		'keep_min' => 'En az tutulacak makale sayısı',
		'kind' => array(
			'_' => 'Akış kaynağının tipi',
			'html_xpath' => array(
				'_' => 'HTML + XPath (Web scraping)',	// IGNORE
				'feed_title' => array(
					'_' => 'akış başlığı',
					'help' => 'Örnek: <code>//başlık</code> ya da sabit dizgi: <code>"Benim özel akışım"</code>',
				),
				'help' => '<dfn><a href="https://www.w3.org/TR/xpath-10/" target="_blank">XPath 1.0</a></dfn> Gelişmiş kullanıcılar için standart istek dili, FreshRSS web scrapingi aktifleştirmek için kullanıyor.',
				'item' => array(
					'_' => 'yeni nesneler bulunuyor <strong>nesneler</strong><br /><small>(en önemli)</small>',
					'help' => 'Örnek: <code>//div[@class="news-item"]</code>',
				),
				'item_author' => array(
					'_' => 'nesne yazarı author',
					'help' => 'Sabit dizi olabilir. Örnek: <code>"Anonymous"</code>',
				),
				'item_categories' => 'nesne etiketleri',
				'item_content' => array(
					'_' => 'nesne içeriği',
					'help' => 'Tüm nesneyi almak için örnek: <code>.</code>',
				),
				'item_thumbnail' => array(
					'_' => 'nesne önizlemesi',
					'help' => 'Örnek: <code>descendant::img/@src</code>',
				),
				'item_timeFormat' => array(
					'_' => 'Özel tarih/saat formatı',
					'help' => 'Opsiyonel. Desteklenen biçime buradan ulaşabilirsiniz. <a href="https://php.net/datetime.createfromformat" target="_blank"><code>DateTime::createFromFormat()</code></a> ya da <code>d-m-Y H:i:s</code>',
				),
				'item_timestamp' => array(
					'_' => 'nesne tarihi',
					'help' => 'Sonuç <a href="https://php.net/strtotime" target="_blank"><code>strtotime()</code></a> tarafından ayrıştırılacaktır.',
				),
				'item_title' => array(
					'_' => 'nesne başlığı',
					'help' => 'Linkte gösterilen gibi <a href="https://developer.mozilla.org/docs/Web/XPath/Axes" target="_blank">XPath axis</a> <code>descendant::</code> ya da <code>descendant::h2</code> kullanınınız',
				),
				'item_uid' => array(
					'_' => 'nesne spesifik ID',
					'help' => 'Opsiyonel. Örnek: <code>descendant::div/@data-uri</code>',
				),
				'item_uri' => array(
					'_' => 'nesne linki (URL)',
					'help' => 'Örnek: <code>descendant::a/@href</code>',
				),
				'relative' => 'XPath (nesneye ait):',
				'xpath' => 'XPath:',
			),
			'rss' => 'RSS / Atom (varsayılan)',
			'xml_xpath' => 'XML + XPath',	// TODO
		),
		'maintenance' => array(
			'clear_cache' => 'Önbelleği temizle',
			'clear_cache_help' => 'Bu akışın önbelleğini temizler.',
			'reload_articles' => 'Makaleleri yeniden yükle',
			'reload_articles_help' => 'Belirlenen seçiçi için metin yenileme ve tüm akış çekme',
			'title' => 'Bakım',
		),
		'max_http_redir' => 'Maksimum HTTP yönlendirme sayısı',
		'max_http_redir_help' => 'Devre dışı bırakmak için boş bırakın ya da 0 olarak bırakın. Sınırsız yönlendirme için -1 olarak tanımlayın',
		'moved_category_deleted' => 'Bir kategoriyi silerseniz, içerisindeki akışlar <em>%s</em> içerisine yerleşir.',
		'mute' => 'sessize al',
		'no_selected' => 'Hiçbir akış seçilmedi.',
		'number_entries' => '%d makale',
		'priority' => array(
			'_' => 'Görünürlük',
			'archived' => 'Gösterme (arşivlenmiş)',
			'main_stream' => 'Ana akışda göster',
			'normal' => 'Kendi kategorisinde göster',
		),
		'proxy' => 'Bu akışı güncellemek için vekil sunucu kullan',
		'proxy_help' => 'Bir protokol seçin (ör: SOCKS5) vekil sunucu adresini girin (e.g: <kbd>127.0.0.1:1080</kbd>)',
		'selector_preview' => array(
			'show_raw' => 'Kaynak kodu göster',
			'show_rendered' => 'İçeriği göster',
		),
		'show' => array(
			'all' => 'Tüm akışı göster',
			'error' => 'Sadece hatalı akışları göster',
		),
		'showing' => array(
			'error' => 'Sadece hatalı akışları gösteriliyor',
		),
		'ssl_verify' => 'SSL güvenliğini doğrula',
		'stats' => 'İstatistikler',
		'think_to_add' => 'Akış ekleyebilirsiniz.',
		'timeout' => 'Zaman aşımı (saniye)',
		'title' => 'Başlık',
		'title_add' => 'RSS akışı ekle',
		'ttl' => 'Şu kadar süreden fazla otomatik yenileme yapma',
		'url' => 'Akış URL',
		'useragent' => 'Bu akışı yüklemek için user agent kullan',
		'useragent_help' => 'Örnek: <kbd>Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:86.0)</kbd>',
		'validator' => 'Akış geçerliliğini kontrol edin',
		'website' => 'Site URL',
		'websub' => 'WebSub ile anlık bildirim',
	),
	'import_export' => array(
		'export' => 'Dışa aktar',
		'export_labelled' => 'Etiketli makaleleri dışarı aktar',
		'export_opml' => 'Akış listesini dışarı aktar (OPML)',
		'export_starred' => 'Favorileri dışarı aktar',
		'feed_list' => '%s makalenin listesi',
		'file_to_import' => 'Dosyadan içe aktar<br />(OPML, JSON or ZIP)',
		'file_to_import_no_zip' => 'Dosyadan içe aktar<br />(OPML or JSON)',
		'import' => 'İçe aktar',
		'starred_list' => 'Favori makaleleirn listesi',
		'title' => 'İçe / dışa aktar',
	),
	'menu' => array(
		'add' => 'Kategori veya akış ekle',
		'import_export' => 'İçe / dışa aktar',
		'label_management' => 'Etiket yönetimi',
		'stats' => array(
			'idle' => 'Boştaki akışlar',
			'main' => 'Ana istatistikler',
			'repartition' => 'Makale dağılımı',
		),
		'subscription_management' => 'Abonelik yönetimi',
		'subscription_tools' => 'Abonelik araçları',
	),
	'tag' => array(
		'name' => 'İsim',
		'new_name' => 'Eski isim',
		'old_name' => 'Yeni isim',
	),
	'title' => array(
		'_' => 'Abonelik yönetimi',
		'add' => 'Kategori veya akış ekle',
		'add_category' => 'Kategori ekle',
		'add_dynamic_opml' => 'Dinamik OPML ekle',
		'add_feed' => 'Akış ekle',
		'add_label' => 'Etiket ekle',
		'delete_label' => 'Etiket sil',
		'feed_management' => 'RSS akış yönetimi',
		'rename_label' => 'Etiketi yeniden adlandır',
		'subscription_tools' => 'Abonelik araçları',
	),
);
