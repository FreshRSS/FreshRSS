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
	'action' => array(
		'finish' => 'Installation fertigstellen',
		'fix_errors_before' => 'Bitte Fehler korrigieren, bevor zum nächsten Schritt gesprungen wird.',
		'keep_install' => 'Vorherige Konfiguration beibehalten',
		'next_step' => 'Zum nächsten Schritt springen',
		'reinstall' => 'Neuinstallation von FreshRSS',
	),
	'bdd' => array(
		'_' => 'Datenbank',
		'conf' => array(
			'_' => 'Datenbank-Konfiguration',
			'ko' => 'Überprüfen Sie Ihre Datenbank-Information.',
			'ok' => 'Datenbank-Konfiguration wurde gespeichert.',
		),
		'host' => 'Host',	// IGNORE
		'password' => 'Datenbank-Password',
		'prefix' => 'Tabellen-Präfix',
		'type' => 'Datenbank-Typ',
		'username' => 'Datenbank-Benutzername',
	),
	'check' => array(
		'_' => 'Überprüfungen',
		'already_installed' => 'Wir haben festgestellt, dass FreshRSS bereits installiert wurde!',
		'cache' => array(
			'nok' => 'Überprüfen Sie die Berechtigungen des Verzeichnisses <em>%s</em>. Der HTTP-Server muss Schreibrechte besitzen.',
			'ok' => 'Die Berechtigungen des Verzeichnisses <em>%s</em> sind in Ordnung.',
		),
		'ctype' => array(
			'nok' => 'Ihnen fehlt eine benötigte Bibliothek für die Überprüfung von Zeichentypen (php-ctype).',
			'ok' => 'Sie haben die benötigte Bibliothek für die Überprüfung von Zeichentypen (ctype).',
		),
		'curl' => array(
			'nok' => 'Ihnen fehlt cURL (Paket php-curl).',
			'ok' => 'Sie haben die cURL-Erweiterung.',
		),
		'data' => array(
			'nok' => 'Überprüfen Sie die Berechtigungen des Verzeichnisses <em>%s</em>. Der HTTP-Server muss Schreibrechte besitzen.',
			'ok' => 'Die Berechtigungen des Verzeichnisses <em>%s</em> sind in Ordnung.',
		),
		'database-connection' => array(
			'nok' => 'Fehler bei der Datenbankverbindung.',
			'ok' => 'Datenbankverbindung ist in Ordnung.',
		),
		'database-table' => array(
			'nok' => 'Die Datenbanktabelle „%s“ ist unvollständig.',
			'ok' => 'Die Datenbanktabelle „%s“ ist in Ordnung.',
		),
		'database-tables' => array(
			'nok' => 'Einige Datenbanktabellen fehlen.',
			'ok' => 'Alle Datenbanktabellen sind vorhanden.',
		),
		'database-title' => 'Datenbank',
		'dom' => array(
			'nok' => 'Ihnen fehlt eine benötigte Bibliothek um DOM zu durchstöbern.',
			'ok' => 'Sie haben die benötigte Bibliothek um DOM zu durchstöbern.',
		),
		'favicons' => array(
			'nok' => 'Überprüfen Sie die Berechtigungen des Verzeichnisses <em>%s</em>. Der HTTP-Server muss Schreibrechte besitzen.',
			'ok' => 'Die Berechtigungen des Verzeichnisses <em>%s</em> sind in Ordnung.',
		),
		'fileinfo' => array(
			'nok' => 'Die empfohlene PHP-Bibliothek „fileinfo“ (Paket „fileinfo“) kann nicht gefunden werden.',
			'ok' => 'Sie verfügen über die empfohlene PHP-Bibliothek „fileinfo“ (Paket „fileinfo“).',
		),
		'files' => 'Datei-Installation',
		'intl' => array(
			'nok' => 'Die empfohlene Bibliothek php-intl für die Internationalisierung kann nicht gefunden werden.',
			'ok' => 'Sie haben die empfohlene Bibliothek php-intl für die Internationalisierung.',
		),
		'json' => array(
			'nok' => 'Ihnen fehlt eine empfohlene Bibliothek um JSON zu parsen.',
			'ok' => 'Sie haben eine empfohlene Bibliothek um JSON zu parsen.',
		),
		'mbstring' => array(
			'nok' => 'Es fehlt die empfohlene mbstring-Bibliothek für Unicode.',
			'ok' => 'Sie haben die empfohlene mbstring-Bibliothek für Unicode.',
		),
		'pcre' => array(
			'nok' => 'Ihnen fehlt eine benötigte Bibliothek für reguläre Ausdrücke (php-pcre).',
			'ok' => 'Sie haben die benötigte Bibliothek für reguläre Ausdrücke (PCRE).',
		),
		'pdo-mysql' => array(
			'nok' => 'Der erforderliche PDO-Treiber für MySQL/MariaDB kann nicht gefunden werden.',
		),
		'pdo-pgsql' => array(
			'nok' => 'Der erforderliche PDO-Treiber für PostgreSQL kann nicht gefunden werden.',
		),
		'pdo-sqlite' => array(
			'nok' => 'Der PDO-Treiber für SQLite kann nicht gefunden werden.',
			'ok' => 'Sie haben den PDO-Treiber für SQLite.',
		),
		'pdo' => array(
			'nok' => 'Ihnen fehlt PDO oder einer der unterstützten Treiber (pdo_sqlite, pdo_pgsql, pdo_mysql).',
			'ok' => 'Sie haben PDO und mindestens einen der unterstützten Treiber (pdo_sqlite, pdo_pgsql, pdo_mysql).',
		),
		'php' => array(
			'_' => 'PHP-Installation',
			'nok' => 'Ihre PHP-Version ist %s aber FreshRSS benötigt mindestens Version %s.',
			'ok' => 'Ihre PHP-Version ist %s, welche kompatibel mit FreshRSS ist.',
		),
		'reload' => 'Nochmal prüfen',
		'tmp' => array(
			'nok' => 'Überprüfen Sie die Berechtigungen des Verzeichnisses <em>%s</em>. Der HTTP-Server muss Schreibrechte besitzen.',
			'ok' => 'Die Berechtigungen des Temp Verzeichnisses sind in Ordnung.',
		),
		'tokens' => array(
			'nok' => 'Überprüfen Sie die Berechtigungen des Verzeichnisses <em>./data/tokens</em>. Der HTTP-Server muss Schreibrechte besitzen.',
			'ok' => 'Die Berechtigungen des Verzeichnisses <em>./data/tokens</em> sind in Ordnung.',
		),
		'unknown_process_username' => 'unbekannt',
		'users' => array(
			'nok' => 'Überprüfen Sie die Berechtigungen des Verzeichnisses <em>%s</em>. Der HTTP-Server muss Schreibrechte besitzen.',
			'ok' => 'Die Berechtigungen des Verzeichnisses <em>%s</em> sind in Ordnung.',
		),
		'xml' => array(
			'nok' => 'Ihnen fehlt die benötigte Bibliothek um XML zu parsen.',
			'ok' => 'Sie haben die benötigte Bibliothek um XML zu parsen.',
		),
		'zip' => array(
			'nok' => 'Ihnen fehlt die ZIP-Erweiterung (Paket php-zip).',
			'ok' => 'Sie haben die empfohlene Erweiterung für ZIP (php-zip-Paket).',
		),
	),
	'conf' => array(
		'_' => 'Allgemeine Konfiguration',
		'ok' => 'Die allgemeine Konfiguration ist gespeichert worden.',
	),
	'congratulations' => 'Glückwunsch!',
	'default_user' => array(
		'_' => 'Benutzername des Standardbenutzers',
		'max_char' => 'maximal 16 alphanumerische Zeichen',
	),
	'fix_errors_before' => 'Bitte den Fehler korrigieren, bevor zum nächsten Schritt gesprungen wird.',
	'javascript_is_better' => 'FreshRSS ist angenehmer, wenn JavaScript aktiviert ist.',
	'js' => array(
		'confirm_reinstall' => 'Durch die Neuinstallation von FreshRSS gehen Ihre bisherigen Einstellungen verloren. Möchten Sie wirklich fortfahren?',
	),
	'language' => array(
		'_' => 'Sprache',
		'choose' => 'Wählen Sie eine Sprache für FreshRSS',
		'defined' => 'Die Sprache wurde festgelegt.',
	),
	'missing_applied_migrations' => 'Etwas ist schief gelaufen. Bitte erstellen Sie eine leere <em>%s</em> Datei manuell.',
	'ok' => 'Der Installationsvorgang war erfolgreich.',
	'session' => array(
		'nok' => 'Der Webserver scheint nicht korrekt konfiguriert zu sein, damit notwendige PHP-Session-Cookies verwendet werden können.',
	),
	'step' => 'Schritt %d',
	'steps' => 'Schritte',
	'this_is_the_end' => 'Das ist das Ende',
	'title' => 'Installation · FreshRSS',	// IGNORE
);
