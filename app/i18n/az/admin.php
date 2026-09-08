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
	'auth' => array(
		'allow_anonymous' => 'Standart istifadəçinin məqalələrinin anonim oxunmasına icazə ver (%s)',
		'allow_anonymous_refresh' => 'Məqalələrin anonim yenilənməsinə icazə ver',
		'api_enabled' => '<abbr>API</abbr> girişinə icazə ver <small>(mobil tətbiqlər və istifadəçi sorğularının paylaşılması üçün tələb olunur)</small>',
		'form' => 'Veb forma (ənənəvi, JavaScript tələb edir)',
		'http' => 'HTTP (qabaqcıl: veb server, OIDC, SSO… tərəfindən idarə olunur)',
		'none' => 'Yoxdur (təhlükəlidir)',
		'title' => 'Kimlik doğrulama',
		'token' => 'Əsas kimlik doğrulama tokeni',
		'token_help' => 'İstifadəçinin bütün RSS çıxışlarına girişə və lentlərin kimlik doğrulaması olmadan yenilənməsinə imkan verir:',
		'type' => 'Kimlik doğrulama üsulu',
	),
	'extensions' => array(
		'author' => 'Müəllif',
		'community' => 'Mövcud icma genişlənmələri',
		'description' => 'Təsvir',
		'disabled' => 'Deaktiv',
		'empty_list' => 'Quraşdırılmış genişlənmə yoxdur',
		'empty_list_help' => 'Genişlənmə siyahısının boş olmasının səbəbini müəyyən etmək üçün jurnalları yoxlayın.',
		'enabled' => 'Aktivdir',
		'is_compatible' => 'Uyğundur',
		'latest' => 'Quraşdırılıb',
		'name' => 'Ad',
		'no_configure_view' => 'Bu genişlənmə konfiqurasiya edilə bilməz.',
		'system' => array(
			'_' => 'Sistem genişlənmələri',
			'no_rights' => 'Sistem genişlənməsi (tələb olunan icazələriniz yoxdur)',
		),
		'title' => 'Genişlənmələr',
		'update' => 'Yeniləmə mövcuddur',
		'user' => 'İstifadəçi genişlənmələri',
		'version' => 'Versiya',
	),
	'stats' => array(
		'_' => 'Statistika',
		'all_feeds' => 'Bütün lentlər',
		'category' => 'Kateqoriya',
		'date_published' => 'Dərc tarixi',
		'date_received' => 'Alınma tarixi',
		'entry_count' => 'Yazı sayı',
		'entry_per_category' => 'Kateqoriya üzrə yazılar',
		'entry_per_day' => 'Gün üzrə yazılar (son 30 gün)',
		'entry_per_day_of_week' => 'Həftənin günü üzrə (orta: %.2f mesaj)',
		'entry_per_hour' => 'Saat üzrə (orta: %.2f mesaj)',
		'entry_per_month' => 'Ay üzrə (orta: %.2f mesaj)',
		'entry_repartition' => 'Yazıların paylanması',
		'feed' => 'Lent',
		'feed_per_category' => 'Kateqoriya üzrə lentlər',
		'idle' => 'Fəaliyyətsiz lentlər',
		'main' => 'Əsas statistika',
		'main_stream' => 'Əsas axın',
		'nb_unreads' => 'Oxunmamış məqalələrin sayı',
		'no_idle' => 'Fəaliyyətsiz lent yoxdur!',
		'number_entries' => '%d məqalə',
		'overview' => 'Ümumi baxış',
		'percent_of_total' => '% ümumidən',
		'repartition' => 'Məqalələrin paylanması: %s',
		'status_favorites' => 'Seçilmişlər',
		'status_read' => 'Oxunmuş',
		'status_total' => 'Ümumi',
		'status_unread' => 'Oxunmamış',
		'title' => 'Statistika',
		'top_feed' => 'İlk on lent',
		'unread_dates' => 'Ən çox oxunmamış məqaləsi olan tarixlər',
	),
	'system' => array(
		'_' => 'Sistem parametrləri',
		'auto-update-url' => 'Avtomatik yeniləmə serverinin URL-i',
		'base-url' => array(
			'_' => 'Əsas URL',
			'recommendation' => 'Avtomatik tövsiyə: <kbd>%s</kbd>',
		),
		'closed_registration_message' => 'Qeydiyyat bağlı olduqda mesaj',
		'cookie-duration' => array(
			'help' => 'saniyə ilə',
			'number' => 'Girişdə qalma müddəti',
		),
		'default_closed_registration_message' => 'Bu server hazırda yeni qeydiyyat qəbul etmir.',
		'force_email_validation' => 'E-poçt ünvanının doğrulanmasını məcburi et',
		'instance-name' => 'İnstans adı',
		'internal-host-allowlist' => array(
			'_' => 'Daxili host icazə siyahısı',
			'help' => 'Hər sətirdə bir qeyd:<ul><li>Bir <code>host:port</code>. Məsələn <code>127.0.0.1:8080</code> və ya <code>rss-bridge:80</code></li><li>CIDR qeydi. Məsələn istənilən IPv4-ə icazə vermək üçün <code>0.0.0.0/0</code>, istənilən IPv6-ya icazə vermək üçün <code>::/0</code></li><li>İstənilən hosta icazə vermək üçün <code>*</code> (təhlükəsiz deyil)</li></ul>',
		),
		'max-categories' => 'İstifadəçi başına maksimum kateqoriya sayı',
		'max-feeds' => 'İstifadəçi başına maksimum lent sayı',
		'override-by-env-var' => 'Bu parametr <kbd>%s</kbd> mühit dəyişəni ilə təyin olunur.',
		'registration' => array(
			'number' => 'Maksimum hesab sayı',
			'select' => array(
				'label' => 'Qeydiyyat forması',
				'option' => array(
					'noform' => 'Deaktiv: Qeydiyyat forması yoxdur',
					'nolimit' => 'Aktivdir: Hesab limiti yoxdur',
					'setaccountsnumber' => 'Maksimum hesab sayını təyin et',
				),
			),
			'status' => array(
				'disabled' => 'Forma deaktivdir',
				'enabled' => 'Forma aktivdir',
			),
			'title' => 'İstifadəçi qeydiyyat forması',
		),
		'sensitive-parameter' => 'Həssas parametr. <kbd>./data/config.php</kbd> faylında əl ilə redaktə edin',
		'tos' => array(
			'disabled' => 'verilməyib',
			'enabled' => '<a href="./?a=tos">aktivdir</a>',
			'help' => '<a href="https://freshrss.github.io/FreshRSS/en/admins/12_User_management.html#enable-terms-of-service-tos" target="_blank">İstifadə şərtlərini necə aktivləşdirməli</a>',
		),
		'websub' => array(
			'help' => '<a href="https://freshrss.github.io/FreshRSS/en/users/WebSub.html" target="_blank">WebSub</a> haqqında',
		),
	),
	'update' => array(
		'_' => 'FreshRSS-i yenilə',
		'apply' => 'Yeniləməni başlat',
		'changelog' => 'Dəyişikliklər jurnalı',
		'check' => 'Yeni yeniləmələri yoxla',
		'copiedFromURL' => 'update.php %s ünvanından ./data qovluğuna kopyalandı',
		'current_version' => 'Hazırda quraşdırılmış versiya',
		'last' => 'Son yoxlama',
		'loading' => 'Yenilənir…',
		'none' => 'Yeniləmə yoxdur',
		'releaseChannel' => array(
			'_' => 'Buraxılış kanalı',
			'edge' => 'Davamlı buraxılış (“edge”)',
			'latest' => 'Stabil buraxılış (“latest”)',	// DIRTY
		),
		'title' => 'FreshRSS-i yenilə',
		'viaGit' => 'git və GitHub.com vasitəsilə yeniləmə başladı',
	),
	'user' => array(
		'admin' => 'Administrator',	// IGNORE
		'article_count' => 'Məqalələr',
		'back_to_manage' => '← İstifadəçi siyahısına qayıt',
		'create' => 'Yeni istifadəçi yarat',
		'database_size' => 'Verilənlər bazasının ölçüsü',
		'email' => 'E-poçt ünvanı',
		'enabled' => 'Aktivdir',
		'feed_count' => 'Lentlər',
		'is_admin' => 'Administratordur',
		'language' => 'Dil',
		'last_user_activity' => 'Son istifadəçi fəaliyyəti',
		'list' => 'İstifadəçi siyahısı',
		'number' => '%d hesab yaradılıb',
		'numbers' => '%d hesab yaradılıb',
		'password_form' => 'Parol<br /><small>(veb forma ilə giriş üsulu üçün)</small>',
		'password_format' => 'Ən azı 7 simvol',
		'title' => 'İstifadəçiləri idarə et',
		'username' => 'İstifadəçi adı',
	),
);
