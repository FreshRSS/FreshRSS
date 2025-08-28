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
		'documentation' => 'Aşağıdaki URL’yi kopyalayın ve harici bir araçta kullanın.',
		'title' => 'API',	// IGNORE
	),
	'bookmarklet' => array(
		'documentation' => 'Bu düğmeyi yer imleri çubuğunuza sürükleyin veya sağ tıklayıp “Bu Bağlantıyı Yer İmlerine Ekle” seçeneğini seçin. Ardından abone olmak istediğiniz herhangi bir sayfada “Abone Ol” düğmesine tıklayın.',
		'label' => 'Abone Ol',
		'title' => 'Yer İmi Aracı',
	),
	'category' => array(
		'_' => 'Kategori',
		'add' => 'Kategori ekle',
		'archiving' => 'Arşivleme',
		'dynamic_opml' => array(
			'_' => 'Dinamik OPML',
			'help' => 'Bu kategoriyi beslemelerle dinamik olarak doldurmak için bir <a href="http://opml.org/" target="_blank">OPML dosyası</a> URL’si sağlayın.',
		),
		'empty' => 'Boş kategori',
		'expand' => 'Kategoriyi genişlet',
		'information' => 'Bilgi',
		'open' => 'Kategoriyi aç',
		'opml_url' => 'OPML URL’si',
		'position' => 'Görüntüleme konumu',
		'position_help' => 'Kategori sıralama düzenini kontrol etmek için',
		'title' => 'Başlık',
	),
	'feed' => array(
		'accept_cookies' => 'Çerezleri kabul et',
		'accept_cookies_help' => 'Besleme sunucusunun çerez ayarlamasına izin ver (yalnızca istek süresince bellekte saklanır).',
		'add' => 'Besleme ekle',
		'advanced' => 'Gelişmiş',
		'archiving' => 'Arşivleme',
		'auth' => array(
			'configuration' => 'Giriş',
			'help' => 'HTTP ile korunan RSS beslemelerine erişim sağlar.',
			'http' => 'HTTP Kimlik Doğrulama',
			'password' => 'HTTP parolası',
			'username' => 'HTTP kullanıcı adı',
		),
		'change_favicon' => 'Change…',	// TODO
		'clear_cache' => 'Önbelleği her zaman temizle',
		'content_action' => array(
			'_' => 'Makale içeriği getirilirken içerik eylemi',
			'append' => 'Mevcut içeriğin sonuna ekle',
			'prepend' => 'Mevcut içeriğin başına ekle',
			'replace' => 'Mevcut içeriği değiştir',
		),
		'content_retrieval' => 'İçerik alma',
		'css_cookie' => 'Makale içeriği getirilirken çerezleri kullan',
		'css_cookie_help' => 'Örnek: <kbd>foo=bar; gdpr_consent=true; cookie=value</kbd>',
		'css_help' => 'Kısaltılmış RSS beslemelerini alır (dikkat, daha fazla zaman gerektirir!)',
		'css_path' => 'Orijinal web sitesindeki makale CSS seçicisi',
		'css_path_filter' => array(
			'_' => 'Kaldırılacak öğelerin CSS seçicisi',
			'help' => 'CSS seçicisi bir liste olabilir, örneğin: <kbd>footer, aside, p[data-sanitized-class~="menu"]</kbd>',
		),
		'description' => 'Açıklama',
		'empty' => 'Bu besleme boş. Lütfen hala güncel olup olmadığını kontrol edin.',
		'error' => 'Bu beslemede bir sorun oluştu. Eğer bu durum devam ederse, lütfen hala erişilebilir olup olmadığını kontrol edin.',
		'export-as-opml' => array(
			'download' => 'İndir',
			'help' => 'XML dosyası (veri alt kümesi. <a href="https://freshrss.github.io/FreshRSS/en/developers/OPML.html" target="_blank">Belgelere bakın</a>)',
			'label' => 'OPML olarak dışa aktar',
		),
		'ext_favicon' => 'Set automatically',	// TODO
		'favicon_changed_by_ext' => 'The icon has been set by the <b>%s</b> extension.',	// TODO
		'filteractions' => array(
			'_' => 'Filtre eylemleri',
			'help' => 'Her satıra bir arama filtresi yazın. Operatörler için <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">belgelere bakın</a>.',
		),
		'http_headers' => 'HTTP Başlıkları',
		'http_headers_help' => 'Başlıklar yeni bir satırla ayrılır ve bir başlığın adı ile değeri iki nokta üst üste ile ayrılır (örneğin: <kbd><code>Accept: application/atom+xml<br />Authorization: Bearer some-token</code></kbd>).',
		'icon' => 'Icon',	// TODO
		'information' => 'Bilgi',
		'keep_min' => 'Saklanacak minimum makale sayısı',
		'kind' => array(
			'_' => 'Besleme kaynağı türü',
			'html_json' => array(
				'_' => 'HTML + XPath + JSON nokta notasyonu (HTML içindeki JSON)',
				'xpath' => array(
					'_' => 'HTML içindeki JSON için XPath',
					'help' => 'Örnek: <code>normalize-space(//script[@type="application/json"])</code> (tek JSON)<br />veya: <code>//script[@type="application/ld+json"]</code> (her makale için bir JSON nesnesi)',
				),
			),
			'html_xpath' => array(
				'_' => 'HTML + XPath (Web kazıma)',
				'feed_title' => array(
					'_' => 'besleme başlığı',
					'help' => 'Örnek: <code>//title</code> veya sabit bir metin: <code>"Benim özel beslemem"</code>',
				),
				'help' => '<dfn><a href="https://www.w3.org/TR/xpath-10/" target="_blank">XPath 1.0</a></dfn>, gelişmiş kullanıcılar için standart bir sorgu dilidir ve FreshRSS tarafından web kazımayı etkinleştirmek için desteklenir.',
				'item' => array(
					'_' => 'haber <strong>öğelerini</strong> bulma<br /><small>(en önemlisi)</small>',
					'help' => 'Örnek: <code>//div[@class="news-item"]</code>',
				),
				'item_author' => array(
					'_' => 'öğe yazarı',
					'help' => 'Sabit bir metin de olabilir. Örnek: <code>"Anonim"</code>',
				),
				'item_categories' => 'öğe etiketleri',
				'item_content' => array(
					'_' => 'öğe içeriği',
					'help' => 'Tam öğeyi almak için örnek: <code>.</code>',
				),
				'item_thumbnail' => array(
					'_' => 'öğe küçük resmi',
					'help' => 'Örnek: <code>descendant::img/@src</code>',
				),
				'item_timeFormat' => array(
					'_' => 'Özel tarih/saat biçimi',
					'help' => 'İsteğe bağlı. <a href="https://php.net/datetime.createfromformat" target="_blank"><code>DateTime::createFromFormat()</code></a> tarafından desteklenen bir biçim, örneğin <code>d-m-Y H:i:s</code>',
				),
				'item_timestamp' => array(
					'_' => 'öğe tarihi',
					'help' => 'Sonuç, <a href="https://php.net/strtotime" target="_blank"><code>strtotime()</code></a> tarafından ayrıştırılacaktır.',
				),
				'item_title' => array(
					'_' => 'öğe başlığı',
					'help' => 'Özellikle <a href="https://developer.mozilla.org/docs/Web/XPath/Axes" target="_blank">XPath ekseni</a> <code>descendant::</code> kullanın, örneğin <code>descendant::h2</code>',
				),
				'item_uid' => array(
					'_' => 'öğe benzersiz kimliği',
					'help' => 'İsteğe bağlı. Örnek: <code>descendant::div/@data-uri</code>',
				),
				'item_uri' => array(
					'_' => 'öğe bağlantısı (URL)',
					'help' => 'Örnek: <code>descendant::a/@href</code>',
				),
				'relative' => 'Öğe ile ilgili XPath:',
				'xpath' => 'Şunun için XPath:',
			),
			'json_dotnotation' => array(
				'_' => 'JSON (nokta notasyonu)',
				'feed_title' => array(
					'_' => 'besleme başlığı',
					'help' => 'Örnek: <code>meta.title</code> veya sabit bir metin: <code>"Benim özel beslemem"</code>',
				),
				'help' => 'JSON nokta notasyonu, nesneler arasında noktalar ve diziler için köşeli parantezler kullanır (örneğin <code>data.items[0].title</code>).',
				'item' => array(
					'_' => 'haber <strong>öğelerini</strong> bulma<br /><small>(en önemlisi)</small>',
					'help' => 'Öğeleri içeren diziye giden JSON yolu, örneğin <code>$</code> veya <code>newsItems</code>',
				),
				'item_author' => 'öğe yazarı',
				'item_categories' => 'öğe etiketleri',
				'item_content' => array(
					'_' => 'öğe içeriği',
					'help' => 'İçeriğin bulunduğu anahtar, örneğin <code>content</code>',
				),
				'item_thumbnail' => array(
					'_' => 'öğe küçük resmi',
					'help' => 'Örnek: <code>image</code>',
				),
				'item_timeFormat' => array(
					'_' => 'Özel tarih/saat biçimi',
					'help' => 'İsteğe bağlı. <a href="https://php.net/datetime.createfromformat" target="_blank"><code>DateTime::createFromFormat()</code></a> tarafından desteklenen bir biçim, örneğin <code>d-m-Y H:i:s</code>',
				),
				'item_timestamp' => array(
					'_' => 'öğe tarihi',
					'help' => 'Sonuç, <a href="https://php.net/strtotime" target="_blank"><code>strtotime()</code></a> tarafından ayrıştırılacaktır.',
				),
				'item_title' => 'öğe başlığı',
				'item_uid' => 'öğe benzersiz kimliği',
				'item_uri' => array(
					'_' => 'öğe bağlantısı (URL)',
					'help' => 'Örnek: <code>permalink</code>',
				),
				'json' => 'Şunun için nokta notasyonu:',
				'relative' => 'Öğe ile ilgili nokta notasyon yolu:',
			),
			'jsonfeed' => 'JSON Besleme',
			'rss' => 'RSS / Atom (varsayılan)',
			'xml_xpath' => 'XML + XPath',	// IGNORE
		),
		'maintenance' => array(
			'clear_cache' => 'Önbelleği temizle',
			'clear_cache_help' => 'Bu besleme için önbelleği temizle.',
			'reload_articles' => 'Makaleleri yeniden yükle',
			'reload_articles_help' => 'Belirtilen sayıda makaleyi yeniden yükle ve bir seçici tanımlıysa tam içeriği getir.',
			'title' => 'Bakım',
		),
		'max_http_redir' => 'Maksimum HTTP yönlendirmeleri',
		'max_http_redir_help' => 'Devre dışı bırakmak için 0’a ayarlayın veya boş bırakın, sınırsız yönlendirme için -1 kullanın.',
		'method' => array(
			'_' => 'HTTP Yöntemi',
		),
		'method_help' => 'POST yükü, <code>application/x-www-form-urlencoded</code> ve <code>application/json</code> için otomatik destek sağlar.',
		'method_postparams' => 'POST için yük',
		'moved_category_deleted' => 'Bir kategoriyi kaldırdığınızda, içindeki beslemeler otomatik olarak <em>%s</em> altına sınıflandırılır.',
		'mute' => array(
			'_' => 'sessize al',
			'state_is_muted' => 'Bu besleme sessize alınmış',
		),
		'no_selected' => 'Hiçbir besleme seçilmedi.',
		'number_entries' => '%d makale',
		'open_feed' => '%s beslemesini aç',
		'path_entries_conditions' => 'İçerik alma koşulları',
		'priority' => array(
			'_' => 'Görünürlük',
			'archived' => 'Gösterilmesin (arşivlenmiş)',
			'category' => 'Kategorisinde göster',
			'important' => 'Önemli beslemelerde göster',
			'main_stream' => 'Ana akışta göster',
		),
		'proxy' => 'Bu beslemeyi almak için bir proxy ayarlayın',
		'proxy_help' => 'Bir protokol seçin (örneğin: SOCKS5) ve proxy adresini girin (örneğin: <kbd>127.0.0.1:1080</kbd> veya <kbd>kullanıcıadı:parola@127.0.0.1:1080</kbd>).',
		'reset_favicon' => 'Reset to default',	// TODO
		'selector_preview' => array(
			'show_raw' => 'Kaynak kodu göster',
			'show_rendered' => 'İçeriği göster',
		),
		'show' => array(
			'all' => 'Tüm beslemeler',
			'error' => 'Yalnızca hatalı beslemeleri göster',
		),
		'showing' => array(
			'error' => 'Yalnızca hatalı beslemeler gösteriliyor',
		),
		'ssl_verify' => 'SSL güvenliğini doğrula',
		'stats' => 'İstatistikler',
		'think_to_add' => 'Birkaç besleme eklemeyi düşünebilirsiniz.',
		'timeout' => 'Zaman aşımı (saniye cinsinden)',
		'title' => 'Başlık',
		'title_add' => 'RSS beslemesi ekle',
		'ttl' => 'Otomatik yenileme sıklığını şundan fazla yapma',
		'unicityCriteria' => array(
			'_' => 'Makale benzersizlik kriteri',
			'forced' => '<span title="Beslemede yinelenen makaleler olsa bile benzersizlik kriterini zorla">zorlanmış</span>',
			'help' => 'Geçersiz beslemeler için geçerlidir.<br />⚠️ Politikayı değiştirmek kopyalar oluşturur.',
			'id' => 'Standart Kimlik (varsayılan)',
			'link' => 'Bağlantı',
			'sha1:content' => 'İçerik',
			'sha1:content_published' => 'İçerik + Tarih',
			'sha1:link_published' => 'Bağlantı + Tarih',
			'sha1:link_published_title' => 'Bağlantı + Tarih + Başlık',
			'sha1:link_published_title_content' => 'Bağlantı + Tarih + Başlık + İçerik',
			'sha1:published' => 'Tarih',
			'sha1:title' => 'Başlık',
			'sha1:title_published' => 'Başlık + Tarih',
			'sha1:title_published_content' => 'Başlık + Tarih + İçerik',
		),
		'url' => 'Besleme URL’si',
		'useragent' => 'Bu beslemeyi almak için kullanıcı aracısını ayarlayın',
		'useragent_help' => 'Örnek: <kbd>Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:86.0)</kbd>',
		'validator' => 'Beslemenin geçerliliğini kontrol et',
		'website' => 'Web sitesi URL’si',
		'websub' => 'WebSub ile anlık bildirimler',
	),
	'import_export' => array(
		'export' => array(
			'_' => 'Dışa Aktar',
			'sqlite' => 'Kullanıcı veritabanını SQLite olarak indir',
		),
		'export_labelled' => 'Etiketlenmiş makalelerinizi dışa aktarın',
		'export_opml' => 'Besleme listesini dışa aktar (OPML)',
		'export_starred' => 'Favorilerinizi dışa aktarın',
		'feed_list' => '%s makalenin listesi',
		'file_to_import' => 'İçe aktarılacak dosya<br />(OPML, JSON veya ZIP)',
		'file_to_import_no_zip' => 'İçe aktarılacak dosya<br />(OPML veya JSON)',
		'import' => 'İçe Aktar',
		'starred_list' => 'Favori makalelerin listesi',
		'title' => 'İçe / dışa aktarma',
	),
	'menu' => array(
		'add' => 'Besleme veya kategori ekle',
		'import_export' => 'İçe / dışa aktarma',
		'label_management' => 'Etiket yönetimi',
		'stats' => array(
			'idle' => 'Boşta olan beslemeler',
			'main' => 'Ana istatistikler',
			'repartition' => 'Makale dağılımı',
		),
		'subscription_management' => 'Abonelik yönetimi',
		'subscription_tools' => 'Abonelik araçları',
	),
	'tag' => array(
		'auto_label' => 'Bu etiketi yeni makalelere ekle',
		'name' => 'İsim',
		'new_name' => 'Yeni isim',
		'old_name' => 'Eski isim',
	),
	'title' => array(
		'_' => 'Abonelik yönetimi',
		'add' => 'Besleme veya kategori ekle',
		'add_category' => 'Kategori ekle',
		'add_dynamic_opml' => 'Dinamik OPML ekle',
		'add_feed' => 'Besleme ekle',
		'add_label' => 'Etiket ekle',
		'add_opml_category' => 'OPML kategori adı',
		'delete_label' => 'Etiketi sil',
		'feed_management' => 'RSS besleme yönetimi',
		'rename_label' => 'Etiketi yeniden adlandır',
		'subscription_tools' => 'Abonelik araçları',
	),
);
