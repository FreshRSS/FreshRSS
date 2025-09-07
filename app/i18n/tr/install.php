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
	'action' => array(
		'finish' => 'Kurulumu tamamla',
		'fix_errors_before' => 'Lütfen bir sonraki adıma geçmeden önce tüm hataları düzeltin.',
		'keep_install' => 'Önceki yapılandırmayı koru',
		'next_step' => 'Bir sonraki adıma geç',
		'reinstall' => 'FreshRSS’yi yeniden kur',
	),
	'bdd' => array(
		'_' => 'Veritabanı',
		'conf' => array(
			'_' => 'Veritabanı yapılandırması',
			'ko' => 'Veritabanı yapılandırmanızı doğrulayın.',
			'ok' => 'Veritabanı yapılandırması kaydedildi.',
		),
		'host' => 'Ana makine',
		'password' => 'Veritabanı parolası',
		'prefix' => 'Tablo öneki',
		'type' => 'Veritabanı türü',
		'username' => 'Veritabanı kullanıcı adı',
	),
	'check' => array(
		'_' => 'Kontroller',
		'already_installed' => 'FreshRSS’nin zaten kurulu olduğunu tespit ettik!',
		'cache' => array(
			'nok' => '<em>%2$s</em> kullanıcısı için <em>%1$s</em> dizinindeki izinleri kontrol edin. HTTP sunucusunun yazma izni olmalı.',
			'ok' => 'Önbellek dizinindeki izinler uygun.',
		),
		'ctype' => array(
			'nok' => 'Karakter türü kontrolü için gerekli kütüphane (php-ctype) bulunamadı.',
			'ok' => 'Karakter türü kontrolü için gerekli kütüphaneniz (ctype) var.',
		),
		'curl' => array(
			'nok' => 'cURL kütüphanesi (php-curl paketi) bulunamadı.',
			'ok' => 'cURL kütüphaneniz var.',
		),
		'data' => array(
			'nok' => '<em>%2$s</em> kullanıcısı için <em>%1$s</em> dizinindeki izinleri kontrol edin. HTTP sunucusunun yazma izni olmalı.',
			'ok' => 'Veri dizinindeki izinler uygun.',
		),
		'dom' => array(
			'nok' => 'DOM’u taramak için gerekli kütüphane bulunamadı.',
			'ok' => 'DOM’u taramak için gerekli kütüphaneniz var.',
		),
		'favicons' => array(
			'nok' => '<em>%2$s</em> kullanıcısı için <em>%1$s</em> dizinindeki izinleri kontrol edin. HTTP sunucusunun yazma izni olmalı.',
			'ok' => 'Favori simgeler dizinindeki izinler uygun.',
		),
		'fileinfo' => array(
			'nok' => 'PHP fileinfo kütüphanesi (fileinfo paketi) bulunamadı.',
			'ok' => 'Fileinfo kütüphaneniz var.',
		),
		'json' => array(
			'nok' => 'JSON ayrıştırmak için önerilen kütüphane bulunamadı.',
			'ok' => 'JSON ayrıştırmak için önerilen kütüphaneniz var.',
		),
		'mbstring' => array(
			'nok' => 'Unicode için önerilen mbstring kütüphanesi bulunamadı.',
			'ok' => 'Unicode için önerilen mbstring kütüphaneniz var.',
		),
		'pcre' => array(
			'nok' => 'Düzenli ifadeler için gerekli kütüphane (php-pcre) bulunamadı.',
			'ok' => 'Düzenli ifadeler için gerekli kütüphaneniz (PCRE) var.',
		),
		'pdo' => array(
			'nok' => 'PDO veya desteklenen sürücülerden biri (pdo_mysql, pdo_sqlite, pdo_pgsql) bulunamadı.',
			'ok' => 'PDO ve desteklenen sürücülerden en az biri (pdo_mysql, pdo_sqlite, pdo_pgsql) var.',
		),
		'php' => array(
			'nok' => 'PHP sürümünüz %s, ancak FreshRSS en az %s sürümünü gerektiriyor.',
			'ok' => 'PHP sürümünüz, %s, FreshRSS ile uyumlu.',
		),
		'reload' => 'Tekrar kontrol et',
		'tmp' => array(
			'nok' => '<em>%2$s</em> kullanıcısı için <em>%1$s</em> dizinindeki izinleri kontrol edin. HTTP sunucusunun yazma izni olmalı.',
			'ok' => 'Geçici dizindeki izinler uygun.',
		),
		'unknown_process_username' => 'bilinmeyen',
		'users' => array(
			'nok' => '<em>%2$s</em> kullanıcısı için <em>%1$s</em> dizinindeki izinleri kontrol edin. HTTP sunucusunun yazma izni olmalı.',
			'ok' => 'Kullanıcılar dizinindeki izinler uygun.',
		),
		'xml' => array(
			'nok' => 'XML ayrıştırmak için gerekli kütüphane bulunamadı.',
			'ok' => 'XML ayrıştırmak için gerekli kütüphaneniz var.',
		),
	),
	'conf' => array(
		'_' => 'Genel yapılandırma',
		'ok' => 'Genel yapılandırma kaydedildi.',
	),
	'congratulations' => 'Tebrikler!',
	'default_user' => array(
		'_' => 'Varsayılan kullanıcının kullanıcı adı',
		'max_char' => 'en fazla 16 alfanümerik karakter',
	),
	'fix_errors_before' => 'Lütfen bir sonraki adıma geçmeden önce hataları düzeltin.',
	'javascript_is_better' => 'FreshRSS, JavaScript etkinleştirildiğinde daha keyifli',
	'js' => array(
		'confirm_reinstall' => 'FreshRSS’yi yeniden kurarak önceki yapılandırmanızı kaybedeceksiniz. Devam etmek istediğinizden emin misiniz?',
	),
	'language' => array(
		'_' => 'Dil',
		'choose' => 'FreshRSS için bir dil seçin',
		'defined' => 'Dil tanımlandı.',
	),
	'missing_applied_migrations' => 'Bir şeyler ters gitti; <em>%s</em> dosyasını manuel olarak boş bir şekilde oluşturmalısınız.',
	'ok' => 'Kurulum işlemi başarılı oldu.',
	'session' => array(
		'nok' => 'Web sunucusu, PHP oturumları için gerekli çerezler konusunda yanlış yapılandırılmış görünüyor!',
	),
	'step' => 'adım %d',
	'steps' => 'Adımlar',
	'this_is_the_end' => 'Bu son',
	'title' => 'Kurulum · FreshRSS',
);
