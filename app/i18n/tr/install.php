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
		'fix_errors_before' => 'Lütfen sonraki adıma geçmek için hataları düzeltin.',
		'keep_install' => 'Önceki kuruluma devam et',
		'next_step' => 'Sonraki adım',
		'reinstall' => 'FreshRSS i yeniden yükle',
	),
	'auth' => array(
		'form' => 'Web formu (geleneksel, JavaScript gerektirir)',
		'http' => 'HTTP (ileri kullanıcılar için, HTTPS)',
		'none' => 'Hiçbiri (tehlikeli)',
		'password_form' => 'Şifre<br /><small>(Tarayıcı girişi için)</small>',
		'password_format' => 'En az 7 karakter',
		'type' => 'Kimlik doğrulama yöntemi',
	),
	'bdd' => array(
		'_' => 'Veritabanı',
		'conf' => array(
			'_' => 'Veritabanı yapılandırılması',
			'ko' => 'Veritabanı bilginizi doğrulayın.',
			'ok' => 'Veritabanı yapılandırılması kayıt edildi.',
		),
		'host' => 'Sunucu',
		'password' => 'Veritabanı şifresi',
		'prefix' => 'Tablo ön eki',
		'type' => 'Veritabanı türü',
		'username' => 'Veritabanı kullanıcı adı',
	),
	'check' => array(
		'_' => 'Kontroller',
		'already_installed' => 'FreshRSS zaten yüklü!',
		'cache' => array(
			'nok' => '<em>%s/em> klasör yetkisini kontrol edin. HTTP yazma yetkisi olmalı.',
			'ok' => 'Önbellek klasörü yetkileri sorunsuz.',
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
			'nok' => '<em>%s</em> klasör yetkisini kontrol edin. HTTP yazma yetkisi olmalı.',
			'ok' => 'Veri klasörü yetkileri sorunsuz.',
		),
		'dom' => array(
			'nok' => 'DOM kütüpbanesi eksik.',
			'ok' => 'DOM kütüphanesi sorunsuz.',
		),
		'favicons' => array(
			'nok' => '<em>%s</em> klasör yetkisini kontrol edin. HTTP yazma yetkisi olmalı.',
			'ok' => 'Site ikonu klasörü yetkileri sorunsuz.',
		),
		'fileinfo' => array(
			'nok' => 'PHP fileinfo eksik (fileinfo package).',
			'ok' => 'fileinfo eklentisi sorunsuz.',
		),
		'json' => array(
			'nok' => 'Tavsiye edilen JSON çözümleme kütüphanesi eksik.',
			'ok' => 'Tavsiye edilen JSON çözümleme kütüphanesi sorunsuz.',
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
			'nok' => 'PHP sürümünüz %s fakat FreshRSS için gerekli olan en düşük sürüm %s.',
			'ok' => 'PHP Sürümünüz %s, FreshRSS ile tam uyumlu.',
		),
		'reload' => 'Check again',	// TODO
		'tmp' => array(
			'nok' => '<em>%s</em> klasör yetkisini kontrol edin. HTTP yazma yetkisi olmalı.',
			'ok' => 'Geçici klasör izinleri sorunsuz.',
		),
		'unknown_process_username' => 'bilinmeyen',
		'users' => array(
			'nok' => '<em>%s</em> klasör yetkisini kontrol edin. HTTP yazma yetkisi olmalı.',
			'ok' => 'Kullanıcılar klasörü yetkileri sorunsuz.',
		),
		'xml' => array(
			'nok' => 'XML ayrıştırmak için gerekli kütüphaneye sahip değilsiniz.',
			'ok' => 'XML ayrıştırmak için gerekli kütüphaneye sahipsiniz.',
		),
	),
	'conf' => array(
		'_' => 'Genel yapılandırma',
		'ok' => 'Genel yapılandırma ayarları kayıt edildi.',
	),
	'congratulations' => 'Tebrikler!',
	'default_user' => 'Öntanımlı kullanıcı adı <small>(en fazla 16 alfanümerik karakter)</small>',
	'fix_errors_before' => 'Lütfen sonraki adıma geçmek için hataları düzeltin.',
	'javascript_is_better' => 'FreshRSS JavaScript ile daha işlevseldir',
	'js' => array(
		'confirm_reinstall' => 'FreshRSS i yeniden kurarak önceki yapılandırma ayarlarınızı kaybedeceksiniz. Devam etmek istiyor musunuz ?',
	),
	'language' => array(
		'_' => 'Dil',
		'choose' => 'FreshRSS için bir dil seçin',
		'defined' => 'Dil belirlendi.',
	),
	'missing_applied_migrations' => 'Birşeyler ters gitti; <em>%s</em> boş dosyasını elle oluşturmalısınız.',
	'ok' => 'Kurulum başarıyla tamamlandı.',
	'session' => array(
		'nok' => 'Sunucu PHP çerez ayarları hatalı yapılmış görünüyor!',
	),
	'step' => 'adım %d',
	'steps' => 'Adımlar',
	'this_is_the_end' => 'Son Adım',
	'title' => 'Kurulum · FreshRSS',
);
