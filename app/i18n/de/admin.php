<?php

return array(
	'auth' => array(
		'allow_anonymous' => 'Anonymes Lesen der Artikel des Standardbenutzers (%s) erlauben',
		'allow_anonymous_refresh' => 'Anonymes Aktualisieren der Artikel erlauben',
		'api_enabled' => '<abbr>API</abbr>-Zugriff erlauben <small>(für mobile Anwendungen benötigt)</small>',
		'form' => 'Webformular (traditionell, benötigt JavaScript)',
		'http' => 'HTTP (HTTPS für erfahrene Benutzer)',
		'none' => 'Keine (gefährlich)',
		'persona' => 'Mozilla Persona (modern, benötigt JavaScript)',
		'title' => 'Authentifizierung',
		'title_reset' => 'Zurücksetzen der Authentifizierung',
		'token' => 'Authentifizierungs-Token',
		'token_help' => 'Erlaubt den Zugriff auf die RSS-Ausgabe des Standardbenutzers ohne Authentifizierung.',
		'type' => 'Authentifizierungsmethode',
		'unsafe_autologin' => 'Erlaube unsicheres automatisches Anmelden mit folgendem Format: ',
	),
	'check_install' => array(
		'cache' => array(
			'nok' => 'Überprüfen Sie die Berechtigungen des Verzeichnisses <em>./data/cache</em>. Der HTTP-Server muss Schreibrechte besitzen.',
			'ok' => 'Die Berechtigungen des Verzeichnisses <em>./data/cache</em> sind in Ordnung.',
		),
		'categories' => array(
			'nok' => 'Die Tabelle <em>category</em> ist schlecht konfiguriert.',
			'ok' => 'Die Tabelle <em>category</em> ist korrekt konfiguriert.',
		),
		'connection' => array(
			'nok' => 'Verbindung zur Datenbank kann nicht aufgebaut werden.',
			'ok' => 'Verbindung zur Datenbank konnte aufgebaut werden.',
		),
		'ctype' => array(
			'nok' => 'Ihnen fehlt eine benötigte Bibliothek für die Überprüfung von Zeichentypen (php-ctype).',
			'ok' => 'Sie haben die benötigte Bibliothek für die Überprüfung von Zeichentypen (ctype).',
		),
		'curl' => array(
			'nok' => 'Ihnen fehlt cURL (Paket php5-curl).',
			'ok' => 'Sie haben die cURL-Erweiterung.',
		),
		'data' => array(
			'nok' => 'Überprüfen Sie die Berechtigungen des Verzeichnisses <em>./data</em>. Der HTTP-Server muss Schreibrechte besitzen.',
			'ok' => 'Die Berechtigungen des Verzeichnisses <em>./data</em> sind in Ordnung.',
		),
		'database' => 'Datenbank-Installation',
		'dom' => array(
			'nok' => 'Ihnen fehlt eine benötigte Bibliothek um DOM zu durchstöbern (Paket php-xml).',
			'ok' => 'Sie haben die benötigte Bibliothek um DOM zu durchstöbern.',
		),
		'entries' => array(
			'nok' => 'Die Tabelle <em>entry</em> ist schlecht konfiguriert.',
			'ok' => 'Die Tabelle <em>entry</em> ist korrekt konfiguriert.',
		),
		'favicons' => array(
			'nok' => 'Überprüfen Sie die Berechtigungen des Verzeichnisses <em>./data/favicons</em>. Der HTTP-Server muss Schreibrechte besitzen.',
			'ok' => 'Die Berechtigungen des Verzeichnisses <em>./data/favicons</em> sind in Ordnung.',
		),
		'feeds' => array(
			'nok' => 'Die Tabelle <em>feed</em> ist schlecht konfiguriert.',
			'ok' => 'Die Tabelle <em>feed</em> ist korrekt konfiguriert.',
		),
		'files' => 'Datei-Installation',
		'json' => array(
			'nok' => 'Ihnen fehlt die JSON-Erweiterung (Paket php5-json).',
			'ok' => 'Sie haben die JSON-Erweiterung.',
		),
		'minz' => array(
			'nok' => 'Ihnen fehlt das Minz-Framework.',
			'ok' => 'Sie haben das Minz-Framework.',
		),
		'pcre' => array(
			'nok' => 'Ihnen fehlt eine benötigte Bibliothek für reguläre Ausdrücke (php-pcre).',
			'ok' => 'Sie haben die benötigte Bibliothek für reguläre Ausdrücke (PCRE).',
		),
		'pdo' => array(
			'nok' => 'Ihnen fehlt PDO oder einer der unterstützten Treiber (pdo_mysql, pdo_sqlite).',
			'ok' => 'Sie haben PDO und mindestens einen der unterstützten Treiber (pdo_mysql, pdo_sqlite).',
		),
		'persona' => array(
			'nok' => 'Überprüfen Sie die Berechtigungen des Verzeichnisses <em>./data/persona</em>. Der HTTP-Server muss Schreibrechte besitzen.',
			'ok' => 'Die Berechtigungen des Verzeichnisses <em>./data/persona</em> sind in Ordnung.',
		),
		'php' => array(
			'_' => 'PHP-Installation',
			'nok' => 'Ihre PHP-Version ist %s aber FreshRSS benötigt mindestens Version %s.',
			'ok' => 'Ihre PHP-Version ist %s, welche kompatibel mit FreshRSS ist.',
		),
		'tables' => array(
			'nok' => 'Es fehlen eine oder mehrere Tabellen in der Datenbank.',
			'ok' => 'Tabellen existieren in der Datenbank.',
		),
		'title' => 'Installationsüberprüfung',
		'tokens' => array(
			'nok' => 'Überprüfen Sie die Berechtigungen des Verzeichnisses <em>./data/tokens</em>. Der HTTP-Server muss Schreibrechte besitzen.',
			'ok' => 'Die Berechtigungen des Verzeichnisses <em>./data/tokens</em> sind in Ordnung.',
		),
		'users' => array(
			'nok' => 'Überprüfen Sie die Berechtigungen des Verzeichnisses <em>./data/users</em>. Der HTTP-Server muss Schreibrechte besitzen.',
			'ok' => 'Die Berechtigungen des Verzeichnisses <em>./data/users</em> sind in Ordnung.',
		),
		'zip' => array(
			'nok' => 'Ihnen fehlt die ZIP-Erweiterung (Paket php5-zip).',
			'ok' => 'Sie haben die ZIP-Erweiterung.',
		),
	),
	'extensions' => array(
		'disabled' => 'Deaktiviert',
		'empty_list' => 'Es gibt keine installierte Erweiterung.',
		'enabled' => 'Aktiviert',
		'no_configure_view' => 'Diese Erweiterung kann nicht konfiguriert werden.',
		'system' => array(
			'_' => 'System-Erweiterungen',
			'no_rights' => 'System-Erweiterung (Sie haben keine Berechtigung dafür)',
		),
		'title' => 'Erweiterungen',
		'user' => 'Benutzer-Erweiterungen',
	),
	'stats' => array(
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
		'feed' => 'Feed',
		'feed_per_category' => 'Feeds pro Kategorie',
		'idle' => 'Inaktive Feeds',
		'main' => 'Haupt-Statistiken',
		'main_stream' => 'Haupt-Feeds',
		'menu' => array(
			'idle' => 'Inaktive Feeds',
			'main' => 'Haupt-Statistiken',
			'repartition' => 'Artikel-Verteilung',
		),
		'no_idle' => 'Es gibt keinen inaktiven Feed!',
		'number_entries' => '%d Artikel',
		'percent_of_total' => '%% Gesamt',
		'repartition' => 'Artikel-Verteilung',
		'status_favorites' => 'Favoriten',
		'status_read' => 'Gelesen',
		'status_total' => 'Gesamt',
		'status_unread' => 'Ungelesen',
		'title' => 'Statistiken',
		'top_feed' => 'Top 10-Feeds',
	),
	'system' => array(
		'_' => 'System configuration', // @todo translate
		'auto-update-url' => 'Auto-update server URL', // @todo translate
		'instance-name' => 'Instance name', // @todo translate
		'max-categories' => 'Categories per user limit', // @todo translate
		'max-feeds' => 'Feeds per user limit', // @todo translate
		'registration' => array(
			'help' => '0 meint, dass es kein Account Limit gibt',
			'number' => 'Maximale Anzahl von Accounts',
		),
	),
	'update' => array(
		'_' => 'System aktualisieren',
		'apply' => 'Anwenden',
		'check' => 'Auf neue Aktualisierungen prüfen',
		'current_version' => 'Ihre aktuelle Version von FreshRSS ist %s.',
		'last' => 'Letzte Überprüfung: %s',
		'none' => 'Keine ausstehende Aktualisierung',
		'title' => 'System aktualisieren',
	),
	'user' => array(
		'articles_and_size' => '%s Artikel (%s)',
		'create' => 'Neuen Benutzer erstellen',
		'email_persona' => 'Anmelde-E-Mail-Adresse<br /><small>(für <a href="https://persona.org/" rel="external">Mozilla Persona</a>)</small>',
		'language' => 'Sprache',
		'number' => 'Es wurde bis jetzt %d Account erstellt',
		'numbers' => 'Es wurden bis jetzt %d Accounts erstellt',
		'password_form' => 'Passwort<br /><small>(für die Anmeldemethode per Webformular)</small>',
		'password_format' => 'mindestens 7 Zeichen',
		'title' => 'Benutzer verwalten',
		'user_list' => 'Liste der Benutzer',
		'username' => 'Nutzername',
		'users' => 'Benutzer',
	),
);
