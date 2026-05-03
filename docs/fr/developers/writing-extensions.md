---
nav_order: 100
redirect_from:
  - /en/developers/03_Backend/05_Extensions.html
---

# Writing extensions

## Présentation de FreshRSS

FreshRSS est un agrégateur de flux RSS / Atom écrit en PHP depuis octobre
2012. Le site officiel est situé à l’adresse
[freshrss.org](https://freshrss.org) et son dépot Git est hébergé par GitHub
: [github.com/FreshRSS/FreshRSS](https://github.com/FreshRSS/FreshRSS).

## Problème à résoudre

FreshRSS est limité dans ses possibilités techniques par différents facteurs
:

* La disponibilité des développeurs principaux ;
* La volonté d’intégrer certains changements ;
* Le niveau de « hack » nécessaire pour intégrer des fonctionnalités à la
  marge.

Si la première limitation peut, en théorie, être levée par la participation
de nouveaux contributeurs au projet, elle est en réalité conditionnée par la
volonté des contributeurs à s’intéresser au code source du projet en
entier. Afin de lever les deux autres limitations quant à elles, il faudra
la plupart du temps passer par un « à-coté » souvent synonyme de « fork ».

Une autre solution consiste à passer par un système d’extensions. En
permettant à des utilisateurs d’écrire leur propre extension sans avoir à
s’intéresser au cœur même du logiciel de base, on permet :

1. De réduire la quantité de code source à assimiler pour un nouveau
   contributeur ;
2. De permettre d’intégrer des nouveautés de façon non-officielles ;
3. De se passer des développeurs principaux pour d’éventuelles améliorations
   sans passer par la case « fork ».

Note : il est tout à fait imaginable que les fonctionnalités d’une extension
puissent par la suite être intégrées dans le code initial de FreshRSS de
façon officielle. Cela permet de proposer un « proof of concept » assez
facilement.

## Minz Framework

see [Minz documentation](minz.md)

## Écrire une extension pour FreshRSS

Nous y voilà ! Nous avons abordé les fonctionnalités les plus utiles de Minz
et qui permettent de faire tourner FreshRSS correctement et il est plus que
temps d’aborder les extensions en elles-même.

Une extension permet donc d’ajouter des fonctionnalités facilement à
FreshRSS sans avoir à toucher au cœur du projet directement.

### Make it work in Docker

When working on an extension, it’s easier to see it working directly in its
environment. With Docker, you can leverage the use of the ```volume```
option when starting the container. Hopefully, you can use it without
Docker-related knowledge by using the Makefile rule:
```sh
make start extensions="/full/path/to/extension/1 /full/path/to/extension/2"
```

### Les fichiers et répertoires de base

La première chose à noter est que **toutes** les extensions **doivent** se
situer dans le répertoire `extensions`, à la base de l’arborescence de
FreshRSS. Une extension est un répertoire contenant un ensemble de fichiers
et sous-répertoires obligatoires ou facultatifs. La convention veut que l’on
précède le nom du répertoire principal par un « x » pour indiquer qu’il ne
s’agit pas d’une extension incluse par défaut dans FreshRSS.

Le répertoire principal d’une extension doit comporter au moins deux
fichiers **obligatoire** :

* Un fichier `metadata.json` qui contient une description de l’extension. Ce
  fichier est écrit en JSON ;
* Un fichier `extension.php` contenant le point d’entrée de l’extension.

Please note that there is a not a required link between the directory name
of the extension and the name of the class inside `extension.php`, but you
should follow our best practice: If you want to write a `HelloWorld`
extension, the directory name should be `xExtension-HelloWorld` and the base
class name `HelloWorldExtension`.

In the file `freshrss/extensions/xExtension-HelloWorld/extension.php` you
need the structure:
```php
final class HelloWorldExtension extends Minz_Extension {
	#[\Override]
	public function init(): void {
		parent::init();

		// your code here
	}
}
```

There is an example HelloWorld extension that you can download from [our
GitHub repo](https://github.com/FreshRSS/xExtension-HelloWorld).

You may also need additional files or subdirectories depending on your
needs:

* `configure.phtml` est le fichier contenant le formulaire pour paramétrer
  votre extension
* A `static/` directory containing CSS and JavaScript files that you will
  need for your extension (note that if you need to write a lot of CSS it
  may be more interesting to write a complete theme)
* A `Controllers` directory containing additional controllers
* An `i18n` directory containing additional translations
* `layout` and `views` directories to define new views or to overwrite the
  current views

In addition, it is good to have a `LICENSE` file indicating the license
under which your extension is distributed and a `README` file giving a
detailed description of it.

### The metadata.json file

The `metadata.json` file defines your extension through a number of
important elements. It must contain a valid JSON array containing the
following entries:

* `name` : le nom de votre extension ;
* `author` : votre nom, éventuellement votre adresse mail mais il n’y a pas
  de format spécifique à adopter ;
* `description` : une description de votre extension ;
* `version` : le numéro de version actuel de l’extension ;
* `entrypoint`: Indicates the entry point of your extension. It must match the name of the class contained in the file `extension.php` without the suffix `Extension`
(so if the entry point is `HelloWorld`, your class will be called `HelloWorldExtension`)
* `type`: Defines the type of your extension. There are two types: `system` and `user`. We will study this difference right after.

Only the `name` and `entrypoint` fields are required.

### Choisir entre extension « system » ou « user »

A *user* extension can be enabled by some users and not by others (typically
for user preferences).

A *system* extension in comparison is enabled for every account.

### Writing your own extension.php

This file is the core of your extension.  It must define some key elements
to be loaded by the extension system:

1. The class name must be the `entrypoint` value defined in the
   `metadata.json` file suffixed by `Extension` (if your `entrypoint` value
   is `HelloWorld`, your class name will be `HelloWorldExtension`).
1. The class must extend the `Minz_Extension` abstract class which defines
   the core methods and properties of a FreshRSS extension.
1. The class must define the `init` method. This method is called **only**
   if the extension is loaded. Its purpose is to initialize the extension
   and its behavior during every page load.

The `Minz_Extension` abstract class defines a set of methods that can be
overridden to fit your needs: * the `install` method is called when the user
enables the extension in the configuration page. It must return `true` when
successful and a string containing an error message when not. Its purpose is
to prepare FreshRSS for the extension (adding a table to the database,
creating a folder tree, …).  * the `uninstall` method is called when the
user disables the extension in the configuration page. It must return `true`
when successful and a string containing an error message when not. Its
purpose is to clean FreshRSS (removing a table from the database, deleting a
folder tree, …). Usually it reverts changes introduced by the `install`
method.  * the `handleConfigureAction` method is called when a user loads
the extension configuration panel. It contains the logic to validate and
store the submitted values defined in the `configure.phtml` file.

> If your extension code is scattered in different classes, you need to load their source before using them. Of course you could include the files manually, but it’s more efficient to load them automatically. To do so, you just need to define the `autoload` method which will include them when needed. This method will be registered automatically when the extension is enabled.

The `Minz_Extension` abstract class defines another set of methods that should not be overridden:
* the `getName`, `getEntrypoint`, `getPath`, `getAuthor`, `getDescription`, `getVersion`, and `getType` methods return the extension internal properties. Those properties are extracted from the `metadata.json` file.
* `getFileUrl(string $filename, bool $isStatic = true): string` will return the URL to a file in the `static` directory.
	The first parameter is the name of the file (without `static/`).
	Set `$isStatic` to true for user-independent files, and to `false` for files saved in a user’s own directory.
* the `registerController` method registers an extension controller in FreshRSS. The selected controller must be defined in the extension *Controllers* folder, its file name must be `<name>Controller.php`, and its class name must be `FreshExtension_<name>_Controller`.
* the `registerViews` method registers the extension views in FreshRSS.
* the `registerTranslates` method registers the extension translation files in FreshRSS.
* the `registerHook` method registers hook actions in different part of the application.
* the `getSystemConfiguration*()` family of methods retrieve typed extension configuration values for the system.
* the `setSystemConfigurationValue()` method stores an extension configuration value for the system.
* the `removeSystemConfiguration` method removes the extension configuration for the system.
* the `getUserConfiguration*()` family of methods retrieve typed extension configuration values for the current user.
* the `setUserConfigurationValue()` method stores an extension configuration value for the current user.
* the `removeUserConfiguration` method removes the extension configuration for the current user.

> Note that if you modify the later set of methods, you might break the extension system. Thus making FreshRSS unusable. So it’s highly recommended to let those unmodified.

### Le système « hooks »

You can register at the FreshRSS event system in an extensions `init()`
method, to manipulate data when some of the core functions are executed.
The last parameter is the priority of the hook when triggered.  The hook
with the lowest priority value are triggered first.  The default priority is
0.

```php
final class HelloWorldExtension extends Minz_Extension
{
	#[\Override]
	public function init(): void {
		parent::init();

		$this->registerHook(Minz_HookType::EntryBeforeDisplay, [$this, 'renderEntry'], 10);
		$this->registerHook(Minz_HookType::CheckUrlBeforeAdd, [self::class, 'checkUrl'], -10);
	}

	public function renderEntry(FreshRSS_Entry $entry): FreshRSS_Entry {
		$message = $this->getUserConfigurationString('message');
		$entry->_content("<h1>{$message}</h1>" . $entry->content());
		return $entry;
	}

	public static function checkUrlBeforeAdd(string $url): string {
		if (str_starts_with($url, 'https://')) {
			return $url;
		}
		return null;
	}
}
```

The following events are available:

* `Minz_HookType::ActionExecute` (`function(Minz_ActionController $controller): bool`): Called before an action is executed in `Minz_Dispatcher::launchAction()`.
	By returning `true`, you allow the original action to proceed further; `false` stops further execution of the action.
	This hook can be used for adding extra functionality to an existing action. See also: `Minz_Request::is()`, `Minz_Request::controllerName()`, `Minz_Request::actionName()`.
* `Minz_HookType::ApiMisc` (`function(): void`): to allow extensions to have their own API endpoint
* `Minz_HookType::BeforeLoginBtn` (`function(): string`): Allows to insert HTML before the login button. Applies to the create button on the register page as well. Example use case is inserting a captcha widget.
* `Minz_HookType::CheckUrlBeforeAdd` (`function($url) -> Url | null`): will be executed every time a URL is added. The URL itself will be passed as parameter. This way a website known to have feeds which doesn’t advertise it in the header can still be automatically supported.
* `Minz_HookType::CustomFaviconBtnUrl` (`function(FreshRSS_Feed $feed): string | null`): Allows extensions to implement a button for setting a custom favicon for individual feeds by providing an URL. The URL will be sent a POST request with the `extAction` field set to either `query_icon_info` or `update_icon`, along with an `id` field which describes the feed's ID.
Example response for a `query_icon_info` request:
```json
{"extName":"YouTube Video Feed","iconUrl":"..\/f.php?h=40838a43"}
```
* `Minz_HookType::CustomFaviconHash` (`function(FreshRSS_Feed $feed): string
  | null`): Enables the modification of custom favicon hashes by returning
  params from the hook function. The hook should check if the
  `customFaviconExt` attribute of `$feed` is set to the extension's name
  before returning a custom value. Otherwise, the return value should be
  null.
* `Minz_HookType::EntriesFavorite` (`function(array $ids, bool $is_favorite): void`):
	will be executed when some entries are marked or unmarked as favorites (starred)
* `Minz_HookType::EntryAutoRead` (`function(FreshRSS_Entry $entry, string $why): void`): Triggered when an entry is automatically marked as read. The *why* parameter supports the rules {`filter`, `upon_reception`, `same_title_in_feed`, `same_guid_in_category`}.
* `Minz_HookType::EntryAutoUnread` (`function(FreshRSS_Entry $entry, string $why): void`): Triggered when an entry is automatically marked as unread. The *why* parameter supports the rules {`updated_article`}.
* `Minz_HookType::EntryBeforeDisplay` (`function($entry) -> Entry | null`): will be executed every time an entry is rendered. The entry itself (instance of FreshRSS\_Entry) will be passed as parameter.
* `Minz_HookType::EntryBeforeInsert` (`function($entry) -> Entry | null`): will be executed when a feed is refreshed and new entries will be imported into the database. The new entry (instance of FreshRSS\_Entry) will be passed as parameter.
* `Minz_HookType::EntryBeforeAdd` (`function($entry) -> Entry | null`): will be executed when a feed is refreshed and just before an entry is added to the database. Useful for reading the final state of the entry after filter actions have been applied. The new entry (instance of FreshRSS\_Entry) will be passed as parameter.
* `Minz_HookType::EntryBeforeUpdate` (`function($entry) -> Entry | null`): will be executed when a feed is refreshed and just before an entry is updated in the database. Useful for reading the final state of the entry after filter actions have been applied. The updated entry (instance of FreshRSS\_Entry) will be passed as parameter.
* `Minz_HookType::FeedBeforeActualize` (`function($feed) -> Feed | null`): will be executed when a feed is updated. The feed (instance of FreshRSS\_Feed) will be passed as parameter.
* `Minz_HookType::FeedBeforeInsert` (`function($feed) -> Feed | null`): will be executed when a new feed is imported into the database. The new feed (instance of FreshRSS\_Feed) will be passed as parameter.
* `Minz_HookType::FeedsListBeforeActualize` (`function(array<FreshRSS_Feed> $feedList) -> array | null`): will be executed before FreshRSS tries to update feeds. The list of feeds (array of `FreshRSS_Feed`) to update will be passed as a parameter. Useful for modifying the order in which the feeds will be updated.
* `Minz_HookType::FreshrssInit` (`function() -> none`): will be executed at the end of the initialization of FreshRSS, useful to initialize components or to do additional access checks.
* `Minz_HookType::FreshrssUserMaintenance` (`function() -> none`): will be executed for each user during the `actualize_script`, useful to run some maintenance tasks on the user.
* `Minz_HookType::JsVars` (`function($vars = array) -> array | null`): will be executed if the `jsonVars` in the header will be generated.
* `Minz_HookType::MenuAdminEntry` (`function() -> string`): add an entry at the end of the "Administration" menu, the returned string must be valid HTML (e.g. `<li class="item active"><a href="url">New entry</a></li>`).
* `Minz_HookType::MenuConfigurationEntry` (`function() -> string`): add an entry at the end of the "Configuration" menu, the returned string must be valid HTML (e.g. `<li class="item active"><a href="url">New entry</a></li>`).
* `Minz_HookType::MenuOtherEntry` (`function() -> string`): add an entry at the end of the header dropdown menu (i.e. after the "About" entry), the returned string must be valid HTML (e.g. `<li class="item active"><a href="url">New entry</a></li>`).
* `Minz_HookType::NavEntries` (`function() -> string`): will add DOM elements before the navigation buttons.
* `Minz_HookType::NavMenu` (`function() -> string`): will be executed if the navigation was built.
* `Minz_HookType::NavReadingModes` (`function($reading_modes) -> array | null`): **TODO** add documentation.
* `Minz_HookType::PostUpdate` (`function(none) -> none`): **TODO** add documentation.
* `Minz_HookType::SimplepieAfterInit` (`function(FreshRSS_SimplePieCustom $simplePie, FreshRSS_Feed $feed, bool $result): void`): Triggered after fetching an RSS/Atom feed with SimplePie. Useful for instance to get the HTTP response headers (e.g. `$simplePie->data['headers']`).
* `Minz_HookType::SimplepieBeforeInit` (`function(FreshRSS_SimplePieCustom $simplePie, FreshRSS_Feed $feed): void`): Triggered before fetching an RSS/Atom feed with SimplePie.
* `Minz_HookType::ViewModes` (`function(array<FreshRSS_ViewMode> $viewModes): array|null`): Allow extensions to register additional view modes than *normal*, *reader*, *global*.

> ℹ️ Note: the `Minz_HookType::Simplepie*` hooks are only fired for feeds using SimplePie via pull, i.e. normal RSS/Atom feeds. This excludes WebSub (push), and the various HTML or JSON Web scraping methods.

### JavaScript events

```javascript
function use_context() {
	// Something that refers to the window.context
}

if (document.readyState && document.readyState !== 'loading' && typeof window.context !== 'undefined' && typeof window.context.extensions !== 'undefined') {
	use_context();
} else {
	document.addEventListener('freshrss:globalContextLoaded', use_context, false);
}
```

The following events are available:

* `freshrss:globalContextLoaded`: will be dispatched after load the global
  `context` variable, useful for referencing variables injected with the
  `Minz_HookType::JsVars` hook.

### Injecting CDN content

When using the `init` method, it is possible to inject scripts from CDN
using the `Minz_View::appendScript` directive.  FreshRSS will include the
script in the page but will not load it since it will be blocked by the
default content security policy (**CSP**).  To amend the existing CSP, you
need to define the extension CSP policies:
```php
// in the extension.php file
protected array $csp_policies = [
	'default-src' => 'example.org',
];
```
This will only amend the extension CSP to FreshRSS CSP.

### Writing your own configure.phtml

When you want to support user configurations for your extension or simply
display some information, you have to create the `configure.phtml` file.

> **TODO**
