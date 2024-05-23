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
		'none' => 'None (berbahaya)',
		'title' => 'Autentikasi',
		'token' => 'Token autentikasi master',
		'token_help' => 'Mengizinkan akses ke semua keluaran output RSS pengguna serta menyegarkan feed tanpa autentikasi:',
		'type' => 'Metode autentikasi',
		'unsafe_autologin' => 'Izinkan login otomatis yang tidak aman menggunakan format: ',
	),
	'check_install' => array(
		'cache' => array(
			'nok' => 'Periksa izin <em>./data/cache</em> direktori. HTTP server harus memiliki izin menulis.',
			'ok' => 'Izin direktori cache bagus',
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
		'database' => 'Instalasi Database',
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
			'ok' => 'Table feed bagus.',
		),
		'fileinfo' => array(
			'nok' => 'Tidak dapat menemukan PHP fileinfo library (fileinfo package).',
			'ok' => 'Kamu memiliki library fileinfo.',
		),
		'files' => 'Instalasi File',
		'json' => array(
			'nok' => 'Tidak dapat menemukan JSON (php-json package).',
			'ok' => 'Anda memiliki ekstensi JSON.',
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
			'_' => 'instalasi PHP.',
			'nok' => 'Versi php anda adalah %s tapi FreshRSS membutuhkan setidaknya versi %s.',
			'ok' => 'Versi php anda (%s) kompatibel dengan FreshRSS.',
		),
		'tables' => array(
			'nok' => 'Ada satu atau lebih tabel yang hilang dalam database.',
			'ok' => 'Tabel yang sesuai ada dalam database.',
		),
		'title' => 'Pengecekan Instalasi.',
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
		'disabled' => 'Dinonaktifkan',
		'empty_list' => 'Tidak ada ekstensi terpasang',
		'enabled' => 'Diaktifkan',
		'latest' => 'Terinstal',
		'name' => 'Nama',
		'no_configure_view' => 'Ekstensi ini tidak dapat dikonfigurasi.',
		'system' => array(
			'_' => 'Ekstensi sistem',
			'no_rights' => 'System extension (Anda tidak memiliki izin yang diperlukan)',
		),
		'title' => 'Ekstensi',
		'update' => 'Pembaruan tersedia',
		'user' => 'Ekstensi User',
		'version' => 'Versi',
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
		'status_read' => 'Terbaca',
		'status_total' => 'Total',	// TODO
		'status_unread' => 'Belum Terbaca',
		'title' => 'Statistik',
		'top_feed' => 'Sepuluh feed teratas',
	),
	'system' => array(
		'_' => 'Sistem konfigurasi',
		'auto-update-url' => 'Otomatis perbarui URL Server',
		'base-url' => array(
			'_' => 'Base URL',	// TODO
			'recommendation' => 'Rekomendasi Otomatis: <kbd>%s</kbd>',
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
				'disabled' => 'Form dinonaktifkan',
				'enabled' => 'Form diaktifkan',
			),
			'title' => 'Formulir Pendaftaran Pengguna',
		),
		'sensitive-parameter' => 'Parameter sensitif. Edit manual di <kbd>./data/config.php</kbd>',
		'tos' => array(
			'disabled' => 'Tidak diberikan',
			'enabled' => '<a href="./?a=tos">diaktifkan</a>',
			'help' => 'Cara <a href="https://freshrss.github.io/FreshRSS/en/admins/12_User_management.html#enable-terms-of-service-tos" target="_blank">mengaktifkan Ketentuan Layanan.</a>',
		),
		'websub' => array(
			'help' => 'Tentang <a href="https://freshrss.github.io/FreshRSS/en/users/WebSub.html" target="_blank">WebSub</a>',
		),
	),
	'update' => array(
		'_' => 'Perbarui sistem',
		'apply' => 'Terapkan',
		'changelog' => 'Log Perubahan',
		'check' => 'Periksa pembaruan baru',
		'copiedFromURL' => 'update.php disalin dari %s ke ./data',
		'current_version' => 'Versi saat ini adalah',
		'last' => 'Verifikasi terakhir',
		'loading' => 'Memperbarui…',
		'none' => 'Tidak ada pembaruan untuk diterapkan',
		'releaseChannel' => array(
			'_' => 'Release channel',	// TODO
			'edge' => 'Rolling release (“edge”)',	// TODO
			'latest' => 'Stable release (“latest”)',	// TODO
		),
		'title' => 'Perbarui Sistem',
		'viaGit' => 'Pembaruan via Git dan Github.com dimulai',
	),
	'user' => array(
		'admin' => 'Administrator',	// TODO
		'article_count' => 'Artikel',
		'back_to_manage' => '← Kembali ke Daftar Pengguna',
		'create' => 'Buat pengguna baru',
		'database_size' => 'Ukuran database',
		'email' => 'Alamat email',
		'enabled' => 'Diaktifkan',
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
