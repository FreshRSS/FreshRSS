# Minz Framework

Minz is the homemade PHP framework used by FreshRSS.

This data sheet should refer to the official FreshRSS and Minz documentation (the PHP framework on which FreshRSS is based). Unfortunately, this documentation does not yet exist. In a few words, here are the main things you should know. It is not necessary to read all the chapters in this section if you don’t need to use a feature in your extension (if you don’t need to translate your extension, no need to know more about the `Minz_Translate` module for example).

## MVC Architecture

Minz relies on and imposes an MVC architecture on projects using it. This architecture consists of three main components:

* The model: this is the base object that we will manipulate. In FreshRSS, categories, flows and articles are templates. The part of the code that makes it possible to manipulate them in a database is also part of the model but is separated from the base model: we speak of DAO (for "Data Access Object"). The templates are stored in a `Models` folder.
* The view: this is what the user sees. The view is therefore simply HTML code mixed with PHP to display dynamic information. The views are stored in a `views` folder.
* The controller: this is what makes it possible to link models and views. Typically, a controller will load templates from the database (like a list of items) to "pass" them to a view for display. Controllers are stored in a `Controllers` directory.

## Routing

In order to link a URL to a controller, first you have to go through a "routing" phase. In FreshRSS, this is particularly simple because it suffices to specify the name of the controller to load into the URL using a `c` parameter.
For example, the address <http://example.com?c=hello> will execute the code contained in the `hello` controller.

One concept that has not yet been discussed is the "actions" system. An action is executed *on* a controller. Concretely, a controller is represented by a class and its actions by methods. To execute an action, it is necessary to specify an `a` parameter in the URL.

Code example:

```php
<?php

class FreshRSS_hello_Controller extends FreshRSS_ActionController {
	public function indexAction() {
		$this->view->a_variable = 'FooBar';
	}

	public function worldAction() {
		$this->view->a_variable = 'Hello World!';
	}
}

?>
```

When loading the address <http://example.com?c=hello&a=world>, the `world` action is executed on the `hello` controller.

Note: if `c` or `a` is not specified, the default value for each of these variables is `index`.
So the address <http://example.com?c=hello> will execute the `index` action of the `hello` controller.

From now on, the `hello/world` naming convention will be used to refer to a controller/action pair.

## Views

Each view is associated with a controller and an action. The view associated with `hello/world` will be stored in a very specific file: `views/hello/world. phtml`. This convention is imposed by Minz.

As explained above, the views consist of HTML mixed with PHP. Code example:

```html
<p>
	This is a parameter passed from the controller: <?= $this->a_variable ?>
</p>
```

The variable `$this->a_variable` is passed by the controller (see previous example). The difference is that in the controller it is necessary to pass `$this->view`, while in the view `$this` suffices.

## Working with GET / POST

It is often necessary to take advantage of parameters passed by GET or POST. In Minz, these parameters are accessible using the `Minz_Request` class.
Code example:

```php
<?php

$default_value = 'foo';
$param = Minz_Request::paramString('bar') ?: $default_value;

// Display the value of the parameter `bar` (passed via GET or POST)
// or "foo" if the parameter does not exist.
echo $param;

// Sets the value of the `bar` parameter
Minz_Request::_param('bar', 'baz');

// Will necessarily display "baz" since we have just forced its value.
// Note that the second parameter (default) is optional.
echo Minz_Request::paramString('bar');

?>
```

The `Minz_Request::isPost()` method can be used to execute a piece of code only if it is a POST request.

Note: it is preferable to use `Minz_Request` only in controllers. It is likely that you will encounter this method in FreshRSS views, or even in templates, but be aware that this is **not** good practice.

## Access session settings

The access to session parameters is strangely similar to the GET / POST parameters but passes through the `Minz_Session` class this time! There is no example here because you can repeat the previous example by changing all `Minz_Request` to `Minz_Session`.

## Working with URLs

To take full advantage of the Minz routing system, it is strongly discouraged to write hard URLs in your code. For example, the following view should be avoided:

```html
<p>
	Go to page <a href="http://example.com?c=hello&amp;a=world">Hello world</a>!
</p>
```

If one day it was decided to use a "url rewriting" system to have addresses in a <http://example.com/controller/action> format, all previous addresses would become ineffective!

So use the `Minz_Url` class and its `display()` method instead. `Minz_Url::display()` takes an array of the following form as its argument:

```php
<?php

$url_array = [
	'c' => 'hello',
	'a' => 'world',
	'params' => [
		'foo' => 'bar',
	],
];

// Show something like .?c=hello&amp;a=world&amp;foo=bar
echo Minz_Url::display($url_array);

?>
```

Since this can become a bit tedious to use in the long run, especially in views, it is preferable to use the `_url()` shortcut:

```php
<?php

// Displays the same as above
echo _url('hello', 'world', 'foo', 'bar');

?>
```

Note: as a general rule, the shortened form (`_url()`) should be used in views, while the long form (`Minz_Url::display()`) should be used in controllers.

## Redirections

It is often necessary to redirect a user to another page. To do so, the `Minz_Request` class offers another useful method: `forward()`. This method takes the same URL format as the one seen just before as its argument.

Code example:

```php
<?php

$url_array = [
	'c' => 'hello',
	'a' => 'world',
];

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

$url_array = [
	'c' => 'hello',
	'a' => 'world',
];
$feedback_good = 'All went well!';
$feedback_bad = 'Oops, something went wrong.';

Minz_Request::good($feedback_good, $url_array);

// or

Minz_Request::bad($feedback_bad, $url_array);

?>
```

## Translation Management

This part [is explained here](/docs/en/internationalization.md).

## Migration

Existing documentation includes:

* [How to manage migrations](migrations.md)
