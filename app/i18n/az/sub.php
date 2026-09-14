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
		'documentation' => 'Xarici alətdə istifadə etmək üçün aşağıdakı URL-i kopyalayın.',
		'title' => 'API',	// IGNORE
	),
	'bookmarklet' => array(
		'documentation' => 'Bu düyməni əlfəcin panelinizə sürükləyin və ya üzərinə sağ klikləyib “Bu keçidi əlfəcinlərə əlavə et” seçin. Sonra abunə olmaq istədiyiniz istənilən səhifədə “Abunə ol” düyməsinə klikləyin.',
		'label' => 'Abunə ol',
		'title' => 'Bookmarklet',	// IGNORE
	),
	'category' => array(
		'_' => 'Kateqoriya',
		'add' => 'Kateqoriya əlavə et',
		'archiving' => 'Arxivləmə',
		'dynamic_opml' => array(
			'_' => 'Dinamik OPML',
			'help' => 'Bu kateqoriyanı lentlərlə dinamik doldurmaq üçün <a href="https://opml.org/" target="_blank">OPML faylının</a> URL-ini verin',
		),
		'empty' => 'Boş kateqoriya',
		'error' => 'Bu dinamik OPML kateqoriyasında problem yarandı. OPML URL-inin hələ də əlçatan olduğunu və istifadəçi başına düşən maksimum lent sayının aşılmadığını yoxlayın.',
		'expand' => 'Kateqoriyanı genişləndir',
		'information' => 'Məlumat',
		'open' => 'Kateqoriyanı aç',
		'opml_url' => 'OPML URL-i',
		'position' => 'Göstərilmə mövqeyi',
		'position_help' => 'Kateqoriya sıralamasına nəzarət etmək üçün',
		'title' => 'Başlıq',
	),
	'feed' => array(
		'accept_cookies' => 'Cookie-ləri qəbul et',
		'accept_cookies_help' => 'Lent serverinə cookie təyin etməyə icazə verin (yalnız sorğu müddətində yaddaşda saxlanılır)',
		'add' => 'Lent əlavə et',
		'advanced' => 'Qabaqcıl',
		'archiving' => 'Arxivləmə',
		'auth' => array(
			'configuration' => 'Giriş',
			'help' => 'HTTP ilə qorunan RSS lentlərinə giriş imkanı verir',
			'http' => 'HTTP kimlik doğrulama',
			'password' => 'HTTP parolu',
			'username' => 'HTTP istifadəçi adı',
		),
		'change_favicon' => 'Dəyiş…',
		'clear_cache' => 'Keşi həmişə təmizlə',
		'content_action' => array(
			'_' => 'Məqalə məzmunu gətirilərkən məzmun əməliyyatı',
			'append' => 'Mövcud məzmundan sonra əlavə et',
			'prepend' => 'Mövcud məzmundan əvvəl əlavə et',
			'replace' => 'Mövcud məzmunu əvəz et',
		),
		'content_retrieval' => 'Məzmunun alınması',
		'css_cookie' => 'Məqalə məzmunu gətirilərkən cookie istifadə et',
		'css_cookie_help' => 'Nümunə: <kbd>foo=bar; gdpr_consent=true; cookie=value</kbd>',
		'css_help' => 'Kəsilmiş RSS lentlərini bütöv gətirir (diqqət, daha çox vaxt tələb edir!)',
		'css_path' => 'Orijinal veb saytda məqalənin CSS seçicisi',
		'css_path_filter' => array(
			'_' => 'Çıxarılacaq elementlərin CSS seçicisi',
			'help' => 'CSS seçicisi belə bir siyahı ola bilər: <kbd>footer, aside, p[data-sanitized-class~="menu"]</kbd>',
		),
		'description' => 'Təsvir',
		'empty' => 'Bu lent boşdur. Zəhmət olmasa, onun hələ də dəstəkləndiyini yoxlayın.',
		'error' => 'Bu lentdə problem yarandı. Vəziyyət davam edərsə, zəhmət olmasa, onun hələ də əlçatan olduğunu yoxlayın.',
		'export-as-opml' => array(
			'download' => 'Endir',
			'help' => 'XML faylı (məlumatın bir hissəsi. <a href="https://freshrss.github.io/FreshRSS/en/developers/OPML.html" target="_blank">Sənədlərə baxın</a>)',
			'label' => 'OPML kimi ixrac et',
		),
		'ext_favicon' => 'Avtomatik təyin et',
		'favicon_changed_by_ext' => 'İkon <b>%s</b> genişlənməsi tərəfindən təyin edilib.',
		'filteractions' => array(
			'_' => 'Süzgəc əməliyyatları',
			'help' => 'Hər sətirdə bir axtarış süzgəci yazın. Operatorlar üçün <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">sənədlərə baxın</a>.',
			'view_filter' => 'Mövcud məqalələrdə süzgəclərin önbaxışı (yeni pəncərə)',
		),
		'global_hint' => 'Hər lentdə neçə məqalənin vəziyyətə və ya axtarış ifadəsinə uyğun gəldiyini görmək üçün <a href="%s">qlobal görünüşdən</a> istifadə edin',
		'http_headers' => 'HTTP başlıqları',
		'http_headers_help' => 'Başlıqlar sətir keçidi ilə, başlığın adı və dəyəri isə iki nöqtə ilə ayrılır (məsələn: <kbd><code>Accept: application/atom+xml<br />Authorization: Bearer some-token</code></kbd>).',
		'icon' => 'İkon',
		'information' => 'Məlumat',
		'keep_adding_feed' => 'Sonra daha çox lent əlavə edin',
		'keep_min' => 'Saxlanılacaq minimum məqalə sayı',
		'kind' => array(
			'_' => 'Lent mənbəyinin növü',
			'html_json' => array(
				'_' => 'HTML + XPath + JSON nöqtə notasiyası (HTML daxilində JSON)',
				'xpath' => array(
					'_' => 'HTML daxilindəki JSON üçün XPath',
					'help' => 'Nümunə: <code>normalize-space(//script[@type="application/json"])</code> (tək JSON)<br />və ya: <code>//script[@type="application/ld+json"]</code> (hər məqaləyə bir JSON obyekti)',
				),
			),
			'html_xpath' => array(
				'_' => 'HTML + XPath (Web scraping)',	// IGNORE
				'feed_title' => array(
					'_' => 'lentin başlığı',
					'help' => 'Nümunə: <code>//title</code> və ya statik mətn: <code>"Mənim öz lentim"</code>',
				),
				'help' => '<dfn><a href="https://www.w3.org/TR/xpath-10/" target="_blank">XPath 1.0</a></dfn> qabaqcıl istifadəçilər üçün standart sorğu dilidir və FreshRSS Web scraping imkanı yaratmaq üçün onu dəstəkləyir.',
				'item' => array(
					'_' => 'xəbər <strong>elementlərini</strong> tapmaq<br /><small>(ən vacibi)</small>',
					'help' => 'Nümunə: <code>//div[@class="news-item"]</code>',
				),
				'item_author' => array(
					'_' => 'elementin müəllifi',
					'help' => 'Statik mətn də ola bilər. Nümunə: <code>"Anonim"</code>',
				),
				'item_categories' => 'elementin etiketləri',
				'item_content' => array(
					'_' => 'elementin məzmunu',
					'help' => 'Bütöv elementi götürmək üçün nümunə: <code>.</code>',
				),
				'item_thumbnail' => array(
					'_' => 'elementin kiçik şəkli',
					'help' => 'Nümunə: <code>descendant::img/@src</code>',
				),
				'item_timeFormat' => array(
					'_' => 'Fərdi tarix və saat formatı',
					'help' => 'İstəyə bağlı. <a href="https://www.php.net/datetime.createfromformat" target="_blank"><code>DateTime::createFromFormat()</code></a> tərəfindən dəstəklənən format, məsələn <code>d-m-Y H:i:s</code>',
				),
				'item_timestamp' => array(
					'_' => 'elementin tarixi',
					'help' => 'Nəticə <a href="https://www.php.net/strtotime" target="_blank"><code>strtotime()</code></a> ilə emal ediləcək',
				),
				'item_title' => array(
					'_' => 'elementin başlığı',
					'help' => 'Xüsusilə <a href="https://developer.mozilla.org/docs/Web/XML/XPath/Reference/Axes" target="_blank">XPath oxundan</a> istifadə edin: <code>descendant::</code>, məsələn <code>descendant::h2</code>',
				),
				'item_uid' => array(
					'_' => 'elementin unikal ID-si',
					'help' => 'İstəyə bağlı. Nümunə: <code>descendant::div/@data-uri</code>',
				),
				'item_uri' => array(
					'_' => 'elementin keçidi (URL)',
					'help' => 'Nümunə: <code>descendant::a/@href</code>',
				),
				'relative' => 'XPath (elementə nisbətən) bunun üçün:',
				'xpath' => 'XPath bunun üçün:',
			),
			'json_dotnotation' => array(
				'_' => 'JSON (nöqtə notasiyası)',
				'feed_title' => array(
					'_' => 'lentin başlığı',
					'help' => 'Nümunə: <code>meta.title</code> və ya statik mətn: <code>"Mənim öz lentim"</code>',
				),
				'help' => 'JSON nöqtə notasiyası obyektlər arasında nöqtə, massivlər üçün isə kvadrat mötərizə işlədir (məsələn <code>data.items[0].title</code>)',
				'item' => array(
					'_' => 'xəbər <strong>elementlərini</strong> tapmaq<br /><small>(ən vacibi)</small>',
					'help' => 'Elementləri saxlayan massivə aparan JSON yolu, məsələn <code>$</code> və ya <code>newsItems</code>',
				),
				'item_author' => 'elementin müəllifi',
				'item_categories' => 'elementin etiketləri',
				'item_content' => array(
					'_' => 'elementin məzmunu',
					'help' => 'Məzmunun tapıldığı açar, məsələn <code>content</code>',
				),
				'item_thumbnail' => array(
					'_' => 'elementin kiçik şəkli',
					'help' => 'Nümunə: <code>image</code>',
				),
				'item_timeFormat' => array(
					'_' => 'Fərdi tarix və saat formatı',
					'help' => 'İstəyə bağlı. <a href="https://www.php.net/datetime.createfromformat" target="_blank"><code>DateTime::createFromFormat()</code></a> tərəfindən dəstəklənən format, məsələn <code>d-m-Y H:i:s</code>',
				),
				'item_timestamp' => array(
					'_' => 'elementin tarixi',
					'help' => 'Nəticə <a href="https://www.php.net/strtotime" target="_blank"><code>strtotime()</code></a> ilə emal ediləcək',
				),
				'item_title' => 'elementin başlığı',
				'item_uid' => 'elementin unikal ID-si',
				'item_uri' => array(
					'_' => 'elementin keçidi (URL)',
					'help' => 'Nümunə: <code>permalink</code>',
				),
				'json' => 'nöqtə notasiyası bunun üçün:',
				'relative' => 'nöqtə notasiyalı yol (elementə nisbətən) bunun üçün:',
			),
			'jsonfeed' => 'JSON Feed',	// IGNORE
			'rss' => 'RSS / Atom (standart)',
			'xml_xpath' => 'XML + XPath',	// IGNORE
		),
		'last-entry-publication-date' => 'Sonuncu məqalə <time datetime="%1$s" title="%1$s">%2$s</time> dərc olunub.',
		'last-entry-received-date' => 'Sonuncu məqalə <time datetime="%1$s" title="%1$s">%2$s</time> alınıb.',
		'last-error-date' => 'Sonuncu xətalı yeniləmə <time datetime="%1$s" title="%1$s">%2$s</time>.',
		'last-update' => 'Sonuncu uğurlu yeniləmə <time datetime="%1$s" title="%1$s">%2$s</time>.',
		'maintenance' => array(
			'clear_cache' => 'Keşi təmizlə',
			'clear_cache_help' => 'Bu lent üçün keşi təmizləyin.',
			'reload_articles' => 'Məqalələri yenidən yüklə',
			'reload_articles_help' => 'Göstərilən sayda məqaləni yenidən yükləyin və seçici təyin olunubsa, tam məzmunu gətirin.',
			'title' => 'Texniki xidmət',
		),
		'max_http_redir' => 'Maksimum HTTP yönləndirmə sayı',
		'max_http_redir_help' => 'Deaktiv etmək üçün 0 yazın və ya boş buraxın, limitsiz yönləndirmə üçün -1',
		'method' => array(
			'_' => 'HTTP metodu',
		),
		'method_help' => 'POST yükü <code>application/x-www-form-urlencoded</code> və <code>application/json</code> formatlarını avtomatik dəstəkləyir',
		'method_postparams' => 'POST üçün yük',
		'moved_category_deleted' => 'Kateqoriyanı sildiyiniz zaman onun lentləri avtomatik olaraq <em>%s</em> altında qruplaşdırılır.',
		'mute' => array(
			'_' => 'səssiz',
			'state_is_muted' => 'Bu lent səssizdir',
		),
		'no_selected' => 'Heç bir lent seçilməyib.',
		'number_entries' => '%d məqalə',
		'open_feed' => '%s lentini aç',
		'path_entries_conditions' => 'Məzmunun alınması üçün şərtlər',
		'priority' => array(
			'_' => 'Görünürlük',
			'category' => 'Öz kateqoriyasında göstər',
			'feed' => 'Öz lentində göstər',
			'hidden' => 'Göstərmə',
			'important' => 'Vacib lentlərdə göstər',
			'main_stream' => 'Əsas axında göstər',
		),
		'proxy' => 'Bu lenti gətirmək üçün proxy təyin edin',
		'proxy_help' => 'Protokol seçin (məsələn: SOCKS5) və proxy ünvanını daxil edin (məsələn: <kbd>127.0.0.1:1080</kbd> və ya <kbd>username:password@127.0.0.1:1080</kbd>)',
		'reset_favicon' => 'Standarta qaytar',
		'selector_preview' => array(
			'show_raw' => 'Mənbə kodunu göstər',
			'show_rendered' => 'Məzmunu göstər',
		),
		'show' => array(
			'all' => 'Bütün lentlər',
			'error' => 'Yalnız xətalı lentləri göstər',
		),
		'showing' => array(
			'error' => 'Yalnız xətalı lentlər göstərilir',
		),
		'ssl_verify' => 'SSL təhlükəsizliyini yoxla',
		'stats' => 'Statistika',
		'think_to_add' => 'Bir neçə lent əlavə edə bilərsiniz.',
		'timeout' => 'Saniyə ilə vaxt həddi',
		'title' => 'Başlıq',
		'title_add' => 'RSS lenti əlavə et',
		'ttl' => 'Avtomatik yeniləmə bundan tez-tez olmasın',
		'unicityCriteria' => array(
			'_' => 'Məqalənin unikallıq meyarı',
			'forced' => '<span title="Lentdə təkrar məqalələr olsa belə, unikallıq meyarını sabit saxla">məcburi</span>',
			'help' => 'Yanlış lentlər üçün aktualdır.<br />⚠️ Siyasətin dəyişdirilməsi təkrarlar yaradacaq.',
			'id' => 'Standart ID (ilkin)',
			'link' => 'Keçid',
			'sha1:content' => 'Məzmun',
			'sha1:content_published' => 'Məzmun + Tarix',
			'sha1:link_published' => 'Keçid + Tarix',
			'sha1:link_published_title' => 'Keçid + Tarix + Başlıq',
			'sha1:link_published_title_content' => 'Keçid + Tarix + Başlıq + Məzmun',
			'sha1:published' => 'Tarix',
			'sha1:title' => 'Başlıq',
			'sha1:title_published' => 'Başlıq + Tarix',
			'sha1:title_published_content' => 'Başlıq + Tarix + Məzmun',
		),
		'url' => 'Lentin URL-i',
		'useragent' => 'Bu lenti gətirmək üçün user agent təyin edin',
		'useragent_help' => 'Nümunə: <kbd>Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:86.0)</kbd>',
		'validator' => 'Lentin etibarlılığını yoxla',
		'website' => 'Veb saytın URL-i',
		'websub' => 'WebSub ilə ani bildirişlər',
	),
	'import_export' => array(
		'export' => array(
			'_' => 'İxrac',
			'sqlite' => 'İstifadəçi verilənlər bazasını SQLite kimi endir',
		),
		'export_labelled' => 'Etiketlənmiş məqalələrinizi ixrac edin',
		'export_opml' => 'Lentlərin siyahısını ixrac edin (OPML)',
		'export_starred' => 'Seçilmişlərinizi ixrac edin',
		'feed_list' => '%s məqalələrinin siyahısı',
		'file_to_import' => 'İdxal ediləcək fayl<br />(OPML, JSON və ya ZIP)',
		'file_to_import_no_zip' => 'İdxal ediləcək fayl<br />(OPML və ya JSON)',
		'import' => 'İdxal',
		'starred_list' => 'Seçilmiş məqalələrin siyahısı',
		'title' => 'İdxal / ixrac',
	),
	'menu' => array(
		'add' => 'Lent və ya kateqoriya əlavə et',
		'import_export' => 'İdxal / ixrac',
		'label_management' => 'Etiketlərin idarə edilməsi',
		'stats' => array(
			'idle' => 'Fəaliyyətsiz lentlər',
			'main' => 'Əsas statistika',
			'repartition' => 'Məqalələrin bölgüsü',
			'unread_dates' => 'Oxunmamışların tarixləri',
		),
		'subscription_management' => 'Abunələrin idarə edilməsi',
		'subscription_tools' => 'Abunə alətləri',
	),
	'tag' => array(
		'auto_label' => 'Bu etiketi yeni məqalələrə əlavə et',
		'name' => 'Ad',
		'new_name' => 'Yeni ad',
		'old_name' => 'Köhnə ad',
	),
	'title' => array(
		'_' => 'Abunələrin idarə edilməsi',
		'add' => 'Lent və ya kateqoriya əlavə et',
		'add_category' => 'Kateqoriya əlavə et',
		'add_dynamic_opml' => 'Dinamik OPML əlavə et',
		'add_feed' => 'Lent əlavə et',
		'add_label' => 'Etiket əlavə et',
		'add_opml_category' => 'OPML kateqoriyasının adı',
		'delete_label' => 'Bu etiketi sil',
		'feed_management' => 'RSS lentlərinin idarə edilməsi',
		'subscription_tools' => 'Abunə alətləri',
	),
);
