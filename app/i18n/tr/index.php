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
		'_' => 'Hakkında',
		'agpl3' => '<a href="https://www.gnu.org/licenses/agpl-3.0.html">AGPL 3</a>',	// IGNORE
		'bug_reports' => array(
			'environment_information' => array(
				'_' => 'Sistem bilgileri',
				'browser' => 'Tarayıcı',
				'database' => 'Veritabanı',
				'server_software' => 'Sunucu yazılımı',
				'version_curl' => 'cURL sürümü',
				'version_frss' => 'FreshRSS sürümü',
				'version_php' => 'PHP sürümü',
			),
		),
		'bugs_reports' => 'Hata raporları',
		'documentation' => 'Belgeler',
		'freshrss_description' => 'FreshRSS, kendi sunucunuzda barındırabileceğiniz bir RSS toplayıcı ve okuyucudur. Birden fazla haber sitesini tek bir bakışta okuyup takip etmenizi sağlar, böylece siteler arasında gezinmenize gerek kalmaz. FreshRSS hafif, yapılandırılabilir ve kullanımı kolaydır.',
		'github' => '<a href="https://github.com/FreshRSS/FreshRSS/issues">GitHub üzerinde</a>',
		'license' => 'Lisans',
		'project_website' => 'Proje web sitesi',
		'title' => 'Hakkında',
		'version' => 'Sürüm',
	),
	'feed' => array(
		'empty' => 'Gösterilecek makale yok.',
		'received' => array(
			'before_yesterday' => 'Dünden önceki gün alınanlar',
			'today' => 'Bugün alınanlar',
			'yesterday' => 'Dün alınanlar',
		),
		'rss_of' => '%s’nin RSS beslemesi',
		'title' => 'Ana akış',
		'title_fav' => 'Favoriler',
		'title_global' => 'Genel görünüm',
	),
	'log' => array(
		'_' => 'Günlükler',
		'clear' => 'Günlükleri temizle',
		'empty' => 'Günlük dosyası boş',
		'title' => 'Günlükler',
	),
	'menu' => array(
		'about' => 'FreshRSS Hakkında',
		'before_one_day' => 'Bir günden eski',
		'before_one_week' => 'Bir haftadan eski',
		'bookmark_query' => 'Geçerli sorguyu yer imlerine ekle',
		'favorites' => 'Favoriler (%s)',
		'global_view' => 'Genel görünüm',
		'important' => 'Önemli beslemeler',
		'main_stream' => 'Ana akış',
		'mark_all_read' => 'Tümünü okundu olarak işaretle',
		'mark_cat_read' => 'Kategoriyi okundu olarak işaretle',
		'mark_feed_read' => 'Beslemeyi okundu olarak işaretle',
		'mark_selection_unread' => 'Seçimi okunmadı olarak işaretle',
		'mylabels' => 'Etiketlerim',
		'newer_first' => 'Önce yeniler',
		'non-starred' => 'Favori olmayanları göster',
		'normal_view' => 'Normal görünüm',
		'older_first' => 'Önce eskiler',
		'queries' => 'Kullanıcı sorguları',
		'read' => 'Okunanları göster',
		'reader_view' => 'Okuma görünümü',
		'rss_view' => 'RSS beslemesi',
		'search_short' => 'Ara',
		'sort' => array(
			'_' => 'Sıralama kriteri',
			'c' => array(
				'name_asc' => 'Category, feed titles A→Z',	// TODO
				'name_desc' => 'Category, feed titles Z→A',	// TODO
			),
			'date_asc' => 'Yayın tarihi 1→9',
			'date_desc' => 'Yayın tarihi 9→1',
			'f' => array(
				'name_asc' => 'Feed title A→Z',	// TODO
				'name_desc' => 'Feed title Z→A',	// TODO
			),
			'id_asc' => 'Son alınanlar en sonda',
			'id_desc' => 'Son alınanlar başta',
			'link_asc' => 'Bağlantı A→Z',
			'link_desc' => 'Bağlantı Z→A',
			'rand' => 'Rastgele sıralama',
			'title_asc' => 'Başlık A→Z',
			'title_desc' => 'Başlık Z→A',
		),
		'starred' => 'Favorileri göster',
		'stats' => 'İstatistikler',
		'subscription' => 'Abonelik yönetimi',
		'unread' => 'Okunmayanları göster',
	),
	'share' => 'Paylaş',
	'tag' => array(
		'related' => 'Makale etiketleri',
	),
	'tos' => array(
		'title' => 'Hizmet Şartları',
	),
);
