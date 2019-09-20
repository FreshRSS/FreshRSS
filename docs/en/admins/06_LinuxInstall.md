# Installation on Debian 9/Ubuntu 16.04

This tutorial will give you step-by-step commands to install the latest stable release of FreshRSS with Apache and MySQL using git. It's always recommended that you [backup your installation](05_Backup.md) before updating

Please note: Commands need to be run as an administrator; either perform the following from a sudo shell (`sudo -s`) or use an administrator account.

## Part 1: Setting up and configuring the LAMP stack
Begin by installing Apache, and enable Apache modules needed for FreshRSS
```
apt install apache2
a2enmod headers expires rewrite ssl
```

### TODO: configure Apache

Next, install PHP and the necessary modules
```
apt install php php-curl php-gmp php-intl php-mbstring php-sqlite3 php-xml php-zip
```

Install the PHP module for Apache
```
apt install libapache2-mod-php
```

Next, we'll need to install and configure MySQL. Install MySQL components like so:
```
sudo apt install mysql-server mysql-client php-mysql
```

MySQL must now be started:
```
service mysql-server start
```

We'll need to configure MySQL.
**Note:** As you've just installed mysql, there will be no root password; simply hit enter on the first step
```
mysql_secure_installation
```

And restart it
```
service mysql-server restart
```

Finally, restart MySQL and the web server
```

service apache2 restart
```

## Part 2: Installing FreshRSS

Begin by installing git, if you don't already have it installed.
```
apt install git
```

Next, change to the install directory and download FreshRSS using git
```
cd /usr/share/
git clone https://github.com/FreshRSS/FreshRSS.git
```

Change to the new FreshRSS directory, and set the permissions so that your Web server can access the files
```
cd FreshRSS
chown -R :www-data .
sudo chmod -R g+r .
```
We'll also need to allow the data folder to be written to, like so:
```
chmod -R g+w ./data/
```

Optional: If you would like to allow updates from the Web interface, set write permissions
```
chmod -R g+w .
```

Finally, symlink the public folder to the root of your web directory
```
ln -s /usr/share/FreshRSS/p /var/www/html/
```

## Part 3: Creating a Database for FreshRSS

Start a MySQL session. running this command will ask you for the MySQL password you set earler, and then put you into a prompt that should look like `MariaDB [(none)]>`
```
mysql -u root -p
```

From the MySQL prompt (`MariaDB [(none)]>`), run the following commands, substituting `<username>`, `<password>`, and `<database_name>` for real values.
```
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

You can now finish the installation from a web browser by navigating to to `http://<your_server>/p` and following the graphical prompts.
Alternatively, you can finish the installation using [the cli](https://github.com/FreshRSS/FreshRSS/tree/master/cli)
