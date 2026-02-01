---
description: FreshRSS introduction and conventions for AI agents and human contributors
---

# FreshRSS introduction and conventions

FreshRSS is an open-source news aggregator supporting RSS/ATOM/WebSub and also Web scraping.

The market segment is mostly self-hosting, although multiple user accounts are supported.
It is supposed to be installed on a modest server (mostly, but not limited to, Linux) and can be accessed through a Web UI and an API.

It is written in PHP to make it easy to deploy and easy to contribute to.

More information can be found in [README](README.md) and in the [documentation](docs/en/) published at <https://freshrss.github.io/FreshRSS/en/>

## Instruction structure for AI agents and humans

* [`.github/instructions/`](.github/instructions/) contain the instructions that primarily match filename patterns.
* [`.github/skills/`](.github/skills/) contain the skills to achieve higher-level goals, potentially combining multiple instructions.
* **`AGENTS.md`** is the entry point description for AI coding agents and contributors, referencing other documents such as instructions and skills.
* Favour standard conventions over vendor-specific ones.
* To reduce duplication, refer to enforceable configuration files instead of excessive free-text repetitions.

## Code structure

* `app/Controllers/` – Controllers extend `FreshRSS_ActionController`, named as `{name}Controller.php` with class `FreshRSS_{name}_Controller`
* `app/Models/` – Domain models extend `Minz_Model`.
	* DAOs may have some database-specific inheritance, e.g.: `*DAO.php` (base or MySQL), `*DAOSQLite.php` (SQLite), `*DAOPGSQL.php` (PostgreSQL)
* `app/views/{controller}/` – View templates are `.phtml` files mixing PHP and HTML
* `app/views/helpers/` – Reusable view elements with `$this->partial('name')`
* `lib/core-extensions/` or `extensions/` – FreshRSS extensions
* `lib/Minz/` – Core framework: routing, sessions, translations, extensions, PDO abstraction
* `lib/lib_rss.php` – Contain `spl_autoload_register` and other global functions
* `p/` – Public Web root. Only the content of this folder should be exposed if possible (`p/` should not be visible in the public URL)
	* Only the `p/i/` path should be access controlled. The main entry point is `p/i/index.php`
	* `p/api/greader.php` – Primary API for mobile clients
	* `p/api/pshb.php` – Receive realtime pushes via WebSub
	* `p/themes/` – UI themes

### Configuration data

* Constants: [`constants.php`](constants.php) overridden in `constants.local.php`
* System config: [`config.default.php`](config.default.php) overridden in `data/config.php`
* User config: [`config-user.default.php`](config-user.default.php) overridden in `data/users/{username}/config.php`

> ℹ Access via `FreshRSS_Context::systemConf()` and `FreshRSS_Context::userConf()`

## Database patterns

Three database backends supported: SQLite, PostgreSQL, MySQL/MariaDB.
The SQL differences are implemented through inheritance:

```php
// Base DAO with common queries
class FreshRSS_EntryDAO extends Minz_ModelPdo { }
// Database-specific overrides
class FreshRSS_EntryDAOSQLite extends FreshRSS_EntryDAO { }
class FreshRSS_EntryDAOPGSQL extends FreshRSS_EntryDAO { }
```

A factory pattern selects the correct DAO, e.g.:

```php
FreshRSS_Factory::createEntryDao();
```

**Important**: in database, VARCHAR/TEXT fields are HTML-encoded, except `attributes` fields, which contain JSON, and which sub-strings are not HTML-encoded.

## Main development commands

> ℹ Recommended before committing

```sh
# Runs all tests: PHPUnit, PHPCS, PHPStan, typos
make test-all

# Auto-fix all trivial issues: whitespace, RTL CSS, translations
make fix-all

# See a list of commands:
make help
```

CI/CD is defined in [`.github/workflows/tests.yml`](.github/workflows/tests.yml)

A Dev Container is available under [`.devcontainer/`](.devcontainer/).

## Docker

> ℹ Check [Docker documentation](Docker/README.md).

## CLI Tools

There are scripts in `cli/` for admin tasks, such as:

```sh
./cli/list-users.php
```

> ℹ Check [CLI documentation](cli/README.md).

When possible, it is best to run as Web server user:

```sh
sudo -u www-data cli/actualize-user.php --user alice
```

or at least re-apply the file permissions after CLI operations:

```sh
cli/access-permissions.sh
```
