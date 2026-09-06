# FreshRSS tests

See our [documentation about running tests](https://freshrss.github.io/FreshRSS/en/developers/03_Running_tests.html).

```sh
make test-all
```

See [`test.yml`](../.github/workflows/tests.yml) for the GitHub Actions automated tests.

See [`composer.json`](../composer.json) for the different tests and versions, to be run locally.

## Details about this *tests* folder

Unit tests are based on [PHPUnit](https://phpunit.de/).
Here is an example of manual install:

```sh
cd ./tests/
wget -O phpunit.phar https://phar.phpunit.de/phpunit-10.phar
php phpunit.phar --bootstrap bootstrap.php
```

The `shellchecks.sh` script is used to safeguard shell scripts from common
shell script bugs and to ensure a consistent style.
It requires [ShellCheck](https://www.shellcheck.net/) and [shfmt](https://github.com/mvdan/sh).

## Entry DAO database tests

`EntryDAOTest` runs against an in-memory SQLite database by default. To run the same
tests against PostgreSQL or MySQL/MariaDB, create a test database and set
`FRESHRSS_TEST_DSN`, `FRESHRSS_TEST_USER`, and optionally `FRESHRSS_TEST_PASSWORD`:

```sh
FRESHRSS_TEST_DSN='pgsql:host=127.0.0.1;port=5432;dbname=freshrss_test' \
FRESHRSS_TEST_USER=freshrss_test \
vendor/bin/phpunit --bootstrap tests/bootstrap.php tests/app/Models/EntryDAOTest.php

# Both MySQL and MariaDB use the mysql PDO driver.
FRESHRSS_TEST_DSN='mysql:host=127.0.0.1;port=3306;dbname=freshrss_test' \
FRESHRSS_TEST_USER=freshrss_test \
vendor/bin/phpunit --bootstrap tests/bootstrap.php tests/app/Models/EntryDAOTest.php
```

The corresponding PDO extension must be installed. Each case uses a fresh connection
and temporary tables, which are removed automatically when the connection closes.
The tests exercise the actual database-specific DAO, including compressed article
content on MySQL/MariaDB and unread cache updates.
