<?php

return array(
	'action' => array(
		'finish' => 'Kurulumu tamamla',
		'fix_errors_before' => 'Lütfen sonraki adıma geçmek için hataları düzeltin.',
		'keep_install' => 'Önceki kuruluma devam et',
		'next_step' => 'Sonraki adım',
		'reinstall' => 'FreshRSS i yeniden yükle',
	),
	'auth' => array(
		'email_persona' => 'Giriş email adresi<br /><small>(<a href="https://persona.org/" rel="external">Mozilla Persona</a> için)</small>',
		'form' => 'Web formu (geleneksel, JavaScript gerektirir)',
		'http' => 'HTTP (ileri kullanıcılar için, HTTPS)',
		'none' => 'Hiçbiri (tehlikeli)',
		'password_form' => 'Şifre<br /><small>(Tarayıcı girişi için)</small>',
		'password_format' => 'En az 7 karakter',
		'persona' => 'Mozilla Persona (modern, JavaScript gerektirir)',
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
		'prefix' => 'Tablo ön eki',
		'password' => 'HTTP şifre',
		'type' => 'Veritabanı türü',
		'username' => 'HTTP kullanıcı adı',
	),
	'check' => array(
		'_' => 'Kontroller',
		'already_installed' => 'FreshRSS zaten yüklü!',
		'cache' => array(
			'nok' => '<em>./data/cache</em> klasör yetkisini kontrol edin. HTTP yazma yetkisi olmalı',
			'ok' => 'Önbellek klasörü yetkileri sorunsuz.',
		),
		'ctype' => array(
			'nok' => 'Karakter yazım kontrolü için kütüphane eksik (php-ctype).',
			'ok' => 'Karakter yazım kontrolü için kütüphane sorunsuz (ctype).',
		),
		'curl' => array(
			'nok' => 'cURL eksik (php5-curl package).',
			'ok' => 'cURL eklentisi sorunsuz.',
		),
		'data' => array(
			'nok' => '<em>./data</em> klasör yetkisini kontrol edin. HTTP yazma yetkisi olmalı',
			'ok' => 'Veri klasörü yetkileri sorunsuz.',
		),
		'dom' => array(
			'nok' => 'DOM kütüpbanesi eksik.',
			'ok' => 'DOM kütüphanesi sorunsuz.',
		),
		'favicons' => array(
			'nok' => '<em>./data/favicons</em> klasör yetkisini kontrol edin. HTTP yazma yetkisi olmalı',
			'ok' => 'Site ikonu klasörü yetkileri sorunsuz.',
		),
		'http_referer' => array(
			'nok' => 'Lütfen HTTP REFERER değiştirmediğinize emin olun.',
			'ok' => 'HTTP REFERER ve sunucunuz arası iletişim sorunsuz.',
		),
		'json' => array(
			'nok' => 'Tavsiye edilen JSON çözümleme kütüphanesi eksik.',
			'ok' => 'Tavsiye edilen JSON çözümleme kütüphanesi sorunsuz.',
		),
		'minz' => array(
			'nok' => 'Minz framework eksik.',
			'ok' => 'Minz framework sorunsuz.',
		),
		'pcre' => array(
			'nok' => 'Düzenli ifadeler kütüphanesi eksik (php-pcre).',
			'ok' => 'Düzenli ifadeler kütüphanesi sorunsuz (PCRE).',
		),
		'pdo' => array(
			'nok' => 'PDO veya PDO destekli bir sürücü eksik (pdo_mysql, pdo_sqlite).',
			'ok' => 'PDO sorunsuz (pdo_mysql, pdo_sqlite).',
		),
		'persona' => array(
			'nok' => '<em>./data/persona</em> klasör yetkisini kontrol edin. HTTP yazma yetkisi olmalı',
			'ok' => 'Mozilla Persona klasörü yetkileri sorunsuz.',
		),
		'php' => array(
			'nok' => 'PHP versiyonunuz %s fakat FreshRSS için gerekli olan en düşük sürüm %s.',
			'ok' => 'PHP versiyonunuz %s, FreshRSS ile tam uyumlu.',
		),
		'users' => array(
			'nok' => '<em>./data/users</em> klasör yetkisini kontrol edin. HTTP yazma yetkisi olmalı',
			'ok' => 'Kullanıcılar klasörü yetkileri sorunsuz.',
		),
		'xml' => array(
			'nok' => 'You lack the required library to parse XML.',
			'ok' => 'You have the required library to parse XML.',
		),
	),
	'conf' => array(
		'_' => 'Genel yapılandırma',
		'ok' => 'Genel yapılandırma ayarları kayıt edildi.',
	),
	'congratulations' => 'Tebrikler!',
	'default_user' => 'Öntanımlı kullanıcı adı <small>(en fazla 16 alfanümerik karakter)</small>',
	'delete_articles_after' => 'Makaleleri şu süre sonunda sil',
	'fix_errors_before' => 'Lütfen sonraki adıma geçmek için hataları düzeltin.',
	'javascript_is_better' => 'FreshRSS JavaScript ile daha işlevseldir',
	'js' => array(
		'confirm_reinstall' => 'FressRSS i yeniden kurarak önceki yapılandırma ayarlarınızı kaybedeceksiniz. Devam etmek istiyor musunuz ?',
	),
	'language' => array(
		'_' => 'Dil',
		'choose' => 'FreshRSS için bir dil seçin',
		'defined' => 'Dil belirlendi.',
	),
	'not_deleted' => 'Hata meydana geldi; <em>%s</em> dosyasını elle silmelisiniz.',
	'ok' => 'Kurulum başarıyla tamamlandı.',
	'step' => 'adım %d',
	'steps' => 'Adımlar',
	'title' => 'Kurulum · FreshRSS',
	'this_is_the_end' => 'Son Adım',
);
