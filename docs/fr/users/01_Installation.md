# Les pré-requis sur le serveur

FreshRSS est un logiciel développé en PHP reposant sur le modèle client - serveur. C’est-à-dire qu’il vous faudra un serveur web pour en profiter. Ensuite, FreshRSS ne demande pas une configuration très fournie et peut donc, en théorie, tourner sur la plupart des serveurs mutualisés.

Il est toutefois de votre responsabilité de vérifier que votre hébergement permettra de faire tourner FreshRSS avant de nous taper dessus. Dans le cas où les informations listées ci-dessous ne seraient pas à jour, vous pourrez.

| Logiciel         | Recommandé         | Fonctionne aussi avec          |
| --------         | -----------        | ---------------------          |
| Serveur web      | **Apache 2.4+**    | nginx, lighttpd |
| PHP              | **PHP 8.1+**       | FreshRSS 1.24.3 : PHP 7.4+<br />FreshRSS 1.22.1 : PHP 7.2+ |
| Modules PHP      | Requis : libxml, cURL, JSON, PDO_MySQL, PCRE et ctype<br />Requis (32 bits seulement) : GMP<br />Recommandé : Zlib, mbstring et iconv, ZipArchive<br />*Pour une liste complète des modules nécessaires voir le [Dockerfile](https://github.com/FreshRSS/FreshRSS/blob/edge/Docker/Dockerfile-Alpine#L9-L11)* |                                |
| Base de données  | **PostgreSQL 10+** | SQLite, MariaDB 10.6+, MySQL 8.0+ |
| Navigateur       | **Firefox**        | Chrome, Opera, Safari, or Edge   |

## Choisir la bonne version de FreshRSS

FreshRSS possède deux canaux de distributions (ou branches) qui sortent à des fréquences plus ou moins rapides:

### Canal de publication continue

Si vous voulez une publication continue (*rolling release*) avec les dernières nouveautés et sécurité,
ou bien aider à tester ou développer la future version,
vous pouvez utiliser [la branche `edge`](https://github.com/FreshRSS/FreshRSS/tree/edge/).

### Canal de publication versionnée

Si vous préférez moins de mises à jour, vous pouvez utiliser [la branche `latest`](https://github.com/FreshRSS/FreshRSS/tree/latest/).
Celle-ci est plus stable mais au prix de moins de sécurité et de plus de bugs connus
car les corrections ne sont pas rétro-portées sur les anciennes versions.
De nouvelles versions sont publiées quelques fois par an.
Voir la [dernière version](https://github.com/FreshRSS/FreshRSS/releases/latest)
et la [liste des versions](https://github.com/FreshRSS/FreshRSS/releases).

## Installation sur Apache

```apache
<VirtualHost *:80>
	DocumentRoot /var/www/html/

	#Site par défaut...

	ErrorLog ${APACHE_LOG_DIR}/error.default.log
	CustomLog ${APACHE_LOG_DIR}/access.default.log vhost_combined
</VirtualHost>

<VirtualHost *:80>
	ServerName rss.example.net
	DocumentRoot /path/to/FreshRSS/p/

	<Directory /path/to/FreshRSS/p>
		AllowOverride AuthConfig FileInfo Indexes Limit
		Require all granted
	</Directory>

	ErrorLog ${APACHE_LOG_DIR}/freshrss_error.log
	CustomLog ${APACHE_LOG_DIR}/freshrss_access.log combined

	AllowEncodedSlashes On
</VirtualHost>

<IfModule mod_ssl.c>
	<VirtualHost *:443>
		ServerName rss.example.net
		DocumentRoot /path/to/FreshRSS/p/

		<Directory /path/to/FreshRSS/p>
			AllowOverride AuthConfig FileInfo Indexes Limit
			Require all granted
		</Directory>

		ErrorLog ${APACHE_LOG_DIR}/freshrss_error.log
		CustomLog ${APACHE_LOG_DIR}/freshrss_access.log combined

		<IfModule mod_http2.c>
			Protocols h2 http/1.1
		</IfModule>

		# Pour l’API
		AllowEncodedSlashes On

		SSLEngine on
		SSLCompression off
		SSLCertificateFile /path/to/server.crt
		SSLCertificateKeyFile /path/to/server.key
		# Additional SSL configuration, e.g. with LetsEncrypt
	</VirtualHost>
</IfModule>
```

## Installation sur Nginx

Voici un fichier de configuration pour nginx. Il couvre la configuration pour HTTP, HTTPS, et PHP.

*Vous pourrez trouver d’autres fichiers de configuration plus simples mais ces derniers ne seront peut-être pas compatibles avec l’API FreshRSS.*

```nginx
server {
	listen 80;
	listen 443 ssl;

	# configuration https
	ssl on;
	ssl_certificate /etc/nginx/server.crt;
	ssl_certificate_key /etc/nginx/server.key;

	# l’URL ou les URLs de votre serveur
	server_name rss.example.net;

	# le répertoire où se trouve le dossier p de FreshRSS
	root /srv/FreshRSS/p/;

	index index.php index.html index.htm;

	# les fichiers de log nginx
	access_log /var/log/nginx/rss.access.log;
	error_log /var/log/nginx/rss.error.log;

	# gestion des fichiers php
	# il est nécessaire d’utiliser cette expression régulière pour le bon fonctionnement de l’API
	location ~ ^.+?\.php(/.*)?$ {
		fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
		fastcgi_split_path_info ^(.+\.php)(/.*)$;
		# Par défaut la variable PATH_INFO n’est pas définie sous PHP-FPM
		# mais les APIs FreshRSS greader.php et misc.php en ont besoin. Si vous avez un “Bad Request”, vérifiez bien cette dernière !
		# REMARQUE : l’utilisation de la variable $path_info est requis. Pour plus de détails, voir :
		# https://trac.nginx.org/nginx/ticket/321
		set $path_info $fastcgi_path_info;
		fastcgi_param PATH_INFO $path_info;
		include fastcgi_params;
		fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
	}

	location / {
		try_files $uri $uri/ index.php;
	}
}
```

## Conseils de sécurité

> **TODO**
