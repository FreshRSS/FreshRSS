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
		'finish' => 'Selesaikan pemasangan',
		'fix_errors_before' => 'Perbaiki semua galat sebelum melanjutkan.',
		'keep_install' => 'Gunakan konfigurasi sebelumnya',
		'next_step' => 'Lanjut',
		'reinstall' => 'Pasang ulang FreshRSS',
	),
	'bdd' => array(
		'_' => 'Basis data',
		'conf' => array(
			'_' => 'Konfigurasi basis data',
			'ko' => 'Memeriksa konfigurasi basis data Anda.',
			'ok' => 'Konfigurasi basis data sudah disimpan.',
		),
		'host' => 'Hos',
		'password' => 'Kata sandi basis data',
		'prefix' => 'Prefiks tabel',
		'type' => 'Jenis basis data',
		'username' => 'Nama pengguna basis data',
	),
	'check' => array(
		'_' => 'Pemeriksaan',
		'already_installed' => 'Kami mendeteksi bahwa FreshRSS sudah terpasang!',
		'cache' => array(
			'nok' => 'Periksa izin direktori <em>%1$s</em> untuk pengguna <em>%2$s</em>. Server HTTP harus memiliki izin menulis di direktori tersebut.',
			'ok' => 'Izin untuk direktori tembolok sudah bagus.',
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
			'nok' => 'Periksa izin direktori <em>%1$s</em> untuk pengguna <em>%2$s</em>. Server HTTP harus memiliki izin menulis di direktori tersebut.',
			'ok' => 'Izin untuk direktori data sudah bagus.',
		),
		'database-connection' => array(
			'nok' => 'Kesalahan koneksi basis data.',
			'ok' => 'Koneksi basis data sudah bagus.',
		),
		'database-table' => array(
			'nok' => 'Tabel basis data "%s" tidak lengkap.',
			'ok' => 'Tabel basis data "%s" sudah bagus.',
		),
		'database-tables' => array(
			'nok' => 'Beberapa tabel basis data tidak ditemukan.',
			'ok' => 'Semua tabel basis data sudah ada.',
		),
		'database-title' => 'Basis data',
		'docroot' => array(
			'nok' => 'Root dokumen server web Anda tampaknya tidak menunjuk ke folder <code>./p/</code>. Folder lain seperti <code>./data/</code> mungkin dapat diakses publik.',
			'ok' => 'Root dokumen server web Anda sudah menunjuk dengan benar ke folder <code>./p/</code>.',
		),
		'dom' => array(
			'nok' => 'Tidak dapat menemukan pustaka yang diperlukan untuk menelusuri DOM.',
			'ok' => 'Anda memiliki pustaka yang diperlukan untuk menelusuri DOM.',
		),
		'favicons' => array(
			'nok' => 'Periksa izin direktori <em>%1$s</em> untuk pengguna <em>%2$s</em>. Server HTTP harus memiliki izin menulis di direktori tersebut.',
			'ok' => 'Izin untuk direktori favicon sudah bagus.',
		),
		'fileinfo' => array(
			'nok' => 'Tidak dapat menemukan pustaka PHP fileinfo (fileinfo).',
			'ok' => 'Anda memiliki pustaka fileinfo.',
		),
		'files' => 'Pemasangan Berkas',
		'gmp' => array(
			'nok' => 'Tidak dapat menemukan ekstensi GMP yang diperlukan untuk PHP 32-bit (paket php-gmp).',
			'ok' => 'Anda memiliki ekstensi GMP yang diperlukan untuk PHP 32-bit.',
		),
		'intl' => array(
			'nok' => 'Tidak dapat menemukan pustaka php-intl yang disarankan untuk internasionalisasi.',
			'ok' => 'Anda memiliki pustaka php-intl yang disarankan untuk internasionalisasi.',
		),
		'json' => array(
			'nok' => 'Tidak dapat menemukan pustaka yang direkomendasikan untuk membaca JSON.',
			'ok' => 'Anda memiliki pustaka yang direkomendasikan untuk membaca JSON.',
		),
		'mbstring' => array(
			'nok' => 'Tidak dapat menemukan pustaka mbstring yang direkomendasikan untuk Unicode.',
			'ok' => 'Anda memiliki pustaka mbstring yang direkomendasikan untuk Unicode.',
		),
		'pcre' => array(
			'nok' => 'Tidak dapat menemukan pustaka untuk ekspresi regular (regex) (php-pcre).',
			'ok' => 'Anda memiliki pustaka untuk ekspresi regular (regex) (PCRE).',
		),
		'pdo-mysql' => array(
			'nok' => 'Tidak dapat menemukan driver PDO yang diperlukan untuk MySQL/MariaDB.',
		),
		'pdo-pgsql' => array(
			'nok' => 'Tidak dapat menemukan driver PDO yang diperlukan untuk PostgreSQL.',
		),
		'pdo-sqlite' => array(
			'nok' => 'Tidak dapat menemukan driver PDO untuk SQLite.',
			'ok' => 'Anda memiliki driver PDO untuk SQLite.',
		),
		'pdo' => array(
			'nok' => 'Tidak dapat menemukan PDO atau sejenisnya untuk basis data yang didukung (pdo_sqlite, pdo_pgsql, pdo_mysql).',
			'ok' => 'Anda memiliki PDO atau sejenisnya untuk basis data yang didukung (pdo_sqlite, pdo_pgsql, pdo_mysql).',
		),
		'php' => array(
			'_' => 'Pemasangan PHP.',
			'nok' => 'Versi PHP Anda adalah %s tapi FreshRSS membutuhkan setidaknya versi %s.',
			'ok' => 'Versi PHP Anda (%s) cocok dengan FreshRSS.',
		),
		'reload' => 'Periksa kembali',
		'tmp' => array(
			'nok' => 'Periksa izin direktori <em>%1$s</em> untuk pengguna <em>%2$s</em>. Server HTTP harus memiliki izin menulis di direktori tersebut.',
			'ok' => 'Izin pada direktori tmp sudah bagus.',
		),
		'tokens' => array(
			'nok' => 'Periksa izin direktori <em>./data/tokens</em>. Server HTTP harus memiliki izin menulis di direktori tersebut.',
			'ok' => 'Izin pada direktori token sudah bagus.',
		),
		'unknown_process_username' => 'tidak diketahui',
		'users' => array(
			'nok' => 'Periksa izin direktori <em>%1$s</em> untuk pengguna <em>%2$s</em>. Server HTTP harus memiliki izin menulis di direktori tersebut.',
			'ok' => 'Izin pada direktori pengguna sudah bagus.',
		),
		'xml' => array(
			'nok' => 'Tidak dapat menemukan pustaka yang diperlukan untuk membaca XML.',
			'ok' => 'Anda memiliki pustaka yang diperlukan untuk membaca XML.',
		),
		'zip' => array(
			'nok' => 'Tidak dapat menemukan pustaka ekstensi zip (php-zip).',
			'ok' => 'Anda memiliki pustaka ekstensi zip.',
		),
	),
	'conf' => array(
		'_' => 'Konfigurasi umum',
		'ok' => 'Konfigurasi umum sudah disimpan.',
	),
	'congratulations' => 'Selamat datang!',
	'default_user' => array(
		'_' => 'Nama pengguna untuk pengguna baku',
		'max_char' => '1-39 karakter: huruf, angka, dan <code>. _ @ -</code>',
	),
	'fix_errors_before' => 'Perbaiki galat sebelum melanjutkan.',
	'javascript_is_better' => 'FreshRSS lebih baik dengan JavaScript diaktifkan',
	'js' => array(
		'confirm_reinstall' => 'Anda akan kehilangan konfigurasi sebelumnya jika Anda memasang ulang FreshRSS. Apakah Anda yakin?',
	),
	'language' => array(
		'_' => 'Bahasa',
		'choose' => 'Pilih bahasa untuk FreshRSS',
		'defined' => 'Bahasa sudah dipilih.',
	),
	'missing_applied_migrations' => 'Ada sesuatu yang salah, Anda harus membuat berkas kosong <em>%s</em> secara manual.',
	'ok' => 'Proses pemasangan sukses.',
	'session' => array(
		'nok' => 'Sepertinya konfigurasi server webnya salah untuk kuki yang dibutuhkan untuk sesi PHP!',
	),
	'step' => 'langkah %d',
	'steps' => 'Langkah-Langkah',
	'this_is_the_end' => 'Sudah selesai',
	'title' => 'Pemasangan · FreshRSS',
);
