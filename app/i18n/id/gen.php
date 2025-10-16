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
		'actualize' => 'Perbarui umpan',
		'add' => 'Tambah',
		'back_to_rss_feeds' => '← Kembali ke umpan RSS Anda',
		'cancel' => 'Batal',
		'close' => 'Tutup',
		'create' => 'Buat',
		'delete_all_feeds' => 'Hapus semua umpan',
		'delete_errored_feeds' => 'Hapus umpan dengan galat',
		'delete_muted_feeds' => 'Hapus umpan yang dibisukan',
		'demote' => 'Demosi',
		'disable' => 'Nonaktifkan',
		'download' => 'Unduh',
		'empty' => 'Kosongkan',
		'enable' => 'Aktifkan',
		'export' => 'Ekspor',
		'filter' => 'Filter',	// TODO
		'import' => 'Impor',
		'load_default_shortcuts' => 'Muat pintasan baku',
		'manage' => 'Kelola',
		'mark_read' => 'Tandai sebagai sudah dibaca',
		'menu' => array(
			'open' => 'Buka menu',
		),
		'nav_buttons' => array(
			'next' => 'Artikel selanjutnya',
			'prev' => 'Artikel sebelumnya',
			'up' => 'Ke atas',
		),
		'open_url' => 'Buka URL',
		'promote' => 'Promosi',
		'purge' => 'Hapus',
		'refresh_opml' => 'Segarkan OPML',
		'remove' => 'Hapus',
		'rename' => 'Ubah nama',
		'see_website' => 'Lihat situs',
		'submit' => 'Kirim',
		'truncate' => 'Hapus semua artikel',
		'update' => 'Perbarui',
	),
	'auth' => array(
		'accept_tos' => 'Saya menyetujui <a href="%s">Kebijakan Layanan</a>.',
		'email' => 'Alamat surel',
		'keep_logged_in' => 'Biarkan saya masuk <small>(%s hari)</small>',
		'login' => 'Masuk',
		'logout' => 'Keluar',
		'password' => array(
			'_' => 'Kata sandi',
			'format' => '<small>Paling tidak 7 karakter</small>',
		),
		'reauth' => array(
			'header' => 'Reauthentication is required',	// TODO
			'tip' => 'You won’t be asked to sign in again for <u>%d minutes</u>',	// TODO
			'title' => 'Reauthentication',	// TODO
		),
		'registration' => array(
			'_' => 'Akun baru',
			'ask' => 'Buat akun?',
			'title' => 'Pembuatan akun',
		),
		'username' => array(
			'_' => 'Nama pengguna',
			'format' => '<small>Maksimum 16 alfanumerik karakter</small>',
		),
	),
	'date' => array(
		'Apr' => '\\A\\p\\r\\i\\l',	// IGNORE
		'Aug' => '\\A\\g\\u\\s\\t\\u\\s',
		'Dec' => '\\D\\e\\s\\e\\m\\b\\e\\r',
		'Feb' => '\\F\\e\\b\\r\\u\\a\\r\\i',
		'Jan' => '\\J\\a\\n\\u\\a\\r\\i',
		'Jul' => '\\J\\u\\l\\i',
		'Jun' => '\\J\\u\\n\\i',
		'Mar' => '\\M\\a\\r\\e\\t',
		'May' => '\\M\\e\\i',
		'Nov' => '\\N\\o\\v\\e\\m\\b\\e\\r',	// IGNORE
		'Oct' => '\\O\\k\\t\\o\\b\\e\\r',
		'Sep' => '\\S\\e\\p\\t\\e\\m\\b\\e\\r',	// IGNORE
		'apr' => 'Apr.',	// IGNORE
		'april' => 'April',	// IGNORE
		'aug' => 'Agu.',
		'august' => 'Agustus',
		'before_yesterday' => 'Sebelum kemarin',
		'dec' => 'Des.',
		'december' => 'Desember',
		'feb' => 'Feb.',	// IGNORE
		'february' => 'Februari',
		'format_date' => '%s j\\<\\s\\u\\p\\>S\\<\\/\\s\\u\\p\\> Y',
		'format_date_hour' => '%s j\\<\\s\\u\\p\\>S\\<\\/\\s\\u\\p\\> Y \\a\\t g\\:i a',
		'fri' => 'Jum',
		'jan' => 'Jan.',	// IGNORE
		'january' => 'Januari',
		'jul' => 'Juli',
		'july' => 'Juli',
		'jun' => 'Juni',
		'june' => 'Juni',
		'last_2_year' => 'Dua tahun terakhir',
		'last_3_month' => 'Tiga bulan terakhir',
		'last_3_year' => 'Tiga tahun terakhir',
		'last_5_year' => 'Lima tahun terakhir',
		'last_6_month' => 'Enam bulan terakhir',
		'last_month' => 'Satu bulan terakhir',
		'last_week' => 'Satu pekan terakhir',
		'last_year' => 'Satu tahun terakhir',
		'mar' => 'Mar.',	// IGNORE
		'march' => 'Maret',
		'may' => 'Mei',
		'may_' => 'Mei',
		'mon' => 'Bln',
		'month' => 'bulan',
		'nov' => 'Nov.',	// IGNORE
		'november' => 'November',	// IGNORE
		'oct' => 'Okt.',
		'october' => 'Oktober',
		'sat' => 'Sbt',
		'sep' => 'Sept.',	// IGNORE
		'september' => 'September',	// IGNORE
		'sun' => 'Mng',
		'thu' => 'Kms',
		'today' => 'Hari ini',
		'tue' => 'Sel',
		'wed' => 'Rab',
		'yesterday' => 'Kemarin',
	),
	'dir' => 'ltr',	// IGNORE
	'freshrss' => array(
		'_' => 'FreshRSS',	// IGNORE
		'about' => 'Tentang FreshRSS',
	),
	'js' => array(
		'category_empty' => 'Kategori kosong',
		'confirm_action' => 'Apakah Anda yakin ingin melakukan ini? Ini tidak dapat dibatalkan!',
		'confirm_action_feed_cat' => 'Apakah Anda yakin ingin melakukan ini? Anda akan kehilangan favorit dan pencarian pengguna terkait. Ini tidak dapat dibatalkan.',
		'confirm_exit_slider' => 'Are you sure you want to discard unsaved settings?',	// TODO
		'feedback' => array(
			'body_new_articles' => 'Ada %%d artikel baru untuk dibaca di FreshRSS.',
			'body_unread_articles' => '(belum dibaca: %%d)',
			'request_failed' => 'Permintaan gagal, mungkin dikarenakan masalah koneksi internet.',
			'title_new_articles' => 'FreshRSS: artikel baru!',
		),
		'labels_empty' => 'Tidak ada label',
		'new_article' => 'Tidak ada artikel baru yang tersedia, klik untuk menyegarkan halaman.',
		'should_be_activated' => 'JavaScript harus diaktifkan',
		'unsafe_csp_header' => 'The CSP header in use is unsafe and FreshRSS may be vulnerable to XSS attacks. <a target="_blank" href="https://freshrss.github.io/FreshRSS/en/admins/10_ServerConfig.html#security">See documentation</a>',	// TODO
	),
	'lang' => array(
		'cs' => 'Čeština',	// IGNORE
		'de' => 'Deutsch',	// IGNORE
		'el' => 'Ελληνικά',	// IGNORE
		'en' => 'English',	// IGNORE
		'en-US' => 'English (United States)',	// IGNORE
		'es' => 'Español',	// IGNORE
		'fa' => 'فارسی',	// IGNORE
		'fi' => 'Suomi',	// IGNORE
		'fr' => 'Français',	// IGNORE
		'he' => 'עברית',	// IGNORE
		'hu' => 'Magyar',	// IGNORE
		'id' => 'Bahasa Indonesia',	// IGNORE
		'it' => 'Italiano',	// IGNORE
		'ja' => '日本語',	// IGNORE
		'ko' => '한국어',	// IGNORE
		'lv' => 'Latviešu',	// IGNORE
		'nl' => 'Nederlands',	// IGNORE
		'oc' => 'Occitan',	// IGNORE
		'pl' => 'Polski',	// IGNORE
		'pt-BR' => 'Português (Brasil)',	// IGNORE
		'pt-PT' => 'Português (Portugal)',	// IGNORE
		'ru' => 'Русский',	// IGNORE
		'sk' => 'Slovenčina',	// IGNORE
		'tr' => 'Türkçe',	// IGNORE
		'uk' => 'Українська',	// IGNORE
		'zh-CN' => '简体中文',	// IGNORE
		'zh-TW' => '正體中文',	// IGNORE
	),
	'menu' => array(
		'about' => 'Tentang',
		'account' => 'Akun',
		'admin' => 'Administrasi',
		'advanced_search' => 'Advanced Search',	// TODO
		'archiving' => 'Pengarsipan',
		'authentication' => 'Autentikasi',
		'check_install' => 'Pemeriksaan pemasangan',
		'configuration' => 'Konfigurasi',
		'display' => 'Tampilan',
		'extensions' => 'Ekstensi',
		'logs' => 'Log',
		'privacy' => 'Privasi',
		'queries' => 'Pencarian pengguna',
		'reading' => 'Membaca',
		'search' => 'Cari kata atau #label',
		'search_help' => 'Lihat dokumentasi unuk <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">parameter pencarian</a> lebih lanjut',
		'sharing' => 'Berbagi',
		'shortcuts' => 'Pintasan',
		'stats' => 'Statistik',
		'system' => 'Konfigurasi sistem',
		'update' => 'Pembaruan',
		'user_management' => 'Kelola pengguna',
		'user_profile' => 'Profil',
	),
	'period' => array(
		'days' => 'hari',
		'hours' => 'jam',
		'months' => 'bulan',
		'weeks' => 'minggu',
		'years' => 'tahun',
	),
	'readme' => array(
		'contribute' => 'contribute',	// IGNORE
		'language' => 'Language',	// IGNORE
		'translated' => 'Progress',	// IGNORE
	),
	'search' => array(
		'advanced_search_help' => 'This form helps construct search queries, but manual queries are even more powerful.',	// TODO
		'authors' => 'Authors',	// TODO
		'categories' => 'Categories',	// TODO
		'content' => 'Content',	// TODO
		'date_from' => 'From',	// TODO
		'date_past' => 'In the past',	// TODO
		'date_published' => 'Publication Date',	// TODO
		'date_range' => 'Date Range',	// TODO
		'date_received' => 'Received Date',	// TODO
		'date_to' => 'To',	// TODO
		'feeds' => 'Feeds',	// TODO
		'free_text' => 'Free Text',	// TODO
		'free_text_help' => 'Search both in title and content',	// TODO
		'full_documentation' => 'View <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">full search documentation</a>',	// TODO
		'labels' => 'My Labels',	// TODO
		'multiple_help' => 'Select one or more (hold <kbd>Ctrl</kbd> or <kbd>Cmd</kbd>)',	// TODO
		'sources' => 'Sources',	// TODO
		'tags' => 'Article Tags',	// TODO
		'text' => 'Text Search',	// TODO
		'text_help' => 'Multiple lines are combined by a logical <i>or</i>. Also supports <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#regex" target="_blank">regular expressions</a>.',	// TODO
		'text_placeholder' => 'Keyword',	// TODO
		'title' => 'Title',	// TODO
		'url' => 'URL',	// TODO
		'user_queries' => 'User Queries',	// TODO
	),
	'share' => array(
		'Known' => 'Situs berbasis Known',
		'archiveIS' => 'archive.is',	// IGNORE
		'archiveORG' => 'archive.org',	// IGNORE
		'archivePH' => 'archive.ph',	// IGNORE
		'bluesky' => 'Bluesky',	// IGNORE
		'buffer' => 'Buffer',	// IGNORE
		'clipboard' => 'Papan Klip',
		'diaspora' => 'Diaspora*',	// IGNORE
		'email' => 'Surel',
		'email-webmail-firefox-fix' => 'Surel (klien web - perbaikan untuk Firefox)',
		'facebook' => 'Facebook',	// IGNORE
		'gnusocial' => 'GNU social',	// IGNORE
		'jdh' => 'Journal du hacker',	// IGNORE
		'lemmy' => 'Lemmy',	// IGNORE
		'linkding' => 'Linkding',	// IGNORE
		'linkedin' => 'LinkedIn',	// IGNORE
		'mastodon' => 'Mastodon',	// IGNORE
		'movim' => 'Movim',	// IGNORE
		'omnivore' => 'Omnivore',	// IGNORE
		'pinboard' => 'Pinboard',	// IGNORE
		'pinterest' => 'Pinterest',	// IGNORE
		'pocket' => 'Pocket',	// IGNORE
		'print' => 'Cetak',
		'raindrop' => 'Raindrop.io',	// IGNORE
		'reddit' => 'Reddit',	// IGNORE
		'shaarli' => 'Shaarli',	// IGNORE
		'telegram' => 'Telegram',	// IGNORE
		'twitter' => 'Twitter',	// IGNORE
		'wallabag' => 'wallabag v1',	// IGNORE
		'wallabagv2' => 'wallabag v2',	// IGNORE
		'web-sharing-api' => 'Bagikan sistem',
		'whatsapp' => 'Whatsapp',	// IGNORE
		'xing' => 'Xing',	// IGNORE
	),
	'short' => array(
		'attention' => 'Peringatan!',
		'blank_to_disable' => 'Biarkan kosong untuk menonaktifkan',
		'by_author' => 'Oleh:',
		'by_default' => 'Secara baku',
		'damn' => 'Sial!',
		'default_category' => 'Tidak ada kategori',
		'no' => 'Tidak',
		'not_applicable' => 'Tidak tersedia',
		'ok' => 'Oke!',
		'or' => 'atau',
		'yes' => 'Ya',
	),
	'stream' => array(
		'load_more' => 'Muat lebih banyak artikel',
		'mark_all_read' => 'Tandai semua sebagai sudah dibaca',
		'nothing_to_load' => 'Tidak ada artikel lagi',
	),
);
