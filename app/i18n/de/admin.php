<?php

/******************************************************************************
 * Each entry of that file can be associated with a comment to indicate its   *
 * state. When there is no comment, it means the entry is fully translated.   *
 * The recognized comments are (comment matching is case-insensitive):        *
 *   + TODO: the entry has never been translated.                             *
 *   + DIRTY: the entry has been translated but needs to be updated.          *
 *   + IGNORE: the entry does not need to be translated.                      *
 * When a comment is not recognized, it is discarded.                         *
 ******************************************************************************/

return array(
	'auth' => array(
		'allow_anonymous' => 'Anonymes Lesen der Artikel des Standardbenutzers (%s) erlauben',
		'allow_anonymous_refresh' => 'Anonymes Aktualisieren der Artikel erlauben',
		'api_enabled' => '<abbr>API</abbr>-Zugriff erlauben <small>(für mobile Apps und zum Teilen von Benutzerabfragen erforderlich)</small>',
		'form' => 'Webformular (traditionell, benötigt JavaScript)',
		'http' => 'HTTP (fortgeschritten: vom Webserver verwaltet, OIDC, SSO…)',
		'none' => 'Keine (gefährlich)',
		'title' => 'Authentifizierung',
		'token' => 'Master-Authentifizierungs-Token',
		'token_help' => 'Erlaubt Zugriff auf alle RSS-Ausgaben des Nutzers sowie das Aktualisieren von Feeds ohne Authentifizierung:',
		'type' => 'Authentifizierungsmethode',
	),
	'extensions' => array(
		'author' => 'Autor',
		'community' => 'Verfügbare Community-Erweiterungen',
		'description' => 'Beschreibung',
		'disabled' => 'Deaktiviert',
		'empty_list' => 'Keine installierten Erweiterungen',
		'empty_list_help' => 'Überprüfen Sie die Protokolle, um den Grund für die leere Erweiterungsliste zu ermitteln.',
		'enabled' => 'Aktiviert',
		'is_compatible' => 'Ist kompatibel',
		'latest' => 'Installiert',
		'name' => 'Name',	// IGNORE
		'no_configure_view' => 'Diese Erweiterung kann nicht konfiguriert werden.',
		'system' => array(
			'_' => 'System-Erweiterungen',
			'no_rights' => 'System-Erweiterung (Sie haben keine Berechtigung dafür)',
		),
		'title' => 'Erweiterungen',
		'update' => 'Update verfügbar',
		'user' => 'Benutzer-Erweiterungen',
		'version' => 'Version',	// IGNORE
	),
	'stats' => array(
		'_' => 'Statistiken',
		'all_feeds' => 'Alle Feeds',
		'category' => 'Kategorie',
		'date_published' => 'Veröffentlicht am',
		'date_received' => 'Erhalten am',
		'entry_count' => 'Anzahl der Einträge',
		'entry_per_category' => 'Einträge pro Kategorie',
		'entry_per_day' => 'Einträge pro Tag (letzte 30 Tage)',
		'entry_per_day_of_week' => 'Pro Wochentag (Durchschnitt: %.2f Nachrichten)',
		'entry_per_hour' => 'Pro Stunde (Durchschnitt: %.2f Nachrichten)',
		'entry_per_month' => 'Pro Monat (Durchschnitt: %.2f Nachrichten)',
		'entry_repartition' => 'Einträge-Verteilung',
		'feed' => 'Feed',	// IGNORE
		'feed_per_category' => 'Feeds pro Kategorie',
		'idle' => 'Inaktive Feeds',
		'main' => 'Haupt-Statistiken',
		'main_stream' => 'Haupt-Feeds',
		'nb_unreads' => 'Anzahl ungelesener Artikel',
		'no_idle' => 'Es gibt keine inaktiven Feeds!',
		'number_entries' => '%d Artikel',
		'overview' => 'Übersicht',
		'percent_of_total' => '% der Gesamtanzahl',
		'repartition' => 'Artikel-Verteilung: %s',
		'status_favorites' => 'Favoriten',
		'status_read' => 'Gelesen',
		'status_total' => 'Gesamt',
		'status_unread' => 'Ungelesen',
		'title' => 'Statistiken',
		'top_feed' => 'Top 10-Feeds',
		'unread_dates' => 'Tage mit den meisten ungelesenen Artikeln',
	),
	'system' => array(
		'_' => 'Systemeinstellungen',
		'auto-update-url' => 'URL des Aktualisierungsservers',
		'base-url' => array(
			'_' => 'Base URL',	// IGNORE
			'recommendation' => 'Automatische Empfehlung: <kbd>%s</kbd>',
		),
		'closed_registration_message' => 'Nachricht bei geschlossener Registrierung',
		'cookie-duration' => array(
			'help' => 'in Sekunden',
			'number' => 'Angemeldet bleiben für',
		),
		'default_closed_registration_message' => 'Dieser Server akzeptiert momentan keine neuen Registrierungen.',
		'force_email_validation' => 'E-Mail-Adressprüfung erzwingen',
		'instance-name' => 'Bezeichnung',
		'internal-host-allowlist' => array(
			'_' => 'Internal host allowlist',	// TODO
			'help' => 'One entry per line:<ul><li>A <code>host:port</code>. For instance <code>127.0.0.1:8080</code> or <code>rss-bridge:80</code></li><li>A CIDR notation. For instance <code>0.0.0.0/0</code> to allow any IPv4, <code>::/0</code> to allow any IPv6</li><li>A <code>*</code> to allow any host (unsafe)</li></ul>',	// TODO
		),
		'max-categories' => 'Anzahl erlaubter Kategorien pro Benutzer',
		'max-feeds' => 'Anzahl erlaubter Feeds pro Benutzer',
		'override-by-env-var' => 'This setting is set by the environment variable <kbd>%s</kbd>.',	// TODO
		'registration' => array(
			'number' => 'Maximale Anzahl von Accounts',
			'select' => array(
				'label' => 'Registrierungsformular',
				'option' => array(
					'noform' => 'Deaktiviert: Keine Registrierung möglich',
					'nolimit' => 'Aktiviert: Unbegrenzte Anzahl neuer Accounts',
					'setaccountsnumber' => 'Maximale Anzahl an Benutzer-Accounts festlegen',
				),
			),
			'status' => array(
				'disabled' => 'Formular deaktiviert',
				'enabled' => 'Formular aktiviert',
			),
			'title' => 'Benutzer-Registrierungsformular',
		),
		'sensitive-parameter' => 'Kritische Einstellung. Manuell in <kbd>./data/config.php</kbd> anpassbar.',
		'tos' => array(
			'disabled' => 'sind nicht aktiviert',
			'enabled' => '<a href="./?a=tos">sind aktiv</a>',
			'help' => 'So werden die <a href="https://freshrss.github.io/FreshRSS/en/admins/12_User_management.html#enable-terms-of-service-tos" target="_blank">Nutzungsbedingungen aktiviert</a>',
		),
		'websub' => array(
			'help' => 'Über <a href="https://freshrss.github.io/FreshRSS/en/users/WebSub.html" target="_blank">WebSub</a>',
		),
	),
	'update' => array(
		'_' => 'System aktualisieren',
		'apply' => 'Aktualisierung starten',
		'changelog' => 'Liste der Änderungen',
		'check' => 'Auf neue Aktualisierungen prüfen',
		'copiedFromURL' => 'update.php wurde von %s nach ./data kopiert',
		'current_version' => 'Aktuelle Version',
		'last' => 'Letzte Überprüfung',
		'loading' => 'Aktualisierung läuft…',
		'none' => 'Keine ausstehende Aktualisierung',
		'releaseChannel' => array(
			'_' => 'Veröffentlichungskanal',
			'edge' => 'Aktueller Entwicklungsstand (“edge”)',
			'latest' => 'Stabile Version (“latest”)',
		),
		'title' => 'System aktualisieren',
		'viaGit' => 'Update über git und GitHub.com gestartet',
	),
	'user' => array(
		'admin' => 'Administrator',	// IGNORE
		'article_count' => 'Artikel',
		'back_to_manage' => '← Zurück zur Benutzerliste',
		'create' => 'Neuen Benutzer erstellen',
		'database_size' => 'Datenbankgröße',
		'email' => 'E-Mail-Adresse',
		'enabled' => 'Aktiviert',
		'feed_count' => 'Feeds',	// IGNORE
		'is_admin' => 'Ist Administrator',
		'language' => 'Sprache',
		'last_user_activity' => 'Letzte Benutzeraktivität',
		'list' => 'Benutzerliste',
		'number' => 'Bisher wurde %d Account erstellt',
		'numbers' => 'Bisher wurden %d Accounts erstellt',
		'password_form' => 'Passwort<br /><small>(für die Anmeldemethode per Webformular)</small>',
		'password_format' => 'mindestens 7 Zeichen',
		'title' => 'Benutzer verwalten',
		'username' => 'Nutzername',
	),
);
