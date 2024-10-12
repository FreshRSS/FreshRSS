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
		'_' => 'Arhivēšana',
		'exception' => 'Iztīrīt izņēmumu',
		'help' => 'Vairākas opcijas ir pieejamas atsevišķas barotnes iestatījumos.',
		'keep_favourites' => 'Nekad neizdzēst mīļākos',
		'keep_labels' => 'Nekad neizdzēst birkas',
		'keep_max' => 'Maksimālais saglabājamo rakstu skaits',	// DIRTY
		'keep_min_by_feed' => 'Minimālais rakstu skaits, kas jāsaglabā vienā barotnē',
		'keep_period' => 'Maksimālais saglabājamo rakstu vecums',
		'keep_unreads' => 'Nekad neizdzēst nelasītos rakstus',
		'maintenance' => 'Uzturēšana',
		'optimize' => 'Optimizēt datubāzi',
		'optimize_help' => 'Periodiski palaist, lai samazinātu datubāzes lielumu.',
		'policy' => 'Iztīrīšanas politika',
		'policy_warning' => 'Ja nav izvēlēta iztīrīšanas politika, katrs raksts tiks saglabāts..',
		'purge_now' => 'Iztīrīt tagad',
		'title' => 'Arhivēšana',
		'ttl' => 'Automātiski neatjaunināt biežāk nekā',
	),
	'display' => array(
		'_' => 'Ekrāns',
		'darkMode' => array(
			'_' => 'Automātiskais tumšais režīms',
			'auto' => 'Auto',	// IGNORE
			'help' => 'For compatible themes only',	// TODO
			'no' => 'Nē',
		),
		'icon' => array(
			'bottom_line' => 'Apakšējā līnija',
			'display_authors' => 'Autori',
			'entry' => 'Raksta ikonas',
			'publication_date' => 'Publicēšanas datums',
			'related_tags' => 'Raksta birkas',
			'sharing' => 'Dalīšanās',
			'summary' => 'Kopsavilkums',
			'top_line' => 'Augšējā līnija',
		),
		'language' => 'Valoda',
		'notif_html5' => array(
			'seconds' => 'sekundes (0 nozīmē, ka nav laika ierobežojuma)',
			'timeout' => 'HTML5 paziņojuma laika ierobežojums',
		),
		'show_nav_buttons' => 'Rādīt navigācijas pogas',
		'theme' => array(
			'_' => 'Tēma',
			'deprecated' => array(
				'_' => 'Novecojis',
				'description' => 'Šī tēma vairs netiek atbalstīta un vairs nebūs pieejama <a href="https://freshrss.github.io/FreshRSS/en/users/05_Configuration.html#theme" target="_blank">nākamajā FreshRSS versijā</a>.',
			),
		),
		'theme_not_available' => 'Tēma "%s" vairs nav pieejama. Lūdzu, izvēlieties citu tēmu.',
		'thumbnail' => array(
			'label' => 'Sīktēls',
			'landscape' => 'Ainavas',
			'none' => 'Nekāds',
			'portrait' => 'Portreta',
			'square' => 'Kvadrāta',
		),
		'timezone' => 'Laika josla',
		'title' => 'Ekrāns',
		'website' => array(
			'full' => 'Ikona un vārds',
			'icon' => 'Tikai ikona',
			'label' => 'Mājaslapa',
			'name' => 'Tikai vārds',
			'none' => 'Nekāds',
		),
		'width' => array(
			'content' => 'Satura platums',
			'large' => 'Plats',
			'medium' => 'Vidējs',
			'no_limit' => 'Pilna platuma',
			'thin' => 'Šaurs',
		),
	),
	'logs' => array(
		'loglist' => array(
			'level' => 'Žurnāla līmenis',
			'message' => 'Žurnāla ziņa',
			'timestamp' => 'Laika zīmogs',
		),
		'pagination' => array(
			'first' => 'Pirmais',
			'last' => 'Pēdējais',
			'next' => 'Nākamais',
			'previous' => 'Iepriekšējais',
		),
	),
	'profile' => array(
		'_' => 'Profila pārvalde',
		'api' => 'API pārvalde',
		'delete' => array(
			'_' => 'Konta dzēšana',
			'warn' => 'Jūsu konts un visi saistītie dati tiks dzēsti..',
		),
		'email' => 'E-pasta adrese',
		'password_api' => 'API parole<br /><small>(piem., priekš mobilajām lietotnēm)</small>',
		'password_form' => 'Parole<br /><small>(Web-formas pieteikšanās metodei)</small>',
		'password_format' => 'Vismaz 7 rakstzīmes',
		'title' => 'Profils',
	),
	'query' => array(
		'_' => 'Lietotāja pieprasījumi',
		'deprecated' => 'Šis pieprasījums vairs nav derīgs. Norādītā kategorija vai barotne ir dzēsta.',
		'description' => 'Description',	// TODO
		'filter' => array(
			'_' => 'Piemērotais filtrs:',
			'categories' => 'Rādīt pēc kategorijas',
			'feeds' => 'Rādīt pēc barotnes',
			'order' => 'Kārtot pēc datuma',
			'search' => 'Izteiksme',
			'shareOpml' => 'Enable sharing by OPML of corresponding categories and feeds',	// TODO
			'shareRss' => 'Enable sharing by HTML &amp; RSS',	// TODO
			'state' => 'Stāvoklis',
			'tags' => 'Rādīt pēc birkas',
			'type' => 'Veids',
		),
		'get_all' => 'Rādīt visus rakstus',
		'get_all_labels' => 'Display articles with any label',	// TODO
		'get_category' => 'Rādīt kategoriju “%s”',
		'get_favorite' => 'Rādīt mīļākos rakstus',
		'get_feed' => 'Rādīt barotni “%s”',
		'get_important' => 'Display articles from important feeds',	// TODO
		'get_label' => 'Display articles with “%s” label',	// TODO
		'help' => 'See the <a href="https://freshrss.github.io/FreshRSS/en/users/user_queries.html" target="_blank">documentation for user queries and resharing by HTML / RSS / OPML</a>.',	// TODO
		'image_url' => 'Image URL',	// TODO
		'name' => 'Vārds',
		'no_filter' => 'Bez filtra',
		'number' => 'Pieprasījums nr. %d',
		'order_asc' => 'Vispirms rādīt vecākos rakstus',
		'order_desc' => 'Vispirms rādīt jaunākos rakstus',
		'search' => 'Meklēt “%s”',
		'share' => array(
			'_' => 'Share this query by link',	// TODO
			'greader' => 'Shareable link to the GReader JSON',	// TODO
			'help' => 'Give this link if you want to share this query with anyone',	// TODO
			'html' => 'Shareable link to the HTML page',	// TODO
			'opml' => 'Shareable link to the OPML list of feeds',	// TODO
			'rss' => 'Shareable link to the RSS feed',	// TODO
		),
		'state_0' => 'Rādīt visus rakstus',
		'state_1' => 'Rādīt lasītos rakstus',
		'state_2' => 'Rādīt nelasītos rakstus',
		'state_3' => 'Rādīt visus rakstus',
		'state_4' => 'Rādīt mīļākos rakstus',
		'state_5' => 'Rādīt lasītos mīļākos rakstus',
		'state_6' => 'Rādīt nelasītos mīļākos rakstus',
		'state_7' => 'Rādīt mīļākos rakstus',
		'state_8' => 'Rādīt ne mīļākos rakstus',
		'state_9' => 'Rādīt lasītos ne mīļākos rakstus',
		'state_10' => 'Rādīt nelasītos ne mīļākos rakstus',
		'state_11' => 'Rādīt ne mīļākos rakstus',
		'state_12' => 'Rādīt visus rakstus',
		'state_13' => 'Rādīt lasītos rakstus',
		'state_14' => 'Rādīt nelasītos rakstus',
		'state_15' => 'Rādīt visus rakstus',
		'title' => 'Lietotāja pieprasījumi',
	),
	'reading' => array(
		'_' => 'Lasīšana',
		'after_onread' => 'Pēc "atzīmēt visus kā izlasītus",',
		'always_show_favorites' => 'Pēc noklusējuma rādīt visus rakstus mīļāko sadaļā',
		'article' => array(
			'authors_date' => array(
				'_' => 'Autori un datums',
				'both' => 'Virsrakstā un kājenē',
				'footer' => 'Kājienē',
				'header' => 'Virsrakstā',
				'none' => 'Nekāds',
			),
			'feed_name' => array(
				'above_title' => 'Virs titula/birkām',
				'none' => 'Nekāds',
				'with_authors' => 'Autoru un datuma rindā',
			),
			'feed_title' => 'Barotnes tituls',
			'icons' => array(
				'_' => 'Article icons position<br /><small>(Reading view only)</small>',	// TODO
				'above_title' => 'Above title',	// TODO
				'with_authors' => 'In authors and date row',	// TODO
			),
			'tags' => array(
				'_' => 'Birkas',
				'both' => 'Virsrakstā un kājenē',
				'footer' => 'Kājienē',
				'header' => 'Virsrakstā',
				'none' => 'Nekāds',
			),
			'tags_max' => array(
				'_' => 'Maksimālais rādīto birku skaits',
				'help' => '0 nozīmē: rādīt visas birkas un nesalocīt tās',
			),
		),
		'articles_per_page' => 'Rakstu skaits lapā',
		'auto_load_more' => 'Ielādēt vairāk rakstu lapas apakšā',
		'auto_remove_article' => 'Paslēpt rakstus pēc izlasīšanas',
		'confirm_enabled' => 'Parādīt apstiprinājuma dialoglodziņu darbībai "atzīmēt visus kā izlasītus"',
		'display_articles_unfolded' => 'Pēc noklusējuma rādīt nesalocītus rakstus',
		'display_categories_unfolded' => 'Nesalocītās kategorijas',
		'headline' => array(
			'articles' => 'Raksti: Atvērt/Aizvērt',
			'articles_header_footer' => 'Raksti: virsraksts/kājotne',
			'categories' => 'Kreisā navigācija: Kategorijas',
			'mark_as_read' => 'Atzīmēt rakstu kā izlasītu',
			'misc' => 'Citi',
			'view' => 'Skatīt',
		),
		'hide_read_feeds' => 'Paslēpt kategorijas un barotnes, kurās nav nelasītu rakstu (nedarbojas ar konfigurāciju "Rādīt visus rakstus")',
		'img_with_lazyload' => 'Izmantot <em>slinkās ielādes</em> režīmu, lai ielādētu attēlus',
		'jump_next' => 'pāriet uz nākamo nelasīto radinieku (barotni vai kategoriju)',
		'mark_updated_article_unread' => 'Atjauninātos rakstus atzīmēt kā nelasītus',
		'number_divided_when_reader' => 'Dalīt ar 2 lasīšanas skatā.',
		'read' => array(
			'article_open_on_website' => 'kad raksts tiek atvērts tā sākotnējā mājaslapā',
			'article_viewed' => 'kad raksts tiek skatīts',
			'focus' => 'when focused (except for important feeds)',	// TODO
			'keep_max_n_unread' => 'Maksimālais nelasīto rakstu skaits',
			'scroll' => 'ritināšanas laikā (except for important feeds)',	// DIRTY
			'upon_gone' => 'kad tas vairs nav augšupējā ziņu barotnē',
			'upon_reception' => 'pēc raksta saņemšanas',
			'when' => 'Atzīmēt rakstu kā izlasītu…',
			'when_same_title' => 'ja identisks virsraksts jau ir jaunākajos <i>n</i> rakstos',
		),
		'show' => array(
			'_' => 'Rādāmie raksti',
			'active_category' => 'Aktīvā kategorija',
			'adaptive' => 'Pielāgot rādīšanu',
			'all_articles' => 'Rādīt visus rakstus',
			'all_categories' => 'Visas kategorijas',
			'no_category' => 'Bez kategorijas',
			'remember_categories' => 'Iegaumēt atvērtās kategorijas',
			'unread' => 'Rādīt tikai nelasītos',
		),
		'show_fav_unread_help' => 'Attiecas arī uz birkām',
		'sides_close_article' => 'Spiežot ārpus raksta teksta apgabala, raksts tiek aizvērts',
		'sort' => array(
			'_' => 'Kārtošanas kārtība',
			'newer_first' => 'Sākumā jaunākos',
			'older_first' => 'Sākumā vecākos',
		),
		'star' => array(
			'when' => 'Mark an article as favourite…',	// TODO
		),
		'sticky_post' => 'Uzlīmēt rakstu augšā, kad atvērts',
		'title' => 'Lasīšana',
		'view' => array(
			'default' => 'Noklusējuma skats',
			'global' => 'Globālais skats',
			'normal' => 'Parastais skats',
			'reader' => 'Lasīšanas skats',
		),
	),
	'sharing' => array(
		'_' => 'Dalīšanās',
		'add' => 'Pievienojat dalīšanās metodi',
		'deprecated' => 'Šis pakalpojums ir novecojis un tiks noņemts no FreshRSS kādā <a href="https://freshrss.github.io/FreshRSS/en/users/08_sharing_services.html" title="Atvērt dokumentāciju, lai iegūtu vairāk informācijas" target="_blank">nākamajā versijā</a>.',
		'diaspora' => 'Diaspora*',	// IGNORE
		'email' => 'E-pasts',
		'facebook' => 'Facebook',	// IGNORE
		'more_information' => 'Vairāk informācija',
		'print' => 'Drukāt',
		'raindrop' => 'Raindrop.io',	// IGNORE
		'remove' => 'Noņemt dalīšanās metodi',
		'shaarli' => 'Shaarli',	// IGNORE
		'share_name' => 'Rādāmā dalīšanās nosaukums',
		'share_url' => 'Dalīšanās URL, ko izmantot',
		'title' => 'Dalīšanās',
		'twitter' => 'Twitter',	// IGNORE
		'wallabag' => 'wallabag',	// IGNORE
	),
	'shortcut' => array(
		'_' => 'Saīsnes',
		'article_action' => 'Raksta darbības',
		'auto_share' => 'Dalīties',
		'auto_share_help' => 'Ja ir tikai viens dalīšanās režīms, tiek izmantots tas režīms. Pretējā gadījumā režīmi ir pieejami pēc to numura If there is only one sharing mode, it is used.',
		'close_dropdown' => 'Aizvērt izvēlnes',
		'collapse_article' => 'Salocīt',
		'first_article' => 'Atvērt pirmo rakstu',
		'focus_search' => 'Piekļuve meklēšanas lodziņam',
		'global_view' => 'Pāriet uz globālo skatu',
		'help' => 'Ekrāna dokumentācija',
		'javascript' => 'Lai izmantotu saīsnes, ir jābūt iespējotam JavaScript.',
		'last_article' => 'Atvērt pēdējo rakstu',
		'load_more' => 'Ielādēt vairāk rakstus',
		'mark_favorite' => 'Pārslēgt mīļāko',
		'mark_read' => 'Pārslēgt izlasītu',
		'navigation' => 'Navigācija',
		'navigation_help' => 'Izmantojot modifikatoru <kbd>⇧ Shift</kbd>, navigācijas saīsnes attiecas uz barotnēm.<br/>Izmantojot modifikatoru <kbd>Alt ⎇</kbd>, navigācijas saīsnes attiecas uz kategorijām.',
		'navigation_no_mod_help' => 'Sekojošās navigācijas saīsnes neatbalsta modifikatorus.',
		'next_article' => 'Atvērt nākamo rakstu',
		'next_unread_article' => 'Atvērt nākamo neizlasīto rakstu',
		'non_standard' => 'Dažas pogas (<kbd>%s</kbd>) var nestrādāt kā saīsnes.',
		'normal_view' => 'Pārslēgt uz parasto skatu',
		'other_action' => 'Citas rīcības',
		'previous_article' => 'Atvērt iepriekšējo skatui',
		'reading_view' => 'Pārslēgt uz lasīšanas režīmu',
		'rss_view' => 'Atvērt RSS barotni',
		'see_on_website' => 'Redzēt sākotnējā mājaslapā',
		'shift_for_all_read' => '+ <kbd>Alt ⎇</kbd>, lai atzīmētu iepriekšējos rakstus kā izlasītus<br />+ <kbd>⇧ Shift</kbd>, lai atzīmētu visus rakstus kā izlasītus',
		'skip_next_article' => 'Fokusēt nākamo bez atvēršanas',
		'skip_previous_article' => 'Fokusēt iepriekšējo bez atvēršanas',
		'title' => 'Saīsnes',
		'toggle_media' => 'Mēdiju atskaņošana/pauze',
		'user_filter' => 'Piekļuve lietotāju pieprasījumiem',
		'user_filter_help' => 'Ja ir tikai viens lietotāja pieprasījums, tiek izmantots tas. Pretējā gadījumā pieprasījumi ir pieejami pēc to numura.',
		'views' => 'Skati',
	),
	'user' => array(
		'articles_and_size' => '%s raksti (%s)',
		'current' => 'Pašreizējais lietotājs',
		'is_admin' => 'ir administrators',
		'users' => 'Lietotāji',
	),
);
