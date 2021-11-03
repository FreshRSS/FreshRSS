# Running tests

FreshRSS is tested with [PHPUnit](https://phpunit.de/). No code should be
merged in `edge` if the tests don't pass.

## Locally

As a developer, you can run the test suite on your PC easily with `make`
commands. You can run the test suite with:

```sh
make test
```

This command downloads the PHPUnit binary and verifies its checksum. If the
verification fails, the file is deleted. In this case, you should [open an
issue on GitHub](https://github.com/FreshRSS/FreshRSS/issues/new) to let
maintainers know about the problem.

Then, it executes PHPUnit in a Docker container. If you don't use Docker,
you can run the command directly with:

```sh
NO_DOCKER=true make test
```

## Intégration continue avec GitHub Actions

Les tests sont lancés automatiquement dès que vous ouvrez une « pull request » sur GitHub.
Ceux-ci sont lancés grace aux « [GitHub Actions](https://github.com/FreshRSS/FreshRSS/actions) ».
Cette action est nécessaire pour s'assurer qu'aucune régression ne soit introduite dans le code. Nous n'accepterons aucune PR si les tests ne sont pas valides, nous vous demanderons donc de corriger tout ce qui doit l'être avant de commencer à relire votre code.

Si cela vous intéresse, vous pouvez étudier [le fichier de configuration](https://github.com/FreshRSS/FreshRSS/blob/edge/.github/workflows/tests.yml).
