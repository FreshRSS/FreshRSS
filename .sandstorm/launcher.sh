#!/bin/bash

# Create a bunch of folders under the clean /var that php, nginx, and mysql expect to exist
mkdir -p /var/lib/mysql
mkdir -p /var/lib/nginx
mkdir -p /var/lib/php5/sessions
mkdir -p /var/log
mkdir -p /var/log/mysql
mkdir -p /var/log/nginx
# Wipe /var/run, since pidfiles and socket files from previous launches should go away
# TODO someday: I'd prefer a tmpfs for these.
rm -rf /var/run
mkdir -p /var/run
mkdir -p /var/run/mysqld

cp -R /opt/app/data /var/
mkdir -p /var/data/users/sandcat
cp /var/data/users/_/config.default.php /var/data/users/sandcat/config.php


app_salt=$(dd if=/dev/urandom bs=1 count=200 2> /dev/null | tr -c -d 'A-Za-z0-9' | sed -n 's/\(.\{40\}\).*/\1/p')
cp /opt/app/.sandstorm/config.php /var/data/config.php
sudo sed -i "s/sandsalt/$app_salt/g" /var/data/config.php

rm /var/data/do-install.txt

# Ensure mysql tables created
HOME=/etc/mysql /usr/bin/mysql_install_db --force

# Spawn mysqld, php
HOME=/etc/mysql /usr/sbin/mysqld &


/usr/sbin/php5-fpm --nodaemonize --fpm-config /etc/php5/fpm/php-fpm.conf &
# Wait until mysql and php have bound their sockets, indicating readiness
while [ ! -e /var/run/mysqld/mysqld.sock ] ; do
    echo "waiting for mysql to be available at /var/run/mysqld/mysqld.sock"
    sleep .2
done
echo "create database freshrss" | mysql -u root
mysql -u root < /opt/app/SQL/raw.sql
while [ ! -e /var/run/php5-fpm.sock ] ; do
    echo "waiting for php5-fpm to be available at /var/run/php5-fpm.sock"
    sleep .2
done

# Start nginx.
/usr/sbin/nginx -g "daemon off;"
