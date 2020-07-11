# Apache/Nginx Configuration Files

## Apache configuration
This is an example Apache virtual hosts configuration file. It covers HTTP and HTTPS configuration.

```
<VirtualHost *:80>
	DocumentRoot /var/www/html/

	#Default site...

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

		# For the API
		AllowEncodedSlashes On

		SSLEngine on
		SSLCompression off
		SSLCertificateFile /path/to/server.crt
		SSLCertificateKeyFile /path/to/server.key
		# Additional SSL configuration, e.g. with LetsEncrypt
	</VirtualHost>
</IfModule>
```

## Nginx configuration

This is an example nginx configuration file. It covers HTTP, HTTPS, and php-fpm configuration.

You can find simpler config file but they may be incompatible with FreshRSS API.
```
server {
	listen 80;
	listen 443 ssl;

	# HTTPS configuration
	ssl on;
	ssl_certificate /etc/nginx/server.crt;
	ssl_certificate_key /etc/nginx/server.key;

	# your server’s URL(s)
	server_name rss.example.net;

	# the folder p of your FreshRSS installation
	root /srv/FreshRSS/p/;

	index index.php index.html index.htm;

	# nginx log files
	access_log /var/log/nginx/rss.access.log;
	error_log /var/log/nginx/rss.error.log;

	# php files handling
	# this regex is mandatory because of the API
	location ~ ^.+?\.php(/.*)?$ {
		fastcgi_pass unix:/var/run/php/php7.0-fpm.sock;
		fastcgi_split_path_info ^(.+\.php)(/.*)$;
		# By default, the variable PATH_INFO is not set under PHP-FPM
		# But FreshRSS API greader.php need it. If you have a “Bad Request” error, double check this var!
		# NOTE: the separate $path_info variable is required. For more details, see:
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
