# Environment configuration

**TODO**

# Project architecture

**TODO**

# Extensions

If you want to create your own FreshRSS extension, take a look at the [extension documentation](03_Backend/05_Extensions.md).  

# Coding style

If you want to contribute to the source code, it is important to follow the project coding style. The actual code does not follow it throughout the project, but every time we have an opportunity, we should fix it.

Contributions which do not follow the coding style will be rejected as long as the coding style is not fixed.

## Spaces, tabs and white spaces

### Indent
Code indent must use tabs.

### Alignment

Once the code is indented, it might be useful to align it to ease the reading. In that case, use spaces.

```php
$result = a_function_with_a_really_long_name($param1, $param2,
                                             $param3, $param4);
```

### End of line

The end of line character must be a line feed (LF) which is a default end of line on *NIX systems. This character must not follow other white spaces.

It is possible to verify if there is white spaces before the end of line, with the following Git command:

```bash
# command to check files before adding them in the Git index
git diff --check
# command to check files after adding them in the Git index
git diff --check --cached
```

### End of file

Every file must end by an empty line.

### With commas, dots and semi-columns

There is no space before those characters but there is one after.

### With operators

There is a space before and after every operator.

```php
if ($a == 10) {
    // do something
}

echo $a ? 1 : 0;
```

### With brackets

There is no spaces in the brackets. There is no space before the opening bracket except if it is after a keyword. There is no space after the closing bracket except if it is followed by a curly bracket.

```php
if ($a == 10) {
    // do something
}

if ((int)$a == 10) {
    // do something
}
```

### With chained functions

It happens most of the time in Javascript files. When there is chained functions, closures and callback functions, it is hard to understand the code if not properly formatted. In those cases, we add a new indent level for the complete instruction and reset the indent for a new instruction on the same level.

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

Lines should be shorter than 80 characters. However, in some case, it is possible to extend that limit to 100 characters.

With functions, parameters can be declared on different lines.

```php
function my_function($param_1, $param_2,
                     $param_3, $param_4) {
    // do something
}
```

## Naming

All the code elements (functions, classes, methods and variables) must describe their usage in concise way.

### Functions and variables

They must follow the "snake case" convention.

```php
// a function
function function_name() {
    // do something
}
// a variable
$variable_name;
```

### Methods

They must follow the "lower camel case" convention.

```php
private function methodName() {
    // do something
}
```

### Classes

They must follow the "upper camel case" convention.

```php
abstract class ClassName {}
```

## Encoding

Files must be encoded with UTF-8 character set.

## PHP 5.3 compatibility

Do not get an array item directly from a function or a method. Use a variable.

```php
// code with PHP 5.3 compatibility
$my_variable = function_returning_an_array();
echo $my_variable[0];
// code without PHP 5.3 compatibility
echo function_returning_an_array()[0];
```

Do not use short array declaration.

```php
// code with PHP 5.3 compatibility
$variable = array();
// code without PHP 5.3 compatibility
$variable = [];
```

## Miscellaneous

### Operators
They must be at the end of the line if a condition runs on more than one line.

```php
if ($a == 10 ||
    $a == 20) {
    // do something
}
```

### End of file

If the file contains only PHP code, the PHP closing tag must be omitted.

### Arrays

If an array declaration runs on more than one line, each element must be followed by a comma even the last one.

```php
$variable = array(
    "value 1",
    "value 2",
    "value 3",
);
```
