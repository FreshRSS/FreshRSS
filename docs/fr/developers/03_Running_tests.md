# Running tests

FreshRSS is tested with [PHPUnit](https://phpunit.de/). No code should be
merged in `master` if the tests don't pass.

## Locally

As a developer, you can run the test suite on your PC easily with `make`
commands. First, you should install PHPUnit with:

```console
$ make bin/phpunit
```

This commands download the binary and verify its checksum. If the
verification fails, the file is deleted. In this case, you should [open an
issue on GitHub](https://github.com/FreshRSS/FreshRSS/issues/new) to let
maintainers know about the problem.

Then, you can run the test suite with:

```console
$ make tests
```

It executes PHPUnit in a Docker container. If you don't use Docker, you can
run the command directly with:

```console
$ php ./bin/phpunit --bootstrap ./tests/bootstrap.php ./tests
```

If the command fails, you can take a look at the Makefile to verify if the
command had changed.

## Travis

Tests are automatically run when you open a pull request on GitHub. It is
done with [Travis CI](https://travis-ci.org/FreshRSS/FreshRSS/). This is
done to ensure there is no regressions in your code. We cannot merge a PR if
the tests fail so we'll ask you to fix bugs before to review your code.

If you're interested in, you can take a look at [the configuration
file](https://github.com/FreshRSS/FreshRSS/blob/master/.travis.yml).
