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

./cli/do-install.php --default_user admin ( --auth_type form --environment production --base_url https://rss.example.net/ --language en --title FreshRSS --allow_anonymous --api_enabled --db-type mysql --db-host localhost:3306 --db-user freshrss --db-password dbPassword123 --db-base freshrss --db-prefix freshrss )
# --auth_type can be: 'form' (default), 'http_auth' (using the Web server access control), 'none' (dangerous)
# --db-type can be: 'sqlite' (default), 'mysql' (MySQL or MariaDB), 'pgsql' (PostgreSQL)
# --environment can be: 'production' (default), 'development' (for additional log messages)
# --language can be: 'en' (default), 'fr', or one of the [supported languages](../app/i18n/)
# --db-prefix is an optional prefix in front of the names of the tables. We suggest using 'freshrss_'
# This command does not create the default user. Do that with ./cli/create-user.php

./cli/reconfigure.php
# Same parameters as for do-install.php. Used to update an existing installation.

./cli/create-user.php --user username ( --password 'password' --api_password 'api_password' --language en --email user@example.net --token 'longRandomString' --no_default_feeds --purge_after_months 3 --feed_min_articles_default 50 --feed_ttl_default 3600 --since_hours_posts_per_rss 168 --min_posts_per_rss 2 --max_posts_per_rss 400 )
# --language can be: 'en' (default), 'fr', or one of the [supported languages](../app/i18n/)

./cli/update-user.php --user username ( ... )
# Same options as create-user.php, except --no_default_feeds which is only available for create-user.php

./cli/delete-user.php --user username

./cli/list-users.php
# Return a list of users, with the default/admin user first

./cli/actualize-user.php --user username

./cli/import-for-user.php --user username --filename /path/to/file.ext
# The extension of the file { .json, .opml, .xml, .zip } is used to detect the type of import

./cli/export-opml-for-user.php --user username > /path/to/file.opml.xml

./cli/export-zip-for-user.php --user username ( --max-feed-entries 100 ) > /path/to/file.zip

./cli/user-info.php -h --user username
# -h is to use a human-readable format
# --user can be a username, or '*' to loop on all users
# Returns: 1) a * iff the user is admin, 2) the name of the user,
#  3) the date/time of last user action, 4) the size occupied,
#  and the number of: 5) categories, 6) feeds, 7) read articles, 8) unread articles, and 9) favourites
```


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

## Using git

If you manage FreshRSS via command line, then installing and updating FreshRSS can be done via git:

```sh
# If your local user does not have write access, prefix all commands by sudo:
sudo ...

# Install FreshRSS
cd /usr/share/
git clone https://github.com/FreshRSS/FreshRSS.git

# Perform all commands below in your FreshRSS directory:
cd /usr/share/FreshRSS

# Use the development version of FreshRSS
git checkout -b dev origin/dev

# Check out a specific version of FreshRSS
# See release names on https://github.com/FreshRSS/FreshRSS/releases
# You will then need to manually change version
# or checkout master or dev branch to get new versions
git checkout 1.7.0

# Verify what branch is used
git branch

# Check whether there is a new version of FreshRSS,
# assuming you are on the /master or /dev branch
git fetch --all
git status

# Discard manual changes (do a backup before)
git reset --hard
# Then re-delete the file forcing the setup wizard
rm data/do-install.txt

# Delete manual additions (do a backup before)
git clean -f -d

# Update to a newer version of FreshRSS,
# assuming you are on the /master or /dev branch
git pull

# Set the rights so that your Web server can access the files
# (Example for Debian / Ubuntu)
chown -R :www-data . && chmod -R g+r . && chmod -R g+w ./data/
```
