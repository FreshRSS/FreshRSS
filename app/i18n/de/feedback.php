<?php

return array(
	'access' => array(
		'denied' => 'Sie haben nicht die Berechtigung, diese Seite aufzurufen',
		'not_found' => 'Sie suchen nach einer Seite, die nicht existiert',
	),
	'admin' => array(
		'optimization_complete' => 'Optimierung abgeschlossen',
	),
	'api' => array(
		'password' => array(
			'failed' => 'Your password cannot be modified',	// TODO - Translation
			'updated' => 'Your password has been modified',	// TODO - Translation
		),
	),
	'auth' => array(
		'form' => array(
			'not_set' => 'Während der Konfiguration des Authentifikationssystems trat ein Fehler auf. Bitte versuchen Sie es später erneut.',
			'set' => 'Formular ist ab sofort ihr Standard-Authentifikationssystem.',
		),
		'login' => array(
			'invalid' => 'Anmeldung ist ungültig',
			'success' => 'Sie sind angemeldet',
		),
		'logout' => array(
			'success' => 'Sie sind abgemeldet',
		),
		'no_password_set' => 'Administrator-Passwort ist nicht gesetzt worden. Dieses Feature ist nicht verfügbar.',
	),
	'conf' => array(
		'error' => 'Während der Speicherung der Konfiguration trat ein Fehler auf',
		'query_created' => 'Abfrage "%s" ist erstellt worden.',
		'shortcuts_updated' => 'Die Tastenkombinationen sind aktualisiert worden',
		'updated' => 'Die Konfiguration ist aktualisiert worden',
	),
	'extensions' => array(
		'already_enabled' => '%s ist bereits aktiviert',
		'disable' => array(
			'ko' => '%s kann nicht deaktiviert werden. Für Details <a href="%s">prüfen Sie die FreshRSS-Protokolle</a>.',
			'ok' => '%s ist jetzt deaktiviert',
		),
		'enable' => array(
			'ko' => '%s kann nicht aktiviert werden. Für Details <a href="%s">prüfen Sie die FreshRSS-Protokolle</a>.',
			'ok' => '%s ist jetzt aktiviert',
		),
		'not_enabled' => '%s ist noch nicht aktiviert',
		'not_found' => '%s existiert nicht',
		'no_access' => 'Sie haben keinen Zugang zu %s',
	),
	'import_export' => array(
		'export_no_zip_extension' => 'Die ZIP-Erweiterung fehlt auf Ihrem Server. Bitte versuchen Sie die Dateien eine nach der anderen zu exportieren.',
		'feeds_imported' => 'Ihre Feeds sind importiert worden und werden jetzt aktualisiert',
		'feeds_imported_with_errors' => 'Ihre Feeds sind importiert worden, aber es traten einige Fehler auf',
		'file_cannot_be_uploaded' => 'Die Datei kann nicht hochgeladen werden!',
		'no_zip_extension' => 'Die ZIP-Erweiterung ist auf Ihrem Server nicht vorhanden.',
		'zip_error' => 'Ein Fehler trat während des ZIP-Imports auf.',
	),
	'profile' => array(
		'error' => 'Ihr Profil kann nicht geändert werden',
		'updated' => 'Ihr Profil ist geändert worden',
	),
	'sub' => array(
		'actualize' => 'Aktualisieren',
		'articles' => array(
			'marked_read' => 'Die ausgewählten Artikel wurden als gelesen markiert.',
			'marked_unread' => 'Die ausgewählten Artikel wurden als ungelesen markiert.',
		),
		'category' => array(
			'created' => 'Die Kategorie %s ist erstellt worden.',
			'deleted' => 'Die Kategorie ist gelöscht worden.',
			'emptied' => 'Die Kategorie ist geleert worden.',
			'error' => 'Die Kategorie kann nicht aktualisiert werden',
			'name_exists' => 'Der Kategorie-Name existiert bereits.',
			'not_delete_default' => 'Sie können die Vorgabe-Kategorie nicht löschen!',
			'not_exist' => 'Die Kategorie existiert nicht!',
			'no_id' => 'Sie müssen die ID der Kategorie präzisieren.',
			'no_name' => 'Der Kategorie-Name kann nicht leer sein.',
			'over_max' => 'Sie haben Ihre Kategorien-Limite erreicht (%d)',
			'updated' => 'Die Kategorie ist aktualisiert worden.',
		),
		'feed' => array(
			'actualized' => '<em>%s</em> ist aktualisiert worden',
			'actualizeds' => 'Die RSS-Feeds sind aktualisiert worden',
			'added' => 'Der RSS-Feed <em>%s</em> ist hinzugefügt worden',
			'already_subscribed' => 'Sie haben <em>%s</em> bereits abonniert',
			'cache_cleared' => '<em>%s</em> cache has been cleared',	// TODO - Translation
			'deleted' => 'Der Feed ist gelöscht worden',
			'error' => 'Der Feed kann nicht aktualisiert werden',
			'internal_problem' => 'Der RSS-Feed konnte nicht hinzugefügt werden. Für Details <a href="%s">prüfen Sie die FreshRSS-Protokolle</a>.',
			'invalid_url' => 'Die URL <em>%s</em> ist ungültig',
			'not_added' => '<em>%s</em> konnte nicht hinzugefügt werden',
			'not_found' => 'Feed cannot be found',	// TODO - Translation
			'no_refresh' => 'Es gibt keinen Feed zum Aktualisieren…',
			'n_actualized' => 'Die %d Feeds sind aktualisiert worden',
			'n_entries_deleted' => 'Die %d Artikel sind gelöscht worden',
			'over_max' => 'Sie haben Ihre Feeds-Limite erreicht (%d)',
			'reloaded' => '<em>%s</em> has been reloaded',	// TODO - Translation
			'selector_preview' => array(
				'http_error' => 'Failed to load website content.',	// TODO - Translation
				'no_entries' => 'There is no entries in your feed. You need at least one entry to create a preview.',	// TODO - Translation
				'no_feed' => 'Internal error (no feed to entry).',	// TODO - Translation
				'no_result' => 'The selector didn\'t match anything. As a fallback the original feed text will be displayed instead.',	// TODO - Translation
				'selector_empty' => 'The selector is empty. You need to define one to create a preview.',	// TODO - Translation
			),
			'updated' => 'Der Feed ist aktualisiert worden',
		),
		'purge_completed' => 'Bereinigung abgeschlossen (%d Artikel gelöscht)',
	),
	'update' => array(
		'can_apply' => 'FreshRSS wird nun auf die <strong>Version %s</strong> aktualisiert.',
		'error' => 'Der Aktualisierungsvorgang stieß auf einen Fehler: %s',
		'file_is_nok' => '<strong>Version %s</strong>. Überprüfen Sie die Berechtigungen des Verzeichnisses <em>%s</em>. Der HTTP-Server muss Schreibrechte besitzen',
		'finished' => 'Aktualisierung abgeschlossen!',
		'none' => 'Keine Aktualisierung zum Anwenden',
		'server_not_found' => 'Der Aktualisierungs-Server kann nicht gefunden werden. [%s]',
	),
	'user' => array(
		'created' => array(
			'error' => 'Der Benutzer %s kann nicht erstellt werden',
			'_' => 'Der Benutzer %s ist erstellt worden',
		),
		'deleted' => array(
			'error' => 'Der Benutzer %s kann nicht gelöscht werden',
			'_' => 'Der Benutzer %s ist gelöscht worden',
		),
		'updated' => array(
			'error' => 'Benutzer %s wurde nicht aktualisiert',
			'_' => 'Benutzer %s wurde aktualisiert',
		),
	),
);
