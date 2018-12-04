[![Build Status][travis-badge]][travis-link]

* Read this document on [github.com/FreshRSS/FreshRSS/](https://github.com/FreshRSS/FreshRSS/blob/master/README.md) to get the correct links and pictures.
* [Version française](README.fr.md)

# FreshRSS
FreshRSS is a self-hosted RSS feed aggregator like [Leed](http://leed.idleman.fr/) or [Kriss Feed](https://tontof.net/kriss/feed/).

It is lightweight, easy to work with, powerful, and customizable.

It is a multi-user application with an anonymous reading mode.
It supports custom tags, and [PubSubHubbub](https://github.com/pubsubhubbub/PubSubHubbub) for instant notifications from compatible Web sites.
There is an API for (mobile) clients, and a [Command-Line Interface](cli/README.md).
Finally, it supports [extensions](#extensions) for further tuning.

Feature requests, bug reports, and other contributions are welcome. The best way to contribute is to [open an issue on GitHub](https://github.com/FreshRSS/FreshRSS/issues). We are a friendly community.


* Official website: https://freshrss.org
* Demo: https://demo.freshrss.org/
* License: [GNU AGPL 3](https://www.gnu.org/licenses/agpl-3.0.html)

![FreshRSS logo](docs/img/FreshRSS-logo.png)

# Releases
See the [list of releases](../../releases).

## About branches
* Use [the master branch](https://github.com/FreshRSS/FreshRSS/tree/master/) if you need a stable version.
* For those willing to help testing or developing the latest features, [the dev branch](https://github.com/FreshRSS/FreshRSS/tree/dev) is waiting for you!

# Disclaimer
FreshRSS comes with absolutely no warranty.

# Requirements
* Light server running Linux or Windows
	* It even works on Raspberry Pi 1 with response time under a second (tested with 150 feeds, 22k articles)
* A web server: Apache2 (recommended), nginx, lighttpd (not tested on others)
* PHP 5.3.8+ (PHP 5.4+ recommended, and PHP 5.5+ for performance, or PHP 7 for even higher performance)
	* Required extensions: [cURL](https://secure.php.net/curl), [DOM](https://secure.php.net/dom), [XML](https://secure.php.net/xml), [session](https://secure.php.net/session), [ctype](https://secure.php.net/ctype), and [PDO_MySQL](https://secure.php.net/pdo-mysql) or [PDO_SQLite](https://secure.php.net/pdo-sqlite) or [PDO_PGSQL](https://secure.php.net/pdo-pgsql)
	* Recommended extensions: [JSON](https://secure.php.net/json), [GMP](https://secure.php.net/gmp) (for API access on 32-bit platforms), [IDN](https://secure.php.net/intl.idn) (for Internationalized Domain Names), [mbstring](https://secure.php.net/mbstring) (for Unicode strings), [iconv](https://secure.php.net/iconv) (for charset conversion), [ZIP](https://secure.php.net/zip) (for import/export), [zlib](https://secure.php.net/zlib) (for compressed feeds)
* MySQL 5.5.3+ (recommended), or SQLite 3.7.4+, or PostgreSQL 9.2+
* A recent browser like Firefox / IceCat, Internet Explorer 11 / Edge, Chromium / Chrome, Opera, or Safari.
	* Works on mobile
	* All features may not be available on mobile or Internet Explorer 11 / Edge

![FreshRSS screenshot](docs/img/FreshRSS-screenshot.png)

# [Documentation](https://freshrss.github.io/FreshRSS/en/)
* [User documentation](https://freshrss.github.io/FreshRSS/en/users/02_First_steps.html), where you can discover all the possibilities offered by FreshRSS
* [Administrator documentation](https://freshrss.github.io/FreshRSS/en/admins/01_Index.html) for detailed installation and maintenance related tasks
* [Developer documentation](https://freshrss.github.io/FreshRSS/en/developers/01_First_steps.html) to guide you in the source code of FreshRSS and to help you if you want to contribute
* [Contributor guidelines](https://freshrss.github.io/FreshRSS/en/contributing.md) for those who want to help improve FreshRSS

# [Installation](https://freshrss.github.io/FreshRSS/en/admins/02_Installation.html)
1. Get FreshRSS with git or [by downloading the archive](https://github.com/FreshRSS/FreshRSS/archive/master.zip)
2. Put the application somewhere on your server (expose only the `./p/` folder to the web)
3. Add write access to the `./data/` folder for the webserver user
4. Access FreshRSS with your browser and follow the installation process
	* or use the [Command-Line Interface](cli/README.md)
5. Everything should be working :) If you encounter any problems, feel free to [contact us](https://github.com/FreshRSS/FreshRSS/issues).
6. Advanced configuration settings can be found in [config.default.php](config.default.php) and modified in `data/config.php`.
7. When using Apache, enable [`AllowEncodedSlashes`](https://httpd.apache.org/docs/trunk/mod/core.html#allowencodedslashes) for better compatibility with mobile clients.

More detailed information about installation and server configuration can be found in [our documentation](https://freshrss.github.io/FreshRSS/en/admins/02_Installation.html).

## Automated install 
* [![Docker](https://www.docker.com/sites/default/files/horizontal.png)](./Docker/)
* [![YunoHost](https://install-app.yunohost.org/install-with-yunohost.png)](https://install-app.yunohost.org/?app=freshrss)
* [![Cloudron](https://cloudron.io/img/button.svg)](https://cloudron.io/button.html?app=org.freshrss.cloudronapp)

# Advice
* For better security, expose only the `./p/` folder to the Web.
	* Be aware that the `./data/` folder contains all personal data, so it is a bad idea to expose it.
* The `./constants.php` file defines access to the application folder. If you want to customize your installation, look here first.
* If you encounter any problem, logs are accessible from the interface or manually in `./data/users/*/log*.txt` files.
	* The special folder `./data/users/_/` contains the part of the logs that are shared by all users.
* The date and time in the right-hand column is the date declared by the feed, not the time at which the article was received by FreshRSS, and it is not used for sorting.
	* When importing a new feed, all of its articles will appear at the top of the feed list regardless of their declared date.


# Extensions
FreshRSS supports further customizations by adding extensions on top of its core functionality.
See the [repository dedicated to those extensions](https://github.com/FreshRSS/Extensions).


# APIs & native apps

FreshRSS supports access from native apps for Linux, Android, iOS, and OS X, via two distinct APIs.

## Google Reader-like API

There is more information available about our Google Reader compatible API on the page [mobile access](https://freshrss.github.io/FreshRSS/en/users/06_Mobile_access.html).

Supported clients are:

* Android
	* [News+](https://play.google.com/store/apps/details?id=com.noinnion.android.newsplus) with [News+ Google Reader extension](https://play.google.com/store/apps/details?id=com.noinnion.android.newsplus.extension.google_reader) (Closed source)
	* [FeedMe 3.5.3+](https://play.google.com/store/apps/details?id=com.seazon.feedme) (Closed source)
	* [EasyRSS](https://github.com/Alkarex/EasyRSS) (Open source, [F-Droid](https://f-droid.org/packages/org.freshrss.easyrss/))
* GNU/Linux
	* [FeedReader 2.0+](https://jangernert.github.io/FeedReader/) (Open source)

## Fever API

See our [Fever API documentation](https://freshrss.github.io/FreshRSS/en/users/06_Fever_API.html) page.

Supported clients are:

* iOS
	* [Fiery Feeds](https://itunes.apple.com/app/fiery-feeds-rss-reader/id1158763303) (Closed source)
	* [Unread](https://itunes.apple.com/app/unread-rss-reader/id1252376153) (Closed source)
	* [Reeder-3](https://itunes.apple.com/app/reeder-3/id697846300) (Closed source)
* MacOS
	* [Readkit](https://itunes.apple.com/app/readkit/id588726889) (Closed source)


# Included libraries
* [SimplePie](https://simplepie.org/)
* [MINZ](https://github.com/marienfressinaud/MINZ)
* [php-http-304](https://alexandre.alapetite.fr/doc-alex/php-http-304/)
* [jQuery](https://jquery.com/)
* [lib_opml](https://github.com/marienfressinaud/lib_opml)
* [jQuery Plugin Sticky-Kit](https://leafo.net/sticky-kit/)
* [keyboard_shortcuts](http://www.openjs.com/scripts/events/keyboard_shortcuts/)
* [flotr2](http://www.humblesoftware.com/flotr2)

## Only for some options
* [bcrypt.js](https://github.com/dcodeIO/bcrypt.js)
* [phpQuery](https://github.com/phpquery/phpquery)

## If native functions are not available
* [Services_JSON](https://pear.php.net/pepr/pepr-proposal-show.php?id=198)
* [password_compat](https://github.com/ircmaxell/password_compat)

[travis-badge]:https://travis-ci.org/FreshRSS/FreshRSS.svg?branch=master
[travis-link]:https://travis-ci.org/FreshRSS/FreshRSS
