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
		'allow_anonymous' => 'Izinkan pembacaan artikel pengguna default (%s) secara awanama',
		'allow_anonymous_refresh' => 'Izinkan untuk memuat ulang artikel awanama',
		'api_enabled' => 'Izinkan akses <abbr>API</abbr> <small>(Diperlukan untuk aplikasi seluler dan untuk membagikan pencarian pengguna)</small>',
		'form' => 'Formulir Web (klasik, membutuhkan JavaScript)',
		'http' => 'HTTP (tingkat lanjut: dikelola oleh peladen Web, OIDC, SSO, dll.)',
		'none' => 'Tidak ada (berbahaya)',
		'title' => 'Autentikasi',
		'token' => 'Token autentikasi utama',
		'token_help' => 'Mengizinkan akses ke semua RSS pengguna serta menyegarkan umpan tanpa autentikasi:',
		'type' => 'Metode autentikasi',
		'unsafe_autologin' => 'Izinkan masuk otomatis tidak aman menggunakan format: ',
	),
	'check_install' => array(
		'cache' => array(
			'nok' => 'Periksa izin direktori <em>./data/cache</em>. Peladen HTTP harus memiliki izin menulis di direktori tersebut.',
			'ok' => 'Izin untuk direktori tembolok sudah bagus.',
		),
		'categories' => array(
			'nok' => 'Tabel kategori dikonfigurasi secara tidak tepat.',
			'ok' => 'Tabel kategori baik-baik saja.',
		),
		'connection' => array(
			'nok' => 'Koneksi ke basis data tidak dapat dibuat.',
			'ok' => 'Koneksi ke basis data berhasil.',
		),
		'ctype' => array(
			'nok' => 'Tidak dapat menemukan pustaka yang diperlukan untuk pemeriksaan jenis karakter (php-ctype).',
			'ok' => 'Anda memiliki pustaka untuk pemeriksaan jenis karakter (ctype).',
		),
		'curl' => array(
			'nok' => 'Tidak dapat menemukan pustaka cURL (php-curl).',
			'ok' => 'Anda memiliki pustaka cURL.',
		),
		'data' => array(
			'nok' => 'Periksa izin direktori <em>./data</em>. Peladen HTTP harus memiliki izin menulis di direktori tersebut.',
			'ok' => 'Izin untuk direktori data sudah bagus.',
		),
		'database' => 'Pemasangan Basis Data',
		'dom' => array(
			'nok' => 'Tidak dapat menemukan pustaka yang diperlukan untuk menelusuri DOM (php-xml).',
			'ok' => 'Anda memiliki pustaka yang diperlukan untuk menelusuri DOM.',
		),
		'entries' => array(
			'nok' => 'Tabel entri dikonfigurasi secara tidak tepat.',
			'ok' => 'Tabel entri baik-baik saja.',
		),
		'favicons' => array(
			'nok' => 'Periksa izin direktori <em>./data/favicons</em>. Peladen HTTP harus memiliki izin menulis di direktori tersebut.',
			'ok' => 'Izin untuk direktori favicon sudah bagus.',
		),
		'feeds' => array(
			'nok' => 'Tabel umpan dikonfigurasi secara tidak tepat.',
			'ok' => 'Tabel umpan baik-baik saja.',
		),
		'fileinfo' => array(
			'nok' => 'Tidak dapat menemukan pustaka PHP fileinfo (fileinfo).',
			'ok' => 'Anda memiliki pustaka fileinfo.',
		),
		'files' => 'Pemasangan Berkas',
		'json' => array(
			'nok' => 'Tidak dapat menemukan pustaka JSON (php-json).',
			'ok' => 'Anda memiliki pustaka ekstensi JSON.',
		),
		'mbstring' => array(
			'nok' => 'Tidak dapat menemukan pustaka mbstring untuk Unicode.',
			'ok' => 'Anda memiliki pustaka mbstring untuk Unicode yang direkomendasikan.',
		),
		'pcre' => array(
			'nok' => 'Tidak dapat menemukan pustaka untuk ekspresi regular (regex) (php-pcre).',
			'ok' => 'Anda memiliki pustaka untuk ekspresi regular (regex) (PCRE).',
		),
		'pdo' => array(
			'nok' => 'Tidak dapat menemukan PDO atau sejenisnya untuk basis data yang didukung (pdo_mysql, pdo_sqlite, pdo_pgsql).',
			'ok' => 'Anda memiliki PDO atau sejenisnya untuk basis data yang didukung (pdo_mysql, pdo_sqlite, pdo_pgsql).',
		),
		'php' => array(
			'_' => 'Pemasangan PHP.',
			'nok' => 'Versi PHP Anda adalah %s tapi FreshRSS membutuhkan setidaknya versi %s.',
			'ok' => 'Versi PHP Anda (%s) cocok dengan FreshRSS.',
		),
		'tables' => array(
			'nok' => 'Ada satu atau lebih tabel yang hilang dalam basis data.',
			'ok' => 'Tabel yang sesuai sudah ada dalam basis data.',
		),
		'title' => 'Pengecekan Pemasangan.',
		'tokens' => array(
			'nok' => 'Periksa izin direktori <em>./data/tokens</em>. Peladen HTTP harus memiliki izin menulis di direktori tersebut.',
			'ok' => 'Izin pada direktori token sudah bagus.',
		),
		'users' => array(
			'nok' => 'Periksa izin direktori <em>./data/users</em>. Peladen HTTP harus memiliki izin menulis di direktori tersebut.',
			'ok' => 'Izin pada direktori pengguna sudah bagus.',
		),
		'zip' => array(
			'nok' => 'Tidak dapat menemukan pustaka ekstensi zip (php-zip).',
			'ok' => 'Anda memiliki pustaka ekstensi zip.',
		),
	),
	'extensions' => array(
		'author' => 'Pengembang',
		'community' => 'Ekstensi komunitas yang tersedia',
		'description' => 'Keterangan',
		'disabled' => 'Dinonaktifkan',
		'empty_list' => 'Tidak ada ekstensi yang terpasang',
		'empty_list_help' => 'Periksa log untuk menemukan alasan daftar ekstensi yang kosong.',
		'enabled' => 'Diaktifkan',
		'latest' => 'Terpasang',
		'name' => 'Nama',
		'no_configure_view' => 'Ekstensi ini tidak dapat dikonfigurasi.',
		'system' => array(
			'_' => 'Ekstensi sistem',
			'no_rights' => 'Ekstensi sistem (Anda tidak memiliki izin yang diperlukan)',
		),
		'title' => 'Ekstensi',
		'update' => 'Pembaruan tersedia',
		'user' => 'Ekstensi pengguna',
		'version' => 'Versi',
	),
	'stats' => array(
		'_' => 'Statistik',
		'all_feeds' => 'Semua umpan',
		'category' => 'Kategori',
		'entry_count' => 'Jumlah entri',
		'entry_per_category' => 'Entri per kategori',
		'entry_per_day' => 'Entri per hari (30 hari terakhir)',
		'entry_per_day_of_week' => 'Per hari dalam seminggu (rata-rata: %.2f pesan)',
		'entry_per_hour' => 'Per jam (rata-rata %.2f pesan)',
		'entry_per_month' => 'Per bulan (rata -rata: %.2f pesan)',
		'entry_repartition' => 'Pengkategorian Entri',
		'feed' => 'Umpan',
		'feed_per_category' => 'Umpan per kategori',
		'idle' => 'Umpan Tak Terbarukan',
		'main' => 'Statistik utama',
		'main_stream' => 'Bagian utama',
		'no_idle' => 'Tidak ada umpan tak terbarukan!',
		'number_entries' => '%d artikel',
		'overview' => 'Ringkasan',
		'percent_of_total' => '% dari total',
		'repartition' => 'Pengkategorian artikel: %s',
		'status_favorites' => 'Favorit',
		'status_read' => 'Terbaca',
		'status_total' => 'Total',	// IGNORE
		'status_unread' => 'Belum Terbaca',
		'title' => 'Statistik',
		'top_feed' => 'Sepuluh umpan teratas',
	),
	'system' => array(
		'_' => 'Konfigurasi Sistem',
		'auto-update-url' => 'URL peladen untuk pembaruan otomatis',
		'base-url' => array(
			'_' => 'URL peladen',
			'recommendation' => 'Rekomendasi Otomatis: <kbd>%s</kbd>',
		),
		'cookie-duration' => array(
			'help' => 'dalam detik',
			'number' => 'Durasi untuk terus masuk',
		),
		'force_email_validation' => 'Paksa verifikasi alamat surel',
		'instance-name' => 'Nama peladen',
		'max-categories' => 'Jumlah kategori maksimal per pengguna',
		'max-feeds' => 'Jumlah umpan maksimal per pengguna',
		'registration' => array(
			'number' => 'Jumlah akun maksimal',
			'select' => array(
				'label' => 'Formulir pendaftaran',
				'option' => array(
					'noform' => 'Nonaktif: Tidak ada formulir pendaftaran',
					'nolimit' => 'Aktif: Tidak ada batasan akun',
					'setaccountsnumber' => 'Atur jumlah akun maksimal',
				),
			),
			'status' => array(
				'disabled' => 'Formulir dinonaktifkan',
				'enabled' => 'Formulir diaktifkan',
			),
			'title' => 'Formulir Pendaftaran Pengguna',
		),
		'sensitive-parameter' => 'Konfigurasi sensitif. Sunting manual di <kbd>./data/config.php</kbd>',
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
		'_' => 'Pembaruan FreshRSS',
		'apply' => 'Mulai pembaruan',
		'changelog' => 'Log Perubahan',
		'check' => 'Periksa pembaruan baru',
		'copiedFromURL' => 'update.php disalin dari %s ke ./data',
		'current_version' => 'Versi saat ini adalah',
		'last' => 'Terakhir diperiksa pada',
		'loading' => 'Memperbarui…',
		'none' => 'Tidak ada pembaruan yang baru',
		'releaseChannel' => array(
			'_' => 'Kanal rilis',
			'edge' => 'Rilis Baru (“edge”)',
			'latest' => 'Rilis Stabil (“latest”)',
		),
		'title' => 'Pembaruan FreshRSS',
		'viaGit' => 'Pembaruan lewat git dan Github.com dimulai',
	),
	'user' => array(
		'admin' => 'Administrator',	// IGNORE
		'article_count' => 'Artikel',
		'back_to_manage' => '← Kembali ke Daftar Pengguna',
		'create' => 'Buat pengguna baru',
		'database_size' => 'Ukuran basis data',
		'email' => 'Alamat surel',
		'enabled' => 'Aktif',
		'feed_count' => 'Umpan',
		'is_admin' => 'Admin',
		'language' => 'Bahasa',
		'last_user_activity' => 'Aktivitas pengguna terakhir',
		'list' => 'Daftar pengguna',
		'number' => 'Ada %d akun yang telah dibuat',
		'numbers' => 'Ada %d akun yang telah dibuat',
		'password_form' => 'Kata sandi<br /><small>(Untuk metode masuk formulir web)</small>',
		'password_format' => 'Setidaknya 7 karakter',
		'title' => 'Kelola pengguna',
		'username' => 'Nama pengguna',
	),
);
