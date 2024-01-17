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
		'allow_anonymous' => 'Anonymes Lesen der Artikel des Standardbenutzers (%s) erlauben',
		'allow_anonymous_refresh' => 'Anonymes Aktualisieren der Artikel erlauben',
		'api_enabled' => '<abbr>API</abbr>-Zugriff erlauben <small>(für mobile Anwendungen benötigt)</small>',
		'form' => 'Webformular (traditionell, benötigt JavaScript)',
		'http' => 'HTTP (HTTPS für erfahrene Benutzer)',
		'none' => 'Keine (gefährlich)',
		'title' => 'Authentifizierung',
		'token' => 'Authentifizierungs-Token',
		'token_help' => 'Erlaubt den Zugriff auf die RSS-Ausgabe des Standardbenutzers ohne Authentifizierung.',
		'type' => 'Authentifizierungsmethode',
		'unsafe_autologin' => 'Erlaube unsicheres automatisches Anmelden mit folgendem Format: ',
	],
	'check_install' => [
		'cache' => [
			'nok' => 'Überprüfen Sie die Berechtigungen des Verzeichnisses <em>./data/cache</em>. Der HTTP-Server muss Schreibrechte besitzen.',
			'ok' => 'Die Berechtigungen des Verzeichnisses <em>./data/cache</em> sind in Ordnung.',
		],
		'categories' => [
			'nok' => 'Die Tabelle <em>category</em> ist schlecht konfiguriert.',
			'ok' => 'Die Tabelle <em>category</em> ist korrekt konfiguriert.',
		],
		'connection' => [
			'nok' => 'Verbindung zur Datenbank kann nicht aufgebaut werden.',
			'ok' => 'Verbindung zur Datenbank konnte aufgebaut werden.',
		],
		'ctype' => [
			'nok' => 'Ihnen fehlt eine benötigte Bibliothek für die Überprüfung von Zeichentypen (php-ctype).',
			'ok' => 'Sie haben die benötigte Bibliothek für die Überprüfung von Zeichentypen (ctype).',
		],
		'curl' => [
			'nok' => 'Ihnen fehlt cURL (Paket php-curl).',
			'ok' => 'Sie haben die cURL-Erweiterung.',
		],
		'data' => [
			'nok' => 'Überprüfen Sie die Berechtigungen des Verzeichnisses <em>./data</em>. Der HTTP-Server muss Schreibrechte besitzen.',
			'ok' => 'Die Berechtigungen des Verzeichnisses <em>./data</em> sind in Ordnung.',
		],
		'database' => 'Datenbank-Installation',
		'dom' => [
			'nok' => 'Ihnen fehlt eine benötigte Bibliothek um DOM zu durchstöbern (Paket php-xml).',
			'ok' => 'Sie haben die benötigte Bibliothek um DOM zu durchstöbern.',
		],
		'entries' => [
			'nok' => 'Die Tabelle <em>entry</em> ist schlecht konfiguriert.',
			'ok' => 'Die Tabelle <em>entry</em> ist korrekt konfiguriert.',
		],
		'favicons' => [
			'nok' => 'Überprüfen Sie die Berechtigungen des Verzeichnisses <em>./data/favicons</em>. Der HTTP-Server muss Schreibrechte besitzen.',
			'ok' => 'Die Berechtigungen des Verzeichnisses <em>./data/favicons</em> sind in Ordnung.',
		],
		'feeds' => [
			'nok' => 'Die Tabelle <em>feed</em> ist schlecht konfiguriert.',
			'ok' => 'Die Tabelle <em>feed</em> ist korrekt konfiguriert.',
		],
		'fileinfo' => [
			'nok' => 'Ihnen fehlt PHP fileinfo (Paket fileinfo).',
			'ok' => 'Sie haben die fileinfo-Erweiterung.',
		],
		'files' => 'Datei-Installation',
		'json' => [
			'nok' => 'Ihnen fehlt die JSON-Erweiterung (Paket php-json).',
			'ok' => 'Sie haben die JSON-Erweiterung.',
		],
		'mbstring' => [
			'nok' => 'Ihnen fehlt die mbstring-Bibliothek für Unicode.',
			'ok' => 'Sie haben die empfohlene mbstring-Bliothek für Unicode.',
		],
		'pcre' => [
			'nok' => 'Ihnen fehlt eine benötigte Bibliothek für reguläre Ausdrücke (php-pcre).',
			'ok' => 'Sie haben die benötigte Bibliothek für reguläre Ausdrücke (PCRE).',
		],
		'pdo' => [
			'nok' => 'Ihnen fehlt PDO oder einer der unterstützten Treiber (pdo_mysql, pdo_sqlite, pdo_pgsql).',
			'ok' => 'Sie haben PDO und mindestens einen der unterstützten Treiber (pdo_mysql, pdo_sqlite, pdo_pgsql).',
		],
		'php' => [
			'_' => 'PHP-Installation',
			'nok' => 'Ihre PHP-Version ist %s aber FreshRSS benötigt mindestens Version %s.',
			'ok' => 'Ihre PHP-Version ist %s, welche kompatibel mit FreshRSS ist.',
		],
		'tables' => [
			'nok' => 'Es fehlen eine oder mehrere Tabellen in der Datenbank.',
			'ok' => 'Tabellen existieren in der Datenbank.',
		],
		'title' => 'Installationsüberprüfung',
		'tokens' => [
			'nok' => 'Überprüfen Sie die Berechtigungen des Verzeichnisses <em>./data/tokens</em>. Der HTTP-Server muss Schreibrechte besitzen.',
			'ok' => 'Die Berechtigungen des Verzeichnisses <em>./data/tokens</em> sind in Ordnung.',
		],
		'users' => [
			'nok' => 'Überprüfen Sie die Berechtigungen des Verzeichnisses <em>./data/users</em>. Der HTTP-Server muss Schreibrechte besitzen.',
			'ok' => 'Die Berechtigungen des Verzeichnisses <em>./data/users</em> sind in Ordnung.',
		],
		'zip' => [
			'nok' => 'Ihnen fehlt die ZIP-Erweiterung (Paket php-zip).',
			'ok' => 'Sie haben die ZIP-Erweiterung.',
		],
	],
	'extensions' => [
		'author' => 'Autor',
		'community' => 'Verfügbare Community-Erweiterungen',
		'description' => 'Beschreibungen',
		'disabled' => 'Deaktiviert',
		'empty_list' => 'Es gibt keine installierte Erweiterung.',
		'enabled' => 'Aktiviert',
		'latest' => 'Installiert',
		'name' => 'Name',	// IGNORE
		'no_configure_view' => 'Diese Erweiterung kann nicht konfiguriert werden.',
		'system' => [
			'_' => 'System-Erweiterungen',
			'no_rights' => 'System-Erweiterung (Sie haben keine Berechtigung dafür)',
		],
		'title' => 'Erweiterungen',
		'update' => 'Update verfügbar',
		'user' => 'Benutzer-Erweiterungen',
		'version' => 'Version',	// IGNORE
	],
	'stats' => [
		'_' => 'Statistiken',
		'all_feeds' => 'Alle Feeds',
		'category' => 'Kategorie',
		'entry_count' => 'Anzahl der Einträge',
		'entry_per_category' => 'Einträge pro Kategorie',
		'entry_per_day' => 'Einträge pro Tag (letzten 30 Tage)',
		'entry_per_day_of_week' => 'Pro Wochentag (Durchschnitt: %.2f Nachrichten)',
		'entry_per_hour' => 'Pro Stunde (Durchschnitt: %.2f Nachrichten)',
		'entry_per_month' => 'Pro Monat (Durchschnitt: %.2f Nachrichten)',
		'entry_repartition' => 'Einträge-Verteilung',
		'feed' => 'Feed',	// IGNORE
		'feed_per_category' => 'Feeds pro Kategorie',
		'idle' => 'Inaktive Feeds',
		'main' => 'Haupt-Statistiken',
		'main_stream' => 'Haupt-Feeds',
		'no_idle' => 'Es gibt keinen inaktiven Feed!',
		'number_entries' => '%d Artikel',
		'percent_of_total' => '% Gesamt',
		'repartition' => 'Artikel-Verteilung',
		'status_favorites' => 'Favoriten',
		'status_read' => 'Gelesen',
		'status_total' => 'Gesamt',
		'status_unread' => 'Ungelesen',
		'title' => 'Statistiken',
		'top_feed' => 'Top 10-Feeds',
	],
	'system' => [
		'_' => 'Systemeinstellungen',
		'auto-update-url' => 'Auto-Update URL',
		'base-url' => [
			'_' => 'Base URL',	// TODO
			'recommendation' => 'Automatic recommendation: <kbd>%s</kbd>',	// TODO
		],
		'cookie-duration' => [
			'help' => 'in Sekunden',
			'number' => 'Eingeloggt bleiben für',
		],
		'force_email_validation' => 'E-Mail Adressvalidierung erzwingen',
		'instance-name' => 'Bezeichnung',
		'max-categories' => 'Anzahl erlaubter Kategorien pro Benutzer',
		'max-feeds' => 'Anzahl erlaubter Feeds pro Benutzer',
		'registration' => [
			'number' => 'Maximale Anzahl von Accounts',
			'select' => [
				'label' => 'Registrierungsformular',
				'option' => [
					'noform' => 'Deaktiviert: Keine Registrierung möglich',
					'nolimit' => 'Aktiviert: Registrierung möglich',
					'setaccountsnumber' => 'Anzahl maximaler Benutzer-Acounts festlegen',
				],
			],
			'status' => [
				'disabled' => 'Formular deaktiviert',
				'enabled' => 'Formular aktiviert',
			],
			'title' => 'Benutzer-Registrierungsformular',
		],
		'sensitive-parameter' => 'Sensitive parameter. Edit manually in <kbd>./data/config.php</kbd>',	// TODO
		'tos' => [
			'disabled' => 'sind nicht aktiviert',
			'enabled' => '<a href="./?a=tos">sind aktiv</a>',
			'help' => 'So werden die <a href="https://freshrss.github.io/FreshRSS/en/admins/12_User_management.html#enable-terms-of-service-tos" target="_blank">Nutzungsbedingungen aktiviert</a>',
		],
		'websub' => [
			'help' => 'About <a href="https://freshrss.github.io/FreshRSS/en/users/WebSub.html" target="_blank">WebSub</a>',	// TODO
		],
	],
	'update' => [
		'_' => 'System aktualisieren',
		'apply' => 'Anwenden',
		'changelog' => 'Liste der Änderungen',
		'check' => 'Auf neue Aktualisierungen prüfen',
		'copiedFromURL' => 'update.php wurde von %s nach ./data kopiert',
		'current_version' => 'Aktuelle Version',
		'last' => 'Letzte Überprüfung',
		'loading' => 'Aktualisierung läuft…',
		'none' => 'Keine ausstehende Aktualisierung',
		'releaseChannel' => [
			'_' => 'Veröffentlichungskanal',
			'edge' => 'Aktueller Entwicklungsstand (“edge”)',
			'latest' => 'Stabile Version (“latest”)',
		],
		'title' => 'System aktualisieren',
		'viaGit' => 'Update über git und Github.com gestartet',
	],
	'user' => [
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
		'number' => 'Es wurde bis jetzt %d Account erstellt',
		'numbers' => 'Es wurden bis jetzt %d Accounts erstellt',
		'password_form' => 'Passwort<br /><small>(für die Anmeldemethode per Webformular)</small>',
		'password_format' => 'mindestens 7 Zeichen',
		'title' => 'Benutzer verwalten',
		'username' => 'Nutzername',
	],
];
