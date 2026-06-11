# Backup

## What to back up

- `./data/` - **required**. You can skip `cache/` and `favicons/`; FreshRSS rebuilds them.
- `./extensions/` - **recommended** if you use third-party extensions.
- `./i/themes/` - **optional**, only if you have added custom themes.
- **External database** (MySQL, MariaDB, PostgreSQL) - back up separately with [`./cli/db-backup.php`](#creating-a-database-backup) (portable SQLite per user) or `mysqldump`/`pg_dump`. SQLite is covered by `./data/` above.

All other folders belong to the source code and are restored by a fresh install or upgrade.

## Full installation backup

Do this before an upgrade.

The following commands assume your FreshRSS directory is `/usr/share/FreshRSS`; substitute your path if installed elsewhere.

> ℹ️ It is safer to stop your web server and cron during maintenance operations.

### Creating a database backup

Back up each user's database to `./data/users/*/backup.sqlite`:

```sh
cd /usr/share/FreshRSS/
./cli/db-backup.php
```

### Creating a backup of all files

Save the backup to your home directory:

```sh
cd ~
```

Create a gzipped tar archive of the FreshRSS directory:

```sh
tar -czf FreshRSS-backup.tgz -C /usr/share/FreshRSS/ .
```

### Restoring files from a backup

Extract the backup into your FreshRSS directory:

```sh
tar -xzf ~/FreshRSS-backup.tgz -C /usr/share/FreshRSS/
```

### Restoring a database backup

Restore each user's database from `./data/users/*/backup.sqlite`:

```sh
cd /usr/share/FreshRSS/
./cli/db-restore.php --delete-backup --force-overwrite
```

## Automatic periodic SQLite export

For ongoing on-server backups, separate from the one-shot `db-backup.php` / `db-restore.php` migration workflow, enable automatic SQLite export in `./data/config.php`:

```php
'auto_sqlite_export' => [
    'enabled' => true,
    'retention' => 7,
],
```

Then schedule it (for example via cron):

```sh
./cli/export-sqlite-auto.php
```

Each run writes `./data/users/<username>/sqlite-backups/<YYYYMMDDTHHMMSSZ>.sqlite` (UTC) for every user and prunes older files to the configured `retention` count.

## Migrating the database

First, back up all user databases to SQLite files:

```sh
cd /usr/share/FreshRSS/
./cli/db-backup.php
```

Change your database setup:

- to change the database type (e.g. from MySQL to PostgreSQL), edit `./data/config.php` accordingly.
- to upgrade to a major PostgreSQL version, after a PostgreSQL backup, delete the old instance and start a new one (remove the PostgreSQL volume if using Docker).

Restore all user databases from the SQLite files:

```sh
cd /usr/share/FreshRSS/
./cli/db-restore.php --delete-backup --force-overwrite
```

See also our [Docker documentation for migrating the database](https://github.com/FreshRSS/FreshRSS/blob/edge/Docker/README.md#migrate-database).

## Backing up selected content

### Feed list export

You can export your feed list in OPML format either from the web interface, or from the [command-line interface](https://github.com/FreshRSS/FreshRSS/blob/edge/cli/README.md).

The OPML export only includes the standard OPML parameters; it omits FreshRSS-specific attributes like refresh frequency, credentials, user agent, and XPath web scraping rules.

For a full export including these, use the SQLite export described below.

### Exporting your data

#### MySQL or MariaDB

You can use [phpMyAdmin](https://www.phpmyadmin.net/) or `mysqldump`. Replace `<db_user>` with your database username, `<db_host>` with your database server hostname, and `<freshrss_db>` with the FreshRSS database name:

```sh
mysqldump --skip-comments --disable-keys --user=<db_user> --password --host <db_host> --result-file=freshrss.dump.sql --databases <freshrss_db>
```

#### Any database

Export your database to a SQLite file with the [command-line interface](https://github.com/FreshRSS/FreshRSS/blob/edge/cli/README.md):

```sh
./cli/export-sqlite-for-user.php --user <username> --filename </path/to/db.sqlite>
```

Import the SQLite file back into your database:

```sh
./cli/import-sqlite-for-user.php --user <username> --filename </path/to/db.sqlite>
```

> ℹ️ The database filename must use the `.sqlite` extension for both commands to work.

The export/import flow is useful when you need to:

- fully export a user,
- back up your service,
- migrate the service to another server,
- change the database type,
- fix database corruption.
