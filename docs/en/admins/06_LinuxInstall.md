# Installation on Debian 9/Ubuntu 16.04

This tutorial will give you step-by-step commands to install the latest stable release of FreshRSS with Apache and MySQL using git. It’s always recommended that you [backup your installation](05_Backup.md) before updating

Please note: Commands need to be run as an administrator; either perform the following from a sudo shell (`sudo -s`) or use an administrator account.

## Part 1: Setting up and configuring the LAMP stack

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

Next, we will need to install and configure MySQL. Install MySQL components like so:

```sh
sudo apt install mysql-server mysql-client php-mysql
```

MySQL must now be started:

```sh
service mysql-server start
```

We will need to configure MySQL.
**Note:** As you have just installed mysql, there will be no root password; simply hit enter on the first step

```sh
mysql_secure_installation
```

And restart it

```sh
service mysql-server restart
```

Finally, restart MySQL and the web server

```sh
service apache2 restart
```

## Part 2: Installing FreshRSS

Begin by installing git, if you don’t already have it installed.

```sh
apt install git
```

Next, change to the install directory and download FreshRSS using git

```sh
cd /usr/share/
git clone https://github.com/FreshRSS/FreshRSS.git
```

Change to the new FreshRSS directory, and set the permissions so that your Web server can access the files

```sh
cd FreshRSS
chown -R :www-data .
sudo chmod -R g+r .
```

We will also need to allow the data folder to be written to, like so:

```sh
chmod -R g+w ./data/
```

Optional: If you would like to allow updates from the Web interface, set write permissions

```sh
chmod -R g+w .
```

Finally, symlink the public folder to the root of your web directory

```sh
ln -s /usr/share/FreshRSS/p /var/www/html/
```

## Part 3: Creating a Database for FreshRSS

Start a MySQL session. running this command will ask you for the MySQL password you set earlier, and then put you into a prompt that should look like `MariaDB [(none)]>`

```sh
mysql -u root -p
```

From the MySQL prompt (`MariaDB [(none)]>`), run the following commands, substituting `<username>`, `<password>`, and `<database_name>` for real values.

```sql
CREATE USER '<username>'@'localhost' IDENTIFIED BY '<password>';
CREATE DATABASE `databaseName`;
GRANT ALL privileges ON `databaseName`.* TO 'userName'@localhost;
FLUSH PRIVILEGES;
QUIT;
```

A brief explanation of the previous command block:

* You first create a database user for FreshRSS to use.
* Then you create a database for FreshRSS to store data in.
* You grant permissions for the user you created to read, write, and modify the database.
* Flushing privileges reloads the permissions, which makes the previous command take effect.

## Part 4: Finishing the Installation

You can now finish the installation from a web browser by navigating to to `http://<your_server>/` and following the graphical prompts.
Alternatively, you can finish the installation using [the cli](https://github.com/FreshRSS/FreshRSS/tree/edge/cli)
