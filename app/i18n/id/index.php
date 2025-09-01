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
	'about' => array(
		'_' => 'Tentang',
		'agpl3' => '<a href="https://www.gnu.org/licenses/agpl-3.0.html">AGPL 3</a>',	// IGNORE
		'bug_reports' => array(
			'environment_information' => array(
				'_' => 'Informasi sistem',
				'browser' => 'Peladen',
				'database' => 'Basis data',
				'server_software' => 'Aplikasi peladen',
				'version_curl' => 'versi cURL',
				'version_frss' => 'versi FreshRSS',
				'version_php' => 'versi PHP',
			),
		),
		'bugs_reports' => 'Laporan kutu',
		'documentation' => 'Dokumentasi',
		'freshrss_description' => 'FreshRSS adalah pembaca dan pengumpul RSS yang bisa dihos sendiri. Ini memungkinkan Anda untuk membaca dan mengikuti beberapa situs berita dengan sekilas tanpa menjelajahi dari satu situs ke situs lainnya. FreshRSS itu ringan, gampang dikonfigurasi, dan mudah untuk digunakan.',
		'github' => '<a href="https://github.com/FreshRSS/FreshRSS/issues">di GitHub</a>',
		'license' => 'Lisensi',
		'project_website' => 'Situs FreshRSS',
		'title' => 'Tentang',
		'version' => 'Versi',
	),
	'feed' => array(
		'empty' => 'Tidak ada artikel untuk diperlihatkan.',
		'received' => array(
			'before_yesterday' => 'Diterima sebelum kemarin',
			'today' => 'Diterima hari ini',
			'yesterday' => 'Diterima kemarin',
		),
		'rss_of' => 'Umpan RSS untuk %s',
		'title' => 'Bagian Utama',
		'title_fav' => 'Favorit',
		'title_global' => 'Tampilan Global',
	),
	'log' => array(
		'_' => 'Log',
		'clear' => 'Bersihkan log',
		'empty' => 'Berkas log kosong',
		'title' => 'Log',
	),
	'menu' => array(
		'about' => 'Tentang FreshRSS',
		'before_one_day' => 'Lebih lama dari satu hari',
		'before_one_week' => 'Lebih lama dari satu minggu',
		'bookmark_query' => 'Markah pencarian saat ini',
		'favorites' => 'Favorit (%s)',
		'global_view' => 'Tampilan Global',
		'important' => 'Umpan Penting',
		'main_stream' => 'Bagian Utama',
		'mark_all_read' => 'Tandai semua sebagai sudah dibaca',
		'mark_cat_read' => 'Tandai kategori sebagai sudah dibaca',
		'mark_feed_read' => 'Tandai umpan sebagai sudah dibaca',
		'mark_selection_unread' => 'Tandai yang dipilih sebagai belum dibaca',
		'mylabels' => 'Label Saya',
		'newer_first' => 'Yang terbaru dulu',
		'non-starred' => 'Tampilkan yang tidak difavoritkan',
		'normal_view' => 'Tampilan Normal',
		'older_first' => 'Yang terlama dulu',
		'queries' => 'Pencarian pengguna',
		'read' => 'Tampilkan yang sudah dibaca',
		'reader_view' => 'Tampilan Membaca',
		'rss_view' => 'Umpan RSS',
		'search_short' => 'Cari',
		'sort' => array(
			'_' => 'Kriteria pengurutan',
			'c' => array(
				'name_asc' => 'Category, feed titles A→Z',	// TODO
				'name_desc' => 'Category, feed titles Z→A',	// TODO
			),
			'date_asc' => 'Tanggal publikasi 1→9',
			'date_desc' => 'Tanggal publikasi 9→1',
			'f' => array(
				'name_asc' => 'Feed title A→Z',	// TODO
				'name_desc' => 'Feed title Z→A',	// TODO
			),
			'id_asc' => 'Yang baru diterima terakhir',
			'id_desc' => 'Yang baru diterima paling awal',
			'link_asc' => 'Tautan A→Z',
			'link_desc' => 'Tautan Z→A',
			'rand' => 'Acak',
			'title_asc' => 'Judul A→Z',
			'title_desc' => 'Judul Z→A',
		),
		'starred' => 'Tampilkan yang difavoritkan',
		'stats' => 'Statistik',
		'subscription' => 'Pengelolaan Langganan',
		'unread' => 'Tampilkan yang belum dibaca',
	),
	'share' => 'Bagikan',
	'tag' => array(
		'related' => 'Tagar artikel',
	),
	'tos' => array(
		'title' => 'Ketentuan Layanan',
	),
);
