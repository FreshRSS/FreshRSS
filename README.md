* [Version française](README.fr.md)

# FreshRSS
FreshRSS is a self-hosted RSS feed aggregator such as [Leed](http://projet.idleman.fr/leed/) or [Kriss Feed](http://tontof.net/kriss/feed/).

It is at the same time lightweight, easy to work with, powerful and customizable.

It is a multi-user application with an anonymous reading mode.
It supports [PubSubHubbub](https://code.google.com/p/pubsubhubbub/) for instant notifications from compatible Web sites.

* Official website: http://freshrss.org
* Demo: http://demo.freshrss.org/
* License: [GNU AGPL 3](http://www.gnu.org/licenses/agpl-3.0.html)

![FreshRSS logo](http://marienfressinaud.fr/data/images/freshrss/freshrss_title.png)

# Releases
See the [list of releases](../../releases).

## Note on branches
**This application is under continuous development!** Please use the branch that suits your needs:

* Use [the master branch](https://github.com/FreshRSS/FreshRSS/tree/master/) if you need a stable version.
* [The beta branch](https://github.com/FreshRSS/FreshRSS/tree/beta) is the default branch: new features are added on a monthly basis.
* For developers and tech savvy persons willing to help testing the latest features, [the dev branch](https://github.com/FreshRSS/FreshRSS/tree/dev) is waiting for you!

# Disclaimer
This application was developed to fulfil personal needs primarily, and comes with absolutely no warranty.
Feature requests, bug reports, and other contributions are welcome. The best way is to [open issues on GitHub](https://github.com/FreshRSS/FreshRSS/issues).
We are a friendly community.

# Requirements
* Light server running Linux or Windows
	* It even works on Raspberry Pi with response time under a second (tested with 150 feeds, 22k articles, or 32Mo of compressed data)
* A web server: Apache2 (recommended), nginx, lighttpd (not tested on others)
* PHP 5.2.1+ (PHP 5.3.7+ recommended, and PHP 5.5+ for performance) (beta support for PHP 7 with even higher performance)
	* Required extensions: [PDO_MySQL](http://php.net/pdo-mysql) or [PDO_SQLite](http://php.net/pdo-sqlite), [cURL](http://php.net/curl), [GMP](http://php.net/gmp) (for API access on platforms < 64 bits), [IDN](http://php.net/intl.idn) (for Internationalized Domain Names)
	* Recommended extensions: [JSON](http://php.net/json), [mbstring](http://php.net/mbstring), [zlib](http://php.net/zlib), [Zip](http://php.net/zip)
* MySQL 5.0.3+ (recommended) or SQLite 3.7.4+
* A recent browser like Firefox, Chrome, Opera, Safari. [Internet Explorer currently not supported, but support will come back](https://github.com/FreshRSS/FreshRSS/issues/772).
	* Works on mobile

![FreshRSS screenshot](http://marienfressinaud.fr/data/images/freshrss/freshrss_default-design.png)

# Installation
1. Get FreshRSS with git or [by downloading the archive](https://github.com/FreshRSS/FreshRSS/archive/master.zip)
2. Dump the application on your server (expose only the `./p/` folder)
3. Add write access on `./data/` folder to the webserver user
4. Access FreshRSS with your browser and follow the installation process
5. Everything should be working :) If you encounter any problem, feel free to contact me.
6. Advanced configuration settings can be seen in [config.php](./data/config.default.php).

## Example of full installation on Linux Debian/Ubuntu
```sh
# If you use an Apache Web server (otherwise you need another Web server)
sudo apt-get install apache2
sudo a2enmod headers expires rewrite ssl
# (Optional) If you want a MySQL database server
sudo apt-get install mysql-server mysql-client php5-mysql
# Main components (git is optional if you manually download the installation files)
sudo apt-get install git php5 php5-curl php5-gd php5-intl php5-json php5-gmp php5-sqlite
# Restart Web server
sudo service apache2 restart

# For FreshRSS itself
cd /usr/share/
sudo git clone https://github.com/FreshRSS/FreshRSS.git
# Set the rights so that your Web browser can access the files
cd FreshRSS
sudo chown -R :www-data .
sudo chmod -R g+w ./data/
# Publish FreshRSS in your public HTML directory
sudo ln -s /usr/share/FreshRSS/p /var/www/html/FreshRSS
# Navigate to http://example.net/FreshRSS to complete the installation.
# (If you do it from localhost, you may have to adjust the setting of your public address later)

# Update to a newer version of FreshRSS
cd /usr/share/FreshRSS
sudo git reset --hard
sudo git pull
sudo chown -R :www-data .
sudo chmod -R g+w ./data/
```

# Access control
It is needed for the multi-user mode to limit access to FreshRSS. You can:
* use form authentication (need JavaScript and PHP 5.3.7+, works with some PHP 5.3.3+)
* use [Mozilla Persona](https://login.persona.org/about) authentication included in FreshRSS
* use HTTP authentication supported by your web server
	* See [Apache documentation](http://httpd.apache.org/docs/trunk/howto/auth.html)
		* In that case, create a `./p/i/.htaccess` file with a matching `.htpasswd` file.

# Automatic feed update
* You can add a Cron job to launch the update script.
Check the Cron documentation related to your distribution ([Debian/Ubuntu](https://help.ubuntu.com/community/CronHowto), [Red Hat/Fedora](https://fedoraproject.org/wiki/Administration_Guide_Draft/Cron), [Slackware](http://docs.slackware.com/fr:slackbook:process_control?#cron), [Gentoo](https://wiki.gentoo.org/wiki/Cron), [Arch Linux](https://wiki.archlinux.org/index.php/Cron)…).
It’s a good idea to use the Web server user.
For example, if you want to run the script every hour:

```
7 * * * * php /your-path/FreshRSS/app/actualize_script.php > /tmp/FreshRSS.log 2>&1
```

# Advices
* For a better security, expose only the `./p/` folder on the web.
	* Be aware that the `./data/` folder contains all personal data, so it is a bad idea to expose it.
* The `./constants.php` file defines access to application folder. If you want to customize your installation, every thing happens here.
* If you encounter any problem, logs are accessible from the interface or manually in `./data/log/*.log` files.

# Backup
* You need to keep `./data/config.php`, `./data/*_user.php` and `./data/persona/` files
* You can export your feed list in OPML format from FreshRSS
* To save articles, you can use [phpMyAdmin](http://www.phpmyadmin.net) or MySQL tools:

```bash
mysqldump -u user -p --databases freshrss > freshrss.sql
```


# Included libraries
* [SimplePie](http://simplepie.org/)
* [MINZ](https://github.com/marienfressinaud/MINZ)
* [php-http-304](http://alexandre.alapetite.fr/doc-alex/php-http-304/)
* [jQuery](http://jquery.com/)
* [keyboard_shortcuts](http://www.openjs.com/scripts/events/keyboard_shortcuts/)
* [flotr2](http://www.humblesoftware.com/flotr2)

## Only for some options
* [bcrypt.js](https://github.com/dcodeIO/bcrypt.js)
* [phpQuery](http://code.google.com/p/phpquery/)

## If native functions are not available
* [Services_JSON](http://pear.php.net/pepr/pepr-proposal-show.php?id=198)
* [password_compat](https://github.com/ircmaxell/password_compat)
