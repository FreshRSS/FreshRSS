This page assumes you have completed the [server setup](../admins/03_Installation.md).

# Mobile Access

You can access FreshRSS on mobile devices via browser and via mobile apps.


## Access via Browser

The FreshRSS's user interface is optimized for both small and large screens. The content will fit nicely on small mobile device screens as well.


## Access via Mobile App

FreshRSS supports access from mobile / native apps for Linux, Android, iOS, Windows and macOS, via two distinct APIs: Google Reader API (best), and Fever API (limited features and less efficient).

A list of known apps is available on the [FreshRSS GitHub page](https://github.com/FreshRSS/FreshRSS#apis--native-apps).


### Enable the API in FreshRSS

1. Under the section “Authentication”, enable the option “Allow API access (required for mobile apps)”.
2. Under the section “Profile”, fill-in the field “API password (e.g., for mobile apps)”.
	* Every user must define an API password.
	* The reason for an API-specific password is that it may be used in less safe situations than the main password, and does not grant access to as many things.

See the [page about the Google Reader compatible API](../developers/06_GoogleReader_API.md) for more details.
See the [page about the Fever compatible API](../developers/06_Fever_API.md) for more details.


### Testing

1. Under the section “Profile”, click on the link like `https://rss.example.net/api/` next to the field “API password”.
2. Click on first link “Check full server configuration”:
	* If you get *PASS* then you are done, all is good: you may proceed to step 6.
	* If you get *Bad Request!* or *Not Found*, then your server probably does not accept slashes `/` that are escaped `%2F`. Proceed to step 5.
	* If you get any other error message, proceed to step 5.


### Fix server configuration

* Click on the second link “Check partial server configuration (without `%2F` support)”:
	* If you get `PASS`, then the problem is indeed that your server does not accept slashes `/` that are escaped `%2F`.
		* With Apache, remember the directive [`AllowEncodedSlashes On`](http://httpd.apache.org/docs/trunk/mod/core.html#allowencodedslashes)
		* Or use a client that does not escape slashes (such as EasyRSS), in which case proceed to step 6.
	* If you get *Service Unavailable!*, then check from step 1 again.
	* With __Apache__:
		* If you get *FAIL getallheaders!*, the combination of your PHP version and your Web server does not provide access to [`getallheaders`](http://php.net/getallheaders)
			* Turn on Apache `mod_setenvif` (often enabled by default), or `mod_rewrite` with the following procedure:
				* Allow [`FileInfo` in `.htaccess`](http://httpd.apache.org/docs/trunk/mod/core.html#allowoverride): see the [server setup](../admins/03_Installation.md) again.
				* Enable [`mod_rewrite`](http://httpd.apache.org/docs/trunk/mod/mod_rewrite.html):
					* With Debian / Ubuntu: `sudo a2enmod rewrite`
	* With __nginx__:
		* If you get *Bad Request!*, check your server `PATH_INFO` configuration.
		* If you get *File not found!*, check your server `fastcgi_split_path_info`.
	* If you get *FAIL 64-bit or GMP extension!*, then your PHP version does not pass the requirement of being 64-bit and/or have PHP [GMP](http://php.net/gmp) extension.
		* The easiest is to add the GMP extension. On Debian / Ubuntu: `sudo apt install php-gmp`
	* Update and try again from step 3.
