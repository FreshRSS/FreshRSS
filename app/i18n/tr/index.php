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
		'bugs_reports' => 'Hata raporu',
		'credits' => 'Tanıtım',
		'credits_content' => 'Bu frameworkü kullanmamasına rağmen FreshRSS bazı tasarım ögelerini <a href="http://twitter.github.io/bootstrap/">Bootstrap</a> dan almıştır. <a href="https://gitlab.gnome.org/Archive/gnome-icon-theme-symbolic">İkonlar</a> <a href="https://www.gnome.org/">GNOME projesinden</a> alınmıştır. <em>Open Sans</em> yazı tipi <a href="https://fonts.google.com/specimen/Open+Sans">Steve Matteson</a> tarafından oluşturulmuştur. FreshRSS bir PHP framework olan <a href="https://framagit.org/marienfressinaud/MINZ">Minz</a> i temel alır.',
		'documentation' => 'Documentation',	// TODO
		'freshrss_description' => 'FreshRSS kendi hostunuzda çalışan bir RSS akış toplayıcısıdır. Güçlü ve yapılandırılabilir araçlarıyla basit ve kullanımı kolay bir uygulamadır.',
		'github' => '<a href="https://github.com/FreshRSS/FreshRSS/issues">Github sayfası</a>',
		'license' => 'Lisans',
		'project_website' => 'Proje sayfası',
		'title' => 'Hakkında',
		'version' => 'Sürüm',
	),
	'feed' => array(
		'add' => 'Akış ekleyebilirsin.',
		'empty' => 'Gösterilecek makale yok.',
		'rss_of' => '%s kaynağına ait RSS akışı',
		'title' => 'Ana akış',
		'title_fav' => 'Favoriler',
		'title_global' => 'Evrensel görünüm',
	),
	'log' => array(
		'_' => 'Log Kayıtları',
		'clear' => 'Log kayıt dosyasını temizle',
		'empty' => 'Log kayır dosyası boş',
		'title' => 'Log Kayıtları',
	),
	'menu' => array(
		'about' => 'FreshRSS hakkında',
		'before_one_day' => 'Bir gün önce',
		'before_one_week' => 'Bir hafta önce',
		'bookmark_query' => 'Şuana ait yer imi sorgusu',
		'favorites' => 'Favoriler (%s)',
		'global_view' => 'Evrensel görünüm',
		'main_stream' => 'Ana akış',
		'mark_all_read' => 'Hepsini okundu olarak işaretle',
		'mark_cat_read' => 'Kategoriyi okundu olarak işaretle',
		'mark_feed_read' => 'Akışı okundu olarak işaretle',
		'mark_selection_unread' => 'Seçilenleri okunmadı olarak işaretleMark selection as unread',
		'newer_first' => 'Önce yeniler',
		'non-starred' => 'Favori dışındakileri göster',
		'normal_view' => 'Normal görünüm',
		'older_first' => 'Önce eskiler',
		'queries' => 'Kullanıcı sorguları',
		'read' => 'Okunmuşları göster',
		'reader_view' => 'Okuma görünümü',
		'rss_view' => 'RSS akışı',
		'search_short' => 'Ara',
		'starred' => 'Favorileri göster',
		'stats' => 'İstatistikler',
		'subscription' => 'Abonelik yönetimi',
		'tags' => 'Etiketlerim',
		'unread' => 'Okunmamışları göster',
	),
	'share' => 'Paylaş',
	'tag' => array(
		'related' => 'İlgili etiketler',
	),
	'tos' => array(
		'title' => 'Hizmet Kullanım Şartları',
	),
);
