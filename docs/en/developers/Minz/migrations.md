# How to manage migrations with Minz

Migrations are the way to modify the database or the structure of files under the `data/` path.

## How to write a migration?

Migrations are placed under the `app/migrations` folder.

Good practice is to prepend the filename by the current date and explain what does the migration do in few words (e.g. `2020_01_11_CreateFooTable.php`).

The files must contain a class which name starts with `FreshRSS_Migration_`, followed by the basename of the file (e.g. `FreshRSS_Migration_2020_01_11_CreateFooTable`).

The class must declare a `migrate` static function. It must return `true` or a string to indicate the migration is applied, or `false` otherwise. It can also raise an exception: the message will be used to detail the error.

Example:

```php
// File: app/migrations/2020_01_11_CreateFooTable.php
class FreshRSS_Migration_2020_01_11_CreateFooTable {
	public static function migrate() {
		$pdo = new Minz_PdoSqlite('sqlite:/some/path/db.sqlite');
		$result = $pdo->exec('CREATE TABLE foos (bar TEXT)');
		if ($result === false) {
			$error = $pdo->errorInfo();
			raise Exception('Error in SQL statement: ' . $error[2]);
		}

		return true;
	}
}
```

## How to apply migrations?

They are automatically applied one by one when a user accesses FreshRSS.

Before being applied, migrations are sorted by filenames (see the [`strnatcmp`](https://php.net/strnatcmp) function). Already applied migrations are skipped (the list can be found in the `data/applied_migrations.txt` file).

To ensure migrations are not applied several times if two users access FreshRSS at the same time, a folder named `data/applied_migrations.txt.lock` is created, then deleted at the end of the process.
