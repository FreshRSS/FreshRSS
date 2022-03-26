# Backup

FreshRSS global settings are in `./data/config.php` and users' settings are in `./data/users/*/config.php`. You can also backup the whole `./data/` directory but exclude the things you do not want.

If you use extensions, than in each directory in `./extensions` the folder `static` contains the user extensions settings.

## Full-Installation Backup

Do this before an upgrade.

This following tutorial demonstrates commands for backing up FreshRSS. It assumes that your main FreshRSS directory is `/usr/share/FreshRSS`; If you’ve installed it somewhere else, substitute your path as necessary.

### Creating a Backup of all Files

First, Enter the directory you wish to save your backup to. Here, for example, we’ll save the backup to the user home directory

```sh
cd ~
```

Next, we’ll create a gzipped tar archive of the FreshRSS directory. The following command will archive the entire contents of your FreshRSS installation in it’s current state.

```sh
tar -czf FreshRSS-backup.tgz -C /usr/share/FreshRSS/ .
```

And you’re done!

### Restoring Files from a Backup

First, copy the backup previously made into your FreshRSS directory

```sh
cp ~/FreshRSS-backup.tgz /usr/share/FreshRSS/
```

Next, change to your FreshRSS directory

```sh
cd /usr/share/FreshRSS/
```

Extract the backup

```sh
tar -xzf FreshRSS-backup.tgz
```

And optionally, as cleanup, remove the copy of your backup from the FreshRSS directory

```sh
rm FreshRSS-backup.tgz
```

## Backing up Feeds

### Feed list Export

You can export your feed list in OPML format either from the web interface, or from the [Command-Line Interface](https://github.com/FreshRSS/FreshRSS/blob/edge/cli/README.md).

The OPML export only exports the standard OPML parameters and does not export things such as desired refresh frequency, custom attributes such as passwords, user agent, XPath Web scraping, etc.

To export all that, use a full back-up with export-to-sqlite, as in following sectiong is described.

### Saving Articles

**If you are using MySQL**
You can use [phpMyAdmin](https://www.phpmyadmin.net/) or MySQL tools, where `<db_user>` is your database username, `<db_host>` is the hostname of your web server containing your FreshRSS database, and `<freshrss_db>` is the database used by FreshRSS:

```sh
mysqldump --skip-comments --disable-keys --user=<db_user> --password --host <db_host> --result-file=freshrss.dump.sql --databases <freshrss_db>
```

**From any database**
You can use the [Command-Line Interface](https://github.com/FreshRSS/FreshRSS/blob/edge/cli/README.md) to export your database to a SQLite database file:

```sh
./cli/export-sqlite-for-user.php --user <username> --filename </path/to/db.sqlite>
```

> Note that the database filename needs the `sqlite` extension in order to work properly.

You can use the [Command-Line Interface](https://github.com/FreshRSS/FreshRSS/blob/edge/cli/README.md) again to import the SQLite database file into your database:

```sh
./cli/import-sqlite-for-user.php --user <username> --filename </path/to/db.sqlite>
```

> Again, note that the database filename needs the `sqlite` extension in order to work properly.

The SQLite process is useful when you need to:

- export a user fully,
- backup your service,
- migrate the service to another server,
- change database type,
- fix database corruptions.
