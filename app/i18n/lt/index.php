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
		'_' => 'Apie',
		'agpl3' => '<a href="https://www.gnu.org/licenses/agpl-3.0.html">AGPL 3</a>',	// IGNORE
		'bug_reports' => array(
			'environment_information' => array(
				'_' => 'Sistemos informacija',
				'browser' => 'Naršyklė',
				'database' => 'Duomenų bazė',
				'server_software' => 'Serverio programinė įranga',
				'version_curl' => 'cURL versija',
				'version_frss' => 'FreshRSS versija',
				'version_php' => 'PHP versija',
			),
		),
		'bugs_reports' => 'Klaidų pranešimai',
		'documentation' => 'Dokumentacija',
		'freshrss_description' => 'FreshRSS – tai savarankiškai talpinamas RSS agregatorius ir skaityklė. Ji leidžia vienu žvilgsniu skaityti ir sekti kelias naujienų svetaines, nenaršant iš vienos svetainės į kitą. FreshRSS yra lengva, lanksčiai konfigūruojama ir paprasta naudoti.',
		'github' => '<a href="https://github.com/FreshRSS/FreshRSS/issues">svetainėje GitHub</a>',
		'license' => 'Licencija',
		'project_website' => 'Projekto svetainė',
		'title' => 'Apie',
		'version' => 'Versija',
	),
	'feed' => array(
		'empty' => 'Nėra straipsnių, kuriuos būtų galima rodyti.',
		'published' => array(
			'_' => 'Paskelbta',
			'future' => 'Paskelbta ateityje',
			'today' => 'Paskelbta šiandien',
			'yesterday' => 'Paskelbta vakar',
		),
		'received' => array(
			'_' => 'Gauta',
			'today' => 'Gauta šiandien',
			'yesterday' => 'Gauta vakar',
		),
		'rss_of' => '%s RSS kanalas',
		'title' => 'Pagrindinis srautas',
		'title_fav' => 'Mėgstami',
		'title_global' => 'Bendras vaizdas',
		'userModified' => array(
			'_' => 'Naudotojo pakeista',
			'today' => 'Naudotojo pakeista šiandien',
			'yesterday' => 'Naudotojo pakeista vakar',
		),
	),
	'log' => array(
		'_' => 'Žurnalai',
		'clear' => 'Išvalyti žurnalus',
		'empty' => 'Žurnalo failas tuščias',
		'title' => 'Žurnalai',
	),
	'menu' => array(
		'about' => 'Apie FreshRSS',
		'before_one_day' => 'Senesni nei viena diena',
		'before_one_week' => 'Senesni nei viena savaitė',
		'bookmark_query' => 'Įsiminti dabartinę užklausą',
		'favorites' => 'Mėgstami (%s)',
		'global_view' => 'Bendras vaizdas',
		'important' => 'Svarbūs kanalai',
		'main_stream' => 'Pagrindinis srautas',
		'mark_all_read' => 'Žymėti visus skaitytais',
		'mark_cat_read' => 'Žymėti kategoriją skaityta',
		'mark_feed_read' => 'Žymėti kanalą skaitytu',
		'mark_selection_unread' => 'Žymėti pažymėtus neskaitytais',
		'mylabels' => 'Mano etiketės',
		'non-starred' => 'Rodyti nepamėgtus',
		'normal_view' => 'Įprastas vaizdas',
		'queries' => 'Naudotojo užklausos',
		'read' => 'Rodyti skaitytus',
		'reader_view' => 'Skaitymo vaizdas',
		'rss_view' => 'RSS kanalas',
		'search_short' => 'Ieškoti',
		'sort' => array(
			'asc' => 'Didėjančiai',
			'c' => array(
				'name_asc' => 'Kategorijų, kanalų pavadinimai A→Ž',
				'name_desc' => 'Kategorijų, kanalų pavadinimai Ž→A',
			),
			'date_asc' => 'Paskelbimo data 1→9',
			'date_desc' => 'Paskelbimo data 9→1',
			'desc' => 'Mažėjančiai',
			'f' => array(
				'name_asc' => 'Kanalo pavadinimas A→Ž',
				'name_desc' => 'Kanalo pavadinimas Ž→A',
			),
			'id_asc' => 'Naujausi gauti gale',
			'id_desc' => 'Naujausi gauti priekyje',
			'length_asc' => 'Turinio ilgis 1→9',
			'length_desc' => 'Turinio ilgis 9→1',
			'link_asc' => 'Nuoroda A→Ž',
			'link_desc' => 'Nuoroda Ž→A',
			'primary' => array(
				'_' => 'Rikiavimo kriterijus',
				'help' => 'Daugeliu atvejų rekomenduojama rikiuoti pagal <em>gavimo</em> datą – dėl nuoseklumo ir našumo',
			),
			'rand' => 'Atsitiktine tvarka',
			'secondary' => array(
				'_' => 'Antrinis rikiavimo kriterijus',
				'help' => 'Aktualu tik tada, kai pagrindinis rikiavimo kriterijus yra kategorijų ar kanalų pavadinimai',
			),
			'title_asc' => 'Pavadinimas A→Ž',
			'title_desc' => 'Pavadinimas Ž→A',
			'user_modified_asc' => 'Naudotojo pakeista 1→9',
			'user_modified_desc' => 'Naudotojo pakeista 9→1',
		),
		'starred' => 'Rodyti pamėgtus',
		'stats' => 'Statistika',
		'subscription' => 'Prenumeratų tvarkymas',
		'unread' => 'Rodyti neskaitytus',
	),
	'share' => 'Bendrinti',
	'tag' => array(
		'related' => 'Straipsnio žymos',
	),
	'tos' => array(
		'title' => 'Naudojimosi sąlygos',
	),
);
