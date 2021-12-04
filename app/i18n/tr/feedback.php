<?php

return array(
	'access' => array(
		'denied' => 'Bu sayfaya erişim yetkiniz yok',
		'not_found' => 'Varolmayan bir sayfa arıyorsunuz',
	),
	'admin' => array(
		'optimization_complete' => 'Optimizasyon tamamlandı',
	),
	'api' => array(
		'password' => array(
			'failed' => 'Şifreniz değiştirilemedi',
			'updated' => 'Şifreniz değiştirildi',
		),
	),
	'auth' => array(
		'login' => array(
			'invalid' => 'Giriş geçersiz',
			'success' => 'Bağlantı kuruldu',
		),
		'logout' => array(
			'success' => 'Bağlantı koptu',
		),
	),
	'conf' => array(
		'error' => 'Yapılandırma ayarları kaydedilirken hata oluştu',
		'query_created' => 'Sorgu "%s" oluşturuldu.',
		'shortcuts_updated' => 'Kısayollar yenilendi',
		'updated' => 'Yapılandırm ayarları yenilendi',
	),
	'extensions' => array(
		'already_enabled' => '%s zaten aktif',
		'cannot_remove' => '%s silinemez',
		'disable' => array(
			'ko' => '%s gösterilemiyor. Detaylar için <a href="%s">FreshRSS log kayıtlarını</a> kontrol edin.',
			'ok' => '%s pasif',
		),
		'enable' => array(
			'ko' => '%s aktifleştirilemiyor. Detaylar için <a href="%s">FreshRSS log kayıtlarını</a> kontrol edin.',
			'ok' => '%s aktif',
		),
		'no_access' => '%s de yetkiniz yok',
		'not_enabled' => '%s henüz aktif değil',
		'not_found' => '%s bulunmamaktadır',
		'removed' => '%s silindi',
	),
	'import_export' => array(
		'export_no_zip_extension' => 'ZIP eklentisi mevcut sunucunuzda yer almıyor. Lütfen başka dosya formatında dışarı aktarmayı deneyin.',
		'feeds_imported' => 'Akışlarınız içe aktarıldı ve şimdi güncellenecek',
		'feeds_imported_with_errors' => 'Akışlarınız içeri aktarıldı ama bazı hatalar meydana geldi',
		'file_cannot_be_uploaded' => 'Dosya yüklenemedi!',
		'no_zip_extension' => 'ZIP eklentisi mevcut sunucunuzda yer almıyor.',
		'zip_error' => 'ZIP içe aktarımı sırasında hata meydana geldi.',
	),
	'profile' => array(
		'error' => 'Profiliniz düzenlenemedi',
		'updated' => 'Profiliniz düzenlendi',
	),
	'sub' => array(
		'actualize' => 'Güncelleme',
		'articles' => array(
			'marked_read' => 'Seçili makaleler okundu olarak işaretlendi.',
			'marked_unread' => 'Seçili makaleler okunmadı olarak işaretlendi.',
		),
		'category' => array(
			'created' => 'Kategori %s oluşturuldu.',
			'deleted' => 'Kategori silindi.',
			'emptied' => 'Kategori boşaltıldı',
			'error' => 'Kategori güncellenemedi',
			'name_exists' => 'Kategori ismi zaten bulunmakta.',
			'no_id' => 'Kategori id sinden emin olmalısınız.',
			'no_name' => 'Kategori ismi boş olamaz.',
			'not_delete_default' => 'Öntanımlı kategoriyi silemezsiniz!',
			'not_exist' => 'Kategori bulunmamakta!',
			'over_max' => 'Kategori limitini aştınız (%d)',
			'updated' => 'Karegori güncellendi.',
		),
		'feed' => array(
			'actualized' => '<em>%s</em> güncellendi',
			'actualizeds' => 'RSS akışları güncellendi',
			'added' => '<em>%s</em> RSS akışı eklendi',
			'already_subscribed' => '<em>%s</em> için zaten aboneliğiniz bulunmakta',
			'cache_cleared' => '<em>%s</em> önbelleği temizlendi',
			'deleted' => 'Akış silindi',
			'error' => 'Akış güncellenemiyor',
			'internal_problem' => 'RSS akışı eklenemiyor. Detaylar için <a href="%s">FreshRSS log kayıtlarını</a> kontrol edin. You can try force adding by appending <code>#force_feed</code> to the URL.',
			'invalid_url' => 'URL <em>%s</em> geçersiz',
			'n_actualized' => '%d akışları güncellendi',
			'n_entries_deleted' => '%d makaleleri silindi',
			'no_refresh' => 'Yenilenecek akış yok…',
			'not_added' => '<em>%s</em> eklenemedi',
			'not_found' => 'Akış bulunamadı',
			'over_max' => 'Akış limitini aştınız (%d)',
			'reloaded' => '<em>%s</em> yeniden yüklendi',
			'selector_preview' => array(
				'http_error' => 'İnternet site içeriği yüklenirken sorun oluştu.',
				'no_entries' => 'Bu akışta hiç makale yok. Görünüm oluşturmak için en az bir makale var olmalıdır.',
				'no_feed' => 'İç sunucu hatası (akış bulunamadı).',
				'no_result' => 'Seçici herhanbir şey ile eşleşmiyor. Yedek olarak bunun yerine orijinal akış metni görüntülenecektir.',
				'selector_empty' => 'Seçici boş. Görüntülemek için bir tane tanımlamalısınız.',
			),
			'updated' => 'Akış güncellendi',
		),
		'purge_completed' => 'Temizleme tamamlandı (%d makale silindi)',
	),
	'tag' => array(
		'created' => '"%s" etiketi oluşturuldu.',
		'name_exists' => 'Etiket zaten mevcut.',
		'renamed' => '"%s" isimli etiketin ismi "%s" olarak değiştirildi.',
	),
	'update' => array(
		'can_apply' => 'FreshRSS <strong>%s sürümüne</strong> güncellenecek.',
		'error' => 'Güncelleme işlemi sırasında hata: %s',
		'file_is_nok' => '<strong>%s sürümüne</strong>. <em>%s</em> klasör yetkisini kontrol edin. HTTP yazma yetkisi olmalı',
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
			'error' => '%s kullanıcısı güncellenmedi',
		),
	),
);
