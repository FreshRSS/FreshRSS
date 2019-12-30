# Environment configuration (Docker)

FreshRSS is built with PHP and uses a homemade framework, Minz. The dependencies are directly included in the source code, so you don't need Composer.

There are various ways to configure your development environment. The easiest and most supported method is based on Docker, which is the solution documented below. If you already have a working PHP environment, you probably don't need it.

We assume here that you use a GNU/Linux distribution, capable of running Docker. Otherwise, you'll have to adapt the commands accordingly.

The commands that follow have to be executed in a console. They start by `$` when commands need to be executed as normal user, and by `#` when they need to be executed as root user. You don't have to type these characters. A path may be indicated before these characters to help you identify where they need to be executed. For instance, `app$ echo 'Hello World'` indicates that you have to execute `echo` command in the `app/` directory.

First, you need to install [Docker](https://docs.docker.com/install/linux/docker-ce/ubuntu/).

Once you're done, clone the repository with:

```console
$ git clone https://github.com/FreshRSS/FreshRSS.git
$ cd FreshRSS
```

Note that, if you want to contribute, you have to fork the repository first and clone your fork instead of the "root" one. Adapt the commands in consequence.

Then, the only command you need to know is the following:

```console
$ make start
```

This might take some time while Docker downloads the image. If your user isn't in the `docker` group, you'll need to prepend the command with `sudo`.

**You can now access FreshRSS at [http://localhost:8080](http://localhost:8080).** Just follow the install process and select the SQLite database.

You can stop the containers by typing <kbd>Control</kbd> + <kbd>c</kbd> or with the following command, in another terminal:

```console
$ make stop
```

If you're interested in the configuration, the `make` commands are defined in the [`Makefile`](/Makefile).

If you need to use a different tag image (default is `alpine`), you can set the `TAG` environment variable:

```console
$ TAG=arm make start
```

You can find the full list of available tags [on the Docker hub](https://hub.docker.com/r/freshrss/freshrss/tags).

If you want to build the Docker image yourself, you can use the following command:

```console
$ make build
$ # or
$ TAG=arm make build
```

The `TAG` variable can be anything (e.g. `local`). You can target a specific architecture by adding `-alpine` or `-arm` at the end of the tag (e.g. `local-arm`).

# Project architecture

**TODO**

# Extensions

If you want to create your own FreshRSS extension, take a look at the [extension documentation](03_Backend/05_Extensions.md).

# Coding style

If you want to contribute to the source code, it's important to follow the project's coding style. The actual code doesn't always follow it throughout the project, but we should fix it every time an opportunity presents itself.

Contributions which don't follow the coding style will be rejected as long as the coding style is not fixed.

## Spaces, tabs and other whitespace characters

### Indentation
Code indentation must use tabs.

### Alignment

Once the code has been correctly indented, it might be useful to align it for ease of reading. In that case, please use spaces.

```php
$result = a_function_with_a_really_long_name($param1, $param2,
                                             $param3, $param4);
```

### End of line

The newline character must be a line feed (LF), which is the default line ending on *NIX systems. This character must not follow other white space.

You can verify if there is any unintended white space at the end of line with the following Git command:

```bash
# command to check files before adding them in the Git index
git diff --check
# command to check files after adding them in the Git index
git diff --check --cached
```

### End of file

Every file must end by an empty line.

### Commas, dots and semi-columns

There should no space before those characters, but there should be one after.

### Operators

There should be a space before and after every operator.

```php
if ($a == 10) {
	// do something
}

echo $a ? 1 : 0;
```

### Parentheses

There should be no spaces in between brackets. There should be no spaces before the opening bracket, except if it's after a keyword. There shouldn't be any spaces after the closing bracket, except if it's followed by a curly bracket.

```php
if ($a == 10) {
	// do something
}

if ((int)$a == 10) {
	// do something
}
```

### With chained functions

It happens most of the time in Javascript files. When there are chained functions with closures and callback functions, it's hard to understand the code if not properly formatted. In those cases, we add a new indent level for the complete instruction and reset the indent for a new instruction on the same level.

```javascript
// First instruction
shortcut.add(shortcuts.mark_read, function () {
		//...
	}, {
		'disable_in_input': true
	});
// Second instruction
shortcut.add("shift+" + shortcuts.mark_read, function () {
		//...
	}, {
		'disable_in_input': true
	});
```

## Line length

Lines should strive to be shorter than 80 characters. However, this limit may be extended to 100 characters when strictly necessary.

With functions, parameters can be declared on multiple lines.

```php
function my_function($param_1, $param_2,
                     $param_3, $param_4) {
	// do something
}
```

## Naming

All code elements (functions, classes, methods and variables) must describe their usage succinctly.

### Functions and variables

Functions and variables must follow the "snake case" naming convention.

```php
// a function
function function_name() {
	// do something
}
// a variable
$variable_name;
```

### Methods

Methods must follow the "lower camel case" naming convention.

```php
private function methodName() {
	// do something
}
```

### Classes

Classes must follow the "upper camel case" naming convention.

```php
abstract class ClassName {}
```

## Encoding

Files must be encoded with the UTF-8 character set.

## PHP compatibility

Please ensure that your code works with the oldest PHP version officially supported by FreshRSS.

## Miscellaneous

### Operators
Operators must be at the end of the line if a condition is split over more than one line.

```php
if ($a == 10 ||
    $a == 20) {
	// do something
}
```

### End of file

If the file contains only PHP code, the PHP closing tag must be omitted.

### Arrays

If an array declaration runs on more than one line, each element must be followed by a comma, including the last one.

```php
$variable = [
	"value 1",
	"value 2",
	"value 3",
];
```
