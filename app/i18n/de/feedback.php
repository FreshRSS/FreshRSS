<?php

return array(
	'admin' => array(
		'optimization_complete' => 'Optimierung abgeschlossen',
	),
	'access' => array(
		'denied' => 'Sie haben nicht die Berechtigung, diese Seite aufzurufen',
		'not_found' => 'Sie suchen nach einer Seite, die nicht existiert',
	),
	'auth' => array(
		'form' => array(
			'not_set' => 'Während der Konfiguration des Authentifikationssystems trat ein Fehler auf. Bitte versuchen Sie es später erneut.',
			'set' => 'Formular ist ab sofort ihr Standard-Authentifikationssystem.',
		),
		'login' => array(
			'invalid' => 'Anmeldung ist ungültig',
			'success' => 'Sie sind verbunden',
		),
		'logout' => array(
			'success' => 'Sie sind getrennt',
		),
		'no_password_set' => 'Administrator-Passwort ist nicht gesetzt worden. Dieses Feature ist nicht verfügbar.',
		'not_persona' => 'Nur das Persona-System kann zurückgesetzt werden.',
	),
	'conf' => array(
		'error' => 'Während des Speicherung der Konfiguration trat ein Fehler auf',
		'query_created' => 'Abfrage "%s" ist erstellt worden.',
		'shortcuts_updated' => 'Tastaturkürzel sind aktualisiert worden',
		'updated' => 'Konfiguration ist aktualisiert worden',
	),
	'extensions' => array(
		'already_enabled' => '%s ist bereits aktiviert',
		'disable' => array(
			'ko' => '%s kann nicht deaktiviert werden. Für Details <a href="%s">prüfen Sie die FressRSS-Protokolle</a>.',
			'ok' => '%s ist jetzt deaktiviert',
		),
		'enable' => array(
			'ko' => '%s kann nicht aktiviert werden. Für Details <a href="%s">prüfen Sie die FressRSS-Protokolle</a>.',
			'ok' => '%s ist jetzt aktiviert',
		),
		'no_access' => 'Sie haben keinen Zugang zu %s',
		'not_enabled' => '%s ist noch nicht aktiviert',
		'not_found' => '%s existiert nicht',
	),
	'import_export' => array(
		'export_no_zip_extension' => 'Die Zip-Erweiterung fehlt auf Ihrem Server. Bitte versuchen Sie, Dateien eine nach der anderen zu exportieren.',
		'feeds_imported' => 'Ihre Feeds sind importiert worden und werden jetzt aktualisiert',
		'feeds_imported_with_errors' => 'Ihre Feeds sind importiert worden, aber es traten einige Fehler auf',
		'file_cannot_be_uploaded' => 'Datei kann nicht hochgeladen werden!',
		'no_zip_extension' => 'Die Zip-Erweiterung ist auf Ihrem Server nicht vorhanden.',
		'zip_error' => 'Ein Fehler trat während des Zip-Imports auf.',
	),
	'sub' => array(
		'actualize' => 'Aktualisieren',
		'category' => array(
			'created' => 'Kategorie %s ist erstellt worden.',
			'deleted' => 'Kategorie ist gelöscht worden.',
			'emptied' => 'Kategorie ist geleert worden.',
			'error' => 'Kategorie kann nicht aktualisiert werden',
			'name_exists' => 'Kategorie-Name existiert bereits.',
			'no_id' => 'Sie müssen die ID der Kategorie präzisieren.',
			'no_name' => 'Kategorie-Name kann nicht leer sein.',
			'not_delete_default' => 'Sie können die Vorgabe-Kategorie nicht löschen!',
			'not_exist' => 'Die Kategorie existiert nicht!',
			'over_max' => 'Sie haben Ihr Kategorien-Limit erreicht (%d)',
			'updated' => 'Kategorie ist aktualisiert worden.',
		),
		'feed' => array(
			'actualized' => '<em>%s</em> ist aktualisiert worden',
			'actualizeds' => 'RSS-Feeds sind aktualisiert worden',
			'added' => 'RSS-Feed <em>%s</em> ist hinzugefügt worden',
			'already_subscribed' => 'Sie haben <em>%s</em> bereits abonniert',
			'deleted' => 'Feed ist gelöscht worden',
			'error' => 'Feed kann nicht aktualisiert werden',
			'internal_problem' => 'Der RSS-Feed konnte nicht hinzugefügt werden. Für Details <a href="%s">prüfen Sie die FressRSS-Protokolle</a>.',
			'invalid_url' => 'URL <em>%s</em> ist ungültig',
			'marked_read' => 'Feeds sind als gelesen markiert worden',
			'n_actualized' => '%d Feeds sind aktualisiert worden',
			'n_entries_deleted' => '%d Artikel sind gelöscht worden',
			'no_refresh' => 'Es gibt keinen Feed zum Aktualisieren…',
			'not_added' => '<em>%s</em> konnte nicht hinzugefügt werden',
			'over_max' => 'Sie haben Ihr Feeds-Limit erreicht (%d)',
			'updated' => 'Feed ist aktualisiert worden',
		),
		'purge_completed' => 'Bereinigung abgeschlossen (%d Artikel gelöscht)',
	),
	'update' => array(
		'can_apply' => 'FreshRSS wird nun auf die <strong>Version %s</strong> aktualisiert.',
		'error' => 'Der Aktualisierungsvorgang stieß auf einen Fehler: %s',
		'file_is_nok' => 'Überprüfen Sie die Berechtigungen des Verzeichnisses <em>%s</em>. Der HTTP-Server muss Schreibrechte besitzen',
		'finished' => 'Aktualisierung abgeschlossen!',
		'none' => 'Keine Aktualisierung zum Anwenden',
		'server_not_found' => 'Aktualisierungs-Server kann nicht gefunden werden. [%s]',
	),
	'user' => array(
		'created' => array(
			'_' => 'Benutzer %s ist erstellt worden',
			'error' => 'Benutzer %s kann nicht erstellt werden',
		),
		'deleted' => array(
			'_' => 'Benutzer %s ist gelöscht worden',
			'error' => 'Benutzer %s kann nicht gelöscht werden',
		),
	),
	'profile' => array(
		'error' => 'Ihr Profil kann nicht geändert werden',
		'updated' => 'Ihr Profil ist geändert worden',
	),
);
