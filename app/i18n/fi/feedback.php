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
		'denied' => 'Sinulla ei ole tämän sivun käyttöoikeutta',
		'not_found' => 'Etsimääsi sivua ei ole',
	),
	'admin' => array(
		'optimization_complete' => 'Optimointi on valmis',
	),
	'api' => array(
		'password' => array(
			'failed' => 'Salasanaa ei voi muuttaa',
			'updated' => 'Salasana on muutettu',
		),
	),
	'auth' => array(
		'login' => array(
			'invalid' => 'Sisäänkirjaus epäonnistui',
			'success' => 'Yhteys on muodostettu',
		),
		'logout' => array(
			'success' => 'Yhteys on katkaistu',
		),
	),
	'conf' => array(
		'error' => 'Määritysten tallennuksessa ilmeni virhe',
		'query_created' => 'Kysely “%s” on luotu.',
		'shortcuts_updated' => 'Pikanäppäimet on päivitetty',
		'updated' => 'Määritykset on päivitetty',
	),
	'extensions' => array(
		'already_enabled' => '%s on jo käytössä',
		'cannot_remove' => 'Laajennusta %s ei voi poistaa',
		'disable' => array(
			'ko' => 'Laajennusta %s ei voi poistaa käytöstä. Lisätietoja on <a href="%s">FreshRSS-lokeissa</a>.',
			'ok' => '%s on nyt poistettu käytöstä',
		),
		'enable' => array(
			'ko' => 'Laajennusta %s ei voi ottaa käyttöön. Lisätietoja on <a href="%s">FreshRSS-lokeissa</a>.',
			'ok' => '%s on nyt otettu käyttöön',
		),
		'invalid_view_mode' => 'Invalid view mode “%s”! Fall back to “Normal view”.',	// TODO
		'no_access' => 'Sinulla ei ole laajennuksen %s käyttöoikeutta',
		'not_enabled' => 'Laajennus %s ei ole käytössä',
		'not_found' => 'Laajennusta %s ei ole',
		'removed' => '%s on poistettu',
	),
	'import_export' => array(
		'export_no_zip_extension' => 'ZIP-laajennusta ei löydy palvelimesta. Vie tiedostot yksitellen.',
		'feeds_imported' => 'Syötteet on tuotu palveluun. Jos kaikki haluamasi syötteet on tuotu, voit nyt napsauttaa <i>Päivitä syötteet</i> -painiketta.',
		'feeds_imported_with_errors' => 'Syötteet on tuotu palveluun, mutta tuonnissa ilmeni virheitä. Jos kaikki haluamasi syötteet on tuotu, voit nyt napsauttaa <i>Päivitä syötteet</i> -painiketta.',
		'file_cannot_be_uploaded' => 'Tiedoston siirto palvelimeen ei onnistu!',
		'no_zip_extension' => 'ZIP-laajennusta ei löydy palvelimesta.',
		'zip_error' => 'ZIP-käsittelyssä on ilmennyt virhe.',
	),
	'profile' => array(
		'error' => 'Profiilia ei voi muokata',
		'passwords_dont_match' => 'Passwords don’t match',	// TODO
		'updated' => 'Profiilia on muokattu',
	),
	'sub' => array(
		'actualize' => 'Päivitetään',
		'articles' => array(
			'marked_read' => 'Valitut artikkelit on merkitty luetuiksi.',
			'marked_unread' => 'Artikkelit on merkitty lukemattomiksi.',
		),
		'category' => array(
			'created' => 'Luokka %s on luotu.',
			'deleted' => 'Luokka on poistettu.',
			'emptied' => 'Luokka on tyhjennetty',
			'error' => 'Luokan päivitys ei onnistu',
			'name_exists' => 'Luokan nimi on jo käytössä.',
			'no_id' => 'Määritä luokan tunnus.',
			'no_name' => 'Luokan nimi ei voi olla tyhjä.',
			'not_delete_default' => 'Oletusluokkaa ei voi poistaa.',
			'not_exist' => 'Luokkaa ei ole.',
			'over_max' => 'Enimmäismäärä luokkia on luotu (%d)',
			'updated' => 'Luokka on päivitetty.',
		),
		'feed' => array(
			'actualized' => '<em>%s</em> on päivitetty',
			'actualizeds' => 'RSS-syötteet on päivitetty',
			'added' => 'RSS-syöte <em>%s</em> on lisätty',
			'already_subscribed' => 'Olet jo tilannut syötteen <em>%s</em>',
			'cache_cleared' => 'Välimuisti <em>%s</em> on tyhjennetty',
			'deleted' => 'Syöte on poistettu',
			'error' => 'Syötteen päivitys ei onnistu',
			'favicon' => array(
				'too_large' => 'Uploaded icon is too large. The maximum file size is <em>%s</em>.',	// TODO
				'unsupported_format' => 'Unsupported image file format!',	// TODO
			),
			'internal_problem' => 'Uutissyötettä ei voinut lisätä. Lisätietoja on <a href="%s">FreshRSS-lokeissa</a>. Voit yrittää pakottaa lisäämisen liittämällä tekstin <code>#force_feed</code> URL-osoitteen loppuun.',
			'invalid_url' => 'URL-osoite <em>%s</em> on virheellinen',
			'n_actualized' => '%d syötettä on päivitetty',
			'n_entries_deleted' => '%d artikkelia on poistettu',
			'no_refresh' => 'Päivitettäviä syötteitä ei ole',
			'not_added' => 'Syötteen <em>%s</em> lisäys ei onnistunut',
			'not_found' => 'Syötettä ei löydy',
			'over_max' => 'Enimmäismäärä syötteitä on lisätty (%d)',
			'reloaded' => '<em>%s</em> on ladattu uudelleen',
			'selector_preview' => array(
				'http_error' => 'Sivuston sisällön lataus epäonnistui.',
				'no_entries' => 'Syötteessä ei ole artikkeleita. Tarvitset ainakin yhden artikkelin luodaksesi esikatselun.',
				'no_feed' => 'Sisäinen virhe (syötettä ei löydy).',
				'no_result' => 'Valitsin ei vastannut mitään sisältöä. Varatoimena näytetään alkuperäisen syötteen teksti.',
				'selector_empty' => 'Valitsin on tyhjä. Määritä ainakin yksi valitsin luodaksesi esikatselun.',
			),
			'updated' => 'Syöte on päivitetty',
		),
		'purge_completed' => 'Tyhjennys on valmis (%d artikkelia poistettu)',
	),
	'tag' => array(
		'created' => 'Merkintä “%s” on luotu.',
		'error' => 'Merkinnän päivitys ei onnistunut.',
		'name_exists' => 'Samanniminen merkintä on lisätty aiemmin.',
		'renamed' => 'Merkintä “%s” on nimetty uudelleen: “%s”.',
		'updated' => 'Merkintä on päivitetty.',
	),
	'update' => array(
		'can_apply' => 'FreshRSS-sovellukseen on saatavissa päivitys: <strong>versio %s</strong>.',
		'error' => 'Päivityksessä on ilmennyt virhe: %s',
		'file_is_nok' => 'FreshRSS-sovellukseen on saatavissa päivitys (<strong>version %s</strong>), mutta tarkista hakemiston <em>%s</em> oikeudet. HTTP-palvelimella on oltava kirjoitusoikeus.',
		'finished' => 'Päivitys on valmis!',
		'none' => 'Päivitystä ei ole saatavilla',
		'server_not_found' => 'Päivityspalvelinta ei löydy. [%s]',
	),
	'user' => array(
		'created' => array(
			'_' => 'Käyttäjä %s on luotu',
			'error' => 'Käyttäjän %s luonti ei onnistu',
		),
		'deleted' => array(
			'_' => 'Käyttäjä %s on poistettu',
			'error' => 'Käyttäjän %s poisto ei onnistu',
		),
		'updated' => array(
			'_' => 'Käyttäjä %s on päivitetty',
			'error' => 'Käyttäjää %s ei ole päivitetty',
		),
	),
);
