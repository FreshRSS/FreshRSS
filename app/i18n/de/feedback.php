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
	'access' => [
		'denied' => 'Sie haben nicht die Berechtigung, diese Seite aufzurufen',
		'not_found' => 'Sie suchen nach einer Seite, die nicht existiert',
	],
	'admin' => [
		'optimization_complete' => 'Optimierung abgeschlossen',
	],
	'api' => [
		'password' => [
			'failed' => 'Ihr Passwort konnte nicht geändert werden',
			'updated' => 'Ihr Passwort wurde geändert',
		],
	],
	'auth' => [
		'login' => [
			'invalid' => 'Anmeldung ist ungültig',
			'success' => 'Sie sind angemeldet',
		],
		'logout' => [
			'success' => 'Sie sind abgemeldet',
		],
	],
	'conf' => [
		'error' => 'Während der Speicherung der Konfiguration trat ein Fehler auf',
		'query_created' => 'Abfrage „%s“ ist erstellt worden.',
		'shortcuts_updated' => 'Die Tastenkombinationen sind aktualisiert worden',
		'updated' => 'Die Konfiguration ist aktualisiert worden',
	],
	'extensions' => [
		'already_enabled' => '%s ist bereits aktiviert',
		'cannot_remove' => '%s kann nicht gelöscht werden',
		'disable' => [
			'ko' => '%s kann nicht deaktiviert werden. Für Details <a href="%s">prüfen Sie die FreshRSS-Protokolle</a>.',
			'ok' => '%s ist jetzt deaktiviert',
		],
		'enable' => [
			'ko' => '%s kann nicht aktiviert werden. Für Details <a href="%s">prüfen Sie die FreshRSS-Protokolle</a>.',
			'ok' => '%s ist jetzt aktiviert',
		],
		'no_access' => 'Sie haben keinen Zugang zu %s',
		'not_enabled' => '%s ist noch nicht aktiviert',
		'not_found' => '%s existiert nicht',
		'removed' => '%s wurde gelöscht',
	],
	'import_export' => [
		'export_no_zip_extension' => 'Die ZIP-Erweiterung fehlt auf Ihrem Server. Bitte versuchen Sie die Dateien eine nach der anderen zu exportieren.',
		'feeds_imported' => 'Ihre Feeds sind importiert worden. Wenn Sie alle Dateien importiert haben, können Sie <i>Feeds aktualisieren</i> klicken.',
		'feeds_imported_with_errors' => 'Ihre Feeds sind importiert worden, aber es traten einige Fehler auf. Wenn Sie alle Dateien importiert haben, können Sie <i>Feeds aktualisieren</i> klicken.',
		'file_cannot_be_uploaded' => 'Die Datei kann nicht hochgeladen werden!',
		'no_zip_extension' => 'Die ZIP-Erweiterung ist auf Ihrem Server nicht vorhanden.',
		'zip_error' => 'Ein Fehler trat während des ZIP-Imports auf.',	// DIRTY
	],
	'profile' => [
		'error' => 'Ihr Profil kann nicht geändert werden',
		'updated' => 'Ihr Profil ist geändert worden',
	],
	'sub' => [
		'actualize' => 'Aktualisieren',
		'articles' => [
			'marked_read' => 'Die ausgewählten Artikel wurden als gelesen markiert.',
			'marked_unread' => 'Die ausgewählten Artikel wurden als ungelesen markiert.',
		],
		'category' => [
			'created' => 'Die Kategorie %s ist erstellt worden.',
			'deleted' => 'Die Kategorie ist gelöscht worden.',
			'emptied' => 'Die Kategorie ist geleert worden.',
			'error' => 'Die Kategorie kann nicht aktualisiert werden',
			'name_exists' => 'Der Kategorie-Name existiert bereits.',
			'no_id' => 'Sie müssen die ID der Kategorie präzisieren.',
			'no_name' => 'Der Kategorie-Name kann nicht leer sein.',
			'not_delete_default' => 'Sie können die Vorgabe-Kategorie nicht löschen!',
			'not_exist' => 'Die Kategorie existiert nicht!',
			'over_max' => 'Sie haben Ihre Kategorien-Limite erreicht (%d)',
			'updated' => 'Die Kategorie ist aktualisiert worden.',
		],
		'feed' => [
			'actualized' => '<em>%s</em> ist aktualisiert worden',
			'actualizeds' => 'Die RSS-Feeds sind aktualisiert worden',
			'added' => 'Der RSS-Feed <em>%s</em> ist hinzugefügt worden',
			'already_subscribed' => 'Sie haben <em>%s</em> bereits abonniert',
			'cache_cleared' => '<em>%s</em> Zwischenspeicher wurde geleert',
			'deleted' => 'Der Feed ist gelöscht worden',
			'error' => 'Der Feed kann nicht aktualisiert werden',
			'internal_problem' => 'Der RSS-Feed konnte nicht hinzugefügt werden. Für Details <a href="%s">prüfen Sie die FreshRSS-Protokolle</a>. Mit <code>#force_feed</code> am Ende der Feed-URL kann das Hinzufügen erzwungen werden.',
			'invalid_url' => 'Die URL <em>%s</em> ist ungültig',
			'n_actualized' => 'Die %d Feeds sind aktualisiert worden',
			'n_entries_deleted' => 'Die %d Artikel sind gelöscht worden',
			'no_refresh' => 'Es gibt keinen Feed zum Aktualisieren…',
			'not_added' => '<em>%s</em> konnte nicht hinzugefügt werden',
			'not_found' => 'Der Feed konnte nicht gefunden werden',
			'over_max' => 'Sie haben Ihre Feeds-Limite erreicht (%d)',
			'reloaded' => '<em>%s</em> wurde neugeladen',
			'selector_preview' => [
				'http_error' => 'Website-Inhalt konnte nicht geladen werden.',
				'no_entries' => 'In diesem Feed gibt es keine Artikel. Um eine Vorschau zu erstellen, muss mindestens ein Artikel vorhanden sein.',
				'no_feed' => 'Interner Fehler (Feed konnte nicht gefunden werden).',
				'no_result' => 'Die Auswahl ergab keine Ergebnisse. Der Originaltext des Feeds wird daher angezeigt.',
				'selector_empty' => 'Die Auswahl ist leer. Sie müssen einen definieren um eine Vorschau zu erstellen.',
			],
			'updated' => 'Der Feed ist aktualisiert worden',
		],
		'purge_completed' => 'Bereinigung abgeschlossen (%d Artikel gelöscht)',
	],
	'tag' => [
		'created' => 'Label „%s“ wurde erstellt.',
		'error' => 'Label could not be updated!',	// TODO
		'name_exists' => 'Label-Name existiert bereits.',
		'renamed' => 'Das Label „%s“ wurde umbenannt in „%s“.',
		'updated' => 'Label has been updated.',	// TODO
	],
	'update' => [
		'can_apply' => 'FreshRSS wird nun auf die <strong>Version %s</strong> aktualisiert.',
		'error' => 'Der Aktualisierungsvorgang stieß auf einen Fehler: %s',
		'file_is_nok' => '<strong>Version %s</strong>. Überprüfen Sie die Berechtigungen des Verzeichnisses <em>%s</em>. Der HTTP-Server muss Schreibrechte besitzen',
		'finished' => 'Aktualisierung abgeschlossen!',
		'none' => 'Keine Aktualisierung zum Anwenden',
		'server_not_found' => 'Der Aktualisierungs-Server kann nicht gefunden werden. [%s]',
	],
	'user' => [
		'created' => [
			'_' => 'Der Benutzer %s wurde erstellt',
			'error' => 'Der Benutzer %s konnte nicht erstellt werden',
		],
		'deleted' => [
			'_' => 'Der Benutzer %s wurde gelöscht',
			'error' => 'Der Benutzer %s konnte nicht gelöscht werden',
		],
		'updated' => [
			'_' => 'Benutzer %s wurde aktualisiert',
			'error' => 'Benutzer %s konnte nicht aktualisiert werden',
		],
	],
];
