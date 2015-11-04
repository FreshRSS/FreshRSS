<?php

return array(
	'action' => array(
		'finish' => 'Installazione completata',
		'fix_errors_before' => 'Per favore correggi gli errori prima di passare al passaggio successivo.',
		'keep_install' => 'Mantieni installazione precedente',
		'next_step' => 'Vai al prossimo passaggio',
		'reinstall' => 'Reinstalla FreshRSS',
	),
	'auth' => array(
		'email_persona' => 'Indirizzo mail<br /><small>(per <a href="https://persona.org/" rel="external">Mozilla Persona</a>)</small>',
		'form' => 'Web form (tradizionale, richiede JavaScript)',
		'http' => 'HTTP (per gli utenti avanzati con HTTPS)',
		'none' => 'Nessuno (pericoloso)',
		'password_form' => 'Password<br /><small>(per il login tramite Web-form tradizionale)</small>',
		'password_format' => 'Almeno 7 caratteri',
		'persona' => 'Mozilla Persona (moderno, richiede JavaScript)',
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
		'password' => 'HTTP password',
		'type' => 'Tipo di database',
		'username' => 'HTTP username',
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
			'nok' => 'Manca il supporto per cURL (pacchetto php5-curl).',
			'ok' => 'Estensione cURL presente.',
		),
		'data' => array(
			'nok' => 'Verifica i permessi sulla cartella <em>./data</em>. Il server HTTP deve avere i permessi per scriverci dentro',
			'ok' => 'I permessi sulla cartella data sono corretti.',
		),
		'dom' => array(
			'nok' => 'Manca una libreria richiesta per leggere DOM (pacchetto php-xml).',
			'ok' => 'Libreria richiesta per leggere DOM presente.',
		),
		'favicons' => array(
			'nok' => 'Verifica i permessi sulla cartella <em>./data/favicons</em>. Il server HTTP deve avere i permessi per scriverci dentro',
			'ok' => 'I permessi sulla cartella favicons sono corretti.',
		),
		'http_referer' => array(
			'nok' => 'Per favore verifica che non stai alterando il tuo HTTP REFERER.',
			'ok' => 'Il tuo HTTP REFERER riconosciuto corrisponde al tuo server.',
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
			'nok' => 'Manca PDO o uno degli altri driver supportati (pdo_mysql, pdo_sqlite).',
			'ok' => 'PDO e altri driver supportati (pdo_mysql, pdo_sqlite).',
		),
		'persona' => array(
			'nok' => 'Verifica i permessi sulla cartella <em>./data/persona</em>. Il server HTTP deve avere i permessi per scriverci dentro',
			'ok' => 'I permessi sulla cartella Mozilla Persona sono corretti.',
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
