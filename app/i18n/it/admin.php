<?php

return array(
	'auth' => array(
		'allow_anonymous' => 'Consenti la lettura agli utenti anonimi degli articoli dell utente predefinito (%s)',
		'allow_anonymous_refresh' => 'Consenti agli utenti anonimi di aggiornare gli articoli',
		'api_enabled' => 'Consenti le <abbr>API</abbr> di accesso <small>(richiesto per le app mobili)</small>',
		'form' => 'Web form (tradizionale, richiede JavaScript)',
		'http' => 'HTTP (per gli utenti avanzati con HTTPS)',
		'none' => 'Nessuno (pericoloso)',
		'title' => 'Autenticazione',
		'title_reset' => 'Reset autenticazione',
		'token' => 'Token di autenticazione',
		'token_help' => 'Consenti accesso agli RSS dell utente predefinito senza autenticazione:',
		'type' => 'Metodo di autenticazione',
		'unsafe_autologin' => 'Consenti accesso automatico non sicuro usando il formato: ',
	),
	'check_install' => array(
		'cache' => array(
			'nok' => 'Verifica i permessi sulla cartella <em>./data/cache</em>. Il server HTTP deve avere i permessi per scriverci dentro',
			'ok' => 'I permessi sulla cartella della cache sono corretti.',
		),
		'categories' => array(
			'nok' => 'La tabella delle categorie ha una configurazione errata.',
			'ok' => 'Tabella delle categorie OK.',
		),
		'connection' => array(
			'nok' => 'La connessione al database non può essere stabilita.',
			'ok' => 'Connessione al database OK',
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
		'database' => 'Installazione database',
		'dom' => array(
			'nok' => 'Manca una libreria richiesta per leggere DOM (pacchetto php-xml).',
			'ok' => 'Libreria richiesta per leggere DOM presente.',
		),
		'entries' => array(
			'nok' => 'La tabella Entry ha una configurazione errata.',
			'ok' => 'Tabella Entry OK.',
		),
		'favicons' => array(
			'nok' => 'Verifica i permessi sulla cartella <em>./data/favicons</em>. Il server HTTP deve avere i permessi per scriverci dentro',
			'ok' => 'I permessi sulla cartella favicons sono corretti.',
		),
		'feeds' => array(
			'nok' => 'La tabella Feed ha una configurazione errata.',
			'ok' => 'Tabella Feed OK.',
		),
		'fileinfo' => array(
			'nok' => 'Manca il supporto per PHP fileinfo (pacchetto fileinfo).',
			'ok' => 'Estensione fileinfo presente.',
		),
		'files' => 'Installazione files',
		'json' => array(
			'nok' => 'Manca il supoorto a JSON (pacchetto php-json).',
			'ok' => 'Estensione JSON presente.',
		),
		'mbstring' => array(
			'nok' => 'Cannot find the recommended library mbstring for Unicode.',	// TODO - Translation
			'ok' => 'You have the recommended library mbstring for Unicode.',	// TODO - Translation
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
			'nok' => 'Versione PHP %s FreshRSS richiede almeno la versione %s.',
			'ok' => 'Versione PHP %s, compatibile con FreshRSS.',
			'_' => 'Installazione PHP',
		),
		'tables' => array(
			'nok' => 'Rilevate tabelle mancanti nel database.',
			'ok' => 'Tutte le tabelle sono presenti nel database.',
		),
		'title' => 'Verifica installazione',
		'tokens' => array(
			'nok' => 'Verifica i permessi sulla cartella <em>./data/tokens</em>. Il server HTTP deve avere i permessi per scriverci dentro',
			'ok' => 'I permessi sulla cartella tokens sono corretti.',
		),
		'users' => array(
			'nok' => 'Verifica i permessi sulla cartella <em>./data/users</em>. Il server HTTP deve avere i permessi per scriverci dentro',
			'ok' => 'I permessi sulla cartella users sono corretti.',
		),
		'zip' => array(
			'nok' => 'Manca estensione ZIP (pacchetto php-zip).',
			'ok' => 'Estensione ZIP presente.',
		),
	),
	'extensions' => array(
		'author' => 'Author',	// TODO - Translation
		'community' => 'Available community extensions',	// TODO - Translation
		'description' => 'Description',	// TODO - Translation
		'disabled' => 'Disabilitata',
		'empty_list' => 'Non ci sono estensioni installate',
		'enabled' => 'Abilitata',
		'latest' => 'Installed',	// TODO - Translation
		'name' => 'Name',	// TODO - Translation
		'no_configure_view' => 'Questa estensioni non può essere configurata.',
		'system' => array(
			'no_rights' => 'Estensione di sistema (non hai i permessi su questo tipo)',
			'_' => 'Estensioni di sistema',
		),
		'title' => 'Estensioni',
		'update' => 'Update available',	// TODO - Translation
		'user' => 'Estensioni utente',
		'version' => 'Version',	// TODO - Translation
	),
	'stats' => array(
		'all_feeds' => 'Tutti i feeds',
		'category' => 'Categoria',
		'entry_count' => 'Articoli',
		'entry_per_category' => 'Articoli per categoria',
		'entry_per_day' => 'Articoli per giorno (ultimi 30 giorni)',
		'entry_per_day_of_week' => 'Per giorno della settimana (media: %.2f articoli)',
		'entry_per_hour' => 'Per ora (media: %.2f articoli)',
		'entry_per_month' => 'Per mese (media: %.2f articoli)',
		'entry_repartition' => 'Ripartizione contenuti',
		'feed' => 'Feed',	// TODO - Translation
		'feed_per_category' => 'Feeds per categoria',
		'idle' => 'Feeds non aggiornati',
		'main' => 'Statistiche principali',
		'main_stream' => 'Flusso principale',
		'menu' => array(
			'idle' => 'Feeds non aggiornati',
			'main' => 'Statistiche principali',
			'repartition' => 'Ripartizione articoli',
		),
		'no_idle' => 'Non ci sono feed non aggiornati',
		'number_entries' => '%d articoli',
		'percent_of_total' => '%% del totale',
		'repartition' => 'Ripartizione articoli',
		'status_favorites' => 'Preferiti',
		'status_read' => 'Letti',
		'status_total' => 'Totale',
		'status_unread' => 'Non letti',
		'title' => 'Statistiche',
		'top_feed' => 'I migliori 10 feeds',
		'_' => 'Statistiche',
	),
	'system' => array(
		'auto-update-url' => 'Auto-update server URL',	// TODO - Translation
		'cookie-duration' => array(
			'help' => 'in seconds',	// TODO - Translation
			'number' => 'Duration to keep logged in',	// TODO - Translation
		),
		'force_email_validation' => 'Force email addresses validation',	// TODO - Translation
		'instance-name' => 'Nome istanza',
		'max-categories' => 'Limite categorie per utente',
		'max-feeds' => 'Limite feeds per utente',
		'registration' => array(
			'help' => '0 significa che non esiste limite sui profili',
			'number' => 'Numero massimo di profili',
		),
		'_' => 'Configurazione di sistema',
	),
	'update' => array(
		'apply' => 'Applica',
		'check' => 'Controlla la presenza di nuovi aggiornamenti',
		'current_version' => 'FreshRSS versione %s.',
		'last' => 'Ultima verifica: %s',
		'none' => 'Nessun aggiornamento da applicare',
		'title' => 'Aggiorna sistema',
		'_' => 'Aggiornamento sistema',
	),
	'user' => array(
		'articles_and_size' => '%s articoli (%s)',
		'article_count' => 'Articles',	// TODO - Translation
		'back_to_manage' => '← Return to user list',	// TODO - Translation
		'create' => 'Crea nuovo utente',
		'database_size' => 'Database size',	// TODO - Translation
		'delete_users' => 'Delete user',	// TODO - Translation
		'email' => 'Email address',	// TODO - Translation
		'feed_count' => 'Feeds',	// TODO - Translation
		'language' => 'Lingua',
		'list' => 'User list',	// TODO - Translation
		'number' => ' %d profilo utente creato',
		'numbers' => 'Sono presenti %d profili utente',
		'password_form' => 'Password<br /><small>(per il login classico)</small>',
		'password_format' => 'Almeno 7 caratteri',
		'selected' => 'Selected user',	// TODO - Translation
		'title' => 'Gestione utenti',
		'update_users' => 'Update user',	// TODO - Translation
		'username' => 'Nome utente',
		'users' => 'Utenti',
		'user_list' => 'Lista utenti',
	),
);
