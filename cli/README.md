* Back to [main read-me](../README.md)

# FreshRSS Command-Line Interface (CLI)

## Note on access rights

When using the command-line interface, remember that your user might not be the same as the one used by your Web server.
This might create some access right problems.

It is recommended to invoke commands using the same user as your Web server:

```sh
cd /usr/share/FreshRSS
sudo -u www-data sh -c './cli/list-users.php'
```

In any case, when you are done with a series of commands, you should re-apply the access rights:

```sh
cd /usr/share/FreshRSS
sudo chown -R :www-data .
sudo chmod -R g+r .
sudo chmod -R g+w ./data/
```


## Commands

Options in parenthesis are optional.


```sh
cd /usr/share/FreshRSS

./cli/do-install.php --default_user admin --auth_type form  ( --environment production --base_url https://rss.example.net/ --title FreshRSS --allow_anonymous --api_enabled --db-type mysql --db-host localhost:3306 --db-user freshrss --db-password dbPassword123 --db-base freshrss --db-prefix freshrss )
# --auth_type can be: 'form' (recommended), 'http_auth' (using the Web server access control), 'none' (dangerous)
# --db-type can be: 'sqlite' (default), 'mysql' (MySQL or MariaDB), 'pgsql' (PostgreSQL)
# --environment can be: 'production' (default), 'development' (for additional log messages)
# --db-prefix is an optional prefix in front of the names of the tables
# This command does not create the default user. Do that with ./cli/create-user.php

./cli/create-user.php --user username ( --password 'password' --api-password 'api_password' --language en --email user@example.net --token 'longRandomString' --no-default-feeds )
# --language can be: 'en' (default), 'fr', or one of the [supported languages](../app/i18n/)

./cli/delete-user.php --user username

./cli/list-users.php
# Return a list of users, with the default/admin user first

./cli/actualize-user.php --user username

./cli/import-for-user.php --user username --filename /path/to/file.ext
# The extension of the file { .json, .opml, .xml, .zip } is used to detect the type of import

./cli/export-opml-for-user.php --user username > /path/to/file.opml.xml

./cli/export-zip-for-user.php --user username ( --max-feed-entries 100 ) > /path/to/file.zip
```
