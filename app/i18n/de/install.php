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
	'action' => [
		'finish' => 'Installation fertigstellen',
		'fix_errors_before' => 'Bitte Fehler korrigieren, bevor zum nächsten Schritt gesprungen wird.',
		'keep_install' => 'Vorherige Konfiguration beibehalten',
		'next_step' => 'Zum nächsten Schritt springen',
		'reinstall' => 'Neuinstallation von FreshRSS',
	],
	'auth' => [
		'form' => 'Webformular (traditionell, benötigt JavaScript)',
		'http' => 'HTTP (HTTPS für erfahrene Benutzer)',
		'none' => 'Keine (gefährlich)',
		'password_form' => 'Passwort<br /><small>(für die Anmeldemethode per Webformular)</small>',
		'password_format' => 'mindestens 7 Zeichen',
		'type' => 'Authentifizierungsmethode',
	],
	'bdd' => [
		'_' => 'Datenbank',
		'conf' => [
			'_' => 'Datenbank-Konfiguration',
			'ko' => 'Überprüfen Sie Ihre Datenbank-Information.',
			'ok' => 'Datenbank-Konfiguration ist gespeichert worden.',
		],
		'host' => 'Host',	// IGNORE
		'password' => 'Datenbank-Password',
		'prefix' => 'Tabellen-Präfix',
		'type' => 'Datenbank-Typ',
		'username' => 'Datenbank-Benutzername',
	],
	'check' => [
		'_' => 'Überprüfungen',
		'already_installed' => 'Wir haben festgestellt, dass FreshRSS bereits installiert wurde!',
		'cache' => [
			'nok' => 'Überprüfen Sie die Berechtigungen des Verzeichnisses <em>%s</em>. Der HTTP-Server muss Schreibrechte besitzen.',
			'ok' => 'Die Berechtigungen des Verzeichnisses <em>%s</em> sind in Ordnung.',
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
			'nok' => 'Überprüfen Sie die Berechtigungen des Verzeichnisses <em>%s</em>. Der HTTP-Server muss Schreibrechte besitzen.',
			'ok' => 'Die Berechtigungen des Verzeichnisses <em>%s</em> sind in Ordnung.',
		],
		'dom' => [
			'nok' => 'Ihnen fehlt eine benötigte Bibliothek um DOM zu durchstöbern.',
			'ok' => 'Sie haben die benötigte Bibliothek um DOM zu durchstöbern.',
		],
		'favicons' => [
			'nok' => 'Überprüfen Sie die Berechtigungen des Verzeichnisses <em>%s</em>. Der HTTP-Server muss Schreibrechte besitzen.',
			'ok' => 'Die Berechtigungen des Verzeichnisses <em>%s</em> sind in Ordnung.',
		],
		'fileinfo' => [
			'nok' => 'Ihnen fehlt PHP fileinfo (Paket fileinfo).',
			'ok' => 'Sie haben die fileinfo-Erweiterung.',
		],
		'json' => [
			'nok' => 'Ihnen fehlt eine empfohlene Bibliothek um JSON zu parsen.',
			'ok' => 'Sie haben eine empfohlene Bibliothek um JSON zu parsen.',
		],
		'mbstring' => [
			'nok' => 'Es fehlt die empfohlene mbstring-Bibliothek für Unicode.',
			'ok' => 'Sie haben die empfohlene mbstring-Bibliothek für Unicode.',
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
			'nok' => 'Ihre PHP-Version ist %s aber FreshRSS benötigt mindestens Version %s.',
			'ok' => 'Ihre PHP-Version ist %s, welche kompatibel mit FreshRSS ist.',
		],
		'reload' => 'Nochmal prüfen',
		'tmp' => [
			'nok' => 'Überprüfen Sie die Berechtigungen des Verzeichnisses <em>%s</em>. Der HTTP-Server muss Schreibrechte besitzen.',
			'ok' => 'Die Berechtigungen des Temp Verzeichnisses sind in Ordnung.',
		],
		'unknown_process_username' => 'unbekannt',
		'users' => [
			'nok' => 'Überprüfen Sie die Berechtigungen des Verzeichnisses <em>%s</em>. Der HTTP-Server muss Schreibrechte besitzen.',
			'ok' => 'Die Berechtigungen des Verzeichnisses <em>%s</em> sind in Ordnung.',
		],
		'xml' => [
			'nok' => 'Ihnen fehlt die benötigte Bibliothek um XML zu parsen.',
			'ok' => 'Sie haben die benötigte Bibliothek um XML zu parsen.',
		],
	],
	'conf' => [
		'_' => 'Allgemeine Konfiguration',
		'ok' => 'Die allgemeine Konfiguration ist gespeichert worden.',
	],
	'congratulations' => 'Glückwunsch!',
	'default_user' => [
		'_' => 'Benutzername des Standardbenutzers',
		'max_char' => 'maximal 16 alphanumerische Zeichen',
	],
	'fix_errors_before' => 'Bitte den Fehler korrigieren, bevor zum nächsten Schritt gesprungen wird.',
	'javascript_is_better' => 'FreshRSS ist ansprechender mit aktiviertem JavaScript',
	'js' => [
		'confirm_reinstall' => 'Die vorherige Konfiguration (Daten) geht verloren während FreshRSS neu installiert wird. Sind Sie sich sicher fortzufahren?',
	],
	'language' => [
		'_' => 'Sprache',
		'choose' => 'Wählen Sie eine Sprache für FreshRSS',
		'defined' => 'Die Sprache wurde festgelegt.',
	],
	'missing_applied_migrations' => 'Etwas ist schief gelaufen. Bitte erstellen Sie eine leere <em>%s</em> Datei manuell.',
	'ok' => 'Der Installationsvorgang war erfolgreich.',
	'session' => [
		'nok' => 'Der Webserver scheint nicht korrekt konfiguriert zu sein, damit notwendige PHP-Session-Cookies verwendet werden können.',
	],
	'step' => 'Schritt %d',
	'steps' => 'Schritte',
	'this_is_the_end' => 'Das ist das Ende',
	'title' => 'Installation · FreshRSS',	// IGNORE
];
