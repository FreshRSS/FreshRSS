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
		'denied' => 'Jums nav tiesību piekļūt šai lapai',
		'not_found' => 'Jūs meklējat lapu, kas neeksistē',
	),
	'admin' => array(
		'optimization_complete' => 'Optimizācija pabeigta',
	),
	'api' => array(
		'password' => array(
			'failed' => 'Jūsu paroli nevar mainīt',
			'updated' => 'Jūsu parole tika mainīta',
		),
	),
	'auth' => array(
		'login' => array(
			'invalid' => 'Pieteikšanās ir nederīga',
			'success' => 'Jūs esat savienots',
		),
		'logout' => array(
			'success' => 'Jūs esat atvienots',
		),
	),
	'conf' => array(
		'error' => 'Konfigurācijas saglabāšanas laikā notika kļūda',
		'query_created' => 'Ir izveidots pieprasījums "%s".',
		'shortcuts_updated' => 'Ir atjaunināti īsceļi',
		'updated' => 'Konfigurācija tikai atjaunināta',
	),
	'extensions' => array(
		'already_enabled' => '%s ir jau iespējots',
		'cannot_remove' => '%s nevar būt izņemts',
		'disable' => array(
			'ko' => '%s nevar būt atspējots. <a href="%s">Pārbaudiet FreshRSS žurnālu</a> priekš papildu informācijas.',
			'ok' => '%s ir tagad atspējots',
		),
		'enable' => array(
			'ko' => '%s nevar būt ieslēgts. <a href="%s">Pārbaudiet FreshRSS žurnālu</a> priekš papildu informācijas.',
			'ok' => '%s ir tagad ieslēgts',
		),
		'no_access' => 'Jums nav piekļuves %s',
		'not_enabled' => '%s nav ieslēgts',
		'not_found' => '%s nēeksistē',
		'removed' => '%s izņemts',
	),
	'import_export' => array(
		'export_no_zip_extension' => 'Jūsu serverī nav ZIP paplašinājuma. Lūdzu, mēģiniet eksportēt failus pa vienam.',
		'feeds_imported' => 'Jūsu barotnes tika importētas un tagad tiks atjauninātas.	/ Your feeds have been imported. If you are done importing, you can now click the <i>Update feeds</i> button.',	// DIRTY
		'feeds_imported_with_errors' => 'Jūsu barotnes tika importētas, bet ir radušās dažas kļūdas / Your feeds have been imported, but some errors occurred. If you are done importing, you can now click the <i>Update feeds</i> button.',	// DIRTY
		'file_cannot_be_uploaded' => 'Failu nevar augšupielādēt!',
		'no_zip_extension' => 'Jūsu serverī nav ZIP paplašinājuma.',
		'zip_error' => 'ZIP importa laikā notika kļūda.',	// DIRTY
	),
	'profile' => array(
		'error' => 'Jūsu profilu nevar mainīt',
		'updated' => 'Jūsu profils tika mainīts',
	),
	'sub' => array(
		'actualize' => 'Atjaunina',
		'articles' => array(
			'marked_read' => 'Atlasītie raksti tika atzīmēti kā lasīti.',
			'marked_unread' => 'Atlasītie raksti tika atzīmēti kā nelasīti.',
		),
		'category' => array(
			'created' => 'Tika izveidota kategorija %s.',
			'deleted' => 'Kategorija tika izdzēsta.',
			'emptied' => 'Kategorija tika iztukšota',
			'error' => 'Kategoriju nevar atjaunināt',
			'name_exists' => 'Kategorijas nosaukums jau pastāv.',
			'no_id' => 'Ir jānorāda kategorijas ID.',
			'no_name' => 'Kategorijas nosaukums nedrīkst būt tukšs.',
			'not_delete_default' => 'Noklusējuma kategoriju nevar dzēst!',
			'not_exist' => 'Kategorija neeksistē!',
			'over_max' => 'Jūs esat sasniedzis savu kategoriju limitu (%d)',
			'updated' => 'Kategorija tika atjaunināta.',
		),
		'feed' => array(
			'actualized' => '<em>%s</em> tika atjaunota',
			'actualizeds' => 'RSS barotnes tika atjaunotas',
			'added' => 'RSS barotne <em>%s</em> tika pievienota',
			'already_subscribed' => 'Jūs jau esat abonējis <em>%s</em>',
			'cache_cleared' => '<em>%s</em> kešatmiņa tika iztukšota',
			'deleted' => 'Barortne tika izdzēsta',
			'error' => 'Barotne nevar būt atjaunināta',
			'internal_problem' => 'Barotni nevarēja pievienot. <a href="%s">Apskataties FreshRSS žurnālu</a> priekš papildus informācijas. Jūs varat izmēģināt piespiedu pievienošanu, URL pievienojot <code>#force_feed</code>.',
			'invalid_url' => 'URL <em>%s</em> ir nepareizs',
			'n_actualized' => '%d barotnes tika atjaunotas',
			'n_entries_deleted' => '%d raksti tika izdzēsti',
			'no_refresh' => 'Nav barotnes, kuras var atjaunot',
			'not_added' => '<em>%s</em> nevarēja būt pievienots',
			'not_found' => 'Barotni nevarēja atrast',
			'over_max' => 'Jūs esat sasniedzis barotņu limitu (%d)',
			'reloaded' => '<em>%s</em> tika pārlādēts',
			'selector_preview' => array(
				'http_error' => 'Neizdevās ielādēt vietnes saturu.',
				'no_entries' => 'Šajā barotnē nav neviena raksta. Jums ir nepieciešams vismaz viens raksts, lai izveidotu priekšskatījumu.',
				'no_feed' => 'Iekšēja kļūda (barotni nevarēja atrast).',
				'no_result' => 'Selektors nekam neatbilda. Kā rezerves variants tā vietā tiks parādīts sākotnējais barotnes teksts.',
				'selector_empty' => 'Atlasītājs ir tukšs. Lai izveidotu priekšskatījumu, ir jādefinē kāds no tiem.',
			),
			'updated' => 'Barotne tika atjaunota',
		),
		'purge_completed' => 'Tīrīšana pabeigta (%d raksti dzēsti)',
	),
	'tag' => array(
		'created' => 'Birka “%s” tika uztaisīta.',
		'error' => 'Label could not be updated!',	// TODO
		'name_exists' => 'Birkas nosaukums jau pastāv.',
		'renamed' => 'Birka “%s” tika pārdēvēts par “%s”.',
		'updated' => 'Label has been updated.',	// TODO
	),
	'update' => array(
		'can_apply' => 'FreshRSS tagad būs atjaunots uz <strong>%s versiju</strong>.',
		'error' => 'Atjaunināšanas process ir saskāries ar kļūdu: %s',
		'file_is_nok' => 'Jauna <strong>versija %s</strong> ir pieejama, bet pārbaudiet atļaujas uz <em>%s</em> mapi. HTTP serverim jābūt piešķirtām rakstīšanas atļaujām',
		'finished' => 'Atjauninājums ir pabeigts!',
		'none' => 'Nav jāpiemēro atjauninājums',
		'server_not_found' => 'Atjaunināšanas serveri nevar atrast. [%s]',
	),
	'user' => array(
		'created' => array(
			'_' => 'Lietotājs %s tika uztaisīts',
			'error' => 'Lietotāju %s nevarēja uztaisīt',
		),
		'deleted' => array(
			'_' => 'Lietotājs %s tika izdzēsts',
			'error' => 'Lietotāju %s nevarēja izdzēst',
		),
		'updated' => array(
			'_' => 'Lietotājs %s tika atjaunots',
			'error' => 'Lietotāju %s nevarēja atjaunot',
		),
	),
);
