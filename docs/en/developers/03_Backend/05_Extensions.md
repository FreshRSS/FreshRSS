# Writing extensions for FreshRSS

## About FreshRSS

FreshRSS is an RSS / Atom feeds aggregator written in PHP since October 2012. The official site is located at [freshrss.org](https://freshrss.org) and its repository is hosted by Github: [github.com/FreshRSS/FreshRSS](https://github.com/FreshRSS/FreshRSS).

## Problem to solve

FreshRSS is limited in its technical possibilities by various factors:

* The number of developers
* The will to integrate certain changes
* The level of "hacking" required to integrate marginal features

While the first limitation can, in theory, be lifted by the participation of new contributors to the project, it depends on the willingness of contributors to take an interest in the source code of the entire project. In order to remove the other two limitations, most of the time it will be necessary to create a "fork".

Another solution consists of an extension system. By allowing users to write their own extension without taking an interest in the core of the basic software, we allow for:

1. Reducing the amount of source code a new contributor has to take in
2. Unofficial integration of novelties
3. No necessity of forking or main developer approvement.

Note: it is quite conceivable that the functionalities of an extension can later be officially integrated into the FreshRSS code. Extensions make it easy to propose a proof of concept.

## Understanding basic mechanics (Minz and MVC)

**TODO** : move to 02_Minz.md

This data sheet should refer to the official FreshRSS and Minz documentation (the PHP framework on which FreshRSS is based). Unfortunately, this documentation does not yet exist. In a few words, here are the main things you should know. It is not necessary to read all the chapters in this section if you don't need to use a feature in your extension (if you don't need to translate your extension, no need to know more about the `Minz_Translate` module for example).

### MVC Architecture

Minz relies on and imposes an MVC architecture for projects using it. This architecture consists of three main components:

* The model: this is the base object that we will manipulate. In FreshRSS, categories, flows and articles are templates. The part of the code that makes it possible to manipulate them in a database is also part of the model but is separated from the base model: we speak of DAO (for "Data Access Object"). The templates are stored in a `Models` folder.
* The view: this is what the user sees. The view is therefore simply HTML code mixed with PHP to display dynamic information. The views are stored in an `views` folder.
* The controller: this is what makes it possible to link models and views. Typically, a controller will load templates from the database (like a list of items) to "pass" them to a view for display. Controllers are stored in a `Controllers` directory.

### Routing

In order to link a URL to a controller, first you have to go through a "routing" phase. In FreshRSS, this is particularly simple because it suffices to specify the name of the controller to load into the URL using a `c` parameter. For example, the address http://exemple.com?c=hello will execute the code contained in the `hello` controller.

One concept that has not yet been discussed is the "actions" system. An action is executed *on* a controller. Concretely, a controller is represented by a class and its actions by methods. To execute an action, it is necessary to specify an `a` parameter in the URL.

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

When loading the address http://exemple.com?c=hello&a=world, the `world` action is executed on the `hello` controller.

Note: if `c` or `a` is not specified, the default value for each of these variables is `index`. So the address http://exemple.com?c=hello will execute the `index` action of the `hello` controller.

Later, the `hello/world` convention will be used to refer to a controller/action pair.

### Views

Each view is associated with a controller and an action. The view associated with `hello/world` will be stored in a very specific file: `views/hello/world. phtml`. This convention is imposed by Minz.

As explained above, the views consist of HTML mixed with PHP. Code example:

```html
<p>
    This is a parameter passed from the controller: <?php echo $this->a_variable; ?>
</p>
```

The variable `$this->a_variable` is passed by the controller (see previous example). The difference is that in the controller it is necessary to pass `$this->view`, while in the view `$this` suffices.

### Working with GET / POST

It is often necessary to take advantage of parameters passed by GET or POST. In Minz, these parameters are accessible using the `Minz_Request` class.
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

The `Minz_Request::isPost()` method can be used to execute a piece of code only if it is a POST request.

Note: it is preferable to use `Minz_Request` only in controllers. It is likely that you will encounter this method in FreshRSS views, or even in templates, but be aware that this is **not** good practice.

### Access session settings

The access to session parameters is strangely similar to the GET / POST parameters but passes through the `Minz_Session` class this time! There is no example here because you can repeat the previous example by changing all `Minz_Request` to `Minz_Session`.

### Working with URLs

To take full advantage of the Minz routing system, it is strongly discouraged to write hard URLs in your code. For example, the following view should be avoided:

```html
<p>
    Go to page <a href="http://example.com?c=hello&amp;a=world">Hello world</a>!
</p>
```

Should it be decided one day to use a "url rewriting" system to have addresses in a http://exemple.com/controller/action format, all previous addresses would become ineffective!

So use the `Minz_Url` class and its `display()` method instead. `Minz_Url::display()` takes an array of the following form as its argument:

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

Since this can become a bit tedious to use in the long run, especially in views, it is preferable to use the `_url()' shortcut:

```php
<?php

// Displays the same as above
echo _url('hello', 'world', 'foo', 'bar');

?>
```

Note: as a general rule, the shortened form (`_url()`) should be used in views, while the long form (`Minz_Url::display()`) should be used in controllers.

### Redirections

It is often necessary to redirect a user to another page. To do so, the `Minz_Request` class offers another useful method: `forward()`. This method takes the same URL format as the one seen just before as its argument.

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

It is very common to want display a message to the user while performing a redirect, to tell the user how the action was carried out (validation of a form for example). Such a message is passed through a `notification` session variable (note: we will talk about feedback from now on to avoid confusion with a notification that can occur at any time). To facilitate this kind of very frequent action, there are two shortcuts that both perform a 302 redirect by assigning a feedback message:

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

It is common (and that's an understatement) to want to show some text to the user. In the previous example, for example, we display feedback to the user based on the result of form validation. The problem is that FreshRSS has users of different nationalities. It is therefore necessary to be able to manage different languages in order not to remain confined to English or French.

The solution is to use the `Minz_Translate` class, which allows dynamic translation of FreshRSS (or any Minz-based application). Before using this module, it is necessary to know where to find the strings to be translated. Each language has its own subdirectory in a parent directory named `i18n`. For example, English language files are located in `i18n/fr/`. There are seven different files:

- `admin.php` for anything related to FreshRSS administration
- `conf.php` for configuration
- `feedback.php` contains translations of feedback messages
- `gen.php` stores what is global to FreshRSS (gen for "general")
- `index.php` for the main page that lists feeds and the About page
- `install.php` contains strings related FreshRSS installation
- `sub.php` for subscription management (sub for "subscription")

This organization makes it possible to avoid a single huge translation file.

The translation files are quite simple: it is only a matter of returning a PHP table containing the translations. Extract from `app/i18n/en/gen.php`:

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

To access these translations, `Minz_Translate` will help us with its `Minz_Translate::t()` method. As this can be a bit long to type, a shortcut has been introduced that **must** be used in all circumstances: `_t()`.
Code example:

```html
<p>
    <a href="<?php echo _url('index', 'index'); ?>">
        <?php echo _t('gen.action.back_to_rss_feeds'); ?>
    </a>
</p>
```

The string to pass to the `_t()` function consists of a series of identifiers separated by dots. The first identifier indicates from which file to extract the translation (in this case, `gen.php`), while the following ones indicate table entries. Thus `action` is an entry of the main array and `back_to_rss_feeds` is an entry of the `action` array. This allows us to further organize our translation files.

There is a small special case that sometimes makes life easier: the `_` identifier. This must necessarily be present at the end of the chain and gives a value to the higher-level identifier. It's pretty hard to explain but very simple to understand. In the example given above, a `_` is associated with the value `FreshRSS`: this means that there is no need to write `_t('gen.freshrss._')` but `_t('gen.freshrss')` suffices.

### Configuration management

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
- A `Controllers` directory containing additional controllers
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

**TODO**

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

**TODO**
