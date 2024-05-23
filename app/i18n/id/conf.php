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
	'archiving' => array(
		'_' => 'Mengarsipkan',
		'exception' => 'Pengecualian Pembersihan',
		'help' => 'Lebih banyak opsi tersedia di pengaturan umpan individu',
		'keep_favourites' => 'Jangan pernah hapus favorit',
		'keep_labels' => 'Never delete labels',	// TODO
		'keep_max' => 'Jumlah maksimum artikel yang disimpan per umpan',
		'keep_min_by_feed' => 'Jumlah minimum artikel yang harus disimpan per feed',
		'keep_period' => 'Maksimal umur artikel yang harus disimpan',
		'keep_unreads' => 'Jangan hapus artikel yang belum dibaca',
		'maintenance' => 'Pemeliharaan',
		'optimize' => 'Optimalkan basis data',
		'optimize_help' => 'Jalankan sesekali untuk mengurangi ukuran basis data',
		'policy' => 'Kebijakan pembersihan',
		'policy_warning' => 'Jika tidak ada kebijakan pembersihan yang dipilih, setiap artikel akan disimpan.',
		'purge_now' => 'Pembersihan sekarang',
		'title' => 'Arsip',
		'ttl' => 'Jangan perbarui otomatis lebih sering dari',
	),
	'display' => array(
		'_' => 'Tampilan',
		'darkMode' => array(
			'_' => 'Mode gelap otomatis (beta)',
			'auto' => 'Otomatis',
			'no' => 'Tidak',
		),
		'icon' => array(
			'bottom_line' => 'Garis bawah',
			'display_authors' => 'Penulis',
			'entry' => 'Ikon artikel',
			'publication_date' => 'Tanggal publikasi',
			'related_tags' => 'Tag artikel',
			'sharing' => 'Berbagi',
			'summary' => 'Ringkasan',
			'top_line' => 'Garis atas',
		),
		'language' => 'Bahasa',
		'notif_html5' => array(
			'seconds' => 'detik (0 berarti tanpa batas waktu)',
			'timeout' => 'Batas waktu pemberitahuan HTML5',
		),
		'show_nav_buttons' => 'Tampilkan tombol navigasi',
		'theme' => array(
			'_' => 'Tema',
			'deprecated' => array(
				'_' => 'Dihentikan',
				'description' => 'Tema ini tidak lagi didukung dan tidak akan tersedia lagi pada <a href="https://freshrss.github.io/FreshRSS/en/users/05_Configuration.html#theme" target="_blank">rilis mendatang FreshRSS</a>',
			),
		),
		'theme_not_available' => 'Tema "%s" tidak lagi tersedia. Silakan pilih tema lain.',
		'thumbnail' => array(
			'label' => 'Thumbnail',	// TODO
			'landscape' => 'Lanskap',
			'none' => 'Tidak ada',
			'portrait' => 'Potret',
			'square' => 'Persegi',
		),
		'timezone' => 'Zona waktu',
		'title' => 'Tampilan',
		'website' => array(
			'full' => 'Ikon dan nama',
			'icon' => 'Hanya ikon',
			'label' => 'Situs web',
			'name' => 'Hanya nama',
			'none' => 'Tidak ada',
		),
		'width' => array(
			'content' => 'Lebar konten',
			'large' => 'Lebar',
			'medium' => 'Sedang',
			'no_limit' => 'Lebar penuh',
			'thin' => 'Sempit',
		),
	),
	'logs' => array(
		'loglist' => array(
			'level' => 'Level Log',
			'message' => 'Pesan Log',
			'timestamp' => 'Timestamp',	// TODO
		),
		'pagination' => array(
			'first' => 'Pertama',
			'last' => 'Terakhir',
			'next' => 'Selanjutnya',
			'previous' => 'Sebelumnya',
		),
	),
	'profile' => array(
		'_' => 'Manajemen Profil',
		'api' => 'Manajemen API',
		'delete' => array(
			'_' => 'Hapus Akun',
			'warn' => 'Akun Anda dan semua data terkait akan dihapus.',
		),
		'email' => 'Alamat Email',
		'password_api' => 'Password API<br /><small>(contoh: untuk aplikasi mobile)</small>',
		'password_form' => 'Password<br /><small>(untuk metode login formulir web)</small>',
		'password_format' => 'Minimal 7 karakter',
		'title' => 'Profil',
	),
	'query' => array(
		'_' => 'Permintaan Pengguna',
		'deprecated' => 'Permintaan ini tidak valid lagi. Kategori atau feed yang dirujuk telah dihapus.',
		'filter' => array(
			'_' => 'Filter yang diterapkan:',
			'categories' => 'Tampilkan berdasarkan kategori',
			'feeds' => 'Tampilkan berdasarkan feed',
			'order' => 'Urutkan berdasarkan tanggal',
			'search' => 'Ekspresi Pencarian',
			'shareOpml' => 'Aktifkan berbagi melalui OPML dari kategori dan feed yang sesuai',
			'shareRss' => 'Aktifkan berbagi melalui HTML &amp; RSS',
			'state' => 'Status',
			'tags' => 'Tampilkan berdasarkan label',
			'type' => 'Tipe',
		),
		'get_all' => 'Tampilkan semua artikel',
		'get_all_labels' => 'Tampilkan artikel dengan setiap label',
		'get_category' => 'Tampilkan kategori "%s"',
		'get_favorite' => 'Tampilkan artikel favorit',
		'get_feed' => 'Tampilkan feed "%s"',
		'get_important' => 'Tampilkan artikel dari feed penting',
		'get_label' => 'Tampilkan artikel dengan label "%s"',
		'help' => 'Lihat <a href="https://freshrss.github.io/FreshRSS/en/users/user_queries.html" target="_blank">dokumentasi untuk permintaan pengguna dan berbagi ulang melalui HTML / RSS / OPML</a>.',
		'name' => 'Nama',
		'no_filter' => 'Tanpa filter',
		'number' => 'Permintaan n°%d',
		'order_asc' => 'Tampilkan artikel tertua dahulu',
		'order_desc' => 'Tampilkan artikel terbaru dahulu',
		'search' => 'Cari untuk "%s"',
		'share' => array(
			'_' => 'Bagikan permintaan ini melalui tautan',
			'help' => 'Berikan tautan ini jika Anda ingin berbagi permintaan ini dengan siapa pun',
			'html' => 'Tautan dapat dibagikan ke halaman HTML',
			'opml' => 'Tautan dapat dibagikan ke daftar OPML dari feed',
			'rss' => 'Tautan dapat dibagikan ke feed RSS',
		),
		'state_0' => 'Tampilkan semua artikel',
		'state_1' => 'Tampilkan artikel yang telah dibaca',
		'state_2' => 'Tampilkan artikel yang belum dibaca',
		'state_3' => 'Tampilkan semua artikel',
		'state_4' => 'Tampilkan artikel favorit',
		'state_5' => 'Tampilkan artikel favorit yang telah dibaca',
		'state_6' => 'Tampilkan artikel favorit yang belum dibaca',
		'state_7' => 'Tampilkan artikel favorit',
		'state_8' => 'Tampilkan artikel non-favorit',
		'state_9' => 'Tampilkan artikel non-favorit yang telah dibaca',
		'state_10' => 'Tampilkan artikel non-favorit yang belum dibaca',
		'state_11' => 'Tampilkan artikel non-favorit',
		'state_12' => 'Tampilkan semua artikel',
		'state_13' => 'Tampilkan artikel yang telah dibaca',
		'state_14' => 'Tampilkan artikel yang belum dibaca',
		'state_15' => 'Tampilkan semua artikel',
		'title' => 'Permintaan Pengguna',
	),
	'reading' => array(
		'_' => 'Membaca',
		'after_onread' => 'Setelah “tandai semua sebagai telah dibaca”',
		'always_show_favorites' => 'Selalu tampilkan semua artikel favorit secara default',
		'article' => array(
			'authors_date' => array(
				'_' => 'Penulis dan tanggal',
				'both' => 'Di header dan footer',
				'footer' => 'Di footer',
				'header' => 'Di header',
				'none' => 'Tidak ada',
			),
			'feed_name' => array(
				'above_title' => 'Di atas judul/tag',
				'none' => 'Tidak ada',
				'with_authors' => 'Di baris penulis dan tanggal',
			),
			'feed_title' => 'Judul feed',
			'tags' => array(
				'_' => 'Tag',
				'both' => 'Di header dan footer',
				'footer' => 'Di footer',
				'header' => 'Di header',
				'none' => 'Tidak ada',
			),
			'tags_max' => array(
				'_' => 'Jumlah maksimum tag yang ditampilkan',
				'help' => '0 berarti: tampilkan semua tag dan jangan lipat',
			),
		),
		'articles_per_page' => 'Jumlah artikel per halaman',
		'auto_load_more' => 'Muat lebih banyak artikel di bagian bawah halaman',
		'auto_remove_article' => 'Sembunyikan artikel setelah dibaca',
		'confirm_enabled' => 'Tampilkan dialog konfirmasi pada tindakan “tandai semua sebagai telah dibaca”',
		'display_articles_unfolded' => 'Tampilkan artikel terbuka secara default',
		'display_categories_unfolded' => 'Kategori untuk dibuka',
		'headline' => array(
			'articles' => 'Artikel: Buka/Tutup',
			'articles_header_footer' => 'Artikel: header/footer',
			'categories' => 'Navigasi kiri: Kategori',
			'mark_as_read' => 'Tandai artikel sebagai telah dibaca',
			'misc' => 'Lain-lain',
			'view' => 'Tampilan',
		),
		'hide_read_feeds' => 'Sembunyikan kategori & feed yang tidak memiliki artikel belum dibaca (tidak berlaku untuk konfigurasi “Tampilkan semua artikel”)',
		'img_with_lazyload' => 'Gunakan mode “lazy load” untuk memuat gambar',
		'jump_next' => 'loncat ke saudara yang belum dibaca berikutnya (feed atau kategori)',
		'mark_updated_article_unread' => 'Tandai artikel yang diperbarui sebagai belum dibaca',
		'number_divided_when_reader' => 'Bagi dua dalam tampilan baca.',
		'read' => array(
			'article_open_on_website' => 'ketika artikel dibuka di situs web aslinya',
			'article_viewed' => 'ketika artikel dilihat',
			'focus' => 'saat difokuskan (kecuali untuk feed penting)',
			'keep_max_n_unread' => 'Jumlah maksimum artikel yang tetap belum dibaca',
			'scroll' => 'saat menggulir (kecuali untuk feed penting)',
			'upon_gone' => 'saat tidak lagi ada di feed berita atas',
			'upon_reception' => 'saat menerima artikel',
			'when' => 'Tandai artikel sebagai telah dibaca…',
			'when_same_title' => 'jika judul identik sudah ada di <i>n</i> artikel terbaru',
		),
		'show' => array(
			'_' => 'Artikel untuk ditampilkan',
			'active_category' => 'Kategori aktif',
			'adaptive' => 'Penyesuaian tampilan',
			'all_articles' => 'Tampilkan semua artikel',
			'all_categories' => 'Semua kategori',
			'no_category' => 'Tidak ada kategori',
			'remember_categories' => 'Ingat kategori yang terbuka',
			'unread' => 'Hanya tampilkan yang belum dibaca',
		),
		'show_fav_unread_help' => 'Berlaku juga pada label',
		'sides_close_article' => 'Klik di luar area teks artikel untuk menutup artikel',
		'sort' => array(
			'_' => 'Urutan penyortiran',
			'newer_first' => 'Terbaru dulu',
			'older_first' => 'Terlama dulu',
		),
		'sticky_post' => 'Tempelkan artikel di bagian atas saat dibuka',
		'title' => 'Membaca',
		'view' => array(
			'default' => 'Tampilan default',
			'global' => 'Tampilan global',
			'normal' => 'Tampilan normal',
			'reader' => 'Tampilan membaca',
		),
	),
	'sharing' => array(
		'_' => 'Sharing',	// TODO
		'add' => 'Add a sharing method',	// TODO
		'blogotext' => 'Blogotext',	// IGNORE
		'deprecated' => 'This service is deprecated and will be removed from FreshRSS in a <a href="https://freshrss.github.io/FreshRSS/en/users/08_sharing_services.html" title="Open documentation for more information" target="_blank">future release</a>.',	// TODO
		'diaspora' => 'Diaspora*',	// IGNORE
		'email' => 'Email',	// TODO
		'facebook' => 'Facebook',	// IGNORE
		'more_information' => 'More information',	// TODO
		'print' => 'Print',	// TODO
		'raindrop' => 'Raindrop.io',	// IGNORE
		'remove' => 'Remove sharing method',	// TODO
		'shaarli' => 'Shaarli',	// IGNORE
		'share_name' => 'Share name to display',	// TODO
		'share_url' => 'Share URL to use',	// TODO
		'title' => 'Sharing',	// TODO
		'twitter' => 'Twitter',	// IGNORE
		'wallabag' => 'wallabag',	// IGNORE
	),
	'shortcut' => array(
		'_' => 'Pintasan',
		'article_action' => 'Tindakan artikel',
		'auto_share' => 'Bagikan',
		'auto_share_help' => 'Jika hanya ada satu mode berbagi, itu akan digunakan. Jika tidak, mode dapat diakses dengan nomornya.',
		'close_dropdown' => 'Tutup menu',
		'collapse_article' => 'Ciutkan',
		'first_article' => 'Buka artikel pertama',
		'focus_search' => 'Akses kotak pencarian',
		'global_view' => 'Beralih ke tampilan global',
		'help' => 'Tampilkan dokumentasi',
		'javascript' => 'JavaScript harus diaktifkan untuk menggunakan pintasan',
		'last_article' => 'Buka artikel terakhir',
		'load_more' => 'Muat lebih banyak artikel',
		'mark_favorite' => 'Toggle favorit',
		'mark_read' => 'Toggle baca',
		'navigation' => 'Navigasi',
		'navigation_help' => 'Dengan modifikasi <kbd>⇧ Shift</kbd>, pintasan navigasi berlaku pada feed.<br/>Dengan modifikasi <kbd>Alt ⎇</kbd>, pintasan navigasi berlaku pada kategori.',
		'navigation_no_mod_help' => 'Pintasan navigasi berikut tidak mendukung modifikasi.',
		'next_article' => 'Buka artikel berikutnya',
		'next_unread_article' => 'Buka artikel berikutnya yang belum dibaca',
		'non_standard' => 'Beberapa tombol (<kbd>%s</kbd>) mungkin tidak berfungsi sebagai pintasan.',
		'normal_view' => 'Beralih ke tampilan normal',
		'other_action' => 'Tindakan lainnya',
		'previous_article' => 'Buka artikel sebelumnya',
		'reading_view' => 'Beralih ke tampilan membaca',
		'rss_view' => 'Buka sebagai umpan RSS',
		'see_on_website' => 'Lihat di situs web asli',
		'shift_for_all_read' => '+ <kbd>Alt ⎇</kbd> untuk menandai artikel sebelumnya sebagai telah dibaca<br />+ <kbd>⇧ Shift</kbd> untuk menandai semua artikel sebagai telah dibaca',
		'skip_next_article' => 'Fokus berikutnya tanpa membuka',
		'skip_previous_article' => 'Fokus sebelumnya tanpa membuka',
		'title' => 'Pintasan',
		'toggle_media' => 'Putar/jeda media',
		'user_filter' => 'Akses kueri pengguna',
		'user_filter_help' => 'Jika hanya ada satu kueri pengguna, itu akan digunakan. Jika tidak, kueri dapat diakses dengan nomornya.',
		'views' => 'Tampilan',
	),
	'user' => array(
		'articles_and_size' => '%s artikel (%s)',
		'current' => 'Pengguna saat ini',
		'is_admin' => 'adalah administrator',
		'users' => 'Pengguna',
	),
);
