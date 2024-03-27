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

return [
	'access' => [
		'denied' => 'Bu sayfaya erişim yetkiniz yok',
		'not_found' => 'Varolmayan bir sayfa arıyorsunuz',
	],
	'admin' => [
		'optimization_complete' => 'Optimizasyon tamamlandı',
	],
	'api' => [
		'password' => [
			'failed' => 'Şifreniz değiştirilemedi',
			'updated' => 'Şifreniz değiştirildi',
		],
	],
	'auth' => [
		'login' => [
			'invalid' => 'Giriş geçersiz',
			'success' => 'Bağlantı kuruldu',
		],
		'logout' => [
			'success' => 'Bağlantı koptu',
		],
	],
	'conf' => [
		'error' => 'Yapılandırma ayarları kaydedilirken hata oluştu',
		'query_created' => 'Sorgu “%s” oluşturuldu.',
		'shortcuts_updated' => 'Kısayollar yenilendi',
		'updated' => 'Yapılandırm ayarları yenilendi',
	],
	'extensions' => [
		'already_enabled' => '%s zaten aktif',
		'cannot_remove' => '%s silinemez',
		'disable' => [
			'ko' => '%s gösterilemiyor. Detaylar için <a href="%s">FreshRSS log kayıtlarını</a> kontrol edin.',
			'ok' => '%s pasif',
		],
		'enable' => [
			'ko' => '%s aktifleştirilemiyor. Detaylar için <a href="%s">FreshRSS log kayıtlarını</a> kontrol edin.',
			'ok' => '%s aktif',
		],
		'no_access' => '%s de yetkiniz yok',
		'not_enabled' => '%s henüz aktif değil',
		'not_found' => '%s bulunmamaktadır',
		'removed' => '%s silindi',
	],
	'import_export' => [
		'export_no_zip_extension' => 'ZIP eklentisi mevcut sunucunuzda yer almıyor. Lütfen başka dosya formatında dışarı aktarmayı deneyin.',
		'feeds_imported' => 'Akışlarınız içe aktarıldı ve şimdi güncellenecek / Your feeds have been imported. If you are done importing, you can now click the <i>Update feeds</i> button.',	// DIRTY
		'feeds_imported_with_errors' => 'Akışlarınız içeri aktarıldı ama bazı hatalar meydana geldi / Your feeds have been imported, but some errors occurred. If you are done importing, you can now click the <i>Update feeds</i> button.',	// DIRTY
		'file_cannot_be_uploaded' => 'Dosya yüklenemedi!',
		'no_zip_extension' => 'ZIP eklentisi mevcut sunucunuzda yer almıyor.',
		'zip_error' => 'ZIP içe aktarımı sırasında hata meydana geldi.',	// DIRTY
	],
	'profile' => [
		'error' => 'Profiliniz düzenlenemedi',
		'updated' => 'Profiliniz düzenlendi',
	],
	'sub' => [
		'actualize' => 'Güncelleme',
		'articles' => [
			'marked_read' => 'Seçili makaleler okundu olarak işaretlendi.',
			'marked_unread' => 'Seçili makaleler okunmadı olarak işaretlendi.',
		],
		'category' => [
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
		],
		'feed' => [
			'actualized' => '<em>%s</em> güncellendi',
			'actualizeds' => 'RSS akışları güncellendi',
			'added' => '<em>%s</em> RSS akışı eklendi',
			'already_subscribed' => '<em>%s</em> için zaten aboneliğiniz bulunmakta',
			'cache_cleared' => '<em>%s</em> önbelleği temizlendi',
			'deleted' => 'Akış silindi',
			'error' => 'Akış güncellenemiyor',
			'internal_problem' => 'RSS akışı eklenemiyor. Detaylar için <a href="%s">FreshRSS log kayıtlarını</a> kontrol edin. You can try force adding by appending <code>#force_feed</code> to the URL.',	// DIRTY
			'invalid_url' => 'URL <em>%s</em> geçersiz',
			'n_actualized' => '%d akışları güncellendi',
			'n_entries_deleted' => '%d makaleleri silindi',
			'no_refresh' => 'Yenilenecek akış yok…',
			'not_added' => '<em>%s</em> eklenemedi',
			'not_found' => 'Akış bulunamadı',
			'over_max' => 'Akış limitini aştınız (%d)',
			'reloaded' => '<em>%s</em> yeniden yüklendi',
			'selector_preview' => [
				'http_error' => 'İnternet site içeriği yüklenirken sorun oluştu.',
				'no_entries' => 'Bu akışta hiç makale yok. Görünüm oluşturmak için en az bir makale var olmalıdır.',
				'no_feed' => 'İç sunucu hatası (akış bulunamadı).',
				'no_result' => 'Seçici herhanbir şey ile eşleşmiyor. Yedek olarak bunun yerine orijinal akış metni görüntülenecektir.',
				'selector_empty' => 'Seçici boş. Görüntülemek için bir tane tanımlamalısınız.',
			],
			'updated' => 'Akış güncellendi',
		],
		'purge_completed' => 'Temizleme tamamlandı (%d makale silindi)',
	],
	'tag' => [
		'created' => '“%s” etiketi oluşturuldu.',
		'error' => 'Label could not be updated!',	// TODO
		'name_exists' => 'Etiket zaten mevcut.',
		'renamed' => '“%s” isimli etiketin ismi “%s” olarak değiştirildi.',
		'updated' => 'Label has been updated.',	// TODO
	],
	'update' => [
		'can_apply' => 'FreshRSS <strong>%s sürümüne</strong> güncellenecek.',
		'error' => 'Güncelleme işlemi sırasında hata: %s',
		'file_is_nok' => '<strong>%s sürümüne</strong>. <em>%s</em> klasör yetkisini kontrol edin. HTTP yazma yetkisi olmalı',
		'finished' => 'Güncelleme tamamlandı!',
		'none' => 'Güncelleme yok',
		'server_not_found' => 'Güncelleme sunucusu bulunamadı. [%s]',
	],
	'user' => [
		'created' => [
			'_' => '%s kullanıcısı oluşturuldu',
			'error' => '%s kullanıcısı oluşturulamadı',
		],
		'deleted' => [
			'_' => '%s kullanıcısı silindi',
			'error' => '%s kullanıcısı silinemedi',
		],
		'updated' => [
			'_' => '%s kullanıcısı güncellendi',
			'error' => '%s kullanıcısı güncellenmedi',
		],
	],
];
