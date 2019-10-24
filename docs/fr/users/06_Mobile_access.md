This page assumes you have completed the [server
setup](../admins/02_Installation.md).

# Enable the API in FreshRSS

1. Under the section “Authentication”, enable the option “Allow API access
   (required for mobile apps)”.
2. Under the section “Profile”, fill-in the field “API password (e.g., for mobile apps)”.
	* Every user must define an API password.
	* The reason for an API-specific password is that it may be used in less safe situations than the main password, and does not grant access to as many things.

The rest of this page is about the Google Reader compatible API.  See the
[page about the Fever compatible API](06_Fever_API.md) for another
possibility.


# Testing

3. Under the section “Profile”, click on the link like
   `https://rss.example.net/api/` next to the field “API password”.
4. Click on first link “Check full server configuration”:
	* If you get *PASS* then you are done, all is good: you may proceed to step 6.
	* If you get *Bad Request!* or *Not Found*, then your server probably does not accept slashes `/` that are escaped `%2F`. Proceed to step 5.
	* If you get any other error message, proceed to step 5.


# Fix server configuration

5. Click on the second link “Check partial server configuration (without `%2F` support)”:
	* If you get `PASS`, then the problem is indeed that your server does not accept slashes `/` that are escaped `%2F`.
		* With Apache, remember the directive [`AllowEncodedSlashes On`](http://httpd.apache.org/docs/trunk/mod/core.html#allowencodedslashes)
		* Or use a client that does not escape slashes (such as EasyRSS), in which case proceed to step 6.
	* If you get *Service Unavailable!*, then check from step 1 again.
	* With __Apache__:
		* If you get *FAIL getallheaders!*, the combination of your PHP version and your Web server does not provide access to [`getallheaders`](http://php.net/getallheaders)
			* Turn on Apache `mod_setenvif` (often enabled by default), or `mod_rewrite` with the following procedure:
				* Allow [`FileInfo` in `.htaccess`](http://httpd.apache.org/docs/trunk/mod/core.html#allowoverride): see the [server setup](../admins/02_Installation.md) again.
				* Enable [`mod_rewrite`](http://httpd.apache.org/docs/trunk/mod/mod_rewrite.html):
					* With Debian / Ubuntu: `sudo a2enmod rewrite`
	* With __nginx__:
		* If you get *Bad Request!*, check your server `PATH_INFO` configuration.
		* If you get *File not found!*, check your server `fastcgi_split_path_info`.
	* If you get *FAIL 64-bit or GMP extension!*, then your PHP version does not pass the requirement of being 64-bit and/or have PHP [GMP](http://php.net/gmp) extension.
		* The easiest is to add the GMP extension. On Debian / Ubuntu: `sudo apt install php-gmp`
	* Update and try again from step 3.


# Compatible clients

6. On the same FreshRSS API page, note the address given under “Your API address”, like `https://freshrss.example.net/api/greader.php`
	* You will type it in a client, together with your FreshRSS username, and the corresponding special API password.

7. Pick a client supporting a Google Reader-like API. Selection:
	* Android
		* [News+](https://play.google.com/store/apps/details?id=com.noinnion.android.newsplus) with [News+ Google Reader extension](https://play.google.com/store/apps/details?id=com.noinnion.android.newsplus.extension.google_reader) (Closed source)
		* [FeedMe 3.5.3+](https://play.google.com/store/apps/details?id=com.seazon.feedme) (Closed source)
		* [EasyRSS](https://github.com/Alkarex/EasyRSS) (Open source, [F-Droid](https://f-droid.org/packages/org.freshrss.easyrss/))
	* Linux
		* [FeedReader 2.0+](https://jangernert.github.io/FeedReader/) (Open source)
	* MacOS
		* [Vienna RSS](http://www.vienna-rss.com/) (Open source)
		* [Reeder](https://www.reederapp.com/) (Commercial)
	* iOS
		* [Reeder](https://www.reederapp.com/) (Commercial)
	* Firefox
		* [FreshRSS-Notify](https://addons.mozilla.org/firefox/addon/freshrss-notify-webextension/) (Open source)


# Google Reader compatible API

Examples of basic queries:

```sh
# Initial login, using API password (Email and Passwd can be given either as GET, or POST - better)

curl 'https://freshrss.example.net/api/greader.php/accounts/ClientLogin?Email=alice&Passwd=Abcdef123456'

SID=alice/8e6845e089457af25303abc6f53356eb60bdb5f8

Auth=alice/8e6845e089457af25303abc6f53356eb60bdb5f8



# Examples of read-only requests

curl -s -H "Authorization:GoogleLogin auth=alice/8e6845e089457af25303abc6f53356eb60bdb5f8" \

  'https://freshrss.example.net/api/greader.php/reader/api/0/subscription/list?output=json'



curl -s -H "Authorization:GoogleLogin auth=alice/8e6845e089457af25303abc6f53356eb60bdb5f8" \

  'https://freshrss.example.net/api/greader.php/reader/api/0/unread-count?output=json'



curl -s -H "Authorization:GoogleLogin auth=alice/8e6845e089457af25303abc6f53356eb60bdb5f8" \

  'https://freshrss.example.net/api/greader.php/reader/api/0/tag/list?output=json'



# Retrieve a token for requests making modifications

curl -H "Authorization:GoogleLogin auth=alice/8e6845e089457af25303abc6f53356eb60bdb5f8" \

  'https://freshrss.example.net/api/greader.php/reader/api/0/token'

8e6845e089457af25303abc6f53356eb60bdb5f8ZZZZZZZZZZZZZZZZZ



# Get articles, piped to jq for easier JSON reading

curl -s -H "Authorization:GoogleLogin auth=alice/8e6845e089457af25303abc6f53356eb60bdb5f8" \

  'https://freshrss.example.net/api/greader.php/reader/api/0/stream/contents/reading-list' | jq .

```

