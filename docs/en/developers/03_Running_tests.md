# Running tests

FreshRSS is tested with [PHPUnit](https://phpunit.de/). No code should be merged in `edge` if the tests don’t pass.

## Locally

As a developer, you can run the test suite on your PC easily with `make` commands. You can run the test suite with:

```sh
make test
```

This command downloads the PHPUnit binary and verifies its checksum. If the verification fails, the file is deleted. In this case, you should [open an issue on GitHub](https://github.com/FreshRSS/FreshRSS/issues/new) to let maintainers know about the problem.

Then, it executes PHPUnit in a Docker container. If you don't use Docker, you can run the command directly with:

```sh
NO_DOCKER=true make test
```

The linter can be run with a `make` command as well:

```sh
make lint # to execute the linter on the PHP files
make lint-fix # or, to fix the errors detected by the linter
```

Similarly to PHPUnit, it downloads a [PHP\_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer) binary (i.e. `phpcs` or `phpcbf` depending on the command) and verifies its checksum.

## GitHub Actions for Continuous Integration

Tests are automatically run when you open a pull request on GitHub.
They are done with [GitHub Actions](https://github.com/FreshRSS/FreshRSS/actions).
This is done to ensure there is no regressions in your code. We cannot merge a PR if the tests fail so we will ask you to fix bugs before to review your code.

If you are interested, you can take a look at [the configuration file](https://github.com/FreshRSS/FreshRSS/blob/edge/.github/workflows/tests.yml).
