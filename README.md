[![Liberapay donations](https://img.shields.io/liberapay/receives/FreshRSS.svg?logo=liberapay)](https://liberapay.com/FreshRSS/donate)

* Read this document on [github.com/FreshRSS/FreshRSS/](https://github.com/FreshRSS/FreshRSS/blob/edge/README.md) to get the correct links and pictures.
* [Version française](README.fr.md)

# FreshRSS

FreshRSS is a self-hosted RSS feed aggregator like [Leed](https://github.com/LeedRSS/Leed) or [Kriss Feed](https://tontof.net/kriss/feed/).

It is lightweight, easy to work with, powerful, and customizable.

It is a multi-user application with an anonymous reading mode. It supports custom tags.
There is an API for (mobile) clients, and a [Command-Line Interface](cli/README.md).

Thanks to the [WebSub](https://www.w3.org/TR/websub/) standard (formerly [PubSubHubbub](https://github.com/pubsubhubbub/PubSubHubbub)),
FreshRSS is able to receive instant push notifications from compatible sources, such as [Mastodon](https://joinmastodon.org), [Friendica](https://friendi.ca), [WordPress](https://wordpress.org/plugins/pubsubhubbub/), Blogger, FeedBurner, etc.

Finally, it supports [extensions](#extensions) for further tuning.

Feature requests, bug reports, and other contributions are welcome. The best way to contribute is to [open an issue on GitHub](https://github.com/FreshRSS/FreshRSS/issues).
We are a friendly community.

* Official website: <https://freshrss.org>
* Demo: <https://demo.freshrss.org/>
* License: [GNU AGPL 3](https://www.gnu.org/licenses/agpl-3.0.html)

![FreshRSS logo](docs/img/FreshRSS-logo.png)

# Disclaimer

FreshRSS comes with absolutely no warranty.

![FreshRSS screenshot](docs/img/FreshRSS-screenshot.png)

# [Documentation](https://freshrss.github.io/FreshRSS/en/)

* [User documentation](https://freshrss.github.io/FreshRSS/en/users/02_First_steps.html), where you can discover all the possibilities offered by FreshRSS
* [Administrator documentation](https://freshrss.github.io/FreshRSS/en/admins/01_Index.html) for detailed installation and maintenance related tasks
* [Developer documentation](https://freshrss.github.io/FreshRSS/en/developers/01_Index.html) to guide you in the source code of FreshRSS and to help you if you want to contribute
* [Contributor guidelines](https://freshrss.github.io/FreshRSS/en/contributing.html) for those who want to help improve FreshRSS

# Requirements

* A recent browser like Firefox / IceCat, Edge, Chromium / Chrome, Opera, Safari.
	* Works on mobile (except a few features)
* Light server running Linux or Windows
	* It even works on Raspberry Pi 1 with response time under a second (tested with 150 feeds, 22k articles)
* A web server: Apache2 (recommended), nginx, lighttpd (not tested on others)
* PHP 7.0+
	* Required extensions: [cURL](https://www.php.net/curl), [DOM](https://www.php.net/dom), [JSON](https://www.php.net/json), [XML](https://www.php.net/xml), [session](https://www.php.net/session), [ctype](https://www.php.net/ctype), and [PDO_MySQL](https://www.php.net/pdo-mysql) or [PDO_SQLite](https://www.php.net/pdo-sqlite) or [PDO_PGSQL](https://www.php.net/pdo-pgsql)
	* Recommended extensions: [GMP](https://www.php.net/gmp) (for API access on 32-bit platforms), [IDN](https://www.php.net/intl.idn) (for Internationalized Domain Names), [mbstring](https://www.php.net/mbstring) (for Unicode strings), [iconv](https://www.php.net/iconv) (for charset conversion), [ZIP](https://www.php.net/zip) (for import/export), [zlib](https://www.php.net/zlib) (for compressed feeds)
* MySQL 5.5.3+ or MariaDB equivalent, or SQLite 3.7.4+, or PostgreSQL 9.5+


# Releases

The latest stable release can be found [here](https://github.com/FreshRSS/FreshRSS/releases/latest). New versions are released every two to three months.

If you want a rolling release with the newest features, or want to help testing or developing the next stable version, you can use [the `edge` branch](https://github.com/FreshRSS/FreshRSS/tree/edge/).


# [Installation](https://freshrss.github.io/FreshRSS/en/admins/03_Installation.html)

## Automated install

* [![Docker](https://www.docker.com/sites/default/files/horizontal.png)](./Docker/)
* [![YunoHost](https://install-app.yunohost.org/install-with-yunohost.png)](https://install-app.yunohost.org/?app=freshrss)
* [![Cloudron](https://cloudron.io/img/button.svg)](https://cloudron.io/button.html?app=org.freshrss.cloudronapp)

## Manual install

1. Get FreshRSS with git or [by downloading the archive](https://github.com/FreshRSS/FreshRSS/archive/latest.zip)
2. Put the application somewhere on your server (expose only the `./p/` folder to the Web)
3. Add write access to the `./data/` folder for the webserver user
4. Access FreshRSS with your browser and follow the installation process
	* or use the [Command-Line Interface](cli/README.md)
5. Everything should be working :) If you encounter any problems, feel free to [contact us](https://github.com/FreshRSS/FreshRSS/issues).
6. Advanced configuration settings can be found in [config.default.php](config.default.php) and modified in `data/config.php`.
7. When using Apache, enable [`AllowEncodedSlashes`](https://httpd.apache.org/docs/trunk/mod/core.html#allowencodedslashes) for better compatibility with mobile clients.

More detailed information about installation and server configuration can be found in [our documentation](https://freshrss.github.io/FreshRSS/en/admins/03_Installation.html).

## Advice

* For better security, expose only the `./p/` folder to the Web.
	* Be aware that the `./data/` folder contains all personal data, so it is a bad idea to expose it.
* The `./constants.php` file defines access to the application folder. If you want to customize your installation, look here first.
* If you encounter any problem, logs are accessible from the interface or manually in `./data/users/*/log*.txt` files.
	* The special folder `./data/users/_/` contains the part of the logs that are shared by all users.


# FAQ

* The date and time in the right-hand column is the date declared by the feed, not the time at which the article was received by FreshRSS, and it is not used for sorting.
	* In particular, when importing a new feed, all of its articles will appear at the top of the feed list regardless of their declared date.


# Extensions

FreshRSS supports further customizations by adding extensions on top of its core functionality.
See the [repository dedicated to those extensions](https://github.com/FreshRSS/Extensions).


# APIs & native apps

FreshRSS supports access from mobile / native apps for Linux, Android, iOS, Windows and MacOS, via two distinct APIs:
[Google Reader API](https://freshrss.github.io/FreshRSS/en/users/06_Mobile_access.html) (best),
and [Fever API](https://freshrss.github.io/FreshRSS/en/users/06_Fever_API.html) (limited features and less efficient).

| App                                                                                   | Platform    | Free Software                                                 | Maintained & Developed | API              | Works offline | Fast sync | Fetch more in individual views | Fetch read articles | Favourites | Labels | Podcasts | Manage feeds |
|:--------------------------------------------------------------------------------------|:-----------:|:-------------------------------------------------------------:|:----------------------:|:----------------:|:-------------:|:---------:|:------------------------------:|:-------------------:|:----------:|:------:|:--------:|:------------:|
| [News+](https://play.google.com/store/apps/details?id=com.noinnion.android.newsplus) with [Google Reader extension](https://github.com/noinnion/newsplus/blob/master/apk/GoogleReaderCloneExtension_101.apk) | Android | [Partially](https://github.com/noinnion/newsplus/blob/master/extensions/GoogleReaderCloneExtension/src/com/noinnion/android/newsplus/extension/google_reader/) | 2015       | GReader | ✔️             | ⭐⭐⭐       | ✔️                    | ✔️                 | ✔️         | ✔️     | ✔️       | ✔️           |
| [FeedMe](https://play.google.com/store/apps/details?id=com.seazon.feedme)*            | Android     | ➖                                                            | ✔️✔️                   | GReader          | ✔️            | ⭐⭐        | ➖                             | ➖                  | ✔️         | ✓     | ✔️       | ✔️           |
| [RSS Guard](https://github.com/martinrotter/rssguard) | Windows, GNU/Linux, MacOS, OS/2 | ✔️ | ✔️✔️ | GReader | ✔️ | ⭐ | ➖ | ✔️ | ✔️ | ✔️ | ✔️ | ➖ |
| [EasyRSS](https://github.com/Alkarex/EasyRSS)                                         | Android     | [✔️](https://github.com/Alkarex/EasyRSS)                      | ✔️                     | GReader          | Bug           | ⭐⭐        | ➖                             | ➖                  | ✔️         | ➖     | ➖       | ➖           |
| [Readrops](https://github.com/readrops/Readrops)                                      | Android     | [✔️](https://github.com/readrops/Readrops)                    | ✔️✔️                   | GReader          | ✔️            | ⭐⭐⭐       | ➖                             | ➖                  | ➖         | ➖     | ➖       | ✔️           |
| [FocusReader](https://play.google.com/store/apps/details?id=allen.town.focus.reader)  | Android     | ➖                                                            | ✔️✔️                   | GReader          | ✔️            | ⭐⭐⭐       | ➖                             | ➖                  | ✔️         | ➖     | ✓       | ✔️           |
| [ChristopheHenry](https://gitlab.com/christophehenry/freshrss-android)            | Android     | [✔️](https://gitlab.com/christophehenry/freshrss-android) | Work in progress       | GReader          | ✔️            | ⭐⭐        | ➖                             | ✔️                  | ✔️         | ➖     | ➖       | ➖           |
| [Fluent Reader](https://hyliu.me/fluent-reader/)                             | Windows, Linux, MacOS| [✔️](https://github.com/yang991178/fluent-reader)             | ✔️✔️                   | Fever            | ✔️            | ⭐         | ➖                             | ✔️                  | ✔️         | ➖     | ➖       | ➖           |
| [FeedReader](https://jangernert.github.io/FeedReader/)                                | GNU/Linux   | [✔️](https://jangernert.github.io/FeedReader/)                | ✔️                     | GReader          | ✔️            | ⭐⭐        | ➖                             | ✔️                  | ✔️         | ➖     | ✔️       | ✔️           |
| [NewsFlash](https://gitlab.com/news-flash/news_flash_gtk)                             | GNU/Linux   | [✔️](https://gitlab.com/news-flash/news_flash_gtk)            | ✔️✔️                   | Fever   | ➖            | ⭐⭐        | ✔️                           | ✔️                | ✔️       | ➖    | ➖      | ➖          |
| [NewsFlash](https://gitlab.com/news-flash/news_flash_gtk) |            GNU/Linux            | [✔️](https://gitlab.com/news-flash/news_flash_gtk) | Work in Progress | GReader | ➖ | ❔ | ❔ | ❔ | ❔ | ❔ | ➖ | ❔ |
| [Newsboat 2.24+](https://newsboat.org/)                                 | GNU/Linux, MacOS, FreeBSD | [✔️](https://github.com/newsboat/newsboat/)                   | ✔️✔️                   | GReader          | ➖            | ⭐        | ➖                             | ✔️                  | ✔️         | ➖     | ✔️       | ➖           |
| [Vienna RSS](http://www.vienna-rss.com/)                                              | MacOS       | [✔️](https://github.com/ViennaRSS/vienna-rss)                 | ✔️✔️                   | GReader          | ❔            | ❔        | ❔                             | ❔                  | ❔         | ❔     | ❔       | ❔           |
| [Reeder](https://www.reederapp.com/)*                                                  | iOS, MacOS  | ➖                                                            | ✔️✔️                 | GReader, Fever   | ✔️            | ⭐⭐⭐       | ➖                             | ✔️                  | ✔️         | ➖     | ➖       | ✔️           |
| [Unread](https://apps.apple.com/app/unread-2/id1363637349)                            | iOS         | ➖                                                            | ✔️✔️                   | Fever            | ✔️            | ❔        | ❔                             | ❔                  | ✔️         | ➖     | ➖       | ➖           |
| [Fiery Feeds](https://apps.apple.com/app/fiery-feeds-rss-reader/id1158763303)         | iOS         | ➖                                                            | ✔️✔️                   | Fever            | ❔            | ❔        | ❔                             | ❔                  | ❔         | ➖     | ➖       | ➖           |
| [Readkit](https://apps.apple.com/app/readkit/id588726889)                             | MacOS       | ➖                                                            | ✔️✔️                   | Fever            | ✔️            | ❔        | ❔                             | ❔                  | ❔         | ➖     | ➖       | ➖           |
| [Netnewswire](https://ranchero.com/netnewswire/)                                      | iOS, MacOS  | [✔️](https://github.com/Ranchero-Software/NetNewsWire)        | Work in progress       | GReader          | ✔️            | ❔        | ❔                             | ❔                  | ✔️         | ➖     | ❔       | ✔️           |

\* Install and enable the [GReader Redate extension](https://github.com/javerous/freshrss-greader-redate) to have the correct publication date for feed articles if you are using Reeder or FeedMe.

# Included libraries

* [SimplePie](https://simplepie.org/)
* [MINZ](https://github.com/marienfressinaud/MINZ)
* [php-http-304](https://alexandre.alapetite.fr/doc-alex/php-http-304/)
* [lib_opml](https://github.com/marienfressinaud/lib_opml)
* [PHPMailer](https://github.com/PHPMailer/PHPMailer)
* [Chart.js](https://www.chartjs.org)

## Only for some options or configurations

* [bcrypt.js](https://github.com/dcodeIO/bcrypt.js)
* [phpQuery](https://github.com/phpquery/phpquery)
