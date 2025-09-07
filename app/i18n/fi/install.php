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
	'action' => array(
		'finish' => 'Tee asennus loppuun',
		'fix_errors_before' => 'Korjaa kaikki virheet, ennen kuin siirryt seuraavaan vaiheeseen.',
		'keep_install' => 'Säilytä edelliset määritykset',
		'next_step' => 'Siirry seuraavaan vaiheeseen',
		'reinstall' => 'Asenna FreshRSS uudelleen',
	),
	'bdd' => array(
		'_' => 'Tietokanta',
		'conf' => array(
			'_' => 'Tietokannan määritys',
			'ko' => 'Tarkista tietokannan määritys.',
			'ok' => 'Tietokannan määritys on tallennettu.',
		),
		'host' => 'Palvelin',
		'password' => 'Tietokannan salasana',
		'prefix' => 'Taulun etuliite',
		'type' => 'Tietokannan laji',
		'username' => 'Tietokantakäyttäjän tunnus',
	),
	'check' => array(
		'_' => 'Tarkistukset',
		'already_installed' => 'FreshRSS on jo asennettu!',
		'cache' => array(
			'nok' => 'Tarkista käyttäjän <em>%2$s</em> oikeudet hakemistoon <em>%1$s</em>. HTTP-palvelimella on oltava kirjoitusoikeus.',
			'ok' => 'Cache-hakemiston oikeudet ovat oikein.',
		),
		'ctype' => array(
			'nok' => 'Merkkilajien tarkastukseen tarvittavaa kirjastoa (php-ctype) ei löydy.',
			'ok' => 'Merkkilajien tarkastukseen tarvittava kirjasto (ctype) löytyy.',
		),
		'curl' => array(
			'nok' => 'cURL-kirjastoa (php-curl-paketti) ei löydy.',
			'ok' => 'cURL-kirjasto löytyy.',
		),
		'data' => array(
			'nok' => 'Tarkista käyttäjän <em>%2$s</em> oikeudet hakemistoon <em>%1$s</em>. HTTP-palvelimella on oltava kirjoitusoikeus.',
			'ok' => 'Data-hakemiston oikeudet ovat oikein.',
		),
		'dom' => array(
			'nok' => 'DOM-rakenteen selaamiseen tarvittavaa kirjastoa ei löydy.',
			'ok' => 'DOM-rakenteen selaamiseen tarvittava kirjasto löytyy.',
		),
		'favicons' => array(
			'nok' => 'Tarkista käyttäjän <em>%2$s</em> oikeudet hakemistoon <em>%1$s</em>. HTTP-palvelimella on oltava kirjoitusoikeus.',
			'ok' => 'Favicons-hakemiston oikeudet ovat oikein.',
		),
		'fileinfo' => array(
			'nok' => 'PHP fileinfo -kirjastoa (fileinfo-paketti) ei löydy.',
			'ok' => 'Fileinfo-kirjasto löytyy.',
		),
		'json' => array(
			'nok' => 'JSON-sisällön jäsentämiseen suositeltua kirjastoa ei löydy.',
			'ok' => 'JSON-sisällön jäsentämiseen suositeltu kirjasto löytyy.',
		),
		'mbstring' => array(
			'nok' => 'Unicodea varten suositeltua mbstring-kirjastoa ei löydy.',
			'ok' => 'Unicodea varten suositeltu mbstring-kirjasto löytyy.',
		),
		'pcre' => array(
			'nok' => 'Säännöllisiä lausekkeita varten tarvittavaa kirjastoa (php-pcre) ei löydy.',
			'ok' => 'Säännöllisiä lausekkeita varten tarvittava kirjasto (PCRE) löytyy.',
		),
		'pdo' => array(
			'nok' => 'PDO:ta tai jotain tuettua ohjainta (pdo_mysql, pdo_sqlite, pdo_pgsql) ei löydy.',
			'ok' => 'PDO ja ainakin yksi tuetuista ohjaimista (pdo_mysql, pdo_sqlite, pdo_pgsql) löytyy.',
		),
		'php' => array(
			'nok' => 'Asennettu PHP-versio on %s, mutta FreshRSS edellyttää vähintään versiota %s.',
			'ok' => 'Asennettu PHP-versio, %s, on yhteensopiva FreshRSS-sovelluksen kanssa.',
		),
		'reload' => 'Tarkista uudelleen',
		'tmp' => array(
			'nok' => 'Tarkista käyttäjän <em>%2$s</em> oikeudet hakemistoon <em>%1$s</em>. HTTP-palvelimella on oltava kirjoitusoikeus.',
			'ok' => 'Temp-hakemiston oikeudet ovat oikein.',
		),
		'unknown_process_username' => 'tuntematon',
		'users' => array(
			'nok' => 'Tarkista käyttäjän <em>%2$s</em> oikeudet hakemistoon <em>%1$s</em>. HTTP-palvelimella on oltava kirjoitusoikeus.',
			'ok' => 'Users-hakemiston oikeudet ovat oikein.',
		),
		'xml' => array(
			'nok' => 'XML-sisällön jäsentämiseen tarvittavaa kirjastoa ei löydy.',
			'ok' => 'XML-sisällön jäsentämiseen tarvittava kirjasto löytyy.',
		),
	),
	'conf' => array(
		'_' => 'Yleinen määritykset',
		'ok' => 'Yleiset määritykset on tallennettu.',
	),
	'congratulations' => 'Onneksi olkoon!',
	'default_user' => array(
		'_' => 'Oletuskäyttäjän käyttäjätunnus',
		'max_char' => 'Enintään 16 aakkosnumeerista merkkiä',
	),
	'fix_errors_before' => 'Korjaa virheet, ennen kuin siirryt seuraavaan vaiheeseen.',
	'javascript_is_better' => 'FreshRSS-sovellusta on miellyttävämpi käyttää, kun JavaScript on käytössä',
	'js' => array(
		'confirm_reinstall' => 'Jos asennat FreshRSS-sovelluksen uudelleen, menetät kaikki aiemmin tekemäsi määritykset. Haluatko varmasti jatkaa?',
	),
	'language' => array(
		'_' => 'Kieli',
		'choose' => 'Valitse FreshRSS-sovelluksen kieli',
		'defined' => 'Kieli on määritetty.',
	),
	'missing_applied_migrations' => 'Jotain meni pieleen. Luo tyhjä tiedosto <em>%s</em> itse.',
	'ok' => 'Asennus onnistui.',
	'session' => array(
		'nok' => 'Web-palvelinta ei ole määritetty oikein PHP-istuntojen tarvitsemia evästeitä varten.',
	),
	'step' => 'vaihe %d',
	'steps' => 'Vaiheet',
	'this_is_the_end' => 'Asennus päättyy tähän',
	'title' => 'Asennus · FreshRSS',
);
