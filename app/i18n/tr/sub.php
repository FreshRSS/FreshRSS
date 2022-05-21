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
		'documentation' => 'Bu butonu yer imleri araç çubuğunuza sürükleyerek veya sağ tıklayıp "Bağlantıyı yer imlerine ekle" seçeneğini seçerek yer imlerine ekleyin. Eklemek istediğiniz sitedeyken oluşturulan bu "Abone Ol" butonu ile akış ekleyebilirsiniz.',
		'label' => 'Abone ol',
		'title' => 'Bookmarklet',	// IGNORE
	),
	'category' => array(
		'_' => 'Kategori',
		'add' => 'Kategori ekle',
		'archiving' => 'Arşiv',
		'empty' => 'Boş kategori',
		'information' => 'Bilgi',
		'position' => 'Konumu göster',
		'position_help' => 'Kategori sıralama düzenini kontrol etmek için',
		'title' => 'Başlık',
	),
	'feed' => array(
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
			'_' => 'Content action when fetching the article content',	// TODO
			'append' => 'Mevcut içeriğin sonrasına ekle',
			'prepend' => 'Mevcut içeriğin öncesine ekle',
			'replace' => 'Mevcut içerikle değiştir',
		),
		'css_cookie' => 'Makale içeriğini yüklerken çerez kullan',
		'css_cookie_help' => 'Örnek: <kbd>foo=bar; gdpr_consent=true; cookie=value</kbd>',
		'css_help' => 'Dikkat, daha çok zaman gerekir!',
		'css_path' => 'Makaleleri kendi CSS görünümü ile göster',
		'description' => 'Tanım',
		'empty' => 'Bu akış boş. Lütfen akışın aktif olduğuna emin olun.',
		'error' => 'Bu akışda bir hatayla karşılaşıldı. Lütfen akışın sürekli ulaşılabilir olduğuna emin olun.',
		'filteractions' => array(
			'_' => 'Eylemi filtrele',
			'help' => 'Her satıra tek arama filtresi yaz.',
		),
		'information' => 'Bilgi',
		'keep_min' => 'En az tutulacak makale sayısı',
		'kind' => array(
			'_' => 'Type of feed source',	// TODO
			'html_xpath' => array(
				'_' => 'HTML + XPath (Web scraping)',	// TODO
				'feed_title' => array(
					'_' => 'feed title',	// TODO
					'help' => 'Example: <code>//title</code> or a static string: <code>"My custom feed"</code>',	// TODO
				),
				'help' => '<dfn><a href="https://www.w3.org/TR/xpath-10/" target="_blank">XPath 1.0</a></dfn> is a standard query language for advanced users, and which FreshRSS supports to enable Web scraping.',	// TODO
				'item' => array(
					'_' => 'finding news <strong>items</strong><br /><small>(most important)</small>',	// TODO
					'help' => 'Example: <code>//div[@class="news-item"]</code>',	// TODO
				),
				'item_author' => array(
					'_' => 'item author',	// TODO
					'help' => 'Can also be a static string. Example: <code>"Anonymous"</code>',	// TODO
				),
				'item_categories' => 'items tags',	// TODO
				'item_content' => array(
					'_' => 'item content',	// TODO
					'help' => 'Example to take the full item: <code>.</code>',	// TODO
				),
				'item_thumbnail' => array(
					'_' => 'item thumbnail',	// TODO
					'help' => 'Example: <code>descendant::img/@src</code>',	// TODO
				),
				'item_timestamp' => array(
					'_' => 'item date',	// TODO
					'help' => 'The result will be parsed by <a href="https://php.net/strtotime" target="_blank"><code>strtotime()</code></a>',	// TODO
				),
				'item_title' => array(
					'_' => 'item title',	// TODO
					'help' => 'Use in particular the <a href="https://developer.mozilla.org/docs/Web/XPath/Axes" target="_blank">XPath axis</a> <code>descendant::</code> like <code>descendant::h2</code>',	// TODO
				),
				'item_uri' => array(
					'_' => 'item link (URL)',	// TODO
					'help' => 'Example: <code>descendant::a/@href</code>',	// TODO
				),
				'relative' => 'XPath (relative to item) for:',	// TODO
				'xpath' => 'XPath for:',	// TODO
			),
			'rss' => 'RSS / Atom (default)',	// TODO
		),
		'maintenance' => array(
			'clear_cache' => 'Önbelleği temizle',
			'clear_cache_help' => 'Bu akışın önbelleğini temizler.',
			'reload_articles' => 'Makaleleri yeniden yükle',
			'reload_articles_help' => 'Reload that many articles and fetch complete content if a selector is defined.',	// TODO
			'title' => 'Bakım',
		),
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
		'add_feed' => 'Akış ekle',
		'add_label' => 'Etiket ekle',
		'delete_label' => 'Etiket sil',
		'feed_management' => 'RSS akış yönetimi',
		'rename_label' => 'Etiketi yeniden adlandır',
		'subscription_tools' => 'Abonelik araçları',
	),
);
