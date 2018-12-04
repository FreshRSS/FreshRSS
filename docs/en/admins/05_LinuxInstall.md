# Installation on Debian 9/Ubuntu 16.04

This tutorial will give you step-by-step commands to install the latest stable release of FreshRSS with Apache and MySQL using git. Open a command line and follow along!

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

### TODO: Configure MySQL

Finally, restart the web server
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

### TODO: setup MySQL database for FreshRSS

You can now finish the installation from a web browser by navigating to to `http://<your_server>/p` and following the graphical prompts.