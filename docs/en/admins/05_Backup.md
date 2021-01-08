# Backup

This tutorial demonstrates commands for backing up FreshRSS. It assumes that your main FreshRSS directory is `/usr/share/FreshRSS`; If you've installed it somewhere else, substitute your path as necessary.

## Installation Backup

Do this before an upgrade.

### Creating a Backup

First, Enter the directory you wish to save your backup to. Here, for example, we'll save the backup to the user home directory
```
cd ~
```

Next, we'll create a gzipped tar archive of the FreshRSS directory. The following command will archive the entire contents of your FreshRSS installation in it's current state.
```
tar -czf FreshRSS-backup.tgz -C /usr/share/FreshRSS/ .
```

And you're done!

### Restoring from a Backup

First, copy the backup previously made into your FreshRSS directory
```
cp ~/FreshRSS-backup.tgz /usr/share/FreshRSS/
```

Next, change to your FreshRSS directory
```
cd /usr/share/FreshRSS/
```

Extract the backup
```
tar -xzf FreshRSS-backup.tgz
```

And optionally, as cleanup, remove the copy of your backup from the FreshRSS directory
```
rm FreshRSS-backup.tgz
```

## Backing up Feeds

### Feed list Export
You can export your feed list in OPML format either from the web interface, or from the [Command-Line Interface](https://github.com/FreshRSS/FreshRSS/blob/master/cli/README.md).

### Saving Articles

**If you are using MySQL**  
You can use [phpMyAdmin](https://www.phpmyadmin.net/) or MySQL tools, where `<db_user>` is your database username, `<db_host>` is the hostname of your web server containing your FreshRSS database, and `<freshrss_db>` is the database used by FreshRSS:
```
mysqldump --skip-comments --disable-keys --user=<db_user> --password --host <db_host> --result-file=freshrss.dump.sql --databases <freshrss_db>
```

**From any database**  
You can use the [Command-Line Interface](https://github.com/FreshRSS/FreshRSS/blob/master/cli/README.md) to export your database to a SQLite database file:
```
./cli/export-sqlite-for-user.php --user <username> --filename </path/to/db.sqlite>
```
> Note that the database filename needs the `sqlite` extension in order to work properly.

You can use the [Command-Line Interface](https://github.com/FreshRSS/FreshRSS/blob/master/cli/README.md) again to import the SQLite database file into your database:
```
./cli/import-sqlite-for-user.php --user <username> --filename </path/to/db.sqlite>
```
> Again, note that the database filename needs the `sqlite` extension in order to work properly.

The SQLite process is useful when you need to:
- export a user fully,
- backup your service,
- migrate the service to another server,
- change database type,
- fix database corruptions.
