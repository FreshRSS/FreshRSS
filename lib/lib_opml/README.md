# lib\_opml

lib\_opml is a library to read and write OPML in PHP.

OPML is a standard designed to store and exchange outlines (i.e. a tree
structure arranged to show hierarchical relationships). It is mainly used to
exchange list of feeds between feed aggregators. The specification is
available at [opml.org](http://opml.org).

lib\_opml has been tested with PHP 7.4, 8.0 and 8.1. It requires [DOMDocument](https://www.php.net/manual/book.dom.php)
to work.

It only supports versions 1.0 and 2.0 of OPML since these are the only
published versions. Version 1.1 is treated as version 1.0, as stated by the
specification.

It is licensed under the [MIT license](/LICENSE).

## Installation

lib\_opml is available on [Packagist](https://packagist.org/packages/marienfressinaud/lib_opml)
and it is recommended to install it with Composer:

```console
$ composer require marienfressinaud/lib_opml
```

If you don’t use Composer, you can download [the ZIP archive](https://framagit.org/marienfressinaud/lib_opml/-/archive/main/lib_opml-main.zip)
and copy the content of the `src/` folder in your project. Then, load the files
manually:

```php
<?php
require 'path/to/lib_opml/LibOpml/Exception.php';
require 'path/to/lib_opml/LibOpml/LibOpml.php';
require 'path/to/lib_opml/functions.php';
```

## Usage

```php
$filename = 'my_opml_file.xml';
$opml_array = libopml_parse_file($filename);
print_r($opml_array);
```

```php
$opml_string = '...';
$opml_array = libopml_parse_string($opml_string);
print_r($opml_array);
```

```php
$opml_array = [...];
$opml_string = libopml_render($opml_array);
$opml_object = libopml_render($opml_array, true);
echo $opml_string;
print_r($opml_object);
```

If parsing fails for any reason (e.g. not a XML string, does not match with
the specifications), a `LibOpml\Exception` is raised.

lib\_opml can also be used with a class style:

```php
use marienfressinaud\LibOpml;

$libopml = new LibOpml\LibOpml();

$opml_array = $libopml->parseFile($filename);
$opml_array = $libopml->parseString($opml_string);
$opml_string = $libopml->render($opml_array);
$opml_object = $libopml->render($opml_array, true);
```

See the [`examples/`](/examples) folder for concrete examples.

You are encouraged to read the source code to learn more about lib\_opml. Thus,
the full documentation is available as comments in the code:

- [`src/LibOpml/LibOpml.php`](src/LibOpml/LibOpml.php)
- [`src/LibOpml/Exception.php`](src/LibOpml/Exception.php)
- [`src/functions.php`](src/functions.php)

There are few other information in the rest of this README about special
elements and attributes, namespaces and strictness.

## Special elements and attributes

Some elements have special meanings according to the specification, which means
they can be parsed to a specific type by lib\_opml. In the other way, when
rendering an OPML string, you must pass these elements with their correct
types.

Head elements:

- `dateCreated` is parsed to a `\DateTime`;
- `dateModified` is parsed to a `\DateTime`;
- `expansionState` is parsed to an array of integers;
- `vertScrollState` is parsed to an integer;
- `windowTop` is parsed to an integer;
- `windowLeft` is parsed to an integer;
- `windowBottom` is parsed to an integer;
- `windowRight` is parsed to an integer.

Outline attributes:

- `created` is parsed to a `\DateTime`;
- `category` is parsed to an array of strings;
- `isComment` is parsed to a boolean;
- `isBreakpoint` is parsed to a boolean.

If one of these elements is not of the correct type, a `LibOpml\Exception` is
raised.

Finally, there are additional checks based on the outline type attribute:

- if `type="rss"`, then the `xmlUrl` attribute is required;
- if `type="link"`, then the `url` attribute is required;
- if `type="include"`, then the `url` attribute is required.

Note that the `type` attribute is case-insensitive and will always be
lowercased.

## Namespaces

OPML can be extended with namespaces:

> An OPML file may contain elements and attributes not described on this page,
> only if those elements are defined in a namespace, as specified by the W3C.

When rendering an OPML, you can include a `namespaces` key to specify
namespaces:

```php
$opml_array = [
    'namespaces' => [
        'test' => 'https://example.com/test',
    ],
    'body' => [
        ['text' => 'My outline', 'test:path' => '/some/example/path'],
    ],
];

$opml_string = libopml_render($opml_array);
echo $opml_string;
```

This will output:

```xml
<?xml version="1.0" encoding="UTF-8"?>
<opml xmlns:test="https://example.com/test" version="2.0">
  <head/>
  <body>
    <outline text="My outline" test:path="/some/example/path"/>
  </body>
</opml>
```

## Strictness

You can tell lib\_opml to be less or more strict when parsing or rendering OPML.
This is done by passing an optional `$strict` attribute to the functions. When
strict is `false`, most of the specification requirements are simply ignored
and lib\_opml will do its best to parse (or generate) an OPML.

By default, parsing is not strict so you’ll be able to read most of the files
out there. If you want the parsing to be strict (to validate a file for
instance), pass `true` to `libopml_parse_file()` or `libopml_parse_string()`:

```php
$opml_array = libopml_parse_file($filename, true);
$opml_array = libopml_parse_string($opml_string, true);
```

On the other side, reading is strict by default, so you are encouraged to
generate valid OPMLs. If you need to relax the strictness, pass `false` to
`libopml_render()`:

```php
// Note the first false is to generate a string and not returning a
// \DOMDocument element
$opml_string = libopml_render($opml_array, false, false);
```

Please note that when using the class form, strict is passed during the object
instantiation:

```php
use marienfressinaud\LibOpml;

// lib_opml will be strict for both parsing and rendering!
$libopml = new LibOpml\LibOpml(true);

$opml_array = $libopml->parseString($opml_string);
$opml_string = $libopml->render($opml_array);
```

## Changelog

See [CHANGELOG.md](/CHANGELOG.md).

## Tests and linters

To run the tests, you’ll have to install Composer first (see [the official
documentation](https://getcomposer.org/doc/00-intro.md)). Then, install the
dependencies:

```console
$ make install
```

You should now have a `vendor/` folder containing the development dependencies.

Run the tests with:

```console
$ make test
```

Run the linter with:

```console
$ make lint
$ make lint-fix
```

## Contributing

Please submit bug reports and merge requests to the [Framagit repository](https://framagit.org/marienfressinaud/lib_opml).

There’s not a lot to do, but the documentation and examples could probably be
improved.

Merge requests require that you fill a short checklist to save me time while
reviewing your changes. You also must make sure the test suite succeeds.
