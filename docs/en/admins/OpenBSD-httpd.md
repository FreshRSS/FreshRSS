# OpenBSD httpd configuration

OpenBSD `httpd(8)` does not use `.htaccess` files. The following example
serves the public `p/` directory and passes the Google Reader API path to
PHP-FPM with `PATH_INFO` preserved:

```httpd
server "rss.example.net" {
	listen on * tls port 443
	root "/var/www/htdocs/FreshRSS/p"

	tls certificate "/etc/ssl/rss.example.net.fullchain.pem"
	tls key "/etc/ssl/private/rss.example.net.key"

	location match "^/api/greader\\.php(/.*)?$" {
		fastcgi socket "/run/php-fpm.sock"
		fastcgi param PATH_INFO "/api/greader.php"
	}

	location match "^/(.*\\.php)(/.*)?$" {
		fastcgi socket "/run/php-fpm.sock"
		fastcgi param SCRIPT_FILENAME "/var/www/htdocs/FreshRSS/p/$1"
		fastcgi param PATH_INFO "$2"
	}
}
```

Adjust the document root, PHP-FPM socket, and certificate paths for the local
installation. Set FreshRSS `base_url` to the public HTTPS URL, then verify the
API endpoint at `/api/greader.php`.

The `PATH_INFO` parameters are important: FreshRSS uses the path after
`greader.php` to route Google Reader API requests.

## HTTP caching

Unlike the bundled Apache configuration, OpenBSD `httpd` does not read the
project’s [`.htaccess` file](https://github.com/FreshRSS/FreshRSS/blob/edge/p/.htaccess).
Confirm the HTTP cache policy of the server or reverse
proxy used in front of FreshRSS: static assets such as CSS,
JavaScript, fonts, and images should be cached, but do not cache PHP pages or API
responses.
