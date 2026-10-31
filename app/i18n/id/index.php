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
	'about' => array(
		'_' => 'Tentang',
		'agpl3' => '<a href="https://www.gnu.org/licenses/agpl-3.0.html">AGPL 3</a>',	// IGNORE
		'bug_reports' => array(
			'environment_information' => array(
				'_' => 'Informasi sistem',
				'browser' => 'Browser',	// IGNORE
				'database' => 'Basis data',
				'server_software' => 'Aplikasi server',
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
		'published' => array(
			'_' => 'Diterbitkan',
			'future' => 'Diterbitkan di masa mendatang',
			'today' => 'Diterbitkan hari ini',
			'yesterday' => 'Diterbitkan kemarin',
		),
		'received' => array(
			'_' => 'Diterima',
			'today' => 'Diterima hari ini',
			'yesterday' => 'Diterima kemarin',
		),
		'rss_of' => 'Umpan RSS untuk %s',
		'title' => 'Bagian Utama',
		'title_fav' => 'Favorit',
		'title_global' => 'Tampilan Global',
		'userModified' => array(
			'_' => 'Diubah oleh pengguna',
			'today' => 'Diubah oleh pengguna hari ini',
			'yesterday' => 'Diubah oleh pengguna kemarin',
		),
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
		'non-starred' => 'Tampilkan yang tidak difavoritkan',
		'normal_view' => 'Tampilan Normal',
		'queries' => 'Pencarian pengguna',
		'read' => 'Tampilkan yang sudah dibaca',
		'reader_view' => 'Tampilan Membaca',
		'rss_view' => 'Umpan RSS',
		'search_short' => 'Cari',
		'sort' => array(
			'asc' => 'Naik',
			'c' => array(
				'name_asc' => 'Kategori, judul umpan A→Z',
				'name_desc' => 'Kategori, judul umpan Z→A',
			),
			'date_asc' => 'Tanggal publikasi 1→9',
			'date_desc' => 'Tanggal publikasi 9→1',
			'desc' => 'Turun',
			'f' => array(
				'name_asc' => 'Judul umpan A→Z',
				'name_desc' => 'Judul umpan Z→A',
			),
			'id_asc' => 'Yang baru diterima terakhir',
			'id_desc' => 'Yang baru diterima paling awal',
			'length_asc' => 'Panjang konten 1→9',
			'length_desc' => 'Panjang konten 9→1',
			'link_asc' => 'Tautan A→Z',
			'link_desc' => 'Tautan Z→A',
			'primary' => array(
				'_' => 'Kriteria pengurutan',
				'help' => 'Pengurutan berdasarkan tanggal <em>diterima</em> disarankan untuk sebagian besar kasus, demi konsistensi dan performa',
			),
			'rand' => 'Acak',
			'secondary' => array(
				'_' => 'Kriteria pengurutan sekunder',
				'help' => 'Hanya relevan bila kriteria pengurutan utama adalah kategori atau judul umpan',
			),
			'title_asc' => 'Judul A→Z',
			'title_desc' => 'Judul Z→A',
			'user_modified_asc' => 'Diubah pengguna 1→9',
			'user_modified_desc' => 'Diubah pengguna 9→1',
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
