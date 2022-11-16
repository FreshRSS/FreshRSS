#!/bin/sh

ln -s "$(pwd)" /var/www/FreshRSS

cp ./Docker/*.Apache.conf /etc/apache2/conf.d/

cat <<EOT >./constants.local.php
<?php
define('DATA_PATH', '/home/developer/freshrss-data');
EOT

./Docker/entrypoint.sh

chown -R developer:www-data /home/developer/freshrss-data
chmod -R g+w /home/developer/freshrss-data

httpd
