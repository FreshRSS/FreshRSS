#!/bin/sh

ln -s "$(pwd)" /var/www/FreshRSS

cp ./Docker/*.Apache.conf /etc/apache2/conf.d/

./Docker/entrypoint.sh

chown -R developer:www-data /home/developer/freshrss-data
chmod -R g+rwX /home/developer/freshrss-data

httpd -c 'ErrorLog "/var/log/apache2/error.log"' -c 'CustomLog "/var/log/apache2/access.log" combined_proxy'
