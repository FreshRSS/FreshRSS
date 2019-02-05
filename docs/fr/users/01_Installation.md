# Les pré-requis sur le serveur

FreshRSS est un logiciel développé en PHP reposant sur le modèle client - serveur. C’est-à-dire qu’il vous faudra un serveur web pour en profiter. Ensuite, FreshRSS ne demande pas une configuration très fournie et peut donc, en théorie, tourner sur la plupart des serveurs mutualisés.

Il est toutefois de votre responsabilité de vérifier que votre hébergement permettra de faire tourner FreshRSS avant de nous taper dessus. Dans le cas où les informations listées ci-dessous ne seraient pas à jour, vous pourrez.

 | Logiciel         | Recommandé                                                                                                     | Fonctionne aussi avec          |
 | --------         | -----------                                                                                                    | ---------------------          |
 | Serveur web      | **Apache 2**                                                                                                   | Nginx                          |
 | PHP              | **PHP 5.5+**                                                                                                   | PHP 5.3.8+                     |
 | Modules PHP      | Requis : libxml, cURL, PDO_MySQL, PCRE et ctype \\ Requis (32 bits seulement) : GMP \\ Recommandé : JSON, Zlib, mbstring et iconv, ZipArchive |                                |
 | Base de données  | **MySQL 5.5.3+**                                                                                               | SQLite 3.7.4+                  |
 | Navigateur       | **Firefox**                                                                                                    | Chrome, Opera, Safari, or IE 11+ |

## Note importante

FreshRSS **PEUT** fonctionner sur la version de PHP 5.3.8+. En effet, nous utilisons des fonctions spécifiques pour la connexion par formulaire et notamment la [bibliothèque ''password_compat''](https://github.com/ircmaxell/password_compat#requirements).

# Choisir la bonne version de FreshRSS

FreshRSS possède trois versions différentes (nous parlons de branches) qui sortent à des fréquences plus ou moins rapides. Aussi prenez le temps de comprendre à quoi correspond chacune de ces versions.

## La version stable

[Téléchargement](https://github.com/FreshRSS/FreshRSS/archive/master.zip)

Cette version sort lorsqu’on considère qu’on a répondu à nos objectifs en terme de nouvelles fonctionnalités. Deux versions peuvent ainsi sortir de façon très rapprochée si les développeurs travaillent bien. En pratique, comme nous nous fixons de nombreux objectifs et que nous travaillons sur notre temps libre, les versions sont souvent assez espacées (plusieurs mois). Son avantage est que le code est particulièrement stable et vous ne devriez pas faire face à de méchants bugs.

## La version de développement

[Téléchargement](https://github.com/FreshRSS/FreshRSS/archive/dev.zip)

Comme son nom l’indique, il s’agit de la version sur laquelle les développeurs travaillent. **Elle est donc instable !** Si vous souhaitez recevoir les améliorations au jour le jour, vous pouvez l’utiliser, mais attention à bien suivre les évolutions sur Github (via [le flux RSS de la branche](https://github.com/FreshRSS/FreshRSS/commits/dev.atom) par exemple). On raconte que les développeurs principaux l’utilisent quotidiennement sans avoir de soucis. Sans doute savent-ils ce qu’ils font…

# Installation sur Apache

```
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

# Installation sur Nginx

Voici un fichier de configuration pour nginx. Il couvre la configuration pour HTTP, HTTPS, et PHP.

_Vous pourrez trouver d’autres fichiers de configuration plus simples mais ces derniers ne seront peut-être pas compatibles avec l’API FreshRSS._

```
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
		fastcgi_pass unix:/var/run/php/php7.0-fpm.sock;
		fastcgi_split_path_info ^(.+\.php)(/.*)$;
		# Par défaut la variable PATH_INFO n’est pas définie sous PHP-FPM
		# or l’API FreshRSS greader.php en a besoin. Si vous avez un “Bad Request”, vérifiez bien cette dernière !
		fastcgi_param PATH_INFO $fastcgi_path_info;
		include fastcgi_params;
		fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
	}

	location / {
		try_files $uri $uri/ index.php;
	}
}
```

Pour un tutoriel pas à pas, vous pouvez suivre [cet article dédié](http://www.pihomeserver.fr/2013/05/08/raspberry-pi-home-server-installer-un-agregateur-de-flux-rss-pour-remplacer-google-reader/).

# Conseils de sécurité

**TODO**
