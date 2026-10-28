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
	'access' => array(
		'denied' => 'Bu səhifəyə giriş icazəniz yoxdur',
		'not_found' => 'Mövcud olmayan səhifə axtarırsınız',
	),
	'admin' => array(
		'optimization_complete' => 'Optimallaşdırma tamamlandı',
	),
	'api' => array(
		'password' => array(
			'failed' => 'Parolunuz dəyişdirilə bilmədi',
			'updated' => 'Parolunuz dəyişdirildi',
		),
	),
	'auth' => array(
		'login' => array(
			'invalid' => 'Giriş yanlışdır',
			'success' => 'Daxil oldunuz',
		),
		'logout' => array(
			'success' => 'Çıxış etdiniz',
		),
	),
	'conf' => array(
		'error' => 'Parametrlər yadda saxlanarkən xəta baş verdi',
		'query_created' => '“%s” sorğusu yaradıldı.',
		'shortcuts_updated' => 'Qısayollar yeniləndi',
		'updated' => 'Parametrlər yeniləndi',
	),
	'extensions' => array(
		'already_enabled' => '%s artıq aktivdir',
		'cannot_remove' => '%s çıxarıla bilmədi',
		'disable' => array(
			'ko' => '%s deaktiv edilə bilmədi. Təfərrüatlar üçün <a href="%s">FreshRSS jurnallarını yoxlayın</a>.',
			'ok' => '%s indi deaktivdir',
		),
		'enable' => array(
			'ko' => '%s aktivləşdirilə bilmədi. Təfərrüatlar üçün <a href="%s">FreshRSS jurnallarını yoxlayın</a>.',
			'ok' => '%s indi aktivdir',
		),
		'invalid_view_mode' => 'Yanlış görünüş rejimi “%s”! “Normal görünüş”ə qayıdılır.',
		'no_access' => '%s üzərində girişiniz yoxdur',
		'not_enabled' => '%s aktiv deyil',
		'not_found' => '%s mövcud deyil',
		'removed' => '%s çıxarıldı',
	),
	'import_export' => array(
		'export_no_zip_extension' => 'ZIP genişlənməsi serverinizdə mövcud deyil. Zəhmət olmasa faylları bir-bir ixrac etməyə çalışın.',
		'feeds_imported' => 'Lentləriniz idxal edildi. İdxalı bitirmisinizsə, indi <i>Lentləri yenilə</i> düyməsini basa bilərsiniz.',
		'feeds_imported_with_errors' => 'Lentləriniz idxal edildi, lakin bəzi xətalar baş verdi. İdxalı bitirmisinizsə, indi <i>Lentləri yenilə</i> düyməsini basa bilərsiniz.',
		'file_cannot_be_uploaded' => 'Fayl yüklənə bilmədi!',
		'no_zip_extension' => 'ZIP genişlənməsi serverinizdə mövcud deyil.',
		'zip_error' => 'ZIP emalı zamanı xəta baş verdi.',
	),
	'profile' => array(
		'error' => 'Profiliniz dəyişdirilə bilmədi',
		'passwords_dont_match' => 'Parollar uyğun gəlmir',
		'updated' => 'Profiliniz dəyişdirildi',
	),
	'sub' => array(
		'actualize' => 'Yenilənir',
		'articles' => array(
			'marked_read' => 'Seçilən məqalələr oxunmuş kimi işarələndi.',
			'marked_unread' => 'Məqalələr oxunmamış kimi işarələndi.',
		),
		'category' => array(
			'created' => '%s kateqoriyası yaradıldı.',
			'deleted' => 'Kateqoriya silindi.',
			'emptied' => 'Kateqoriya boşaldıldı',
			'error' => 'Kateqoriya yenilənə bilmədi',
			'name_exists' => 'Kateqoriya adı artıq mövcuddur.',
			'no_id' => 'Kateqoriyanın ID-sini göstərməlisiniz.',
			'no_name' => 'Kateqoriya adı boş ola bilməz.',
			'not_delete_default' => 'Standart kateqoriyanı silə bilməzsiniz!',
			'not_exist' => 'Kateqoriya mövcud deyil!',
			'over_max' => 'Kateqoriya limitinizə çatdınız (%d)',
			'updated' => 'Kateqoriya yeniləndi.',
		),
		'feed' => array(
			'actualized' => '<em>%s</em> yeniləndi',
			'actualizeds' => 'RSS lentləri yeniləndi',
			'added' => '<em>%s</em> RSS lenti əlavə edildi',
			'already_subscribed' => 'Artıq <em>%s</em> lentinə abunə olmusunuz',
			'cache_cleared' => '<em>%s</em> keşi təmizləndi',
			'deleted' => 'Lent silindi',
			'error' => 'Lent yenilənə bilmədi',
			'favicon' => array(
				'too_large' => 'Yüklənən ikon çox böyükdür. Maksimum fayl ölçüsü <em>%s</em>.',
				'unsupported_format' => 'Dəstəklənməyən şəkil fayl formatı!',
			),
			'internal_problem' => 'Xəbər lenti əlavə edilə bilmədi. Təfərrüatlar üçün <a href="%s">FreshRSS jurnallarını yoxlayın</a>. URL-in sonuna <code>#force_feed</code> əlavə edərək məcburi əlavə etməyə cəhd edə bilərsiniz.',
			'invalid_url' => '<em>%s</em> URL-i yanlışdır',
			'n_actualized' => '%d lent yeniləndi',
			'n_entries_deleted' => '%d məqalə silindi',
			'no_refresh' => 'Yeniləmək üçün lent yoxdur',
			'not_added' => '<em>%s</em> əlavə edilə bilmədi',
			'not_found' => 'Lent tapıla bilmədi',
			'over_max' => 'Lent limitinizə çatdınız (%d)',
			'reloaded' => '<em>%s</em> yenidən yükləndi',
			'selector_preview' => array(
				'http_error' => 'Veb sayt məzmunu yüklənə bilmədi.',
				'no_entries' => 'Bu lentdə məqalə yoxdur. Önbaxış yaratmaq üçün ən azı bir məqalə lazımdır.',
				'no_feed' => 'Daxili xəta (lent tapıla bilmədi).',
				'no_result' => 'Seçici heç nə ilə uyğun gəlmədi. Əvəzində ehtiyat variant kimi lentin orijinal mətni göstəriləcək.',
				'selector_empty' => 'Seçici boşdur. Önbaxış yaratmaq üçün onu təyin etməlisiniz.',
			),
			'updated' => 'Lent yeniləndi',
		),
		'purge_completed' => 'Təmizləmə tamamlandı (%d məqalə silindi)',
	),
	'tag' => array(
		'created' => '“%s” etiketi yaradıldı.',
		'error' => 'Etiket yenilənə bilmədi!',
		'name_exists' => 'Etiket adı artıq mövcuddur.',
		'renamed' => '“%s” etiketinin adı “%s” olaraq dəyişdirildi.',
		'updated' => 'Etiket yeniləndi.',
	),
	'update' => array(
		'can_apply' => 'FreshRSS-in yenilənməsi mövcuddur: <strong>Versiya %s</strong>.',
		'error' => 'Yeniləmə prosesi xəta ilə qarşılaşdı: %s',
		'file_is_nok' => 'FreshRSS-in yenilənməsi mövcuddur (<strong>Versiya %s</strong>), lakin <em>%s</em> qovluğundakı icazələri yoxlayın. HTTP serverinin yazma icazəsi olmalıdır',
		'finished' => 'Yeniləmə tamamlandı!',
		'none' => 'Yeniləmə mövcud deyil',
		'server_not_found' => 'Yeniləmə serveri tapıla bilmədi. [%s]',
	),
	'user' => array(
		'created' => array(
			'_' => '%s istifadəçisi yaradıldı',
			'error' => '%s istifadəçisi yaradıla bilmədi',
		),
		'deleted' => array(
			'_' => '%s istifadəçisi silindi',
			'error' => '%s istifadəçisi silinə bilmədi',
		),
		'updated' => array(
			'_' => '%s istifadəçisi yeniləndi',
			'error' => '%s istifadəçisi yenilənmədi',
		),
	),
);
