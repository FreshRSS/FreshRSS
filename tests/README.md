# FreshRSS tests

```sh
cd ./tests/
wget https://phar.phpunit.de/phpunit.phar
php phpunit.phar --bootstrap bootstrap.php
```

The `shellchecks.sh` script is used to safeguard shell scripts from common
shell script bugs and to ensure a consistent style.
It requires [ShellCheck](https://www.shellcheck.net/) and [shfmt](https://github.com/mvdan/sh).
