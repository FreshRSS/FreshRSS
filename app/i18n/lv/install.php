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
		'finish' => 'Pabeigt uzstādīšanu',
		'fix_errors_before' => 'Lūdzu, pirms nākamā soļa turpināšanas izlabojiet visas kļūdas.',
		'keep_install' => 'Saglabāt iepriekšējo konfigurāciju',
		'next_step' => 'Iet uz nākamo soli',
		'reinstall' => 'Pārinstalēt FreshRSS',
	),
	'bdd' => array(
		'_' => 'Datubāze',
		'conf' => array(
			'_' => 'Datubāzes konfigurācija',
			'ko' => 'Pārbaudiet datubāzes konfigurāciju.',
			'ok' => 'Datubāzes konfigurācija ir saglabāta.',
		),
		'host' => 'Saimnieks',
		'password' => 'Datubāzes parole',
		'prefix' => 'Tabulas prefikss',
		'type' => 'Datubāzes veids',
		'username' => 'Datubāzes lietotājvārds',
	),
	'check' => array(
		'_' => 'Pārbaudes',
		'already_installed' => 'Mēs esam konstatējuši, ka FreshRSS jau ir instalēts!',
		'cache' => array(
			'nok' => 'Pārbaudiet atļaujas <em>%1$s</em> mapē priekš lietotāja <em>%2$s</em>. HTTP serverim jābūt piešķirtām rakstīšanas atļaujām.',
			'ok' => 'Kešatmiņas mapes atļaujas ir pareizas.',
		),
		'ctype' => array(
			'nok' => 'Nevar atrast nepieciešamo bibliotēku rakstzīmju tipa pārbaudei (php-ctype).',
			'ok' => 'Jums ir nepieciešamā bibliotēka rakstzīmju tipa pārbaudei (ctype).',
		),
		'curl' => array(
			'nok' => 'Nevar atrast cURL bibliotēku (php-curl pakotne).',
			'ok' => 'Jums ir cURL bibliotēka.',
		),
		'data' => array(
			'nok' => 'Pārbaudiet atļaujas <em>%1$s</em> mapē priekš lietotāja <em>%2$s</em>. HTTP serverim jābūt piešķirtām rakstīšanas atļaujām.',
			'ok' => 'Ar datu mapes atļaujām viss ir kārtībā.',
		),
		'dom' => array(
			'nok' => 'Nevar atrast nepieciešamo bibliotēku, lai pārlūkotu DOM (php-xml pakete).',
			'ok' => 'Jums ir nepieciešamā bibliotēka, lai pārlūkotu DOM.',
		),
		'favicons' => array(
			'nok' => 'Pārbaudiet atļaujas <em>%1$s</em> mapē priekš lietotāja <em>%2$s</em>. HTTP serverim jābūt piešķirtām rakstīšanas atļaujām.',
			'ok' => 'Ar favikonu mapes atļaujām viss ir kārtībā.',
		),
		'fileinfo' => array(
			'nok' => 'Nevar atrast PHP fileinfo bibliotēku (fileinfo pakotne).',
			'ok' => 'Jums ir fileinfo bibliotēka.',
		),
		'json' => array(
			'nok' => 'Nevar atrast JSON (php-json pakete).',
			'ok' => 'Jums ir JSON paplašinājums.',
		),
		'mbstring' => array(
			'nok' => 'Nevar atrast ieteikto mbstring bibliotēku priekš Unicode.',
			'ok' => 'Jums ir ieteiktā mbstring bibliotēka priekš Unicode.',
		),
		'pcre' => array(
			'nok' => 'Nevar atrast nepieciešamo bibliotēku regulārajām izteiksmēm (php-pcre).',
			'ok' => 'Jums ir nepieciešamā regulāro izteiksmju bibliotēka (PCRE).',
		),
		'pdo' => array(
			'nok' => 'Nevar atrast PDO vai kādu no atbalstītajiem draiveriem (pdo_mysql, pdo_sqlite, pdo_pgsql).',
			'ok' => 'Jums ir PDO un vismaz viens no atbalstītajiem draiveriem (pdo_mysql, pdo_sqlite, pdo_pgsql).',
		),
		'php' => array(
			'nok' => 'Jūsu PHP versija ir %s, bet FreshRSS nepieciešama vismaz %s versija.',
			'ok' => 'Jūsu PHP versija (%s) ir saderīga ar FreshRSS.',
		),
		'reload' => 'Pārbaudiet atkal',
		'tmp' => array(
			'nok' => 'Pārbaudiet atļaujas <em>%1$s</em> mapē priekš lietotāja <em>%2$s</em>. HTTP serverim jābūt piešķirtām rakstīšanas atļaujām.',
			'ok' => 'Ar pagaidu mapes atļaujām viss ir kārtībā.',
		),
		'unknown_process_username' => 'unknown',	// TODO
		'users' => array(
			'nok' => 'Pārbaudiet atļaujas <em>%1$s</em> mapē priekš lietotāja <em>%2$s</em>. HTTP serverim jābūt piešķirtām rakstīšanas atļaujām.',
			'ok' => 'Ar lietotāju mapes atļaujām viss ir kārtībā.',
		),
		'xml' => array(
			'nok' => 'Nevar atrast nepieciešamo bibliotēku XML analizēšanai.',
			'ok' => 'Jums ir XML analizēšanai nepieciešamā bibliotēka.',
		),
	),
	'conf' => array(
		'_' => 'Vispārējā konfigurācija',
		'ok' => 'Vispārējā konfigurācija ir saglabāta.',
	),
	'congratulations' => 'Apsveicam!',
	'default_user' => array(
		'_' => 'Noklusējuma lietotāja lietotājvārds',
		'max_char' => 'ne vairāk kā 16 burtu un ciparu zīmes',
	),
	'fix_errors_before' => 'Lūdzu izlabojat kļūdas pirms ejat uz nākamo soli.',
	'javascript_is_better' => 'FreshRSS ir patīkamāks, ja ir iespējots JavaScript',
	'js' => array(
		'confirm_reinstall' => 'Pārinstalējot FreshRSS, jūs zaudēsiet iepriekšējo konfigurāciju. Vai esat pārliecināts, ka vēlaties turpināt?',
	),
	'language' => array(
		'_' => 'Valoda',
		'choose' => 'Izvēlaties FreshRSS valodu',
		'defined' => 'Valoda ir definēta.',
	),
	'missing_applied_migrations' => 'Kaut kas ir nogājis greizi; jums vajadzētu izveidot tukšu failu <em>%s</em> manuāli.',
	'ok' => 'Instalēšanas process bija veiksmīgs.',
	'session' => array(
		'nok' => 'Šķiet, ka tīmekļa serveris ir nepareizi konfigurēts attiecībā uz PHP sesijām nepieciešamajiem sīkfailiem!',
	),
	'step' => 'solis %d',
	'steps' => 'Soļi',
	'this_is_the_end' => 'Šīs ir beigas',
	'title' => 'Instalācija · FreshRSS',
);
