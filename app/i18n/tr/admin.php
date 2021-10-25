<?php

return array(
	'auth' => array(
		'allow_anonymous' => 'Öntanımlı kullanıcının makalelerinin anonim okunmasına izin ver (%s)',
		'allow_anonymous_refresh' => 'Anonim makale yenilemesine izin ver',
		'api_enabled' => '<abbr>API</abbr> erişimine izin ver <small>(mobil uygulamalar için gerekli)</small>',
		'form' => 'Web formu (geleneksel, JavaScript gerektirir)',
		'http' => 'HTTP (ileri kullanıcılar için, HTTPS)',
		'none' => 'Hiçbiri (tehlikeli)',
		'title' => 'Kimlik doğrulama',
		'token' => 'Kimlik doğrulama işareti',
		'token_help' => 'Kimlik doğrulama olmaksızın öntanımlı kullanıcının RSS çıktısına erişime izin ver:',
		'type' => 'Kimlik doğrulama yöntemi',
		'unsafe_autologin' => 'Güvensiz otomatik girişe izin ver: ',
	),
	'check_install' => array(
		'cache' => array(
			'nok' => '<em>./data/cache</em> klasör yetkisini kontrol edin. HTTP yazma yetkisi olmalı',
			'ok' => 'Önbellek klasörü yetkileri sorunsuz.',
		),
		'categories' => array(
			'nok' => 'Kategori tablosu kötü yapılandırılmış.',
			'ok' => 'Kategori tablosu sorunsuz.',
		),
		'connection' => array(
			'nok' => 'Veritabanı ile bağlantı kurulamıyor.',
			'ok' => 'Veritabanı ile bağlantı sorunsuz.',
		),
		'ctype' => array(
			'nok' => 'Karakter yazım kontrolü için kütüphane eksik (php-ctype).',
			'ok' => 'Karakter yazım kontrolü için kütüphane sorunsuz (ctype).',
		),
		'curl' => array(
			'nok' => 'cURL eksik (php-curl package).',
			'ok' => 'cURL eklentisi sorunsuz.',
		),
		'data' => array(
			'nok' => '<em>./data</em> klasör yetkisini kontrol edin. HTTP yazma yetkisi olmalı',
			'ok' => 'Veri klasörü yetkileri sorunsuz.',
		),
		'database' => 'Veritabanı kurulumu',
		'dom' => array(
			'nok' => 'DOM kütüpbanesi eksik (php-xml package).',
			'ok' => 'DOM kütüphanesi sorunsuz.',
		),
		'entries' => array(
			'nok' => 'Giriş tablosu kötü yapılandırılmış.',
			'ok' => 'Giriş tablosu sorunsuz.',
		),
		'favicons' => array(
			'nok' => '<em>./data/favicons</em> klasör yetkisini kontrol edin. HTTP yazma yetkisi olmalı',
			'ok' => 'Site ikonu klasörü yetkileri sorunsuz.',
		),
		'feeds' => array(
			'nok' => 'Akış tablosu kötü yapılandırılmış.',
			'ok' => 'Akış tablosu sorunsuz.',
		),
		'fileinfo' => array(
			'nok' => 'PHP fileinfo eksik (fileinfo package).',
			'ok' => 'fileinfo eklentisi sorunsuz.',
		),
		'files' => 'Dosya kurulumu',
		'json' => array(
			'nok' => 'JSON eklentisi eksik (php-json package).',
			'ok' => 'JSON eklentisi sorunsuz.',
		),
		'mbstring' => array(
			'nok' => 'Unicode için tavsiye edilen mbstring kütüphanesi bulunamadı.',
			'ok' => 'Unicode için tavsiye edilen mbstring kütüphaneniz mevcut.',
		),
		'pcre' => array(
			'nok' => 'Düzenli ifadeler kütüphanesi eksik (php-pcre).',
			'ok' => 'Düzenli ifadeler kütüphanesi sorunsuz (PCRE).',
		),
		'pdo' => array(
			'nok' => 'PDO veya PDO destekli bir sürücü eksik (pdo_mysql, pdo_sqlite, pdo_pgsql).',
			'ok' => 'PDO sorunsuz (pdo_mysql, pdo_sqlite, pdo_pgsql).',
		),
		'php' => array(
			'_' => 'PHP kurulumu',
			'nok' => 'PHP sürümünüz %s fakat FreshRSS için gerekli olan en düşük sürüm %s.',
			'ok' => 'PHP sürümünüz %s, FreshRSS ile tam uyumlu.',
		),
		'tables' => array(
			'nok' => 'Veritabanında bir veya daha fazla tablo eksik.',
			'ok' => 'Veritabanı tabloları sorunsuz.',
		),
		'title' => 'Kurulum kontrolü',
		'tokens' => array(
			'nok' => '<em>./data/tokens</em> klasör yetkisini kontrol edin. HTTP yazma yetkisi olmalı',
			'ok' => 'İşaretler klasörü yetkileri sorunsuz..',
		),
		'users' => array(
			'nok' => '<em>./data/users</em> klasör yetkisini kontrol edin. HTTP yazma yetkisi olmalı',
			'ok' => 'Kullanıcılar klasörü yetkileri sorunsuz.',
		),
		'zip' => array(
			'nok' => 'ZIP eklentisi eksik (php-zip package).',
			'ok' => 'ZIP eklentisi sorunsuz.',
		),
	),
	'extensions' => array(
		'author' => 'Yazar',
		'community' => 'Kullanılabilir topluluk eklentileri',
		'description' => 'Açıklama',
		'disabled' => 'Pasif',
		'empty_list' => 'Yüklenmiş eklenti bulunmamaktadır',
		'enabled' => 'Aktif',
		'latest' => 'Kuruldu',
		'name' => 'İsim',
		'no_configure_view' => 'Bu eklenti yapılandırılamaz.',
		'system' => array(
			'_' => 'Sistem eklentileri',
			'no_rights' => 'Sistem eklentileri (düzenleme hakkınız yok)',
		),
		'title' => 'Eklentiler',
		'update' => 'Güncelleme mevcut',
		'user' => 'Kullanıcı eklentileri',
		'version' => 'Sürüm',
	),
	'stats' => array(
		'_' => 'İstatistikler',
		'all_feeds' => 'Tüm akış',
		'category' => 'Kategori',
		'entry_count' => 'Makale sayısı',
		'entry_per_category' => 'Kategori başı makale sayısı',
		'entry_per_day' => 'Günlük makale sayısı (last 30 days)',
		'entry_per_day_of_week' => 'Haftanın günü (ortalama: %.2f makale)',
		'entry_per_hour' => 'Saatlik (ortalama: %.2f makale)',
		'entry_per_month' => 'Aylık (average: %.2f makale)',
		'entry_repartition' => 'Giriş dağılımı',
		'feed' => 'Akış',
		'feed_per_category' => 'Kategoriye göre akışlar',
		'idle' => 'Boştaki akışlar',
		'main' => 'Ana istatistikler',
		'main_stream' => 'Ana akış',
		'no_idle' => 'Boşta akış yok!',
		'number_entries' => '%d makale',
		'percent_of_total' => '%% toplamın yüzdesi',
		'repartition' => 'Makale dağılımı',
		'status_favorites' => 'Favoriler',
		'status_read' => 'Okunmuş',
		'status_total' => 'Toplam',
		'status_unread' => 'Okunmamış',
		'title' => 'İstatistikler',
		'top_feed' => 'İlk 10 akış',
	),
	'system' => array(
		'_' => 'Sistem yapılandırması',
		'auto-update-url' => 'Otomatik güncelleme sunucu URL',
		'cookie-duration' => array(
			'help' => 'saniye',
			'number' => 'Oturum açık kalma süresi',
		),
		'force_email_validation' => 'Email doğrulamasını zorunlu kıl',
		'instance-name' => 'Örnek isim',
		'max-categories' => 'Kullanıcı başına kategori limiti',
		'max-feeds' => 'Kullanıcı başına akış limiti',
		'registration' => array(
			'help' => '0 sınır yok anlamındadır',
			'number' => 'En fazla hesap sayısı',
			'select' => array(
				'label' => 'Registration form',	// TODO - Translation
				'option' => array(
					'noform' => 'Disabled: No registration form',	// TODO - Translation
					'nolimit' => 'Enabled: No limit of accounts',	// TODO - Translation
					'setaccountsnumber' => 'Set max. number of accounts',	// TODO - Translation
				),
			),
			'status' => array(
				'disabled' => 'Form disabled',	// TODO - Translation
				'enabled' => 'Form enabled',	// TODO - Translation
			),
			'title' => 'User registration form',	// TODO - Translation
		),
	),
	'update' => array(
		'_' => 'Sistem güncelleme',
		'apply' => 'Uygula',
		'check' => 'Güncelleme kontrolü',
		'current_version' => 'Mevcut FreshRSS sürümünüz %s.',
		'last' => 'Son kontrol: %s',
		'none' => 'Yeni güncelleme yok',
		'title' => 'Sistem güncelleme',
	),
	'user' => array(
		'admin' => 'Yönetici',
		'article_count' => 'Makaleler',
		'back_to_manage' => '← Kullanıcı listesine geri dön',
		'create' => 'Yeni kullanıcı oluştur',
		'database_size' => 'Veritabanı boyutu',
		'email' => 'Email adres',
		'enabled' => 'Aktif',
		'feed_count' => 'Akış',
		'is_admin' => 'yöneticidir',
		'language' => 'Dil',
		'last_user_activity' => 'Son kullanıcı hareketi',
		'list' => 'Kullanıcı Listesi',
		'number' => 'Oluşturulmuş %d hesap mevcut',
		'numbers' => 'Oluşturulmuş %d hesap mevcut',
		'password_form' => 'Şifre<br /><small>(Tarayıcı girişi için)</small>',
		'password_format' => 'En az 7 karakter',
		'title' => 'Kullanıcıları yönet',
		'username' => 'Kullanıcı adı',
	),
);
