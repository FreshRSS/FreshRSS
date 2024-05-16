# Écriture d’extensions pour FreshRSS

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
* Le niveau de « hack » nécessaire pour intégrer des fonctionnalités à la marge.

Si la première limitation peut, en théorie, être levée par la participation
de nouveaux contributeurs au projet, elle est en réalité conditionnée par la
volonté des contributeurs à s’intéresser au code source du projet en
entier. Afin de lever les deux autres limitations quant à elles, il faudra
la plupart du temps passer par un « à-coté » souvent synonyme de « fork ».

Une autre solution consiste à passer par un système d’extensions. En
permettant à des utilisateurs d’écrire leur propre extension sans avoir à
s’intéresser au cœur même du logiciel de base, on permet :

1. De réduire la quantité de code source à assimiler pour un nouveau contributeur ;
2. De permettre d’intégrer des nouveautés de façon non-officielles ;
3. De se passer des développeurs principaux pour d’éventuelles améliorations
	sans passer par la case « fork ».

Note : il est tout à fait imaginable que les fonctionnalités d’une extension
puissent par la suite être intégrées dans le code initial de FreshRSS de
façon officielle. Cela permet de proposer un « proof of concept » assez
facilement.

## Minz Framework

see [Minz documentation](/docs/fr/developers/Minz/index.md)

## Écrire une extension pour FreshRSS

Nous y voilà ! Nous avons abordé les fonctionnalités les plus utiles de Minz
et qui permettent de faire tourner FreshRSS correctement et il est plus que
temps d’aborder les extensions en elles-même.

Une extension permet donc d’ajouter des fonctionnalités facilement à
FreshRSS sans avoir à toucher au cœur du projet directement.

### Travailler dans Docker

Quand on travaille sur une extension, c’est toujours plus facile de la travailler directement dans son environnement. Avec Docker, on peut exploiter l’option ```volume``` quand on démarre le conteneur. Heureusement, on peut l’utiliser sans avoir de connaissances particulières de Docker en utilisant la règle du Makefile :
```sh
make start extensions="/chemin/complet/de/l/extension/1 /chemin/complet/de/l/extension/2"
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
```html
class HelloWorldExtension extends Minz_Extension {
	public function init() {
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
* `entrypoint` : indique le point d’entrée de votre extension. Il doit
	correspondre au nom de la classe contenue dans le fichier `extension.php`
	sans le suffixe `Extension` (donc si le point d’entrée est `HelloWorld`,
	votre classe s’appellera `HelloWorldExtension`) ;
* `type` : définit le type de votre extension. Il existe deux types :
	`system` et `user`. Nous étudierons cette différence juste après.

Seuls les champs `name` et `entrypoint` sont requis.

### Choisir entre extension « system » ou « user »

A *user* extension can be enabled by some users and not by others
(typically for user preferences).

A *system* extension in comparison is enabled for every account.

### Writing your own extension.php

This file is the entry point of your extension. It must contain a specific
class to function.  As mentioned above, the name of the class must be your
`entrypoint` suffixed by `Extension` (`HelloWorldExtension` for example).
In addition, this class must be inherited from the `Minz_Extension` class to
benefit from extensions-specific methods.

Your class will benefit from four methods to redefine:

* `install()` is called when a user clicks the button to activate your
	extension. It allows, for example, to update the database of a user in
	order to make it compatible with the extension. It returns `true` if
	everything went well or, if not, a string explaining the problem.
* `uninstall()` is called when a user clicks the button to disable your
	extension. This will allow you to undo the database changes you
	potentially made in `install ()`. It returns `true` if everything went
	well or, if not, a string explaining the problem.
* `init()` is called for every page load *if the extension is enabled*. It
	will therefore initialize the behavior of the extension. This is the most
	important method.
* `handleConfigureAction()` is called when a user loads the extension
	management panel. Specifically, it is called when the
	`?c=extension&a=configured&e=name-of-your-extension` URL is loaded. You
	should also write here the behavior you want when validating the form in
	your `configure.phtml` file.

	In addition, you will have a number of methods directly inherited from
	`Minz_Extension` that you should not redefine:

* The "getters" first: most are explicit enough not to detail them here -
	`getName()`, `getEntrypoint()`, `getPath()` (allows you to retrieve the
	path to your extension), `getAuthor()`, `getDescription()`,
	`getVersion()`, `getType()`.
* `getFileUrl($filename, $type)` will return the URL to a file in the
	`static` directory. The first parameter is the name of the file (without
	`static /`), the second is the type of file to be used (`css` or `js`).
* `registerController($base_name)` will tell Minz to take into account the
	given controller in the routing system. The controller must be located in
	your `Controllers` directory, the name of the file must be `<base_name>Controller.php` and the name of the
	`FreshExtension_<base_name>_Controller` class.

> **À FAIRE**

* `registerViews()`
* `registerTranslates()`
* `registerHook($hook_name, $hook_function)`

### Le système « hooks »

You can register at the FreshRSS event system in an extensions `init()`
method, to manipulate data when some of the core functions are executed.

```php
final class HelloWorldExtension extends Minz_Extension
{
	#[\Override]
	public function init(): void {
		$this->registerHook('entry_before_display', [$this, 'renderEntry']);
		$this->registerHook('check_url_before_add', [self::class, 'checkUrl']);
	}

	public function renderEntry(FreshRSS_Entry $entry): FreshRSS_Entry {
		$message = $this->getUserConfigurationValue('message');
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

* `check_url_before_add` (`function($url) -> Url | null`): will be executed
	every time a URL is added. The URL itself will be passed as
	parameter. This way a website known to have feeds which doesn’t advertise
	it in the header can still be automatically supported.
* `entry_auto_read` (`function(FreshRSS_Entry $entry, string $why): void`):
	Appelé lorsqu’une entrée est automatiquement marquée comme lue. Le paramètre *why* supporte les règles {`filter`, `upon_reception`, `same_title_in_feed`}.
* `entry_auto_unread` (`function(FreshRSS_Entry $entry, string $why): void`):
	Appelé lorsqu’une entrée est automatiquement marquée comme non-lue. Le paramètre *why* supporte les règles {`updated_article`}.
* `entry_before_display` (`function($entry) -> Entry | null`): will be
	executed every time an entry is rendered. The entry itself (instance of
	FreshRSS\_Entry) will be passed as parameter.
* `entry_before_insert` (`function($entry) -> Entry | null`): will be
	executed when a feed is refreshed and new entries will be imported into
	the database. The new entry (instance of FreshRSS\_Entry) will be passed
	as parameter.
* `feed_before_actualize` (`function($feed) -> Feed | null`): will be
	executed when a feed is updated. The feed (instance of FreshRSS\_Feed)
	will be passed as parameter.
* `feed_before_insert` (`function($feed) -> Feed | null`): will be executed
	when a new feed is imported into the database. The new feed (instance of
	FreshRSS\_Feed) will be passed as parameter.
* `freshrss_init` (`function() -> none`): will be executed at the end of the
	initialization of FreshRSS, useful to initialize components or to do
	additional access checks
* `menu_admin_entry` (`function() -> string`): add an entry at the end of
	the "Administration" menu, the returned string must be valid HTML
	(e.g. `<li class="item active"><a href="url">New entry</a></li>`)
* `menu_configuration_entry` (`function() -> string`): add an entry at the
	end of the "Configuration" menu, the returned string must be valid HTML
	(e.g. `<li class="item active"><a href="url">New entry</a></li>`)
* `menu_other_entry` (`function() -> string`): add an entry at the end of
	the header dropdown menu (i.e. after the "About" entry), the returned
	string must be valid HTML (e.g. `<li class="item active"><a href="url">New
	entry</a></li>`)
* `nav_reading_modes` (`function($reading_modes) -> array | null`): **TODO**
	add documentation
* `post_update` (`function(none) -> none`): **TODO** add documentation
* `simplepie_before_init` (`function($simplePie, $feed) -> none`): **TODO**
	add documentation

### Writing your own configure.phtml

When you want to support user configurations for your extension or simply
display some information, you have to create the `configure.phtml` file.

> **À FAIRE**
