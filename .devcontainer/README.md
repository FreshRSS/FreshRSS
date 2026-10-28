# Dev Container for FreshRSS

This is a [Development Container](https://containers.dev) to provide a one-click full development environment
with all the needed tools and configurations, to develop and test [FreshRSS](https://github.com/FreshRSS/FreshRSS/).

It can be used on your local machine (see for instance the [Dev Containers extension for Visual Studio Code](https://marketplace.visualstudio.com/items?itemName=ms-vscode-remote.remote-containers)),
or as [GitHub Codespaces](https://github.com/features/codespaces) simply in a Web browser:

[![Open in GitHub Codespaces](https://github.com/codespaces/badge.svg)](https://github.com/codespaces/new?hide_repo_select=true&ref=edge&repo=6322699)

## Test instance of FreshRSS

A test instance of FreshRSS is automatically started as visible from the *Ports* tab: check the *Local Address* column, and click on the *Open in browser* 🌐 icon.
It runs the FreshRSS code that you are currently editing.

Apache logs can be seen in `/var/log/apache2/access.log` and `/var/log/apache2/error.log`.

## Software tests

Running the tests can be done directly from the built-in terminal, e.g.:

```sh
make test-all
```
