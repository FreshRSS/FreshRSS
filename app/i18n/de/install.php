<?php

return array(
	'action' => array(
		'finish' => 'Installation fertigstellen',
		'fix_errors_before' => 'Bitte Fehler korrigieren, bevor zum nächsten Schritt gesprungen wird.',
		'keep_install' => 'Vorherige Konfiguration beibehalten',
		'next_step' => 'Zum nächsten Schritt springen',
		'reinstall' => 'Neuinstallation von FreshRSS',
	),
	'auth' => array(
		'form' => 'Webformular (traditionell, benötigt JavaScript)',
		'http' => 'HTTP (HTTPS für erfahrene Benutzer)',
		'none' => 'Keine (gefährlich)',
		'password_form' => 'Passwort<br /><small>(für die Anmeldemethode per Webformular)</small>',
		'password_format' => 'mindestens 7 Zeichen',
		'type' => 'Authentifizierungsmethode',
	),
	'bdd' => array(
		'conf' => array(
			'ko' => 'Überprüfen Sie Ihre Datenbank-Information.',
			'ok' => 'Datenbank-Konfiguration ist gespeichert worden.',
			'_' => 'Datenbank-Konfiguration',
		),
		'host' => 'Host',	// TODO - Translation
		'password' => 'SQL-Password',
		'prefix' => 'Tabellen-Präfix',
		'type' => 'Datenbank-Typ',
		'username' => 'SQL-Nutzername',
		'_' => 'Datenbank',
	),
	'check' => array(
		'already_installed' => 'Wir haben festgestellt, dass FreshRSS bereits installiert wurde!',
		'cache' => array(
			'nok' => 'Überprüfen Sie die Berechtigungen des Verzeichnisses <em>./data/cache</em>. Der HTTP-Server muss Schreibrechte besitzen.',
			'ok' => 'Die Berechtigungen des Verzeichnisses <em>./data/cache</em> sind in Ordnung.',
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
			'nok' => 'Überprüfen Sie die Berechtigungen des Verzeichnisses <em>./data</em>. Der HTTP-Server muss Schreibrechte besitzen.',
			'ok' => 'Die Berechtigungen des Verzeichnisses <em>./data</em> sind in Ordnung.',
		),
		'dom' => array(
			'nok' => 'Ihnen fehlt eine benötigte Bibliothek um DOM zu durchstöbern.',
			'ok' => 'Sie haben die benötigte Bibliothek um DOM zu durchstöbern.',
		),
		'favicons' => array(
			'nok' => 'Überprüfen Sie die Berechtigungen des Verzeichnisses <em>./data/favicons</em>. Der HTTP-Server muss Schreibrechte besitzen.',
			'ok' => 'Die Berechtigungen des Verzeichnisses <em>./data/favicons</em> sind in Ordnung.',
		),
		'fileinfo' => array(
			'nok' => 'Ihnen fehlt PHP fileinfo (Paket fileinfo).',
			'ok' => 'Sie haben die fileinfo-Erweiterung.',
		),
		'http_referer' => array(
			'nok' => 'Bitte stellen Sie sicher, dass Sie Ihren HTTP REFERER nicht abändern.',
			'ok' => 'Ihr HTTP REFERER ist bekannt und entspricht Ihrem Server.',
		),
		'json' => array(
			'nok' => 'Ihnen fehlt eine empfohlene Bibliothek um JSON zu parsen.',
			'ok' => 'Sie haben eine empfohlene Bibliothek um JSON zu parsen.',
		),
		'mbstring' => array(
			'nok' => 'Es fehlt die empfohlene mbstring-Bibliothek für Unicode.',
			'ok' => 'Sie haben die empfohlene mbstring-Bibliothek für Unicode.',
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
			'nok' => 'Ihnen fehlt PDO oder einer der unterstützten Treiber (pdo_mysql, pdo_sqlite, pdo_pgsql).',
			'ok' => 'Sie haben PDO und mindestens einen der unterstützten Treiber (pdo_mysql, pdo_sqlite, pdo_pgsql).',
		),
		'php' => array(
			'nok' => 'Ihre PHP-Version ist %s aber FreshRSS benötigt mindestens Version %s.',
			'ok' => 'Ihre PHP-Version ist %s, welche kompatibel mit FreshRSS ist.',
		),
		'users' => array(
			'nok' => 'Überprüfen Sie die Berechtigungen des Verzeichnisses <em>./data/users</em>. Der HTTP-Server muss Schreibrechte besitzen.',
			'ok' => 'Die Berechtigungen des Verzeichnisses <em>./data/users</em> sind in Ordnung.',
		),
		'xml' => array(
			'nok' => 'Ihnen fehlt die benötigte Bibliothek um XML zu parsen.',
			'ok' => 'Sie haben die benötigte Bibliothek um XML zu parsen.',
		),
		'_' => 'Überprüfungen',
	),
	'conf' => array(
		'ok' => 'Die allgemeine Konfiguration ist gespeichert worden.',
		'_' => 'Allgemeine Konfiguration',
	),
	'congratulations' => 'Glückwunsch!',
	'default_user' => 'Nutzername des Standardbenutzers <small>(maximal 16 alphanumerische Zeichen)</small>',
	'delete_articles_after' => 'Entferne Artikel nach',
	'fix_errors_before' => 'Bitte den Fehler korrigieren, bevor zum nächsten Schritt gesprungen wird.',
	'javascript_is_better' => 'FreshRSS ist ansprechender mit aktiviertem JavaScript',
	'js' => array(
		'confirm_reinstall' => 'Du wirst deine vorherige Konfiguration (Daten) verlieren FreshRSS. Bist du sicher, dass du fortfahren willst?',
	),
	'language' => array(
		'choose' => 'Wählen Sie eine Sprache für FreshRSS',
		'defined' => 'Die Sprache ist festgelegt worden.',
		'_' => 'Sprache',
	),
	'not_deleted' => 'Etwas ist schiefgelaufen; Sie müssen die Datei <em>%s</em> manuell löschen.',
	'ok' => 'Der Installationsvorgang war erfolgreich.',
	'step' => 'Schritt %d',
	'steps' => 'Schritte',
	'this_is_the_end' => 'Das ist das Ende',
	'title' => 'Installation · FreshRSS',	// TODO - Translation
);
