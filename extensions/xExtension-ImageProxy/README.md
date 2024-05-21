# Image Proxy extension

This FreshRSS extension allows you to get rid of insecure content warnings or disappearing images when you use an encrypted connection to FreshRSS. An encrypted connection can be [very easily enabled](http://fransdejonge.com/2016/05/lets-encrypt-on-debianjessie/) thanks to the [Let's Encrypt](https://letsencrypt.org/) initiative.

To use it, upload this entire directory to the FreshRSS `./extensions` directory on your server and enable it on the extension panel in FreshRSS.

## Changelog

* 0.7.3 Turkish language support added

## Configuration settings

* `proxy_url` (default: `https://images.example.com/?url=`): the URL that is prependended to the original image URL

* `scheme_http` (default: `1`): whether to proxy HTTP resources

* `scheme_https` (default: `0`): whether to proxy HTTPS resources

* `scheme_default` (default: `auto`): which scheme to use for resources that do not include one; if set to `-`, those will not be proxied;
  if set along `scheme_include`, the scheme included in the URL will either be `auto`-matically derived from your current connection or the one explicitly specified

* `scheme_include` (default: `0`): whether to include the scheme - `http*://` - in the proxied URL

* `url_encode` (default: `1`): whether to URL-encode (RFC 3986) the proxied URL

## Proxy Settings

By default this extension will use the [wsrv.nl](https://wsrv.nl) image caching and resizing proxy, but instead you can supply your own proxy URL in the settings. An example URL would look like ``https://images.example.com/?url=``.

By ticking the `scheme_https` checkbox, you can also force the use of the proxy, even for images coming through an encrypted channel. This makes the server that hosts your FreshRSS instance the only point of entry for images, preventing your client from connecting directly to the RSS sources to recover them (which could be a privacy concern in extreme cases).

The source code for the wsrv.nl proxy can be found at [github.com/weserv/images](https://github.com/weserv/images), but of course other methods are available. For example, in Apache you could [use `mod_rewrite` to set up a simple proxy](#apache-configuration) and similar methods are available in nginx and lighttpd. Alternatively you could use a simple PHP script, [along these lines](https://github.com/Alexxz/Simple-php-proxy-script). Keep in mind that too simple a proxy could introduce security risks, which is why the default proxy processes the images.

### Apache configuration

In order to use Apache [mod_rewrite](https://httpd.apache.org/docs/current/mod/mod_rewrite.html), you will need to set the following settings:

* `proxy_url` = **<https://www.example.org/proxy/>**

* `scheme_include` = **1**

* `url_encode` = **0**

Along the following Apache configuration for the `www.example.org` virtual host:

```apache
# WARNING: Multiple '/' in %{REQUEST_URI} are internally trimmed to a single one!
RewriteCond %{REQUEST_URI} ^/proxy/https:/+(.*)$
RewriteRule ^ https://%1 [QSA,P,L]
RewriteCond %{REQUEST_URI} ^/proxy/http:/+(.*)$
RewriteRule ^ http://%1 [QSA,P,L]
# CRITICAL: Do NOT leave your proxy open to everyone!!!
<Location "/proxy/">
  # Local network
  Require ip 192.168.0.0/16 172.16.0.0/12 10.0.0.0/8
  # Users
  AuthType Basic
  AuthName "Proxy - Authorized Users ONLY"
  AuthBasicProvider file
  AuthUserFile /etc/apache2/htpasswd/users
  Require valid-user
  # Local network OR authenticated users
  Satisfy any
</Location>
# CRITICAL: Do NOT allow access to local resources!!!
#  - (any) IPv4
#  - (any) IPv6
#  - localhost
#  - local.domain (e.g. example.org)
<LocationMatch "^/proxy/https?:/+([0-9]{1,3}(\.[0-9]{1,3}){3}|([0-9a-fA-F]{0,4}:?)?(:[0-9a-fA-F]{1,4}:){0,6}([.:][0-9a-fA-F]{1,4}){1,7}|[^/]*(localhost|local\.domain|example\.org))(/|$)">
  Require all denied
</LocationMatch>
```

### nginx configuration

In order to use nginx's [proxy
module](https://nginx.org/en/docs/http/ngx_http_proxy_module.html), you will
need to set the following settings:

* `proxy_url` = **<https://www.example.org/proxy?key=changeme&url=>**
* `scheme_include` = **1**
* `url_encode` = **0**

Add this to your nginx config:

``` nginx
# Use 1 GiB cache with a 1 MiB memory zone (enough for ~8,000 keys).
# Delete data that has not been accessed for 12 hours.
proxy_cache_path /var/cache/nginx/freshrss levels=1:2 keys_zone=freshrss:1m
                 max_size=1g inactive=12h use_temp_path=off;

server {

…

    location /proxy {
        if ($arg_key = "changeme") {
            proxy_pass $arg_url;
        }
        # Handle redirects coming from the target server.
        proxy_redirect ~^(.*)$ https://www.example.org/proxy?key=$arg_key&url=$1;
        proxy_ssl_server_name on;
        proxy_cache freshrss;
        # Cache positive answers for up to 2 days.
        proxy_cache_valid 200 301 302 307 308 2d;
    }

…

}
```

If you do not need caching, omit all lines starting with `proxy_cache`. If you
would like to limit access based on IP addresses instead, take a look at
[ngx_http_access_module](http://nginx.org/en/docs/http/ngx_http_access_module.html).
