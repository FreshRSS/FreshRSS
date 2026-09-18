# Installation on Debian/Ubuntu

This tutorial will give you step-by-step commands to install FreshRSS with Apache using git.
It’s always recommended that you [backup your installation](05_Backup.md) before updating

Please note: Commands need to be run as an administrator; either perform the following from a sudo shell (`sudo -s`) or use an administrator account.

## Part 1: Setting up and configuring the Web server

Begin by installing Apache, and enable Apache modules needed for FreshRSS

```sh
apt install apache2
a2enmod headers expires rewrite ssl
```

Then, you have to configure Apache. You can create a file in `/etc/apache2/sites-available`, based on [our example configuration file](10_ServerConfig.md). Once you’re done, create a symbolic link from this file to the `sites-enabled` folder:

```sh
ln -s /etc/apache2/sites-available/freshrss.conf /etc/apache2/sites-enabled/freshrss.conf
```

Next, install PHP and the necessary modules

```sh
apt install php php-curl php-gmp php-intl php-mbstring php-sqlite3 php-xml php-zip
```

Install the PHP module for Apache

```sh
apt install libapache2-mod-php
```

This tutorial uses [SQLite](DatabaseConfig.md), which needs no database server:
the `php-sqlite3` module installed above is all that is required.
Each user’s data is stored in a single file, `data/users/_user_/db.sqlite`, created during the installation.

Finally, restart the web server

```sh
service apache2 restart
```

## Part 2: Installing FreshRSS

Begin by installing git, if you don’t already have it installed.

```sh
apt install git
```

Next, change to the install directory and download FreshRSS using git. The following path keeps FreshRSS out of system read-only directories, which avoids write failures from hardened PHP-FPM service settings.

```sh
mkdir -p /var/www/
cd /var/www/
git clone https://github.com/FreshRSS/FreshRSS.git
```

Change to the new FreshRSS directory, and set the permissions so that your Web server can access the files

```sh
cd FreshRSS
sudo cli/access-permissions.sh
```

Optional: If you would like to allow updates from the Web interface, set write permissions (reduces slightly the security)

```sh
# Debian
chown www-data:www-data -R .
# Alpine
chown apache:www-data -R .
```

Finally, symlink the public folder to your FreshRSS directory

```sh
[ ! -e "/var/www/html/FreshRSS" ] && ln -s /var/www/FreshRSS/p /var/www/html/FreshRSS || echo "/var/www/html/FreshRSS already exists"
```

## Part 3: Finishing the Installation

No database setup is needed with SQLite: it is created automatically during the installation.

You can now finish the installation from a web browser by navigating to to `http://<your_server>/` and following the graphical prompts.
Alternatively, you can finish the installation using [the cli](https://github.com/FreshRSS/FreshRSS/tree/edge/cli)
