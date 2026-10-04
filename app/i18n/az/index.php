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
		'_' => 'Haqqında',
		'agpl3' => '<a href="https://www.gnu.org/licenses/agpl-3.0.html">AGPL 3</a>',	// IGNORE
		'bug_reports' => array(
			'environment_information' => array(
				'_' => 'Sistem məlumatı',
				'browser' => 'Brauzer',
				'database' => 'Verilənlər bazası',
				'server_software' => 'Server proqram təminatı',
				'version_curl' => 'cURL versiyası',
				'version_frss' => 'FreshRSS versiyası',
				'version_php' => 'PHP versiyası',
			),
		),
		'bugs_reports' => 'Xəta hesabatları',
		'documentation' => 'Sənədlər',
		'freshrss_description' => 'FreshRSS öz serverinizdə saxlaya biləcəyiniz RSS toplayıcısı və oxucusudur. O, bir veb saytdan digərinə keçmədən bir neçə xəbər saytını bir baxışda oxumağa və izləməyə imkan verir. FreshRSS yüngüldür, tənzimlənəndir və istifadəsi asandır.',
		'github' => '<a href="https://github.com/FreshRSS/FreshRSS/issues">GitHub-da</a>',
		'license' => 'Lisenziya',
		'project_website' => 'Layihənin veb saytı',
		'title' => 'Haqqında',
		'version' => 'Versiya',
	),
	'feed' => array(
		'empty' => 'Göstəriləcək məqalə yoxdur.',
		'published' => array(
			'_' => 'Dərc edilib',
			'future' => 'Gələcəkdə dərc edilib',
			'today' => 'Bu gün dərc edilib',
			'yesterday' => 'Dünən dərc edilib',
		),
		'received' => array(
			'_' => 'Alınıb',
			'today' => 'Bu gün alınıb',
			'yesterday' => 'Dünən alınıb',
		),
		'rss_of' => '%s üçün RSS lenti',
		'title' => 'Əsas axın',
		'title_fav' => 'Seçilmişlər',
		'title_global' => 'Qlobal görünüş',
		'userModified' => array(
			'_' => 'İstifadəçi dəyişib',
			'today' => 'İstifadəçi bu gün dəyişib',
			'yesterday' => 'İstifadəçi dünən dəyişib',
		),
	),
	'log' => array(
		'_' => 'Jurnallar',
		'clear' => 'Jurnalları təmizlə',
		'empty' => 'Jurnal faylı boşdur',
		'title' => 'Jurnallar',
	),
	'menu' => array(
		'about' => 'FreshRSS haqqında',
		'before_one_day' => 'Bir gündən köhnə',
		'before_one_week' => 'Bir həftədən köhnə',
		'bookmark_query' => 'Cari sorğunu əlfəcinlərə əlavə et',
		'favorites' => 'Seçilmişlər (%s)',
		'global_view' => 'Qlobal görünüş',
		'important' => 'Vacib lentlər',
		'main_stream' => 'Əsas axın',
		'mark_all_read' => 'Hamısını oxunmuş kimi işarələ',
		'mark_cat_read' => 'Kateqoriyanı oxunmuş kimi işarələ',
		'mark_feed_read' => 'Lenti oxunmuş kimi işarələ',
		'mark_selection_unread' => 'Seçimi oxunmamış kimi işarələ',
		'mylabels' => 'Etiketlərim',
		'non-starred' => 'Seçilməmişləri göstər',
		'normal_view' => 'Normal görünüş',
		'queries' => 'İstifadəçi sorğuları',
		'read' => 'Oxunmuşları göstər',
		'reader_view' => 'Oxu görünüşü',
		'rss_view' => 'RSS lenti',
		'search_short' => 'Axtarış',
		'sort' => array(
			'asc' => 'Artan',
			'c' => array(
				'name_asc' => 'Kateqoriya, lent başlıqları A→Z',
				'name_desc' => 'Kateqoriya, lent başlıqları Z→A',
			),
			'date_asc' => 'Dərc tarixi 1→9',
			'date_desc' => 'Dərc tarixi 9→1',
			'desc' => 'Azalan',
			'f' => array(
				'name_asc' => 'Lent başlığı A→Z',
				'name_desc' => 'Lent başlığı Z→A',
			),
			'id_asc' => 'Təzə alınanlar sonda',
			'id_desc' => 'Təzə alınanlar əvvəldə',
			'length_asc' => 'Məzmun uzunluğu 1→9',
			'length_desc' => 'Məzmun uzunluğu 9→1',
			'link_asc' => 'Keçid A→Z',
			'link_desc' => 'Keçid Z→A',
			'primary' => array(
				'_' => 'Sıralama meyarı',
				'help' => 'Əksər hallarda <em>alınma</em> tarixinə görə sıralama tövsiyə olunur, ardıcıllıq və performans üçün',
			),
			'rand' => 'Təsadüfi sıra',
			'secondary' => array(
				'_' => 'İkincili sıralama meyarı',
				'help' => 'Yalnız əsas sıralama meyarı kateqoriya və ya lent başlıqları olduqda əhəmiyyətlidir',
			),
			'title_asc' => 'Başlıq A→Z',
			'title_desc' => 'Başlıq Z→A',
			'user_modified_asc' => 'İstifadəçi dəyişikliyi 1→9',
			'user_modified_desc' => 'İstifadəçi dəyişikliyi 9→1',
		),
		'starred' => 'Seçilmişləri göstər',
		'stats' => 'Statistika',
		'subscription' => 'Abunə idarəetməsi',
		'unread' => 'Oxunmamışları göstər',
	),
	'share' => 'Paylaş',
	'tag' => array(
		'related' => 'Məqalə etiketləri',
	),
	'tos' => array(
		'title' => 'İstifadə şərtləri',
	),
);
