<?php

return array(
	'admin' => array(
		'optimization_complete' => 'Ottimizzazione completata',
	),
	'access' => array(
		'denied' => 'Non hai i permessi per accedere a questa pagina',
		'not_found' => 'Pagina non disponibile',
	),
	'auth' => array(
		'form' => array(
			'not_set' => 'Si è verificato un problema alla configurazione del sistema di autenticazione. Per favore riprova più tardi.',
			'set' => 'Sistema di autenticazione tramite Form impostato come predefinito.',
		),
		'login' => array(
			'invalid' => 'Autenticazione non valida',
			'success' => 'Autenticazione effettuata',
		),
		'logout' => array(
			'success' => 'Disconnessione effettuata',
		),
		'no_password_set' => 'Password di amministrazione non impostata. Opzione non disponibile.',
	),
	'conf' => array(
		'error' => 'Si è verificato un errore durante il salvataggio della configurazione',
		'query_created' => 'Ricerca "%s" creata.',
		'shortcuts_updated' => 'Collegamenti tastiera aggiornati',
		'updated' => 'Configurazione aggiornata',
	),
	'extensions' => array(
		'already_enabled' => '%s è già abilitata',
		'disable' => array(
			'ko' => '%s non può essere disabilitata. <a href="%s">Verifica i logs</a> per dettagli.',
			'ok' => '%s è disabilitata',
		),
		'enable' => array(
			'ko' => '%s non può essere abilitata. <a href="%s">Verifica i logs</a> per dettagli.',
			'ok' => '%s è ora abilitata',
		),
		'no_access' => 'Accesso negato a %s',
		'not_enabled' => '%s non abilitato',
		'not_found' => '%s non disponibile',
	),
	'import_export' => array(
		'export_no_zip_extension' => 'Estensione Zip non presente sul server. Per favore esporta i files singolarmente.',
		'feeds_imported' => 'I tuoi feed sono stati importati e saranno aggiornati',
		'feeds_imported_with_errors' => 'I tuoi feeds sono stati importati ma si sono verificati alcuni errori',
		'file_cannot_be_uploaded' => 'Il file non può essere caricato!',
		'no_zip_extension' => 'Estensione Zip non presente sul server.',
		'zip_error' => 'Si è verificato un errore importando il file Zip',
	),
	'sub' => array(
		'actualize' => 'Aggiorna',
		'category' => array(
			'created' => 'Categoria %s creata.',
			'deleted' => 'Categoria cancellata',
			'emptied' => 'Categoria svuotata',
			'error' => 'Categoria non aggiornata',
			'name_exists' => 'Categoria già esistente.',
			'no_id' => 'Categoria senza ID.',
			'no_name' => 'Il nome della categoria non può essere lasciato vuoto.',
			'not_delete_default' => 'Non puoi cancellare la categoria predefinita!',
			'not_exist' => 'La categoria non esite!',
			'over_max' => 'Hai raggiunto il numero limite di categorie (%d)',
			'updated' => 'Categoria aggiornata.',
		),
		'feed' => array(
			'actualized' => '<em>%s</em> aggiornato',
			'actualizeds' => 'RSS feeds aggiornati',
			'added' => 'RSS feed <em>%s</em> aggiunti',
			'already_subscribed' => 'Hai già sottoscritto <em>%s</em>',
			'deleted' => 'Feed cancellato',
			'error' => 'Feed non aggiornato',
			'internal_problem' => 'RSS feed non aggiunto. <a href="%s">Verifica i logs</a> per dettagli.',
			'invalid_url' => 'URL <em>%s</em> non valido',
			'marked_read' => 'Feeds segnati come letti',
			'n_actualized' => '%d feeds aggiornati',
			'n_entries_deleted' => '%d articoli cancellati',
			'no_refresh' => 'Nessun aggiornamento disponibile…',
			'not_added' => '<em>%s</em> non può essere aggiunto',
			'over_max' => 'Hai raggiunto il numero limite di feed (%d)',
			'updated' => 'Feed aggiornato',
		),
		'purge_completed' => 'Svecchiamento completato (%d articoli cancellati)',
	),
	'update' => array(
		'can_apply' => 'FreshRSS verrà aggiornato alla <strong>versione %s</strong>.',
		'error' => 'Il processo di aggiornamento ha riscontrato il seguente errore: %s',
		'file_is_nok' => 'Verifica i permessi della cartella <em>%s</em>. Il server HTTP deve avere i permessi per la scrittura ',
		'finished' => 'Aggiornamento completato con successo!',
		'none' => 'Nessun aggiornamento disponibile',
		'server_not_found' => 'Server per aggiornamento non disponibile. [%s]',
	),
	'user' => array(
		'created' => array(
			'_' => 'Utente %s creato',
			'error' => 'Errore nella creazione utente %s ',
		),
		'deleted' => array(
			'_' => 'Utente %s cancellato',
			'error' => 'Utente %s non cancellato',
		),
	),
	'profile' => array(
		'error' => 'Il tuo profilo non può essere modificato',
		'updated' => 'Il tuo profilo è stato modificato',
	),
);
