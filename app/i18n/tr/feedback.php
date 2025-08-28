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
	'access' => array(
		'denied' => 'Bu sayfaya erişim izniniz yok',
		'not_found' => 'Var olmayan bir sayfayı arıyorsunuz',
	),
	'admin' => array(
		'optimization_complete' => 'Optimizasyon tamamlandı',
	),
	'api' => array(
		'password' => array(
			'failed' => 'Parolanız değiştirilemedi',
			'updated' => 'Parolanız değiştirildi',
		),
	),
	'auth' => array(
		'login' => array(
			'invalid' => 'Giriş geçersiz',
			'success' => 'Bağlantı kuruldu',
		),
		'logout' => array(
			'success' => 'Bağlantınız kesildi',
		),
	),
	'conf' => array(
		'error' => 'Yapılandırma kaydedilirken bir hata oluştu',
		'query_created' => '“%s” sorgusu oluşturuldu.',
		'shortcuts_updated' => 'Kısayollar güncellendi',
		'updated' => 'Yapılandırma güncellendi',
	),
	'extensions' => array(
		'already_enabled' => '%s zaten etkin',
		'cannot_remove' => '%s kaldırılamaz',
		'disable' => array(
			'ko' => '%s devre dışı bırakılamadı. Ayrıntılar için <a href="%s">FreshRSS günlüklerini kontrol edin</a>.',
			'ok' => '%s artık devre dışı',
		),
		'enable' => array(
			'ko' => '%s etkinleştirilemedi. Ayrıntılar için <a href="%s">FreshRSS günlüklerini kontrol edin</a>.',
			'ok' => '%s artık etkin',
		),
		'invalid_view_mode' => 'Invalid view mode “%s”! Fall back to “Normal view”.',	// TODO
		'no_access' => '%s üzerinde erişiminiz yok',
		'not_enabled' => '%s etkin değil',
		'not_found' => '%s mevcut değil',
		'removed' => '%s kaldırıldı',
	),
	'import_export' => array(
		'export_no_zip_extension' => 'Sunucunuzda ZIP uzantısı mevcut değil. Lütfen dosyaları tek tek dışa aktarmayı deneyin.',
		'feeds_imported' => 'Beslemeleriniz içe aktarıldı. İçe aktarma işleminiz bittiyse, şimdi <i>Beslemeleri güncelle</i> düğmesine tıklayabilirsiniz.',
		'feeds_imported_with_errors' => 'Beslemeleriniz içe aktarıldı, ancak bazı hatalar oluştu. İçe aktarma işleminiz bittiyse, şimdi <i>Beslemeleri güncelle</i> düğmesine tıklayabilirsiniz.',
		'file_cannot_be_uploaded' => 'Dosya yüklenemedi!',
		'no_zip_extension' => 'Sunucunuzda ZIP uzantısı mevcut değil.',
		'zip_error' => 'ZIP işleme sırasında bir hata oluştu.',
	),
	'profile' => array(
		'error' => 'Profiliniz değiştirilemedi',
		'passwords_dont_match' => 'Passwords don’t match',	// TODO
		'updated' => 'Profiliniz değiştirildi',
	),
	'sub' => array(
		'actualize' => 'Güncelleniyor',
		'articles' => array(
			'marked_read' => 'Seçilen makaleler okundu olarak işaretlendi.',
			'marked_unread' => 'Makaleler okunmadı olarak işaretlendi.',
		),
		'category' => array(
			'created' => '%s kategorisi oluşturuldu.',
			'deleted' => 'Kategori silindi.',
			'emptied' => 'Kategori boşaltıldı',
			'error' => 'Kategori güncellenemedi',
			'name_exists' => 'Kategori adı zaten mevcut.',
			'no_id' => 'Kategorinin kimliğini belirtmelisiniz.',
			'no_name' => 'Kategori adı boş olamaz.',
			'not_delete_default' => 'Varsayılan kategoriyi silemezsiniz!',
			'not_exist' => 'Kategori mevcut değil!',
			'over_max' => 'Kategori limitinize ulaştınız (%d)',
			'updated' => 'Kategori güncellendi.',
		),
		'feed' => array(
			'actualized' => '<em>%s</em> güncellendi',
			'actualizeds' => 'RSS beslemeleri güncellendi',
			'added' => '<em>%s</em> RSS beslemesi eklendi',
			'already_subscribed' => '<em>%s</em> beslemesine zaten abonesiniz',
			'cache_cleared' => '<em>%s</em> önbelleği temizlendi',
			'deleted' => 'Besleme silindi',
			'error' => 'Besleme güncellenemedi',
			'favicon' => array(
				'too_large' => 'Uploaded icon is too large. The maximum file size is <em>%s</em>.',	// TODO
				'unsupported_format' => 'Unsupported image file format!',	// TODO
			),
			'internal_problem' => 'Haber akışı eklenemedi. Ayrıntılar için <a href="%s">FreshRSS günlüklerini kontrol edin</a>. URL’ye <code>#force_feed</code> ekleyerek zorla eklemeyi deneyebilirsiniz.',
			'invalid_url' => '<em>%s</em> URL’si geçersiz',
			'n_actualized' => '%d besleme güncellendi',
			'n_entries_deleted' => '%d makale silindi',
			'no_refresh' => 'Yenilenecek besleme yok',
			'not_added' => '<em>%s</em> eklenemedi',
			'not_found' => 'Besleme bulunamadı',
			'over_max' => 'Besleme limitinize ulaştınız (%d)',
			'reloaded' => '<em>%s</em> yeniden yüklendi',
			'selector_preview' => array(
				'http_error' => 'Web sitesi içeriği yüklenemedi.',
				'no_entries' => 'Bu beslemede makale yok. Önizleme oluşturmak için en az bir makale gerekli.',
				'no_feed' => 'Dahili hata (besleme bulunamadı).',
				'no_result' => 'Seçici hiçbir şeyle eşleşmedi. Yedek olarak orijinal besleme metni görüntülenecek.',
				'selector_empty' => 'Seçici boş. Önizleme oluşturmak için bir tane tanımlamanız gerekiyor.',
			),
			'updated' => 'Besleme güncellendi',
		),
		'purge_completed' => 'Temizleme tamamlandı (%d makale silindi)',
	),
	'tag' => array(
		'created' => '“%s” etiketi oluşturuldu.',
		'error' => 'Etiket güncellenemedi!',
		'name_exists' => 'Etiket adı zaten mevcut.',
		'renamed' => '“%s” etiketi “%s” olarak yeniden adlandırıldı.',
		'updated' => 'Etiket güncellendi.',
	),
	'update' => array(
		'can_apply' => 'FreshRSS için bir güncelleme mevcut: <strong>Sürüm %s</strong>.',
		'error' => 'Güncelleme işlemi bir hatayla karşılaştı: %s',
		'file_is_nok' => 'FreshRSS için bir güncelleme mevcut (<strong>Sürüm %s</strong>), ancak <em>%s</em> dizinindeki izinleri kontrol edin. HTTP sunucusunun yazma izni olmalı',
		'finished' => 'Güncelleme tamamlandı!',
		'none' => 'Güncelleme yok',
		'server_not_found' => 'Güncelleme sunucusu bulunamadı. [%s]',
	),
	'user' => array(
		'created' => array(
			'_' => '%s kullanıcısı oluşturuldu',
			'error' => '%s kullanıcısı oluşturulamadı',
		),
		'deleted' => array(
			'_' => '%s kullanıcısı silindi',
			'error' => '%s kullanıcısı silinemedi',
		),
		'updated' => array(
			'_' => '%s kullanıcısı güncellendi',
			'error' => '%s kullanıcısı güncellenemedi',
		),
	),
);
