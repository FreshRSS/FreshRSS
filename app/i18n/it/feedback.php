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
	'access' => array(
		'denied' => 'Non hai i permessi per accedere a questa pagina',
		'not_found' => 'Pagina non disponibile',
	),
	'admin' => array(
		'optimization_complete' => 'Ottimizzazione completata',
	),
	'api' => array(
		'password' => array(
			'failed' => 'La tua password non può essere modificata',
			'updated' => 'La tua password è stata modificata',
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
		'query_created' => 'Ricerca “%s” creata.',
		'shortcuts_updated' => 'Collegamenti tastiera aggiornati',
		'updated' => 'Configurazione aggiornata',
	),
	'extensions' => array(
		'already_enabled' => '%s è già abilitata',
		'cannot_remove' => '%s non può essere rimosso',
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
		'removed' => '%s rimosso',
	),
	'import_export' => array(
		'export_no_zip_extension' => 'Estensione ZIP non presente sul server. Per favore esporta i files singolarmente.',
		'feeds_imported' => 'I tuoi feed sono stati importati e saranno aggiornati. Se hai completato l’importazione, puoi cliccare sul pulsante <i>Aggiorna feed</i>.',
		'feeds_imported_with_errors' => 'I tuoi feed sono stati importati ma si sono verificati alcuni errori. Se hai completato l’importazione, puoi cliccare sul pulsante <i>Aggiorna feed</i>.',
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
			'marked_read' => 'Gli articoli selezionati sono stati segnati come già letti.',
			'marked_unread' => 'Gli articoli sono stati segnati come non letti.',
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
			'actualizeds' => 'Feed RSS aggiornati',
			'added' => 'RSS feed <em>%s</em> aggiunti',
			'already_subscribed' => 'Hai già sottoscritto <em>%s</em>',
			'cache_cleared' => 'La cache di <em>%s</em> è stata svuotata',
			'deleted' => 'Feed cancellato',
			'error' => 'Feed non aggiornato',
			'internal_problem' => 'Feed RSS non aggiunto. <a href="%s">Verifica i log</a> per dettagli. Puoi provare l’aggiunta forzata aggiungendo <code>#force_feed</code> all’URL.',
			'invalid_url' => 'URL <em>%s</em> non valido',
			'n_actualized' => '%d feed aggiornati',
			'n_entries_deleted' => '%d articoli cancellati',
			'no_refresh' => 'Nessun aggiornamento disponibile…',
			'not_added' => '<em>%s</em> non può essere aggiunto',
			'not_found' => 'Feed non trovato',
			'over_max' => 'Hai raggiunto il numero limite di feed (%d)',
			'reloaded' => '<em>%s</em> è stato ricaricato',
			'selector_preview' => array(
				'http_error' => 'Fallito caricamento del contenuto del sito web.',
				'no_entries' => 'Non sono presenti articoli in questo feed. Serve almeno un articolo per creare un’anteprima.',
				'no_feed' => 'Errore interno (feed non trovato).',
				'no_result' => 'Il selettore non ha trovato nessuna corrispondenza. Come azione di ripiego verrà mostrato il testo originale del feed.',
				'selector_empty' => 'Il selettore è vuoto. Devi definirne uno per creare un’anteprima.',
			),
			'updated' => 'Feed aggiornato',
		),
		'purge_completed' => 'Svecchiamento completato (%d articoli cancellati)',
	),
	'tag' => array(
		'created' => 'Il tag “%s” è stato creato.',
		'error' => 'Il tag non può essere aggiornato!',
		'name_exists' => 'Il nome del tag è già presente.',
		'renamed' => 'Il tag “%s” è stato rinominato in “%s”.',
		'updated' => 'Il tag è stato aggiornato.',
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
			'_' => 'L’utente %s è stato aggiornato',
			'error' => 'L’utente %s non è stato aggiornato',
		),
	),
);
