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

return [
	'auth' => [
		'allow_anonymous' => 'Consenti la lettura agli utenti anonimi degli articoli dell utente predefinito (%s)',
		'allow_anonymous_refresh' => 'Consenti agli utenti anonimi di aggiornare gli articoli',
		'api_enabled' => 'Consenti le <abbr>API</abbr> di accesso <small>(richiesto per le app mobili)</small>',
		'form' => 'Web form (tradizionale, richiede JavaScript)',
		'http' => 'HTTP (per gli utenti avanzati con HTTPS)',
		'none' => 'Nessuno (pericoloso)',
		'title' => 'Autenticazione',
		'token' => 'Token di autenticazione',
		'token_help' => 'Consenti accesso agli RSS dell utente predefinito senza autenticazione:',
		'type' => 'Metodo di autenticazione',
		'unsafe_autologin' => 'Consenti accesso automatico non sicuro usando il formato: ',
	],
	'check_install' => [
		'cache' => [
			'nok' => 'Verifica i permessi sulla cartella <em>./data/cache</em>. Il server HTTP deve avere i permessi per scriverci dentro',
			'ok' => 'I permessi sulla cartella della cache sono corretti.',
		],
		'categories' => [
			'nok' => 'La tabella delle categorie ha una configurazione errata.',
			'ok' => 'Tabella delle categorie OK.',
		],
		'connection' => [
			'nok' => 'La connessione al database non può essere stabilita.',
			'ok' => 'Connessione al database OK',
		],
		'ctype' => [
			'nok' => 'Manca una libreria richiesta per il controllo dei caratteri (php-ctype).',
			'ok' => 'Libreria richiesta per il controllo dei caratteri presente (ctype).',
		],
		'curl' => [
			'nok' => 'Manca il supporto per cURL (pacchetto php-curl).',
			'ok' => 'Estensione cURL presente.',
		],
		'data' => [
			'nok' => 'Verifica i permessi sulla cartella <em>./data</em>. Il server HTTP deve avere i permessi per scriverci dentro',
			'ok' => 'I permessi sulla cartella data sono corretti.',
		],
		'database' => 'Installazione database',
		'dom' => [
			'nok' => 'Manca una libreria richiesta per leggere DOM (pacchetto php-xml).',
			'ok' => 'Libreria richiesta per leggere DOM presente.',
		],
		'entries' => [
			'nok' => 'La tabella Entry ha una configurazione errata.',
			'ok' => 'Tabella Entry OK.',
		],
		'favicons' => [
			'nok' => 'Verifica i permessi sulla cartella <em>./data/favicons</em>. Il server HTTP deve avere i permessi per scriverci dentro',
			'ok' => 'I permessi sulla cartella favicons sono corretti.',
		],
		'feeds' => [
			'nok' => 'La tabella Feed ha una configurazione errata.',
			'ok' => 'Tabella Feed OK.',
		],
		'fileinfo' => [
			'nok' => 'Manca il supporto per PHP fileinfo (pacchetto fileinfo).',
			'ok' => 'Estensione fileinfo presente.',
		],
		'files' => 'Installazione files',
		'json' => [
			'nok' => 'Manca il supoorto a JSON (pacchetto php-json).',
			'ok' => 'Estensione JSON presente.',
		],
		'mbstring' => [
			'nok' => 'Non è possibile trovare la libreria mbstring raccomandata per Unicode.',
			'ok' => 'Ha la libreria mbstring raccomandata per Unicode.',
		],
		'pcre' => [
			'nok' => 'Manca una libreria richiesta per le regular expressions (php-pcre).',
			'ok' => 'Libreria richiesta per le regular expressions presente (PCRE).',
		],
		'pdo' => [
			'nok' => 'Manca PDO o uno degli altri driver supportati (pdo_mysql, pdo_sqlite, pdo_pgsql).',
			'ok' => 'PDO e altri driver supportati (pdo_mysql, pdo_sqlite, pdo_pgsql).',
		],
		'php' => [
			'_' => 'Installazione PHP',
			'nok' => 'Versione PHP %s FreshRSS richiede almeno la versione %s.',
			'ok' => 'Versione PHP %s, compatibile con FreshRSS.',
		],
		'tables' => [
			'nok' => 'Rilevate tabelle mancanti nel database.',
			'ok' => 'Tutte le tabelle sono presenti nel database.',
		],
		'title' => 'Verifica installazione',
		'tokens' => [
			'nok' => 'Verifica i permessi sulla cartella <em>./data/tokens</em>. Il server HTTP deve avere i permessi per scriverci dentro',
			'ok' => 'I permessi sulla cartella tokens sono corretti.',
		],
		'users' => [
			'nok' => 'Verifica i permessi sulla cartella <em>./data/users</em>. Il server HTTP deve avere i permessi per scriverci dentro',
			'ok' => 'I permessi sulla cartella users sono corretti.',
		],
		'zip' => [
			'nok' => 'Manca estensione ZIP (pacchetto php-zip).',
			'ok' => 'Estensione ZIP presente.',
		],
	],
	'extensions' => [
		'author' => 'Autore',
		'community' => 'Estensioni della community disponibili',
		'description' => 'Descrizione',
		'disabled' => 'Disabilitata',
		'empty_list' => 'Non ci sono estensioni installate',
		'enabled' => 'Abilitata',
		'latest' => 'Installato',
		'name' => 'Nome',
		'no_configure_view' => 'Questa estensioni non può essere configurata.',
		'system' => [
			'_' => 'Estensioni di sistema',
			'no_rights' => 'Estensione di sistema (non hai i permessi su questo tipo)',
		],
		'title' => 'Estensioni',
		'update' => 'Aggiornamento disponibile',
		'user' => 'Estensioni utente',
		'version' => 'Versione',
	],
	'stats' => [
		'_' => 'Statistiche',
		'all_feeds' => 'Tutti i feeds',
		'category' => 'Categoria',
		'entry_count' => 'Articoli',
		'entry_per_category' => 'Articoli per categoria',
		'entry_per_day' => 'Articoli per giorno (ultimi 30 giorni)',
		'entry_per_day_of_week' => 'Per giorno della settimana (media: %.2f articoli)',
		'entry_per_hour' => 'Per ora (media: %.2f articoli)',
		'entry_per_month' => 'Per mese (media: %.2f articoli)',
		'entry_repartition' => 'Ripartizione contenuti',
		'feed' => 'Feed',	// IGNORE
		'feed_per_category' => 'Feeds per categoria',
		'idle' => 'Feeds non aggiornati',
		'main' => 'Statistiche principali',
		'main_stream' => 'Flusso principale',
		'no_idle' => 'Non ci sono feed non aggiornati',
		'number_entries' => '%d articoli',
		'percent_of_total' => '% del totale',
		'repartition' => 'Ripartizione articoli',
		'status_favorites' => 'Preferiti',
		'status_read' => 'Letti',
		'status_total' => 'Totale',
		'status_unread' => 'Non letti',
		'title' => 'Statistiche',
		'top_feed' => 'I migliori 10 feeds',
	],
	'system' => [
		'_' => 'Configurazione di sistema',
		'auto-update-url' => 'Aggiorna automaticamente l’URL del server',

		'base-url' => [
			'_' => 'URL base',
			'recommendation' => 'Suggerimento automatico: <kbd>%s</kbd>',
		],
		'cookie-duration' => [
			'help' => 'in secondi',
			'number' => 'Tempo in cui rimanere loggati',
		],
		'force_email_validation' => 'Forza la validazione dell’indirizzo mail',
		'instance-name' => 'Nome istanza',
		'max-categories' => 'Limite categorie per utente',
		'max-feeds' => 'Limite feeds per utente',
		'registration' => [
			'number' => 'Numero massimo di profili',
			'select' => [
				'label' => 'Form di registrazione',
				'option' => [
					'noform' => 'Disabilitato: Nessun form di registrazione',
					'nolimit' => 'Abilitato: Nessun limite agli account',
					'setaccountsnumber' => 'Imposta il numero massimo di account',
				],
			],
			'status' => [
				'disabled' => 'Form disabilitato',
				'enabled' => 'Form abilitato',
			],
			'title' => 'Form di registrazione utente',
		],
		'sensitive-parameter' => 'Parametro sensibile. Modificalo manualmente in <kbd>./data/config.php</kbd>',
		'tos' => [
			'disabled' => 'non fornito',
			'enabled' => '<a href="./?a=tos">è abilitato</a>',
			'help' => 'Come <a href="https://freshrss.github.io/FreshRSS/en/admins/12_User_management.html#enable-terms-of-service-tos" target="_blank">abilitare i termini e condizioni</a>',
		],
		'websub' => [
			'help' => 'Riguardo <a href="https://freshrss.github.io/FreshRSS/en/users/WebSub.html" target="_blank">WebSub</a>',
		],
	],
	'update' => [
		'_' => 'Aggiornamento sistema',
		'apply' => 'Applica',
		'changelog' => 'Lista dei cambiamenti',
		'check' => 'Controlla la presenza di nuovi aggiornamenti',
		'copiedFromURL' => 'update.php copiato da %s a ./data',
		'current_version' => 'Versione',
		'last' => 'Ultima verifica',
		'loading' => 'Aggiornamentose…',
		'none' => 'Nessun aggiornamento da applicare',
		'releaseChannel' => [
			'_' => 'Canale di rilascio',
			'edge' => 'Rilascio continuo “edge”)',
			'latest' => 'Stabile “latest”)',
		],
		'title' => 'Aggiorna sistema',
		'viaGit' => 'Aggiornamento tramite git e Github.com avviato',
	],
	'user' => [
		'admin' => 'Amministratore',
		'article_count' => 'Articoli',
		'back_to_manage' => '← Ritorna alla lista utenti',
		'create' => 'Crea nuovo utente',
		'database_size' => 'Dimensione del database',
		'email' => 'Indirizzo e-mail',
		'enabled' => 'Abilitato',
		'feed_count' => 'Feed',
		'is_admin' => 'Amministratore',
		'language' => 'Lingua',
		'last_user_activity' => 'Ultime attività degli utenti',
		'list' => 'Lista utenti',
		'number' => ' %d profilo utente creato',
		'numbers' => 'Sono presenti %d profili utente',
		'password_form' => 'Password<br /><small>per il login classico)</small>',
		'password_format' => 'Almeno 7 caratteri',
		'title' => 'Gestione utenti',
		'username' => 'Nome utente',
	],
];
