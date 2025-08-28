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
	'access' => array(
		'denied' => 'Anda tidak memiliki izin untuk mengakses halaman ini',
		'not_found' => 'Halaman ini tidak ada',
	),
	'admin' => array(
		'optimization_complete' => 'Optimalisasi selesai',
	),
	'api' => array(
		'password' => array(
			'failed' => 'Kata sandi Anda tidak dapat diubah',
			'updated' => 'Kata sandi Anda telah diubah',
		),
	),
	'auth' => array(
		'login' => array(
			'invalid' => 'Tidak valid',
			'success' => 'Sudah terhubung',
		),
		'logout' => array(
			'success' => 'Terputus',
		),
	),
	'conf' => array(
		'error' => 'Galat terjadi ketika menyimpan konfigurasi',
		'query_created' => 'Kueri “%s” telah dibuat.',
		'shortcuts_updated' => 'Pintasan telah diperbarui',
		'updated' => 'Konfigurasi telah diperbarui',
	),
	'extensions' => array(
		'already_enabled' => '%s telah diaktifkan',
		'cannot_remove' => '%s tidak dapat dihapus',
		'disable' => array(
			'ko' => '%s tidak dapat dinonaktifkan. <a href="%s">Periksa log FreshRSS</a> untuk informasi lebih lanjut.',
			'ok' => '%s telah dinonaktifkan',
		),
		'enable' => array(
			'ko' => '%s tidak dapat diaktifkan. <a href="%s">Periksa log FreshRSS</a> untuk informasi lebih lanjut.',
			'ok' => '%s telah diaktifkan',
		),
		'invalid_view_mode' => 'Mode tampilan tidak valid “%s”! Balik ke “Tampilan normal”.',
		'no_access' => 'Anda tidak memiliki akses ke %s',
		'not_enabled' => '%s tidak diaktifkan',
		'not_found' => '%s tidak ada',
		'removed' => '%s dihapus',
	),
	'import_export' => array(
		'export_no_zip_extension' => 'Ekstensi ZIP tidak tersedia di peladen Anda. Coba untuk mengekspor berkasnya satu per satu.',
		'feeds_imported' => 'Umpan Anda telah diimpor. Jika Anda sudah selesai mengimpor, Anda bisa mengklik tombol <i>Perbarui umpan</i>.',
		'feeds_imported_with_errors' => 'Umpan Anda telah diimpor, tapi ada beberapa galat. Jika Anda sudah selesai mengimpor, Anda bisa mengklik tombol <i>Perbarui umpan</i>.',
		'file_cannot_be_uploaded' => 'Berkas tidak dapt diunggah!',
		'no_zip_extension' => 'Ekstensi ZIP tidak tersedia di peladen Anda.',
		'zip_error' => 'Galat terjadi ketika pemrosesan ZIP.',
	),
	'profile' => array(
		'error' => 'Profil Anda tidak dapat diubah',
		'passwords_dont_match' => 'Passwords don’t match',	// TODO
		'updated' => 'Profil Anda telah diubah',
	),
	'sub' => array(
		'actualize' => 'Memperbarui',
		'articles' => array(
			'marked_read' => 'Artikel yang dipilih telah ditandai sebagai sudah dibaca',
			'marked_unread' => 'Artikel telah ditandai sebagai belum dibaca',
		),
		'category' => array(
			'created' => 'Kategori %s telah dibuat.',
			'deleted' => 'Kategori telah dihapus.',
			'emptied' => 'Kategori telah dikosongkan',
			'error' => 'Kategori tidak dapat diperbarui',
			'name_exists' => 'Nama kategori sudah ada.',
			'no_id' => 'You must specify the id of the category.',	// TODO
			'no_name' => 'Nama kategori tidak boleh kosong.',
			'not_delete_default' => 'Tidak dapat menghapus kategori baku!',
			'not_exist' => 'Kategori ini tidak ada!',
			'over_max' => 'Batas kategori Anda sudah tercapai (%d)',
			'updated' => 'Kategori ini telah diperbarui.',
		),
		'feed' => array(
			'actualized' => '<em>%s</em> telah diperbarui',
			'actualizeds' => 'Umpan RSS telah diperbarui',
			'added' => 'Umpan RSS <em>%s</em> telah ditambahkan',
			'already_subscribed' => 'Anda telah berlangganan ke <em>%s</em>',
			'cache_cleared' => 'Tembolok <em>%s</em> telah dikosongkan',
			'deleted' => 'Umpan telah dihapus',
			'error' => 'Umpan tidak dapat diperbarui',
			'favicon' => array(
				'too_large' => 'Ikon yang diunggah terlalu besar. Ukuran maksimal berkas adalah <em>%s</em>.',
				'unsupported_format' => 'Format gambar tidak didukung!',
			),
			'internal_problem' => 'Umpan tidak dapat ditambahkan. <a href="%s">Periksa log FreshRSS</a> untuk informasi lebih lanjut. Anda bisa memaksa penambahan dengan menambahkan <code>#force_feed</code> ke URL.',
			'invalid_url' => 'URL <em>%s</em> tidak valid',
			'n_actualized' => '%d umpan telah diperbarui',
			'n_entries_deleted' => '%d artikel telah dihapus',
			'no_refresh' => 'Tidak ada umpan untuk disegarkan',
			'not_added' => '<em>%s</em> tidak dapat ditambahkan',
			'not_found' => 'Umpan tidak dapat ditemukan',
			'over_max' => 'Anda telah mencapai batas umpan Anda (%d)',
			'reloaded' => '<em>%s</em> telah dimuat ulang',
			'selector_preview' => array(
				'http_error' => 'Tidak dapat memuat konten situs.',
				'no_entries' => 'Tidak ada artikel di umpan ini. Anda harus paling tidak memiliki satu artikel untuk membuat tinjauan.',
				'no_feed' => 'Galat internal (umpan tidak dapat ditemukan).',
				'no_result' => 'Pemilihan tidak cocok dengan apapun. Sebagai ganti, teks umpan aslinya akan ditampilkan di sini.',
				'selector_empty' => 'Pemilihan kosong. Anda harus paling tidak memasukkan satu untuk membuat tinjauan.',
			),
			'updated' => 'Umpan telah diperbarui',
		),
		'purge_completed' => 'Selesai penghapusan (%d artikel dihapus)',
	),
	'tag' => array(
		'created' => 'Label “%s” telah dibuat.',
		'error' => 'Label tidak dapat diperbarui!',
		'name_exists' => 'Label telah ada.',
		'renamed' => 'Label “%s” telah dinamai ulang ke “%s”.',
		'updated' => 'Label telah diperbarui.',
	),
	'update' => array(
		'can_apply' => 'Pembaruan FreshRSS tersedia: <strong>Versi %s</strong>.',
		'error' => 'Galat terjadi dalam proses pembaruan: %s',
		'file_is_nok' => 'Pembaruan FreshRSS tersedia (<strong>Versi %s</strong>), but check permissions on <em>%s</em> directory. HTTP server must have have write permission , dan periksa izin di direktori <em>%s</em>. Peladen HTTP harus memiliki izin menulis di direktori tersebut',
		'finished' => 'Pembaruan selesai!',
		'none' => 'Tidak ada pembaruan yang tersedia',
		'server_not_found' => 'Peladen pembaruan tidak dapat ditemukan. [%s]',
	),
	'user' => array(
		'created' => array(
			'_' => 'Pengguna %s telah dibuat',
			'error' => 'Pengguna %s tidak dapat dibuat',
		),
		'deleted' => array(
			'_' => 'Pengguna %s telah dihapus',
			'error' => 'Pengguna %s tidak dapat dihapus',
		),
		'updated' => array(
			'_' => 'Pengguna %s telah diperbarui',
			'error' => 'Pengguna %s tidak dapat diperbarui',
		),
	),
);
