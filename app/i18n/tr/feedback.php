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
			'failed' => 'Your password cannot be modified',	// TODO - Translation
			'updated' => 'Your password has been modified',	// TODO - Translation
		),
	),
	'auth' => array(
		'form' => array(
			'not_set' => 'Sistem yapılandırma kimlik doğrulaması sırasında hata oldu. Lütfen daha sonra tekrar deneyin.',
			'set' => 'Kimlik doğrulama sistemi tamamnaldı.',
		),
		'login' => array(
			'invalid' => 'Giriş geçersiz',
			'success' => 'Bağlantı kuruldu',
		),
		'logout' => array(
			'success' => 'Bağlantı koptu',
		),
		'no_password_set' => 'Yönetici şifresi ayarlanmadı. Bu özellik kullanıma uygun değil.',
	),
	'conf' => array(
		'error' => 'Yapılandırma ayarları kaydedilirken hata oluştu',
		'query_created' => 'Sorgu "%s" oluşturuldu.',
		'shortcuts_updated' => 'Kısayollar yenilendi',
		'updated' => 'Yapılandırm ayarları yenilendi',
	),
	'extensions' => array(
		'already_enabled' => '%s zaten aktif',
		'cannot_remove' => '%s cannot be removed',	// TODO - Translation
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
		'removed' => '%s removed',	// TODO - Translation
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
			'marked_read' => 'The selected articles have been marked as read.',	// TODO - Translation
			'marked_unread' => 'The articles have been marked as unread.',	// TODO - Translation
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
			'cache_cleared' => '<em>%s</em> cache has been cleared',	// TODO - Translation
			'deleted' => 'Akış silindi',
			'error' => 'Akış güncellenemiyor',
			'internal_problem' => 'RSS akışı eklenemiyor. Detaylar için <a href="%s">FreshRSS log kayıtlarını</a> kontrol edin.',
			'invalid_url' => 'URL <em>%s</em> geçersiz',
			'n_actualized' => '%d akışları güncellendi',
			'n_entries_deleted' => '%d makaleleri silindi',
			'no_refresh' => 'Yenilenecek akış yok…',
			'not_added' => '<em>%s</em> eklenemedi',
			'not_found' => 'Feed cannot be found',	// TODO - Translation
			'over_max' => 'Akış limitini aştınız (%d)',
			'reloaded' => '<em>%s</em> has been reloaded',	// TODO - Translation
			'selector_preview' => array(
				'http_error' => 'Failed to load website content.',	// TODO - Translation
				'no_entries' => 'There are no articles in this feed. You need at least one article to create a preview.',	// TODO - Translation
				'no_feed' => 'Internal error (feed cannot be found).',	// TODO - Translation
				'no_result' => 'The selector didn\'t match anything. As a fallback the original feed text will be displayed instead.',	// TODO - Translation
				'selector_empty' => 'The selector is empty. You need to define one to create a preview.',	// TODO - Translation
			),
			'updated' => 'Akış güncellendi',
		),
		'purge_completed' => 'Temizleme tamamlandı (%d makale silindi)',
	),
	'tag' => array(
		'created' => 'Tag "%s" has been created.',	// TODO - Translation
		'name_exists' => 'Tag name already exists.',	// TODO - Translation
		'renamed' => 'Tag "%s" has been renamed to "%s".',	// TODO - Translation
	),
	'update' => array(
		'can_apply' => 'FreshRSS <strong>%s versiyonuna</strong> güncellenecek.',
		'error' => 'Güncelleme işlemi sırasında hata: %s',
		'file_is_nok' => '<strong>%s versiyonuna</strong>. <em>%s</em> klasör yetkisini kontrol edin. HTTP yazma yetkisi olmalı',
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
			'_' => 'User %s has been updated',	// TODO - Translation
			'error' => 'User %s has not been updated',	// TODO - Translation
		),
	),
);
