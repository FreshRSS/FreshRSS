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
	'auth' => array(
		'allow_anonymous' => 'Izinkan pembacaan anonim artikel pengguna default (%s)',
		'allow_anonymous_refresh' => 'Izinkan refresh artikel anonim',
		'api_enabled' => 'Izinkan <abbr>API</abbr> akses <small>(Diperlukan untuk aplikasi seluler)</small>',	// DIRTY
		'form' => 'Web form (traditional, membutuhkan JavaScript)',
		'http' => 'HTTP (untuk pengguna tingkat lanjut HTTPS)',
		'none' => 'None (dangerous)',	// TODO
		'title' => 'Authentication',	// TODO
		'token' => 'Master authentication token',	// TODO
		'token_help' => 'Allows access to all RSS outputs of the user as well as refreshing feeds without authentication:',	// TODO
		'type' => 'Authentication method',	// TODO
		'unsafe_autologin' => 'Izinkan login otomatis yang tidak aman menggunakan format: ',
	),
	'check_install' => array(
		'cache' => array(
			'nok' => 'Periksa izin <em>./data/cache</em> direktori. HTTP server harus memiliki izin menulis.',
			'ok' => 'Izin pada direktori cache bagus.',	// DIRTY
		),
		'categories' => array(
			'nok' => 'Tabel kategori dikonfigurasi secara tidak tepat.',
			'ok' => 'Tabel kategori baik-baik saja.',
		),
		'connection' => array(
			'nok' => 'Koneksi ke database tidak dapat dibuat.',
			'ok' => 'Koneksi ke database berhasil.',
		),
		'ctype' => array(
			'nok' => 'Tidak dapat menemukan library yang diperlukan untuk pemeriksaan jenis karakter (php-ctype).',
			'ok' => 'Anda memiliki library yang dibutuhkan untuk pemeriksaan jenis karakter (ctype).',
		),
		'curl' => array(
			'nok' => 'Tidak dapat menemukan cURL library (php-curl package).',
			'ok' => 'Kamu punya cURL library.',
		),
		'data' => array(
			'nok' => 'Periksa izin <em>./data</em> direktori. HTTP server harus memiliki izin tulis.',
			'ok' => 'Izin pada direktori data bagus.',
		),
		'database' => 'Database installation',	// TODO
		'dom' => array(
			'nok' => 'Tidak dapat menemukan library yang diperlukan untuk menelusuri DOM (php-xml package).',
			'ok' => 'Anda memiliki library yang diperlukan untuk menelusuri DOM.',
		),
		'entries' => array(
			'nok' => 'Tabel entri dikonfigurasi secara tidak benar.',
			'ok' => 'Tabel entri baik-baik saja.',
		),
		'favicons' => array(
			'nok' => 'Periksa izin on <em>./data/favicons</em> direktori. HTTP server harus memiliki izin tulis.',
			'ok' => 'Izin di Direktori Favicons bagus.',
		),
		'feeds' => array(
			'nok' => 'Tabel feed dikonfigurasi secara tidak benar.',
			'ok' => 'Feed table is okay.',	// TODO
		),
		'fileinfo' => array(
			'nok' => 'Tidak dapat menemukan PHP fileinfo library (fileinfo package).',
			'ok' => 'You have the fileinfo library.',	// TODO
		),
		'files' => 'File installation',	// TODO
		'json' => array(
			'nok' => 'Tidak dapat menemukan JSON (php-json package).',
			'ok' => 'You have the JSON extension.',	// TODO
		),
		'mbstring' => array(
			'nok' => 'Tidak dapat menemukan mbstring library untuk Unicode.',
			'ok' => 'Anda memiliki mbstring library untuk Unicode.',
		),
		'pcre' => array(
			'nok' => 'Tidak dapat menemukan library untuk regular expressions (php-pcre).',
			'ok' => 'Anda memiliki library untuk regular expressions (PCRE).',
		),
		'pdo' => array(
			'nok' => 'Tidak dapat menemukan PDO salah satu drivers yang didukung (pdo_mysql, pdo_sqlite, pdo_pgsql).',
			'ok' => 'Anda memiliki PDO dan setidaknya salah satu drivers yang didukung (pdo_mysql, pdo_sqlite, pdo_pgsql).',
		),
		'php' => array(
			'_' => 'PHP installation',	// TODO
			'nok' => 'Your PHP version is %s but FreshRSS requires at least version %s.',	// TODO
			'ok' => 'Your PHP version (%s) is compatible with FreshRSS.',	// TODO
		),
		'tables' => array(
			'nok' => 'Ada satu atau lebih tabel yang hilang dalam database.',
			'ok' => 'Tabel yang sesuai ada dalam database.',
		),
		'title' => 'Installation check',	// TODO
		'tokens' => array(
			'nok' => 'Periksa izin pada <em>./data/tokens</em> direktori. HTTP server harus memiliki izin menulis',
			'ok' => 'Izin pada direktori token bagus.',
		),
		'users' => array(
			'nok' => 'Periksa izin <em>./data/users</em> direktori. HTTP server harus memiliki izin menulis',
			'ok' => 'Izin pada direktori pengguna bagus.',
		),
		'zip' => array(
			'nok' => 'Tidak dapat menemukan ekstensi zip (php-zip package).',
			'ok' => 'Anda memiliki ekstensi zip.',
		),
	),
	'extensions' => array(
		'author' => 'Pengarang',
		'community' => 'Ekstensi komunitas yang tersedia',
		'description' => 'Keterangan',
		'disabled' => 'Disabled',	// TODO
		'empty_list' => 'Tidak ada ekstensi terpasang',
		'enabled' => 'Enabled',	// TODO
		'latest' => 'Installed',	// TODO
		'name' => 'Name',	// TODO
		'no_configure_view' => 'Ekstensi ini tidak dapat dikonfigurasi.',
		'system' => array(
			'_' => 'System extensions',	// TODO
			'no_rights' => 'System extension (Anda tidak memiliki izin yang diperlukan)',
		),
		'title' => 'Extensions',	// TODO
		'update' => 'Pembaruan tersedia',
		'user' => 'User extensions',	// TODO
		'version' => 'Version',	// TODO
	),
	'stats' => array(
		'_' => 'Statistik',
		'all_feeds' => 'Semua feed',
		'category' => 'Kategori',
		'entry_count' => 'Entri masuk',
		'entry_per_category' => 'Entri per kategori',
		'entry_per_day' => 'Entri per hari (30 hari terakhir)',
		'entry_per_day_of_week' => 'Per hari dalam seminggu (rata-rata: %.2f pesan)',
		'entry_per_hour' => 'Per jam (rata-rata %.2f pesan)',
		'entry_per_month' => 'Per bulan (rata -rata: %.2f pesan)',
		'entry_repartition' => 'Mengembalikan entri',
		'feed' => 'Feed',	// TODO
		'feed_per_category' => 'Feed per kategori',
		'idle' => 'Feed idle',
		'main' => 'Statistik utama',
		'main_stream' => 'Aliran utama',
		'no_idle' => 'Tidak ada idle feed!',
		'number_entries' => '%d artikel',
		'percent_of_total' => '% dari total',
		'repartition' => 'Mengembalikan artikel',
		'status_favorites' => 'Favorites',
		'status_read' => 'Read',	// TODO
		'status_total' => 'Total',	// TODO
		'status_unread' => 'Unread',	// TODO
		'title' => 'Statistik',
		'top_feed' => 'Sepuluh feed teratas',
	),
	'system' => array(
		'_' => 'Sistem konfigurasi',
		'auto-update-url' => 'Auto-update server URL',	// TODO
		'base-url' => array(
			'_' => 'Base URL',	// TODO
			'recommendation' => 'Automatic recommendation: <kbd>%s</kbd>',	// TODO
		),
		'cookie-duration' => array(
			'help' => 'dalam hitungan detik',
			'number' => 'Durasi untuk terus masuk',
		),
		'force_email_validation' => 'Validasi alamat email paksa',
		'instance-name' => 'Nama instansi',
		'max-categories' => 'Jumlah kategori maksimal per pengguna',
		'max-feeds' => 'Maksimal Jumlah Feed Per Pengguna',
		'registration' => array(
			'number' => 'Jumlah Akun Maks',
			'select' => array(
				'label' => 'Formulir pendaftaran',
				'option' => array(
					'noform' => 'Disabled: Tidak ada formulir pendaftaran',
					'nolimit' => 'Enabled: Tidak ada batasan akun',
					'setaccountsnumber' => 'Setel Max. jumlah akun',
				),
			),
			'status' => array(
				'disabled' => 'Form disabled',	// TODO
				'enabled' => 'Form enabled',	// TODO
			),
			'title' => 'Formulir Pendaftaran Pengguna',
		),
		'sensitive-parameter' => 'Sensitive parameter. Edit manually in <kbd>./data/config.php</kbd>',	// TODO
		'tos' => array(
			'disabled' => 'is not given',	// TODO
			'enabled' => '<a href="./?a=tos">is enabled</a>',	// TODO
			'help' => 'How to <a href="https://freshrss.github.io/FreshRSS/en/admins/12_User_management.html#enable-terms-of-service-tos" target="_blank">enable the Terms of Service</a>',	// TODO
		),
		'websub' => array(
			'help' => 'About <a href="https://freshrss.github.io/FreshRSS/en/users/WebSub.html" target="_blank">WebSub</a>',	// TODO
		),
	),
	'update' => array(
		'_' => 'Update system',	// DIRTY
		'apply' => 'Apply',	// DIRTY
		'changelog' => 'Changelog',	// TODO
		'check' => 'Periksa pembaruan baru',
		'copiedFromURL' => 'update.php copied from %s to ./data',	// TODO
		'current_version' => 'Versi saat ini adalah',
		'last' => 'Verifikasi terakhir',
		'loading' => 'Updating…',	// TODO
		'none' => 'Tidak ada pembaruan untuk diterapkan',
		'releaseChannel' => array(
			'_' => 'Release channel',	// TODO
			'edge' => 'Rolling release (“edge”)',	// TODO
			'latest' => 'Stable release (“latest”)',	// TODO
		),
		'title' => 'Perbarui Sistem',
		'viaGit' => 'Update via git and Github.com started',	// TODO
	),
	'user' => array(
		'admin' => 'Administrator',	// TODO
		'article_count' => 'Artikel',
		'back_to_manage' => '← Kembali ke Daftar Pengguna',
		'create' => 'Buat pengguna baru',
		'database_size' => 'Ukuran database',
		'email' => 'Alamat email',
		'enabled' => 'Enabled',	// TODO
		'feed_count' => 'Feeds',	// TODO
		'is_admin' => 'Is admin',	// TODO
		'language' => 'Bahasa',
		'last_user_activity' => 'Aktivitas pengguna terakhir',
		'list' => 'Daftar pengguna',
		'number' => 'Ada %d akun telah dibuat',
		'numbers' => 'Ada %d akun dibuat',
		'password_form' => 'Password<br /><small>(Untuk metode login bentuk web)</small>',
		'password_format' => 'Setidaknya 7 karakter',
		'title' => 'Kelola pengguna',
		'username' => 'Username',	// TODO
	),
);
