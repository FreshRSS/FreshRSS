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
	'access' => array(
		'denied' => 'Neturite teisės pasiekti šio puslapio',
		'not_found' => 'Ieškote puslapio, kurio nėra',
	),
	'admin' => array(
		'optimization_complete' => 'Optimizavimas baigtas',
	),
	'api' => array(
		'password' => array(
			'failed' => 'Jūsų slaptažodžio pakeisti nepavyko',
			'updated' => 'Jūsų slaptažodis pakeistas',
		),
	),
	'auth' => array(
		'login' => array(
			'invalid' => 'Neteisingi prisijungimo duomenys',
			'success' => 'Esate prisijungę',
		),
		'logout' => array(
			'success' => 'Esate atsijungę',
		),
	),
	'conf' => array(
		'error' => 'Įrašant konfigūraciją įvyko klaida',
		'query_created' => 'Užklausa „%s“ sukurta.',
		'shortcuts_updated' => 'Spartieji klavišai atnaujinti',
		'updated' => 'Konfigūracija atnaujinta',
	),
	'extensions' => array(
		'already_enabled' => '%s jau įjungtas',
		'cannot_remove' => '%s pašalinti negalima',
		'disable' => array(
			'ko' => '%s išjungti nepavyko. Išsamiau – <a href="%s">FreshRSS žurnaluose</a>.',
			'ok' => '%s dabar išjungtas',
		),
		'enable' => array(
			'ko' => '%s įjungti nepavyko. Išsamiau – <a href="%s">FreshRSS žurnaluose</a>.',
			'ok' => '%s dabar įjungtas',
		),
		'invalid_view_mode' => 'Netinkamas rodymo režimas „%s“! Grįžtama į „Įprastą vaizdą“.',
		'no_access' => 'Neturite prieigos prie %s',
		'not_enabled' => '%s nėra įjungtas',
		'not_found' => '%s neegzistuoja',
		'removed' => '%s pašalintas',
	),
	'import_export' => array(
		'export_no_zip_extension' => 'Jūsų serveryje nėra ZIP plėtinio. Pabandykite eksportuoti failus po vieną.',
		'feeds_imported' => 'Jūsų kanalai importuoti. Kai baigsite importuoti, galite spustelėti mygtuką <i>Atnaujinti kanalus</i>.',
		'feeds_imported_with_errors' => 'Jūsų kanalai importuoti, tačiau įvyko kelios klaidos. Kai baigsite importuoti, galite spustelėti mygtuką <i>Atnaujinti kanalus</i>.',
		'file_cannot_be_uploaded' => 'Failo įkelti nepavyko!',
		'no_zip_extension' => 'Jūsų serveryje nėra ZIP plėtinio.',
		'zip_error' => 'Apdorojant ZIP įvyko klaida.',
	),
	'profile' => array(
		'error' => 'Jūsų profilio pakeisti nepavyko',
		'passwords_dont_match' => 'Slaptažodžiai nesutampa',
		'updated' => 'Jūsų profilis pakeistas',
	),
	'sub' => array(
		'actualize' => 'Atnaujinama',
		'articles' => array(
			'marked_read' => 'Pasirinkti straipsniai pažymėti skaitytais.',
			'marked_unread' => 'Straipsniai pažymėti neskaitytais.',
		),
		'category' => array(
			'created' => 'Kategorija %s sukurta.',
			'deleted' => 'Kategorija ištrinta.',
			'emptied' => 'Kategorija ištuštinta',
			'error' => 'Kategorijos atnaujinti nepavyko',
			'name_exists' => 'Toks kategorijos pavadinimas jau yra.',
			'no_id' => 'Turite nurodyti kategorijos ID.',
			'no_name' => 'Kategorijos pavadinimas negali būti tuščias.',
			'not_delete_default' => 'Numatytosios kategorijos ištrinti negalima!',
			'not_exist' => 'Tokios kategorijos nėra!',
			'over_max' => 'Pasiekėte kategorijų ribą (%d)',
			'updated' => 'Kategorija atnaujinta.',
		),
		'feed' => array(
			'actualized' => '<em>%s</em> atnaujintas',
			'actualizeds' => 'RSS kanalai atnaujinti',
			'added' => 'RSS kanalas <em>%s</em> pridėtas',
			'already_subscribed' => 'Jūs jau prenumeruojate <em>%s</em>',
			'cache_cleared' => '<em>%s</em> podėlis (cache) išvalytas',
			'deleted' => 'Kanalas ištrintas',
			'error' => 'Kanalo atnaujinti nepavyko',
			'favicon' => array(
				'too_large' => 'Įkelta piktograma per didelė. Didžiausias failo dydis – <em>%s</em>.',
				'unsupported_format' => 'Nepalaikomas paveikslėlio failo formatas!',
			),
			'internal_problem' => 'Naujienų kanalo pridėti nepavyko. Išsamiau – <a href="%s">FreshRSS žurnaluose</a>. Galite bandyti pridėti priverstinai, prie URL pridėdami <code>#force_feed</code>.',
			'invalid_url' => 'URL <em>%s</em> netinkamas',
			'n_actualized' => 'Atnaujinta kanalų: %d',
			'n_entries_deleted' => 'Ištrinta straipsnių: %d',
			'no_refresh' => 'Nėra kanalų, kuriuos reikėtų atnaujinti',
			'not_added' => '<em>%s</em> pridėti nepavyko',
			'not_found' => 'Kanalo rasti nepavyko',
			'over_max' => 'Pasiekėte kanalų ribą (%d)',
			'reloaded' => '<em>%s</em> įkeltas iš naujo',
			'selector_preview' => array(
				'http_error' => 'Nepavyko įkelti svetainės turinio.',
				'no_entries' => 'Šiame kanale nėra straipsnių. Peržiūrai sukurti reikia bent vieno straipsnio.',
				'no_feed' => 'Vidinė klaida (kanalo rasti nepavyko).',
				'no_result' => 'Selektorius nieko neatitiko. Vietoj to bus rodomas originalus kanalo tekstas.',
				'selector_empty' => 'Selektorius tuščias. Kad sukurtumėte peržiūrą, jį reikia nurodyti.',
			),
			'updated' => 'Kanalas atnaujintas',
		),
		'purge_completed' => 'Išvalymas baigtas (ištrinta straipsnių: %d)',
	),
	'tag' => array(
		'created' => 'Etiketė „%s“ sukurta.',
		'error' => 'Etiketės atnaujinti nepavyko!',
		'name_exists' => 'Toks etiketės pavadinimas jau yra.',
		'renamed' => 'Etiketė „%s“ pervadinta į „%s“.',
		'updated' => 'Etiketė atnaujinta.',
	),
	'update' => array(
		'can_apply' => 'Yra FreshRSS atnaujinimas: <strong>versija %s</strong>.',
		'error' => 'Atnaujinimo metu įvyko klaida: %s',
		'file_is_nok' => 'Yra FreshRSS atnaujinimas (<strong>versija %s</strong>), tačiau patikrinkite katalogo <em>%s</em> teises. HTTP serveris turi turėti rašymo teisę',
		'finished' => 'Atnaujinimas baigtas!',
		'none' => 'Atnaujinimų nėra',
		'server_not_found' => 'Atnaujinimų serverio rasti nepavyko. [%s]',
	),
	'user' => array(
		'created' => array(
			'_' => 'Naudotojas %s sukurtas',
			'error' => 'Naudotojo %s sukurti nepavyko',
		),
		'deleted' => array(
			'_' => 'Naudotojas %s ištrintas',
			'error' => 'Naudotojo %s ištrinti nepavyko',
		),
		'updated' => array(
			'_' => 'Naudotojas %s atnaujintas',
			'error' => 'Naudotojas %s nebuvo atnaujintas',
		),
	),
);
