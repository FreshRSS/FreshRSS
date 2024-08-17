# Running tests

FreshRSS is tested with [PHPUnit](https://phpunit.de/), [PHPStan](https://phpstan.org/), [PHP\_CodeSniffer](https://github.com/PHPCSStandards/PHP_CodeSniffer/), and more.
No code should be merged in `edge` if the tests don’t pass.

## Locally

As a developer, you can run the test suite on your PC easily with `make` commands. You can run the test suite with:

```sh
cd ./FreshRSS/
make test-all
```

Some syntax, formatting, whitespace, and i18n conventions can be fixed automatically with:

```sh
make fix-all
```

Some tests can run inside some Docker images, in particular to test against minimum and maximum versions of PHP:

```sh
# Prepare
make composer-test
docker build --pull --tag freshrss/freshrss:oldest -f Docker/Dockerfile-Oldest .
docker build --pull --tag freshrss/freshrss:newest -f Docker/Dockerfile-Newest .

# Run
docker run --rm -e FRESHRSS_ENV=development -e TZ=UTC -v $(pwd):/var/www/FreshRSS freshrss/freshrss:oldest bin/composer test
docker run --rm -e FRESHRSS_ENV=development -e TZ=UTC -v $(pwd):/var/www/FreshRSS freshrss/freshrss:newest bin/composer test
```

## GitHub Actions for Continuous Integration

Tests are automatically run when you open a pull request on GitHub.
They are performed with [GitHub Actions](https://github.com/FreshRSS/FreshRSS/actions).
This ensures your code will not introduce some kind of regression. We will not merge a PR if tests fail so we will ask you to fix any bugs before reviewing your code.

If you are interested, you can take a look at [the configuration file](https://github.com/FreshRSS/FreshRSS/blob/edge/.github/workflows/tests.yml).

## Using feed snapshots

As feed data is volatile, it’s better to work with snapshots when debugging some issues.
You can find the description to retrieve a snapshot [here](06_Reporting_Bugs.md#how-to-provide-feed-data).

To serve those snapshots, you can use a mock server.
Here we will demonstrate how to work with [WireMock](https://wiremock.org/) but other solutions exist.
Here are the steps to start using the WireMock mock server:

1. Go to the mock server home folder.
If you do not have one, you need to create one.
1. Inside the mock server home folder, create the ___file_ and _mappings_ folders.
1. Copy or move your snapshots in the ___file_ folder.
1. Create the _feed.json_ file in the _mappings_ folder with the following content:
	```js
	{
		"request": {
			"method": "GET",
			"urlPathPattern": "/.*"
		},
		"response": {
			"status": 200,
			"bodyFileName": "{{request.pathSegments.[0]}}",
			"transformers": ["response-template"],
			"headers": {
				"Content-Type": "application/rss+xml"
			}
		}
	}
	```
1. Launch the containerized server with the following command:
	```bash
	# <PORT> is the port used on the host to communicate with the server
	# <NETWORK> is the name of the docker network used (by default, it’s freshrss-network)
	docker run -it --rm -p <PORT>:8080 --name wiremock --network <NETWORK> -v $PWD:/home/wiremock wiremock/wiremock:latest-alpine --local-response-templating
	```
1. You can access the `<RSS>` mock file directly:
   * from the host by sending a GET request to `http://localhost:<PORT>/<RSS>`,
   * from any container connected on the same network by sending a GET request to `http://wiremock:8080/<RSS>`.
