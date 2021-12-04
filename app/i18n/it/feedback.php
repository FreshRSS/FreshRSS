<?php

return array(
	'access' => array(
		'denied' => 'Non hai i permessi per accedere a questa pagina',
		'not_found' => 'Pagina non disponibile',
	),
	'admin' => array(
		'optimization_complete' => 'Ottimizzazione completata',
	),
	'api' => array(
		'password' => array(
			'failed' => 'Your password cannot be modified',	// TODO - Translation
			'updated' => 'Your password has been modified',	// TODO - Translation
		),
	),
	'auth' => array(
		'login' => array(
			'invalid' => 'Autenticazione non valida',
			'success' => 'Autenticazione effettuata',
		),
		'logout' => array(
			'success' => 'Disconnessione effettuata',
		),
	),
	'conf' => array(
		'error' => 'Si è verificato un errore durante il salvataggio della configurazione',
		'query_created' => 'Ricerca "%s" creata.',
		'shortcuts_updated' => 'Collegamenti tastiera aggiornati',
		'updated' => 'Configurazione aggiornata',
	),
	'extensions' => array(
		'already_enabled' => '%s è già abilitata',
		'cannot_remove' => '%s cannot be removed',	// TODO - Translation
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
		'removed' => '%s removed',	// TODO - Translation
	),
	'import_export' => array(
		'export_no_zip_extension' => 'Estensione ZIP non presente sul server. Per favore esporta i files singolarmente.',
		'feeds_imported' => 'I tuoi feed sono stati importati e saranno aggiornati',
		'feeds_imported_with_errors' => 'I tuoi feeds sono stati importati ma si sono verificati alcuni errori',
		'file_cannot_be_uploaded' => 'Il file non può essere caricato!',
		'no_zip_extension' => 'Estensione ZIP non presente sul server.',
		'zip_error' => 'Si è verificato un errore importando il file ZIP',
	),
	'profile' => array(
		'error' => 'Il tuo profilo non può essere modificato',
		'updated' => 'Il tuo profilo è stato modificato',
	),
	'sub' => array(
		'actualize' => 'Aggiorna',
		'articles' => array(
			'marked_read' => 'The selected articles have been marked as read.',	// TODO - Translation
			'marked_unread' => 'The articles have been marked as unread.',	// TODO - Translation
		),
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
			'cache_cleared' => '<em>%s</em> cache has been cleared',	// TODO - Translation
			'deleted' => 'Feed cancellato',
			'error' => 'Feed non aggiornato',
			'internal_problem' => 'RSS feed non aggiunto. <a href="%s">Verifica i logs</a> per dettagli. You can try force adding by appending <code>#force_feed</code> to the URL.',	// TODO - Translation
			'invalid_url' => 'URL <em>%s</em> non valido',
			'n_actualized' => '%d feeds aggiornati',
			'n_entries_deleted' => '%d articoli cancellati',
			'no_refresh' => 'Nessun aggiornamento disponibile…',
			'not_added' => '<em>%s</em> non può essere aggiunto',
			'not_found' => 'Feed cannot be found',	// TODO - Translation
			'over_max' => 'Hai raggiunto il numero limite di feed (%d)',
			'reloaded' => '<em>%s</em> has been reloaded',	// TODO - Translation
			'selector_preview' => array(
				'http_error' => 'Failed to load website content.',	// TODO - Translation
				'no_entries' => 'There are no articles in this feed. You need at least one article to create a preview.',	// TODO - Translation
				'no_feed' => 'Internal error (feed cannot be found).',	// TODO - Translation
				'no_result' => 'The selector didn\'t match anything. As a fallback the original feed text will be displayed instead.',	// TODO - Translation
				'selector_empty' => 'The selector is empty. You need to define one to create a preview.',	// TODO - Translation
			),
			'updated' => 'Feed aggiornato',
		),
		'purge_completed' => 'Svecchiamento completato (%d articoli cancellati)',
	),
	'tag' => array(
		'created' => 'Tag "%s" has been created.',	// TODO - Translation
		'name_exists' => 'Tag name already exists.',	// TODO - Translation
		'renamed' => 'Tag "%s" has been renamed to "%s".',	// TODO - Translation
	),
	'update' => array(
		'can_apply' => 'FreshRSS verrà aggiornato alla <strong>versione %s</strong>.',
		'error' => 'Il processo di aggiornamento ha riscontrato il seguente errore: %s',
		'file_is_nok' => 'Nuova <strong>versione %s</strong>, ma verifica i permessi della cartella <em>%s</em>. Il server HTTP deve avere i permessi per la scrittura ',
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
		'updated' => array(
			'_' => 'User %s has been updated',	// TODO - Translation
			'error' => 'User %s has not been updated',	// TODO - Translation
		),
	),
);
