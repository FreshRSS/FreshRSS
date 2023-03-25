# Changelog of lib\_opml

## 2023-03-10 - v0.5.1

- fix: Handle case where OPML is loaded but empty
- misc: Fix installation of Composer on the CI
- misc: Force timezone to UTC in tests

## 2022-07-25 - v0.5.0

- BREAKING CHANGE: Reverse parameters in `libopml_render()`
- BREAKING CHANGE: Validate email and URL address elements
- Add support for PHP 7.2+
- Add a .gitattributes file
- Improve the documentation about usage
- Add a note about stability in README
- Fix a PHPDoc annotation
- Homogeneize tests with "Newspapers" examples

## 2022-06-04 - v0.4.0

- Refactor the LibOpml class to be not static
- Parse or render attributes according to their types
- Add support for namespaces
- Don't require text attribute if OPML version is 1.0
- Check that outline text attribute is not empty
- Verify that xmlUrl and url attributes are present according to the type
  attribute
- Accept a version attribute in render method
- Handle OPML 1.1 as 1.0
- Fail if version, head or body is missing
- Fail if OPML version is not supported
- Fail if head contains invalid elements
- Fail if sub-outlines are not arrays when rendering
- Make parsing less strict by default
- Don't raise most parsing errors when strict is false
- Force type attribute to lowercase
- Remove SimpleXML as a requirement
- Homogenize exception messages
- Close pre tags in the example file
- Improve documentation in the README
- Improve comments in the source code
- Add a MR checklist item about changes
- Update the description in composer.json
- Update dev dependencies

## 2022-04-23 - v0.3.0

- Reorganize the architecture of code (using namespaces and classes)
- Change PHP minimum version to 7.4
- Move to Framagit instead of GitHub
- Change the license to MIT
- Configure lib\_opml with Composer
- Add PHPUnit tests for all the methods and functions
- Add a linter to the project
- Provide a Makefile
- Configure Gitlab CI instead of Travis
- Add a merge request template
- Improve the comments, documentation and examples

## 2014-03-31 - v0.2.0

- Allow to make optional the `text` attribute
- Improve and complete documentation
- Fix examples

## 2014-03-29 - v0.1.0

First version
