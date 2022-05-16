SimplePie
=========

SimplePie is a very fast and easy-to-use class, written in PHP, that puts the
'simple' back into 'really simple syndication'.  Flexible enough to suit
beginners and veterans alike, SimplePie is focused on [speed, ease of use,
compatibility and standards compliance][what_is].

[what_is]: http://simplepie.org/wiki/faq/what_is_simplepie


Requirements
------------
* PHP 5.6+ (Required since SimplePie 1.5.3)
* libxml2 (certain 2.7.x releases are too buggy for words, and will crash)
* One of iconv, mbstring or intl extensions
* cURL or fsockopen()
* PCRE support


What comes in the package?
--------------------------
1. `library/` - SimplePie classes for use with the autoloader
2. `autoloader.php` - The SimplePie Autoloader if you want to use the separate
   file version.
3. `README.markdown` - This document.
4. `LICENSE.txt` - A copy of the BSD license.
5. `compatibility_test/` - The SimplePie compatibility test that checks your
   server for required settings.
6. `demo/` - A basic feed reader demo that shows off some of SimplePie's more
   noticeable features.
7. `idn/` - A third-party library that SimplePie can optionally use to
   understand Internationalized Domain Names (IDNs).
8. `build/` - Scripts related to generating pieces of SimplePie
9. `test/` - SimplePie's unit test suite.

### Where's `simplepie.inc`?
Since SimplePie 1.3, we've split the classes into separate files to make it easier
to maintain and use.

If you'd like a single monolithic file, see the assets in the
[releases](https://github.com/simplepie/simplepie/releases), or you can
run `php build/compile.php` to generate `SimplePie.compiled.php` yourself.

To start the demo
-----------------
1. Upload this package to your webserver.
2. Make sure that the cache folder inside of the demo folder is server-writable.
3. Navigate your browser to the demo folder.


Need support?
-------------
For further setup and install documentation, function references, etc., visit
[the wiki][wiki]. If you're using the latest version off GitHub, you can also
check out the [API documentation][].

If you can't find an answer to your question in the documentation, head on over
to one of our [support channels][]. For bug reports and feature requests, visit
the [issue tracker][].

[API documentation]: http://dev.simplepie.org/api/
[wiki]: http://simplepie.org/wiki/
[support channels]: http://simplepie.org/support/
[issue tracker]: http://github.com/simplepie/simplepie/issues


Project status
--------------
SimplePie is currently maintained by Malcolm Blaney.

As an open source project, SimplePie is maintained on a somewhat sporadic basis.
This means that feature requests may not be fulfilled straight away, as time has
to be prioritized.

If you'd like to contribute to SimplePie, the best way to get started is to fork
the project on GitHub and send pull requests for patches. When doing so, please
be aware of our [coding standards][].

[coding standards]: http://simplepie.org/wiki/misc/coding_standards


Authors and contributors
------------------------
### Current
* [Malcolm Blaney][] (Maintainer, support)

### Alumni
* [Ryan McCue][] (developer, support)
* [Ryan Parman][] (Creator, developer, evangelism, support)
* [Sam Sneddon][] (Lead developer)
* [Michael Shipley][] (Submitter of patches, support)
* [Steve Minutillo][] (Submitter of patches)

[Malcolm Blaney]: https://mblaney.xyz
[Ryan McCue]: http://ryanmccue.info
[Ryan Parman]: http://ryanparman.com
[Sam Sneddon]: https://gsnedders.com
[Michael Shipley]: http://michaelpshipley.com
[Steve Minutillo]: http://minutillo.com/steve/


### Contributors
For a complete list of contributors:

1. Pull down the latest SimplePie code
2. In the `simplepie` directory, run `git shortlog -ns`


License
-------
[New BSD license](http://www.opensource.org/licenses/BSD-3-Clause)
