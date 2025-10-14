[![Liberapay donations](https://img.shields.io/liberapay/receives/FreshRSS.svg?logo=liberapay)](https://liberapay.com/FreshRSS/donate)

* Read this document on [github.com/FreshRSS/FreshRSS/](https://github.com/FreshRSS/FreshRSS/blob/edge/README.md) to get the correct links and pictures.
* [Version française](README.fr.md)

# FreshRSS

FreshRSS is a self-hosted RSS feed aggregator.

It is lightweight, easy to work with, powerful, customizable, and has been [translated](#internationalization-20-languages-translation-progress) into many languages.

It is a multi-user application with an anonymous reading mode. It supports custom tags.
There is an API for (mobile) clients, and a [Command-Line Interface](cli/README.md).

Thanks to the [WebSub](https://freshrss.github.io/FreshRSS/en/users/WebSub.html) standard,
FreshRSS is able to receive instant push notifications from compatible sources, such as [Friendica](https://friendi.ca), [WordPress](https://wordpress.org/plugins/pubsubhubbub/), Blogger, Medium, etc.

FreshRSS natively supports basic [Web scraping](https://freshrss.github.io/FreshRSS/en/users/11_website_scraping.html),
based on [XPath](https://www.w3.org/TR/xpath-10/), for Web sites not providing any RSS / Atom feed.
Also supports JSON documents.

FreshRSS offers the ability to [reshare selections of articles by HTML, RSS, and OPML](https://freshrss.github.io/FreshRSS/en/users/user_queries.html).

Different [login methods](https://freshrss.github.io/FreshRSS/en/admins/09_AccessControl.html) are supported: Web form (including an anonymous option), HTTP Authentication (compatible with proxy delegation), OpenID Connect.

Finally, FreshRSS supports [extensions](#extensions) for further tuning.

* Official website: <https://freshrss.org>
* Demo: <https://demo.freshrss.org>
* License: [GNU AGPL 3](https://www.gnu.org/licenses/agpl-3.0.html)

![FreshRSS logo](docs/img/FreshRSS-logo.png)

## Feedback and contributions

Feature requests, bug reports, and other contributions are welcome. The best way is to [open an issue on GitHub](https://github.com/FreshRSS/FreshRSS/issues).
We are a friendly community.

To facilitate contributions, the [following option](.devcontainer/README.md) is available:

[![Open in GitHub Codespaces](https://github.com/codespaces/badge.svg)](https://github.com/codespaces/new?hide_repo_select=true&ref=edge&repo=6322699)

## Screenshot

![FreshRSS screenshot](docs/img/FreshRSS-screenshot.png)

## Disclaimer

FreshRSS comes with absolutely no warranty.

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
* A Web server: Apache2.4+ (recommended), nginx, lighttpd (not tested on others)
* PHP 8.1+
	* Required extensions: [cURL](https://www.php.net/curl), [DOM](https://www.php.net/dom), [JSON](https://www.php.net/json), [XML](https://www.php.net/xml), [session](https://www.php.net/session), [ctype](https://www.php.net/ctype)
	* Recommended extensions: [PDO_SQLite](https://www.php.net/pdo-sqlite) (for export/import), [GMP](https://www.php.net/gmp) (for API access on 32-bit platforms), [IDN](https://www.php.net/intl.idn) (for Internationalized Domain Names), [mbstring](https://www.php.net/mbstring) (for Unicode strings), [iconv](https://www.php.net/iconv) (for charset conversion), [ZIP](https://www.php.net/zip) (for import/export), [zlib](https://www.php.net/zlib) (for compressed feeds)
	* Extension for database: [PDO_PGSQL](https://www.php.net/pdo-pgsql) or [PDO_SQLite](https://www.php.net/pdo-sqlite) or [PDO_MySQL](https://www.php.net/pdo-mysql)
* PostgreSQL 10+ or SQLite or MariaDB 10.0.5+ or MySQL 8.0+

# [Installation](https://freshrss.github.io/FreshRSS/en/admins/03_Installation.html)

The latest stable release can be found [on GitHub](https://github.com/FreshRSS/FreshRSS/releases/latest). New versions are released every two to three months.

If you want a rolling release with the newest features, or want to help testing or developing the next stable version, you can use [the `edge` branch](https://github.com/FreshRSS/FreshRSS/tree/edge/).

## Automated install

| | | |
|-|-|-|
| [<img src="https://www.docker.com/wp-content/uploads/2022/03/horizontal-logo-monochromatic-white.png" width="160" alt="Docker" />](./Docker/) | [<img src="https://install-app.yunohost.org/install-with-yunohost.png" width="160" alt="YunoHost" />](https://install-app.yunohost.org/?app=freshrss) | [<img src="https://elest.io/images/logos/deploy-to-elestio-btn.png" width="160" alt="Elestio" />](https://elest.io/open-source/freshrss) |
| [<img src="https://cloudron.io/img/button.svg" width="160" alt="Cloudron" />](https://cloudron.io/button.html?app=org.freshrss.cloudronapp) | [<img src="https://www.pikapods.com/static/run-button-34.svg" width="160" alt="PikaPods" />](https://www.pikapods.com/pods?run=freshrss) | [<img src="https://zeabur.com/button.svg" width="160" alt="Zeabur" />](https://zeabur.com/templates/MD4TRW) |
| [<img src="https://raw.githubusercontent.com/ClawCloud/Run-Template/refs/heads/main/Run-on-ClawCloud.svg" width="160" alt="ClawCloud" />](https://template.run.claw.cloud/?openapp=system-fastdeploy%3FtemplateName%3Dfreshrss) | [<img src="https://assets.hostinger.com/vps/deploy.svg" width="160" alt="Hostinger" />](https://www.hostinger.com/vps/docker-hosting?compose_url=https://github.com/FreshRSS/FreshRSS/blob/edge/Docker/freshrss/docker-compose.yml) | |

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

# Advice

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

# Internationalization: 20+ languages. Translation progress

<translations>
<!-- This section is automatically generated by `./cli/check.translation.php -g` -->

| Language | Progress | |
| - | - | - |
| Čeština (cs) | ￭￭￭￭￭￭￭￭･･ 88% | [contribute](https://github.com/search?q=repo%3AFreshRSS%2FFreshRSS+path%3Aapp%2Fi18n%2Fcs+%2F%28TODO%7CDIRTY%29%24%2F) |
| Deutsch (de) | ￭￭￭￭￭￭￭￭￭･ 98% | [contribute](https://github.com/search?q=repo%3AFreshRSS%2FFreshRSS+path%3Aapp%2Fi18n%2Fde+%2F%28TODO%7CDIRTY%29%24%2F) |
| Ελληνικά (el) | ￭￭････････ 22% | [contribute](https://github.com/search?q=repo%3AFreshRSS%2FFreshRSS+path%3Aapp%2Fi18n%2Fel+%2F%28TODO%7CDIRTY%29%24%2F) |
| English (en) | ￭￭￭￭￭￭￭￭￭￭ 100% | [contribute](https://github.com/search?q=repo%3AFreshRSS%2FFreshRSS+path%3Aapp%2Fi18n%2Fen+%2F%28TODO%7CDIRTY%29%24%2F) |
| English (United States) (en-US) | ￭￭￭￭￭￭￭￭￭￭ 100% | [contribute](https://github.com/search?q=repo%3AFreshRSS%2FFreshRSS+path%3Aapp%2Fi18n%2Fen-US+%2F%28TODO%7CDIRTY%29%24%2F) |
| Español (es) | ￭￭￭￭￭￭￭￭￭･ 91% | [contribute](https://github.com/search?q=repo%3AFreshRSS%2FFreshRSS+path%3Aapp%2Fi18n%2Fes+%2F%28TODO%7CDIRTY%29%24%2F) |
| فارسی (fa) | ￭￭￭￭￭￭￭￭￭･ 97% | [contribute](https://github.com/search?q=repo%3AFreshRSS%2FFreshRSS+path%3Aapp%2Fi18n%2Ffa+%2F%28TODO%7CDIRTY%29%24%2F) |
| Suomi (fi) | ￭￭￭￭￭￭￭￭￭･ 99% | [contribute](https://github.com/search?q=repo%3AFreshRSS%2FFreshRSS+path%3Aapp%2Fi18n%2Ffi+%2F%28TODO%7CDIRTY%29%24%2F) |
| Français (fr) | ￭￭￭￭￭￭￭￭￭￭ 100% | [contribute](https://github.com/search?q=repo%3AFreshRSS%2FFreshRSS+path%3Aapp%2Fi18n%2Ffr+%2F%28TODO%7CDIRTY%29%24%2F) |
| עברית (he) | ￭￭￭￭･･････ 45% | [contribute](https://github.com/search?q=repo%3AFreshRSS%2FFreshRSS+path%3Aapp%2Fi18n%2Fhe+%2F%28TODO%7CDIRTY%29%24%2F) |
| Magyar (hu) | ￭￭￭￭￭￭￭￭￭･ 98% | [contribute](https://github.com/search?q=repo%3AFreshRSS%2FFreshRSS+path%3Aapp%2Fi18n%2Fhu+%2F%28TODO%7CDIRTY%29%24%2F) |
| Bahasa Indonesia (id) | ￭￭￭￭￭￭￭￭￭･ 96% | [contribute](https://github.com/search?q=repo%3AFreshRSS%2FFreshRSS+path%3Aapp%2Fi18n%2Fid+%2F%28TODO%7CDIRTY%29%24%2F) |
| Italiano (it) | ￭￭￭￭￭￭￭￭￭￭ 100% | [contribute](https://github.com/search?q=repo%3AFreshRSS%2FFreshRSS+path%3Aapp%2Fi18n%2Fit+%2F%28TODO%7CDIRTY%29%24%2F) |
| 日本語 (ja) | ￭￭￭￭￭￭￭￭￭･ 94% | [contribute](https://github.com/search?q=repo%3AFreshRSS%2FFreshRSS+path%3Aapp%2Fi18n%2Fja+%2F%28TODO%7CDIRTY%29%24%2F) |
| 한국어 (ko) | ￭￭￭￭￭￭￭￭･･ 88% | [contribute](https://github.com/search?q=repo%3AFreshRSS%2FFreshRSS+path%3Aapp%2Fi18n%2Fko+%2F%28TODO%7CDIRTY%29%24%2F) |
| Latviešu (lv) | ￭￭￭￭￭￭￭￭･･ 82% | [contribute](https://github.com/search?q=repo%3AFreshRSS%2FFreshRSS+path%3Aapp%2Fi18n%2Flv+%2F%28TODO%7CDIRTY%29%24%2F) |
| Nederlands (nl) | ￭￭￭￭￭￭￭￭￭･ 99% | [contribute](https://github.com/search?q=repo%3AFreshRSS%2FFreshRSS+path%3Aapp%2Fi18n%2Fnl+%2F%28TODO%7CDIRTY%29%24%2F) |
| Occitan (oc) | ￭￭￭￭￭￭￭￭･･ 80% | [contribute](https://github.com/search?q=repo%3AFreshRSS%2FFreshRSS+path%3Aapp%2Fi18n%2Foc+%2F%28TODO%7CDIRTY%29%24%2F) |
| Polski (pl) | ￭￭￭￭￭￭￭￭￭･ 99% | [contribute](https://github.com/search?q=repo%3AFreshRSS%2FFreshRSS+path%3Aapp%2Fi18n%2Fpl+%2F%28TODO%7CDIRTY%29%24%2F) |
| Português (Brasil) (pt-BR) | ￭￭￭￭￭￭￭￭･･ 87% | [contribute](https://github.com/search?q=repo%3AFreshRSS%2FFreshRSS+path%3Aapp%2Fi18n%2Fpt-BR+%2F%28TODO%7CDIRTY%29%24%2F) |
| Português (Portugal) (pt-PT) | ￭￭￭￭￭￭￭￭･･ 87% | [contribute](https://github.com/search?q=repo%3AFreshRSS%2FFreshRSS+path%3Aapp%2Fi18n%2Fpt-PT+%2F%28TODO%7CDIRTY%29%24%2F) |
| Русский (ru) | ￭￭￭￭￭￭￭￭･･ 88% | [contribute](https://github.com/search?q=repo%3AFreshRSS%2FFreshRSS+path%3Aapp%2Fi18n%2Fru+%2F%28TODO%7CDIRTY%29%24%2F) |
| Slovenčina (sk) | ￭￭￭￭￭￭￭￭･･ 88% | [contribute](https://github.com/search?q=repo%3AFreshRSS%2FFreshRSS+path%3Aapp%2Fi18n%2Fsk+%2F%28TODO%7CDIRTY%29%24%2F) |
| Türkçe (tr) | ￭￭￭￭￭￭￭￭￭･ 96% | [contribute](https://github.com/search?q=repo%3AFreshRSS%2FFreshRSS+path%3Aapp%2Fi18n%2Ftr+%2F%28TODO%7CDIRTY%29%24%2F) |
| Українська (uk) | ￭￭￭￭￭￭￭￭￭･ 98% | [contribute](https://github.com/search?q=repo%3AFreshRSS%2FFreshRSS+path%3Aapp%2Fi18n%2Fuk+%2F%28TODO%7CDIRTY%29%24%2F) |
| 简体中文 (zh-CN) | ￭￭￭￭￭￭￭￭･･ 89% | [contribute](https://github.com/search?q=repo%3AFreshRSS%2FFreshRSS+path%3Aapp%2Fi18n%2Fzh-CN+%2F%28TODO%7CDIRTY%29%24%2F) |
| 正體中文 (zh-TW) | ￭￭￭￭￭￭￭￭･･ 88% | [contribute](https://github.com/search?q=repo%3AFreshRSS%2FFreshRSS+path%3Aapp%2Fi18n%2Fzh-TW+%2F%28TODO%7CDIRTY%29%24%2F) |

</translations>

# APIs & native apps

FreshRSS supports access from mobile / native apps for Linux, Android, iOS, Windows and macOS, via two distinct APIs:
[Google Reader API](https://freshrss.github.io/FreshRSS/en/developers/06_GoogleReader_API.html) (best),
and [Fever API](https://freshrss.github.io/FreshRSS/en/developers/06_Fever_API.html) (limited features, less efficient, less safe).

| App                                                                                   | Platform    | Free Software                                                 | Maintained & Developed | API              | Works offline | Fast sync | Fetch more in individual views | Fetch read articles | Favourites | Labels | Podcasts | Manage feeds |
|:--------------------------------------------------------------------------------------|:-----------:|:-------------------------------------------------------------:|:----------------------:|:----------------:|:-------------:|:---------:|:------------------------------:|:-------------------:|:----------:|:------:|:--------:|:------------:|
| [Readrops](https://github.com/readrops/Readrops)                                      | Android     | [✔️](https://github.com/readrops/Readrops)                    | ✔️✔️                   | GReader          | ✔️            | ⭐⭐⭐    | ➖                             | ✔️                  | ✔️         | [➖](https://github.com/readrops/Readrops/issues/54) | ➖       | ✔️           |
| [Capy Reader](https://github.com/jocmp/capyreader)                                    | Android     | [✔️](https://github.com/jocmp/capyreader)                     | ✔️✔️                   | GReader          | ✔️            | ⭐⭐      | [➖](https://github.com/jocmp/capyreader/discussions/532) | ➖                  | ✔️         | [➖](https://github.com/jocmp/capyreader/discussions/531) | ➖       | ✔️           |
| [FeedMe](https://play.google.com/store/apps/details?id=com.seazon.feedme)             | Android     | [➖](https://github.com/seazon/FeedMe)                        | ✔️✔️                   | GReader          | ✔️            | ⭐⭐       | ➖                             | ➖                  | ✔️         | [✓](https://github.com/seazon/FeedMe/issues/348) | ✔️       | ✔️           |
| [FocusReader](https://play.google.com/store/apps/details?id=allen.town.focus.reader)  | Android     | ➖                                                            | ✔️✔️                   | GReader          | ✔️            | ⭐⭐       | ➖                             | ➖                  | ✔️         | ✓     | ✓       | ✔️           |
| [Your News](https://yournews.app/)                                                    | Android, iOS| ➖                                                            | ✔️✔️                   | GReader          | ➖️            | ⭐        | ✔️                             | ✔️                  | ✔️        | ➖     | ➖      | ➖        |
| [Fluent Reader Lite](https://hyliu.me/fluent-reader-lite/)                            | Android, iOS| [✔️](https://github.com/yang991178/fluent-reader-lite)        | ✔️                     | GReader          | ✔️            | ⭐⭐       | ➖                             | ➖                  | ✓         | ➖     | ➖       | ➖           |
| [Read You](https://github.com/Ashinch/ReadYou/)                                       | Android     | [✔️](https://github.com/Ashinch/ReadYou/)                     | [Work in progress](https://github.com/Ashinch/ReadYou/discussions/542) | GReader | ➖            | [⭐](https://github.com/Ashinch/ReadYou/issues/666) | ➖                    | ✔️                   | ✔️             | ➖     | ➖       | ✔️           |

| App                                                                                   | Platform    | Free Software                                                 | Maintained & Developed | API              | Works offline | Fast sync | Fetch more in individual views | Fetch read articles | Favourites | Labels | Podcasts | Manage feeds |
|:--------------------------------------------------------------------------------------|:-----------:|:-------------------------------------------------------------:|:----------------------:|:----------------:|:-------------:|:---------:|:------------------------------:|:-------------------:|:----------:|:------:|:--------:|:------------:|
| [Fluent Reader](https://hyliu.me/fluent-reader/)                             | Windows, Linux, macOS| [✔️](https://github.com/yang991178/fluent-reader)             | ✔️✔️                   | GReader          | ✔️            | ⭐        | ➖                             | ✔️                  | ✓         | ➖     | ➖       | ➖           |
| [RSS Guard](https://github.com/martinrotter/rssguard)             | Windows, GNU/Linux, macOS, OS/2 | [✔️](https://github.com/martinrotter/rssguard)                | ✔️✔️                   | GReader          | ✔️            | ⭐⭐      | ➖ | ✔️ | ✔️ | ✔️ | ✔️ | ✔️ |
| [NewsFlash](https://gitlab.com/news-flash/news_flash_gtk)                             | GNU/Linux   | [✔️](https://gitlab.com/news-flash/news_flash_gtk)            | ✔️✔️                   | GReader          | ➖            | ⭐⭐      | ➖                           | ✔️                | ✔️       | ✔️    | ➖      | ➖          |
| [Newsboat](https://newsboat.org/)                                       | GNU/Linux, macOS, FreeBSD | [✔️](https://github.com/newsboat/newsboat/)                   | ✔️✔️                   | GReader          | ➖            | ⭐        | ➖                             | ✔️                  | ✔️         | ➖     | ✔️       | ➖           |

| App                                                                                   | Platform    | Free Software                                                 | Maintained & Developed | API              | Works offline | Fast sync | Fetch more in individual views | Fetch read articles | Favourites | Labels | Podcasts | Manage feeds |
|:--------------------------------------------------------------------------------------|:-----------:|:-------------------------------------------------------------:|:----------------------:|:----------------:|:-------------:|:---------:|:------------------------------:|:-------------------:|:----------:|:------:|:--------:|:------------:|
| [Vienna RSS](http://www.vienna-rss.com/)                                              | macOS       | [✔️](https://github.com/ViennaRSS/vienna-rss)                 | ✔️✔️                   | GReader          | ❔            | ❔        | ❔                             | ❔                  | ❔         | ❔     | ❔       | ❔           |
| [Readkit](https://apps.apple.com/app/readkit-read-later-rss/id1615798039)             | iOS, macOS  | ➖                                                            | ✔️✔️                   | GReader          | ✔️            | ⭐⭐⭐    | ➖                             | ✔️                  | ✔️         | ➖     | ✓       | 💲           |
| [Reeder Classic](https://www.reederapp.com/classic/)                                 | iOS, macOS  | ➖                                                            | ✔️✔️                   | GReader          | ✔️            | ⭐⭐⭐    | ➖                             | ✔️                  | ✔️         | ➖     | ➖       | ✔️           |
| [lire](https://lireapp.com/)                                                          | iOS, macOS  | ➖                                                            | ✔️✔️                   | GReader          | ❔            | ❔        | ❔                             | ❔                  | ❔         | ❔     | ❔       | ❔           |
| [Unread](https://apps.apple.com/app/unread-2/id1363637349)                            | iOS         | ➖                                                            | ✔️✔️                   | Fever            | ✔️            | ❔        | ❔                             | ❔                  | ✔️         | ➖     | ➖       | ➖           |
| [Fiery Feeds](https://apps.apple.com/app/fiery-feeds-rss-reader/id1158763303)         | iOS         | ➖                                                            | ✔️✔️                   | Fever            | ❔            | ❔        | ❔                             | ❔                  | ❔         | ➖     | ➖       | ➖           |
| [Netnewswire](https://ranchero.com/netnewswire/)                                      | iOS, macOS  | [✔️](https://github.com/Ranchero-Software/NetNewsWire)        | Work in progress       | GReader          | ✔️            | ❔        | ❔                             | ❔                  | ✔️         | ➖     | ❔       | ✔️           |

# Included libraries

* [SimplePie](https://simplepie.org/)
* [php-http-304](https://alexandre.alapetite.fr/doc-alex/php-http-304/)
* [lib_opml](https://framagit.org/marienfressinaud/lib_opml)
* [bcrypt.js](https://github.com/dcodeIO/bcrypt.js)
* [PhpGt/CssXPath](https://github.com/PhpGt/CssXPath)
* [PHPMailer](https://github.com/PHPMailer/PHPMailer)
* [Chart.js](https://www.chartjs.org)

# Additional credits

* Based on a modified version of the [MINZ framework](https://framagit.org/marienfressinaud/MINZ).
* Some [icons](https://gitlab.gnome.org/Archive/gnome-icon-theme-symbolic) come from the [GNOME project](https://www.gnome.org/)
* Fonts: [*Open Sans*](https://fonts.google.com/specimen/Open+Sans), [*Lato*](https://www.latofonts.com/lato-free-fonts/), [*Spectral*](https://github.com/productiontype/spectral)

# Alternatives

If FreshRSS does not suit you for one reason or another, here are alternative solutions to consider:

* [Kriss Feed](https://tontof.net/kriss/feed/)
* [Leed](https://github.com/LeedRSS/Leed)
* [And more…](https://alternativeto.net/software/freshrss/) (but if you like FreshRSS, give us a vote!)
