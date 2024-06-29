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
sudo cli/access-permissions.sh
```


## Commands

Options in parenthesis are optional.

### System

```sh
cd /usr/share/FreshRSS

./cli/prepare.php
# Ensure the needed directories in ./data/

./cli/do-install.php --default-user admin [ --auth-type form --environment production --base-url https://rss.example.net --language en --title FreshRSS --allow-anonymous --allow-anonymous-refresh --api-enabled --db-type sqlite --db-host localhost:3306 --db-user freshrss --db-password dbPassword123 --db-base freshrss --db-prefix freshrss_ ]
# --default-user must be alphanumeric and not longer than 38 characters. The default user of this FreshRSS instance, used as the public user for anonymous reading.
# --auth-type can be: 'form' (default), 'http_auth' (using the Web server access control), 'none' (dangerous).
# --environment can be: 'production' (default), 'development' (for additional log messages).
# --base-url should be a public (routable) URL if possible, and is used for push (WebSub), for some API functions (e.g. favicons), and external URLs in FreshRSS.
# --language can be: 'en' (default), 'fr', or one of the [supported languages](../app/i18n/).
# --title web user interface title for this FreshRSS instance.
# --allow-anonymous sets whether non logged-in visitors are permitted to see the default user's feeds.
# --allow-anonymous-refresh sets whether to permit anonymous users to start the refresh process.
# --api-enabled sets whether the API may be used for mobile apps. API passwords must be set for individual users.
# --db-type can be: 'sqlite' (default), 'mysql' (MySQL or MariaDB), 'pgsql' (PostgreSQL).
# --db-host URL of the database server. Default is 'localhost'.
# --db-user sets database user.
# --db-password sets database password.
# --db-base sets database name.
# --db-prefix is an optional prefix in front of the names of the tables. We suggest using 'freshrss_' (default).
# This command does not create the default user. Do that with ./cli/create-user.php.

./cli/reconfigure.php
# Same parameters as for do-install.php. Used to update an existing installation.
```

> ℹ️ More options for [the configuration of your instance](../config.default.php#L3-L5) may be set in `./data/config.custom.php` before the install process, or in `./data/config.php` after the install process.

### User

```sh
cd /usr/share/FreshRSS

./cli/create-user.php --user username [ --password 'password' --api-password 'api_password' --language en --email user@example.net --token 'longRandomString' --no-default-feeds --purge-after-months 3 --feed-min-articles-default 50 --feed-ttl-default 3600 --since-hours-posts-per-rss 168 --max-posts-per-rss 400 ]
# --user must be alphanumeric, not longer than 38 characters. The name of the user to be created/updated.
# --password sets the user's password.
# --api-password sets the user's api password.
# --language can be: 'en' (default), 'fr', or one of the [supported languages](../app/i18n/).
# --email sets an email for the user which will be used email validation if it forced email validation is enabled.
# --no-default-feeds do not add this FreshRSS instance's default feeds to the user during creation.
# --purge-after-months max age an article can reach before being archived. Default is '3'.
# --feed-min-articles-default number of articles in a feed at which archiving will pause. Default is '50'.
# --feed-ttl-default minimum number of seconds to elapse between feed refreshes. Default is '3600'.
# --max-posts-per-rss number of articles in a feed at which an old article will be archived before a new article is added. Default is '200'.

./cli/update-user.php --user username [ ... ]
# Same options as create-user.php, except --no-default-feeds which is only available for create-user.php.
```

> ℹ️ More options for [the configuration of users](../config-user.default.php#L3-L5) may be set in `./data/config-user.custom.php` prior to creating new users, or in `./data/users/*/config.php` for existing users.

```sh
./cli/actualize-user.php --user username
# Fetch feeds for the specified user.

./cli/delete-user.php --user username
# Deletes the specified user.

./cli/list-users.php
# Return a list of users, with the default/admin user first.

./cli/user-info.php [ --human-readable --header --json --user username1 --user username2 ... ]
# -h, --human-readable display output in a human readable format
# --header outputs some columns headers.
# --json JSON format (disables --header and --human-readable but uses ISO Zulu format for dates).
# --user indicates a username, and can be repeated.
# Returns: 1) a * if the user is admin, 2) the name of the user,
#  3) the date/time of last user action, 4) the size occupied,
#  and the number of: 5) categories, 6) feeds, 7) read articles, 8) unread articles, 9) favourites, 10) tags,
#  11) language, 12) e-mail.

./cli/import-for-user.php --user username --filename /path/to/file.ext
# The extension of the file { .json, .opml, .xml, .zip } is used to detect the type of import.

./cli/export-sqlite-for-user.php --user username --filename /path/to/db.sqlite
# Export the user’s database to a new SQLite file.

./cli/import-sqlite-for-user.php --user username [ --force-overwrite ] --filename /path/to/db.sqlite
# Import the user’s database from an SQLite file.
# --force-overwrite will clear the target user database before import (import only works on an empty user database).

./cli/export-opml-for-user.php --user username > /path/to/file.opml.xml

./cli/export-zip-for-user.php --user username [ --max-feed-entries 100 ] > /path/to/file.zip
```

### Database

```sh
cd /usr/share/FreshRSS

./cli/db-backup.php
# Back-up all users respective database to `data/users/*/backup.sqlite`
# -q, --quiet suppress non-error messages

./cli/db-restore.php --delete-backup --force-overwrite
# Restore all users respective database from `data/users/*/backup.sqlite`
# --delete-backup:	delete `data/users/*/backup.sqlite` after successful import
# --force-overwrite:	will clear the users respective database before import

./cli/db-optimize.php --user username
# Optimize database (reduces the size) for a given user (perform `OPTIMIZE TABLE` in MySQL, `VACUUM` in SQLite)
```

### Translation

```sh
cd /usr/share/FreshRSS

./cli/manipulate.translation.php  --action [ --help --key --value --language --revert --origin-language ]
# manipulate translation files.
# -a, --action  selects the action to perform. (can be either: add, delete, exist, format, or ignore)
# -h, --help displays the commands help file.
# -k, --key selects the key to work on.
# -v, --value selects the value to set.
# -l, --language selects the language to work on.
# -r, --revert revert the action (only used with ignore action).
# -o, --origin-language selects the origin language (only used with add language action).

./cli/check-translation.php [ ---display-result --help --language fr --display-report ]
# Check if translation files have missing keys or missing translations.
# -d, --display-result display results of check.
# -h, --help display help text and exit.
# -l, --language set the language check.
# -r, --display-report display completion report.
```

## Note about cron

Some commands display information on standard error; cron will send an email with this information every time the command will be executed (exited zero or non-zero).

To avoid cron sending email on success:

```text
@daily /usr/local/bin/my-command > /var/log/cron-freshrss-stdout.log 2>/var/log/cron-freshrss-stderr.log || cat /var/log/cron-freshrss-stderr.log
```

Explanations:

* `/usr/local/bin/my-command > /var/log/cron-freshrss-stdout.log`_ : redirect the standard output to a log file
* `/usr/local/bin/my-command 2> /var/log/cron-freshrss-stderr.log` : redirect the standard error to a log file
* `|| cat /var/log/cron-freshrss-stderr.log_ : if the exit code of _/usr/local/bin/my-command` is non-zero, then it send by mail the content error file.

Now, cron will send you an email only if the exit code is non-zero and with the content of the file containing the errors.


## Unix piping

It is possible to invoke a command multiple times, e.g. with different usernames, thanks to the `xargs -n1` command.
Example showing user information for all users which username starts with ‘a’:

```sh
./cli/list-users.php | grep '^a' | xargs -n1 ./cli/user-info.php -h --user
```

Example showing all users ranked by date of last activity:

```sh
./cli/user-info.php -h | sort -k2 -r
```

Example to get the number of feeds of a given user:

```sh
./cli/user-info.php --user alex | cut -f6
#or
./cli/user-info.php --user alex --json | jq '.[] | .feeds'
```

Example to get the name of the users who have not been active since a given date:

```sh
cli/user-info.php --json | jq '.[] | select(.last_user_activity < "2020-05-01") | .user'
```

Example to get the date and name of users who have not been active the past 24 hours (86400 seconds):

```sh
cli/user-info.php --json | jq -r '.[] | select((.last_user_activity | fromdate) < (now - 86400)) | [.last_user_activity, .user] | @csv'
```

# Install and updates

If you want to administrate FreshRSS using git, please read our [installation docs](https://freshrss.github.io/FreshRSS/en/admins/03_Installation.html)
and [update guidelines](https://freshrss.github.io/FreshRSS/en/admins/04_Updating.html).
