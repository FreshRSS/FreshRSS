# Running tests

FreshRSS is tested with [PHPUnit](https://phpunit.de/). No code should be
merged in `master` if the tests don't pass.

## Locally

As a developer, you can run the test suite on your PC easily with `make`
commands. You can run the test suite with:

```console
$ make test
```

This command downloads the PHPUnit binary and verifies its checksum. If the
verification fails, the file is deleted. In this case, you should [open an
issue on GitHub](https://github.com/FreshRSS/FreshRSS/issues/new) to let
maintainers know about the problem.

Then, it executes PHPUnit in a Docker container. If you don't use Docker,
you can run the command directly with:

```console
$ NO_DOCKER=true make test
```

## Travis

Tests are automatically run when you open a pull request on GitHub. It is
done with [Travis CI](https://travis-ci.org/FreshRSS/FreshRSS/). This is
done to ensure there is no regressions in your code. We cannot merge a PR if
the tests fail so we'll ask you to fix bugs before to review your code.

If you're interested in, you can take a look at [the configuration
file](https://github.com/FreshRSS/FreshRSS/blob/master/.travis.yml).
