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

./cli/prepare.php
# Ensure the needed directories in ./data/

./cli/do-install.php --default_user admin [ --auth_type form --environment production --base_url https://rss.example.net --language en --title FreshRSS --allow_anonymous --api_enabled --db-type mysql --db-host localhost:3306 --db-user freshrss --db-password dbPassword123 --db-base freshrss --db-prefix freshrss ]
# --auth_type can be: 'form' (default), 'http_auth' (using the Web server access control), 'none' (dangerous)
# --db-type can be: 'sqlite' (default), 'mysql' (MySQL or MariaDB), 'pgsql' (PostgreSQL)
# --base_url should be a public (routable) URL if possible, and is used for push (WebSub), for some API functions (e.g. favicons), and external URLs in FreshRSS.
# --environment can be: 'production' (default), 'development' (for additional log messages)
# --language can be: 'en' (default), 'fr', or one of the [supported languages](../app/i18n/)
# --db-prefix is an optional prefix in front of the names of the tables. We suggest using 'freshrss_'
# This command does not create the default user. Do that with ./cli/create-user.php

./cli/reconfigure.php
# Same parameters as for do-install.php. Used to update an existing installation.

./cli/create-user.php --user username [ --password 'password' --api_password 'api_password' --language en --email user@example.net --token 'longRandomString' --no_default_feeds --purge_after_months 3 --feed_min_articles_default 50 --feed_ttl_default 3600 --since_hours_posts_per_rss 168 --max_posts_per_rss 400 ]
# --language can be: 'en' (default), 'fr', or one of the [supported languages](../app/i18n/)

./cli/update-user.php --user username [ ... ]
# Same options as create-user.php, except --no_default_feeds which is only available for create-user.php

./cli/actualize-user.php --user username
# Fetch feeds for the specified user

./cli/delete-user.php --user username

./cli/list-users.php
# Return a list of users, with the default/admin user first

./cli/user-info.php -h --user username
# -h is to use a human-readable format
# --user can be a username, or '*' to loop on all users
# Returns: 1) a * iff the user is admin, 2) the name of the user,
#  3) the date/time of last user action, 4) the size occupied,
#  and the number of: 5) categories, 6) feeds, 7) read articles, 8) unread articles, 9) favourites, and 10) tags

./cli/import-for-user.php --user username --filename /path/to/file.ext
# The extension of the file { .json, .opml, .xml, .zip } is used to detect the type of import

./cli/export-sqlite-for-user.php --user username --filename /path/to/db.sqlite
# Export the user’s database to a new SQLite file.

./cli/import-sqlite-for-user.php --user username [ --force-overwrite ] --filename /path/to/db.sqlite
# Import the user’s database from an SQLite file.
# --force-overwrite will clear the target user database before import (import only works on an empty user database)

./cli/export-opml-for-user.php --user username > /path/to/file.opml.xml

./cli/export-zip-for-user.php --user username [ --max-feed-entries 100 ] > /path/to/file.zip

./cli/db-optimize.php --user username
# Optimize database (reduces the size) for a given user (perform `OPTIMIZE TABLE` in MySQL, `VACUUM` in SQLite)
```

#### Note about cron

Some commands display informations on standard error, cron will send an email with thoses informations every time the command will be executed (exited zero or non-zero).

To avoid cron sending email on success:
```sh
@daily /usr/local/bin/my-command > /var/log/cron-freshrss-stdout.log 2>/var/log/cron-freshrss-stderr.log || cat /var/log/cron-freshrss-stderr.log
```

Explanations:
- _/usr/local/bin/my-command > /var/log/cron-freshrss-stdout.log_ : redirect the standard output to a log file
- _/usr/local/bin/my-command 2> /var/log/cron-freshrss-stderr.log_ : redirect the standard error to a log file
- _|| cat /var/log/cron-freshrss-stderr.log_ : if the exit code of _/usr/local/bin/my-command_ is non-zero, then it send by mail the content error file.

Now, cron will send you an email only if the exit code is non-zero and with the content of the file containing the errors.


## Unix piping

It is possible to invoke a command multiple times, e.g. with different usernames, thanks to the `xargs -n1` command.
Example showing user information for all users which username starts with 'a':

```sh
./cli/list-users.php | grep '^a' | xargs -n1 ./cli/user-info.php -h --user
```

Example showing all users ranked by date of last activity:

```sh
./cli/user-info.php -h --user '*' | sort -k2 -r
```

Example to get the number of feeds of a given user:

```sh
./cli/user-info.php --user alex | cut -f6
```


# Install and updates

If you want to administrate FreshRSS using git, please read our [installation docs](https://freshrss.github.io/FreshRSS/en/admins/02_Installation.html)
and [update guidelines](https://freshrss.github.io/FreshRSS/en/admins/03_Updating.html).
