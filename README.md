[![Build Status][travis-badge]][travis-link]

* Read this document on [github.com/FreshRSS/FreshRSS/](https://github.com/FreshRSS/FreshRSS/blob/master/README.md) to get the correct links and pictures.
* [Version française](README.fr.md)

# FreshRSS
FreshRSS is a self-hosted RSS feed aggregator such as [Leed](http://leed.idleman.fr/) or [Kriss Feed](https://tontof.net/kriss/feed/).

It is at the same time lightweight, easy to work with, powerful and customizable.

It is a multi-user application with an anonymous reading mode.
It supports custom tags, and [PubSubHubbub](https://github.com/pubsubhubbub/PubSubHubbub) for instant notifications from compatible Web sites.
There is an API for (mobile) clients, and a [Command-Line Interface](cli/README.md).
Finally, it supports [extensions](#extensions) for further tuning.

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
This application was developed to fulfil personal needs primarily, and comes with absolutely no warranty.
Feature requests, bug reports, and other contributions are welcome. The best way is to [open an issue on GitHub](https://github.com/FreshRSS/FreshRSS/issues).
We are a friendly community.

# Requirements
* Light server running Linux or Windows
	* It even works on Raspberry Pi 1 with response time under a second (tested with 150 feeds, 22k articles)
* A web server: Apache2 (recommended), nginx, lighttpd (not tested on others)
* PHP 5.3.8+ (PHP 5.4+ recommended, and PHP 5.5+ for performance, and PHP 7 for even higher performance)
	* Required extensions: [cURL](https://secure.php.net/curl), [DOM](https://secure.php.net/dom), [XML](https://secure.php.net/xml), [session](https://secure.php.net/session), [ctype](https://secure.php.net/ctype), and [PDO_MySQL](https://secure.php.net/pdo-mysql) or [PDO_SQLite](https://secure.php.net/pdo-sqlite) or [PDO_PGSQL](https://secure.php.net/pdo-pgsql)
	* Recommended extensions: [JSON](https://secure.php.net/json), [GMP](https://secure.php.net/gmp) (for API access on platforms < 64 bits), [IDN](https://secure.php.net/intl.idn) (for Internationalized Domain Names), [mbstring](https://secure.php.net/mbstring) (for Unicode strings), [iconv](https://secure.php.net/iconv) (for charset conversion), [ZIP](https://secure.php.net/zip) (for import/export), [zlib](https://secure.php.net/zlib) (for compressed feeds)
* MySQL 5.5.3+ (recommended), or SQLite 3.7.4+, or PostgreSQL 9.2+
* A recent browser like Firefox / IceCat, Internet Explorer 11 / Edge, Chromium / Chrome, Opera, Safari.
	* Works on mobile

![FreshRSS screenshot](docs/img/FreshRSS-screenshot.png)

# Documentation
* https://freshrss.github.io/FreshRSS/en/

# [Installation](https://freshrss.github.io/FreshRSS/en/admins/02_Installation.html)
1. Get FreshRSS with git or [by downloading the archive](https://github.com/FreshRSS/FreshRSS/archive/master.zip)
2. Dump the application on your server (expose only the `./p/` folder)
3. Add write access on `./data/` folder to the webserver user
4. Access FreshRSS with your browser and follow the installation process
	* or use the [Command-Line Interface](cli/README.md)
5. Everything should be working :) If you encounter any problem, feel free [contact us](https://github.com/FreshRSS/FreshRSS/issues).
6. Advanced configuration settings can be seen in [config.default.php](config.default.php) and modified in `data/config.php`.
7. When using Apache, enable [`AllowEncodedSlashes`](https://httpd.apache.org/docs/trunk/mod/core.html#allowencodedslashes) for better compatibility with mobile clients.

More information about installation and server configuration can be found in [our documentation](https://freshrss.github.io/FreshRSS/en/admins/02_Installation.html).

## Automated install 
* [![Docker](https://www.docker.com/sites/default/files/horizontal.png)](./Docker/)
* [![YunoHost](https://install-app.yunohost.org/install-with-yunohost.png)](https://install-app.yunohost.org/?app=freshrss)
* [![Cloudron](https://cloudron.io/img/button.svg)](https://cloudron.io/button.html?app=org.freshrss.cloudronapp)

## Example of full installation on Linux Debian/Ubuntu
```sh
# If you use an Apache Web server (otherwise you need another Web server)
sudo apt-get install apache2
sudo a2enmod headers expires rewrite ssl	#Apache modules

# Example for Ubuntu >= 16.04, Debian >= 9 Stretch
sudo apt install php php-curl php-gmp php-intl php-mbstring php-sqlite3 php-xml php-zip
sudo apt install libapache2-mod-php	#For Apache
sudo apt install mysql-server mysql-client php-mysql	#Optional MySQL database
sudo apt install postgresql php-pgsql	#Optional PostgreSQL database

# Restart Web server
sudo service apache2 restart

# For FreshRSS itself (git is optional if you manually download the installation files)
cd /usr/share/
sudo apt-get install git
sudo git clone https://github.com/FreshRSS/FreshRSS.git
cd FreshRSS

# If you want to use the development version of FreshRSS
sudo git checkout -b dev origin/dev

# Set the rights so that your Web server can access the files
sudo chown -R :www-data . && sudo chmod -R g+r . && sudo chmod -R g+w ./data/
# If you would like to allow updates from the Web interface
sudo chmod -R g+w .

# Publish FreshRSS in your public HTML directory
sudo ln -s /usr/share/FreshRSS/p /var/www/html/FreshRSS
# Navigate to http://example.net/FreshRSS to complete the installation
# (If you do it from localhost, you may have to adjust the setting of your public address later)
# or use the Command-Line Interface

# Update to a newer version of FreshRSS with git
cd /usr/share/FreshRSS
sudo git pull
sudo chown -R :www-data . && sudo chmod -R g+r . && sudo chmod -R g+w ./data/
```

See more commands and git commands in the [Command-Line Interface documentation](cli/README.md).

## Access control
It is needed for the multi-user mode to limit access to FreshRSS. You can:
* use form authentication (needs JavaScript, and PHP 5.5+ recommended)
* use HTTP authentication supported by your web server
	* See [Apache documentation](https://httpd.apache.org/docs/trunk/howto/auth.html)
		* In that case, create a `./p/i/.htaccess` file with a matching `.htpasswd` file.

## Automatic feed update
* You can add a Cron job to launch the update script.
Check the Cron documentation related to your distribution ([Debian/Ubuntu](https://help.ubuntu.com/community/CronHowto), [Red Hat/Fedora](https://fedoraproject.org/wiki/Administration_Guide_Draft/Cron), [Slackware](https://docs.slackware.com/fr:slackbook:process_control?#cron), [Gentoo](https://wiki.gentoo.org/wiki/Cron), [Arch Linux](https://wiki.archlinux.org/index.php/Cron)…).
It is a good idea to use the Web server user.
For instance, if you want to run the script every hour:

```
9 * * * * php /usr/share/FreshRSS/app/actualize_script.php > /tmp/FreshRSS.log 2>&1
```

### Example on Debian / Ubuntu
Create `/etc/cron.d/FreshRSS` with:

```
6,36 * * * * www-data php -f /usr/share/FreshRSS/app/actualize_script.php > /tmp/FreshRSS.log 2>&1
```


# Advices
* For a better security, expose only the `./p/` folder on the Web.
	* Be aware that the `./data/` folder contains all personal data, so it is a bad idea to expose it.
* The `./constants.php` file defines access to application folder. If you want to customize your installation, every thing happens here.
* If you encounter any problem, logs are accessible from the interface or manually in `./data/users/*/log*.txt` files.
	* The special folder `./data/users/_/` contains the part of the logs that are shared by all users.


# Backup
* You need to keep `./data/config.php`, and `./data/users/*/config.php` files
* You can export your feed list in OPML format either from the Web interface, or from the [Command-Line Interface](cli/README.md)
* To save articles, you can use [phpMyAdmin](https://www.phpmyadmin.net) or MySQL tools:

```bash
mysqldump --skip-comments --disable-keys --user=<db_user> --password --host <db_host> --result-file=freshrss.dump.sql --databases <freshrss_db>
```


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
