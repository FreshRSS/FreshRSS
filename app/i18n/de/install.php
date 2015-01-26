<?php

return array(
	'action' => array(
		'finish' => 'Installation fertigstellen',
		'fix_errors_before' => 'Fehler korrigieren, bevor zum nächsten Schritt gesprungen wird.',
		'next_step' => 'Zum nächsten Schritt gehen',
	),
	'auth' => array(
		'email_persona' => 'Anmelde-E-Mail-Adresse<br /><small>(für <a href="https://persona.org/" rel="external">Mozilla Persona</a>)</small>',
		'form' => 'Webformular (traditionell, benötigt JavaScript)',
		'http' => 'HTTP (HTTPS für erfahrene Benutzer)',
		'none' => 'Keine (gefährlich)',
		'password_form' => 'Passwort<br /><small>(für die Anmeldemethode per Webformular)</small>',
		'password_format' => 'mindestens 7 Zeichen',
		'persona' => 'Mozilla Persona (modern, benötigt JavaScript)',
		'type' => 'Authentifizierungsmethode',
	),
	'bdd' => array(
		'_' => 'Datenbank',
		'conf' => array(
			'_' => 'Datenbank-Konfiguration',
			'ko' => 'Überprüfen Sie Ihre Datenbank-Information.',
			'ok' => 'Datenbank-Konfiguration ist gespeichert worden.',
		),
		'host' => 'Host',
		'prefix' => 'Tabellen-Präfix',
		'password' => 'HTTP-Password',
		'type' => 'Datenbank-Typ',
		'username' => 'HTTP-Nutzername',
	),
	'check' => array(
		'_' => 'Überprüfungen',
		'cache' => array(
			'nok' => 'Überprüfen Sie die Berechtigungen des Verzeichnisses <em>./data/cache</em>. Der HTTP-Server muss Schreibrechte besitzen.',
			'ok' => 'Berechtigungen des Verzeichnisses <em>./data/cache</em> sind in Ordnung.',
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
			'ok' => 'Berechtigungen des Verzeichnisses <em>./data</em> sind in Ordnung.',
		),
		'dom' => array(
			'nok' => 'Ihnen fehlt eine benötigte Bibliothek um DOM zu durchstöbern (Paket php-xml).',
			'ok' => 'Sie haben die benötigte Bibliothek um DOM zu durchstöbern.',
		),
		'favicons' => array(
			'nok' => 'Überprüfen Sie die Berechtigungen des Verzeichnisses <em>./data/favicons</em>. Der HTTP-Server muss Schreibrechte besitzen.',
			'ok' => 'Berechtigungen des Verzeichnisses <em>./data/favicons</em> sind in Ordnung.',
		),
		'http_referer' => array(
			'nok' => 'Bitte stellen Sie sicher, dass Sie Ihren HTTP REFERER nicht abändern.',
			'ok' => 'Ihr HTTP REFERER ist bekannt und entspricht Ihrem Server.',
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
			'ok' => 'Berechtigungen des Verzeichnisses <em>./data/persona</em> sind in Ordnung.',
		),
		'php' => array(
			'nok' => 'Ihre PHP-Version ist %s aber FreshRSS benötigt mindestens Version %s.',
			'ok' => 'Ihre PHP-Version ist %s, welche kompatibel mit FreshRSS ist.',
		),
		'users' => array(
			'nok' => 'Überprüfen Sie die Berechtigungen des Verzeichnisses <em>./data/users</em>. Der HTTP-Server muss Schreibrechte besitzen.',
			'ok' => 'Berechtigungen des Verzeichnisses <em>./data/users</em> sind in Ordnung.',
		),
	),
	'conf' => array(
		'_' => 'Allgemeine Konfiguration',
		'ok' => 'Allgemeine Konfiguration ist gespeichert worden.',
	),
	'congratulations' => 'Glückwunsch!',
	'default_user' => 'Nutzername des Standardbenutzers <small>(maximal 16 alphanumerische Zeichen)</small>',
	'delete_articles_after' => 'Entferne Artikel nach',
	'fix_errors_before' => 'Fehler korrigieren, bevor zum nächsten Schritt gesprungen wird.',
	'javascript_is_better' => 'FreshRSS ist ansprechender mit aktiviertem JavaScript',
	'language' => array(
		'_' => 'Sprache',
		'choose' => 'Wählen Sie eine Sprache für FreshRSS',
		'defined' => 'Sprache ist festgelegt worden.',
	),
	'not_deleted' => 'Etwas ist schiefgelaufen; Sie müssen die Datei <em>%s</em> manuell löschen.',
	'ok' => 'Der Installationsvorgang war erfolgreich.',
	'step' => 'Schritt %d',
	'steps' => 'Schritte',
	'title' => 'Installation · FreshRSS',
	'this_is_the_end' => 'Das ist das Ende',
);
