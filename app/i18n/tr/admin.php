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
	'auth' => array(
		'allow_anonymous' => 'Varsayılan kullanıcının makalelerinin (%s) anonim okunmasına izin ver',
		'allow_anonymous_refresh' => 'Makalelerin anonim olarak yenilenmesine izin ver',
		'api_enabled' => '<abbr>API</abbr> erişimine izin ver <small>(mobil uygulamalar ve kullanıcı sorgularını paylaşmak için gereklidir)</small>',
		'form' => 'Web formu (geleneksel, JavaScript gerektirir)',
		'http' => 'HTTP (gelişmiş: Web sunucusu, OIDC, SSO vb. tarafından yönetilir)',
		'none' => 'Yok (tehlikeli)',
		'title' => 'Kimlik Doğrulama',
		'token' => 'Ana kimlik doğrulama belirteci',
		'token_help' => 'Kullanıcının tüm RSS çıktılarına ve beslemeleri kimlik doğrulaması olmadan yenilemeye erişim sağlar:',
		'type' => 'Kimlik doğrulama yöntemi',
		'unsafe_autologin' => 'Güvenli olmayan otomatik girişe izin ver; şu formatı kullan: ',
	),
	'check_install' => array(
		'cache' => array(
			'nok' => '<em>./data/cache</em> dizinindeki izinleri kontrol edin. HTTP sunucusunun yazma izni olmalı.',
			'ok' => 'Önbellek dizinindeki izinler uygun.',
		),
		'categories' => array(
			'nok' => 'Kategori tablosu yanlış yapılandırılmış.',
			'ok' => 'Kategori tablosu uygun.',
		),
		'connection' => array(
			'nok' => 'Veritabanına bağlantı kurulamıyor.',
			'ok' => 'Veritabanına bağlantı uygun.',
		),
		'ctype' => array(
			'nok' => 'Karakter türü kontrolü için gerekli kütüphane bulunamadı (php-ctype).',
			'ok' => 'Karakter türü kontrolü için gerekli kütüphaneniz var (ctype).',
		),
		'curl' => array(
			'nok' => 'cURL kütüphanesi bulunamadı (php-curl paketi).',
			'ok' => 'cURL kütüphaneniz var.',
		),
		'data' => array(
			'nok' => '<em>./data</em> dizinindeki izinleri kontrol edin. HTTP sunucusunun yazma izni olmalı.',
			'ok' => 'Veri dizinindeki izinler uygun.',
		),
		'database' => 'Veritabanı kurulumu',
		'dom' => array(
			'nok' => 'DOM’u taramak için gerekli kütüphane bulunamadı (php-xml paketi).',
			'ok' => 'DOM’u taramak için gerekli kütüphaneniz var.',
		),
		'entries' => array(
			'nok' => 'Giriş tablosu yanlış yapılandırılmış.',
			'ok' => 'Giriş tablosu uygun.',
		),
		'favicons' => array(
			'nok' => '<em>./data/favicons</em> dizinindeki izinleri kontrol edin. HTTP sunucusunun yazma izni olmalı.',
			'ok' => 'Favori simgeler dizinindeki izinler uygun.',
		),
		'feeds' => array(
			'nok' => 'Besleme tablosu yanlış yapılandırılmış.',
			'ok' => 'Besleme tablosu uygun.',
		),
		'fileinfo' => array(
			'nok' => 'PHP fileinfo kütüphanesi bulunamadı (fileinfo paketi).',
			'ok' => 'Fileinfo kütüphaneniz var.',
		),
		'files' => 'Dosya kurulumu',
		'json' => array(
			'nok' => 'JSON bulunamadı (php-json paketi).',
			'ok' => 'JSON uzantınız var.',
		),
		'mbstring' => array(
			'nok' => 'Unicode için önerilen mbstring kütüphanesi bulunamadı.',
			'ok' => 'Unicode için önerilen mbstring kütüphaneniz var.',
		),
		'pcre' => array(
			'nok' => 'Düzenli ifadeler için gerekli kütüphane bulunamadı (php-pcre).',
			'ok' => 'Düzenli ifadeler için gerekli kütüphaneniz var (PCRE).',
		),
		'pdo' => array(
			'nok' => 'PDO veya desteklenen sürücülerden biri bulunamadı (pdo_mysql, pdo_sqlite, pdo_pgsql).',
			'ok' => 'PDO ve desteklenen sürücülerden en az biri var (pdo_mysql, pdo_sqlite, pdo_pgsql).',
		),
		'php' => array(
			'_' => 'PHP kurulumu',
			'nok' => 'PHP sürümünüz %s, ancak FreshRSS en az %s sürümünü gerektiriyor.',
			'ok' => 'PHP sürümünüz (%s) FreshRSS ile uyumlu.',
		),
		'tables' => array(
			'nok' => 'Veritabanında bir veya daha fazla eksik tablo var.',
			'ok' => 'Veritabanında uygun tablolar mevcut.',
		),
		'title' => 'Kurulum kontrolü',
		'tokens' => array(
			'nok' => '<em>./data/tokens</em> dizinindeki izinleri kontrol edin. HTTP sunucusunun yazma izni olmalı',
			'ok' => 'Belirteçler dizinindeki izinler uygun.',
		),
		'users' => array(
			'nok' => '<em>./data/users</em> dizinindeki izinleri kontrol edin. HTTP sunucusunun yazma izni olmalı',
			'ok' => 'Kullanıcılar dizinindeki izinler uygun.',
		),
		'zip' => array(
			'nok' => 'ZIP uzantısı bulunamadı (php-zip paketi).',
			'ok' => 'ZIP uzantınız var.',
		),
	),
	'extensions' => array(
		'author' => 'Yazar',
		'community' => 'Mevcut topluluk eklentileri',
		'description' => 'Açıklama',
		'disabled' => 'Devre dışı',
		'empty_list' => 'Yüklü eklenti yok',
		'empty_list_help' => 'Eklenti listesinin neden boş olduğunu belirlemek için günlükleri kontrol edin.',
		'enabled' => 'Etkin',
		'latest' => 'Yüklü',
		'name' => 'İsim',
		'no_configure_view' => 'Bu eklenti yapılandırılamaz.',
		'system' => array(
			'_' => 'Sistem eklentileri',
			'no_rights' => 'Sistem eklentisi (gerekli izinlere sahip değilsiniz)',
		),
		'title' => 'Eklentiler',
		'update' => 'Güncelleme mevcut',
		'user' => 'Kullanıcı eklentileri',
		'version' => 'Sürüm',
	),
	'stats' => array(
		'_' => 'İstatistikler',
		'all_feeds' => 'Tüm beslemeler',
		'category' => 'Kategori',
		'entry_count' => 'Giriş sayısı',
		'entry_per_category' => 'Kategorilere göre girişler',
		'entry_per_day' => 'Günlük girişler (son 30 gün)',
		'entry_per_day_of_week' => 'Haftanın günlerine göre (ortalama: %.2f mesaj)',
		'entry_per_hour' => 'Saatlik (ortalama: %.2f mesaj)',
		'entry_per_month' => 'Aylık (ortalama: %.2f mesaj)',
		'entry_repartition' => 'Giriş dağılımı',
		'feed' => 'Besleme',
		'feed_per_category' => 'Kategorilere göre beslemeler',
		'idle' => 'Boşta beslemeler',
		'main' => 'Ana istatistikler',
		'main_stream' => 'Ana akış',
		'no_idle' => 'Boşta besleme yok!',
		'number_entries' => '%d makale',
		'overview' => 'Genel Bakış',
		'percent_of_total' => 'Toplamın yüzdesi',
		'repartition' => 'Makale dağılımı: %s',
		'status_favorites' => 'Favoriler',
		'status_read' => 'Okundu',
		'status_total' => 'Toplam',
		'status_unread' => 'Okunmadı',
		'title' => 'İstatistikler',
		'top_feed' => 'En iyi on besleme',
	),
	'system' => array(
		'_' => 'Sistem yapılandırması',
		'auto-update-url' => 'Otomatik güncelleme sunucu URL’si',
		'base-url' => array(
			'_' => 'Temel URL',
			'recommendation' => 'Otomatik öneri: <kbd>%s</kbd>',
		),
		'cookie-duration' => array(
			'help' => 'saniye cinsinden',
			'number' => 'Oturum açık kalma süresi',
		),
		'force_email_validation' => 'E-posta adresi doğrulamasını zorunlu kıl',
		'instance-name' => 'Örnek adı',
		'max-categories' => 'Kullanıcı başına maksimum kategori sayısı',
		'max-feeds' => 'Kullanıcı başına maksimum besleme sayısı',
		'registration' => array(
			'number' => 'Maksimum hesap sayısı',
			'select' => array(
				'label' => 'Kayıt formu',
				'option' => array(
					'noform' => 'Devre dışı: Kayıt formu yok',
					'nolimit' => 'Etkin: Hesap sınırlaması yok',
					'setaccountsnumber' => 'Maksimum hesap sayısını ayarla',
				),
			),
			'status' => array(
				'disabled' => 'Form devre dışı',
				'enabled' => 'Form etkin',
			),
			'title' => 'Kullanıcı kayıt formu',
		),
		'sensitive-parameter' => 'Hassas parametre. <kbd>./data/config.php</kbd> dosyasında manuel olarak düzenleyin',
		'tos' => array(
			'disabled' => 'verilmedi',
			'enabled' => '<a href="./?a=tos">etkin</a>',
			'help' => '<a href="https://freshrss.github.io/FreshRSS/en/admins/12_User_management.html#enable-terms-of-service-tos" target="_blank">Hizmet Şartlarını nasıl etkinleştiririm</a>',
		),
		'websub' => array(
			'help' => '<a href="https://freshrss.github.io/FreshRSS/en/users/WebSub.html" target="_blank">WebSub</a> hakkında',
		),
	),
	'update' => array(
		'_' => 'FreshRSS’yi Güncelle',
		'apply' => 'Güncellemeyi başlat',
		'changelog' => 'Değişiklik günlüğü',
		'check' => 'Yeni güncellemeleri kontrol et',
		'copiedFromURL' => 'update.php, %s adresinden ./data’ya kopyalandı',
		'current_version' => 'Mevcut yüklü sürüm',
		'last' => 'Son kontrol',
		'loading' => 'Güncelleniyor…',
		'none' => 'Güncelleme yok',
		'releaseChannel' => array(
			'_' => 'Yayın kanalı',
			'edge' => 'Sürekli yayın (“edge”)',
			'latest' => 'Kararlı yayın (“latest”)',
		),
		'title' => 'FreshRSS’yi Güncelle',
		'viaGit' => 'Git ve GitHub.com üzerinden güncelleme başlatıldı',
	),
	'user' => array(
		'admin' => 'Yönetici',
		'article_count' => 'Makaleler',
		'back_to_manage' => '← Kullanıcı listesine dön',
		'create' => 'Yeni kullanıcı oluştur',
		'database_size' => 'Veritabanı boyutu',
		'email' => 'E-posta adresi',
		'enabled' => 'Etkin',
		'feed_count' => 'Beslemeler',
		'is_admin' => 'Yönetici mi',
		'language' => 'Dil',
		'last_user_activity' => 'Son kullanıcı etkinliği',
		'list' => 'Kullanıcı listesi',
		'number' => '%d hesap oluşturuldu',
		'numbers' => '%d hesap oluşturuldu',
		'password_form' => 'Parola<br /><small>(Web formuyla giriş yöntemi için)</small>',
		'password_format' => 'En az 7 karakter',
		'title' => 'Kullanıcıları yönet',
		'username' => 'Kullanıcı adı',
	),
);
