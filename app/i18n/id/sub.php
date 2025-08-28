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
	'api' => array(
		'documentation' => 'Salin URL berikut untuk menggunakannya di alat eksternal.',
		'title' => 'API',	// IGNORE
	),
	'bookmarklet' => array(
		'documentation' => 'Seret tombol ini ke bilah alat markah Anda atau klik kanan dan pilih "Markahi Tautan". Kemudian klik "Langgan" di halaman yang ingin Anda langgan',
		'label' => 'Langgan',
		'title' => 'Bookmarklet',	// IGNORE
	),
	'category' => array(
		'_' => 'Kategori',
		'add' => 'Tambah kategori',
		'archiving' => 'Pengarsipan',
		'dynamic_opml' => array(
			'_' => 'OPML dinamis',
			'help' => 'Sediakan URL ke <a href="http://opml.org/" target="_blank">berkas OPML</a> untuk memasukkan umpan ke kategori ini secara dinamis',
		),
		'empty' => 'Kategori kosong',
		'expand' => 'Kembangkan kategori',
		'information' => 'Informasi',
		'open' => 'Buka kategori',
		'opml_url' => 'URL OPML',
		'position' => 'Posisi tampilan',
		'position_help' => 'Untuk mengatur urutan pengurutan kategori',
		'title' => 'Judul',
	),
	'feed' => array(
		'accept_cookies' => 'Terima kuki',
		'accept_cookies_help' => 'Perbolehkan peladen umpan untuk mengirimkan kuki (hanya disimpan di memori selama durasi permintaan)',
		'add' => 'Tambah umpan',
		'advanced' => 'Lebih lanjut',
		'archiving' => 'Pengarsipan',
		'auth' => array(
			'configuration' => 'Masuk',
			'help' => 'Agar dapat bisa mengakses umpan RSS yang dilindungi oleh autentikasi HTTP',
			'http' => 'Autentikasi HTTP',
			'password' => 'Kata sandi HTTP',
			'username' => 'Nama pengguna HTTP',
		),
		'change_favicon' => 'Ubah…',
		'clear_cache' => 'Selalu bersihkan tembolok',
		'content_action' => array(
			'_' => 'Yang dilakukan ketika mengambil konten artikel',
			'append' => 'Tambahkan setelah konten yang telah ada',
			'prepend' => 'Tambahkan sebelum konten yang telah ada',
			'replace' => 'Timpa konten yang telah ada',
		),
		'content_retrieval' => 'Pengambilan konten',
		'css_cookie' => 'Gunakan kuki ketika mengambil konten artikel',
		'css_cookie_help' => 'Contoh: <kbd>foo=bar; gdpr_consent=true; cookie=value</kbd>',
		'css_help' => 'Mengambil bagian artikel sesuai CSS yang dimasukkan (awas, memerlukan lebih banyak waktu!)',
		'css_path' => 'Pemilihan CSS artikel di situs aslinya',
		'css_path_filter' => array(
			'_' => 'Pemilihan CSS artikel untuk konten yang akan dihapus',
			'help' => 'Pemilihan CSS bisa juga berupa daftar seperti: <kbd>footer, aside, p[data-sanitized-class~="menu"]</kbd>',
		),
		'description' => 'Deskripsi',
		'empty' => 'Umpan ini kosong. Periksa apakah umpan ini masih ada',
		'error' => 'Ada masalah dengan umpan ini. Jika masih terus-menerus, periksa apakah umpan ini masih ada.',
		'export-as-opml' => array(
			'download' => 'Unduh',
			'help' => 'Berkas XML (subset data. <a href="https://freshrss.github.io/FreshRSS/en/developers/OPML.html" target="_blank">Lihat dokumentasi</a>)',
			'label' => 'Unduh dalam bentuk OPML',
		),
		'ext_favicon' => 'Atur secara otomatis',
		'favicon_changed_by_ext' => 'Ikon telah diatur oleh ekstensi <b>%s</b>.',
		'filteractions' => array(
			'_' => 'Tindakan penyaringan',
			'help' => 'Tulis satu penyaringan pencarian per baris. Operator <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">lihat dokumentasi</a>.',
		),
		'http_headers' => 'Tajuk HTTP',
		'http_headers_help' => 'Tajuk dipisahkan dengan baris baru dan nama dan nilai dari tajuk dipisahkan dengan titik dua (contoh: <kbd><code>Accept: application/atom+xml<br />Authorization: Bearer some-token</code></kbd>).',
		'icon' => 'Ikon',
		'information' => 'Informasi',
		'keep_min' => 'Jumlah minimum artikel yang harus disimpan',
		'kind' => array(
			'_' => 'Jenis sumber umpan',
			'html_json' => array(
				'_' => 'HTML + XPath + notasi dot JSON (JSON dalam HTML)',
				'xpath' => array(
					'_' => 'XPath untuk JSON dalam HTML',
					'help' => 'Contoh: <code>normalize-space(//script[@type="application/json"])</code> (satu JSON)<br />atau: <code>//script[@type="application/ld+json"]</code> (satu objek JSON per artikel)',
				),
			),
			'html_xpath' => array(
				'_' => 'HTML + XPath (Pengorekan web)',
				'feed_title' => array(
					'_' => 'judul umpan',
					'help' => 'Contoh: <code>//title</code> atau kata statis: <code>"Umpan Saya"</code>',
				),
				'help' => '<dfn><a href="https://www.w3.org/TR/xpath-10/" target="_blank">XPath 1.0</a></dfn> adalah bahasa kueri standar untuk pengguna tingkat lanjut dan yang mana FreshRSS dukung untuk dikorek.',
				'item' => array(
					'_' => 'mencari <strong>item</strong> artikel<br /><small>(paling penting)</small>',
					'help' => 'Contoh: <code>//div[@class="news-item"]</code>',
				),
				'item_author' => array(
					'_' => 'penulis',
					'help' => 'Bisa juga kata statis. Contoh: <code>"Anonymous"</code>',
				),
				'item_categories' => 'label',
				'item_content' => array(
					'_' => 'konten',
					'help' => 'Contoh untuk mengambil konten penuh: <code>.</code>',
				),
				'item_thumbnail' => array(
					'_' => 'keluku',
					'help' => 'Contoh: <code>descendant::img/@src</code>',
				),
				'item_timeFormat' => array(
					'_' => 'Format tanggal dan waktu kustom',
					'help' => 'Opsional. Format yang didukung oleh <a href="https://php.net/datetime.createfromformat" target="_blank"><code>DateTime::createFromFormat()</code></a> seperti <code>d-m-Y H:i:s</code>',
				),
				'item_timestamp' => array(
					'_' => 'tanggal',
					'help' => 'Hasil akan diproses oleh <a href="https://php.net/strtotime" target="_blank"><code>strtotime()</code></a>',
				),
				'item_title' => array(
					'_' => 'judul',
					'help' => 'Gunakan khususnya <a href="https://developer.mozilla.org/docs/Web/XPath/Axes" target="_blank">XPath axis</a> <code>descendant::</code> seperti <code>descendant::h2</code>',
				),
				'item_uid' => array(
					'_' => 'ID unik',
					'help' => 'Opsional. Contoh: <code>descendant::div/@data-uri</code>',
				),
				'item_uri' => array(
					'_' => 'tautan artikel (URL)',
					'help' => 'Contoh: <code>descendant::a/@href</code>',
				),
				'relative' => 'XPath (relatif ke item) untuk:',
				'xpath' => 'XPath untuk:',
			),
			'json_dotnotation' => array(
				'_' => 'JSON (notasi dot)',
				'feed_title' => array(
					'_' => 'judul umpan',
					'help' => 'Contoh: <code>meta.title</code> atau kata statis: <code>"Umpan Saya"</code>',
				),
				'help' => 'Notasi dot JSON menggunakan dot (titik) antara objek dan kurung untuk array. Contoh <code>data.items[0].title</code>',
				'item' => array(
					'_' => 'mencari <strong>item</strong> artikel<br /><small>(paling penting)</small>',
					'help' => 'Jalur JSON ke array yang mengandung item tersebut, contoh: <code>$</code> atau <code>newsItems</code>',
				),
				'item_author' => 'penulis',
				'item_categories' => 'label',
				'item_content' => array(
					'_' => 'konten',
					'help' => 'Objek dimana konten ditemukan <code>content</code>',
				),
				'item_thumbnail' => array(
					'_' => 'keluku',
					'help' => 'Contoh: <code>image</code>',
				),
				'item_timeFormat' => array(
					'_' => 'Format tanggal dan waktu kustom',
					'help' => 'Opsional. Format yang didukung oleh <a href="https://php.net/datetime.createfromformat" target="_blank"><code>DateTime::createFromFormat()</code></a> seperti <code>d-m-Y H:i:s</code>',
				),
				'item_timestamp' => array(
					'_' => 'tanggal',
					'help' => 'Hasil akan diproses oleh <a href="https://php.net/strtotime" target="_blank"><code>strtotime()</code></a>',
				),
				'item_title' => 'judul',
				'item_uid' => 'ID unik',
				'item_uri' => array(
					'_' => 'tautan artikel (URL)',
					'help' => 'Contoh: <code>permalink</code>',
				),
				'json' => 'notasi dot untuk:',
				'relative' => 'jalur notasi dot (relatif ke item) untuk:',
			),
			'jsonfeed' => 'Umpan JSON',
			'rss' => 'RSS / Atom (baku)',
			'xml_xpath' => 'XML + XPath',	// IGNORE
		),
		'maintenance' => array(
			'clear_cache' => 'Bersihkan tembolok',
			'clear_cache_help' => 'Bersihkan tembolok untuk umpan ini.',
			'reload_articles' => 'Muat ulang artikel',
			'reload_articles_help' => 'Muat ulang artikel sesuai angka yang dimasukkan dan ambil konten lengkap jika pemilihan diberikan.',
			'title' => 'Pemeliharaan',
		),
		'max_http_redir' => 'Maksimum pengalihan HTTP',
		'max_http_redir_help' => 'Atur ke 0 atau biarkan kosong untuk menonaktifkannya, -1 untuk pengalihan tak terhingga.',
		'method' => array(
			'_' => 'Metode HTTP',
		),
		'method_help' => 'Metode jaringan POST memiliki dukungan otomatis untuk <code>application/x-www-form-urlencoded</code> dan <code>application/json</code>',
		'method_postparams' => 'Metode untuk POST',
		'moved_category_deleted' => 'Ketika Anda menghapus sebuah kategori, umpan yang ada di dalamnya secara otomatis akan berada di bawah <em>%s</em>.',
		'mute' => array(
			'_' => 'bisukan',
			'state_is_muted' => 'Umpan ini dibisukan',
		),
		'no_selected' => 'Tidak ada umpan yang dipilih.',
		'number_entries' => '%d artikel',
		'open_feed' => 'Buka umpan %s',
		'path_entries_conditions' => 'Kondisi untuk pengambilan konten',
		'priority' => array(
			'_' => 'Ketampakan',
			'archived' => 'Jangan tampilkan (diarsipkan)',
			'category' => 'Tampilkan hanya di kategorinya saja',
			'important' => 'Tampilkan di umpan penting',
			'main_stream' => 'Tampilkan di bagian utama',
		),
		'proxy' => 'Atur proksi untuk mengambil umpan ini',
		'proxy_help' => 'Pilih protokol (contoh: SOCKS5) dan masukkan alamat proksi (contoh: <kbd>127.0.0.1:1080</kbd> atau <kbd>username:password@127.0.0.1:1080</kbd>)',
		'reset_favicon' => 'Atur ulang ke yang baku',
		'selector_preview' => array(
			'show_raw' => 'Tampilkan kode sumber',
			'show_rendered' => 'Tampilkan konten',
		),
		'show' => array(
			'all' => 'Semua umpan',
			'error' => 'Tampilkan hanya umpan dengan galat',
		),
		'showing' => array(
			'error' => 'Menampilkan hanya umpan dengan galat',
		),
		'ssl_verify' => 'Verifikasi keamanan SSL',
		'stats' => 'Statistik',
		'think_to_add' => 'Kamu boleh menambahkan beberapa umpan.',
		'timeout' => 'Timeout dalam detik',
		'title' => 'Judul',
		'title_add' => 'Tambah umpan RSS',
		'ttl' => 'Jangan perbarui secara otomatis lebih banyak daripada',
		'unicityCriteria' => array(
			'_' => 'Kriteria keunikan artikel',
			'forced' => '<span title="Blokir kriteria keunikan meski umpan memiliki artikel duplikat">paksa</span>',
			'help' => 'Relevan untuk umpan yang tidak valid.<br />⚠️ Mengubah ini akan membuat artikel duplikat.',
			'id' => 'ID standar (baku)',
			'link' => 'Tautan',
			'sha1:content' => 'Konten',
			'sha1:content_published' => 'Konten + Tanggal',
			'sha1:link_published' => 'Tautan + Tanggal',
			'sha1:link_published_title' => 'Tautan + Tanggal + Judul',
			'sha1:link_published_title_content' => 'Tautan + Tanggal + Judul + Konten',
			'sha1:published' => 'Tanggal',
			'sha1:title' => 'Judul',
			'sha1:title_published' => 'Judul + Tanggal',
			'sha1:title_published_content' => 'Judul + Tanggal + Konten',
		),
		'url' => 'URL umpan',
		'useragent' => 'Atur UA (user agent) untuk mengambil umpan ini',
		'useragent_help' => 'Contoh: <kbd>Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:86.0)</kbd>',
		'validator' => 'Periksa validitas umpan ini',
		'website' => 'URL situs',
		'websub' => 'Notifikasi langsung menggunakan WebSub',
	),
	'import_export' => array(
		'export' => array(
			'_' => 'Ekspor',
			'sqlite' => 'Unduh basis data pengguna dalam bentuk SQLite',
		),
		'export_labelled' => 'Ekspor artikel yang dilabelkan',
		'export_opml' => 'Ekspor daftar umpan (OPML)',
		'export_starred' => 'Ekspor favorit Anda',
		'feed_list' => 'Daftar dari %s artikel',
		'file_to_import' => 'Berkas untuk diimpor <br />(OPML, JSON atau ZIP)',
		'file_to_import_no_zip' => 'Berkas untuk diimpor<br />(OPML atau JSON)',
		'import' => 'Impot',
		'starred_list' => 'Daftar artikel difavoritkan',
		'title' => 'Impor / Ekspor',
	),
	'menu' => array(
		'add' => 'Tambah umpan atau kategori',
		'import_export' => 'Impor / Ekspor',
		'label_management' => 'Pengelolaan label',
		'stats' => array(
			'idle' => 'Umpan tak terbarukan',
			'main' => 'Statistik utama',
			'repartition' => 'Pengkategorian artikel',
		),
		'subscription_management' => 'Pengelolaan langganan',
		'subscription_tools' => 'Alat langganan',
	),
	'tag' => array(
		'auto_label' => 'Tambahkan label ini ke artikel baru',
		'name' => 'Nama',
		'new_name' => 'Nama baru',
		'old_name' => 'Nama lama',
	),
	'title' => array(
		'_' => 'Pengelolaan langganan',
		'add' => 'Tambah umpan atau kategori',
		'add_category' => 'Tambah kategori',
		'add_dynamic_opml' => 'Tambah OPML dinamis',
		'add_feed' => 'Tambah umpan',
		'add_label' => 'Tambah label',
		'add_opml_category' => 'Nama kategori OPML',
		'delete_label' => 'Hapus label',
		'feed_management' => 'Pengelolaan umpan RSS',
		'rename_label' => 'Ubah nama label',
		'subscription_tools' => 'Alat langganan',
	),
);
