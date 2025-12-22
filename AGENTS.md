---
description: Coding instructions for FreshRSS contributors and AI agents
---

# FreshRSS Coding Instructions

## Architecture Overview

FreshRSS is a self-hosted RSS aggregator built on **Minz**, a custom lightweight MVC framework in `lib/Minz/`.
The application follows a traditional MVC pattern with these key directories:

- **`app/Controllers/`** – Controllers extend `FreshRSS_ActionController` (which extends `Minz_ActionController`). Named as `{name}Controller.php` with class `FreshRSS_{name}_Controller`
- **`app/Models/`** – Domain models extend `Minz_Model`. DAOs follow database-specific inheritance: `*DAO.php` (base) → `*DAOSQLite.php`, `*DAOPGSQL.php`
- **`app/views/{controller}/`** – View templates are `.phtml` files mixing PHP and HTML
- **`lib/Minz/`** – Core framework: routing, sessions, translations, extensions, PDO abstraction
- **`p/`** – Public web root (only the content of this folder should be exposed). Entry point is `p/i/index.php`

## Naming Conventions

- **Classes**: Use `FreshRSS_` prefix for app classes, `Minz_` for framework classes
- **Controllers**: `FreshRSS_{name}_Controller` in `{name}Controller.php`
- **Models/DAOs**: `FreshRSS_{Entity}` and `FreshRSS_{Entity}DAO` with database-specific variants
- **View helpers**: `$this->partial('name')` loads from `app/views/helpers/`
- **Method prefixes**: `_methodName()` indicates internal/private-like usage (convention, not enforced)

## Translation System (i18n)

Translations live in `app/i18n/{lang}/` as PHP arrays. Use `_t('key.subkey')` in code/views:

```php
_t('gen.action.save')  // Returns translated string
_i('configure')        // Returns icon HTML with translation
```

To add/modify translations, use Makefile targets:
```sh
make i18n-add-key key=gen.action.new_key value="Default English"
make i18n-format  # Formats all i18n files
```

## Development Commands

```sh
# Start development server (Docker, see Docker/README.md for details)
make start          # Runs on http://localhost:8080

# Testing - easiest way to run everything
make test-all       # Runs all tests: PHPUnit, PHPCS, PHPStan, typos

# Auto-fix trivial issues (whitespace, RTL CSS, translations)
make fix-all        # Recommended before committing

# See also:
make help
```

Targeted tests can also be run via:
- `composer` - see [`composer.json`](composer.json) scripts (PHPUnit, PHPSta, PHPCS)
- `npm` - see [`package.json`](package.json) scripts (ESLint, Markdownlint, Stylelint)

A Dev Container is available under [`.devcontainer/`](`.devcontainer/`).

CI/CD is defined in [`.github/workflows/tests.yml`](.github/workflows/tests.yml)

More documentation:
- [`docs/en/`](./docs/en/), published at <https://freshrss.github.io/FreshRSS/>
- [Docker](Docker/README.md)
- [CLI](cli/README.md)

## Code Style

- **Indentation**: Obey [`.editorconfig`](.editorconfig) (some of it can be automatically fixed with `make fix-all`)
- **PHP**:
	- Obey [`phpcs.xml`](./phpcs.xml)
	- See minimum PHP version and available PHP extensions in [`composer.json`](composer.json)
	- `spl_autoload_register` is defined in [`lib/lib_rss.php`](lib/lib_rss.php)
- **JavaScript**: Obey [`eslint.config.js`](eslint.config.js)
- **CSS**: Obey [`.stylelintrc.json`](.stylelintrc.json)
- **Markdown**: Obey [`.markdownlint.json`](.markdownlint.json)

## Extension System

Extensions in `extensions/` or `lib/core-extensions/` extend `Minz_Extension`. Each needs:
- `metadata.json` with name, entrypoint, author, description
- Main class extending `Minz_Extension` with `init()` method
- Register hooks via `Minz_ExtensionManager::callHook()`

## Database Patterns

Three database backends supported: SQLite, PostgreSQL, MySQL/MariaDB.
The SQL differences are implemented through inheritance:
```php
// Base DAO with common queries
class FreshRSS_EntryDAO extends Minz_ModelPdo { }
// Database-specific overrides
class FreshRSS_EntryDAOSQLite extends FreshRSS_EntryDAO { }
class FreshRSS_EntryDAOPGSQL extends FreshRSS_EntryDAO { }
```

Factory pattern selects correct DAO:
```php
FreshRSS_Factory::createEntryDao();
```

In database, most VARCHAR/TEXT fields are HTML-encoded,
except `attributes` fields, which contain JSON, and which sub-strings are not HTML-encoded.

## Configuration

- **System config**: `data/config.php` (from `config.default.php`)
- **User config**: `data/users/{username}/config.php` (from `config-user.default.php`)
- **Constants**: Override via `constants.local.php`
- Access via `FreshRSS_Context::systemConf()` and `FreshRSS_Context::userConf()`

## CLI Tools

Scripts in `cli/` for admin tasks. Run as web server user:
```sh
sudo -u www-data ./cli/list-users.php
sudo -u www-data ./cli/actualize-user.php --user username
./cli/access-permissions.sh  # Fix permissions after CLI operations
```

## Key Integration Points

- **Feed fetching**: `app/Models/SimplePieCustom.php` wraps SimplePie library
- **Google Reader API**: Primary API for mobile clients (`p/api/greader.php`). See `docs/en/developers/06_GoogleReader_API.md` for protocol details and compatible clients
- **Fever API**: Legacy API (`p/api/fever.php`), less powerful than Google Reader
- **WebSub/PubSubHubbub**: Real-time push (`p/api/pshb.php`)
- **Themes**: `p/themes/` with `metadata.json` and CSS files
