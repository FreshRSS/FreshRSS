---
applyTo: "**/*.php"
description: Editing PHP files
---

# PHP files

* See minimum PHP version and available PHP extensions in [`composer.json`](../../composer.json)
* Obey formatting rules defined in [`phpcs.xml`](../../phpcs.xml)
* Automatic fixes can be done with:
	```sh
	composer run-script fix
	# or (targeting more than just PHP)
	make fix-all
	```
* Validation can be done with:
	```sh
	composer test
	# or (targeting more than just PHP)
	make test-all
	```
* Check [`composer.json`](../../composer.json) scripts for details about available individual commands.
* For instance, running a single unit test can be done with:
	```sh
	composer run-script phpunit -- tests/app/Models/SearchTest.php
	```

## Autoloader

* `spl_autoload_register` is defined in [`lib/lib_rss.php`](../../lib/lib_rss.php)

Minimal example:

```php
require dirname(__DIR__) . '/constants.php';
require LIB_PATH . '/lib_rss.php';	//Includes class autoloader
```
