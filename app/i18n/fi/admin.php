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
	'auth' => array(
		'allow_anonymous' => 'Salli kirjautumattomien käyttäjien lukea oletuskäyttäjän artikkeleita (%s)',
		'allow_anonymous_refresh' => 'Salli kirjautumattomien käyttäjien päivittää artikkelit',
		'api_enabled' => 'Salli <abbr>API</abbr>-käyttö <small>(pakollinen kännykkäsovelluksille and sharing user queries)</small>',	// DIRTY
		'form' => 'Web-lomake (perinteinen, käyttää JavaScriptiä)',
		'http' => 'HTTP (advanced: managed by Web server, OIDC, SSO…)',	// TODO
		'none' => 'Ei mitään (vaarallinen)',
		'title' => 'Todentaminen',
		'token' => 'Todentamisen päätunnisteväline',
		'token_help' => 'Sallii käyttäjän kaikkien RSS-tulosteiden käyttämisen sekä syötteiden päivityksen ilman todennusta:',
		'type' => 'Todentamismenetelmä',
		'unsafe_autologin' => 'Salli suojaamaton automaattinen sisäänkirjaus: ',
	),
	'check_install' => array(
		'cache' => array(
			'nok' => 'Tarkista hakemiston <em>./data/cache</em> oikeudet. HTTP-palvelimella on oltava kirjoitusoikeus.',
			'ok' => 'Cache-hakemiston oikeudet ovat oikein.',
		),
		'categories' => array(
			'nok' => 'Luokkataulu on määritetty väärin.',
			'ok' => 'Luokkataulu on määritetty oikein.',
		),
		'connection' => array(
			'nok' => 'Tietokantayhteyden muodostus ei onnistu.',
			'ok' => 'Tietokantayhteys on muodostettu.',
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
			'nok' => 'Tarkista hakemiston <em>./data</em> oikeudet. HTTP-palvelimella on oltava kirjoitusoikeus.',
			'ok' => 'Data-hakemiston oikeudet ovat oikein.',
		),
		'database' => 'Tietokannan asennus',
		'dom' => array(
			'nok' => 'DOM-rakenteen selaamiseen tarvittavaa kirjastoa ei löydy (php-xml-paketti).',
			'ok' => 'DOM-rakenteen selaamiseen tarvittava kirjasto löytyy.',
		),
		'entries' => array(
			'nok' => 'Merkintöjen taulu on määritetty väärin.',
			'ok' => 'Merkintöjen taulu on määritetty oikein.',
		),
		'favicons' => array(
			'nok' => 'Tarkista hakemiston <em>./data/favicons</em> oikeudet. HTTP-palvelimella on oltava kirjoitusoikeus.',
			'ok' => 'Favicons-hakemiston oikeudet ovat oikein.',
		),
		'feeds' => array(
			'nok' => 'Syötetaulu on määritetty väärin.',
			'ok' => 'Syötetaulukko on määritetty oikein.',
		),
		'fileinfo' => array(
			'nok' => 'PHP fileinfo -kirjastoa (fileinfo-paketti) ei löydy.',
			'ok' => 'Fileinfo-kirjasto löytyy.',
		),
		'files' => 'Tiedostojen asennus',
		'json' => array(
			'nok' => 'JSON-tukea (php-json-paketti) ei löydy.',
			'ok' => 'JSON-laajennus on käytössä.',
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
			'_' => 'PHP-asennus',
			'nok' => 'Asennettu PHP-versio on %s, mutta FreshRSS edellyttää vähintään versiota %s.',
			'ok' => 'Asennettu PHP-versio (%s) on yhteensopiva FreshRSS-sovelluksen kanssa.',
		),
		'tables' => array(
			'nok' => 'Tietokannasta puuttuu ainakin yksi taulu.',
			'ok' => 'Kaikki tarvittavat taulut ovat tietokannassa.',
		),
		'title' => 'Asennuksen tarkistus',
		'tokens' => array(
			'nok' => 'Tarkista hakemiston <em>./data/tokens</em> oikeudet. HTTP-palvelimella on oltava kirjoitusoikeus.',
			'ok' => 'Tokens-hakemiston oikeudet ovat oikein.',
		),
		'users' => array(
			'nok' => 'Tarkista hakemiston <em>./data/users</em> oikeudet. HTTP-palvelimella on oltava kirjoitusoikeus.',
			'ok' => 'Users-hakemiston oikeudet ovat oikein.',
		),
		'zip' => array(
			'nok' => 'ZIP-laajennusta ei löydy (php-zip-paketti).',
			'ok' => 'ZIP-laajennus on asennettu.',
		),
	),
	'extensions' => array(
		'author' => 'Tekijä',
		'community' => 'Käytettävissä olevat yhteisön tekemät laajennukset',
		'description' => 'Kuvaus',
		'disabled' => 'Poissa käytöstä',
		'empty_list' => 'Asennettuja laajennuksia ei ole',
		'empty_list_help' => 'Voit tarkistaa lokeista, miksi laajennusluettelo on tyhjä.',
		'enabled' => 'Käytössä',
		'latest' => 'Asennettu',
		'name' => 'Nimi',
		'no_configure_view' => 'Tätä laajennusta ei voi määrittää.',
		'system' => array(
			'_' => 'Järjestelmälaajennukset',
			'no_rights' => 'Järjestelmälaajennus (sinulla ei ole tarvittavia käyttöoikeuksia)',
		),
		'title' => 'Laajennukset',
		'update' => 'Päivitys saatavilla',
		'user' => 'Käyttäjän laajennukset',
		'version' => 'Versio',
	),
	'stats' => array(
		'_' => 'Tilastot',
		'all_feeds' => 'Kaikki syötteet',
		'category' => 'Luokka',
		'entry_count' => 'Artikkelien määrä',
		'entry_per_category' => 'Artikkelit luokan mukaan',
		'entry_per_day' => 'Artikkelit päivän mukaan (edelliset 30 päivää)',
		'entry_per_day_of_week' => 'Artikkelit viikonpäivän mukaan (keskiarvo: %.2f viestiä)',
		'entry_per_hour' => 'Tunnin mukaan (keskiarvo: %.2f viestiä)',
		'entry_per_month' => 'Kuukauden mukaan (keskiarvo: %.2f viestiä)',
		'entry_repartition' => 'Artikkelien uudelleenjaottelu',
		'feed' => 'Syöte',
		'feed_per_category' => 'Syötteitä luokassa',
		'idle' => 'Hiljentyneet syötteet',
		'main' => 'Päätilastot',
		'main_stream' => 'Pääsyötevirta',
		'no_idle' => 'Hiljentyneitä syötteitä ei ole.',
		'number_entries' => '%d artikkelia',
		'overview' => 'Overview',	// TODO
		'percent_of_total' => '% kaikista',
		'repartition' => 'Artikkelien uudelleenjaottelu: %s',
		'status_favorites' => 'Suosikit',
		'status_read' => 'Luetut',
		'status_total' => 'Yhteensä',
		'status_unread' => 'Lukemattomat',
		'title' => 'Tilastot',
		'top_feed' => '10 parasta syötettä',
	),
	'system' => array(
		'_' => 'Järjestelmän määritys',
		'auto-update-url' => 'Automaattisen päivityksen palvelimen URL',
		'base-url' => array(
			'_' => 'URL-pääosoite',
			'recommendation' => 'Automaattinen suositus: <kbd>%s</kbd>',
		),
		'cookie-duration' => array(
			'help' => 'sekunteina',
			'number' => 'Sisäänkirjauksen kesto',
		),
		'force_email_validation' => 'Pakota sähköpostiosoitteen vahvistus',
		'instance-name' => 'Instanssin nimi',
		'max-categories' => 'Luokkien enimmäismäärä käyttäjää kohti',
		'max-feeds' => 'Syötteiden enimmäismäärä käyttäjää kohti',
		'registration' => array(
			'number' => 'Tilien enimmäismäärä',
			'select' => array(
				'label' => 'Rekisteröintilomake',
				'option' => array(
					'noform' => 'Poissa käytöstä: ei rekisteröintilomaketta',
					'nolimit' => 'Käytössä: rajaton määrä tilejä',
					'setaccountsnumber' => 'Määritä tilien enimmäismäärä',
				),
			),
			'status' => array(
				'disabled' => 'Lomake poissa käytöstä',
				'enabled' => 'Lomake käytössä',
			),
			'title' => 'Käyttäjän rekisteröintilomake',
		),
		'sensitive-parameter' => 'Suojattu parametri. Muokkaa suoraan <kbd>./data/config.php</kbd>-tiedostossa.',
		'tos' => array(
			'disabled' => 'ei käytössä',
			'enabled' => '<a href="./?a=tos">käytössä</a>',
			'help' => 'Kuinka <a href="https://freshrss.github.io/FreshRSS/en/admins/12_User_management.html#enable-terms-of-service-tos" target="_blank">ottaa käyttöehdot käyttöön</a>',
		),
		'websub' => array(
			'help' => 'Tietoja <a href="https://freshrss.github.io/FreshRSS/en/users/WebSub.html" target="_blank">WebSub</a>-palvelusta',
		),
	),
	'update' => array(
		'_' => 'Päivitä FreshRSS',
		'apply' => 'Aloita päivitys',
		'changelog' => 'Muutokset',
		'check' => 'Tarkista päivitykset',
		'copiedFromURL' => 'update.php kopioitu osoitteesta %s hakemistoon ./data',
		'current_version' => 'Asennettu versio',
		'last' => 'Viimeksi tarkistettu',
		'loading' => 'Päivitetään…',
		'none' => 'Päivitystä ei ole',
		'releaseChannel' => array(
			'_' => 'Julkaisukanava',
			'edge' => 'Uusin versio (“edge”)',
			'latest' => 'Vakaa versio (“latest”)',
		),
		'title' => 'Päivitä FreshRSS',
		'viaGit' => 'Päivitys gitin ja GitHub.comin avulla on aloitettu',
	),
	'user' => array(
		'admin' => 'Pääkäyttäjä',
		'article_count' => 'Artikkeleita',
		'back_to_manage' => '← Palaa käyttäjäluetteloon',
		'create' => 'Luo uusi käyttäjä',
		'database_size' => 'Tietokannan koko',
		'email' => 'Sähköpostiosoite',
		'enabled' => 'Käytössä',
		'feed_count' => 'Syötteet',
		'is_admin' => 'Pääkäyttäjä',
		'language' => 'Kieli',
		'last_user_activity' => 'Viimeisin käyttäjän toiminta',
		'list' => 'Käyttäjäluettelo',
		'number' => '%d tili on luotu',
		'numbers' => '%d tiliä on luotu',
		'password_form' => 'Salasana<br /><small>(Web-lomakkeella kirjautumista varten)</small>',
		'password_format' => 'Vähintään 7 merkkiä',
		'title' => 'Hallinnoi käyttäjiä',
		'username' => 'Käyttäjätunnus',
	),
);
