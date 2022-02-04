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
		'_' => 'Archivering',
		'exception' => 'Zuiveringsuitzondering',
		'help' => 'Meer opties zijn beschikbaar in de persoonlijke stroom instellingen',
		'keep_favourites' => 'Favorieten nooit verwijderen',
		'keep_labels' => 'Labels nooit verwijderen',
		'keep_max' => 'Maximaal aantal artikelen om te behouden',
		'keep_min_by_feed' => 'Minimum aantal te behouden artikelen in de feed',
		'keep_period' => 'Maximumleeftijd artikelen om te behouden',
		'keep_unreads' => 'Ongelezen artikels nooit verwijderen',
		'maintenance' => 'Onderhoud',
		'optimize' => 'Database optimaliseren',
		'optimize_help' => 'Doe dit zo af en toe om de omvang van de database te verkleinen',
		'policy' => 'Zuiveringsbeleid',
		'policy_warning' => 'Zonder zuiveringsbeleid wordt elk artikel bewaard.',
		'purge_now' => 'Schoon nu op',
		'title' => 'Archivering',
		'ttl' => 'Vernieuw niet automatisch meer dan',
	),
	'display' => array(
		'_' => 'Opmaak',
		'icon' => array(
			'bottom_line' => 'Onderaan',
			'display_authors' => 'Auteurs',
			'entry' => 'Artikel pictogrammen',
			'publication_date' => 'Publicatie datum',
			'related_tags' => 'Gerelateerde labels',
			'sharing' => 'Delen',
			'summary' => 'Samenvatting',
			'top_line' => 'Bovenaan',
		),
		'language' => 'Taal',
		'notif_html5' => array(
			'seconds' => 'seconden (0 betekent geen stop)',
			'timeout' => 'HTML5 notificatie stop',
		),
		'show_nav_buttons' => 'Toon navigatieknoppen',
		'theme' => 'Thema',
		'theme_not_available' => 'Het “%s” thema is niet meer beschikbaar. Kies een ander thema.',
		'thumbnail' => array(
			'label' => 'Miniatuur',
			'landscape' => 'Liggend',
			'none' => 'Geen',
			'portrait' => 'Staand',
			'square' => 'Vierkant',
		),
		'title' => 'Opmaak',
		'width' => array(
			'content' => 'Inhoud breedte',
			'large' => 'Breed',
			'medium' => 'Normaal',
			'no_limit' => 'Geen limiet',
			'thin' => 'Smal',
		),
	),
	'profile' => array(
		'_' => 'Profielbeheer',
		'api' => 'API-beheer',
		'delete' => array(
			'_' => 'Account verwijderen',
			'warn' => 'Uw account en alle gerelateerde gegvens worden verwijderd.',
		),
		'email' => 'Email adres',
		'password_api' => 'Wachtwoord API<br /><small>(e.g., voor mobiele apps)</small>',
		'password_form' => 'Wachtwoord<br /><small>(voor de Web-formulier log in methode)</small>',
		'password_format' => 'Ten minste 7 tekens',
		'title' => 'Profiel',
	),
	'query' => array(
		'_' => 'Gebruikersquery’s (informatie aanvragen)',
		'deprecated' => 'Deze query (informatie aanvraag) is niet langer geldig. De bedoelde categorie of feed is al verwijderd.',
		'filter' => array(
			'_' => 'Filter toegepast:',
			'categories' => 'Weergeven op categorie',
			'feeds' => 'Weergeven op feed',
			'order' => 'Sorteren op datum',
			'search' => 'Expressie',
			'state' => 'Status',
			'tags' => 'Weergeven op tag',
			'type' => 'Type',	// IGNORE
		),
		'get_all' => 'Toon alle artikelen',
		'get_category' => 'Toon "%s" categorie',
		'get_favorite' => 'Toon favoriete artikelen',
		'get_feed' => 'Toon "%s" feed',
		'name' => 'Naam',
		'no_filter' => 'Geen filter',
		'number' => 'Query n°%d',	// IGNORE
		'order_asc' => 'Toon oudste artikelen eerst',
		'order_desc' => 'Toon nieuwste artikelen eerst',
		'search' => 'Zoek naar "%s"',
		'state_0' => 'Toon alle artikelen',
		'state_1' => 'Toon gelezen artikelen',
		'state_2' => 'Toon ongelezen artikelen',
		'state_3' => 'Toon alle artikelen',
		'state_4' => 'Toon favoriete artikelen',
		'state_5' => 'Toon gelezen favoriete artikelen',
		'state_6' => 'Toon ongelezen favoriete artikelen',
		'state_7' => 'Toon favoriete artikelen',
		'state_8' => 'Toon niet favoriete artikelen',
		'state_9' => 'Toon gelezen niet favoriete artikelen',
		'state_10' => 'Toon ongelezen niet favoriete artikelen',
		'state_11' => 'Toon niet favoriete artikelen',
		'state_12' => 'Toon alle artikelen',
		'state_13' => 'Toon gelezen artikelen',
		'state_14' => 'Toon ongelezen artikelen',
		'state_15' => 'Toon alle artikelen',
		'title' => 'Gebruikersquery’s',
	),
	'reading' => array(
		'_' => 'Lezen',
		'after_onread' => 'Na “markeer alles als gelezen”,',
		'always_show_favorites' => 'Toon alle artikelen standaard in favorieten',
		'articles_per_page' => 'Aantal artikelen per pagina',
		'auto_load_more' => 'Laad volgende artikel onderaan de pagina',
		'auto_remove_article' => 'Verberg artikel na lezen',
		'confirm_enabled' => 'Toon een bevestigings dialoog op “markeer alles als gelezen” acties',
		'display_articles_unfolded' => 'Artikelen standaard uitklappen',
		'display_categories_unfolded' => 'Categoriën om uit te klappen',
		'headline' => array(
			'articles' => 'Articles: Open/Close',	// TODO
			'categories' => 'Left navigation: Categories',	// TODO
			'mark_as_read' => 'Mark article as read',	// TODO
			'misc' => 'Miscellaneous',	// TODO
			'view' => 'View',	// TODO
		),
		'hide_read_feeds' => 'Categorieën en feeds zonder ongelezen artikelen verbergen (werkt niet met “Toon alle artikelen” configuratie)',
		'img_with_lazyload' => 'Gebruik "lazy load" methode om afbeeldingen te laden',
		'jump_next' => 'Ga naar volgende ongelezen (feed of categorie)',
		'mark_updated_article_unread' => 'Markeer vernieuwd artikel als ongelezen',
		'number_divided_when_reader' => 'Gedeeld door 2 in de lees modus.',
		'read' => array(
			'article_open_on_website' => 'als het artikel wordt geopend op de originele website',
			'article_viewed' => 'als het artikel wordt bekeken',
			'keep_max_n_unread' => 'Max aantal artikelen ongelezen houden',
			'scroll' => 'tijdens het scrollen',
			'upon_reception' => 'bij ontvangst van het artikel',
			'when' => 'Markeer artikel als gelezen…',
			'when_same_title' => 'als een zelfde titel al voorkomt in de top <i>n</i> nieuwste artikelen',
		),
		'show' => array(
			'_' => 'Artikelen om te tonen',
			'active_category' => 'Actieve categorie',
			'adaptive' => 'Pas weergave aan',
			'all_articles' => 'Bekijk alle artikelen',
			'all_categories' => 'Alle categorieën',
			'no_category' => 'Geen categorie',
			'remember_categories' => 'Open categorieën herinneren',
			'unread' => 'Bekijk alleen ongelezen',
		),
		'show_fav_unread_help' => 'Ook toepassen op labels',
		'sides_close_article' => 'Sluit het artikel door buiten de artikeltekst te klikken',
		'sort' => array(
			'_' => 'Sorteer volgorde',
			'newer_first' => 'Nieuwste eerst',
			'older_first' => 'Oudste eerst',
		),
		'sticky_post' => 'Koppel artikel aan de bovenkant als het geopend wordt',
		'title' => 'Lees modus',
		'view' => array(
			'default' => 'Standaard weergave',
			'global' => 'Globale weergave',
			'normal' => 'Normale weergave',
			'reader' => 'Lees weergave',
		),
	),
	'sharing' => array(
		'_' => 'Delen',
		'add' => 'Deelmethode toevoegen',
		'blogotext' => 'Blogotext',	// IGNORE
		'diaspora' => 'Diaspora*',	// IGNORE
		'email' => 'Email',	// IGNORE
		'facebook' => 'Facebook',	// IGNORE
		'more_information' => 'Meer informatie',
		'print' => 'Afdrukken',	// IGNORE
		'raindrop' => 'Raindrop.io',	// IGNORE
		'remove' => 'Deelmethode verwijderen',
		'shaarli' => 'Shaarli',	// IGNORE
		'share_name' => 'Gedeelde naam om weer te geven',
		'share_url' => 'Deel URL voor gebruik',
		'title' => 'Delen',
		'twitter' => 'Twitter',	// IGNORE
		'wallabag' => 'wallabag',	// IGNORE
	),
	'shortcut' => array(
		'_' => 'Snelkoppelingen',
		'article_action' => 'Artikelacties',
		'auto_share' => 'Delen',
		'auto_share_help' => 'Als er slechts één deelmethode is, dan wordt die gebruikt. Anders zijn ze toegankelijk met hun nummer.',
		'close_dropdown' => 'Sluit menu',
		'collapse_article' => 'Inklappen',
		'first_article' => 'Spring naar eerste artikel',
		'focus_search' => 'Toegang zoek venster',
		'global_view' => 'Schakel naar globaal aanzicht',
		'help' => 'Toon documentatie',
		'javascript' => 'JavaScript moet geactiveerd zijn om verwijzingen te gebruiken',
		'last_article' => 'Spring naar laatste artikel',
		'load_more' => 'Laad meer artikelen',
		'mark_favorite' => 'Markeer als favoriet',
		'mark_read' => 'Markeer als gelezen',
		'navigation' => 'Navigatie',
		'navigation_help' => 'Met de <kbd>⇧ Shift</kbd> toets worden navigatieverwijzingen op feeds toegepast.<br/>Met de <kbd>Alt ⎇</kbd> toets worden navigatieverwijzingen op categorieën toegepast.',
		'navigation_no_mod_help' => 'De volgende navigatiesnelkoppelingen ondersteunen geen toetsencombinaties.',
		'next_article' => 'Spring naar volgende artikel',
		'next_unread_article' => 'Spring naar volgende ongelezene artikel',
		'non_standard' => 'Sommige toetsen (<kbd>%s</kbd>) werken wellicht niet als snelkoppelingen.',
		'normal_view' => 'Schakel naar gewoon aanzicht',
		'other_action' => 'Andere acties',
		'previous_article' => 'Spring naar vorige artikel',
		'reading_view' => 'Schakel naar leesaanzicht',
		'rss_view' => 'Open als RSS-feed',
		'see_on_website' => 'Bekijk op originale website',
		'shift_for_all_read' => '+ <kbd>Alt ⎇</kbd> om voorgaande artikelen als gelezen te markeren<br />+ <kbd>⇧ Shift</kbd> om alle artikelen als gelezen te markeren',
		'skip_next_article' => 'Volgend artikel focusen zonder openen',
		'skip_previous_article' => 'Vorig artikel focusen zonder openen',
		'title' => 'Verwijzingen',
		'toggle_media' => 'Media afspelen/pauzeren',
		'user_filter' => 'Toegang gebruikers filters',
		'user_filter_help' => 'Als er slechts één gebruikersfilter is, dan wordt die gebruikt. Anders zijn ze toegankelijk met hun nummer.',
		'views' => 'Aanzichten',
	),
	'user' => array(
		'articles_and_size' => '%s artikelen (%s)',
		'current' => 'Huidige gebruiker',
		'is_admin' => 'is beheerder',
		'users' => 'Gebruikers',
	),
);
