<?php

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
		'_' => 'Database',
		'conf' => array(
			'_' => 'Configurazione database',
			'ko' => 'Verifica le informazioni del database.',
			'ok' => 'Le configurazioni del database sono state salvate.',
		),
		'host' => 'Host',
		'prefix' => 'Prefisso tabella',
		'password' => 'Password del database',
		'type' => 'Tipo di database',
		'username' => 'Nome utente del database',
	),
	'check' => array(
		'_' => 'Controlli',
		'already_installed' => 'FreshRSS risulta già installato!',
		'cache' => array(
			'nok' => 'Verifica i permessi sulla cartella <em>./data/cache</em>. Il server HTTP deve avere i permessi per scriverci dentro',
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
			'nok' => 'Verifica i permessi sulla cartella <em>./data</em>. Il server HTTP deve avere i permessi per scriverci dentro',
			'ok' => 'I permessi sulla cartella data sono corretti.',
		),
		'dom' => array(
			'nok' => 'Manca una libreria richiesta per leggere DOM.',
			'ok' => 'Libreria richiesta per leggere DOM presente.',
		),
		'favicons' => array(
			'nok' => 'Verifica i permessi sulla cartella <em>./data/favicons</em>. Il server HTTP deve avere i permessi per scriverci dentro',
			'ok' => 'I permessi sulla cartella favicons sono corretti.',
		),
		'fileinfo' => array(
			'nok' => 'Manca il supporto per PHP fileinfo (pacchetto fileinfo).',
			'ok' => 'Estensione fileinfo presente.',
		),
		'http_referer' => array(
			'nok' => 'Per favore verifica che non stai alterando il tuo HTTP REFERER.',
			'ok' => 'Il tuo HTTP REFERER riconosciuto corrisponde al tuo server.',
		),
		'json' => array(
			'nok' => 'You lack a recommended library to parse JSON.',
			'ok' => 'You have a recommended library to parse JSON.',
		),
		'mbstring' => array(
			'nok' => 'Cannot find the recommended library mbstring for Unicode.',	//TODO
			'ok' => 'You have the recommended library mbstring for Unicode.',	//TODO
		),
		'minz' => array(
			'nok' => 'Manca il framework Minz.',
			'ok' => 'Framework Minz presente.',
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
			'_' => 'Installazione PHP',
			'nok' => 'Versione di PHP %s FreshRSS richiede almeno la versione %s.',
			'ok' => 'Versione di PHP %s, compatibile con FreshRSS.',
		),
		'users' => array(
			'nok' => 'Verifica i permessi sulla cartella <em>./data/users</em>. Il server HTTP deve avere i permessi per scriverci dentro',
			'ok' => 'I permessi sulla cartella users sono corretti.',
		),
		'xml' => array(
			'nok' => 'You lack the required library to parse XML.',
			'ok' => 'You have the required library to parse XML.',
		),
	),
	'conf' => array(
		'_' => 'Configurazioni generali',
		'ok' => 'Configurazioni generali salvate.',
	),
	'congratulations' => 'Congratulazione!',
	'default_user' => 'Username utente predefinito <small>(massimo 16 caratteri alfanumerici)</small>',
	'delete_articles_after' => 'Rimuovi articoli dopo',
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
	'not_deleted' => 'Qualcosa non ha funzionato; devi cancellare il file <em>%s</em> manualmente.',
	'ok' => 'Processo di installazione terminato con successo.',
	'step' => 'Passaggio %d',
	'steps' => 'Passaggi',
	'title' => 'Installazione · FreshRSS',
	'this_is_the_end' => 'Fine',
);
