# lib\_opml

lib\_opml is a library to read and write OPML in PHP.

OPML is a standard designed to store and exchange outlines (i.e. a tree
structure arranged to show hierarchical relationships). It is mainly used to
exchange list of feeds between feed aggregators. The specification is
available at [opml.org](http://opml.org).

lib\_opml has been tested with PHP 7.2+. It requires [DOMDocument](https://www.php.net/manual/book.dom.php)
to work.

It supports versions 1.0 and 2.0 of OPML since these are the only published
versions. Version 1.1 is treated as version 1.0, as stated by the specification.

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

### Parse OPML

Let’s say that you have an OPML file named `my_opml_file.xml`:

```xml
<?xml version="1.0" encoding="UTF-8" ?>
<opml version="2.0">
    <head>
        <title>My OPML</title>
    </head>
    <body>
        <outline text="Newspapers">
            <outline text="El País" />
            <outline text="Le Monde" />
            <outline text="The Guardian" />
            <outline text="The New York Times" />
        </outline>
    </body>
</opml>
```

You can load it with:

```php
$opml_array = libopml_parse_file('my_opml_file.xml');
```

lib\_opml parses the file and returns an array:

```php
[
    'version' => '2.0',
    'namespaces' => [],
    'head' => [
        'title' => 'My OPML'
    ],
    'body' => [ // each entry of the body is an outline
        [
            'text' => 'Newspapers',
            '@outlines' => [ // sub-outlines are accessible with the @outlines key
                ['text' => 'El País'],
                ['text' => 'Le Monde'],
                ['text' => 'The Guardian'],
                ['text' => 'The New York Times']
            ]
        ]
    ]
]
```

Since it's just an array, it's very simple to manipulate:

```php
foreach ($opml_array['body'] as $outline) {
    echo $outline['text'];
}
```

You also can load directly an OPML string:

```php
$opml_string = '<opml>...</opml>';
$opml_array = libopml_parse_string($opml_string);
```

### Render OPML

lib\_opml is able to render an OPML string from an array. It checks that the
data is valid and respects the specification.

```php
$opml_array = [
    'head' => [
        'title' => 'My OPML',
    ],
    'body' => [
        [
            'text' => 'Newspapers',
            '@outlines' => [
                ['text' => 'El País'],
                ['text' => 'Le Monde'],
                ['text' => 'The Guardian'],
                ['text' => 'The New York Times']
            ]
        ]
    ]
];

$opml_string = libopml_render($opml_array);

file_put_contents('my_opml_file.xml', $opml_string);
```

### Handle errors

If rendering (or parsing) fails for any reason (e.g. empty `body`, missing
`text` attribute, wrong element type), a `\marienfressinaud\LibOpml\Exception`
is raised:

```php
try {
    $opml_array = libopml_render([
        'body' => []
    ]);
} catch (\marienfressinaud\LibOpml\Exception $e) {
    echo $e->getMessage();
}
```

### Class style

lib\_opml can also be used with a class style:

```php
use marienfressinaud\LibOpml;

$libopml = new LibOpml\LibOpml();

$opml_array = $libopml->parseFile($filename);
$opml_array = $libopml->parseString($opml_string);
$opml_string = $libopml->render($opml_array);
```

### Special elements and attributes

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

If one of these elements is not of the correct type, an Exception is raised.

Finally, there are additional checks based on the outline type attribute:

- if `type="rss"`, then the `xmlUrl` attribute is required;
- if `type="link"`, then the `url` attribute is required;
- if `type="include"`, then the `url` attribute is required.

Note that the `type` attribute is case-insensitive and will always be lowercased.

### Namespaces

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

### Strictness

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
$opml_string = libopml_render($opml_array, false);
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

## Examples and documented source code

See the [`examples/`](/examples) folder for concrete examples.

You are encouraged to read the source code to learn more about lib\_opml. Thus,
the full documentation is available as comments in the code:

- [`src/LibOpml/LibOpml.php`](src/LibOpml/LibOpml.php)
- [`src/LibOpml/Exception.php`](src/LibOpml/Exception.php)
- [`src/functions.php`](src/functions.php)

## Changelog

See [CHANGELOG.md](/CHANGELOG.md).

## Support and stability

Today, lib\_opml covers all the aspects of the OPML specification. Since the
spec didn't change for more than 15 years, it is expected for the library to
not change a lot in the future. Thus, I plan to release the v1.0 in a near
future. I'm only waiting for more tests to be done on its latest version (in
particular in FreshRSS, see [FreshRSS/FreshRSS#4403](https://github.com/FreshRSS/FreshRSS/pull/4403)).
I would also wait for clarifications about the specification (see [scripting/opml.org#3](https://github.com/scripting/opml.org/issues/3)),
but it isn't a hard requirement.

After the release of 1.0, lib\_opml will be considered as “finished”. This
means I will not add new features, nor break the existing code. However, I
commit myself to continue to support the library to fix security issues, bugs,
or to add support to new PHP versions.

In consequence, you can expect lib\_opml to be stable.

## Tests and linters

This section is for developers of lib\_opml.

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
