# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased](https://github.com/simplepie/simplepie/compare/1.6.0...master)

## [1.6.0](https://github.com/simplepie/simplepie/compare/1.5.8...1.6.0) - 2022-04-21

### Added

- New methods `SimplePie::rename_attributes()` and `SimplePie_Sanitize::rename_attributes()` allow renaming attributes by @math-GH in [#717](https://github.com/simplepie/simplepie/pull/717)
- Add audio, video @src elements/attribute for URL resolution by @rdalverny in [#716](https://github.com/simplepie/simplepie/pull/716)
- Added new namespaced aliases and PSR-4 support for every class by @Art4 in [#711](https://github.com/simplepie/simplepie/pull/711)
- Add .editorconfig by @Alkarex in [#724](https://github.com/simplepie/simplepie/pull/724)
- Upload compiled file as release asset by @Art4 in [#725](https://github.com/simplepie/simplepie/pull/725)

### Changed

- GH Actions: version update for ramsey/composer-install by @jrfnl in [#713](https://github.com/simplepie/simplepie/pull/713)

### Fixed

- Bugfix in MySQL cache by @Art4 in [#720](https://github.com/simplepie/simplepie/pull/720)
- Re-enable xml:base for all supported RSS formats by @Alkarex in [#723](https://github.com/simplepie/simplepie/pull/723)

## [1.5.8](https://github.com/simplepie/simplepie/compare/1.5.7...1.5.8) - 2021-12-24

### Changed

- Update CHANGELOG.md, follow keepachangelog format by @Art4 in [#709](https://github.com/simplepie/simplepie/pull/709)

### Fixed

- Fix a small typo in the error() function Docblock by @audrasjb in [#712](https://github.com/simplepie/simplepie/pull/712)
- Fix/708 version bump for constant `SIMPLEPIE_VERSION` for 1.5.8 release by @faisal-alvi in [#710](https://github.com/simplepie/simplepie/pull/710)

## [1.5.7](https://github.com/simplepie/simplepie/compare/1.5.6...1.5.7) - 2021-12-19

* Fix PHP8 crash due to insufficient isset test by @Alkarex in [#670](https://github.com/simplepie/simplepie/pull/670)
* gitignore tests by @Alkarex in [#671](https://github.com/simplepie/simplepie/pull/671)
* Reduce memory when parsing large feeds by @Alkarex in [#672](https://github.com/simplepie/simplepie/pull/672)
* PHP8 catch ValueError for loadHTML() by @Alkarex in [#673](https://github.com/simplepie/simplepie/pull/673)
* Provide access to HTTP status code by @Alkarex in [#674](https://github.com/simplepie/simplepie/pull/674)
* Fix wrong type hint by @Alkarex in [#678](https://github.com/simplepie/simplepie/pull/678)
* Force HTTPS for selected domains by @Alkarex in [#676](https://github.com/simplepie/simplepie/pull/676)
* Prevent cache polution by @Alkarex in [#675](https://github.com/simplepie/simplepie/pull/675)
* Fix typo in comment by @Alkarex in [#680](https://github.com/simplepie/simplepie/pull/680)
* Remove HTTP credentials in HTTP Referer by @Alkarex in [#681](https://github.com/simplepie/simplepie/pull/681)
* CI: switch to GH Actions by @jrfnl in [#688](https://github.com/simplepie/simplepie/pull/688)
* PHP 8.1: fix "passing null to non-nullable" deprecation notice by @jrfnl in [#689](https://github.com/simplepie/simplepie/pull/689)
* Tests: PHPUnit cross-version compatibility by @jrfnl in [#690](https://github.com/simplepie/simplepie/pull/690)
* Tests: use strict assertions by @jrfnl in [#692](https://github.com/simplepie/simplepie/pull/692)
* CacheTest: handle different exceptions PHP cross-version by @jrfnl in [#691](https://github.com/simplepie/simplepie/pull/691)
* GH Actions: don't allow builds to fail on PHP 8.0 or 8.1 by @jrfnl in [#693](https://github.com/simplepie/simplepie/pull/693)
* Tests: use the correct parameter order by @jrfnl in [#694](https://github.com/simplepie/simplepie/pull/694)
* PHPUnit: update configuration by @jrfnl in [#696](https://github.com/simplepie/simplepie/pull/696)
* fix: better deal with proxy returning proxy headers (in response to cURL's Proxy-Connection header) by @shunf4 in [#698](https://github.com/simplepie/simplepie/pull/698)
* Handle multiple Link headers by @voegelas in [#700](https://github.com/simplepie/simplepie/pull/700)
* PHP 8.2: explicitly declare properties by @jrfnl in [#705](https://github.com/simplepie/simplepie/pull/705)
* New Contributor: @shunf4 made their first contribution in [#698](https://github.com/simplepie/simplepie/pull/698)
* New Contributor: @voegelas made their first contribution in [#700](https://github.com/simplepie/simplepie/pull/700)

## [1.5.6](https://github.com/simplepie/simplepie/compare/1.5.5...1.5.6) - 2020-10-14

* PHP 8.0: prevent ValueError for invalid encoding [#657](https://github.com/simplepie/simplepie/pull/657)
* Travis: test against more recent PHP versions [#653](https://github.com/simplepie/simplepie/pull/653)
* PHP 8.0: handle removal of get_magic_quotes_gpc() [#654](https://github.com/simplepie/simplepie/pull/654)
* PHP 7.4/8.0: curly brace array access deprecated & removed [#655](https://github.com/simplepie/simplepie/pull/655)
* PHP 8.0: required parameters are no longer allowed after optional parameters [#656](https://github.com/simplepie/simplepie/pull/656)
* Fix permanent_url for HTTP 301 [#660](https://github.com/simplepie/simplepie/pull/660)
* Fix typo in MIME type in Content_Type_Sniffer [#661](https://github.com/simplepie/simplepie/pull/661)

## [1.5.5](https://github.com/simplepie/simplepie/compare/1.5.4...1.5.5) - 2020-05-01

* Ensure that feeds retrieved with `force_feed` do not share the same cache as those retrieved without. [#643](https://github.com/simplepie/simplepie/pull/643)
* Removed references to removed PHP directives and some PHP < 5.6 checks. [#645](https://github.com/simplepie/simplepie/pull/645)
* Corrected incorrect alumni name. [#638](https://github.com/simplepie/simplepie/pull/638)

## [1.5.4](https://github.com/simplepie/simplepie/compare/1.5.3...1.5.4) - 2019-12-17

* PHP 5.6 or newer is now required. [#625](https://github.com/simplepie/simplepie/pull/625)
* Fixed invalid docblock parameter types [#633](https://github.com/simplepie/simplepie/pull/633)
* Added support for German short forms for weekdays and months. [#632](https://github.com/simplepie/simplepie/pull/632)
* PHP 7.4 support: Fixed instances of accessing array offset on null type values. [#628](https://github.com/simplepie/simplepie/pull/628)
* Return an effective feed URL when asking for non-permanent `subscribe_url`. [#627](https://github.com/simplepie/simplepie/pull/627)

## [1.5.3](https://github.com/simplepie/simplepie/compare/1.5.2...1.5.3) - 2019-09-22

* Replaced `pow()` call with `**` operator (micro performance optimization). [#622](https://github.com/simplepie/simplepie/pull/622)
* Match links containing `feed` in the Locator class. [#621](https://github.com/simplepie/simplepie/pull/621)
* PHP 7.4 support: Ensure the proper argument order for `implode()` calls. [#617](https://github.com/simplepie/simplepie/pull/617)
* Added support for Russian dates. [#607](https://github.com/simplepie/simplepie/pull/607)
* Preemptively changed `is_writeable()` calls to `is_writable()` in case the former is deprecated in PHP. [#604](https://github.com/simplepie/simplepie/pull/604)

## [1.5.2](https://github.com/simplepie/simplepie/compare/1.5.1...1.5.2) - 2018-08-02

* Added support for PHPUnit 6. [#565](https://github.com/simplepie/simplepie/pull/565)
* Added PHP module requirements to Composer. [#590](https://github.com/simplepie/simplepie/pull/590)
* Added support for Redis password and database. [#589](https://github.com/simplepie/simplepie/pull/589)
* Changed the spelling of `writeable` to `writable` within inline documentation. [#586](https://github.com/simplepie/simplepie/pull/586)
* Fixed various issues in the test suite and Travis. [#576](https://github.com/simplepie/simplepie/pull/576)
* Removed ambiguous tests failing on `usort()` in PHP 7. [#578](https://github.com/simplepie/simplepie/pull/578)
* Simplified logic for some function returns. [#573](https://github.com/simplepie/simplepie/pull/573)
* Fixed inline documentation for return value types for accuracy. [#570](https://github.com/simplepie/simplepie/pull/570)
* Fixed Travis to run `composer install`. [#567](https://github.com/simplepie/simplepie/pull/567)
* Removed unnecessary `else`s when a value has already been returned. [#566](https://github.com/simplepie/simplepie/pull/566)
* Fixed a bug where URL fragments are included when `SimplePie_File` normalizes URLs when really old versions of cURL are used. [#564](https://github.com/simplepie/simplepie/pull/564)
* Updated `SimplePie_Locator` to respect cURL options specified. [#561](https://github.com/simplepie/simplepie/pull/561)

## [1.5.1](https://github.com/simplepie/simplepie/compare/1.5...1.5.1) - 2017-11-17

* Fixed photos so they are not added if the URL is empty. [#530](https://github.com/simplepie/simplepie/pull/530)
* Fixed issues with retrieving feeds from behind a proxy. [#512](https://github.com/simplepie/simplepie/pull/512)/[#548](https://github.com/simplepie/simplepie/pull/548)
* Updated favicon URL in `get_favicon()`. [#525](https://github.com/simplepie/simplepie/pull/525)
* Fixed inline documentation typo. [#540](https://github.com/simplepie/simplepie/pull/540)
* Removed extra closing `<a>` tag. [#537](https://github.com/simplepie/simplepie/pull/537)
* Removed and updated feed URLs in the demo. [#535](https://github.com/simplepie/simplepie/pull/535)
* Improvements to microformat feed parsing. [#533](https://github.com/simplepie/simplepie/pull/533)
* Switched from regex to xpath for microformats discovery. [#536](https://github.com/simplepie/simplepie/pull/536)
* Update the registry if the Sanitize class has been changed. [#532](https://github.com/simplepie/simplepie/pull/532)
* Changed the sanitization type for author and category back to text from HTML. [#531](https://github.com/simplepie/simplepie/pull/531)

## [1.5](https://github.com/simplepie/simplepie/compare/1.4.3...1.5) - 2017-04-17

* Introduced `SimplePie_Category->get_type()` for retrieving category type. [#492](https://github.com/simplepie/simplepie/pull/492)
* Added `$enable_exceptions` to the class property declarations for `SimplePie` class. [#504](https://github.com/simplepie/simplepie/pull/504)
* Titles are now parsed for ATOM10 enclosure links. [#507](https://github.com/simplepie/simplepie/pull/507)
* `$item->get_id()` can now be forced to return the supplied ID instead of generating a new one. [#509](https://github.com/simplepie/simplepie/pull/509)

## [1.4.3](https://github.com/simplepie/simplepie/compare/1.4.2...1.4.3) - 2016-11-26

* Removed support for PHP 5.2. [#469](https://github.com/simplepie/simplepie/pull/469)
* Added support for the PHP `UConverter` class. [#485](https://github.com/simplepie/simplepie/pull/485)
* PHP 7.1 Support: Fixed PHP error when trying to use a non-numeric value in `round()`. [#458](https://github.com/simplepie/simplepie/pull/458)
* PHP 7 Support: Fixed deprecated message for old style constructors. [#489](https://github.com/simplepie/simplepie/pull/489)
* Fixed the error message shown when a feed has an empty body. [#487](https://github.com/simplepie/simplepie/pull/487)
* Added an error message when the XML or PCRE PHP extensions are missing. [#468](https://github.com/simplepie/simplepie/pull/468)
* Check the result of sanitize before returning in `get_content()` and `get_description()`. [#494](https://github.com/simplepie/simplepie/pull/494)
* Use `saveHTML()` to fix issues with non UTF-8 characters. [#470](https://github.com/simplepie/simplepie/pull/470)
* Stop passing compressed data through `trim()`. [#455](https://github.com/simplepie/simplepie/pull/455)
* Refactored the UTF-8 conversion error message. [#467](https://github.com/simplepie/simplepie/pull/467)
* Updated the readme file. [#486](https://github.com/simplepie/simplepie/pull/486)
* Added command line support for compayibility test. [#481](https://github.com/simplepie/simplepie/pull/481)
* Added PHP 7.1 to the testing matrix. [#462](https://github.com/simplepie/simplepie/pull/462)
* Use the latest HHVM version in testing (3.15.2). [#480](https://github.com/simplepie/simplepie/pull/480)
* Added PHPUnit as a `dev-dependency` in Composer. [#463](https://github.com/simplepie/simplepie/pull/463)
* Added `mf2/mf2` as a suggestion in Composer for use with microformats. [#491](https://github.com/simplepie/simplepie/pull/491)
* Fixed misspelled occurrences of "separated". [#459](https://github.com/simplepie/simplepie/pull/459)
* Improvements to the compatibility test and error messages. [#488](https://github.com/simplepie/simplepie/pull/488)

## [1.4.2](https://github.com/simplepie/simplepie/compare/1.4.1...1.4.2) - 2016-06-14

* Fixed a bug with IRI parsing.
* More cleanly separates discovery of microformats and parsing when php-mf2 is not present.

## [1.4.1](https://github.com/simplepie/simplepie/compare/1.4.0...1.4.1) - 2016-06-02

* Fixed inconsistent hash results in `SimplePie_Item->get_id()`.
* Leading and trailing whitespace is now trimmed from XML feed content to prevent errors. [#445](https://github.com/simplepie/simplepie/pull/445)
* Improved support for microformat feeds.

## [1.4.0](https://github.com/simplepie/simplepie/compare/1.4-beta...1.4.0) - 2016-04-25

* Dropped support for PHP 5.2. [#348](https://github.com/simplepie/simplepie/pull/348)
* Serialized data is now used for hashing in `SimplePie_Item->get_id()`. [#348](https://github.com/simplepie/simplepie/pull/348)
* Added support for PHP 5.5 and 5.6. [#348](https://github.com/simplepie/simplepie/pull/348)
* Added the `add_attributes()` method to `SimplePie`. [#394](https://github.com/simplepie/simplepie/pull/394)
* Added the `force_cache_fallback()` method to `SimplePie` to allow an expired cache to be used when a feed is unavailable. [#389](https://github.com/simplepie/simplepie/pull/389)
* Added Memcached. [#386](https://github.com/simplepie/simplepie/pull/386)
* Added `set_curl_options()` method to `SimplePie` to allow custom options. [#348](https://github.com/simplepie/simplepie/pull/348)
* Added Redis Caching. [#348](https://github.com/simplepie/simplepie/pull/348)
* Added the CEST timezone. [#380](https://github.com/simplepie/simplepie/pull/380)
* Added support for HTTP 301 Moved Permanently. [#348](https://github.com/simplepie/simplepie/pull/348)
* Added support for `application/x-rss+xml` in `SimplePie_Locator`. [#348](https://github.com/simplepie/simplepie/pull/348)
* Added photo de-duping in microformats. [#348](https://github.com/simplepie/simplepie/pull/348)
* Added decoding for special characters in MAYBE_HTML. [#400](https://github.com/simplepie/simplepie/pull/400)
* Added `SimplePie_Exception` for internally reporting errors. Also, use this to show an error when trying to load the class instead of causing a failure. [#241](https://github.com/simplepie/simplepie/pull/241)
* Added sanitization of the `</html>` and `</body>` tags. [#348](https://github.com/simplepie/simplepie/pull/348)
* Added support for media thumbnails through `SimplePie_Item->get_thumbnail()`. [#348](https://github.com/simplepie/simplepie/pull/348)
* Added the `feed_url` to a returned error message. [#348](https://github.com/simplepie/simplepie/pull/348)
* Added cache purging after a specified period of time when using MySQL cache. [#329](https://github.com/simplepie/simplepie/pull/329)
* Added backwards compatibility for removed `subscribe_*()` and `enable_xml_dump()` methods. [#348](https://github.com/simplepie/simplepie/pull/348)
* Re-added the deprecated `get/set_favicon()` methods for backwards compatibility.
* Charsets are now compared without case sensitivity to avoid duplicates. [#352](https://github.com/simplepie/simplepie/pull/352)
* Fixed encoding of ampersands in `SimplePie->subscribe_url()`. [#348](https://github.com/simplepie/simplepie/pull/348)
* The feed URL is now updated based on the URL returned by cURL. [#348](https://github.com/simplepie/simplepie/pull/348)
* Explicitly use UTF-8 in `SimplePie_Misc->get_element()` and `Simple_ie_Misc->element_implode()`. [#348](https://github.com/simplepie/simplepie/pull/348)
* Improved support, feed and authorship discovery, and parsing for microformats. [#348](https://github.com/simplepie/simplepie/pull/348)
* `rss:pubDate` is now used over `atom:updated` when determining the posting date. [#288](https://github.com/simplepie/simplepie/pull/288)
* Simplified the use of `mtime()` and `touch()`. [#403](https://github.com/simplepie/simplepie/pull/403)
* All items are now forced to have a timestamp. [#348](https://github.com/simplepie/simplepie/pull/348)
* Fixed typo in the date parser that incorrectly identified September as month 8. [#348](https://github.com/simplepie/simplepie/pull/348)
* Fixed backwards compatibility with cache subclasses. [#243](https://github.com/simplepie/simplepie/pull/243)
* Fixed a bug where the updated date was not fetched correctly. [#239](https://github.com/simplepie/simplepie/pull/239)
* Fixed the datatype for `items.data` to be more appropriate in when using MySQL cache. [#302](https://github.com/simplepie/simplepie/pull/302)
* Fixed cURL not failing when the server returns an error. [#425](https://github.com/simplepie/simplepie/pull/425)
* Fixed an error caused when trying to instantiate a `SimplePie_File` object with a bad URI. [#272](https://github.com/simplepie/simplepie/pull/272)
* Fixed a PHP notice that occurs when a date starts with `(`. [#348](https://github.com/simplepie/simplepie/pull/348)
* Fixed uninitialized string offeset PHP notices. [#353](https://github.com/simplepie/simplepie/pull/353)
* Fixed call to non-existent property in Memcache. [#311](https://github.com/simplepie/simplepie/pull/311)
* Fixed a bug where MySQL statements were not being passed thorugh `prepare()`. [#348](https://github.com/simplepie/simplepie/pull/348)
* Fixed an instance where an error message in `SimplePie` was not being triggered correctly. [#348](https://github.com/simplepie/simplepie/pull/348)
* Fixed a bug with Russian feeds. [#348](https://github.com/simplepie/simplepie/pull/348)
* Fixed an issue with memory leaks. [#287](https://github.com/simplepie/simplepie/pull/287)
* Fixed use of `DOMElement` as array. [#315](https://github.com/simplepie/simplepie/pull/315)
* Improved the error message when a feed cannot be found. [#348](https://github.com/simplepie/simplepie/pull/348)
