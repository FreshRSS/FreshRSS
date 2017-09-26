# Writing extensions for FreshRSS

## About FreshRSS

FreshRSS is an RSS / Atom feeds aggregator written in PHP since October 2012. The official site is located at [freshrss.org](https://freshrss.org) and its repository is hosted by Github: [github.com/FreshRSS/FreshRSS](https://github.com/FreshRSS/FreshRSS).

## Problem to solve

**TODO** translate from [french version](https://github.com/FreshRSS/documentation/blob/master/fr/docs/developers/03_Backend/05_Extensions.md)

## Understanding basic mechanics (Minz and MVC)

**TODO** : move to 02_Minz.md

**TODO** translate from [french version](https://github.com/FreshRSS/documentation/blob/master/fr/docs/developers/03_Backend/05_Extensions.md)

### MVC Architecture

**TODO** translate from [french version](https://github.com/FreshRSS/documentation/blob/master/fr/docs/developers/03_Backend/05_Extensions.md)

### Routing

**TODO** translate from [french version](https://github.com/FreshRSS/documentation/blob/master/fr/docs/developers/03_Backend/05_Extensions.md)

Code example:

```php
<?php

class FreshRSS_hello_Controller extends Minz_ActionController {
    public function indexAction() {
        $this->view->a_variable = 'FooBar';
    }

    public function worldAction() {
        $this->view->a_variable = 'Hello World!';
    }
}

?>
```

**TODO** translate from [french version](https://github.com/FreshRSS/documentation/blob/master/fr/docs/developers/03_Backend/05_Extensions.md)

### Views

**TODO** translate from [french version](https://github.com/FreshRSS/documentation/blob/master/fr/docs/developers/03_Backend/05_Extensions.md)

Code example:

```html
<p>
    This is a parameter passed from the controller: <?php echo $this->a_variable; ?>
</p>
```

**TODO** translate from [french version](https://github.com/FreshRSS/documentation/blob/master/fr/docs/developers/03_Backend/05_Extensions.md)

### Working with GET / POST

**TODO** translate from [french version](https://github.com/FreshRSS/documentation/blob/master/fr/docs/developers/03_Backend/05_Extensions.md)

Code example:

```php
<?php

$default_value = 'foo';
$param = Minz_Request::param('bar', $default_value);

// Display the value of the parameter `bar` (passed via GET or POST)
// or "foo" if the parameter does not exist.
echo $param;

// Sets the value of the `bar` parameter
Minz_Request::_param('bar', 'baz');

// Will necessarily display "baz" since we have just forced its value.
// Note that the second parameter (default) is optional.
echo Minz_Request::param('bar');

?>
```

**TODO** translate from [french version](https://github.com/FreshRSS/documentation/blob/master/fr/docs/developers/03_Backend/05_Extensions.md)

### Access session settings

**TODO** translate from [french version](https://github.com/FreshRSS/documentation/blob/master/fr/docs/developers/03_Backend/05_Extensions.md)

### Working with URLs

**TODO** translate from [french version](https://github.com/FreshRSS/documentation/blob/master/fr/docs/developers/03_Backend/05_Extensions.md)

```html
<p>
    Go to page <a href="http://example.com?c=hello&amp;a=world">Hello world</a>!
</p>
```

**TODO** translate from [french version](https://github.com/FreshRSS/documentation/blob/master/fr/docs/developers/03_Backend/05_Extensions.md)

```php
<?php

$url_array = array(
    'c' => 'hello',
    'a' => 'world',
    'params' => array(
        'foo' => 'bar',
    )
);

// Show something like .?c=hello&amp;a=world&amp;foo=bar
echo Minz_Url::display($url_array);

?>
```

**TODO** translate from [french version](https://github.com/FreshRSS/documentation/blob/master/fr/docs/developers/03_Backend/05_Extensions.md)

```php
<?php

// Displays the same as above
echo _url('hello', 'world', 'foo', 'bar');

?>
```

**TODO** translate from [french version](https://github.com/FreshRSS/documentation/blob/master/fr/docs/developers/03_Backend/05_Extensions.md)

### Redirections

**TODO** translate from [french version](https://github.com/FreshRSS/documentation/blob/master/fr/docs/developers/03_Backend/05_Extensions.md)

Code example:

```php
<?php

$url_array = array(
    'c' => 'hello',
    'a' => 'world'
);

// Tells Minz to redirect the user to the hello / world page.
// Note that this is a redirection in the Minz sense of the term, not a redirection that the browser will have to manage (HTTP code 301 or 302)
// The code that follows forward() will thus be executed!
Minz_Request::forward($url_array);

// To perform a type 302 redirect, add "true".
// The code that follows will never be executed.
Minz_Request::forward($url_array, true);

?>
```

**TODO** translate from [french version](https://github.com/FreshRSS/documentation/blob/master/fr/docs/developers/03_Backend/05_Extensions.md)

```php
<?php

$url_array = array(
    'c' => 'hello',
    'a' => 'world'
);
$feedback_good = 'Tout s\'est bien passé !';
$feedback_bad = 'Oups, quelque chose n\'a pas marché.';

Minz_Request::good($feedback_good, $url_array);

// or

Minz_Request::bad($feedback_bad, $url_array);

?>
```

### Translation Management

**TODO** translate from [french version](https://github.com/FreshRSS/documentation/blob/master/fr/docs/developers/03_Backend/05_Extensions.md)

```php
<?php

return array(
    'action' => array(
        'actualize' => 'Actualiser',
        'back_to_rss_feeds' => '← Retour à vos flux RSS',
        'cancel' => 'Annuler',
        'create' => 'Créer',
        'disable' => 'Désactiver',
    ),
    'freshrss' => array(
        '_' => 'FreshRSS',
        'about' => 'À propos de FreshRSS',
    ),
);

?>
```

**TODO** translate from [french version](https://github.com/FreshRSS/documentation/blob/master/fr/docs/developers/03_Backend/05_Extensions.md)

Code example:

```html
<p>
    <a href="<?php echo _url('index', 'index'); ?>">
        <?php echo _t('gen.action.back_to_rss_feeds'); ?>
    </a>
</p>
```

**TODO** translate from [french version](https://github.com/FreshRSS/documentation/blob/master/fr/docs/developers/03_Backend/05_Extensions.md)

### Configuration management

**TODO** translate from [french version](https://github.com/FreshRSS/documentation/blob/master/fr/docs/developers/03_Backend/05_Extensions.md)

## Write an extension for FreshRSS

Here we are! We've talked about the most useful features of Minz and how to run FreshRSS correctly and it's about time to address the extensions themselves.

An extension allows you to add functionality easily to FreshRSS without having to touch the core of the project directly.

### Basic files and folders

The first thing to note is that **all** extensions **must** be located in the `extensions` directory, at the base of the FreshRSS tree. 
An extension is a directory containing a set of mandatory (and optional) files and subdirectories. 
The convention requires that the main directory name be preceded by an "x" to indicate that it is not an extension included by default in FreshRSS.

The main directory of an extension must contain at least two **mandatory** files:

- A `metadata.json` file that contains a description of the extension. This file is written in JSON.
- An `extension.php` file containing the entry point of the extension (which is a class that inherits Minz_Extension).

Please note that there is a not a required link between the directory name of the extension and the name of the class inside `extension.php`, 
but you should follow our best practice:  
If you want to write a `HelloWorld` extension, the directory name should be `xExtension-HelloWorld` and the base class name `HelloWorldExtension`.

In the file `freshrss/extensions/xExtension-HelloWorld/extension.php` you need the structure:
```html
class HelloWorldExtension extends Minz_Extension {
    public function init() {
        // your code here
    }
}
```
There is an example HelloWorld extension that you can download from [our GitHub repo](https://github.com/FreshRSS/xExtension-HelloWorld).

You may also need additional files or subdirectories depending on your needs:

- `configure.phtml` is the file containing the form to parameterize your extension
- A `static/` directory containing CSS and JavaScript files that you will need for your extension (note that if you need to write a lot of CSS it may be more interesting to write a complete theme)
- A `controllers` directory containing additional controllers
- An `i18n` directory containing additional translations
- `layout` and` views` directories to define new views or to overwrite the current views

In addition, it is good to have a `LICENSE` file indicating the license under which your extension is distributed and a` README` file giving a detailed description of it.

### The metadata.json file

The `metadata.json` file defines your extension through a number of important elements. It must contain a valid JSON array containing the following entries:

- `name` : the name of your extension
- `author` : your name, your e-mail address ... but there is no specific format to adopt
- `description` : a description of your extension
- `version` : the current version number of the extension
- `entrypoint` : Indicates the entry point of your extension. It must match the name of the class contained in the file `extension.php` without the suffix` Extension` (so if the entry point is `HelloWorld`, your class will be called` HelloWorldExtension`)
- `type` : Defines the type of your extension. There are two types: `system` and` user`. We will study this difference right after.

Only the `name` and` entrypoint` fields are required.

### Choose between « system » or « user »

A __user__ extension can be enabled by some users and not by others (typically for user preferences). 

A __system__ extension in comparison is enabled for every account.

### Writing your own extension.php

This file is the entry point of your extension. It must contain a specific class to function. 
As mentioned above, the name of the class must be your `entrypoint` suffixed by` Extension` (`HelloWorldExtension` for example). 
In addition, this class must be inherited from the `Minz_Extension` class to benefit from extensions-specific methods.

Your class will benefit from four methods to redefine:

- `install()` is called when a user clicks the button to activate your extension. It allows, for example, to update the database of a user in order to make it compatible with the extension. It returns `true` if everything went well or, if not, a string explaining the problem.
- `uninstall()` is called when a user clicks the button to disable your extension. This will allow you to undo the database changes you potentially made in `install ()`. It returns `true` if everything went well or, if not, a string explaining the problem.
- `init()` is called for every page load *if the extension is enabled*. It will therefore initialize the behavior of the extension. This is the most important method.
- `handleConfigureAction()` is called when a user loads the extension management panel. Specifically, it is called when the `?c=extension&a=configured&e=name-of-your-extension` URL is loaded. You should also write here the behavior you want when validating the form in your `configure.phtml` file.

In addition, you will have a number of methods directly inherited from `Minz_Extension` that you should not redefine:

- The "getters" first: most are explicit enough not to detail them here - `getName()`, `getEntrypoint()`, `getPath()` (allows you to retrieve the path to your extension), `getAuthor()`, `getDescription()`, `getVersion()`, `getType()`.
- `getFileUrl($filename, $type)` will return the URL to a file in the `static` directory. The first parameter is the name of the file (without `static /`), the second is the type of file to be used (`css` or` js`).
- `registerController($base_name)` will tell Minz to take into account the given controller in the routing system. The controller must be located in your `Controllers` directory, the name of the file must be` <base_name>Controller.php` and the name of the `FreshExtension_<base_name>_Controller` class.

**TODO** translate from [french version](https://github.com/FreshRSS/documentation/blob/master/fr/docs/developers/03_Backend/05_Extensions.md)

- `registerViews()`
- `registerTranslates()`
- `registerHook($hook_name, $hook_function)`

### The « hooks » system

You can register at the FreshRSS event system in an extensions `init()` method, to manipulate data when some of the core functions are executed.

```html
class HelloWorldExtension extends Minz_Extension
{
    public function init() {
        $this->registerHook('entry_before_display', array($this, 'renderEntry'));
    }
    public function renderEntry($entry) {
        $entry->_content('<h1>Hello World</h1>' . $entry->content());
        return $entry;
    }
}    
```
The following events are available:

- `entry_before_display` (`function($entry) -> Entry | null`) : will be executed every time an entry is rendered. The entry itself (instance of FreshRSS_Entry) will be passed as parameter. 
- `entry_before_insert` (`function($entry) -> Entry | null`) : will be executed when a feed is refreshed and new entries will be imported into the database. The new entry (instance of FreshRSS_Entry) will be passed as parameter. 
- `feed_before_insert` (`function($feed) -> Feed | null`) : will be executed when a new feed is imported into the database. The new feed (instance of FreshRSS_Feed) will be passed as parameter. 
- `post_update` (`function(none) -> none`) : **TODO** add documentation

### Writing your own configure.phtml

When you want to support user configurations for your extension or simply display some information, you have to create the `configure.phtml` file. 

**TODO** translate from [french version](https://github.com/FreshRSS/documentation/blob/master/fr/docs/developers/03_Backend/05_Extensions.md)
