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
