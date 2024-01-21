# Writing extensions for FreshRSS

## About FreshRSS

FreshRSS is an RSS / Atom feed aggregator written in PHP dating back to October 2012. The official site is located at [freshrss.org](https://freshrss.org) and the official repository is hosted on Github: [github.com/FreshRSS/FreshRSS](https://github.com/FreshRSS/FreshRSS).

## The problem

FreshRSS is limited in its technical possibilities by various factors:

* The number of developers
* The will to integrate certain changes
* The level of "hacking" required to integrate marginal features

While the first limitation can, in theory, be lifted by the participation of new contributors to the project, it depends on the willingness of contributors to take an interest in the source code of the entire project. In order to remove the other two limitations, most of the time it will be necessary to create a "fork".

Another solution consists of an extension system. By allowing users to write their own extension without taking an interest in the core of the basic software, we allow for:

1. Reducing the amount of source code a new contributor has to take in
2. Unofficial integration of novelties
3. No forking or main developer approval required.

Note: it is quite conceivable that the functionalities of an extension can later be officially integrated into the FreshRSS code. Extensions make it easy to propose a proof of concept.

## Minz Framework

see [Minz documentation](/docs/en/developers/Minz/index.md)

## Write an extension for FreshRSS

Here we are! We’ve talked about the most useful features of Minz and how to run FreshRSS correctly and it’s about time to address the extensions themselves.

An extension allows you to easily add functionality to FreshRSS without having to touch the core of the project directly.

### Make it work in Docker

When working on an extension, it’s easier to see it working directly in its environment. With Docker, you can leverage the use of the ```volume``` option when starting the container. Hopefully, you can use it without Docker-related knowledge by using the Makefile rule:
```sh
make start extensions="/full/path/to/extension/1 /full/path/to/extension/2"
```

### Basic files and folders

The first thing to note is that **all** extensions **must** be located in the `extensions` directory, at the base of the FreshRSS tree.
An extension is a directory containing a set of mandatory (and optional) files and subdirectories.
The convention requires that the main directory name be preceded by an "x" to indicate that it is not an extension included by default in FreshRSS.

The main directory of an extension must contain at least two **mandatory** files:

* A `metadata.json` file that contains a description of the extension. This file is written in JSON.
* An `extension.php` file containing the entry point of the extension (which is a class that inherits Minz_Extension).

Please note that there is a not a required link between the directory name of the extension and the name of the class inside `extension.php`,
but you should follow our best practice:
If you want to write a `HelloWorld` extension, the directory name should be `xExtension-HelloWorld` and the base class name `HelloWorldExtension`.

In the file `freshrss/extensions/xExtension-HelloWorld/extension.php` you need the structure:
```php
class HelloWorldExtension extends Minz_Extension {
	public function init() {
		// your code here
	}
}
```

There is an example HelloWorld extension that you can download from [our GitHub repo](https://github.com/FreshRSS/xExtension-HelloWorld).

You may also need additional files or subdirectories depending on your needs:

* `configure.phtml` is the file containing the form to parameterize your extension
* A `static/` directory containing CSS and JavaScript files that you will need for your extension (note that if you need to write a lot of CSS it may be more interesting to write a complete theme)
* A `Controllers` directory containing additional controllers
* An `i18n` directory containing additional translations
* `layout` and `views` directories to define new views or to overwrite the current views

In addition, it is good to have a `LICENSE` file indicating the license under which your extension is distributed and a `README` file giving a detailed description of it.

### The metadata.json file

The `metadata.json` file defines your extension through a number of important elements. It must contain a valid JSON array containing the following entries:

* `name`: the name of your extension
* `author`: your name, your e-mail address … but there is no specific format to adopt
* `description`: a description of your extension
* `version`: the current version number of the extension
* `entrypoint`: Indicates the entry point of your extension. It must match the name of the class contained in the file `extension.php` without the suffix `Extension`
(so if the entry point is `HelloWorld`, your class will be called `HelloWorldExtension`)
* `type`: Defines the type of your extension. There are two types: `system` and `user`. We will study this difference right after.

Only the `name` and `entrypoint` fields are required.

### Choosing between `system` and `user`

A *user* extension can be enabled by some users and not by others (typically for user preferences).

A *system* extension in comparison is enabled for every account.

### Writing your own extension.php

This file is the core of your extension.
It must define some key elements to be loaded by the extension system:

1. The class name must be the `entrypoint` value defined in the `metadata.json` file suffixed by `Extension` (if your `entrypoint` value is `HelloWorld`, your class name will be `HelloWorldExtension`).
1. The class must extend the `Minz_Extension` abstract class which defines the core methods and properties of a FreshRSS extension.
1. The class must define the `init` method. This method is called **only** if the extension is loaded. Its purpose is to initialize the extension and its behavior during every page load.

The `Minz_Extension` abstract class defines a set of methods that can be overridden to fit your needs:
* the `install` method is called when the user enables the extension in the configuration page. It must return `true` when successful and a string containing an error message when not. Its purpose is to prepare FreshRSS for the extension (adding a table to the database, creating a folder tree, …).
* the `uninstall` method is called when the user disables the extension in the configuration page. It must return `true` when successful and a string containing an error message when not. Its purpose is to clean FreshRSS (removing a table from the database, deleting a folder tree, …). Usually it reverts changes introduced by the `install` method.
* the `handleConfigureAction` method is called when a user loads the extension configuration panel. It contains the logic to validate and store the submitted values defined in the `configure.phtml` file.

> If your extension code is scattered in different classes, you need to load their source before using them. Of course you could include the files manually, but it’s more efficient to load them automatically. To do so, you just need to define the `autoload` method which will include them when needed. This method will be registered automatically when the extension is enabled.

The `Minz_Extension` abstract class defines another set of methods that should not be overridden:
* the `getName`, `getEntrypoint`, `getPath`, `getAuthor`, `getDescription`, `getVersion`, and `getType` methods return the extension internal properties. Those properties are extracted from the `metadata.json` file.
* the `getFileUrl` returns the URL of the selected file. The file must exist in the `static` folder of the extension.
* the `registerController` method register an extension controller in FreshRSS. The selected controller must be defined in the extension *Controllers* folder, its file name must be `\<name\>Controller.php`, and its class name must be `FreshExtension_\<name\>_Controller`.
* the `registerViews` method registers the extension views in FreshRSS.
* the `registerTranslates` method registers the extension translation files in FreshRSS.
* the `registerHook` method registers hook actions in different part of the application.
* the `getSystemConfiguration` method retrieves the extension configuration for the system.
* the `setSystemConfiguration` method stores the extension configuration for the system.
* the `removeSystemConfiguration` method removes the extension configuration for the system.
* the `getUserConfiguration` method retrieves the extension configuration for the current user.
* the `setUserConfiguration` method stores the extension configuration for the current user.
* the `removeUserConfiguration` method removes the extension configuration for the current user.

> Note that if you modify the later set of methods, you might break the extension system. Thus making FreshRSS unusable. So it’s highly recommended to let those unmodified.

### The "hooks" system

You can register at the FreshRSS event system in an extensions `init()` method, to manipulate data when some of the core functions are executed.

```php
class HelloWorldExtension extends Minz_Extension
{
	public function init(): void {
		$this->registerHook('entry_before_display', [$this, 'renderEntry']);
	}
	public function renderEntry(FreshRSS_Entry $entry): FreshRSS_Entry {
		$entry->_content('<h1>Hello World</h1>' . $entry->content());
		return $entry;
	}
}
```

The following events are available:

* `check_url_before_add` (`function($url) -> Url | null`): will be executed every time a URL is added. The URL itself will be passed as parameter. This way a website known to have feeds which doesn’t advertise it in the header can still be automatically supported.
* `entry_auto_read` (`function(FreshRSS_Entry $entry, string $why): void`): Triggered when an entry is automatically marked as read. The *why* parameter supports the rules {`filter`, `upon_reception`, `same_title_in_feed`}.
* `entry_auto_unread` (`function(FreshRSS_Entry $entry, string $why): void`): Triggered when an entry is automatically marked as unread. The *why* parameter supports the rules {`updated_article`}.
* `entry_before_display` (`function($entry) -> Entry | null`): will be executed every time an entry is rendered. The entry itself (instance of FreshRSS\_Entry) will be passed as parameter.
* `entry_before_insert` (`function($entry) -> Entry | null`): will be executed when a feed is refreshed and new entries will be imported into the database. The new entry (instance of FreshRSS\_Entry) will be passed as parameter.
* `feed_before_actualize` (`function($feed) -> Feed | null`): will be executed when a feed is updated. The feed (instance of FreshRSS\_Feed) will be passed as parameter.
* `feed_before_insert` (`function($feed) -> Feed | null`): will be executed when a new feed is imported into the database. The new feed (instance of FreshRSS\_Feed) will be passed as parameter.
* `freshrss_init` (`function() -> none`): will be executed at the end of the initialization of FreshRSS, useful to initialize components or to do additional access checks.
* `freshrss_user_maintenance` (`function() -> none`): will be executed for each user during the `actualize_script`, useful to run some maintenance tasks on the user.
* `js_vars` (`function($vars = array) -> array | null`): will be executed if the `jsonVars` in the header will be generated.
* `menu_admin_entry` (`function() -> string`): add an entry at the end of the "Administration" menu, the returned string must be valid HTML (e.g. `<li class="item active"><a href="url">New entry</a></li>`).
* `menu_configuration_entry` (`function() -> string`): add an entry at the end of the "Configuration" menu, the returned string must be valid HTML (e.g. `<li class="item active"><a href="url">New entry</a></li>`).
* `menu_other_entry` (`function() -> string`): add an entry at the end of the header dropdown menu (i.e. after the "About" entry), the returned string must be valid HTML (e.g. `<li class="item active"><a href="url">New entry</a></li>`).
* `nav_menu` (`function() -> string`): will be executed if the navigation was built.
* `nav_reading_modes` (`function($reading_modes) -> array | null`): **TODO** add documentation.
* `post_update` (`function(none) -> none`): **TODO** add documentation.
* `simplepie_before_init` (`function($simplePie, $feed) -> none`): **TODO** add documentation.

### Writing your own configure.phtml

When you want to support user configurations for your extension or simply display some information, you have to create the `configure.phtml` file.

> **TODO**
