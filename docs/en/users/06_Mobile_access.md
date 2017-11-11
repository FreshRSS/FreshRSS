This page assumes you have completed the [server setup](01_Installation.md).

# Enable the API in FreshRSS

1. Under the section “Authentication”, enable the option “Allow API access (required for mobile apps)”.
2. Under the section “Profile”, fill-in the field “API password (e.g., for mobile apps)”.
	a. Every user must define an API password.
	b. The reason for an API-specific password is that it may be used in less safe situations than the main password, and does not grant access to as many things.


# Testing

3. Under the section “Profile”, click on the link like `https://rss.example.net/api/` next to the field “API password”.
4. Click on first link “Check full server configuration”:
	* If you see *PASS* then you are done, all is good: you may proceed to step 6.
	* If you see *Bad Request!* or *Not Found*, then your server probably does not accept slashes `/` that are escaped `%2F`. Proceed to step 5.
	* If you see any other error message, proceed to step 5.


# Fix server configuration

5. Click on the second link “Check partial server configuration (without `%2F` support)”:
	* If you see `PASS`, then the problem is indeed that your server does not accept slashes `/` that are escaped `%2F`.
		* With Apache, remember the directive [`AllowEncodedSlashes On`](http://httpd.apache.org/docs/trunk/mod/core.html#allowencodedslashes)
		* Or use a client that does not escape slashes (such as EasyRSS), in which case proceed to step 6.
	* If you see *Service Unavailable!*, then check from step 1 again.
	* With _Apache_:
		* If you see *FAIL getallheaders!*, the combination of your PHP version and your Web server does not provide access to [`getallheaders`](http://php.net/getallheaders)
			* Update to PHP 5.4+, or use PHP as module instead of CGI. Otherwise turn on Apache `mod_rewrite`:
				* Allow [`FileInfo` in `.htaccess`](http://httpd.apache.org/docs/trunk/mod/core.html#allowoverride): see the [server setup] again.
				* Enable [`mod_rewrite`](http://httpd.apache.org/docs/trunk/mod/mod_rewrite.html):
					* With Debian / Ubuntu: `sudo a2enmod rewrite`
	* With _nginx_:
		* If you see *Bad Request!*, check your server `PATH_INFO` configuration.
		* If you see *File not found!*, check your server `fastcgi_split_path_info`.
	* If you see *FAIL 64-bit or GMP extension!*, then your PHP version does not pass the requirement of being 64-bit and/or have PHP [GMP](http://php.net/gmp) extension.
		* The easiest is to add the GMP extension. On Debian / Ubuntu: `sudo apt install php-gmp`
	* Update and try again from step 3.


# Compatible clients

6. On the same FreshRSS API page, note the adress given under “Your API address”, like `https://freshrss.example.net/api/greader.php`
	* You will type it in a client, together with your FreshRSS username, and the corresponding special API password.

7. Pick a client supporting a Google Reader-like API. Selection:
	* Android
		* [News+](https://play.google.com/store/apps/details?id=com.noinnion.android.newsplus) with [News+ Google Reader extension](https://play.google.com/store/apps/details?id=com.noinnion.android.newsplus.extension.google_reader) (Closed source)
		* [EasyRSS](https://github.com/Alkarex/EasyRSS) (Open source, [F-Droid](https://f-droid.org/packages/org.freshrss.easyrss/))
	* Linux
		* [FeedReader 2.0+](https://jangernert.github.io/FeedReader/) (Open source)
