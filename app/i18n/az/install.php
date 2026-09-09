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
	'action' => array(
		'finish' => 'Quraşdırmanı tamamla',
		'fix_errors_before' => 'Zəhmət olmasa, növbəti addıma keçməzdən əvvəl bütün xətaları düzəldin.',
		'keep_install' => 'Əvvəlki parametrləri saxla',
		'next_step' => 'Növbəti addıma keç',
		'reinstall' => 'FreshRSS-i yenidən quraşdır',
	),
	'bdd' => array(
		'_' => 'Verilənlər bazası',
		'conf' => array(
			'_' => 'Verilənlər bazası parametrləri',
			'ko' => 'Verilənlər bazası parametrlərinizi yoxlayın.',
			'ok' => 'Verilənlər bazası parametrləri yadda saxlanıldı.',
		),
		'host' => 'Host',	// IGNORE
		'password' => 'Verilənlər bazası parolu',
		'prefix' => 'Cədvəl prefiksi',
		'type' => 'Verilənlər bazasının növü',
		'username' => 'Verilənlər bazası istifadəçi adı',
	),
	'check' => array(
		'_' => 'Yoxlamalar',
		'already_installed' => 'FreshRSS-in artıq quraşdırıldığını aşkar etdik!',
		'cache' => array(
			'nok' => '<em>%2$s</em> istifadəçisi üçün <em>%1$s</em> qovluğunun icazələrini yoxlayın. HTTP serverinin yazma icazəsi olmalıdır.',
			'ok' => 'Keş qovluğunun icazələri qaydasındadır.',
		),
		'ctype' => array(
			'nok' => 'Simvol növünün yoxlanması üçün tələb olunan kitabxana tapılmadı (php-ctype).',
			'ok' => 'Simvol növünün yoxlanması üçün tələb olunan kitabxananız var (ctype).',
		),
		'curl' => array(
			'nok' => 'Tələb olunan cURL kitabxanası tapılmadı (php-curl paketi).',
			'ok' => 'Tələb olunan cURL kitabxananız var.',
		),
		'data' => array(
			'nok' => '<em>%2$s</em> istifadəçisi üçün <em>%1$s</em> qovluğunun icazələrini yoxlayın. HTTP serverinin yazma icazəsi olmalıdır.',
			'ok' => 'Verilənlər qovluğunun icazələri qaydasındadır.',
		),
		'database-connection' => array(
			'nok' => 'Verilənlər bazasına qoşulma xətası.',
			'ok' => 'Verilənlər bazasına qoşulma qaydasındadır.',
		),
		'database-table' => array(
			'nok' => 'Verilənlər bazasının "%s" cədvəli tam deyil.',
			'ok' => 'Verilənlər bazasının "%s" cədvəli qaydasındadır.',
		),
		'database-tables' => array(
			'nok' => 'Verilənlər bazasının bəzi cədvəlləri çatışmır.',
			'ok' => 'Verilənlər bazasının bütün cədvəlləri mövcuddur.',
		),
		'database-title' => 'Verilənlər bazası',
		'docroot' => array(
			'nok' => 'Veb serverinizin sənəd kökü <code>./p/</code> qovluğuna yönəlmiş görünmür. <code>./data/</code> kimi digər qovluqlar hamı üçün əlçatan ola bilər.',
			'ok' => 'Veb serverinizin sənəd kökü düzgün şəkildə <code>./p/</code> qovluğuna yönəlib.',
		),
		'dom' => array(
			'nok' => 'DOM-u nəzərdən keçirmək üçün tələb olunan kitabxana tapılmadı.',
			'ok' => 'DOM-u nəzərdən keçirmək üçün tələb olunan kitabxananız var.',
		),
		'favicons' => array(
			'nok' => '<em>%2$s</em> istifadəçisi üçün <em>%1$s</em> qovluğunun icazələrini yoxlayın. HTTP serverinin yazma icazəsi olmalıdır.',
			'ok' => 'Favicons qovluğunun icazələri qaydasındadır.',
		),
		'fileinfo' => array(
			'nok' => 'Tövsiyə olunan PHP fileinfo kitabxanası tapılmadı (fileinfo paketi).',
			'ok' => 'Tövsiyə olunan PHP fileinfo kitabxananız var (fileinfo paketi).',
		),
		'files' => 'Faylların quraşdırılması',
		'gmp' => array(
			'nok' => '32 bitlik PHP üçün tələb olunan GMP genişlənməsi tapılmadı (php-gmp paketi).',
			'ok' => '32 bitlik PHP üçün tələb olunan GMP genişlənməniz var.',
		),
		'intl' => array(
			'nok' => 'Beynəlmiləlləşdirmə üçün tövsiyə olunan php-intl kitabxanası tapılmadı.',
			'ok' => 'Beynəlmiləlləşdirmə üçün tövsiyə olunan php-intl kitabxananız var.',
		),
		'json' => array(
			'nok' => 'JSON-u təhlil etmək üçün tələb olunan kitabxana tapılmadı.',
			'ok' => 'JSON-u təhlil etmək üçün tələb olunan kitabxananız var.',
		),
		'mbstring' => array(
			'nok' => 'Unicode üçün tövsiyə olunan mbstring kitabxanası tapılmadı.',
			'ok' => 'Unicode üçün tövsiyə olunan mbstring kitabxananız var.',
		),
		'pcre' => array(
			'nok' => 'Müntəzəm ifadələr üçün tələb olunan kitabxana tapılmadı (php-pcre).',
			'ok' => 'Müntəzəm ifadələr üçün tələb olunan kitabxananız var (PCRE).',
		),
		'pdo-mysql' => array(
			'nok' => 'MySQL/MariaDB üçün tələb olunan PDO sürücüsü tapılmadı.',
		),
		'pdo-pgsql' => array(
			'nok' => 'PostgreSQL üçün tələb olunan PDO sürücüsü tapılmadı.',
		),
		'pdo-sqlite' => array(
			'nok' => 'SQLite üçün PDO sürücüsü tapılmadı.',
			'ok' => 'SQLite üçün PDO sürücünüz var.',
		),
		'pdo' => array(
			'nok' => 'PDO və ya dəstəklənən sürücülərdən biri tapılmadı (pdo_sqlite, pdo_pgsql, pdo_mysql).',
			'ok' => 'PDO və dəstəklənən sürücülərdən ən azı biri sizdə var (pdo_sqlite, pdo_pgsql, pdo_mysql).',
		),
		'php' => array(
			'_' => 'PHP quraşdırması',
			'nok' => 'PHP versiyanız %s, lakin FreshRSS ən azı %s versiyasını tələb edir.',
			'ok' => 'PHP versiyanız (%s) FreshRSS ilə uyğundur.',
		),
		'reload' => 'Yenidən yoxla',
		'tmp' => array(
			'nok' => '<em>%2$s</em> istifadəçisi üçün <em>%1$s</em> qovluğunun icazələrini yoxlayın. HTTP serverinin yazma icazələri olmalıdır.',
			'ok' => 'Müvəqqəti qovluğun icazələri qaydasındadır.',
		),
		'tokens' => array(
			'nok' => '<em>./data/tokens</em> qovluğunun icazələrini yoxlayın. HTTP serverinin yazma icazəsi olmalıdır',
			'ok' => 'Tokenlər qovluğunun icazələri qaydasındadır.',
		),
		'unknown_process_username' => 'naməlum',
		'users' => array(
			'nok' => '<em>%2$s</em> istifadəçisi üçün <em>%1$s</em> qovluğunun icazələrini yoxlayın. HTTP serverinin yazma icazələri olmalıdır.',
			'ok' => 'İstifadəçilər qovluğunun icazələri qaydasındadır.',
		),
		'xml' => array(
			'nok' => 'XML-i təhlil etmək üçün tələb olunan kitabxana tapılmadı.',
			'ok' => 'XML-i təhlil etmək üçün tələb olunan kitabxananız var.',
		),
		'zip' => array(
			'nok' => 'ZIP üçün tövsiyə olunan genişlənmə tapılmadı (php-zip paketi).',
			'ok' => 'ZIP üçün tövsiyə olunan genişlənməniz var (php-zip paketi).',
		),
	),
	'conf' => array(
		'_' => 'Ümumi parametrlər',
		'ok' => 'Ümumi parametrlər yadda saxlanıldı.',
	),
	'congratulations' => 'Təbriklər!',
	'default_user' => array(
		'_' => 'Standart istifadəçinin istifadəçi adı',
		'max_char' => '1-39 simvol: hərflər, rəqəmlər və <code>. _ @ -</code>',
	),
	'fix_errors_before' => 'Zəhmət olmasa, növbəti addıma keçməzdən əvvəl xətaları düzəldin.',
	'javascript_is_better' => 'JavaScript aktiv olduqda FreshRSS daha xoşdur',
	'js' => array(
		'confirm_reinstall' => 'FreshRSS-i yenidən quraşdırmaqla əvvəlki parametrlərinizi itirəcəksiniz. Davam etmək istədiyinizə əminsiniz?',
	),
	'language' => array(
		'_' => 'Dil',
		'choose' => 'FreshRSS üçün dil seçin',
		'defined' => 'Dil təyin edildi.',
	),
	'missing_applied_migrations' => 'Nəsə səhv getdi; <em>%s</em> boş faylını əl ilə yaratmalısınız.',
	'ok' => 'Quraşdırma prosesi uğurlu oldu.',
	'session' => array(
		'nok' => 'Deyəsən, veb server PHP sessiyalarına lazım olan kukilər üçün yanlış konfiqurasiya edilib!',
	),
	'step' => 'addım %d',
	'steps' => 'Addımlar',
	'this_is_the_end' => 'Bu, sondur',
	'title' => 'Quraşdırma · FreshRSS',
);
