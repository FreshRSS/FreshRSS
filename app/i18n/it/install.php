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
		'finish' => 'Installazione completata',
		'fix_errors_before' => 'Per favore correggi gli errori prima di passare al passaggio successivo.',
		'keep_install' => 'Mantieni configurazione precedente',
		'next_step' => 'Vai al prossimo passaggio',
		'reinstall' => 'Reinstalla FreshRSS',
	),
	'auth' => array(
		'form' => 'Web form (tradizionale, richiede JavaScript)',
		'http' => 'HTTP (per gli utenti avanzati con HTTPS)',
		'none' => 'Nessuno (pericoloso)',
		'password_form' => 'Password<br /><small>(per il login tramite Web-form tradizionale)</small>',
		'password_format' => 'Almeno 7 caratteri',
		'type' => 'Metodo di autenticazione',
	),
	'bdd' => array(
		'_' => 'Database',	// TODO
		'conf' => array(
			'_' => 'Configurazione database',
			'ko' => 'Verifica le informazioni del database.',
			'ok' => 'Le configurazioni del database sono state salvate.',
		),
		'host' => 'Host',	// TODO
		'password' => 'Password del database',
		'prefix' => 'Prefisso tabella',
		'type' => 'Tipo di database',
		'username' => 'Nome utente del database',
	),
	'check' => array(
		'_' => 'Controlli',
		'already_installed' => 'FreshRSS risulta già installato!',
		'cache' => array(
			'nok' => 'Verifica i permessi sulla cartella <em>%s</em>. Il server HTTP deve avere i permessi per scriverci dentro.',
			'ok' => 'I permessi sulla cartella della cache sono corretti.',
		),
		'ctype' => array(
			'nok' => 'Manca una libreria richiesta per il controllo dei caratteri (php-ctype).',
			'ok' => 'Libreria richiesta per il controllo dei caratteri presente (ctype).',
		),
		'curl' => array(
			'nok' => 'Manca il supporto per cURL (pacchetto php-curl).',
			'ok' => 'Estensione cURL presente.',
		),
		'data' => array(
			'nok' => 'Verifica i permessi sulla cartella <em>%s</em>. Il server HTTP deve avere i permessi per scriverci dentro.',
			'ok' => 'I permessi sulla cartella data sono corretti.',
		),
		'dom' => array(
			'nok' => 'Manca una libreria richiesta per leggere DOM.',
			'ok' => 'Libreria richiesta per leggere DOM presente.',
		),
		'favicons' => array(
			'nok' => 'Verifica i permessi sulla cartella <em>%s</em>. Il server HTTP deve avere i permessi per scriverci dentro.',
			'ok' => 'I permessi sulla cartella favicons sono corretti.',
		),
		'fileinfo' => array(
			'nok' => 'Manca il supporto per PHP fileinfo (pacchetto fileinfo).',
			'ok' => 'Estensione fileinfo presente.',
		),
		'json' => array(
			'nok' => 'You lack a recommended library to parse JSON.',
			'ok' => 'You have the recommended library to parse JSON.',	// TODO
		),
		'mbstring' => array(
			'nok' => 'Cannot find the recommended library mbstring for Unicode.',	// TODO
			'ok' => 'You have the recommended library mbstring for Unicode.',	// TODO
		),
		'pcre' => array(
			'nok' => 'Manca una libreria richiesta per le regular expressions (php-pcre).',
			'ok' => 'Libreria richiesta per le regular expressions presente (PCRE).',
		),
		'pdo' => array(
			'nok' => 'Manca PDO o uno degli altri driver supportati (pdo_mysql, pdo_sqlite, pdo_pgsql).',
			'ok' => 'PDO e altri driver supportati (pdo_mysql, pdo_sqlite, pdo_pgsql).',
		),
		'php' => array(
			'nok' => 'Versione di PHP %s FreshRSS richiede almeno la versione %s.',
			'ok' => 'Versione di PHP %s, compatibile con FreshRSS.',
		),
		'reload' => 'Controlla di nuovo',
		'tmp' => array(
			'nok' => 'Verifica i permessi sulla cartella <em>%s</em>. Il server HTTP deve avere i permessi per scriverci dentro.',
			'ok' => 'Permissions on the temp directory are good.',	// TODO
		),
		'unknown_process_username' => 'unknown',	// TODO
		'users' => array(
			'nok' => 'Verifica i permessi sulla cartella <em>%s</em>. Il server HTTP deve avere i permessi per scriverci dentro.',
			'ok' => 'I permessi sulla cartella users sono corretti.',
		),
		'xml' => array(
			'nok' => 'You lack the required library to parse XML.',
			'ok' => 'You have the required library to parse XML.',	// TODO
		),
	),
	'conf' => array(
		'_' => 'Configurazioni generali',
		'ok' => 'Configurazioni generali salvate.',
	),
	'congratulations' => 'Congratulazione!',
	'default_user' => 'Username utente predefinito <small>(massimo 16 caratteri alfanumerici)</small>',
	'fix_errors_before' => 'Per favore correggi gli errori prima di passare al passaggio successivo.',
	'javascript_is_better' => 'FreshRSS funziona meglio con JavaScript abilitato',
	'js' => array(
		'confirm_reinstall' => 'Reinstallando FreshRSS perderai la configurazione precedente. Sei sicuro di voler procedere?',
	),
	'language' => array(
		'_' => 'Lingua',
		'choose' => 'Seleziona la lingua per FreshRSS',
		'defined' => 'Lingua impostata.',
	),
	'missing_applied_migrations' => 'Something went wrong; you should create an empty file <em>%s</em> manually.',	// TODO
	'ok' => 'Processo di installazione terminato con successo.',
	'session' => array(
		'nok' => 'The web server seems to be incorrectly configured for cookies required for PHP sessions!',	// TODO
	),
	'step' => 'Passaggio %d',
	'steps' => 'Passaggi',
	'this_is_the_end' => 'Fine',
	'title' => 'Installazione · FreshRSS',
);
