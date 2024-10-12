# FreshRSS changelog

See also [the FreshRSS releases](https://github.com/FreshRSS/FreshRSS/releases).


## 2024-09-06 FreshRSS 1.24.3

* Bug fixing
	* Fix mark-as-read from user query [#6738](https://github.com/FreshRSS/FreshRSS/pull/6738)
	* Fix regression for shortcut to move between categories [#6741](https://github.com/FreshRSS/FreshRSS/pull/6741)
	* Fix feed title option [#6771](https://github.com/FreshRSS/FreshRSS/pull/6771)
	* Fix XPath for HTML documents with broken root (used by CSS selectors to fetch full content) [#6774](https://github.com/FreshRSS/FreshRSS/pull/6774)
	* Fix UI regression in Mapco/Ansum themes [#6740](https://github.com/FreshRSS/FreshRSS/pull/6740)
	* Fix minor style bug with some themes [#6746](https://github.com/FreshRSS/FreshRSS/pull/6746)
	* Fix export of OPML information for date format of JSON and HTML+XPath feeds [#6779](https://github.com/FreshRSS/FreshRSS/pull/6779)
* Security
	* OpenID Connect better definition of session parameters [#6730](https://github.com/FreshRSS/FreshRSS/pull/6730)
* Compatibility
	* Last version supporting PHP 7.4
* Misc.
	* Use charset for JSON requests from the UI [#6710](https://github.com/FreshRSS/FreshRSS/pull/6710)
	* Use `.html` extension for the local cache of full content pages instead of `.spc` [#6724](https://github.com/FreshRSS/FreshRSS/pull/6724)
	* Update dev dependencies [#6739](https://github.com/FreshRSS/FreshRSS/pull/6739), [#6758](https://github.com/FreshRSS/FreshRSS/pull/6758),
		[#6759](https://github.com/FreshRSS/FreshRSS/pull/6759), [#6760](https://github.com/FreshRSS/FreshRSS/pull/6760)


## 2024-08-23 FreshRSS 1.24.2

* Features
	* New global option to automatically add articles to favourites [#6648](https://github.com/FreshRSS/FreshRSS/pull/6648)
	* New possibility to share a user query in JSON GReader format [#6655](https://github.com/FreshRSS/FreshRSS/pull/6655)
	* New fields image and description for user query share [#6541](https://github.com/FreshRSS/FreshRSS/pull/6541)
	* Show article first words when an article title is empty [#6240](https://github.com/FreshRSS/FreshRSS/pull/6240)
	* New option to share articles from the article title line [#6395](https://github.com/FreshRSS/FreshRSS/pull/6395)
	* Improve JSON Dot Notation module to access more string-friendly types [#6631](https://github.com/FreshRSS/FreshRSS/pull/6631)
	* Improve detection of image types for enclosures not providing a type [#6653](https://github.com/FreshRSS/FreshRSS/pull/6653)
	* Add sharing to [archive.is](https://archive.is/) [#6650](https://github.com/FreshRSS/FreshRSS/pull/6650)
* Security
	* Force log out of users when they are disabled [#6612](https://github.com/FreshRSS/FreshRSS/pull/6612)
	* Increase default values for OpenID Connect `OIDCSessionMaxDuration` and `OIDCSessionInactivityTimeout` [#6642](https://github.com/FreshRSS/FreshRSS/pull/6642)
	* Add default API CORS HTTP headers to shareable user queries [#6659](https://github.com/FreshRSS/FreshRSS/pull/6659)
* Bug fixing
	* Fix parentheses for complex `OR` Boolean search expressions [#6672](https://github.com/FreshRSS/FreshRSS/pull/6672)
	* Fix *keep max unread* [#6632](https://github.com/FreshRSS/FreshRSS/pull/6632)
	* Fix regression in *mark as read upon gone* [#6663](https://github.com/FreshRSS/FreshRSS/pull/6663)
	* Fix regression on *mark duplicate titles as read* for modified articles [#6664](https://github.com/FreshRSS/FreshRSS/pull/6664)
	* Fix regression for Fever API, remove dependency to Exif extension [#6624](https://github.com/FreshRSS/FreshRSS/pull/6624)
	* Fix muted feeds for WebSub [#6671](https://github.com/FreshRSS/FreshRSS/pull/6671)
	* Fix performance / deadlock of PostgreSQL and MySQL / MariaDB during schema updates [#6692](https://github.com/FreshRSS/FreshRSS/pull/6692)
	* Fix HTTP cache of main page (regression since 1.18.0) [#6719](https://github.com/FreshRSS/FreshRSS/pull/6719)
	* Fix HTTP cache of shareable user queries [#6718](https://github.com/FreshRSS/FreshRSS/pull/6718)
	* Fix HTTP cache for feeds with modified `Last-Modified` when content is not modified [#6723](https://github.com/FreshRSS/FreshRSS/pull/6723)
* Extensions
	* Add core extensions, shipped by default: UserCSS and UserJS [#6267](https://github.com/FreshRSS/FreshRSS/pull/6267)
		* Replaces CustomCSS and CustomCS extensions
	* Strong type array parameter helper [#6661](https://github.com/FreshRSS/FreshRSS/pull/6661)
* CLI
	* Add quiet option to `cli/db-backup.php` [#6593](https://github.com/FreshRSS/FreshRSS/pull/6593)
* Compatibility
	* Initial support for PHP 8.4+ [#6615](https://github.com/FreshRSS/FreshRSS/pull/6615)
		* With upstream contributions [php/php-src#14873](https://github.com/php/php-src/issues/14873), [PhpGt/CssXPath#227](https://github.com/PhpGt/CssXPath/pull/227)
	* Fix SQLite on FreeBSD due to DQS [#6701](https://github.com/FreshRSS/FreshRSS/pull/6701), [#6702](https://github.com/FreshRSS/FreshRSS/pull/6702)
* Deployment
	* Docker default image (Debian 12 Bookworm) updated to PHP 8.2.20 and Apache 2.4.61
	* Docker alternative image updated to Alpine 3.20 with PHP 8.3.10 and Apache 2.4.62 [#5383]([#5383](https://github.com/FreshRSS/FreshRSS/pull/5383))
	* Docker: Alpine dev image `freshrss/freshrss:newest` updated to PHP 8.4.0beta3 and Apache 2.4.62 [#5764]([#5764](https://github.com/FreshRSS/FreshRSS/pull/5764))
* UI
	* Default dark mode to auto [#5582](https://github.com/FreshRSS/FreshRSS/pull/5582)
	* New option to control action icons position in reading view [#6297](https://github.com/FreshRSS/FreshRSS/pull/6297)
	* Sticky buttons at the bottom of settings [#6304](https://github.com/FreshRSS/FreshRSS/pull/6304)
	* Various UI and style improvements [#6446](https://github.com/FreshRSS/FreshRSS/pull/6446), [#6485](https://github.com/FreshRSS/FreshRSS/pull/6485),
		[#6651](https://github.com/FreshRSS/FreshRSS/pull/6651)
* I18n
	* Czech: use correct ISO 639-1 code `cs` (and not `cz`, which is the country) [#6514](https://github.com/FreshRSS/FreshRSS/pull/6514)
	* Improve Japanese [#6564](https://github.com/FreshRSS/FreshRSS/pull/6564)
	* Improve Spanish [#6634](https://github.com/FreshRSS/FreshRSS/pull/6634)
	* Improve Traditional Chinese [#6691](https://github.com/FreshRSS/FreshRSS/pull/6691)
* Misc.
	* Pass PHPStan [Level 9](https://phpstan.org/user-guide/rule-levels) [#6544](https://github.com/FreshRSS/FreshRSS/pull/6544)
	* Migrate to ESLint 9 [#6685](https://github.com/FreshRSS/FreshRSS/pull/6685)
	* Minor update of PHPCS whitespace / formatting rules [#6666](https://github.com/FreshRSS/FreshRSS/pull/6666)
	* Markdownlint no-trailing-spaces [#6668](https://github.com/FreshRSS/FreshRSS/pull/6668)
	* Removed sharing with Blogotext [#6225](https://github.com/FreshRSS/FreshRSS/pull/6225)
	* Code improvements [#6043](https://github.com/FreshRSS/FreshRSS/pull/6043)
	* Update dev dependencies [#6606](https://github.com/FreshRSS/FreshRSS/pull/6606), [#6614](https://github.com/FreshRSS/FreshRSS/pull/6614),
		[#6679](https://github.com/FreshRSS/FreshRSS/pull/6679), [#6681](https://github.com/FreshRSS/FreshRSS/pull/6681), [#6682](https://github.com/FreshRSS/FreshRSS/pull/6682),
		[#6683](https://github.com/FreshRSS/FreshRSS/pull/6683), [#6684](https://github.com/FreshRSS/FreshRSS/pull/6684)


## 2024-06-05 FreshRSS 1.24.1

* Features
	* New button to export OMPL of a category [#6519](https://github.com/FreshRSS/FreshRSS/pull/6519)
	* Better git error messages in built-in Web update [#6496](https://github.com/FreshRSS/FreshRSS/pull/6496)
* Bug fixing
	* Fix regression HTTP GET curl options [#6492](https://github.com/FreshRSS/FreshRSS/pull/6492)
	* Fix regression of *mark as read if an identical title already exists* [#6536](https://github.com/FreshRSS/FreshRSS/pull/6536), [#6543](https://github.com/FreshRSS/FreshRSS/pull/6543)
	* Fix connection to PostgreSQL databases with uppercase letters [#6482](https://github.com/FreshRSS/FreshRSS/pull/6482)
	* Fix UI regression hover over title while having the navigation buttons in mobile view [#6486](https://github.com/FreshRSS/FreshRSS/pull/6486)
	* Fix UI for some drag & drops [#6505](https://github.com/FreshRSS/FreshRSS/pull/6505), [#6508](https://github.com/FreshRSS/FreshRSS/pull/6508)
* i18n
	* Improve Czech [#6504](https://github.com/FreshRSS/FreshRSS/pull/6504)
	* Improve Turkish [#6506](https://github.com/FreshRSS/FreshRSS/pull/6506)
* Misc.
	* Update dev dependencies [#6525](https://github.com/FreshRSS/FreshRSS/pull/6525), [#6526](https://github.com/FreshRSS/FreshRSS/pull/6526), [#6528](https://github.com/FreshRSS/FreshRSS/pull/6528),
		[#6529](https://github.com/FreshRSS/FreshRSS/pull/6529), [#6530](https://github.com/FreshRSS/FreshRSS/pull/6530)


## 2024-05-23 FreshRSS 1.24.0

* Features
	* New [*shareable user query*](https://freshrss.github.io/FreshRSS/en/users/user_queries.html#share-your-user-queries) mechanism to share list of articles by HTML, RSS, OPML [#6052](https://github.com/FreshRSS/FreshRSS/pull/6052)
		* Deprecates RSS sharing with master token
	* New JSON scraping mode to consume JSON data [#5662](https://github.com/FreshRSS/FreshRSS/pull/5662), [#6317](https://github.com/FreshRSS/FreshRSS/pull/6317),
		[#6369](https://github.com/FreshRSS/FreshRSS/pull/6369), [#6476](https://github.com/FreshRSS/FreshRSS/pull/6476)
	* New support for JSON Feeds [#5662](https://github.com/FreshRSS/FreshRSS/pull/5662)
	* New support for HTTP POST [#5662](https://github.com/FreshRSS/FreshRSS/pull/5662)
	* New option to automatically add labels to incoming articles [#5954](https://github.com/FreshRSS/FreshRSS/pull/5954)
	* New button to download a feed configuration as OPML [#6312](https://github.com/FreshRSS/FreshRSS/pull/6312)
	* Web scraping support more encodings such as EUC-JP [#6112](https://github.com/FreshRSS/FreshRSS/pull/6112)
	* Web scraping support password-protected queries (refactor some cURL options and use `CURLOPT_USERPWD`) [#6177](https://github.com/FreshRSS/FreshRSS/pull/6177)
	* Web scraping HTTP GET allow UTF-8 even when charset is far from top [#6271](https://github.com/FreshRSS/FreshRSS/pull/6271)
	* Allow manual refresh of disabled feeds [#6408](https://github.com/FreshRSS/FreshRSS/pull/6408)
	* Allow multiple authors on enclosures [#6272](https://github.com/FreshRSS/FreshRSS/pull/6272)
	* New system option in `data/config.php` for number of feeds to refresh in parallel from UI [#6124](https://github.com/FreshRSS/FreshRSS/pull/6124)
* CLI
	* New CLI for [database backup & restore](https://freshrss.github.io/FreshRSS/en/admins/05_Backup.html#creating-a-database-backup) [#6387](https://github.com/FreshRSS/FreshRSS/pull/6387)
		* Can also be used to [migrate from one database to another](https://freshrss.github.io/FreshRSS/en/admins/05_Backup.html#migrate-database), or to upgrade SQLite schema
		* `./cli/db-backup.php ; ./cli/db-restore.php`
	* Improve CLI parameters [#6028](https://github.com/FreshRSS/FreshRSS/pull/6028), [#6036](https://github.com/FreshRSS/FreshRSS/pull/6036),
		[#6099](https://github.com/FreshRSS/FreshRSS/pull/6099), [#6214](https://github.com/FreshRSS/FreshRSS/pull/6214)
	* Fix i18n `cli/manipulate.translation.php` ignore behaviour [#6041](https://github.com/FreshRSS/FreshRSS/pull/6041)
* API
	* New compatible app [Read You](https://github.com/Ashinch/ReadYou) [#4633](https://github.com/FreshRSS/FreshRSS/pull/4633), [#6050](https://github.com/FreshRSS/FreshRSS/pull/6050)
	* Reduce API memory consumption [#6137](https://github.com/FreshRSS/FreshRSS/pull/6137)
	* Allow negative feed IDs for future special cases [#6010](https://github.com/FreshRSS/FreshRSS/pull/6010)
	* Only return `OK` for requests without query parameters [#6238](https://github.com/FreshRSS/FreshRSS/pull/6238)
* Bug fixing
	* Better account for some edge cases for cron and automatic labels during feed refresh [#6117](https://github.com/FreshRSS/FreshRSS/pull/6117)
	* Better support for thumbnails in RSS feeds [#5972](https://github.com/FreshRSS/FreshRSS/pull/5972)
	* Auto-update PostgreSQL or MariaDB / MySQL databases for column details changes since FreshRSS 1.21.0 [#6279](https://github.com/FreshRSS/FreshRSS/pull/6279)
		* For SQLite, DB update require running `./cli/db-backup.php ; ./cli/db-restore.php --force-overwrite`
	* Fix SQLite import of exports produced before FreshRSS 1.20.0 [#6450](https://github.com/FreshRSS/FreshRSS/pull/6450)
	* Fix SQLite release handle to fix deleting users on Microsoft Windows [#6285](https://github.com/FreshRSS/FreshRSS/pull/6285)
	* Fix to allow admins to create user even when there are Terms Of Service [#6269](https://github.com/FreshRSS/FreshRSS/pull/6269)
	* Fix updating the *uncategorized* category deletes the title [#6073](https://github.com/FreshRSS/FreshRSS/pull/6073)
	* Fix disable master authentication token [#6185](https://github.com/FreshRSS/FreshRSS/pull/6185)
	* Fix CSS selector preview [#6423](https://github.com/FreshRSS/FreshRSS/pull/6423)
	* Fix CSS selector encoding [#6426](https://github.com/FreshRSS/FreshRSS/pull/6426)
	* Fix export of CSS selector in OPML of individual feeds [#6435](https://github.com/FreshRSS/FreshRSS/pull/6435)
	* Fix OPML import of `CURLOPT_PROXYTYPE` [#6439](https://github.com/FreshRSS/FreshRSS/pull/6439)
	* Fix favicon with protocol-relative URLs have duplicate slashes [#6068](https://github.com/FreshRSS/FreshRSS/pull/6068)
	* Fix feed TTL+muted logic [#6115](https://github.com/FreshRSS/FreshRSS/pull/6115)
	* Fix apply *mark as read* to updated articles too [#6334](https://github.com/FreshRSS/FreshRSS/pull/6334)
	* Fix ZIP export on systems with custom temp folder [#6392](https://github.com/FreshRSS/FreshRSS/pull/6392)
	* Fix number of posts per page during paging [#6268](https://github.com/FreshRSS/FreshRSS/pull/6268)
	* Fix clipboard sharing UI [#6301](https://github.com/FreshRSS/FreshRSS/pull/6301)
	* Fix shortcut for clipboard sharing [#6277](https://github.com/FreshRSS/FreshRSS/pull/6277)
	* Fix user-query filter display [#6421](https://github.com/FreshRSS/FreshRSS/pull/6421)
* SimplePie
	* Fix absolutize URL for several cases [#6270](https://github.com/FreshRSS/FreshRSS/pull/6270), [simplepie/#861](https://github.com/simplepie/simplepie/pull/861)
* Security
	* Replace `iframe` `allow` attribute [#6274](https://github.com/FreshRSS/FreshRSS/pull/6274)
* Deployment
	* Disable unused PHP modules in our Debian-based Docker image [#5994](https://github.com/FreshRSS/FreshRSS/pull/5994)
* UI
	* No warning for muted feeds [#6114](https://github.com/FreshRSS/FreshRSS/pull/6114)
	* Various UI and style improvements [#6055](https://github.com/FreshRSS/FreshRSS/pull/6055), [#6074](https://github.com/FreshRSS/FreshRSS/pull/6074),
		[#6241](https://github.com/FreshRSS/FreshRSS/pull/6241), [#6242](https://github.com/FreshRSS/FreshRSS/pull/6242), [#6289](https://github.com/FreshRSS/FreshRSS/pull/6289),
		[#6299](https://github.com/FreshRSS/FreshRSS/pull/6299), [#6314](https://github.com/FreshRSS/FreshRSS/pull/6314), [#6357](https://github.com/FreshRSS/FreshRSS/pull/6357),
		[#6373](https://github.com/FreshRSS/FreshRSS/pull/6373), [#6376](https://github.com/FreshRSS/FreshRSS/pull/6376), [#6385](https://github.com/FreshRSS/FreshRSS/pull/6385),
		[#6390](https://github.com/FreshRSS/FreshRSS/pull/6390), [#6444](https://github.com/FreshRSS/FreshRSS/pull/6444), [#6445](https://github.com/FreshRSS/FreshRSS/pull/6445)
	* Improve theme *Origine compact* [#6197](https://github.com/FreshRSS/FreshRSS/pull/6197)
* i18n
	* Improve Brazilian Portuguese [#6067](https://github.com/FreshRSS/FreshRSS/pull/6067)
	* Improve Czech [#6344](https://github.com/FreshRSS/FreshRSS/pull/6344)
	* Improve Dutch [#6343](https://github.com/FreshRSS/FreshRSS/pull/6343)
	* Improve German [#6313](https://github.com/FreshRSS/FreshRSS/pull/6313)
	* Improve Hungarian [#6005](https://github.com/FreshRSS/FreshRSS/pull/6005), [#6377](https://github.com/FreshRSS/FreshRSS/pull/6377), [#6464](https://github.com/FreshRSS/FreshRSS/pull/6464)
	* Improve Indonesian [#6473](https://github.com/FreshRSS/FreshRSS/pull/6473)
	* Improve Italian [#6018](https://github.com/FreshRSS/FreshRSS/pull/6018), [#6060](https://github.com/FreshRSS/FreshRSS/pull/6060), [#6329](https://github.com/FreshRSS/FreshRSS/pull/6329)
	* Improve Japanese [#6108](https://github.com/FreshRSS/FreshRSS/pull/6108), [#6294](https://github.com/FreshRSS/FreshRSS/pull/6294)
	* Improve Korean [#6342](https://github.com/FreshRSS/FreshRSS/pull/6342)
	* Improve Polish [#6358](https://github.com/FreshRSS/FreshRSS/pull/6358)
	* Improve Portuguese [#6345](https://github.com/FreshRSS/FreshRSS/pull/6345)
	* Improve Russian [#6467](https://github.com/FreshRSS/FreshRSS/pull/6467)
	* Improve Simplified Chinese [#6336](https://github.com/FreshRSS/FreshRSS/pull/6336)
	* Improve Slovakian [#6356](https://github.com/FreshRSS/FreshRSS/issues/6356)
	* Improve Spanish [#6471](https://github.com/FreshRSS/FreshRSS/pull/6471)
	* Improve Traditional Chinese [#6350](https://github.com/FreshRSS/FreshRSS/pull/6350)
	* Improve Turkish [#6328](https://github.com/FreshRSS/FreshRSS/pull/6328)
	* Misc. [#6460](https://github.com/FreshRSS/FreshRSS/pull/6460)
* Extensions
	* Sanitize parsing list of extensions names and version number [#6016](https://github.com/FreshRSS/FreshRSS/pull/6016),
		[#6155](https://github.com/FreshRSS/FreshRSS/pull/6155), [Extensions#214](https://github.com/FreshRSS/Extensions/pull/214), [#6186](https://github.com/FreshRSS/FreshRSS/pull/6186)
	* Apply filter actions such as *mark as read* after the *entry_before_insert* hook for extensions [#6091](https://github.com/FreshRSS/FreshRSS/pull/6091)
	* New developer command to test all third-party extensions [Extensions#228](https://github.com/FreshRSS/Extensions/pull/228), [#6273](https://github.com/FreshRSS/FreshRSS/pull/6273)
		* `composer run-script phpstan-third-party`
	* New function `Minz_Extension::amendCsp()` for extensions to modify HTTP headers for Content Security Policy [#6246](https://github.com/FreshRSS/FreshRSS/pull/6246)
	* New property `FreshRSS_Entry::isUpdated()` for extensions to know whether an entry is new or updated [#6334](https://github.com/FreshRSS/FreshRSS/pull/6334)
* Compatibility
	* Fix PHP 7.4 compatibility for automated tests [#6038](https://github.com/FreshRSS/FreshRSS/pull/6038), [#6039](https://github.com/FreshRSS/FreshRSS/pull/6039)
	* Fix PHP 8.2+ compatibility for e-mails [#6130](https://github.com/FreshRSS/FreshRSS/pull/6130)
	* Use PHP 8.3+ `#[\Override]` [#6273](https://github.com/FreshRSS/FreshRSS/pull/6273)
* Misc.
	* Improve PHPStan [#6037](https://github.com/FreshRSS/FreshRSS/pull/6037), [#6459](https://github.com/FreshRSS/FreshRSS/pull/6459)
	* Update *PHPMailer* [#6022](https://github.com/FreshRSS/FreshRSS/pull/6022)
	* Remove noisy `name` parameters in user-query URL [#6371](https://github.com/FreshRSS/FreshRSS/pull/6371)
	* Code improvements [#6046](https://github.com/FreshRSS/FreshRSS/pull/6046), [#6075](https://github.com/FreshRSS/FreshRSS/pull/6075),
		[#6132](https://github.com/FreshRSS/FreshRSS/pull/6132)
	* Add Dependabot for GitHub Actions [#6164](https://github.com/FreshRSS/FreshRSS/pull/6164)
	* Allow <kbd>Ctrl</kbd>+<kbd>C</kbd> for `make start` [#6239](https://github.com/FreshRSS/FreshRSS/pull/6239)
	* Update dev dependencies [#6023](https://github.com/FreshRSS/FreshRSS/pull/6023), [#6265](https://github.com/FreshRSS/FreshRSS/pull/6265)


## 2023-12-30 FreshRSS 1.23.1

* Bug fixing
	* Fix crash regression with the option *Max number of tags shown* [#5978](https://github.com/FreshRSS/FreshRSS/pull/5978)
	* Fix crash regression when enabling extensions defined by old FreshRSS installations [#5979](https://github.com/FreshRSS/FreshRSS/pull/5979)
	* Fix crash regression during export when using MySQL [#5988](https://github.com/FreshRSS/FreshRSS/pull/5988)
	* More robust assignment of categories to feeds [#5986](https://github.com/FreshRSS/FreshRSS/pull/5986)
	* Fix `base_url` being cleared when saving settings [#5992](https://github.com/FreshRSS/FreshRSS/pull/5992)
	* Fix unwanted button in UI of update page [#5999](https://github.com/FreshRSS/FreshRSS/pull/5999)
* Deployment
	* Exclude more folders with `.dockerignore` [#5996](https://github.com/FreshRSS/FreshRSS/pull/5996)
* i18n
	* Improve Simplified Chinese [#5977](https://github.com/FreshRSS/FreshRSS/pull/5977)
	* Improve Hungarian [#6000](https://github.com/FreshRSS/FreshRSS/pull/6000)


## 2023-12-24 FreshRSS 1.23.0

* Features
	* New *Important feeds* group in the main view, with corresponding new priority level for feeds [#5782](https://github.com/FreshRSS/FreshRSS/pull/5782)
		* Entries from important feeds are not marked as read during *scroll*, during *focus*, nor during *Mark all as read*
	* Add filter actions (auto mark as read) at category level and at global levels [#5942](https://github.com/FreshRSS/FreshRSS/pull/5942)
	* Improve reliability of *Max number of articles to keep unread* [#5905](https://github.com/FreshRSS/FreshRSS/pull/5905)
	* New option to mark entries as read when focused from keyboard shortcut [5812](https://github.com/FreshRSS/FreshRSS/pull/5812)
	* New display option to hide *My labels* in article footers [#5884](https://github.com/FreshRSS/FreshRSS/pull/5884)
	* Add support for more thumbnail types in feeds enclosures [#5806](https://github.com/FreshRSS/FreshRSS/pull/5806)
	* Support for favicons with non-absolute paths [#5839](https://github.com/FreshRSS/FreshRSS/pull/5839)
	* Increase SQL (`VARCHAR`) text fields length to maximum possible [#5788](https://github.com/FreshRSS/FreshRSS/pull/5788)
	* Increase SQL date fields to 64-bit to be ready for year 2038+ [#5570](https://github.com/FreshRSS/FreshRSS/pull/5570)
* Compatibility
	* Require PHP 7.4+, and implement *typed properties* [#5720](https://github.com/FreshRSS/FreshRSS/pull/5720)
	* Soft require Apache 2.4+ (but repair minimal compatibility with Apache 2.2) [#5791](https://github.com/FreshRSS/FreshRSS/pull/5791), [#5804](https://github.com/FreshRSS/FreshRSS/pull/5804)
* Bug fixing
	* Fix regression in Docker `CRON_MIN` if any environment variable contains a single quote [#5795](https://github.com/FreshRSS/FreshRSS/pull/5795)
	* Improve filtering of cron environment variables [#5898](https://github.com/FreshRSS/FreshRSS/pull/5898)
	* Fix the `TRUSTED_PROXY` environment variable used in combination with *trusted sources* [#5853](https://github.com/FreshRSS/FreshRSS/pull/5853)
	* Fix regression in marking as read if an identical title already exists [#5937](https://github.com/FreshRSS/FreshRSS/pull/5937)
	* Fix JavaScript regression in label dropdown [#5785](https://github.com/FreshRSS/FreshRSS/pull/5785)
	* Fix regression when renaming a label [#5842](https://github.com/FreshRSS/FreshRSS/pull/5842)
	* Fix API for adding feed with a title [#5868](https://github.com/FreshRSS/FreshRSS/pull/5868)
	* Fix regression in UI of update page [#5802](https://github.com/FreshRSS/FreshRSS/pull/5802)
	* Fix XPath encoding [#5912](https://github.com/FreshRSS/FreshRSS/pull/5912)
	* Fix notifications, in particular during login [#5959](https://github.com/FreshRSS/FreshRSS/pull/5959)
* Deployment
	* Use GitHub Actions to build Docker images, offering architectures `amd64`, `arm32v7`, `arm64v8` with automatic detection [#5808](https://github.com/FreshRSS/FreshRSS/pull/5808)
	* Docker alternative image updated to Alpine 3.19 with PHP 8.2.13 and Apache 2.4.58 [#5383](https://github.com/FreshRSS/FreshRSS/pull/5383)
* Extensions
	* Upgrade extensions code to PHP 7.4+ [#5901](https://github.com/FreshRSS/FreshRSS/pull/5901), [#5957](https://github.com/FreshRSS/FreshRSS/pull/5957)
	* Breaking change: upgraded extensions require FreshRSS 1.23.0+ [Extensions#181](https://github.com/FreshRSS/Extensions/pull/181)
	* Pass FreshRSS version to JavaScript client side for extensions [#5902](https://github.com/FreshRSS/FreshRSS/pull/5902)
	* Add GitHub Actions and PHPStan for automatic testing of the Extensions repository [Extensions#185](https://github.com/FreshRSS/Extensions/pull/185)
* API
	* Improve handling of new lines in enclosure descriptions (e.g., YouTube video descriptions) [#5859](https://github.com/FreshRSS/FreshRSS/pull/5859)
* Security
	* Avoid printing exceptions in favicons [#5867](https://github.com/FreshRSS/FreshRSS/pull/5867)
	* Remove unneeded execution permissions on some files [#5831](https://github.com/FreshRSS/FreshRSS/pull/5831)
* UI
	* Ensure that enough articles are loaded on window resize [#5815](https://github.com/FreshRSS/FreshRSS/pull/5815)
	* Improve *Nord* theme [#5885](https://github.com/FreshRSS/FreshRSS/pull/5885)
	* Do not show message *Add some feeds* [#5827](https://github.com/FreshRSS/FreshRSS/pull/5827)
	* Various UI and style improvements [#5886](https://github.com/FreshRSS/FreshRSS/pull/5886)
* i18n
	* Fix font priority for languages using Han characters [#5930](https://github.com/FreshRSS/FreshRSS/pull/5930)
	* Improve Dutch [#5796](https://github.com/FreshRSS/FreshRSS/pull/5796)
	* Improve Hungarian [#5918](https://github.com/FreshRSS/FreshRSS/pull/5918)
* Misc.
	* Increase PHPStan from Level 7 to [Level 8](https://phpstan.org/user-guide/rule-levels) [#5946](https://github.com/FreshRSS/FreshRSS/pull/5946)
	* Compatibility PHP 8.2+ for running automated tests [#5826](https://github.com/FreshRSS/FreshRSS/pull/5826)
	* Use PHP [`declare(strict_types=1);`](https://php.net/language.types.declarations#language.types.declarations.strict) [#5830](https://github.com/FreshRSS/FreshRSS/pull/5830)
	* Better stack trace for SQL errors [#5916](https://github.com/FreshRSS/FreshRSS/pull/5916)
	* Code improvements [#5511](https://github.com/FreshRSS/FreshRSS/pull/5511), [#5945](https://github.com/FreshRSS/FreshRSS/pull/5945)
	* Update dev dependencies [#5787](https://github.com/FreshRSS/FreshRSS/pull/5787)


## 2023-10-30 FreshRSS 1.22.1

* Bug fixing
	* Fix regression in i18n English fallback for extensions [#5752](https://github.com/FreshRSS/FreshRSS/pull/5752)
	* Fix identification of thumbnails [#5750](https://github.com/FreshRSS/FreshRSS/pull/5750)
	* OpenID Connect compatibility with colon `:` in `OIDC_SCOPES` [#5753](https://github.com/FreshRSS/FreshRSS/pull/5753), [#5764](https://github.com/FreshRSS/FreshRSS/pull/5764)
	* Avoid a warning on non-numeric `TRUSTED_PROXY` environment variable [#5733](https://github.com/FreshRSS/FreshRSS/pull/5733)
	* Better identification of proxied client IP with `RemoteIPInternalProxy` in Apache [#5740](https://github.com/FreshRSS/FreshRSS/pull/5740)
* Deployment
	* Export all environment variables to cron (to allow custom environment variables such as for Kubernetes) [#5772](https://github.com/FreshRSS/FreshRSS/pull/5772)
	* Docker: Upgraded Alpine dev image `freshrss/freshrss:newest` to PHP 8.3 and Apache 2.4.58 [#5764](https://github.com/FreshRSS/FreshRSS/pull/5764)
* Compatibility
	* Test compatibility with PHP 8.3 [#5764](https://github.com/FreshRSS/FreshRSS/pull/5764)
* UI
	* Improve *Origine* theme (dark mode) [#5745](https://github.com/FreshRSS/FreshRSS/pull/5745)
	* Improve *Nord* theme [#5754](https://github.com/FreshRSS/FreshRSS/pull/5754)
	* Various UI and style improvements [#5737](https://github.com/FreshRSS/FreshRSS/pull/5737), [#5765](https://github.com/FreshRSS/FreshRSS/pull/5765),
		[#5773](https://github.com/FreshRSS/FreshRSS/pull/5773), [#5774](https://github.com/FreshRSS/FreshRSS/pull/5774)
* i18n
	* Better i18n string for feed submenu for mark as read [#5762](https://github.com/FreshRSS/FreshRSS/pull/5762)
	* Improve Dutch [#5759](https://github.com/FreshRSS/FreshRSS/pull/5759)
* Misc.
	* Move to GitHub Actions for our GitHub Pages [#5681](https://github.com/FreshRSS/FreshRSS/pull/5681)
	* Update dev dependencies and use `stylelint-stylistic` [#5766](https://github.com/FreshRSS/FreshRSS/pull/5766)


## 2023-10-23 FreshRSS 1.22.0

* Features
	* Add support for OpenID Connect (only in our default Debian-based Docker image for `x86_64`, not Alpine) through [`libapache2-mod-auth-openidc`](https://github.com/OpenIDC/mod_auth_openidc)
		[#5351](https://github.com/FreshRSS/FreshRSS/pull/5351), [#5463](https://github.com/FreshRSS/FreshRSS/pull/5463), [#5481](https://github.com/FreshRSS/FreshRSS/pull/5481),
		[#5523](https://github.com/FreshRSS/FreshRSS/pull/5523), [#5646](https://github.com/FreshRSS/FreshRSS/pull/5646)
	* Allow sharing in anonymous mode [#5261](https://github.com/FreshRSS/FreshRSS/pull/5261)
	* Support Unix socket for MySQL / MariaDB [#5166](https://github.com/FreshRSS/FreshRSS/pull/5166)
	* Use proxy settings also for fetching favicons [#5421](https://github.com/FreshRSS/FreshRSS/pull/5421)
	* Add mutual exclusion semaphore for better scaling of actualize script [#5235](https://github.com/FreshRSS/FreshRSS/pull/5235)
	* Better reporting of XPath failures [#5317](https://github.com/FreshRSS/FreshRSS/pull/5317)
	* Add sharing with Buffer.com [#5286](https://github.com/FreshRSS/FreshRSS/pull/5286)
	* Add sharing with Omnivore [#5477](https://github.com/FreshRSS/FreshRSS/pull/5477)
	* Improve sharing with Linkding [#5433](https://github.com/FreshRSS/FreshRSS/pull/5433)
	* Do not automatically update feeds after import, to better support multiple imports [#5629](https://github.com/FreshRSS/FreshRSS/pull/5629)
	* Compatibility for servers disabling `set_time_limit()` [#5675](https://github.com/FreshRSS/FreshRSS/pull/5675)
	* New configuration constant `CLEANCACHE_HOURS` [#5144](https://github.com/FreshRSS/FreshRSS/pull/5144)
* Bug fixing
	* Fix cache refresh [#5562](https://github.com/FreshRSS/FreshRSS/pull/5562)
	* Fix and improvement of hash of articles using *load full content* [#5576](https://github.com/FreshRSS/FreshRSS/pull/5576)
	* Fix case of falsy GUIDs [#5412](https://github.com/FreshRSS/FreshRSS/pull/5412)
	* Fix and improve JSON export/import [#5332](https://github.com/FreshRSS/FreshRSS/pull/5332), [#5626](https://github.com/FreshRSS/FreshRSS/pull/5626)
	* Fix enclosures in RSS output [#5540](https://github.com/FreshRSS/FreshRSS/pull/5540)
	* Fix parenthesis escaping bug in searches [#5633](https://github.com/FreshRSS/FreshRSS/pull/5633)
	* Fix regression in Fever API enclosures [#5214](https://github.com/FreshRSS/FreshRSS/pull/5214)
	* Fix regression in Fever API mark-all-as-read [#5185](https://github.com/FreshRSS/FreshRSS/pull/5185)
	* Fix regression in OPML export of single feeds [#5238](https://github.com/FreshRSS/FreshRSS/pull/5238)
	* Fix warning during OPML export with empty attributes [#5559](https://github.com/FreshRSS/FreshRSS/pull/5559)
	* Fix extensions in *actualize script* [#5243](https://github.com/FreshRSS/FreshRSS/pull/5243)
	* Fix link to configuration (system or user) for extensions [#5394](https://github.com/FreshRSS/FreshRSS/pull/5394)
	* Fix *mark as read upon gone* option in some conditions [#5315](https://github.com/FreshRSS/FreshRSS/pull/5315),
		[#5382](https://github.com/FreshRSS/FreshRSS/pull/5382), [#5404](https://github.com/FreshRSS/FreshRSS/pull/5404)
	* Fix *mark selection as unread* [#5367](https://github.com/FreshRSS/FreshRSS/pull/5367)
	* Fix warning in articles repartition statistics [#5228](https://github.com/FreshRSS/FreshRSS/pull/5228)
	* Fix count entries with some databases [#5368](https://github.com/FreshRSS/FreshRSS/pull/5368)
	* Fix MariaDB database size calculation [#5655](https://github.com/FreshRSS/FreshRSS/pull/5655)
	* Fix feed position attribute [#5203](https://github.com/FreshRSS/FreshRSS/pull/5203)
	* Fix warning when tagging entries [#5221](https://github.com/FreshRSS/FreshRSS/pull/5221)
	* Fix labels in anonymous mode [#5650](https://github.com/FreshRSS/FreshRSS/pull/5650)
	* Fix bug not allowing strings for tags in XPath [#5653](https://github.com/FreshRSS/FreshRSS/pull/5653)
	* Fix get and order when saving user query [#5515](https://github.com/FreshRSS/FreshRSS/pull/5515)
	* Fix search using user queries [#5669](https://github.com/FreshRSS/FreshRSS/pull/5669)
	* Fix regression of access to logs even when auto-update is disabled [#5577](https://github.com/FreshRSS/FreshRSS/pull/5577)
	* Fix access to Apache logs from Dev Container [#5660](https://github.com/FreshRSS/FreshRSS/pull/5660)
	* Fix malformed HTTP header in case of internal fatal error [#5699](https://github.com/FreshRSS/FreshRSS/pull/5699)
	* Fix rare exception for HTML notifications [#5690](https://github.com/FreshRSS/FreshRSS/pull/5690)
* UI
	* New option to display website name and/or favicon of articles  [#4969](https://github.com/FreshRSS/FreshRSS/pull/4969)
	* Support `<meta name="theme-color" .../>` [#5105](https://github.com/FreshRSS/FreshRSS/pull/5105)
	* Config user settings in slider [#5094](https://github.com/FreshRSS/FreshRSS/pull/5094)
	* Improve theme selector [#5281](https://github.com/FreshRSS/FreshRSS/pull/5281), [#5688](https://github.com/FreshRSS/FreshRSS/pull/5688)
	* Improve *share to clipboard* with animation and icon [#5295](https://github.com/FreshRSS/FreshRSS/pull/5295)
	* Allow *share to clipboard* even for localhost and without HTTPS [#5606](https://github.com/FreshRSS/FreshRSS/pull/5606)
	* Feedback when tag with same name as category already exists [#5181](https://github.com/FreshRSS/FreshRSS/pull/5181)
	* Show *base URL* in configuration [#5656](https://github.com/FreshRSS/FreshRSS/pull/5656), [#5657](https://github.com/FreshRSS/FreshRSS/pull/5657)
	* Show *Terms of Service* in config menu [#5215](https://github.com/FreshRSS/FreshRSS/pull/5215)
	* Show *Terms of Service* in footer [#5222](https://github.com/FreshRSS/FreshRSS/pull/5222)
	* Improve *about* page [#5192](https://github.com/FreshRSS/FreshRSS/pull/5192)
	* Improve *update* page [#5420](https://github.com/FreshRSS/FreshRSS/pull/5420), [#5636](https://github.com/FreshRSS/FreshRSS/pull/5636),
		[#5647](https://github.com/FreshRSS/FreshRSS/pull/5647)
	* Improve Step 1 of install process [#5350](https://github.com/FreshRSS/FreshRSS/pull/5350)
	* Improve *Global view* on mobile [#5297](https://github.com/FreshRSS/FreshRSS/pull/5297)
	* Reduce network overhead for Global view [#5496](https://github.com/FreshRSS/FreshRSS/pull/5496)
	* Fix *Global view*: Stick the article to the top when opened [#5153](https://github.com/FreshRSS/FreshRSS/pull/5153)
	* Fix configuration views that are using a slider [#5469](https://github.com/FreshRSS/FreshRSS/pull/5469)
	* Fix highlight next/prev article while using shortcuts [#5211](https://github.com/FreshRSS/FreshRSS/pull/5211)
	* Fix regression in statistics column name *% of total* [#5232](https://github.com/FreshRSS/FreshRSS/pull/5232)
	* Fix macOS feed title meta-click behaviour [#5492](https://github.com/FreshRSS/FreshRSS/pull/5492)
	* Improve themes
		* *Origine* (dark mode) [#5229](https://github.com/FreshRSS/FreshRSS/pull/5229),
			[#5288](https://github.com/FreshRSS/FreshRSS/pull/5288), [#5437](https://github.com/FreshRSS/FreshRSS/pull/5437)
		* *Alternative Dark* [#5206](https://github.com/FreshRSS/FreshRSS/pull/5206)
		* *Ansum* / *Mapco* [#5453](https://github.com/FreshRSS/FreshRSS/pull/5453)
		* *Dark* [#5280](https://github.com/FreshRSS/FreshRSS/pull/5280), [#5439](https://github.com/FreshRSS/FreshRSS/pull/5439)
		* *Flat* (un-deprecated) [#5316](https://github.com/FreshRSS/FreshRSS/pull/5316)
		* *Nord* [#5689](https://github.com/FreshRSS/FreshRSS/pull/5689), [#5719](https://github.com/FreshRSS/FreshRSS/pull/5719)
	* Delete previously deprecated themes: *BlueLagoon*, *Screwdriver* [#5374](https://github.com/FreshRSS/FreshRSS/pull/5374),
		[#5694](https://github.com/FreshRSS/FreshRSS/pull/5694)
	* Various UI and style improvements [#5147](https://github.com/FreshRSS/FreshRSS/pull/5147), [#5216](https://github.com/FreshRSS/FreshRSS/pull/5216),
		[#5303](https://github.com/FreshRSS/FreshRSS/pull/5303), [#5304](https://github.com/FreshRSS/FreshRSS/pull/5304), [#5397](https://github.com/FreshRSS/FreshRSS/pull/5397),
		[#5398](https://github.com/FreshRSS/FreshRSS/pull/5398), [#5400](https://github.com/FreshRSS/FreshRSS/pull/5400), [#5603](https://github.com/FreshRSS/FreshRSS/pull/5603),
		[#5695](https://github.com/FreshRSS/FreshRSS/pull/5695)
* Security
	* Rework trusted proxies (especially with Docker) [#5549](https://github.com/FreshRSS/FreshRSS/pull/5549)
	* Automatic trusted sources during install [#5358](https://github.com/FreshRSS/FreshRSS/pull/5358)
	* Show remote IP address in case of HTTP Basic Auth error [#5314](https://github.com/FreshRSS/FreshRSS/pull/5314)
* Deployment
	* Docker listen on all interfaces by default, including IPv6 [#5180](https://github.com/FreshRSS/FreshRSS/pull/5180)
	* Docker default image updated to Debian 12 Bookworm with PHP 8.2.7 and Apache 2.4.57 [#5461](https://github.com/FreshRSS/FreshRSS/pull/5461)
	* Docker alternative image updated to Alpine 3.18 with PHP 8.1.23 and Apache 2.4.58 [#5383](https://github.com/FreshRSS/FreshRSS/pull/5383)
	* Docker quiet Apache `a2enmod` [#5464](https://github.com/FreshRSS/FreshRSS/pull/5464)
	* Docker: Add `DATA_PATH` to cron env [#5531](https://github.com/FreshRSS/FreshRSS/pull/5531)
* i18n
	* Fix i18n for automatic dark mode configuration [#5168](https://github.com/FreshRSS/FreshRSS/pull/5168)
	* Clarify that maximum number to keep is per feed [#5458](https://github.com/FreshRSS/FreshRSS/pull/5458)
	* Add Hungarian [#5589](https://github.com/FreshRSS/FreshRSS/pull/5589), [#5593](https://github.com/FreshRSS/FreshRSS/pull/5593)
	* Add Latvian [#5254](https://github.com/FreshRSS/FreshRSS/pull/5254)
	* Add Persian [#5571](https://github.com/FreshRSS/FreshRSS/pull/5571)
	* Remove unneeded quotes in feed warning [#5480](https://github.com/FreshRSS/FreshRSS/pull/5480)
	* Improve German [#5171](https://github.com/FreshRSS/FreshRSS/pull/5171), [#5468](https://github.com/FreshRSS/FreshRSS/pull/5468),
		[#5640](https://github.com/FreshRSS/FreshRSS/pull/5640)
	* Improve Spanish [#5408](https://github.com/FreshRSS/FreshRSS/pull/5408), [#5436](https://github.com/FreshRSS/FreshRSS/pull/5436),
		[#5609](https://github.com/FreshRSS/FreshRSS/pull/5609)
* Extensions
	* Fix fallback to English for extensions [#5426](https://github.com/FreshRSS/FreshRSS/pull/5426)
	* Allow deep-link to extension configuration [#5449](https://github.com/FreshRSS/FreshRSS/pull/5449)
	* New extension hook `entry_auto_read` [#5505](https://github.com/FreshRSS/FreshRSS/pull/5505), [#5561](https://github.com/FreshRSS/FreshRSS/pull/5561)
	* Simplify extension method [#5234](https://github.com/FreshRSS/FreshRSS/pull/5234)
	* Remove obsolete core extensions *Google Group* and *Tumblr* [#5457](https://github.com/FreshRSS/FreshRSS/pull/5457)
* SimplePie
	* Fix `error_reporting` for PHP 8.1+ [#5199](https://github.com/FreshRSS/FreshRSS/pull/5199)
* Misc.
	* Reduce database locks [#5576](https://github.com/FreshRSS/FreshRSS/pull/5576), [#5625](https://github.com/FreshRSS/FreshRSS/pull/5625),
		[#5648](https://github.com/FreshRSS/FreshRSS/pull/5648), [#5649](https://github.com/FreshRSS/FreshRSS/pull/5649)
	* Improve MySQL / MariaDB performance for updating cached SQL values [#5648](https://github.com/FreshRSS/FreshRSS/pull/5648)
	* Increase time limit import OPML [#5231](https://github.com/FreshRSS/FreshRSS/pull/5231)
	* Save SQL attributes as native Unicode [#5371](https://github.com/FreshRSS/FreshRSS/pull/5371)
	* Remove old SQL auto-updates [#5625](https://github.com/FreshRSS/FreshRSS/pull/5625), [#5649](https://github.com/FreshRSS/FreshRSS/pull/5649)
	* Improve Dev Container (update to Alpine 3.18, use `DATA_PATH` environment variable) [#5423](https://github.com/FreshRSS/FreshRSS/pull/5423)
	* Update `lib_opml` [#5188](https://github.com/FreshRSS/FreshRSS/pull/5188)
	* Update `lib/http-conditional` [#5277](https://github.com/FreshRSS/FreshRSS/pull/5277)
	* Update *PHPMailer* [#5389](https://github.com/FreshRSS/FreshRSS/pull/5389)
	* Use typed access to request parameters [#5267](https://github.com/FreshRSS/FreshRSS/pull/5267)
	* Typed view model classes [#5380](https://github.com/FreshRSS/FreshRSS/pull/5380)
	* Remove `ConfigurationSetter` [#5251](https://github.com/FreshRSS/FreshRSS/pull/5251), [#5580](https://github.com/FreshRSS/FreshRSS/pull/5580)
	* Ignore `./data.back/` in `.gitignore` [#5359](https://github.com/FreshRSS/FreshRSS/pull/5359)
	* Composer dev command compatibility with macOS [#5379](https://github.com/FreshRSS/FreshRSS/pull/5379)
	* Code improvements [#5089](https://github.com/FreshRSS/FreshRSS/pull/5089),
		[#5212](https://github.com/FreshRSS/FreshRSS/pull/5212), [#5213](https://github.com/FreshRSS/FreshRSS/pull/5213), [#5362](https://github.com/FreshRSS/FreshRSS/pull/5362),
		[#5470](https://github.com/FreshRSS/FreshRSS/pull/5470), [#5501](https://github.com/FreshRSS/FreshRSS/pull/5501), [#5504](https://github.com/FreshRSS/FreshRSS/pull/5504),
		[#5667](https://github.com/FreshRSS/FreshRSS/pull/5667)
	* Increase PHPStan from Level 5 to [level 7](https://phpstan.org/user-guide/rule-levels) [#4112](https://github.com/FreshRSS/FreshRSS/issues/4112),
		[#5064](https://github.com/FreshRSS/FreshRSS/pull/5064), [#5087](https://github.com/FreshRSS/FreshRSS/pull/5087), [#5090](https://github.com/FreshRSS/FreshRSS/pull/5090),
		[#5106](https://github.com/FreshRSS/FreshRSS/pull/5106), [#5108](https://github.com/FreshRSS/FreshRSS/pull/5108), [#5230](https://github.com/FreshRSS/FreshRSS/pull/5230),
		[#5239](https://github.com/FreshRSS/FreshRSS/pull/5239), [#5258](https://github.com/FreshRSS/FreshRSS/pull/5258), [#5263](https://github.com/FreshRSS/FreshRSS/pull/5263),
		[#5264](https://github.com/FreshRSS/FreshRSS/pull/5264), [#5269](https://github.com/FreshRSS/FreshRSS/pull/5269), [#5272](https://github.com/FreshRSS/FreshRSS/pull/5272),
		[#5275](https://github.com/FreshRSS/FreshRSS/pull/5275), [#5279](https://github.com/FreshRSS/FreshRSS/pull/5279), [#5282](https://github.com/FreshRSS/FreshRSS/pull/5282),
		[#5283](https://github.com/FreshRSS/FreshRSS/pull/5283), [#5289](https://github.com/FreshRSS/FreshRSS/pull/5289), [#5290](https://github.com/FreshRSS/FreshRSS/pull/5290),
		[#5291](https://github.com/FreshRSS/FreshRSS/pull/5291), [#5292](https://github.com/FreshRSS/FreshRSS/pull/5292), [#5299](https://github.com/FreshRSS/FreshRSS/pull/5299),
		[#5305](https://github.com/FreshRSS/FreshRSS/pull/5305), [#5307](https://github.com/FreshRSS/FreshRSS/pull/5307), [#5309](https://github.com/FreshRSS/FreshRSS/pull/5309),
		[#5313](https://github.com/FreshRSS/FreshRSS/pull/5313), [#5318](https://github.com/FreshRSS/FreshRSS/pull/5318), [#5319](https://github.com/FreshRSS/FreshRSS/pull/5319),
		[#5327](https://github.com/FreshRSS/FreshRSS/pull/5327), [#5328](https://github.com/FreshRSS/FreshRSS/pull/5328), [#5352](https://github.com/FreshRSS/FreshRSS/pull/5352),
		[#5353](https://github.com/FreshRSS/FreshRSS/pull/5353), [#5354](https://github.com/FreshRSS/FreshRSS/pull/5354), [#5361](https://github.com/FreshRSS/FreshRSS/pull/5361),
		[#5366](https://github.com/FreshRSS/FreshRSS/pull/5366), [#5370](https://github.com/FreshRSS/FreshRSS/pull/5370), [#5373](https://github.com/FreshRSS/FreshRSS/pull/5373),
		[#5376](https://github.com/FreshRSS/FreshRSS/pull/5376), [#5384](https://github.com/FreshRSS/FreshRSS/pull/5384), [#5388](https://github.com/FreshRSS/FreshRSS/pull/5388),
		[#5393](https://github.com/FreshRSS/FreshRSS/pull/5393), [#5400](https://github.com/FreshRSS/FreshRSS/pull/5400), [#5406](https://github.com/FreshRSS/FreshRSS/pull/5406),
		[#5429](https://github.com/FreshRSS/FreshRSS/pull/5429), [#5431](https://github.com/FreshRSS/FreshRSS/pull/5431), [#5434](https://github.com/FreshRSS/FreshRSS/pull/5434),
		[#5578](https://github.com/FreshRSS/FreshRSS/pull/5578)
	* Update dev dependencies [#5336](https://github.com/FreshRSS/FreshRSS/pull/5336), [#5339](https://github.com/FreshRSS/FreshRSS/pull/5339),
		[#5478](https://github.com/FreshRSS/FreshRSS/pull/5478), [#5513](https://github.com/FreshRSS/FreshRSS/pull/5513), [#5541](https://github.com/FreshRSS/FreshRSS/pull/5541),
		[#5691](https://github.com/FreshRSS/FreshRSS/pull/5691), [#5693](https://github.com/FreshRSS/FreshRSS/pull/5693)


## 2023-03-04 FreshRSS 1.21.0

* Features
	* New *XML+XPath* mode for fetching XML documents when there is no RSS/ATOM feed [#5076](https://github.com/FreshRSS/FreshRSS/pull/5076)
	* Better support of feed enclosures (image / audio / video attachments) [#4944](https://github.com/FreshRSS/FreshRSS/pull/4944)
	* User-defined time-zone [#4906](https://github.com/FreshRSS/FreshRSS/pull/4906)
	* Improve HTML+XPath mode by allowing HTML content [#4878](https://github.com/FreshRSS/FreshRSS/pull/4878)
	* Search only on full tag names and not on parts of tag names [#4882](https://github.com/FreshRSS/FreshRSS/pull/4882)
	* Allows searching for parentheses with `\(` or `\)` [#4989](https://github.com/FreshRSS/FreshRSS/pull/4989)
	* Firefox-compatible sharing service for `mailto:` links for webmail services [#4680](https://github.com/FreshRSS/FreshRSS/pull/4680)
	* Add sharing to [archive.org](https://archive.org/) [#5096](https://github.com/FreshRSS/FreshRSS/pull/5096)
	* Increase max HTTP timeout to 15 minutes [#5074](https://github.com/FreshRSS/FreshRSS/pull/5074)
* Compatibility
	* Require PHP 7.2+ (drop support for PHP 7.0 and 7.1) [#4848](https://github.com/FreshRSS/FreshRSS/pull/4848)
	* Workaround disabled `openlog()` or `syslog()` [#5054](https://github.com/FreshRSS/FreshRSS/pull/5054)
* Deployment
	* Docker default image (Debian 11 Bullseye) updated to PHP 7.4.33
	* Docker: alternative image updated to Alpine 3.17 with PHP 8.1.16 and Apache 2.4.55 [#4886](https://github.com/FreshRSS/FreshRSS/pull/4886)
	* More uniform time-zone behaviour [#4903](https://github.com/FreshRSS/FreshRSS/pull/4903), [#4905](https://github.com/FreshRSS/FreshRSS/pull/4905)
	* New CLI script `cli/sensitive-log.sh` to help e.g. Apache clear logs for sensitive information such as credentials [#5001](https://github.com/FreshRSS/FreshRSS/pull/5001)
	* New CLI script `cli/access-permissions.sh` to help apply file permissions correctly [#5062](https://github.com/FreshRSS/FreshRSS/pull/5062)
	* Improve file permissions on `./extensions/` [#4956](https://github.com/FreshRSS/FreshRSS/pull/4956)
	* Update Apache mime type `font/woff` [#4894](https://github.com/FreshRSS/FreshRSS/pull/4894)
	* Re-added a git `latest` branch (instead of a tag) to track the latest FreshRSS stable releases [#5148](https://github.com/FreshRSS/FreshRSS/pull/5148)
* Bug fixing
	* Fix allow disabling curl proxy for specific feed, when proxy is defined globally [#5082](https://github.com/FreshRSS/FreshRSS/pull/5082)
	* NFS-friendly `is_writable()` checks [#4780](https://github.com/FreshRSS/FreshRSS/pull/4780)
	* Fix error handling when updating feed URL [#5039](https://github.com/FreshRSS/FreshRSS/pull/5039)
	* Fix feed favicon after editing feed URL [#4975](https://github.com/FreshRSS/FreshRSS/pull/4975)
	* Fix allow <kbd>Ctrl</kbd>+<kbd>Click</kbd> to open *Manage feeds* in new tab [#4980](https://github.com/FreshRSS/FreshRSS/pull/4980)
	* Fix empty window opened when pressing space after page load [#5146](https://github.com/FreshRSS/FreshRSS/pull/5146)
	* Fix keep current view when searching [#4981](https://github.com/FreshRSS/FreshRSS/pull/4981)
	* Fix mobile view: scroll main area again after closing slider [#5092](https://github.com/FreshRSS/FreshRSS/pull/5092)
	* Fix change confirmation when leaving sharing service config [#5098](https://github.com/FreshRSS/FreshRSS/pull/5098)
	* Fix sharing to Lemmy [#5020](https://github.com/FreshRSS/FreshRSS/pull/5020)
* Security
	* API avoid logging passwords [CVE-2023-22481](https://github.com/FreshRSS/FreshRSS/security/advisories/GHSA-8vvv-jxg6-8578)
	* Remove execution rights on some files not needing it [#5065](https://github.com/FreshRSS/FreshRSS/pull/5065)
	* More robust application of file access permissions [#5062](https://github.com/FreshRSS/FreshRSS/pull/5062)
* UI
	* Improve search box [#4994](https://github.com/FreshRSS/FreshRSS/pull/4994)
	* Improve navigation menu structure [#4937](https://github.com/FreshRSS/FreshRSS/pull/4937)
	* More consistent sorting of feeds alphabetically [#4841](https://github.com/FreshRSS/FreshRSS/pull/4841)
	* Improve reader view on mobile screen [#4868](https://github.com/FreshRSS/FreshRSS/pull/4868)
	* Various UI and style improvements [#4681](https://github.com/FreshRSS/FreshRSS/pull/4681), [#4794](https://github.com/FreshRSS/FreshRSS/pull/4794)
		[#4800](https://github.com/FreshRSS/FreshRSS/pull/4800), [#4850](https://github.com/FreshRSS/FreshRSS/pull/4850), [#4865](https://github.com/FreshRSS/FreshRSS/pull/4865),
		[#4872](https://github.com/FreshRSS/FreshRSS/pull/4872), [#4874](https://github.com/FreshRSS/FreshRSS/pull/4874), [#4889](https://github.com/FreshRSS/FreshRSS/pull/4889),
		[#4890](https://github.com/FreshRSS/FreshRSS/pull/4890), [#4891](https://github.com/FreshRSS/FreshRSS/pull/4891), [#4897](https://github.com/FreshRSS/FreshRSS/pull/4897),
		[#4899](https://github.com/FreshRSS/FreshRSS/pull/4899), [#4910](https://github.com/FreshRSS/FreshRSS/pull/4910), [#4923](https://github.com/FreshRSS/FreshRSS/pull/4923),
		[#4927](https://github.com/FreshRSS/FreshRSS/pull/4927), [#4960](https://github.com/FreshRSS/FreshRSS/pull/4960), [#4985](https://github.com/FreshRSS/FreshRSS/pull/4985),
		[#4998](https://github.com/FreshRSS/FreshRSS/pull/4998), [#5034](https://github.com/FreshRSS/FreshRSS/pull/5034), [#5040](https://github.com/FreshRSS/FreshRSS/pull/5040),
		[#5055](https://github.com/FreshRSS/FreshRSS/pull/5055), [#5058](https://github.com/FreshRSS/FreshRSS/pull/5058), [#5097](https://github.com/FreshRSS/FreshRSS/pull/5097),
		[#5100](https://github.com/FreshRSS/FreshRSS/pull/5100)
* Themes
	* Dark mode for *Origine* and *Origine compact* themes [#4843](https://github.com/FreshRSS/FreshRSS/pull/4843)
	* Improve *Ansum* and *Mapco* [#4938](https://github.com/FreshRSS/FreshRSS/pull/4938), [#4959](https://github.com/FreshRSS/FreshRSS/pull/4959), [#4967](https://github.com/FreshRSS/FreshRSS/pull/4967),
		[#4983](https://github.com/FreshRSS/FreshRSS/pull/4983), [#4995](https://github.com/FreshRSS/FreshRSS/pull/4995)
	* Improve *Dark pink* [#4881](https://github.com/FreshRSS/FreshRSS/pull/4881)
	* Improve *Nord theme* [#4892](https://github.com/FreshRSS/FreshRSS/pull/4892), [#4979](https://github.com/FreshRSS/FreshRSS/pull/4979)
	* Improve *Origine* [#4893](https://github.com/FreshRSS/FreshRSS/pull/4893)
	* Improve *Origine compact* [#4873](https://github.com/FreshRSS/FreshRSS/pull/4873)
	* Improve *Pafat* [#4909](https://github.com/FreshRSS/FreshRSS/pull/4909)
	* Improve *Swage* [#4875](https://github.com/FreshRSS/FreshRSS/pull/4875), [#4922](https://github.com/FreshRSS/FreshRSS/pull/4922), [#4936](https://github.com/FreshRSS/FreshRSS/pull/4936),
		[#5029](https://github.com/FreshRSS/FreshRSS/pull/5029)
	* Mark some themes as tentatively deprecated: *BlueLagoon*, *Flat*, *Screwdriver* [#4807](https://github.com/FreshRSS/FreshRSS/pull/4807)
* i18n
	* Improve Chinese [#4853](https://github.com/FreshRSS/FreshRSS/pull/4853), [#4856](https://github.com/FreshRSS/FreshRSS/pull/4856)
* SimplePie
	* No URL Decode for enclosure links [simplepie#768](https://github.com/simplepie/simplepie/pull/768)
	* Fix case of multiple RSS2.0 enclosures [simplepie#769](https://github.com/simplepie/simplepie/pull/769)
	* Sanitize thumbnail URL [simplepie#770](https://github.com/simplepie/simplepie/pull/770)
	* Use single constant for default HTTP Accept header [simplepie#784](https://github.com/simplepie/simplepie/pull/784)
* Misc.
	* Increase max feed URL length and drop unicity in database [#5038](https://github.com/FreshRSS/FreshRSS/pull/5038)
	* New support of [Development Containers](https://containers.dev) / [GitHub Codespaces](https://github.com/features/codespaces) to ease development [#4859](https://github.com/FreshRSS/FreshRSS/pull/4859)
	* Update library `lib_opml` [#4403](https://github.com/FreshRSS/FreshRSS/pull/4403)
	* Code improvements [#4232](https://github.com/FreshRSS/FreshRSS/pull/4232), [#4651](https://github.com/FreshRSS/FreshRSS/pull/4651),
		[#5024](https://github.com/FreshRSS/FreshRSS/pull/5024), [#5025](https://github.com/FreshRSS/FreshRSS/pull/5025), [#5028](https://github.com/FreshRSS/FreshRSS/pull/5028),
		[#5032](https://github.com/FreshRSS/FreshRSS/pull/5032), [#5158](https://github.com/FreshRSS/FreshRSS/pull/5158), [#5045](https://github.com/FreshRSS/FreshRSS/pull/5045),
		[#5049](https://github.com/FreshRSS/FreshRSS/pull/5049), [#5063](https://github.com/FreshRSS/FreshRSS/pull/5063), [#5084](https://github.com/FreshRSS/FreshRSS/pull/5084)
	* Update dev dependencies [#4993](https://github.com/FreshRSS/FreshRSS/pull/4993), [#5006](https://github.com/FreshRSS/FreshRSS/pull/5006), [#5109](https://github.com/FreshRSS/FreshRSS/pull/5109)


## 2022-12-08 FreshRSS 1.20.2

* Security fixes
	* [CVE-2022-23497](https://github.com/FreshRSS/FreshRSS/security/advisories/GHSA-hvrj-5fwj-p7v6) Fix security vulnerability in `ext.php` [#4928](https://github.com/FreshRSS/FreshRSS/pull/4928)
	* Apache `TraceEnable Off` [#4863](https://github.com/FreshRSS/FreshRSS/pull/4863)


## 2022-11-14 FreshRSS 1.20.1

* Features
	* Add support for custom XPath date/time format [#4703](https://github.com/FreshRSS/FreshRSS/pull/4703)
	* Add default redirect when authenticating [#4778](https://github.com/FreshRSS/FreshRSS/pull/4778)
	* Force default user before rendering login page [#4620](https://github.com/FreshRSS/FreshRSS/pull/4620)
* API
	* Minor Google Reader API improvements [#4763](https://github.com/FreshRSS/FreshRSS/pull/4763)
* Bug fixing
	* Fix SQL transaction rollbacks during auto-update [#4622](https://github.com/FreshRSS/FreshRSS/pull/4622)
	* Fix `opcache` bug during Web update [#4629](https://github.com/FreshRSS/FreshRSS/pull/4629), [update.freshrss.org#4](https://github.com/FreshRSS/update.freshrss.org/pull/4)
	* Fix export bug [#4822](https://github.com/FreshRSS/FreshRSS/pull/4822)
	* Fix OPML import of special feed attributes [#4708](https://github.com/FreshRSS/FreshRSS/pull/4708)
	* Fix JavaScript bug with remembering opened categories [#4827](https://github.com/FreshRSS/FreshRSS/pull/4827)
	* Fix `curlopt` options for HTML+XPath [#4759](https://github.com/FreshRSS/FreshRSS/pull/4759)
	* Fix charset bug for HTML+XPath [#4623](https://github.com/FreshRSS/FreshRSS/pull/4623)
	* Fix HTML-encoding of CSS selectors [#4707](https://github.com/FreshRSS/FreshRSS/pull/4707), [#4823](https://github.com/FreshRSS/FreshRSS/pull/4823)
	* Fix some broken author links [#4743](https://github.com/FreshRSS/FreshRSS/pull/4743)
	* Fix show settings page after adding new feed [#4631](https://github.com/FreshRSS/FreshRSS/pull/4631)
	* Fix login page when user does not exist [#4621](https://github.com/FreshRSS/FreshRSS/pull/4621)
	* Fix feed manage link on stats page [#4768](https://github.com/FreshRSS/FreshRSS/pull/4768)
	* Fix minor layout bugs [#4830](https://github.com/FreshRSS/FreshRSS/pull/4830)
	* Fix minor UI bugs with Safari [#4643](https://github.com/FreshRSS/FreshRSS/pull/4643)
* UI
	* Change some default settings related to marking articles as read [#4736](https://github.com/FreshRSS/FreshRSS/pull/4736)
	* Improve scrollbar when slider is open [#4692](https://github.com/FreshRSS/FreshRSS/pull/4692)
	* Improve Subscription Management: Show the category position number [#4679](https://github.com/FreshRSS/FreshRSS/pull/4679)
	* Improve Reader view: Mark article as read while scrolling [#4652](https://github.com/FreshRSS/FreshRSS/pull/4652)
	* Improve sharing / integration page [#4774](https://github.com/FreshRSS/FreshRSS/pull/4774)
	* Improve article summary text cut [#4666](https://github.com/FreshRSS/FreshRSS/pull/4666)
	* Improve HTML semantics for some boxes [#4665](https://github.com/FreshRSS/FreshRSS/pull/4665)
	* Change dynamic OPML icon [#4673](https://github.com/FreshRSS/FreshRSS/pull/4673), [#4810](https://github.com/FreshRSS/FreshRSS/pull/4810)
	* Improve box layout for global view [#4791](https://github.com/FreshRSS/FreshRSS/pull/4791)
	* Improve logs layout [#4594](https://github.com/FreshRSS/FreshRSS/pull/4594)
	* Improve Feed configuration: number of articles [#4625](https://github.com/FreshRSS/FreshRSS/pull/4625)
	* Improve drop-down menus [#4597](https://github.com/FreshRSS/FreshRSS/pull/4597)
	* Show tile with explanation when hovering empty feeds [#4617](https://github.com/FreshRSS/FreshRSS/pull/4617)
	* Added bottom nav padding for iOS [#4741](https://github.com/FreshRSS/FreshRSS/pull/4741)
* Themes
	* Implement CSS variables for easy colour customisation [#4641](https://github.com/FreshRSS/FreshRSS/pull/4641), [#4693](https://github.com/FreshRSS/FreshRSS/pull/4693), [#4789](https://github.com/FreshRSS/FreshRSS/pull/4789)
	* Improve CSS line height [#4671](https://github.com/FreshRSS/FreshRSS/pull/4671), [#4782](https://github.com/FreshRSS/FreshRSS/pull/4782)
	* Improved reader view with framed articles [#4663](https://github.com/FreshRSS/FreshRSS/pull/4663)
	* Improve themes
	Alternative Dark [#4635](https://github.com/FreshRSS/FreshRSS/pull/4635), [#4797](https://github.com/FreshRSS/FreshRSS/pull/4797);
	Blue Lagon [#4786](https://github.com/FreshRSS/FreshRSS/pull/4786);
	Dark [#4806](https://github.com/FreshRSS/FreshRSS/pull/4806);
	Mapco [#4648](https://github.com/FreshRSS/FreshRSS/pull/4648), [#4709](https://github.com/FreshRSS/FreshRSS/pull/4709), [#4711](https://github.com/FreshRSS/FreshRSS/pull/4711);
	Origine [#4842](https://github.com/FreshRSS/FreshRSS/pull/4842);
	Origine Compact [#4636](https://github.com/FreshRSS/FreshRSS/pull/4636), [#4735](https://github.com/FreshRSS/FreshRSS/pull/4735), [#4787](https://github.com/FreshRSS/FreshRSS/pull/4787);
	Pafat [#4783](https://github.com/FreshRSS/FreshRSS/pull/4783), [#4792](https://github.com/FreshRSS/FreshRSS/pull/4792), [#4793](https://github.com/FreshRSS/FreshRSS/pull/4793),
	[#4796](https://github.com/FreshRSS/FreshRSS/pull/4796), [#4811](https://github.com/FreshRSS/FreshRSS/pull/4811);
	Swage [#4799](https://github.com/FreshRSS/FreshRSS/pull/4799), [#4828](https://github.com/FreshRSS/FreshRSS/pull/4828), [#4829](https://github.com/FreshRSS/FreshRSS/pull/4829)
	* Rename `template.css` to `frss.css` [#4644](https://github.com/FreshRSS/FreshRSS/pull/4644)
	* Misc. [#4596](https://github.com/FreshRSS/FreshRSS/pull/4596), [#4619](https://github.com/FreshRSS/FreshRSS/pull/4619), [#4696](https://github.com/FreshRSS/FreshRSS/pull/4696)
* i18n
	* Rename *tag* to *label* in some languages [#4770](https://github.com/FreshRSS/FreshRSS/pull/4770)
	* Improve typographic quotes [#4714](https://github.com/FreshRSS/FreshRSS/pull/4714)
	* Remove invalid i18n string [#4844](https://github.com/FreshRSS/FreshRSS/pull/4844)
	* Add Greek [#4718](https://github.com/FreshRSS/FreshRSS/pull/4718), [#4754](https://github.com/FreshRSS/FreshRSS/pull/4754)
	* Add Indonesian [#4706](https://github.com/FreshRSS/FreshRSS/pull/4706)
	* Improve Brazilian Portuguese [#4669](https://github.com/FreshRSS/FreshRSS/pull/4669)
	* Improve Czech [#4670](https://github.com/FreshRSS/FreshRSS/pull/4670)
	* Improve Italian [#4803](https://github.com/FreshRSS/FreshRSS/pull/4803)
	* Improve Japanese [#4668](https://github.com/FreshRSS/FreshRSS/pull/4668)
	* Improve Russian [#4719](https://github.com/FreshRSS/FreshRSS/pull/4719)
	* Improve Spanish [#4676](https://github.com/FreshRSS/FreshRSS/pull/4676), [#4725](https://github.com/FreshRSS/FreshRSS/pull/4725)
	* Improve Turkish [#4715](https://github.com/FreshRSS/FreshRSS/pull/4715)
	* Improve i18n tools [#4742](https://github.com/FreshRSS/FreshRSS/pull/4742), [#4756](https://github.com/FreshRSS/FreshRSS/pull/4756)
* Compatibility
	* Compatibility PHP 8.1+ `strip_tags()` [#4688](https://github.com/FreshRSS/FreshRSS/pull/4688)
	* Fix `GLOB_BRACE` is not available on all platforms [#4628](https://github.com/FreshRSS/FreshRSS/pull/4628)
* Deployment
	* Docker default image (Debian 11 Bullseye) updated to PHP 7.4.33
	* Docker: alternative image (Alpine 3.16) updated to PHP 8.0.25
* Misc.
	* Added *Linkding* as a sharing method [#4721](https://github.com/FreshRSS/FreshRSS/pull/4721)
	* Exclude `.git/` from tests [#4824](https://github.com/FreshRSS/FreshRSS/pull/4824)
	* Exclude `extensions/` from eslint and stylelint tests [#4606](https://github.com/FreshRSS/FreshRSS/pull/4606)
	* Update GitHub Actions version [#4717](https://github.com/FreshRSS/FreshRSS/pull/4717)


## 2022-09-10 FreshRSS 1.20.0

* Features
	* New Web scraping feature *HTML+XPath* for Web pages without any RSS/ATOM feed [#4220](https://github.com/FreshRSS/FreshRSS/pull/4220)
	* Add support for *Dynamic OPML* [#4407](https://github.com/FreshRSS/FreshRSS/pull/4407)
		* Subscriber: Ability for a category to be dynamically populated with a list of feeds provided by a remote OPML
		* Publisher: Ability to dynamically export a FreshRSS view (all, feed, category) into a dynamic OPML
	* New search engine supporting (nested) parentheses [#4378](https://github.com/FreshRSS/FreshRSS/pull/4378), [#4503](https://github.com/FreshRSS/FreshRSS/pull/4503)
		* `(author:Alice OR intitle:hello) (author:Bob OR intitle:world)`
		* also with negation: `!((author:Alice intitle:hello) OR (author:Bob intitle:world))`
		* and supporting calling user queries from the search field by name: `search:"My query"` or `search:QueryA`, or by ID: `S:3`
	* Allow many (50k+) feeds [#4347](https://github.com/FreshRSS/FreshRSS/pull/4347)
		* Note: only for new users or after an export/import or a manual database update
		* See also [#4357](https://github.com/FreshRSS/FreshRSS/pull/4357), [#4353](https://github.com/FreshRSS/FreshRSS/pull/4353),
		[#4417](https://github.com/FreshRSS/FreshRSS/pull/4417), [#4502](https://github.com/FreshRSS/FreshRSS/pull/4502)
	* New option to exclude some DOM elements with a CSS Selector when retrieving an article full content [#4501](https://github.com/FreshRSS/FreshRSS/pull/4501)
	* New option to automatically mark as read gone articles [#4426](https://github.com/FreshRSS/FreshRSS/pull/4426)
	* New OPML export/import of some proprietary FreshRSS attributes [#4342](https://github.com/FreshRSS/FreshRSS/pull/4342)
	* Tolerate the import of some invalid OPML files [#4591](https://github.com/FreshRSS/FreshRSS/pull/4591)
	* New feed settings to allow cookies and HTTP redirects [#4470](https://github.com/FreshRSS/FreshRSS/pull/4470)
	* Performance: Easier [text search indexes](https://freshrss.github.io/FreshRSS/en/admins/DatabaseConfig.html) for fast searches with PostgreSQL [#4505](https://github.com/FreshRSS/FreshRSS/pull/4505)
		* The indexes must be manually added for now. Using GIN `pg_trgm`
	* Easier definition of default user queries for new users in `data/config-user.custom.php` [#4360](https://github.com/FreshRSS/FreshRSS/pull/4360)
	* New sharing through standard [Web Share API](https://www.w3.org/TR/web-share/) [#4271](https://github.com/FreshRSS/FreshRSS/pull/4271)
	* New sharing with Xing, Reddit, Pinterest, WhatsApp [#4270](https://github.com/FreshRSS/FreshRSS/pull/4270)
	* New sharing with [`archive.today`](https://archive.ph/) [#4530](https://github.com/FreshRSS/FreshRSS/pull/4530)
* SimplePie
	* New method `rename_attribute()` instead of removing attributes to better be able to style/hide content of articles [#4175](https://github.com/FreshRSS/FreshRSS/pull/4175),
	[simplepie#717](https://github.com/simplepie/simplepie/pull/717)
	* Fix parsing of HTTP Links [simplepie#729](https://github.com/simplepie/simplepie/pull/729)
	* Fix `status_code` type for PHP 8.1+ [simplepie#728](https://github.com/simplepie/simplepie/pull/728)
	* Fix relative URLs [simplepie#744](https://github.com/simplepie/simplepie/pull/744)
* Bug fixing
	* Fix last update & archive logic (especially for very long feeds, for which some old items were marked as unread) [#4422](https://github.com/FreshRSS/FreshRSS/pull/4422)
	* Fix regression with Fever API on 32-bit platforms [#4201](https://github.com/FreshRSS/FreshRSS/pull/4201)
	* Fix read-when-same-title bug [#4206](https://github.com/FreshRSS/FreshRSS/pull/4206)
	* Fix some search expressions such as `"ab cd"` and `ab-cd` [#4277](https://github.com/FreshRSS/FreshRSS/pull/4277)
	* Fix auto-load of more articles when using shortcuts [#4532](https://github.com/FreshRSS/FreshRSS/pull/4532)
	* Fix <kbd>space</kbd> shortcut [#4581](https://github.com/FreshRSS/FreshRSS/pull/4581)
	* WebSub: Use hash instead of base64 to handle long URLs [#4282](https://github.com/FreshRSS/FreshRSS/pull/4282)
	* Fix handling of authors with ampersand `&` [#4287](https://github.com/FreshRSS/FreshRSS/pull/4287)
	* Fix lazy loading images containing a quote `'` in the address [#4330](https://github.com/FreshRSS/FreshRSS/pull/4330)
	* Fix database size calculation for PostgreSQL [#4249](https://github.com/FreshRSS/FreshRSS/pull/4249)
	* Fix HTTP root redirection in some cases (trailing slash with a proxy) [#4167](https://github.com/FreshRSS/FreshRSS/pull/4167)
	* Fix `htmlspecialchars()` warnings with PHP 8.1+ [#4411](https://github.com/FreshRSS/FreshRSS/pull/4411)
	* Fix OPML category encoding [#4427](https://github.com/FreshRSS/FreshRSS/pull/4427)
	* Fix one category of favicon update problem [#4358](https://github.com/FreshRSS/FreshRSS/pull/4358)
	* Fix rare mark-as-read bug [#4456](https://github.com/FreshRSS/FreshRSS/pull/4456)
	* Add missing extension hook `freshrss_user_maintenance` in CLI [#4495](https://github.com/FreshRSS/FreshRSS/pull/4495)
	* Rename conflicting function `errorMessage()` which exists on some platforms [#4289](https://github.com/FreshRSS/FreshRSS/pull/4289)
	* Fix remain of bookmarklet [#4240](https://github.com/FreshRSS/FreshRSS/pull/4240)
* UI
	* Performance: Automatic simplification of layout for 1000+ feeds [#4357](https://github.com/FreshRSS/FreshRSS/pull/4357)
	* Performance: New option *icons-as-emojis* [#4353](https://github.com/FreshRSS/FreshRSS/pull/4353)
	* Manage feed configuration using a dynamic slider view [#4226](https://github.com/FreshRSS/FreshRSS/pull/4226), [#4297](https://github.com/FreshRSS/FreshRSS/pull/4297), [#4394](https://github.com/FreshRSS/FreshRSS/pull/4394)
	* New option for custom HTML logo/title in the main Web UI view [#4369](https://github.com/FreshRSS/FreshRSS/pull/4369)
	* Show errored, empty, muted feeds in statistics [#4276](https://github.com/FreshRSS/FreshRSS/pull/4276)
	* Improve configuration of registration form [#3932](https://github.com/FreshRSS/FreshRSS/pull/3932)
	* Improve subscription list drag & drop [#3953](https://github.com/FreshRSS/FreshRSS/pull/3953)
	* Improve extension manager [#4181](https://github.com/FreshRSS/FreshRSS/pull/4181)
	* Improve idle feeds list [#4192](https://github.com/FreshRSS/FreshRSS/pull/4192)
	* Improve feed link in normal view [#4006](https://github.com/FreshRSS/FreshRSS/pull/4006)
	* Improve browser notification for unread message [#4193](https://github.com/FreshRSS/FreshRSS/pull/4193)
	* Improve notification banner [#4023](https://github.com/FreshRSS/FreshRSS/pull/4023)
	* Improve new article banner [#4037](https://github.com/FreshRSS/FreshRSS/pull/4037)
	* Improve pagination + *load more* button [#4125](https://github.com/FreshRSS/FreshRSS/pull/4125)
	* Improve log view [#4204](https://github.com/FreshRSS/FreshRSS/pull/4204)
	* Improve unread articles counter in normal view [#4166](https://github.com/FreshRSS/FreshRSS/pull/4166)
	* Automatically set the category when adding a feed from an existing category [#4333](https://github.com/FreshRSS/FreshRSS/pull/4333)
	* Better PWA colours for mobile [#4254](https://github.com/FreshRSS/FreshRSS/pull/4254)
	* Improve article footer [#4306](https://github.com/FreshRSS/FreshRSS/pull/4306)
	* Various UI and style improvements [#4205](https://github.com/FreshRSS/FreshRSS/pull/4205), [#4212](https://github.com/FreshRSS/FreshRSS/pull/4212), [#4218](https://github.com/FreshRSS/FreshRSS/pull/4218),
	[#4238](https://github.com/FreshRSS/FreshRSS/pull/4238), [#4455](https://github.com/FreshRSS/FreshRSS/pull/4455), [#4298](https://github.com/FreshRSS/FreshRSS/pull/4298),
	[#4383](https://github.com/FreshRSS/FreshRSS/pull/4383), [#4452](https://github.com/FreshRSS/FreshRSS/pull/4452), [#4455](https://github.com/FreshRSS/FreshRSS/pull/4455),
	[#4466](https://github.com/FreshRSS/FreshRSS/pull/4466), [#4471](https://github.com/FreshRSS/FreshRSS/pull/4471), [#4472](https://github.com/FreshRSS/FreshRSS/pull/4472),
	[#4474](https://github.com/FreshRSS/FreshRSS/pull/4474), [#4498](https://github.com/FreshRSS/FreshRSS/pull/4498), [#4502](https://github.com/FreshRSS/FreshRSS/pull/4502),
	[#4504](https://github.com/FreshRSS/FreshRSS/pull/4504), [#4558](https://github.com/FreshRSS/FreshRSS/pull/4558), [#4546](https://github.com/FreshRSS/FreshRSS/pull/4546),
	[#4541](https://github.com/FreshRSS/FreshRSS/pull/4541)
* Themes
	* New theme *Dark pink* [#4311](https://github.com/FreshRSS/FreshRSS/pull/4311)
	* New theme *Nord* [#4400](https://github.com/FreshRSS/FreshRSS/pull/4400)
	* Improve themes *Alternative Dark* [#4587](https://github.com/FreshRSS/FreshRSS/pull/4587);
	*Ansum* [#4538](https://github.com/FreshRSS/FreshRSS/pull/4538), [#4549](https://github.com/FreshRSS/FreshRSS/pull/4549);
	*Flat* [#4575](https://github.com/FreshRSS/FreshRSS/pull/4575);
	*Mapco* [#4491](https://github.com/FreshRSS/FreshRSS/pull/4491), [#4491](https://github.com/FreshRSS/FreshRSS/pull/4491);
	*Swage* [#4493](https://github.com/FreshRSS/FreshRSS/pull/4493), [#4512](https://github.com/FreshRSS/FreshRSS/pull/4512), [#4566](https://github.com/FreshRSS/FreshRSS/pull/4566)
* Extensions
	* Allow extensions using `entry_before_insert` to change `entry->isRead()` [#4331](https://github.com/FreshRSS/FreshRSS/pull/4331)
* i18n
	* Improve i18n CLI [#4197](https://github.com/FreshRSS/FreshRSS/pull/4197), [#4199](https://github.com/FreshRSS/FreshRSS/pull/4199)
	* Add Chinese (Traditional) [#4578](https://github.com/FreshRSS/FreshRSS/pull/4578)
	* Improve Chinese (Simplified) [#4332](https://github.com/FreshRSS/FreshRSS/pull/4332), [#4337](https://github.com/FreshRSS/FreshRSS/pull/4337), [#4379](https://github.com/FreshRSS/FreshRSS/pull/4379),
	[#4509](https://github.com/FreshRSS/FreshRSS/pull/4509), [#4577](https://github.com/FreshRSS/FreshRSS/pull/4577)
	* Improve English [#4450](https://github.com/FreshRSS/FreshRSS/pull/4450)
	* Improve German [#4525](https://github.com/FreshRSS/FreshRSS/pull/4525)
	* Improve Korean [#4572](https://github.com/FreshRSS/FreshRSS/pull/4572)
	* Improve Occitan [#4548](https://github.com/FreshRSS/FreshRSS/pull/4548)
	* Improve Polish [#4363](https://github.com/FreshRSS/FreshRSS/pull/4363)
	* Improve Russian [#4385](https://github.com/FreshRSS/FreshRSS/pull/4385)
	* Improve Slovak [#4524](https://github.com/FreshRSS/FreshRSS/pull/4524)
* API
	* Restrict maximum length of item content length for clients compatibility [#4583](https://github.com/FreshRSS/FreshRSS/pull/4583)
	* Supported by [Fluent Reader Lite](https://hyliu.me/fluent-reader-lite/) [#4595](https://github.com/FreshRSS/FreshRSS/pull/4595)
* Deployment
	* Docker: Performance: entrypoint fix buffering, problematic when importing large OPMLs during install [#4417](https://github.com/FreshRSS/FreshRSS/pull/4417)
	* Docker default image (Debian 11 Bullseye) updated to PHP 7.4.30 and Apache 2.4.54
	* Docker: alternative image updated to Alpine 3.16 with PHP 8.0.22 and Apache 2.4.54 [#4391](https://github.com/FreshRSS/FreshRSS/pull/4391)
		* Add PHP extensions `php-openssl` (used by PHPMailer) and `php-xml` (used by SimplePie) [#4420](https://github.com/FreshRSS/FreshRSS/pull/4420)
	* Docker: Upgraded dev image `freshrss/freshrss:newest` to PHP 8.2 [#4420](https://github.com/FreshRSS/FreshRSS/pull/4420)
	* Include PHP extensions in Composer for easier automated deployment [#4497](https://github.com/FreshRSS/FreshRSS/pull/4497)
	* Improved trimming of `base_url` to avoid some common configuration bugs, especially via Docker / CLI [#4423](https://github.com/FreshRSS/FreshRSS/pull/4423)
* CLI
	* Allow empty DB prefix [#4488](https://github.com/FreshRSS/FreshRSS/pull/4488)
* Compatibility
	* Initial support for PHP 8.2+ [#4420](https://github.com/FreshRSS/FreshRSS/pull/4420), [#4421](https://github.com/FreshRSS/FreshRSS/pull/4421)
* Security
	* Improved error page, properly returning HTTP 500 and CSP [#4465](https://github.com/FreshRSS/FreshRSS/pull/4465)
* Misc.
	* Replace `lib_phpQuery` by [`PhpGt/CssXPath`](https://github.com/PhpGt/CssXPath) library for full content retrieval [#4261](https://github.com/FreshRSS/FreshRSS/pull/4261)
		* Add support for star CSS Selectors such as `a[href*="example"]` [CssXPath#181](https://github.com/PhpGt/CssXPath/pull/181)
	* Performance: Do not render irrelevant HTML for Ajax calls [#4310](https://github.com/FreshRSS/FreshRSS/pull/4310), [#4366](https://github.com/FreshRSS/FreshRSS/pull/4366)
	* Performance: New limit option when reloading a feed [#4370](https://github.com/FreshRSS/FreshRSS/pull/4370)
	* Optional possibility to use Composer to update some libraries [#4329](https://github.com/FreshRSS/FreshRSS/pull/4329), [#4368](https://github.com/FreshRSS/FreshRSS/pull/4368)
		* Update to PHPMailer 6.6.0 [#4329](https://github.com/FreshRSS/FreshRSS/pull/4329)
	* Use `.gitattributes` `export-ignore` [#4415](https://github.com/FreshRSS/FreshRSS/pull/4415)
	* Remove HTTP Referer for HTML download [#4372](https://github.com/FreshRSS/FreshRSS/pull/4372)
	* Add database field `attributes` (JSON) for entries [#4444](https://github.com/FreshRSS/FreshRSS/pull/4444)
	* Improve dev automated checks [#4209](https://github.com/FreshRSS/FreshRSS/pull/4209)
	* Update dev dependencies [#4173](https://github.com/FreshRSS/FreshRSS/pull/4173), [#4203](https://github.com/FreshRSS/FreshRSS/pull/4203), [#4241](https://github.com/FreshRSS/FreshRSS/pull/4241),
	[#4419](https://github.com/FreshRSS/FreshRSS/pull/4419), [#4424](https://github.com/FreshRSS/FreshRSS/pull/4424)
	* Fix extension list warning when offline[#4571](https://github.com/FreshRSS/FreshRSS/pull/4571)
	* Code improvements [#4130](https://github.com/FreshRSS/FreshRSS/pull/4130), [#4194](https://github.com/FreshRSS/FreshRSS/pull/4194), [#4201](https://github.com/FreshRSS/FreshRSS/pull/4201),
	[#4202](https://github.com/FreshRSS/FreshRSS/pull/4202), [#4258](https://github.com/FreshRSS/FreshRSS/pull/4258), [#4263](https://github.com/FreshRSS/FreshRSS/pull/4263),
	[#4356](https://github.com/FreshRSS/FreshRSS/pull/4356), [#4436](https://github.com/FreshRSS/FreshRSS/pull/4436), [#4489](https://github.com/FreshRSS/FreshRSS/pull/4489),
	[#4490](https://github.com/FreshRSS/FreshRSS/pull/4490), [#4496](https://github.com/FreshRSS/FreshRSS/pull/4496)


## 2022-02-04 FreshRSS 1.19.2

* Bug fixing
	* Fix regression regarding keeping read state after seeing favourites / labels [#4178](https://github.com/FreshRSS/FreshRSS/pull/4178)
	* Fix migration system on Synology and systems adding custom files to folders [#4163](https://github.com/FreshRSS/FreshRSS/pull/4163)
	* Fix wrong dropdown triangle UI for labels [#4174](https://github.com/FreshRSS/FreshRSS/pull/4174)
	* Fix minor UI bugs [#4169](https://github.com/FreshRSS/FreshRSS/pull/4169), [#4189](https://github.com/FreshRSS/FreshRSS/pull/4189), [#4188](https://github.com/FreshRSS/FreshRSS/pull/4188)
	* Fix minor SCSS details for the themes Ansum and Mapco [#4146](https://github.com/FreshRSS/FreshRSS/pull/4146)
* UI
	* Improve dropdown menus on mobile view [#4141](https://github.com/FreshRSS/FreshRSS/pull/4141), [#4128](https://github.com/FreshRSS/FreshRSS/pull/4128)
	* Improve menu icons [#4004](https://github.com/FreshRSS/FreshRSS/pull/4004)
* Features
	* Support JSON import with date in milliseconds (e.g., Feedly) [#4186](https://github.com/FreshRSS/FreshRSS/pull/4186)
* Deployment
	* Docker: development image `:newest` updated to PHP 8.1.1 and Apache 2.4.52 [#3666](https://github.com/FreshRSS/FreshRSS/pull/3666)
* i18n
	* Improve i18n CLI [#4131](https://github.com/FreshRSS/FreshRSS/pull/4131)
	* Use typographic quotes [#4133](https://github.com/FreshRSS/FreshRSS/pull/4133)
	* Improve message regarding forced feeds [#4145](https://github.com/FreshRSS/FreshRSS/pull/4145)
	* Improve Czech [#4151](https://github.com/FreshRSS/FreshRSS/pull/4151)
	* Improve English [#4161](https://github.com/FreshRSS/FreshRSS/pull/4161)
* Misc.
	* Increase PHPStan to [level 5](https://phpstan.org/user-guide/rule-levels) for code quality, also fixing several PHP 8.1 warnings [#4110](https://github.com/FreshRSS/FreshRSS/pull/4110), [#4123](https://github.com/FreshRSS/FreshRSS/pull/4123), [#4119](https://github.com/FreshRSS/FreshRSS/pull/4119), [#4182](https://github.com/FreshRSS/FreshRSS/pull/4182)
	* Clean temporary files generated by automated tests [#4177](https://github.com/FreshRSS/FreshRSS/pull/4177)
	* Add automated spell checking of the code using [typos](https://github.com/crate-ci/typos) [#4138](https://github.com/FreshRSS/FreshRSS/pull/4138), [#4134](https://github.com/FreshRSS/FreshRSS/pull/4134)
	* Enforce code style *opening brace on same line* in PHPCS [#4122](https://github.com/FreshRSS/FreshRSS/pull/4122)
	* Remove broken GitHub Action automatically adding the `latest` tag to git [#4135](https://github.com/FreshRSS/FreshRSS/pull/4135)


## 2022-01-02 FreshRSS 1.19.1

* Bug fixing
	* Fix some filters for automatic article actions (e.g., `!pubdate:P3d`) [#4092](https://github.com/FreshRSS/FreshRSS/pull/4092)
* Features
	* New search operator on article IDs (useful to show a single article, extensions) [#4058](https://github.com/FreshRSS/FreshRSS/pull/4058)
		* Entry (article) ID: `e:1639310674957894` or multiple entry IDs (*or*): `e:1639310674957894,1639310674957893`
* UI
	* Fix left navigation with long category names [#4055](https://github.com/FreshRSS/FreshRSS/pull/4055)
	* Show *My labels* menu also when empty [#4065](https://github.com/FreshRSS/FreshRSS/pull/4065)
	* Improve category titles on global view [#4059](https://github.com/FreshRSS/FreshRSS/pull/4059)
	* Disable dynamic favicon for browser / extensions blocking canvas [#4098](https://github.com/FreshRSS/FreshRSS/pull/4098)
	* Minor UI and style improvements [#4061](https://github.com/FreshRSS/FreshRSS/pull/4061), [#4067](https://github.com/FreshRSS/FreshRSS/pull/4067), [#4085](https://github.com/FreshRSS/FreshRSS/pull/4085)
* SimplePie
	* Manual update to SimplePie 1.5.8 [#4113](https://github.com/FreshRSS/FreshRSS/pull/4113)
* Code improvements
	* Add PHPStan [level 1](https://phpstan.org/user-guide/rule-levels) for code quality [#4021](https://github.com/FreshRSS/FreshRSS/pull/4021)


## 2021-12-31 FreshRSS 1.19.0

* Features
	* New thumbnail and/or summary options for the normal view [#3805](https://github.com/FreshRSS/FreshRSS/pull/3805)
	* New setting to automatically mark as read a new article if there is already one with the same title in the same feed [#3303](https://github.com/FreshRSS/FreshRSS/pull/3303)
	* New setting to keep only a maximum number of unread articles in a given feed [#3303](https://github.com/FreshRSS/FreshRSS/pull/3303)
	* New search operator based on custom labels, or not [#3709](https://github.com/FreshRSS/FreshRSS/pull/3709)
		* Search articles with label IDs: `L:12,13,14` or label names: `label:something` or `labels:"my label,my other label,🧪"`
		* Search articles with any label: `L:*` or no label: `!L:*`
	* Add support for installable progressive web app (PWA) [#3890](https://github.com/FreshRSS/FreshRSS/pull/3890)
* Bug fixing
	* Fix marking as read a label with SQLite and PostgreSQL [#3711](https://github.com/FreshRSS/FreshRSS/pull/3711)
	* Better fallback for feeds without title [#3787](https://github.com/FreshRSS/FreshRSS/pull/3787)
	* Fix auto-load articles in anonymous mode and global view [#4082](https://github.com/FreshRSS/FreshRSS/pull/4082)
	* Fix several typos found by PHPStan, including one affecting the cache of *keep max unread articles* [#4019](https://github.com/FreshRSS/FreshRSS/pull/4019)
	* Fix warning in Fever API [#4056](https://github.com/FreshRSS/FreshRSS/pull/4056)
	* Show *no articles* alert-box also in global view [#4042](https://github.com/FreshRSS/FreshRSS/pull/4042), [#3099](https://github.com/FreshRSS/FreshRSS/pull/3999)
	* Fix theme selection when a theme has been deleted [#3874](https://github.com/FreshRSS/FreshRSS/pull/3874)
	* Fix keyboard shortcuts in anonymous mode [#3945](https://github.com/FreshRSS/FreshRSS/pull/3945)
	* Fix show password in settings [#3966](https://github.com/FreshRSS/FreshRSS/pull/3966)
	* Fix JavaScript warnings for non-validated users [#3980](https://github.com/FreshRSS/FreshRSS/pull/3980)
	* Fix drag & drop layout for subscriptions [#3949](https://github.com/FreshRSS/FreshRSS/pull/3949)
* Security
	* Better error handling when a user does not exist (especially for API) [#3751](https://github.com/FreshRSS/FreshRSS/pull/3751), [#4084](https://github.com/FreshRSS/FreshRSS/pull/4084)
	* Do not show *Add new feed* for anonymous users [#4040](https://github.com/FreshRSS/FreshRSS/pull/4040)
	* Do not show *Mark as read / unread / favourite* for anonymous users [#3871](https://github.com/FreshRSS/FreshRSS/pull/3871), [#3876](https://github.com/FreshRSS/FreshRSS/pull/3876)
	* Do not show back link on error pages if the user does not have access [#3765](https://github.com/FreshRSS/FreshRSS/pull/3765)
	* Only show *Back to RSS feeds* when logged-in [#3790](https://github.com/FreshRSS/FreshRSS/pull/3790)
	* Fix for special characters in keyboard shortcuts [#3922](https://github.com/FreshRSS/FreshRSS/issues/3922)
	* Remove old workarounds with white space to prevent password autocompletion [#3814](https://github.com/FreshRSS/FreshRSS/pull/3814)
* Compatibility
	* Require PHP 7.0+ (drop support for PHP 5.x) [#3666](https://github.com/FreshRSS/FreshRSS/pull/3666)
	* Drop support for Microsoft Internet Explorer (IE11) [#3666](https://github.com/FreshRSS/FreshRSS/pull/3666)
	* Fix some warnings with PHP 8.1+ [#4012](https://github.com/FreshRSS/FreshRSS/pull/4012), [#4018](https://github.com/FreshRSS/FreshRSS/pull/4018)
	* Fix back-compatibility with Git 2.21- for automatic updates [#3669](https://github.com/FreshRSS/FreshRSS/pull/3669)
	* Fix JavaScript caching and compression for some Apache platforms [#4075](https://github.com/FreshRSS/FreshRSS/pull/4075)
* Deployment
	* Docker: development image `:oldest` is now based on `alpine:3.5` with PHP 7.0.33 and Apache 2.4.35 [#3666](https://github.com/FreshRSS/FreshRSS/pull/3666)
	* Docker: default image updated to Debian 11 Bullseye with PHP 7.4.25 and Apache 2.4.51 [#3782](https://github.com/FreshRSS/FreshRSS/pull/3782)
	* Docker: alternative image updated to Alpine 3.15 with PHP 8.0.14 and Apache 2.4.52 [#3996](https://github.com/FreshRSS/FreshRSS/pull/3996)
	* Docker: fix inclusion of `.htaccess` for `./p/themes/` folder [#4074](https://github.com/FreshRSS/FreshRSS/pull/4074)
	* Docker: only add the crontab when `CRON_MIN` is set [#3927](https://github.com/FreshRSS/FreshRSS/pull/3927)
	* Docker: move logic to disable FreshRSS updates [#3973](https://github.com/FreshRSS/FreshRSS/pull/3973)
	* Docker: allow mounting a volume for the cron file [#3927](https://github.com/FreshRSS/FreshRSS/pull/3927)
	* Images on Docker Hub are automatically scanned for software vulnerabilities
* UI
	* Remember article filters when changing views (category / feed) [#3986](https://github.com/FreshRSS/FreshRSS/pull/3986)
	* Mobile view can access the configuration menu [#3879](https://github.com/FreshRSS/FreshRSS/pull/3879), [#3881](https://github.com/FreshRSS/FreshRSS/pull/3881)
	* Improve layout of settings on small screen [#3818](https://github.com/FreshRSS/FreshRSS/pull/3818), [#3819](https://github.com/FreshRSS/FreshRSS/pull/3819)
	* New shortcut to jump to next unread article [#3891](https://github.com/FreshRSS/FreshRSS/pull/3891)
	* New shortcut to actualise feeds [#3900](https://github.com/FreshRSS/FreshRSS/pull/3900)
	* Implement Escape shortcut to close panels [#3901](https://github.com/FreshRSS/FreshRSS/pull/3901)
	* Improve layout of subscription management page [#3893](https://github.com/FreshRSS/FreshRSS/pull/3893)
	* Use HTML5 tags with better semantics and structure [#3651](https://github.com/FreshRSS/FreshRSS/pull/3651), [#3676](https://github.com/FreshRSS/FreshRSS/pull/3676), [#3713](https://github.com/FreshRSS/FreshRSS/pull/3713), [#3747](https://github.com/FreshRSS/FreshRSS/pull/3747), [#3830](https://github.com/FreshRSS/FreshRSS/pull/3830), [#3851](https://github.com/FreshRSS/FreshRSS/pull/3851)
	* Allow JavaScript in themes [#3739](https://github.com/FreshRSS/FreshRSS/pull/3739)
	* Improve layout of statistics [#3797](https://github.com/FreshRSS/FreshRSS/pull/3797), [#3799](https://github.com/FreshRSS/FreshRSS/pull/3799), [#3803](https://github.com/FreshRSS/FreshRSS/pull/3803)
		* Replace flotr2 with chart.js library [#3858](https://github.com/FreshRSS/FreshRSS/pull/3858)
		* Remove jQuery fully [#3847](https://github.com/FreshRSS/FreshRSS/pull/3847)
	* Improve label management [#3959](https://github.com/FreshRSS/FreshRSS/pull/3959)
	* Update layout of user queries [#3827](https://github.com/FreshRSS/FreshRSS/pull/3827)
	* Improve style of install procedure [#3721](https://github.com/FreshRSS/FreshRSS/pull/3721)
		* Add retry button when checking requirements during install [#3771](https://github.com/FreshRSS/FreshRSS/pull/3771)
	* Improve notification icon [#3678](https://github.com/FreshRSS/FreshRSS/pull/3678)
	* Add CSS class to back links [#3761](https://github.com/FreshRSS/FreshRSS/pull/3761)
	* Better support for `400` and `405` HTTP error codes [#3981](https://github.com/FreshRSS/FreshRSS/pull/3981)
	* Many minor UI and style improvements [#3792](https://github.com/FreshRSS/FreshRSS/pull/3792), [#3795](https://github.com/FreshRSS/FreshRSS/pull/3795), [#3801](https://github.com/FreshRSS/FreshRSS/pull/3801), [#3802](https://github.com/FreshRSS/FreshRSS/pull/3802), [#3817](https://github.com/FreshRSS/FreshRSS/pull/3817), [#3821](https://github.com/FreshRSS/FreshRSS/pull/3821), [#3824](https://github.com/FreshRSS/FreshRSS/pull/3824), [#3831](https://github.com/FreshRSS/FreshRSS/pull/3831), [#3832](https://github.com/FreshRSS/FreshRSS/pull/3832), [#3877](https://github.com/FreshRSS/FreshRSS/pull/3877), [#3880](https://github.com/FreshRSS/FreshRSS/pull/3880), [#3969](https://github.com/FreshRSS/FreshRSS/pull/3969), [#3989](https://github.com/FreshRSS/FreshRSS/pull/3989), [#3990](https://github.com/FreshRSS/FreshRSS/pull/3990), [#4005](https://github.com/FreshRSS/FreshRSS/pull/4005), [#4015](https://github.com/FreshRSS/FreshRSS/pull/4015)
* Themes
	* Show search box for all themes in mobile view [#4025](https://github.com/FreshRSS/FreshRSS/pull/4025)
	* Fix *alternative-dark* theme to avoid bright elements [#3774](https://github.com/FreshRSS/FreshRSS/pull/3774), [#3806](https://github.com/FreshRSS/FreshRSS/pull/3806)
	* Improve the contrast of message boxes for the *Origine* theme [#3725](https://github.com/FreshRSS/FreshRSS/pull/3725)
	* Uniformize the size of `input`and `select` elements for the *Origine* theme [#3727](https://github.com/FreshRSS/FreshRSS/pull/3727)
	* Fix style of banner text for the *Origine* theme [#3731](https://github.com/FreshRSS/FreshRSS/pull/3731)
* i18n
	* Fix language of e-mail notifications [#4076](https://github.com/FreshRSS/FreshRSS/pull/4076)
	* Lint i18n [#3841](https://github.com/FreshRSS/FreshRSS/pull/3841)
	* Fix bug in French and German translations of new/old tags [#3703](https://github.com/FreshRSS/FreshRSS/pull/3703), [#3668](https://github.com/FreshRSS/FreshRSS/pull/3668)
	* Fix name of keyboard shortcut to open in new tab [#3899](https://github.com/FreshRSS/FreshRSS/pull/3899)
	* Add Japanese [#3828](https://github.com/FreshRSS/FreshRSS/pull/3828), [#3834](https://github.com/FreshRSS/FreshRSS/pull/3834)
	* Improve Chinese [#3926](https://github.com/FreshRSS/FreshRSS/pull/3926), [#3947](https://github.com/FreshRSS/FreshRSS/pull/3947), [#3963](https://github.com/FreshRSS/FreshRSS/pull/3963), [#4084](https://github.com/FreshRSS/FreshRSS/pull/4084)
	* Improve Dutch [#3844](https://github.com/FreshRSS/FreshRSS/pull/3844), [#3928](https://github.com/FreshRSS/FreshRSS/pull/3928)
	* Improve German [#3720](https://github.com/FreshRSS/FreshRSS/pull/3720), [#3846](https://github.com/FreshRSS/FreshRSS/pull/3846), [#3913](https://github.com/FreshRSS/FreshRSS/pull/3913), [#4008](https://github.com/FreshRSS/FreshRSS/pull/4008)
	* Improve Italian [#3939](https://github.com/FreshRSS/FreshRSS/pull/3939)
	* Improve Korean [#3914](https://github.com/FreshRSS/FreshRSS/pull/3914)
	* Improve Occitan [#3935](https://github.com/FreshRSS/FreshRSS/pull/3935)
	* Improve Polish [#4027](https://github.com/FreshRSS/FreshRSS/pull/4027)
	* Improve Portuguese [#3908](https://github.com/FreshRSS/FreshRSS/pull/3908), [#3925](https://github.com/FreshRSS/FreshRSS/pull/3925)
	* Improve Russian [#3907](https://github.com/FreshRSS/FreshRSS/pull/3907)
	* Improve Slovak [#4036](https://github.com/FreshRSS/FreshRSS/pull/4036)
	* Improve Spanish [#3916](https://github.com/FreshRSS/FreshRSS/pull/3916)
* Extensions
	* Add system configuration for extension [#3626](https://github.com/FreshRSS/FreshRSS/pull/3626)
* SimplePie
	* Merge from upstream, help with PHP 8.1+ [#4011](https://github.com/FreshRSS/FreshRSS/pull/4011)
	* Fallback to file extensions for enclosures not providing a media type [#3861](https://github.com/FreshRSS/FreshRSS/pull/3861)
* Misc.
	* Implement GitHub Actions for continuous integration / automated testing [3920](https://github.com/FreshRSS/FreshRSS/pull/3920)
	* Use ESLint instead of JSHint [#3906](https://github.com/FreshRSS/FreshRSS/pull/3906)
	* Improve `.editorconfig` and `.stylelintrc` [#3895](https://github.com/FreshRSS/FreshRSS/pull/3895), [#3912](https://github.com/FreshRSS/FreshRSS/pull/3912)
	* Simplify Minz code with PHP 7 `??` operator [#4020](https://github.com/FreshRSS/FreshRSS/pull/4020)
	* Upgrade PHPMailer to 6.5.1 [#3977](https://github.com/FreshRSS/FreshRSS/pull/3977)
	* Added Raindrop.io as sharing option [#3717](https://github.com/FreshRSS/FreshRSS/pull/3717)
	* Delete outdated information regarding Firefox feed reader list [#3822](https://github.com/FreshRSS/FreshRSS/pull/3822)


## 2021-06-06 FreshRSS 1.18.1

* Features
	* Support standard `HTTP 410 Gone` by disabling (muting) gone feeds [#3561](https://github.com/FreshRSS/FreshRSS/pull/3561)
	* Make advanced feed options such as SSL available to non-admins [#3612](https://github.com/FreshRSS/FreshRSS/pull/3612)
* API
	* Supported by [Newsboat 2.24+](https://newsboat.org/) [#3574](https://github.com/FreshRSS/FreshRSS/pull/3574)
	* Supported by [RSS Guard](https://github.com/martinrotter/rssguard) [#3627](https://github.com/FreshRSS/FreshRSS/pull/3627)
* UI
	* Allow Unicode for shortcuts [#3548](https://github.com/FreshRSS/FreshRSS/pull/3548)
* Bug fixing
	* Fix database lock during refresh with MariaDB [#3559](https://github.com/FreshRSS/FreshRSS/pull/3559)
	* Fix database creation from CLI [#3544](https://github.com/FreshRSS/FreshRSS/pull/3544)
	* Fix: `pdo_sqlite` is optional except for export/import SQLite [#3545](https://github.com/FreshRSS/FreshRSS/pull/3545)
	* Fix import of JSON and TT-RSS files, especially with PHP 8 [#3553](https://github.com/FreshRSS/FreshRSS/pull/3553)
		* Allow import of more than 999 favourites/labelled articles even with SQLite
	* Fix additional SQL limits, especially for SQLite [#3586](https://github.com/FreshRSS/FreshRSS/pull/3586)
	* Fix search param encoding in user query [#3541](https://github.com/FreshRSS/FreshRSS/pull/3541)
	* Fix undefined variable & dead code when adding feed [#3546](https://github.com/FreshRSS/FreshRSS/pull/3546)
	* Fix missing translation in feed configuration [#3554](https://github.com/FreshRSS/FreshRSS/pull/3554)
	* Fix double escaping in feed filters [#3563](https://github.com/FreshRSS/FreshRSS/pull/3563)
	* Fix bugs in migration system [#3589](https://github.com/FreshRSS/FreshRSS/pull/3589)
	* Fix regression preventing showing startup errors [#3590](https://github.com/FreshRSS/FreshRSS/pull/3590)
	* Fix form redirection after erroneous user creation [#3656](https://github.com/FreshRSS/FreshRSS/pull/3656)
	* Fix JavaScript error during navigation when no article is selected [#3655](https://github.com/FreshRSS/FreshRSS/pull/3655)
	* Fix link to add feeds from the empty homepage [#3650](https://github.com/FreshRSS/FreshRSS/pull/3650)
	* Fix git update error message [#3645](https://github.com/FreshRSS/FreshRSS/pull/3645)
* SimplePie
	* Fix regression about media attachments [#3565](https://github.com/FreshRSS/FreshRSS/pull/3565)
	* Fix regression about forcing HTTPS for enclosures [#3568](https://github.com/FreshRSS/FreshRSS/pull/3568)
	* Catch ValueError for loadHTML with PHP 8 [simplepie#673](https://github.com/simplepie/simplepie/pull/673)
	* Provide access to latest HTTP status code [simplepie#674](https://github.com/simplepie/simplepie/pull/674)
	* Fix wrong SimplePie type hint [simplepie#678](https://github.com/simplepie/simplepie/pull/678)
	* Merge details from upstream PRs [#3588](https://github.com/FreshRSS/FreshRSS/pull/3588), [#3614](https://github.com/FreshRSS/FreshRSS/pull/3614)
* API
	* Compatibility with Web servers providing `ORIG_PATH_INFO` [#3560](https://github.com/FreshRSS/FreshRSS/pull/3560)
* i18n
	* Improved Russian [#3579](https://github.com/FreshRSS/FreshRSS/pull/3579)
	* Improved Turkish [#3604](https://github.com/FreshRSS/FreshRSS/pull/3604)
	* Improved Chinese [#3600](https://github.com/FreshRSS/FreshRSS/pull/3600)
* Code improvements:
	* Friendly constant syntax for Intellisense [#3577](https://github.com/FreshRSS/FreshRSS/pull/3577)
	* Fix several comments syntaxes [#3615](https://github.com/FreshRSS/FreshRSS/pull/3615)
	* Minor uniform stricter HTML [#3616](https://github.com/FreshRSS/FreshRSS/pull/3616)
	* Removed unused variable [#3587](https://github.com/FreshRSS/FreshRSS/pull/3587)
	* Provide action name in Minz controller exception [#3624](https://github.com/FreshRSS/FreshRSS/pull/3624)
	* New convenience method to extract multiline GET parameters from e.g. `<textarea>` [#3629](https://github.com/FreshRSS/FreshRSS/pull/3629)
* Deployment
	* Automatically apply `latest` tag in git for the latest FreshRSS release [#3524](https://github.com/FreshRSS/FreshRSS/pull/3524)
* Misc.
	* Remove legacy `data/do-install.txt` for triggering install process [#3555](https://github.com/FreshRSS/FreshRSS/pull/3555)
	* If using built-in git updates, automatically change to git `edge` branch if using old `master` or `dev` branch names [#3589](https://github.com/FreshRSS/FreshRSS/pull/3589)


## 2021-03-14 FreshRSS 1.18.0

* Features
	* Allow parallel requests [#3096](https://github.com/FreshRSS/FreshRSS/pull/3096)
		* Much faster manual feeds refresh
	* Reload full article content when an article has changed [#3506](https://github.com/FreshRSS/FreshRSS/pull/3506)
	* New share article link to clipboard [#3330](https://github.com/FreshRSS/FreshRSS/pull/3330)
	* Improved OPML import of feeds with multiple categories [#3286](https://github.com/FreshRSS/FreshRSS/pull/3286)
	* Add a content action parameter to work with CSS selector [#3453](https://github.com/FreshRSS/FreshRSS/pull/3453)
	* New cURL options per feed: proxy, cookie, user-agent [#3367](https://github.com/FreshRSS/FreshRSS/pull/3367), [#3494](https://github.com/FreshRSS/FreshRSS/pull/3494), [#3516](https://github.com/FreshRSS/FreshRSS/pull/3516)
	* Do not import feeds causing database errors (e.g. due to conflicting HTTP redirections) [#3347](https://github.com/FreshRSS/FreshRSS/pull/3347)
* UI
	* New option to remember open categories [#3185](https://github.com/FreshRSS/FreshRSS/pull/3185)
	* Remember the scroll position of the sidebar [#3231](https://github.com/FreshRSS/FreshRSS/pull/3231)
	* Feedback messages are now properly attached to a request, in case multiple tabs are open [#3208](https://github.com/FreshRSS/FreshRSS/pull/3208)
	* New user query configuration page [#3366](https://github.com/FreshRSS/FreshRSS/pull/3366)
	* Allow sorting and drag & drop in the list of user queries [#3346](https://github.com/FreshRSS/FreshRSS/pull/3346), [#3355](https://github.com/FreshRSS/FreshRSS/pull/3355)
	* Change layout to add a subscription [#3289](https://github.com/FreshRSS/FreshRSS/pull/3289)
	* Change integration configuration page [#3372](https://github.com/FreshRSS/FreshRSS/pull/3372)
	* Improve author search when clicking on an author [#3315](https://github.com/FreshRSS/FreshRSS/pull/3315)
	* Allow typing a label name instead of selecting it [#3213](https://github.com/FreshRSS/FreshRSS/pull/3213)
	* Use same behaviour for labels than the option *Show all articles in favourites* [#3472](https://github.com/FreshRSS/FreshRSS/pull/3472)
	* Change naming from *Tag management* to *Label management* [#3446](https://github.com/FreshRSS/FreshRSS/pull/3446)
	* Sort options alphabetically in share menu [#3331](https://github.com/FreshRSS/FreshRSS/pull/3331)
	* Case-insensitive sort order of feeds in category settings [#3466](https://github.com/FreshRSS/FreshRSS/pull/3466)
	* Better compression of the images [#3184](https://github.com/FreshRSS/FreshRSS/pull/3184)
	* Fix minor jaggy motion of the sidebar [#3266](https://github.com/FreshRSS/FreshRSS/pull/3266)
	* Remove useless reset action in sharing configuration page [#3365](https://github.com/FreshRSS/FreshRSS/pull/3365)
	* Add autofocus on subscription page [#3334](https://github.com/FreshRSS/FreshRSS/pull/3334)
	* Fix contrast issue by enforcing black text in base theme [#3196](https://github.com/FreshRSS/FreshRSS/pull/3196)
	* Adjust brightness & contrast of images and videos in dark themes [#3356](https://github.com/FreshRSS/FreshRSS/pull/3356)
	* Improve menu bar of several themes for mobile view [#3480](https://github.com/FreshRSS/FreshRSS/pull/3480), [#3491](https://github.com/FreshRSS/FreshRSS/pull/3491)
	* Fix dropdown menu for user queries with BlueLagoon and Screwdriver themes [#3485](https://github.com/FreshRSS/FreshRSS/pull/3485)
	* Upgrade to jQuery 3.6.0 for statistics [#3501](https://github.com/FreshRSS/FreshRSS/pull/3501)
* Bug fixing
	* Fix the reloading of full article content with SQLite [#3461](https://github.com/FreshRSS/FreshRSS/pull/3461)
	* Fix the caching of an SQL prepared statement affecting the read state of updated articles [#3500](https://github.com/FreshRSS/FreshRSS/pull/3500)
	* Better handle expected article conflicts in database [#3409](https://github.com/FreshRSS/FreshRSS/pull/3409)
	* Fix SQL syntax error/warning when deleting temporary articles [#3357](https://github.com/FreshRSS/FreshRSS/pull/3357)
	* Fix login and refresh bugs in anonymous mode [#3305](https://github.com/FreshRSS/FreshRSS/pull/3305)
	* Fix i18n init [#3249](https://github.com/FreshRSS/FreshRSS/pull/3249)
	* Fix tag management [#3292](https://github.com/FreshRSS/FreshRSS/pull/3292)
	* Fix user queries with labels [#3285](https://github.com/FreshRSS/FreshRSS/pull/3285)
	* Fix loading of default actions for shortcuts [#3394](https://github.com/FreshRSS/FreshRSS/pull/3394)
	* Fix extensions when using CLI [#3443](https://github.com/FreshRSS/FreshRSS/pull/3443)
	* Fix translation CLI [#3364](https://github.com/FreshRSS/FreshRSS/pull/3364)
	* Allow searching for `+` sign [#3489](https://github.com/FreshRSS/FreshRSS/pull/3489)
	* Fix cURL version detection in install script [#3519](https://github.com/FreshRSS/FreshRSS/pull/3519)
* Compatibility
	* Support PHP 8+ [#3186](https://github.com/FreshRSS/FreshRSS/pull/3186), [#3207](https://github.com/FreshRSS/FreshRSS/pull/3207), [#3459](https://github.com/FreshRSS/FreshRSS/pull/3459), [#3487](https://github.com/FreshRSS/FreshRSS/pull/3487)
		* Note: needed for MySQL 8+ with default authentication settings
		* Change ZIP-handling method [#3470](https://github.com/FreshRSS/FreshRSS/pull/3470)
* API
	* Supported by [FocusReader](https://play.google.com/store/apps/details?id=allen.town.focus.reader) (Android) [#3478](https://github.com/FreshRSS/FreshRSS/issues/3478)
	* Implement OPML import/export [#3424](https://github.com/FreshRSS/FreshRSS/pull/3424)
	* Add `canonical` field for fluent-reader, better compatibility InoReader [#3391](https://github.com/FreshRSS/FreshRSS/pull/3391)
	* Better compatibility with BazQux API [#3320](https://github.com/FreshRSS/FreshRSS/pull/3320)
	* Fix continuation token by ensuring it is a string (for Reeder) [#3247](https://github.com/FreshRSS/FreshRSS/issues/3247)
* CLI
	* Add requirements check in relevant CLI [#3410](https://github.com/FreshRSS/FreshRSS/pull/3410)
* Deployment
	* Possibility to auto-install via e.g. `docker-compose` [#3353](https://github.com/FreshRSS/FreshRSS/pull/3353)
		* New tolerance when the database is not available / up (yet) by trying a few times to connect
	* Docker: use Apache `remoteip` to log the client remote IP instead of the local proxy IP [#3226](https://github.com/FreshRSS/FreshRSS/pull/3226)
	* Docker: new environment variable `LISTEN` to change the internal Apache port when running in host network mode [#3343](https://github.com/FreshRSS/FreshRSS/pull/3343)
	* Docker: Alpine image updated to 3.13 with PHP 8.0.3 and Apache 2.4.46 [#3375](https://github.com/FreshRSS/FreshRSS/pull/3375)
		* Note: needed for MySQL 8+ with default authentication settings [#3191](https://github.com/FreshRSS/FreshRSS/issues/3191)
	* Docker default image (Debian 10 Buster) updated to PHP 7.3.27
	* New Docker development image based on `alpine:edge` to test the latest PHP 8+ version [#3294](https://github.com/FreshRSS/FreshRSS/pull/3294)
	* New Docker development image based on `alpine:3.4` to test oldest supported PHP 5.6.36 version with Apache 2.4.43 [#3274](https://github.com/FreshRSS/FreshRSS/pull/3274)
	* Disable built-in update mechanism for new installations using Docker [#3496](https://github.com/FreshRSS/FreshRSS/pull/3496)
	* Check that PHP session is working during install [#3430](https://github.com/FreshRSS/FreshRSS/pull/3430)
* Security
	* Auto-renew login cookie [#3287](https://github.com/FreshRSS/FreshRSS/pull/3287)
	* Remove referer check, already replaced by CSRF token [#3432](https://github.com/FreshRSS/FreshRSS/pull/3432)
	* Increase login cookie duration to 3 months by default [#3170](https://github.com/FreshRSS/FreshRSS/pull/3170)
	* Prevent click on login button until JavaScript is fully loaded [#3275](https://github.com/FreshRSS/FreshRSS/pull/3275)
	* Add toggle password visibility button on login form UI [#3205](https://github.com/FreshRSS/FreshRSS/pull/3205)
	* Better sanitize feed description [#3222](https://github.com/FreshRSS/FreshRSS/pull/3222)
	* Allow `@`-sign in database username (for Azure) [#3241](https://github.com/FreshRSS/FreshRSS/pull/3241)
	* Add username hint for permissions during install [#3373](https://github.com/FreshRSS/FreshRSS/pull/3373)
* SimplePie
	* SimplePie prevent cache pollution [#3502](https://github.com/FreshRSS/FreshRSS/pull/3502)
	* Update to SimplePie 1.5.6 with PHP8 support [#3469](https://github.com/FreshRSS/FreshRSS/pull/3469), [#3206](https://github.com/FreshRSS/FreshRSS/pull/3206)
	* Reduce memory consumption to handle very big feeds [simplepie#672](https://github.com/simplepie/simplepie/pull/672)
	* Replace `ceil()` by `intval()` for edge cases with PHP8 [simplepie#670](https://github.com/simplepie/simplepie/pull/670)
	* Strip HTML comments in feeds [#3288](https://github.com/FreshRSS/FreshRSS/pull/3288)
	* Minor fix of return type for broken feeds [#3423](https://github.com/FreshRSS/FreshRSS/pull/3423)
	* Fix images in enclosures without MIME type [#3361](https://github.com/FreshRSS/FreshRSS/pull/3361)
* Extensions
	* New user maintenance hooks [#3440](https://github.com/FreshRSS/FreshRSS/pull/3440)
	* New hooks `js_vars` and `nav_menu` [#3342](https://github.com/FreshRSS/FreshRSS/pull/3342)
	* Add class autoload for extensions [#3350](https://github.com/FreshRSS/FreshRSS/pull/3350)
	* Add support for extension user files [#3433](https://github.com/FreshRSS/FreshRSS/pull/3433)
	* Add user configuration in extensions [#3397](https://github.com/FreshRSS/FreshRSS/pull/3397)
	* Add a method to retrieve a configuration value [#3422](https://github.com/FreshRSS/FreshRSS/pull/3422)
	* Search files for both core and third-party extensions [#3413](https://github.com/FreshRSS/FreshRSS/pull/3413)
	* Updated base extension class [#3333](https://github.com/FreshRSS/FreshRSS/pull/3333), [#3335](https://github.com/FreshRSS/FreshRSS/pull/3335)
	* Refactor extension file script [#3399](https://github.com/FreshRSS/FreshRSS/pull/3399)
* i18n
	* Fix some translation inconsistencies [#3316](https://github.com/FreshRSS/FreshRSS/pull/3316), [#3240](https://github.com/FreshRSS/FreshRSS/pull/3240)
	* Add Polish [#3190](https://github.com/FreshRSS/FreshRSS/pull/3190)
	* Improve Chinese [#3473](https://github.com/FreshRSS/FreshRSS/pull/3473)
	* Improve Dutch [#3468](https://github.com/FreshRSS/FreshRSS/pull/3468)
	* Improve English [#3248](https://github.com/FreshRSS/FreshRSS/pull/3248)
		* Improve British English date format [#3326](https://github.com/FreshRSS/FreshRSS/pull/3326)
	* Improve German [#3237](https://github.com/FreshRSS/FreshRSS/pull/3237), [#3317](https://github.com/FreshRSS/FreshRSS/pull/3317), [#3318](https://github.com/FreshRSS/FreshRSS/pull/3318), [#3325](https://github.com/FreshRSS/FreshRSS/pull/3325), [#3379](https://github.com/FreshRSS/FreshRSS/pull/3379), [#3448](https://github.com/FreshRSS/FreshRSS/pull/3448), [#3455](https://github.com/FreshRSS/FreshRSS/pull/3455)
	* Improve Occitan [#3245](https://github.com/FreshRSS/FreshRSS/pull/3245), [#3511](https://github.com/FreshRSS/FreshRSS/pull/3511)
* Code improvements
	* Improve FreshRSS system initialisation [#3070](https://github.com/FreshRSS/FreshRSS/pull/3070)
	* Improve session code during install [#3276](https://github.com/FreshRSS/FreshRSS/pull/3276)
	* Enforce `phpcs` (PHP_CodeSniffer) line length + whitespace [#3488](https://github.com/FreshRSS/FreshRSS/pull/3488)
		* Improve settings and applies to `*.phtml, *.css, *.js` as well
	* Fix superfluous Minz check during install [#3302](https://github.com/FreshRSS/FreshRSS/pull/3302)
	* Extract some classes to their own files [#3301](https://github.com/FreshRSS/FreshRSS/pull/3301), [#3298](https://github.com/FreshRSS/FreshRSS/pull/3298), [#3297](https://github.com/FreshRSS/FreshRSS/pull/3297)
	* Explicit git declaration of `.png` files as binary [#3211](https://github.com/FreshRSS/FreshRSS/pull/3211)
	* Remove Minz validation [#3439](https://github.com/FreshRSS/FreshRSS/pull/3439)
	* Explicit `PDO::ERRMODE_SILENT` [#3048](https://github.com/FreshRSS/FreshRSS/pull/3408)
	* Add constant for minimal PHP version [#3369](https://github.com/FreshRSS/FreshRSS/pull/3369)
	* Refactor requirements check during install [#3368](https://github.com/FreshRSS/FreshRSS/pull/3368)
* Misc.
	* Check access rights to temp folder during install [#3312](https://github.com/FreshRSS/FreshRSS/pull/3312)
	* Ensure maximum integer for a date to avoid some database issues [#3259](https://github.com/FreshRSS/FreshRSS/pull/3259)
	* Upgrade PHPMailer to 6.3.0 [#3457](https://github.com/FreshRSS/FreshRSS/pull/3457)
	* Make our Travis greener by testing only our oldest and newest supported PHP versions [#3492](https://github.com/FreshRSS/FreshRSS/pull/3492)


## 2020-09-22 FreshRSS 1.17.0

* Features
	* New tag management page [#3121](https://github.com/FreshRSS/FreshRSS/pull/3121)
	* New page to add feeds and categories [#3027](https://github.com/FreshRSS/FreshRSS/pull/3027)
	* Add a way to disable/enable users [#3056](https://github.com/FreshRSS/FreshRSS/pull/3056)
* Security
	* Add user auto-registration when using HTTP Basic authentication login method [#3003](https://github.com/FreshRSS/FreshRSS/pull/3003)
	* Fix special characters in user queries [#3037](https://github.com/FreshRSS/FreshRSS/pull/3037)
	* Hide feed credentials when adding a new feed [#3099](https://github.com/FreshRSS/FreshRSS/pull/3099)
	* Trim whitespace for feed passwords [#3158](https://github.com/FreshRSS/FreshRSS/pull/3158)
	* Updated PHPMailer library to 6.1.6 [#3024](https://github.com/FreshRSS/FreshRSS/pull/3024)
	* Add blogger.com to the default list of forced HTTPS [#3088](https://github.com/FreshRSS/FreshRSS/pull/3088)
* UI
	* Show feed name and date inside the article (especially good on mobile) [#3081](https://github.com/FreshRSS/FreshRSS/pull/3081)
	* Add shortcut to control media elements (video, audio) [#3036](https://github.com/FreshRSS/FreshRSS/pull/3036)
	* New option to disable shortcuts [#3114](https://github.com/FreshRSS/FreshRSS/pull/3114)
	* Case-insensitive sort order of feeds in categories [#3131](https://github.com/FreshRSS/FreshRSS/pull/3131)
	* Use machine-readable `<time datetime="">` for entry dates [#3106](https://github.com/FreshRSS/FreshRSS/pull/3106)
	* Add tooltips on entry icons [#3115](https://github.com/FreshRSS/FreshRSS/pull/3115)
	* Limit dropdown menus max-height [#3102](https://github.com/FreshRSS/FreshRSS/pull/3102)
	* Fix inline code tag contrast in Ansum and Mapco themes [#3048](https://github.com/FreshRSS/FreshRSS/pull/3048), [#3050](https://github.com/FreshRSS/FreshRSS/pull/3050)
	* Fix login form in BlueLagoon and Screwdriver themes [#3028](https://github.com/FreshRSS/FreshRSS/pull/3028)
* API
	* Supported by [Fluent Reader](https://hyliu.me/fluent-reader/) (Windows, Linux, MacOS) [#3140](https://github.com/FreshRSS/FreshRSS/pull/3140)
	* Fix API `quickadd` [#3051](https://github.com/FreshRSS/FreshRSS/pull/3051)
	* Fix warning when adding a feed [#3075](https://github.com/FreshRSS/FreshRSS/pull/3075)
	* Work-around for common API address errors [#3061](https://github.com/FreshRSS/FreshRSS/pull/3061)
* Compatibility
	* Add fall-backs for compatibility with OPMLs from The Old Reader [#3071](https://github.com/FreshRSS/FreshRSS/pull/3071)
	* Relaxed to allow underscore `_` in feed addresses [#3133](https://github.com/FreshRSS/FreshRSS/pull/3133)
* Deployment
	* Docker default image rebased on Debian 10 Buster, with Apache 2.4.38 and PHP 7.3.19 [#3159](https://github.com/FreshRSS/FreshRSS/pull/3159)
	* Docker: Alpine image updated to 3.12 with Apache/2.4.46 and PHP 7.3.21 [#3025](https://github.com/FreshRSS/FreshRSS/pull/3025)
	* Update example of Dockerfile [#3108](https://github.com/FreshRSS/FreshRSS/pull/3108)
* CLI
	* Re-introduce `--api_password` option (vanished in 1.16.0) [#3179](https://github.com/FreshRSS/FreshRSS/pull/3179)
	* Modify shebang to be more portable [#3038](https://github.com/FreshRSS/FreshRSS/pull/3038)
* Bug fixing
	* SimplePie: Fix compliance with HTTP 301 Moved Permanently [#3180](https://github.com/FreshRSS/FreshRSS/pull/3180)
* i18n
	* Add language negotiation when the user is not logged in [#3022](https://github.com/FreshRSS/FreshRSS/pull/3022)
	* New United States English [#3060](https://github.com/FreshRSS/FreshRSS/pull/3060)
	* Improved British English [#3068](https://github.com/FreshRSS/FreshRSS/pull/3068)
	* Improved Dutch [#3063](https://github.com/FreshRSS/FreshRSS/pull/3063)
	* Improved Slovak [#3020](https://github.com/FreshRSS/FreshRSS/pull/3020)
	* Add a language reference when adding a new one [#3044](https://github.com/FreshRSS/FreshRSS/pull/3044)
	* Change how updating a key works [#3072](https://github.com/FreshRSS/FreshRSS/pull/3072)
	* Add missing translations [#3034](https://github.com/FreshRSS/FreshRSS/pull/3034)
* Misc.
	* Return proper MIME type for favicons [#3032](https://github.com/FreshRSS/FreshRSS/pull/3032)
	* Add a migration system [#2760](https://github.com/FreshRSS/FreshRSS/pull/2760)
	* Makefile support for FreshRSS extensions [#3042](https://github.com/FreshRSS/FreshRSS/pull/3042)
	* Update rules to use Make syntax [#3062](https://github.com/FreshRSS/FreshRSS/pull/3062)
	* Refactor the export feature [#3045](https://github.com/FreshRSS/FreshRSS/pull/3045)


## 2020-05-31 FreshRSS 1.16.2

* Bug fixing (regressions)
	* Fix migration of the preference *Show categories unfolded* (from ≤ 1.16.0) to the new *Categories to unfold* [#3019](https://github.com/FreshRSS/FreshRSS/pull/3019)


## 2020-05-30 FreshRSS 1.16.1

* Features
	* Add the possibility to filter by feed IDs [#2892](https://github.com/FreshRSS/FreshRSS/pull/2892)
		* like `f:123 more-search` or multiple feed IDs like `f:123,234,345 more-search` or an exclusion like `!f:456,789 more-search`
	* Show users last activity date [#2936](https://github.com/FreshRSS/FreshRSS/pull/2936)
	* Ability to follow HTML redirections when retrieving full article content [#2985](https://github.com/FreshRSS/FreshRSS/pull/2985)
* API
	* New table of compatible clients [#2942](https://github.com/FreshRSS/FreshRSS/pull/2942)
	* Expose podcasts in API (used by e.g. FeedMe) [#2898](https://github.com/FreshRSS/FreshRSS/pull/2898)
	* Workaround for clients not sending a clean login request [#2961](https://github.com/FreshRSS/FreshRSS/pull/2961)
	* Relaxed detection of GReader short/long ID form (for Reeder) [#2957](https://github.com/FreshRSS/FreshRSS/pull/2957)
	* Fix warning with FeedReader [#2947](https://github.com/FreshRSS/FreshRSS/pull/2947)
	* Fix GReader string type for Usec fields [#2935](https://github.com/FreshRSS/FreshRSS/pull/2935)
	* Fix Fever integers type [#2946](https://github.com/FreshRSS/FreshRSS/pull/2946)
* CLI
	* JSON output option for `./cli/user-info.php --json` [#2968](https://github.com/FreshRSS/FreshRSS/pull/2968)
	* Add language and e-mail in `./cli/user-info.php` [#2958](https://github.com/FreshRSS/FreshRSS/pull/2958)
	* Fix filenames for exported files [#2932](https://github.com/FreshRSS/FreshRSS/pull/2932)
* UI
	* Access to feed configuration in mobile view [#2938](https://github.com/FreshRSS/FreshRSS/pull/2938)
	* Use standard `loading="lazy"` for favicons [#2962](https://github.com/FreshRSS/FreshRSS/pull/2962)
	* New option to control which categories to unfold [#2888](https://github.com/FreshRSS/FreshRSS/pull/2888)
	* Turn off autocapitalization in login fields [#2907](https://github.com/FreshRSS/FreshRSS/pull/2907)
	* Minor layout improvement of help labels [#2911](https://github.com/FreshRSS/FreshRSS/pull/2911)
	* Minor layout improvement of checkbox labels [#2937](https://github.com/FreshRSS/FreshRSS/pull/2937)
	* Fix styling of search input fields in Safari [#2887](https://github.com/FreshRSS/FreshRSS/pull/2887)
	* Fix styling of `.stick` elements in older Webkit browsers [#2995](https://github.com/FreshRSS/FreshRSS/pull/2995)
	* Use common CSS template for *Alternative-Dark* theme [#3000](https://github.com/FreshRSS/FreshRSS/pull/3000)
	* Upgrade to jQuery 3.5.1 for statistics [#2982](https://github.com/FreshRSS/FreshRSS/pull/2982)
* Compatibility
	* Relax OPML parsing to allow importing not strictly-valid ones [#2983](https://github.com/FreshRSS/FreshRSS/pull/2983)
* Deployment
	* Docker: Alpine image updated to PHP 7.3.17
	* Add reference documentation for using Apache as a reverse proxy [#2919](https://github.com/FreshRSS/FreshRSS/pull/2919)
	* Enforce Unix line endings when checking out via git [#2879](https://github.com/FreshRSS/FreshRSS/pull/2879)
* Bug fixing
	* Fix regression when marking all articles as read, risking to mark newer articles as read [#2909](https://github.com/FreshRSS/FreshRSS/pull/2909)
	* Fix memory leak when using `lib_phpQuery` for full-content retrieval [#3004](https://github.com/FreshRSS/FreshRSS/pull/3004)
	* Fix preview of CSS selector to retrieve full article content [#2993](https://github.com/FreshRSS/FreshRSS/pull/2993)
	* Fix PostgreSQL install when user has limited connection rights [#3013](https://github.com/FreshRSS/FreshRSS/pull/3013)
	* Fix Docker make cron use `FRESHRSS_ENV` environment variable [#2963](https://github.com/FreshRSS/FreshRSS/pull/2963)
	* Fix e-mail validation bug for admins [#2917](https://github.com/FreshRSS/FreshRSS/pull/2917)
	* Fix some cases when WebSub-enabled feeds change address [#2922](https://github.com/FreshRSS/FreshRSS/pull/2922)
	* Fix ensuring that wrong login attempts generate HTTP 403 (e.g. for fail2ban) [#2903](https://github.com/FreshRSS/FreshRSS/pull/2903)
	* Fix archiving options layout in Edge [#2906](https://github.com/FreshRSS/FreshRSS/pull/2906)
	* Fix form in statistics for article repartition [#2896](https://github.com/FreshRSS/FreshRSS/pull/2896)
	* Fix double-HTML-encoding of category names in statistics [#2897](https://github.com/FreshRSS/FreshRSS/pull/2897)
	* Fix password reveal button during install [#2999](https://github.com/FreshRSS/FreshRSS/pull/2999)
	* Fix Makefile rules when PHP is not installed [#3010](https://github.com/FreshRSS/FreshRSS/pull/3010)
* i18n
	* Improve Simplified Chinese [#2891](https://github.com/FreshRSS/FreshRSS/pull/2891)
	* Improve Dutch [#3005](https://github.com/FreshRSS/FreshRSS/pull/3005)
	* Reformat i18n files [#2976](https://github.com/FreshRSS/FreshRSS/pull/2976)
	* Add a Makefile rule to produce PO4A i18n files [#3006](https://github.com/FreshRSS/FreshRSS/pull/3006)
* Misc.
	* Reduce memory consumption during feed refresh [#2972](https://github.com/FreshRSS/FreshRSS/pull/2972), [#2955](https://github.com/FreshRSS/FreshRSS/pull/2955)
		* and improved logs containing memory consumption [#2964](https://github.com/FreshRSS/FreshRSS/pull/2964)
	* Reduce the risk of DB lock errors [#2899](https://github.com/FreshRSS/FreshRSS/pull/2899)
	* Update PHPMailer library to 6.1.5 [#2980](https://github.com/FreshRSS/FreshRSS/pull/2980)
	* Initial rules for Markdown linting [#2880](https://github.com/FreshRSS/FreshRSS/pull/2880)
	* Add a Makefile rule for linting [#2996](https://github.com/FreshRSS/FreshRSS/pull/2996)
	* Add a Makefile rule to refresh feeds [#3014](https://github.com/FreshRSS/FreshRSS/pull/3014)


## 2020-04-09 FreshRSS 1.16.0

* Features
	* Allow multiple users to have administration rights [#2096](https://github.com/FreshRSS/FreshRSS/issues/2096)
	* Preview the CSS rule to retrieve full article content [#2778](https://github.com/FreshRSS/FreshRSS/pull/2778)
	* Improve CSS selector ordering in the full-text retrieval (`lib_phpQuery`) [#2874](https://github.com/FreshRSS/FreshRSS/pull/2874)
		* Allow combining selectors with a comma such as `#article .title, #article .content`
	* New search option `!date:` allowing to exclude any date interval [#2869](https://github.com/FreshRSS/FreshRSS/pull/2869)
		* For instance `!date:P1W` (exclude articles newer than 1 week), `!pubdate:2019`, `-date:2020-01-01/P5d`, etc.
	* New option to show all articles in the favourites view [#2434](https://github.com/FreshRSS/FreshRSS/issues/2434)
	* Allow feed to be actualized just after being truncated [#2862](https://github.com/FreshRSS/FreshRSS/pull/2862)
	* Fallback to showing a GUID when an article title is empty [#2813](https://github.com/FreshRSS/FreshRSS/pull/2813)
* API
	* Supported by [Readrops](https://github.com/readrops/Readrops) (Android, open source) [#2798](https://github.com/FreshRSS/FreshRSS/pull/2798)
	* Improve consistency of the default category [#2840](https://github.com/FreshRSS/FreshRSS/pull/2840)
	* Return proper `newestItemTimestampUsec` [#2853](https://github.com/FreshRSS/FreshRSS/issues/2853)
	* Return `HTTP/1.x 200 OK` for an empty request, to ease discovery [#2855](https://github.com/FreshRSS/FreshRSS/pull/2855)
	* Add ability to customise dates shown in API [#2773](https://github.com/FreshRSS/FreshRSS/pull/2773)
	* Minor clearing of unused parameters [#2816](https://github.com/FreshRSS/FreshRSS/pull/2816)
* Compatibility
	* Support PHP 7.4
* Bug fixing
	* Fix regression causing a login bug in some situations related to e-mail login [#2686](https://github.com/FreshRSS/FreshRSS/pull/2686)
	* Fix regression in feed refresh when there are users whose e-mail is not verified [#2694](https://github.com/FreshRSS/FreshRSS/pull/2694)
	* Fix PostgreSQL install when using a username different than database name [#2732](https://github.com/FreshRSS/FreshRSS/issues/2732)
	* Fix error with advanced searches using SQLite [#2777](https://github.com/FreshRSS/FreshRSS/pull/2777)
	* Fix feed action filter when filtering on `author:` [#2806](https://github.com/FreshRSS/FreshRSS/issues/2806)
	* Fix warning in WebSub [#2743](https://github.com/FreshRSS/FreshRSS/pull/2743)
	* Fix environment variables `COPY_LOG_TO_SYSLOG` and `FRESHRSS_ENV` controlling logging [#2745](https://github.com/FreshRSS/FreshRSS/pull/2745)
	* Fix UI flickering when hovering over articles when authors are displayed [#2701](https://github.com/FreshRSS/FreshRSS/issues/2701)
	* Fix array error with PHP 7.4 [#2780](https://github.com/FreshRSS/FreshRSS/pull/2780)
	* Fix wrong `foreach` in `applyFilterActions` [#2809](https://github.com/FreshRSS/FreshRSS/pull/2809)
	* Fix encoding bug in `lib_phpQuery` when fetching the full content of HTML documents with a complex `<head ...>` [#2864](https://github.com/FreshRSS/FreshRSS/issues/2864)
	* Fix minor bug in “articles to display” configuration UI [#2767](https://github.com/FreshRSS/FreshRSS/pull/2767)
	* Fix sharing with Wallabag [#2817](https://github.com/FreshRSS/FreshRSS/pull/2817)
	* Fix UI background bug when hovering over a long title that overlaps the date [#2755](https://github.com/FreshRSS/FreshRSS/issues/2755)
* UI
	* Better UI / client network performance (time to first byte) thanks to a data streaming pipeline with `yield` [#2588](https://github.com/FreshRSS/FreshRSS/pull/2588)
		* Improved buffering strategy accordingly, with a loading animation while waiting for the first articles to arrive (e.g. complex / slow search) [#2845](https://github.com/FreshRSS/FreshRSS/pull/2845)
		* To benefit from it, requires that the full Web stack allow efficient streaming / flushing of data. Check our reference [Docker + Traefik documentation](./Docker/README.md).
	* Support RTL (right-to-left) languages [#2776](https://github.com/FreshRSS/FreshRSS/pull/2776)
	* New keyboard shortcut <kbd>Alt ⎇</kbd>+<kbd>r</kbd> to park *previous* articles as read [#2843](https://github.com/FreshRSS/FreshRSS/pull/2843)
	* In the statistics page, show feeds inactive for 1, 2, 3, 5 years [#2827](https://github.com/FreshRSS/FreshRSS/issues/2827)
	* Reset FreshRSS page scroll when restoring a browser session, to avoid inadvertently marking as read new articles [#2842](https://github.com/FreshRSS/FreshRSS/pull/2842)
	* Fix scrolling of labels dropdown [#2727](https://github.com/FreshRSS/FreshRSS/pull/2727)
	* Enlarge `<audio>` widgets to use the full width of the reading zone, to help navigation in e.g. podcasts [#2875](https://github.com/FreshRSS/FreshRSS/issues/2875)
	* Use `<p>` instead of `<pre>` to display `<media:description>` information [#2807](https://github.com/FreshRSS/FreshRSS/issues/2807)
	* Show language and e-mail address in the list of users [#2703](https://github.com/FreshRSS/FreshRSS/pull/2703)
	* Change logic when using shortcuts to navigate between feeds, in the case some are empty [#2687](https://github.com/FreshRSS/FreshRSS/pull/2687)
	* Option to show/hide favicons (e.g. to reduce the number of requests) [#2821](https://github.com/FreshRSS/FreshRSS/pull/2821)
	* Improve loader animation colour in the Dark theme [#2753](https://github.com/FreshRSS/FreshRSS/pull/2753)
* SimplePie
	* Use distinct cache for feeds retrieved with `#force_feed` [simplepie#643](https://github.com/simplepie/simplepie/pull/643)
		* Fix the issue of not being able to immediately try to add an invalid feed again [#2524](https://github.com/FreshRSS/FreshRSS/issues/2524)
	* Update to SimplePie 1.5.4 [#2702](https://github.com/FreshRSS/FreshRSS/pull/2702), [#2814](https://github.com/FreshRSS/FreshRSS/pull/2814)
		* Require PHP 5.6+, and add PHP 7.4+ compatibility
		* Add Russian and German dates
		* Etc.
* Deployment
	* Docker: Alpine image updated to 3.11 with PHP 7.3.16 and Apache 2.4.43 [#2729](https://github.com/FreshRSS/FreshRSS/pull/2729)
	* Move core extensions (shipped with FreshRSS) to their own directory, so that `./extensions/` is solely for third-party extensions [#2837](https://github.com/FreshRSS/FreshRSS/pull/2837)
		* This allows mounting `./extensions/` as a Docker volume, to ease adding third-party extensions
* Extensions
	* New core extension to find feeds for Google Groups [#2835](https://github.com/FreshRSS/FreshRSS/issues/2835)
	* New hooks `check_url_before_add` and `feed_before_actualize` [#2704](https://github.com/FreshRSS/FreshRSS/pull/2704)
	* Execute the `entry_before_display` hook also through the API [#2762](https://github.com/FreshRSS/FreshRSS/issues/2762)
	* Allow extensions to change CSP (security) rules [#2708](https://github.com/FreshRSS/FreshRSS/pull/2708)
	* Expose the article ID in the share system (for a new e-mail sharing extension) [#2707](https://github.com/FreshRSS/FreshRSS/pull/2707)
* i18n
	* Improve French [#2878](https://github.com/FreshRSS/FreshRSS/pull/2878)
	* Improve German [#2690](https://github.com/FreshRSS/FreshRSS/pull/2690)
	* Improve Occitan [#2873](https://github.com/FreshRSS/FreshRSS/pull/2873)
	* Improve Portuguese [#2833](https://github.com/FreshRSS/FreshRSS/pull/2833)
	* Improve Simplified Chinese [#2730](https://github.com/FreshRSS/FreshRSS/pull/2730)
	* Improve Spanish [#2823](https://github.com/FreshRSS/FreshRSS/pull/2823)
* Misc.
	* Improve logging of database errors [#2734](https://github.com/FreshRSS/FreshRSS/pull/2734)
	* Remove the `min_posts_per_rss` configuration, which made efficient buffering difficult [#2588](https://github.com/FreshRSS/FreshRSS/pull/2588)
	* Add a test target to Makefile [#2725](https://github.com/FreshRSS/FreshRSS/pull/2725)
	* Fix test suite [#2721](https://github.com/FreshRSS/FreshRSS/pull/2721)
	* Refactor request class [#2373](https://github.com/FreshRSS/FreshRSS/pull/2373)
	* Remove deprecated *magic quotes* logic [#2698](https://github.com/FreshRSS/FreshRSS/pull/2698)


## 2019-11-22 FreshRSS 1.15.3

* Bug fixing (regressions from 1.15.x)
	* Fix adding categories in MySQL 5.5 [#2670](https://github.com/FreshRSS/FreshRSS/issues/2670)
	* Fix saving sharing integrations [#2669](https://github.com/FreshRSS/FreshRSS/pull/2669)
* Compatibility
	* Add fallback for systems with old ICU < 4.6 (*International Components for Unicode*) [#2680](https://github.com/FreshRSS/FreshRSS/pull/2680)
* API
	* Do not obey `rel=self` feed redirections when WebSub is disabled [#2659](https://github.com/FreshRSS/FreshRSS/pull/2659)
* UI
	* Start adding support for RTL (*right-to-left*) languages [#2656](https://github.com/FreshRSS/FreshRSS/pull/2656)
* Deployment
	* Docker: Ubuntu image updated to PHP 7.3.11
* Misc.
	* Add more log when errors occur when saving a profile [#2663](https://github.com/FreshRSS/FreshRSS/issues/2663)
	* Improve Makefile with port override [#2660](https://github.com/FreshRSS/FreshRSS/pull/2660)
	* Update a few external links to HTTPS [#2662](https://github.com/FreshRSS/FreshRSS/pull/2662)


## 2019-11-12 FreshRSS 1.15.2

* Bug fixing (regressions from 1.15.x)
	* Fix CLI failing due to new test against empty usernames [#2644](https://github.com/FreshRSS/FreshRSS/issues/2644)
	* Fix CLI install for SQLite [#2648](https://github.com/FreshRSS/FreshRSS/pull/2648)
	* Fix database optimize action for MySQL/MariaDB [#2647](https://github.com/FreshRSS/FreshRSS/pull/2647)
* Bug fixing (misc.)
	* Sanitize Unicode UTF-8 before insertion of entries, especially needed for PostgreSQL [#2645](https://github.com/FreshRSS/FreshRSS/issues/2645)
* Misc.
	* Rename *sharing* action to avoid erroneous blocking by some ad-blockers [#2509](https://github.com/FreshRSS/FreshRSS/issues/2509)


## 2019-11-06 FreshRSS 1.15.1

* Features
	* New approach based on OPML to definite default feeds for new users [#2627](https://github.com/FreshRSS/FreshRSS/pull/2627)
* API
	* Always send articles IDs as string, to fix compatibility with Reeder [#2621](https://github.com/FreshRSS/FreshRSS/pull/2621)
* Bug fixing (regressions from 1.15.0)
	* Fix database auto-creation at install [#2635](https://github.com/FreshRSS/FreshRSS/pull/2635)
	* Fix bug in database size estimation with PostgreSQL for users with uppercase names [#2631](https://github.com/FreshRSS/FreshRSS/pull/2631)
	* Reset name of default category (which cannot be customised anymore) [#2639](https://github.com/FreshRSS/FreshRSS/pull/2639)
	* Fix UI style details [#2634](https://github.com/FreshRSS/FreshRSS/pull/2634)
* Security
	* Improve cookie security with policy `SameSite=Lax` [#2630](https://github.com/FreshRSS/FreshRSS/pull/2630)
* Misc.
	* Perform automatic git updates with safer fetch+reset instead of clean+fetch+merge [#2625](https://github.com/FreshRSS/FreshRSS/pull/2625)


## 2019-10-31 FreshRSS 1.15.0

* CLI
	* Command line to export/import any database to/from SQLite [#2496](https://github.com/FreshRSS/FreshRSS/pull/2496)
* Features
	* New archiving method, including maximum number of articles per feed, and settings at feed, category, global levels [#2335](https://github.com/FreshRSS/FreshRSS/pull/2335)
	* New option to control category sort order [#2592](https://github.com/FreshRSS/FreshRSS/pull/2592)
	* New option to display article authors underneath the article title [#2487](https://github.com/FreshRSS/FreshRSS/pull/2487)
	* Add e-mail capability [#2476](https://github.com/FreshRSS/FreshRSS/pull/2476), [#2481](https://github.com/FreshRSS/FreshRSS/pull/2481)
	* Ability to define default user settings in `data/config-user.custom.php` [#2490](https://github.com/FreshRSS/FreshRSS/pull/2490)
		* Including default feeds [#2515](https://github.com/FreshRSS/FreshRSS/pull/2515)
	* Allow recreating users if they still exist in database [#2555](https://github.com/FreshRSS/FreshRSS/pull/2555)
	* Add optional database connection URI parameters [#2549](https://github.com/FreshRSS/FreshRSS/issues/2549), [#2559](https://github.com/FreshRSS/FreshRSS/pull/2559)
	* Allow longer articles with MySQL / MariaDB (up to 16MB compressed instead of 64kB) [#2448](https://github.com/FreshRSS/FreshRSS/issues/2448)
	* Add support for terms of service [#2520](https://github.com/FreshRSS/FreshRSS/pull/2520)
	* Add sharing with [Lemmy](https://github.com/dessalines/lemmy) [#2510](https://github.com/FreshRSS/FreshRSS/pull/2510)
* API
	* Add support for [Reeder-4](https://www.reederapp.com/) client [#2513](https://github.com/FreshRSS/FreshRSS/issues/2513)
* Compatibility
	* Require at least PHP 5.6+ [#2495](https://github.com/FreshRSS/FreshRSS/pull/2495), [#2527](https://github.com/FreshRSS/FreshRSS/pull/2527), [#2585](https://github.com/FreshRSS/FreshRSS/pull/2585)
	* Require `php-json` and remove remove `JSON.php` fallback [#2528](https://github.com/FreshRSS/FreshRSS/pull/2528)
	* Require at least PostgreSQL 9.5+ [#2554](https://github.com/FreshRSS/FreshRSS/pull/2554)
* Deployment
	* Take advantage of `mod_authz_core` instead of `mod_access_compat` when running on Apache 2.4+ [#2461](https://github.com/FreshRSS/FreshRSS/pull/2461)
	* Docker: Ubuntu image updated to 19.10 with PHP 7.3.8 and Apache 2.4.41 [#2577](https://github.com/FreshRSS/FreshRSS/pull/2577)
	* Docker: Alpine image updated to 3.10 with PHP 7.3.11 and Apache 2.4.41 [#2238](https://github.com/FreshRSS/FreshRSS/pull/2238)
	* Docker: Increase default PHP POST/upload size to ease importing ZIP files [#2563](https://github.com/FreshRSS/FreshRSS/pull/2563)
	* New environment variable `COPY_LOG_TO_SYSLOG` to see all logs at once in e.g. `docker logs -f` [#2591](https://github.com/FreshRSS/FreshRSS/pull/2591)
	* New environment variable `FRESHRSS_ENV` to control Minz development mode [#2508](https://github.com/FreshRSS/FreshRSS/pull/2508)
	* Git ignore `themes/xTheme-*` [#2511](https://github.com/FreshRSS/FreshRSS/pull/2511)
* Bug fixing
	* Fix missing PHP `opcache` package in Docker Alpine [#2498](https://github.com/FreshRSS/FreshRSS/pull/2498)
	* Fix IE11 / Edge keyboard compatibility [#2507](https://github.com/FreshRSS/FreshRSS/pull/2507)
	* Use `<dc:creator>` instead of `<author>` for RSS 2.0 outputs [#2542](https://github.com/FreshRSS/FreshRSS/pull/2542)
	* Fix PostgreSQL and SQLite database size estimation [#2562](https://github.com/FreshRSS/FreshRSS/pull/2562)
	* Fix broken SVG icons in Swage theme [#2568](https://github.com/FreshRSS/FreshRSS/issues/2568), [#2571](https://github.com/FreshRSS/FreshRSS/pull/2571)
* Security
	* Fix referrer vulnerability when opening an article original link with a shortcut [#2506](https://github.com/FreshRSS/FreshRSS/pull/2506)
	* Slight refactoring of access check [#2471](https://github.com/FreshRSS/FreshRSS/pull/2471)
* UI
	* Optimize dynamic favicon for HiDPI screens [#2539](https://github.com/FreshRSS/FreshRSS/pull/2539)
	* Hide the admin checkbox if user is not admin [#2531](https://github.com/FreshRSS/FreshRSS/pull/2531)
* I18n
	* Add Slovak [#2497](https://github.com/FreshRSS/FreshRSS/pull/2497)
	* Improve Dutch [#2503](https://github.com/FreshRSS/FreshRSS/pull/2503)
	* Improve Occitan [#2519](https://github.com/FreshRSS/FreshRSS/pull/2519), [#2583](https://github.com/FreshRSS/FreshRSS/pull/2583), [#2603](https://github.com/FreshRSS/FreshRSS/pull/2603)
* Extensions
	* Additional hooks [#2482](https://github.com/FreshRSS/FreshRSS/pull/2482)
	* New call to change the layout [#2467](https://github.com/FreshRSS/FreshRSS/pull/2467)
* Misc.
	* Make our JavaScript compatible with LibreJS [#2576](https://github.com/FreshRSS/FreshRSS/pull/2576)
	* PDO (database) refactoring for code simplification [#2522](https://github.com/FreshRSS/FreshRSS/pull/2522)
	* Automatic check of CSS syntax in Travis CI [#2477](https://github.com/FreshRSS/FreshRSS/pull/2477)
	* Make our Travis greener by reducing redundant tests [#2589](https://github.com/FreshRSS/FreshRSS/pull/2589)
	* Remove support for sharing with Google+ [#2464](https://github.com/FreshRSS/FreshRSS/pull/2464)
	* Redirect connected users accessing registration page [#2530](https://github.com/FreshRSS/FreshRSS/pull/2530)
	* Add Makefile [#2481](https://github.com/FreshRSS/FreshRSS/pull/2481)


## 2019-07-25 FreshRSS 1.14.3

* UI
	* New configuration page for each category [#2369](https://github.com/FreshRSS/FreshRSS/issues/2369)
	* Update shortcut configuration page [#2405](https://github.com/FreshRSS/FreshRSS/issues/2405)
	* CSS style for printing [#2149](https://github.com/FreshRSS/FreshRSS/issues/2149)
	* Do not hide multiple `<br />` tags [#2437](https://github.com/FreshRSS/FreshRSS/issues/2437)
	* Updated to jQuery 3.4.1 (only for statistics page) [#2424](https://github.com/FreshRSS/FreshRSS/pull/2424)
* Bug fixing
	* Fix wrong mark-as-read limit [#2429](https://github.com/FreshRSS/FreshRSS/issues/2429)
	* Fix API call for removing a category [#2411](https://github.com/FreshRSS/FreshRSS/issues/2411)
	* Fix user self-registration [#2381](https://github.com/FreshRSS/FreshRSS/issues/2381)
	* Make CGI Authorization configuration for API more compatible [#2446](https://github.com/FreshRSS/FreshRSS/issues/2446)
	* Fix refresh icon in Swage theme [#2375](https://github.com/FreshRSS/FreshRSS/issues/2375)
	* Fix message banner in Swage theme [#2379](https://github.com/FreshRSS/FreshRSS/issues/2379)
	* Docker: Add `php-gmp` for API support in Ubuntu 32-bit [#2450](https://github.com/FreshRSS/FreshRSS/pull/2450)
* Deployment
	* Docker: Add automatic health check [#2438](https://github.com/FreshRSS/FreshRSS/pull/2438), [#2455](https://github.com/FreshRSS/FreshRSS/pull/2455)
	* Docker: Add a version for ARM architecture such as for Raspberry Pi [#2436](https://github.com/FreshRSS/FreshRSS/pull/2436)
	* Docker: Ubuntu image updated to 19.04 with PHP 7.2.19 and Apache 2.4.38 [#2422](https://github.com/FreshRSS/FreshRSS/pull/2422)
	* Docker: Alpine image updated to 3.10 with PHP 7.3.7 and Apache 2.4.39 [#2238](https://github.com/FreshRSS/FreshRSS/pull/2238)
	* Add `hadolint` automatic check of Docker files in Travis [#2456](https://github.com/FreshRSS/FreshRSS/pull/2456)
* Security
	* Allow `@-` as valid characters in usernames (i.e. allow most e-mails) [#2391](https://github.com/FreshRSS/FreshRSS/issues/2391)
* I18n
	* Improve Occitan [#2358](https://github.com/FreshRSS/FreshRSS/pull/2358)
* Misc.
	* New parameter `?maxFeeds=10` to control the max number of feeds to refresh manually [#2388](https://github.com/FreshRSS/FreshRSS/pull/2388)
	* Default to SQLite during install [#2443](https://github.com/FreshRSS/FreshRSS/pull/2443)
	* Add automatic check of shell scripts in Travis with `shellcheck` and `shfmt` [#2454](https://github.com/FreshRSS/FreshRSS/pull/2454)


## 2019-04-08 FreshRSS 1.14.2

* Bug fixing (regressions introduced in 1.14.X)
	* Fix PHP 5.5- compatibility [#2359](https://github.com/FreshRSS/FreshRSS/issues/2359)
* Bug fixing (misc.)
	* Fix minor code syntax warning in API [#2362](https://github.com/FreshRSS/FreshRSS/pull/2362)
* Misc.
	* Add Travis check for PHP syntax [#2361](https://github.com/FreshRSS/FreshRSS/pull/2361)


## 2019-04-07 FreshRSS 1.14.1

* Bug fixing (regressions introduced in 1.14.0)
	* Fix *load more articles* when using ascending order [#2314](https://github.com/FreshRSS/FreshRSS/issues/2314)
	* Fix cron in the Ubuntu flavour of the Docker image [#2319](https://github.com/FreshRSS/FreshRSS/issues/2319)
	* Fix the use of arrow keyboard keys for shortcuts [#2316](https://github.com/FreshRSS/FreshRSS/issues/2316)
	* Fix control+click or middle-click for opening articles in a background tab [#2310](https://github.com/FreshRSS/FreshRSS/issues/2310)
	* Fix the naming of the option to unfold categories [#2307](https://github.com/FreshRSS/FreshRSS/issues/2307)
	* Fix shortcut problem when using unfolded articles [#2328](https://github.com/FreshRSS/FreshRSS/issues/2328)
	* Fix auto-hiding articles [#2323](https://github.com/FreshRSS/FreshRSS/issues/2323)
	* Fix scroll functions with Edge [#2337](https://github.com/FreshRSS/FreshRSS/pull/2337)
	* Fix drop-down menu warning [#2353](https://github.com/FreshRSS/FreshRSS/pull/2353)
	* Fix delay for individual mark-as-read actions [#2332](https://github.com/FreshRSS/FreshRSS/issues/2332)
	* Fix scroll functions in Edge [#2337](https://github.com/FreshRSS/FreshRSS/pull/2337)
* Bug fixing (misc.)
	* Fix extensions in Windows [#994](https://github.com/FreshRSS/FreshRSS/issues/994)
	* Fix import of empty articles [#2351](https://github.com/FreshRSS/FreshRSS/pull/2351)
	* Fix quote escaping on CLI i18n tools [#2355](https://github.com/FreshRSS/FreshRSS/pull/2355)
* UI
	* Better handling of bad Ajax requests and fast page unload (ask confirmation) [#2346](https://github.com/FreshRSS/FreshRSS/pull/2346)
* I18n
	* Improve Dutch [#2312](https://github.com/FreshRSS/FreshRSS/pull/2312)
* Misc.
	* Check JavaScript (jshint) in Travis continuous integration [#2315](https://github.com/FreshRSS/FreshRSS/pull/2315)
	* Add PHP 7.3 to Travis [#2317](https://github.com/FreshRSS/FreshRSS/pull/2317)


## 2019-03-31 FreshRSS 1.14.0

* Features
	* *Filter actions* feature, to auto-mark-as-read based on a search query per feed [#2275](https://github.com/FreshRSS/FreshRSS/pull/2275)
	* Improve account change when using the *unsafe automatic login* [#2288](https://github.com/FreshRSS/FreshRSS/issues/2288)
* UI
	* New themes *Ansum* and *Mapco* [#2245](https://github.com/FreshRSS/FreshRSS/pull/2245)
	* Rewrite jQuery and keyboard shortcut code as native JavaScript ES6 (except for graphs on the statistics pages) [#2234](https://github.com/FreshRSS/FreshRSS/pull/2234)
	* Batch scroll-as-read for better client-side and server-side performance [#2199](https://github.com/FreshRSS/FreshRSS/pull/2199)
	* Keyboard-shortcut navigation at end of feed or category continues to the next one [#2255](https://github.com/FreshRSS/FreshRSS/pull/2255)
	* Changed jump behaviour after marking articles as read [#2206](https://github.com/FreshRSS/FreshRSS/issues/2206)
	* More reactive auto-loading of articles [#2268](https://github.com/FreshRSS/FreshRSS/pull/2268)
* Deployment
	* New default Docker image based on Ubuntu (~3 times faster, but ~2.5 times larger) [#2205](https://github.com/FreshRSS/FreshRSS/pull/2205)
		* Using Ubuntu 18.10 with PHP 7.2.15 and Apache 2.4.34
	* Alpine version updated to Alpine 3.9 with PHP 7.2.14 and Apache 2.4.38 [#2238](https://github.com/FreshRSS/FreshRSS/pull/2238)
* Bug fixing
	* Fix feed option for marking modified articles as unread [#2200](https://github.com/FreshRSS/FreshRSS/issues/2200)
	* Fix API HTTP Authorization case-sensitivity issue introduced in FreshRSS 1.13.1 [#2233](https://github.com/FreshRSS/FreshRSS/issues/2233)
	* Fix breaking warning in Fever API [#2239](https://github.com/FreshRSS/FreshRSS/issues/2239)
	* Fix encoding problem in Fever API [#2241](https://github.com/FreshRSS/FreshRSS/issues/2241)
	* Fix author semi-colon prefix in Fever API [#2281](https://github.com/FreshRSS/FreshRSS/issues/2281)
	* Fix the reading of the environment variable `COPY_SYSLOG_TO_STDERR` [#2260](https://github.com/FreshRSS/FreshRSS/pull/2260)
	* Session fix when form login + HTTP auth are used [#2286](https://github.com/FreshRSS/FreshRSS/pull/2286)
	* Fix `cli/user-info.php` for accounts using a version of the database older than 1.12.0 [#2291](https://github.com/FreshRSS/FreshRSS/issues/2291)
* CLI
	* Better validation of parameters [#2046](https://github.com/FreshRSS/FreshRSS/issues/2046)
	* New option `--header` to `cli/user-info.php` [#2296](https://github.com/FreshRSS/FreshRSS/pull/2296)
* API
	* Supported by [Readably](https://play.google.com/store/apps/details?id=com.isaiasmatewos.readably) (client for Android using Fever API)
* I18n
	* Improve Korean [#2242](https://github.com/FreshRSS/FreshRSS/pull/2242)
	* Improve Occitan [#2253](https://github.com/FreshRSS/FreshRSS/pull/2253)
* Security
	* Reworked the CSRF token interaction with the session in some edge cases [#2290](https://github.com/FreshRSS/FreshRSS/pull/2290)
	* Remove deprecated CSP `child-src` instruction (was already replaced by `frame-src`) [#2250](https://github.com/FreshRSS/FreshRSS/pull/2250)
	* Ensure entry IDs are unique and cannot be set by feeds [#2273](https://github.com/FreshRSS/FreshRSS/issues/2273)
* Misc.
	* Remove HHMV from Travis continuous integration [#2249](https://github.com/FreshRSS/FreshRSS/pull/2249)


## 2019-01-26 FreshRSS 1.13.1

* Features
	* Include articles with custom labels during export [#2196](https://github.com/FreshRSS/FreshRSS/issues/2196)
	* Export/import articles read/unread state [#2226](https://github.com/FreshRSS/FreshRSS/pull/2226)
	* Import FeedBin, and more robust general import [#2228](https://github.com/FreshRSS/FreshRSS/pull/2228)
* Bug fixing
	* Fix missing HTTP `X-Forwarded-Prefix` in cookie path behind a reverse-proxy [#2201](https://github.com/FreshRSS/FreshRSS/pull/2201)
* Deployment
	* Docker improvements [#2202](https://github.com/FreshRSS/FreshRSS/pull/2202)
		* Performance: Hard-include Apache .htaccess to avoid having to scan for changes in those files
		* Performance: Disable unused Apache security check of symlinks
		* Performance: Disable unused Apache modules
		* Add option to mount custom `.htaccess` for HTTP authentication
		* Docker logs gets PHP syslog messages (e.g. from cron job and when fetching external content)
	* New environment variable `COPY_SYSLOG_TO_STDERR` or in `constants.local.php` to copy PHP syslog messages to STDERR [#2213](https://github.com/FreshRSS/FreshRSS/pull/2213)
	* New `TZ` timezone environment variable [#2153](https://github.com/FreshRSS/FreshRSS/issues/2153)
	* Run Docker cron job with Apache user instead of root [#2208](https://github.com/FreshRSS/FreshRSS/pull/2208)
	* Accept HTTP header `X-WebAuth-User` for delegated HTTP Authentication [#2204](https://github.com/FreshRSS/FreshRSS/pull/2204)
* Extensions
	* Trigger a `freshrss:openArticle` JavaScript event [#2222](https://github.com/FreshRSS/FreshRSS/pull/2222)
* API
	* Automatic test of API configuration [#2207](https://github.com/FreshRSS/FreshRSS/pull/2207)
	* Performance + compatibility: Use Apache `SetEnvIf` module if available and fall-back to `RewriteRule` [#2202](https://github.com/FreshRSS/FreshRSS/pull/2202)
* Security
	* Fixes when HTTP user does not exist in FreshRSS [#2204](https://github.com/FreshRSS/FreshRSS/pull/2204)
* I18n
	* Improve Dutch [#2221](https://github.com/FreshRSS/FreshRSS/pull/2221)
	* Improve Occitan [#2230](https://github.com/FreshRSS/FreshRSS/pull/2230)
* Accessibility
	* Remove alt in logo [#2209](https://github.com/FreshRSS/FreshRSS/pull/2209)


## 2018-12-22 FreshRSS 1.13.0

* API
	* Improvements to the Google Reader API [#2093](https://github.com/FreshRSS/FreshRSS/pull/2093)
		* Support for [Vienna RSS](http://www.vienna-rss.com/) (client for Mac OS X) [#2091](https://github.com/FreshRSS/FreshRSS/issues/2091)
	* Contributions to WebSub in third-party systems to support instant push notifications
		from [Mastodon](https://joinmastodon.org) 2.6.2+ and [Friendica](https://friendi.ca) 2018.12+
		[#mastodon/9302](https://github.com/tootsuite/mastodon/pull/9302), [#friendica/6137](https://github.com/friendica/friendica/pull/6137)
		* Rename the PubSubHubbub protocol to use the new standard [WebSub](https://www.w3.org/TR/websub/) name [#2184](https://github.com/FreshRSS/FreshRSS/pull/2184)
* Features
	* Ability to import XML files exported from Tiny-Tiny-RSS [#2079](https://github.com/FreshRSS/FreshRSS/issues/2079)
	* Ability to show all the feeds that have a warning [#2146](https://github.com/FreshRSS/FreshRSS/issues/2146)
	* Share with Pinboard [#1972](https://github.com/FreshRSS/FreshRSS/issues/1972)
* UI
	* Reworked the scrolling of the categories/feeds sidebar [#2117](https://github.com/FreshRSS/FreshRSS/pull/2117)
		* Native styled scrollbars in Firefox 64+, Chrome.
	* Show collapsed sidebar in the reader mode [#2169](https://github.com/FreshRSS/FreshRSS/issues/2169)
	* New shortcuts to move to previous/next article without opening it [#1767](https://github.com/FreshRSS/FreshRSS/pull/1767)
	* Fix regression from 1.12.0 preventing from closing an article [#2085](https://github.com/FreshRSS/FreshRSS/issues/2085)
	* Improvements of the Swage theme [#2088](https://github.com/FreshRSS/FreshRSS/pull/2088), [#2094](https://github.com/FreshRSS/FreshRSS/pull/2094)
	* Many style improvements [#2108](https://github.com/FreshRSS/FreshRSS/pull/2108), [#2115](https://github.com/FreshRSS/FreshRSS/issues/2115),
		[#1620](https://github.com/FreshRSS/FreshRSS/issues/1620), [#2089](https://github.com/FreshRSS/FreshRSS/pull/2089),
		[#2122](https://github.com/FreshRSS/FreshRSS/pull/2122), [#2161](https://github.com/FreshRSS/FreshRSS/pull/2161)
* Deployment
	* Support for HTTP `X-Forwarded-Prefix` to ease the use of reverse proxies [#2191](https://github.com/FreshRSS/FreshRSS/pull/2191)
		* Updated Docker + Træfik + Let’s Encrypt deployment guide [#2189](https://github.com/FreshRSS/FreshRSS/pull/2189)
	* Docker image updated to Alpine 3.8.2 with PHP 7.2.13 and Apache 2.4.35
	* Fix `.dockerignore` [#2195](https://github.com/FreshRSS/FreshRSS/pull/2195)
* I18n
	* Occitan [#2110](https://github.com/FreshRSS/FreshRSS/pull/2110)
* SimplePie
	* Update to SimplePie 1.5.2 [#2136](https://github.com/FreshRSS/FreshRSS/pull/2136)
		* Fix some sanitizing in authors / tags
	* Strip embedded SVG images for now [#2135](https://github.com/FreshRSS/FreshRSS/pull/2135)
* Security
	* Fix HTML injections reported by [Netsparker](https://www.netsparker.com) [#2121](https://github.com/FreshRSS/FreshRSS/issues/2121)
* Bug fixing
	* Fix warning in `tempnam()` with PHP 7.1+ affecting ZIP export [#2134](https://github.com/FreshRSS/FreshRSS/pull/2134)
	* Fix print for views with unfolded articles [#2130](https://github.com/FreshRSS/FreshRSS/issues/2130)
	* Fix notifications in reader view [#1407](https://github.com/FreshRSS/FreshRSS/issues/1407)
	* Fix sharing with Movim [#1781](https://github.com/FreshRSS/FreshRSS/issues/1781)
* Misc.
	* Add username in configuration menu and exported files [#2133](https://github.com/FreshRSS/FreshRSS/pull/2133)
	* New option to set the duration of the cookie session [#2137](https://github.com/FreshRSS/FreshRSS/pull/2137)
	* Add [donation option via Liberapay](https://liberapay.com/FreshRSS/) [#1694](https://github.com/FreshRSS/FreshRSS/issues/1694)


## 2018-10-28 FreshRSS 1.12.0

* Features
	* Ability to add *labels* (custom tags) to articles [#928](https://github.com/FreshRSS/FreshRSS/issues/928)
		* Also available through Google Reader API (full support in News+, partial in FeedMe, EasyRSS). No support in Fever API.
	* Handle article tags containing spaces, as well as comma-separated tags [#2023](https://github.com/FreshRSS/FreshRSS/pull/2023)
	* Handle authors containing spaces, as well as comma or semi-colon separated authors [#2025](https://github.com/FreshRSS/FreshRSS/pull/2025)
	* Searches by tag, author, etc. accept Unicode characters [#2025](https://github.com/FreshRSS/FreshRSS/pull/2025)
	* New option to disable cache for feeds with invalid HTTP caching [#2052](https://github.com/FreshRSS/FreshRSS/pull/2052)
* UI
	* New theme *Swage* [#2069](https://github.com/FreshRSS/FreshRSS/pull/2069)
	* Click on authors to initiate a search by author [#2025](https://github.com/FreshRSS/FreshRSS/pull/2025)
	* Fix CSS for button alignments in older Chrome versions [#2020](https://github.com/FreshRSS/FreshRSS/pull/2020)
	* Updated to jQuery 3.3.1 [#2021](https://github.com/FreshRSS/FreshRSS/pull/2021)
	* Updated to bcrypt.js 2.4.4 [#2022](https://github.com/FreshRSS/FreshRSS/pull/2022)
* Security
	* Improved flow for password change (avoid error 403) [#2056](https://github.com/FreshRSS/FreshRSS/issues/2056)
	* Allow dot `.` in username (best to avoid, though) [#2061](https://github.com/FreshRSS/FreshRSS/issues/2061)
* Performance
	* Remove some counterproductive preload / prefetch rules [#2040](https://github.com/FreshRSS/FreshRSS/pull/2040)
	* Improved fast flush (earlier transfer, fetching of resources, and rendering) [#2045](https://github.com/FreshRSS/FreshRSS/pull/2045)
		* Only available for Apache running PHP as module (not for NGINX, or PHP as CGI / FPM) because we want to keep compression
* Deployment
	* Fix Docker bug with some cron values [#2032](https://github.com/FreshRSS/FreshRSS/pull/2032)
	* Perform `git clean -f -d -f` (removes unknown files and folders) before git auto-update method [#2036](https://github.com/FreshRSS/FreshRSS/pull/2036)
	* Docker image updated to Alpine 3.8.1 with PHP 7.2.8 and Apache 2.4.34
* Bug fixing
	* Make article GUIDs case-sensitive also with MySQL [#2077](https://github.com/FreshRSS/FreshRSS/issues/2077)
	* Ask confirmation for important configuration actions [#2048](https://github.com/FreshRSS/FreshRSS/pull/2048)
	* Fix database size in the Web UI for users about to be deleted [#2047](https://github.com/FreshRSS/FreshRSS/pull/2047)
	* Fix actualize bug after install [#2044](https://github.com/FreshRSS/FreshRSS/pull/2044)
	* Fix manual / Web actualize for which the final commit could be done too early [#2081](https://github.com/FreshRSS/FreshRSS/pull/2081)
	* Fix regression from version 1.11.2, which might have wrongly believed that the server address was private [#2084](https://github.com/FreshRSS/FreshRSS/pull/2084)
		* Please check in `data/config.php` that you have `'pubsubhubbub_enabled' => true,` if your server has a public address
* Extensions
	* Update built-in extension to again fix Tumblr feeds from European Union due to GDPR [#2053](https://github.com/FreshRSS/FreshRSS/pull/2053)
* I18n
	* Fix missing German translations, e.g. for *Sharing with Known* [#2059](https://github.com/FreshRSS/FreshRSS/pull/2059)
* Misc.
	* Better port detection behind a proxy [#2031](https://github.com/FreshRSS/FreshRSS/issues/2031)


## 2018-09-09 FreshRSS 1.11.2

* Features
	* New menu to mark selected articles (view) as unread [#1966](https://github.com/FreshRSS/FreshRSS/issues/1966)
	* Share with LinkedIn [#1960](https://github.com/FreshRSS/FreshRSS/pull/1960)
* Deployment
	* Update Docker image to Alpine 3.8 with PHP 7.2 [#1956](https://github.com/FreshRSS/FreshRSS/pull/1956)
* Bug fixing
	* Fix bugs when searching with special characters (e.g. preventing marking as read) [#1944](https://github.com/FreshRSS/FreshRSS/issues/1944)
	* Avoid cutting in the middle of a multi-byte Unicode character [#1996](https://github.com/FreshRSS/FreshRSS/pull/1996)
	* Fix username check in API to allow underscores [#1955](https://github.com/FreshRSS/FreshRSS/issues/1955)
	* Fix Fever API to allow 32-bit architectures [#1962](https://github.com/FreshRSS/FreshRSS/issues/1962)
	* Fix CSS font bug for *Origine-compact* theme [#1990](https://github.com/FreshRSS/FreshRSS/issues/1990)
	* Fix last user activity for SQLite and PostgreSQL [#2008](https://github.com/FreshRSS/FreshRSS/pull/2008)
	* Fix article counts with SQLite [#2009](https://github.com/FreshRSS/FreshRSS/pull/2009)
	* Fix some automatic URL generation cases [#1946](https://github.com/FreshRSS/FreshRSS/issues/1946)
* Security
	* Avoid feed credentials in logs [#1949](https://github.com/FreshRSS/FreshRSS/pull/1949)
* UI
	* Improved mark-as-read the bottom articles during scrolling [#1973](https://github.com/FreshRSS/FreshRSS/issues/1973)
	* Show all authors for articles with multiple authors [#1968](https://github.com/FreshRSS/FreshRSS/issues/1968)
* I18n
	* Updated Korean [#1985](https://github.com/FreshRSS/FreshRSS/pull/1985)
* Mics.
	* Auto-login after self user creation [#1928](https://github.com/FreshRSS/FreshRSS/issues/1928)
	* Better test if server has public address [#2010](https://github.com/FreshRSS/FreshRSS/pull/2010)
	* Allow `-` in database name at install time [#2005](https://github.com/FreshRSS/FreshRSS/pull/2005)


## 2018-06-16 FreshRSS 1.11.1

* Features
	* Better support of `media:` tags such as thumbnails and descriptions (e.g. for YouTube) [#944](https://github.com/FreshRSS/FreshRSS/issues/944)
* Extensions
	* New extension mechanism allowing changing HTTP headers and other SimplePie parameters [#1924](https://github.com/FreshRSS/FreshRSS/pull/1924)
	* Built-in extension to fix Tumblr feeds from European Union due to GDPR [#1894](https://github.com/FreshRSS/FreshRSS/issues/1894)
* Bug fixing
	* Fix bug in case of bad i18n in extensions [#1797](https://github.com/FreshRSS/FreshRSS/issues/1797)
	* Fix extension callback for updated articles and PubSubHubbub [#1926](https://github.com/FreshRSS/FreshRSS/issues/1926)
	* Fix regression in fetching full articles content [#1917](https://github.com/FreshRSS/FreshRSS/issues/1917)
	* Fix several bugs in the new Fever API [#1930](https://github.com/FreshRSS/FreshRSS/issues/1930)
	* Updated sharing to Mastodon [#1904](https://github.com/FreshRSS/FreshRSS/issues/1904)


## 2018-06-03 FreshRSS 1.11.0

* API
	* Add support for Fever compatible API, enabling more clients [#1406](https://github.com/FreshRSS/FreshRSS/pull/1406)
		* iOS: [Fiery Feeds](https://apps.apple.com/app/fiery-feeds-rss-reader/id1158763303), [Unread](https://apps.apple.com/app/unread-rss-reader/id1252376153)
		* MacOS: [Readkit](https://apps.apple.com/app/readkit/id588726889)
* Features
	* Several per-feed options (implemented in JSON) [#1838](https://github.com/FreshRSS/FreshRSS/pull/1838)
		* Mark updated articles as read [#891](https://github.com/FreshRSS/FreshRSS/issues/891)
		* Mark as read upon reception [#1702](https://github.com/FreshRSS/FreshRSS/issues/1702)
		* Only for admin user [#1905](https://github.com/FreshRSS/FreshRSS/pull/1905)
			* Feed cURL timeout
			* Ignore SSL (unsafe) [#1811](https://github.com/FreshRSS/FreshRSS/issues/1811)
	* Light Boolean search implementation [#879](https://github.com/FreshRSS/FreshRSS/issues/879)
		* All parts are implicitly `AND` (which must not be written), except if `OR` is stated.
		* No use of parentheses. Support for quotes to disable the Boolean search, like `"This or that"`.
		* Example: `Hello intitle:World OR date:P1D example OR author:Else intitle:"This or that"`
	* Share with Pocket [#1884](https://github.com/FreshRSS/FreshRSS/issues/1884)
* Deployment
	* Includes an optional cron daemon in Docker to refresh feeds automatically [#1869](https://github.com/FreshRSS/FreshRSS/issues/1869)
	* Docker Compose example [#1882](https://github.com/FreshRSS/FreshRSS/pull/1882)
* Bug fixing
	* Fix Docker bug affecting Apache `CustomLog` (unwanted local copy of access logs), `ErrorLog`, `Listen` (IPv6 bug) [#1873](https://github.com/FreshRSS/FreshRSS/pull/1873)
	* Fix muted feeds that were not actually muted [#1844](https://github.com/FreshRSS/FreshRSS/issues/1844)
	* Fix null exception in shares, showing only the first article [#1824](https://github.com/FreshRSS/FreshRSS/issues/1824)
	* Fix error during import [#1890](https://github.com/FreshRSS/FreshRSS/issues/1890)
		* Fix additional automatic sequence bug with PostgreSQL [#1907](https://github.com/FreshRSS/FreshRSS/pull/1907)
	* Fix errors in case of empty/wrong username when updating user settings [#1857](https://github.com/FreshRSS/FreshRSS/pull/1857)
	* Fixes in subscription menu [#1858](https://github.com/FreshRSS/FreshRSS/pull/1858)
	* Fix allowing Unix sockets for MySQL and PostgreSQL [#1888](https://github.com/FreshRSS/FreshRSS/issues/1888)
	* Fix `create-user` CLI option `no_default_feeds` [#1900](https://github.com/FreshRSS/FreshRSS/pull/1900)
* SimplePie
	* Work-around for feeds with invalid non-unique GUIDs [#1887](https://github.com/FreshRSS/FreshRSS/pull/1887)
	* Fix for Atom feeds using a namespace for type [#1892](https://github.com/FreshRSS/FreshRSS/issues/1892)
	* Remove some warnings during parsing attempts of some bad feeds [#1909](https://github.com/FreshRSS/FreshRSS/pull/1909)
* Security
	* Strip HTTP credentials from HTTP Referer in SimplePie [#1891](https://github.com/FreshRSS/FreshRSS/pull/1891)
	* Use `autocomplete="new-password"` to prevent form autocomplete in user management pages (fix bug with e.g. Firefox) [#1877](https://github.com/FreshRSS/FreshRSS/pull/1877)
* UI
	* Add tooltips on user queries [#1823](https://github.com/FreshRSS/FreshRSS/pull/1823)
* I18n
	* Improve i18n tools [#1829](https://github.com/FreshRSS/FreshRSS/pull/1829)
	* Updated German [#1856](https://github.com/FreshRSS/FreshRSS/pull/1856)
	* Updated Dutch [#1903](https://github.com/FreshRSS/FreshRSS/pull/1903)
* Misc.
	* Use cURL for fetching full articles content [#1870](https://github.com/FreshRSS/FreshRSS/issues/1870)
	* Add error log information when SQLite has not enough temp space [#1816](https://github.com/FreshRSS/FreshRSS/issues/1816)
	* Allow extension dir to be a symlink [#1911](https://github.com/FreshRSS/FreshRSS/pull/1911)


## 2018-03-09 FreshRSS 1.10.2 (Docker only)

* Bug fixing
	* Fix Docker image for OPML import [#1819](https://github.com/FreshRSS/FreshRSS/pull/1819)
	* Fix Docker image for CSS selectors [#1821](https://github.com/FreshRSS/FreshRSS/issues/1821)
	* Fix Docker other missing PHP extensions [#1822](https://github.com/FreshRSS/FreshRSS/pull/1822)


## 2018-03-04 FreshRSS 1.10.1

* Deployment
	* New Docker image, smaller (based on Alpine Linux) and newer (with PHP 7.1) [#1813](https://github.com/FreshRSS/FreshRSS/pull/1813)
		* with [automated build](https://hub.docker.com/r/freshrss/freshrss/) for x86-64 (AMD64) architectures
* CLI
	* New command `./cli/prepare.php` to make the needed sub-directories of the `./data/` directory [#1813](https://github.com/FreshRSS/FreshRSS/pull/1813)
* Bug fixing
	* Fix API bug for EasyRSS [#1799](https://github.com/FreshRSS/FreshRSS/issues/1799)
	* Fix login bug when using double authentication (HTTP + Web form) [#1807](https://github.com/FreshRSS/FreshRSS/issues/1807)
	* Fix database upgrade for FreshRSS versions older than 1.1.1 [#1803](https://github.com/FreshRSS/FreshRSS/issues/1803)
	* Fix cases of double port in FreshRSS public URL [#1815](https://github.com/FreshRSS/FreshRSS/pull/1815)
* UI
	* Add tooltips on share configuration buttons [#1805](https://github.com/FreshRSS/FreshRSS/pull/1805)
* Misc.
	* Move `./data/shares.php` to `./app/shares.php` to facilitate updates [#1812](https://github.com/FreshRSS/FreshRSS/pull/1812)
	* Show article author email when there is no author name [#1801](https://github.com/FreshRSS/FreshRSS/pull/1801)
	* Improve translation tools [#1808](https://github.com/FreshRSS/FreshRSS/pull/1808)


## 2018-02-24 FreshRSS 1.10.0

* API
	* Add compatibility with [FeedMe](https://play.google.com/store/apps/details?id=com.seazon.feedme) 3.5.3+ on Android [#1774](https://github.com/FreshRSS/FreshRSS/pull/1774)
* Features
	* Ability to pause feeds, and to hide them from categories [#1750](https://github.com/FreshRSS/FreshRSS/pull/1750)
	* Ability for the admin to reset a user’s password [#960](https://github.com/FreshRSS/FreshRSS/issues/960)
* Security
	* Allow HTTP Auth login with `REDIRECT_REMOTE_USER` when using Apache internal redirect [#1772](https://github.com/FreshRSS/FreshRSS/pull/1772)
* UI
	* New icons for marking as favourite and marking as read in the Reading View [#603](https://github.com/FreshRSS/FreshRSS/issues/603)
	* Add shortcuts to switch views [#1755](https://github.com/FreshRSS/FreshRSS/pull/1755)
* Bug fixing
	* Fix login bug when HTTP `REMOTE_USER` changes (used by YunoHost) [#1756](https://github.com/FreshRSS/FreshRSS/pull/1756)
	* Fix warning in PHP 7.2 [#1739](https://github.com/FreshRSS/FreshRSS/pull/1739)
* Extensions
	* Allow extensions to define their own reading view [#1714](https://github.com/FreshRSS/FreshRSS/pull/1714)
* I18n
	* Updated Chinese [#1769](https://github.com/FreshRSS/FreshRSS/pull/1769)
	* Updated Dutch [#1792](https://github.com/FreshRSS/FreshRSS/pull/1792)
	* Updated Korean [#1776](https://github.com/FreshRSS/FreshRSS/pull/1776)
* Misc.
	* More sites in `force-https.default.txt` [#1745](https://github.com/FreshRSS/FreshRSS/pull/1745)
	* Trim URLs when adding new feeds [#1778](https://github.com/FreshRSS/FreshRSS/pull/1778)


## 2017-12-17 FreshRSS 1.9.0

* Features
	* Share with Mastodon [#1521](https://github.com/FreshRSS/FreshRSS/issues/1521)
* UI
	* Add more Unicode glyphs in the Open Sans font [#1032](https://github.com/FreshRSS/FreshRSS/pull/1032)
	* Show URL to add subscriptions from third-party tools [#1247](https://github.com/FreshRSS/FreshRSS/issues/1247)
	* Improved message when checking for new versions [#1586](https://github.com/FreshRSS/FreshRSS/issues/1586)
* SimplePie
	* Remove "SimplePie" name from HTTP User-Agent string [#1656](https://github.com/FreshRSS/FreshRSS/pull/1656)
* Bug fixing
	* Work-around for PHP 5.6.0- `CURLOPT_FOLLOWLOCATION` `open_basedir` bug in favicons and PubSubHubbub [#1655](https://github.com/FreshRSS/FreshRSS/issues/1655)
	* Fix PDO PostgreSQL detection [#1690](https://github.com/FreshRSS/FreshRSS/issues/1690)
	* Fix punycode warning in PHP 7.2 [#1699](https://github.com/FreshRSS/FreshRSS/issues/1699)
	* Fix crash when adding a new category while adding a new feed [#1731](https://github.com/FreshRSS/FreshRSS/pull/1731)
	* Fix ExtensionManager exception handling [#1724](https://github.com/FreshRSS/FreshRSS/pull/1724)
* CLI
	* New command `./cli/db-optimize.php` for database optimisation [#1583](https://github.com/FreshRSS/FreshRSS/issues/1583)
	* Check PHP requirements before running `actualize_script.php` (cron for refreshing feeds) [#1711](https://github.com/FreshRSS/FreshRSS/pull/1711)
* SQL
	* Perform `VACUUM` on SQLite and PostgreSQL databases when optimisation is requested [#918](https://github.com/FreshRSS/FreshRSS/issues/918)
* API
	* Breaking change / compatibility fix (EasyRSS): Provide `link` to articles without HTML-encoding [#1683](https://github.com/FreshRSS/FreshRSS/issues/1683)
* Extensions
	* Breaking change: uppercase `./Controllers/` directory [#1729](https://github.com/FreshRSS/FreshRSS/pull/1729)
	* Show existing extensions in admin panel [#1708](https://github.com/FreshRSS/FreshRSS/pull/1708)
	* New function `$entry->_hash($hex)` for extensions that change the content of entries [#1707](https://github.com/FreshRSS/FreshRSS/pull/1707)
* I18n
	* Hebrew [#1716](https://github.com/FreshRSS/FreshRSS/pull/1716)
	* Improved German [#1698](https://github.com/FreshRSS/FreshRSS/pull/1698)
* Misc.
	* Customisable `constants.local.php` [#1725](https://github.com/FreshRSS/FreshRSS/pull/1725)
	* Basic mechanism to limit the size of the logs [#1712](https://github.com/FreshRSS/FreshRSS/pull/1712)
	* Translation validation tool [#1653](https://github.com/FreshRSS/FreshRSS/pull/1653)
	* Translation manipulation tool [#1658](https://github.com/FreshRSS/FreshRSS/pull/1658)
	* Improved documentation [#1697](https://github.com/FreshRSS/FreshRSS/pull/1697), [#1704](https://github.com/FreshRSS/FreshRSS/pull/1704)
	* New `.editorconfig` file [#1732](https://github.com/FreshRSS/FreshRSS/pull/1732)


## 2017-10-01 FreshRSS 1.8.0

* Compatibility
	* Minimal PHP version increased to PHP 5.3.8+ to fix sanitize bug [#1604](https://github.com/FreshRSS/FreshRSS/issues/1604)
	* Add support for PHP 7.1 in the API [#1584](https://github.com/FreshRSS/FreshRSS/issues/1584), [#1594](https://github.com/FreshRSS/FreshRSS/pull/1594)
* UI
	* New page for subscription tools [#1534](https://github.com/FreshRSS/FreshRSS/issues/1354)
	* Adjustments to the padding of the tree of categories and feeds [1589](https://github.com/FreshRSS/FreshRSS/pull/1589)
	* Fix feed column position after lazy-loading images [#1616](https://github.com/FreshRSS/FreshRSS/pull/1616)
	* Force UI controls for HTML5 video and audio [#1642](https://github.com/FreshRSS/FreshRSS/pull/1642)
	* Fix share menu on small screens [#1645](https://github.com/FreshRSS/FreshRSS/pull/1645)
	* Go back to previous view when collapsing article [#1177](https://github.com/FreshRSS/FreshRSS/issues/1177)
* CLI
	* New command `./cli/update-user.php` to update user settings [#1600](https://github.com/FreshRSS/FreshRSS/issues/1600)
* I18n
	* Korean [#1578](https://github.com/FreshRSS/FreshRSS/pull/1578)
	* Portuguese (Brazilian) [#1648](https://github.com/FreshRSS/FreshRSS/pull/1648)
	* Fix month abbreviations [#1560](https://github.com/FreshRSS/FreshRSS/issues/1560)
* Bug fixing
	* Fix API compatibility bug between PostgreSQL and EasyRSS [#1603](https://github.com/FreshRSS/FreshRSS/pull/1603)
	* Fix PostgreSQL error when adding entries with duplicated GUID [#1610](https://github.com/FreshRSS/FreshRSS/issues/1610), [#1614](https://github.com/FreshRSS/FreshRSS/issues/1614)
	* Fix for RSS feeds containing HTML in author field [#1590](https://github.com/FreshRSS/FreshRSS/issues/1590)
	* Fix logout issue in global view due to CSRF [#1591](https://github.com/FreshRSS/FreshRSS/issues/1591)
* Misc.
	* Travis continuous integration [#1619](https://github.com/FreshRSS/FreshRSS/pull/1619)
	* Allow longer database usernames [#1597](https://github.com/FreshRSS/FreshRSS/issues/1597)


## 2017-06-03 FreshRSS 1.7.0

* Features
	* Deferred insertion of new articles, for better chronological order [#530](https://github.com/FreshRSS/FreshRSS/issues/530)
	* Better search:
		* Possibility to use multiple `intitle:`, `inurl:`, `author:` [#1478](https://github.com/FreshRSS/FreshRSS/pull/1478)
		* Negative searches with `!` or `-` [#1381](https://github.com/FreshRSS/FreshRSS/issues/1381)
			* Examples: `!intitle:unwanted`, `-intitle:unwanted`, `-inurl:unwanted`, `-author:unwanted`, `-#unwanted`, `-unwanted`
		* Allow double-quotes, such as `author:"some name"`, in addition to single-quotes such as `author:'some name'` [#1478](https://github.com/FreshRSS/FreshRSS/pull/1478)
	* Multi-user tokens (to access RSS outputs of any user) [#1390](https://github.com/FreshRSS/FreshRSS/issues/1390)
* Compatibility
	* Add support for PHP 7.1 [#1471](https://github.com/FreshRSS/FreshRSS/issues/1471)
	* PostgreSQL is not experimental anymore [#1476](https://github.com/FreshRSS/FreshRSS/pull/1476)
* Bug fixing
	* Fix PubSubHubbub bugs when deleting users, and improved behaviour when removing feeds [#1495](https://github.com/FreshRSS/FreshRSS/pull/1495)
	* Fix SQL uniqueness bug with PostgreSQL [#1476](https://github.com/FreshRSS/FreshRSS/pull/1476)
		* (Require manual update for existing installations)
	* Do not require PHP extension `fileinfo` for favicons [#1461](https://github.com/FreshRSS/FreshRSS/issues/1461)
	* Fix UI lowest subscription popup hidden [#1479](https://github.com/FreshRSS/FreshRSS/issues/1479)
	* Fix update system via ZIP archive [#1498](https://github.com/FreshRSS/FreshRSS/pull/1498)
	* Work around for IE / Edge bug in username pattern in version 1.6.3 [#1511](https://github.com/FreshRSS/FreshRSS/issues/1511)
	* Fix *mark as read* articles when adding a new feed [#1535](https://github.com/FreshRSS/FreshRSS/issues/1535)
	* Change load order of CSS and JS to help CustomCSS and CustomJS extensions [Extensions#13](https://github.com/FreshRSS/Extensions/issues/13), [#1547](https://github.com/FreshRSS/FreshRSS/pull/1547)
* UI
	* New option for not closing the article when clicking outside its area [#1539](https://github.com/FreshRSS/FreshRSS/pull/1539)
	* Add shortcut in reader view to open the original page [#1564](https://github.com/FreshRSS/FreshRSS/pull/1564)
	* Download icon 💾 for other MIME types (e.g. `application/*`) [#1522](https://github.com/FreshRSS/FreshRSS/pull/1522)
* I18n
	* Simplified Chinese [#1541](https://github.com/FreshRSS/FreshRSS/pull/1541)
	* Improve English [#1465](https://github.com/FreshRSS/FreshRSS/pull/1465)
	* Improve Dutch [#1559](https://github.com/FreshRSS/FreshRSS/pull/1559)
	* Added Spanish language [#1631](https://github.com/FreshRSS/FreshRSS/pull/1631/)
* Security
	* Do not require write access to check availability of new versions [#1450](https://github.com/FreshRSS/FreshRSS/issues/1450)
* Misc.
	* Move [documentation](./docs/) into FreshRSS code [#1510](https://github.com/FreshRSS/FreshRSS/pull/1510)
	* Moved `./data/force-https.default.txt` to `./force-https.default.txt`,
		`./data/config.default.php` to `./config.default.php`,
		and `./data/users/_/config.default.php` to `./config-user.default.php` [#1531](https://github.com/FreshRSS/FreshRSS/issues/1531)
	* Fall back to article URL when the article GUID is empty [#1482](https://github.com/FreshRSS/FreshRSS/issues/1482)
	* Rewritten Favicon library using cURL [#1504](https://github.com/FreshRSS/FreshRSS/pull/1504)
	* Fix SimplePie option to disable syslog [#1528](https://github.com/FreshRSS/FreshRSS/pull/1528)


## 2017-03-11 FreshRSS 1.6.3

* Features
	* New option `disable_update` (also from CLI) to hide the system to update to new FreshRSS versions [#1436](https://github.com/FreshRSS/FreshRSS/pull/1436)
	* Share with Known [#1420](https://github.com/FreshRSS/FreshRSS/pull/1420)
	* Share with GNU social [#1422](https://github.com/FreshRSS/FreshRSS/issues/1422)
* UI
	* New theme *Origine-compact* [#1388](https://github.com/FreshRSS/FreshRSS/pull/1388)
	* Chrome parity with Firefox: auto-focus tab when clicking on notification [#1409](https://github.com/FreshRSS/FreshRSS/pull/1409)
* CLI
	* New command `./cli/reconfigure.php` to update an existing installation [#1439](https://github.com/FreshRSS/FreshRSS/pull/1439)
	* Many CLI improvements [#1447](https://github.com/FreshRSS/FreshRSS/pull/1447)
		* More information (number of feeds, articles, etc.) in `./cli/user-info.php`
		* Better idempotency of `./cli/do-install.php` and language parameter [#1449](https://github.com/FreshRSS/FreshRSS/issues/1449)
* Bug fixing
	* Fix several CLI issues [#1445](https://github.com/FreshRSS/FreshRSS/issues/1445)
		* Fix CLI install bugs with SQLite [#1443](https://github.com/FreshRSS/FreshRSS/issues/1443), [#1448](https://github.com/FreshRSS/FreshRSS/issues/1448)
		* Allow empty strings in CLI do-install [#1435](https://github.com/FreshRSS/FreshRSS/pull/1435)
	* Fix PostgreSQL bugs with API and feed modifications [#1417](https://github.com/FreshRSS/FreshRSS/pull/1417)
	* Do not mark as read in anonymous mode [#1431](https://github.com/FreshRSS/FreshRSS/issues/1431)
	* Fix Favicons warnings [#59dfc64](https://github.com/FreshRSS/FreshRSS/commit/59dfc64512372eaba7609d84500d943bb7274399), [#1452](https://github.com/FreshRSS/FreshRSS/pull/1452)
* Security
	* Sanitize feed Web site URL [#1434](https://github.com/FreshRSS/FreshRSS/issues/1434)
	* No version number for anonymous users [#1404](https://github.com/FreshRSS/FreshRSS/issues/1404)
* Misc.
	* Relaxed requirements for username to `/^[0-9a-zA-Z]|[0-9a-zA-Z_]{2,38}$/` [#1423](https://github.com/FreshRSS/FreshRSS/pull/1423)


## 2016-12-26 FreshRSS 1.6.2

* Features
	* Add git compatibility in Web update system [#1357](https://github.com/FreshRSS/FreshRSS/issues/1357)
		* Requires that the initial installation is done with git
	* New option `limits.cookie_duration` in `data/config.php` to set the login cookie duration [#1384](https://github.com/FreshRSS/FreshRSS/issues/1384)
* SQL
	* More robust export function in the case of large datasets [#1372](https://github.com/FreshRSS/FreshRSS/issues/1372)
* CLI
	* New command `./cli/user-info.php` to get some user information [#1345](https://github.com/FreshRSS/FreshRSS/issues/1345)
* Bug fixing
	* Fix bug in estimating last user activity [#1358](https://github.com/FreshRSS/FreshRSS/issues/1358)
	* PostgreSQL: fix bug when updating cached values [#1360](https://github.com/FreshRSS/FreshRSS/issues/1360)
	* Fix bug in confirmation before marking as read [#1348](https://github.com/FreshRSS/FreshRSS/issues/1348)
	* Fix small bugs in installer [#1363](https://github.com/FreshRSS/FreshRSS/pull/1363)
	* Allow slash in database hostname, when using sockets [#1364](https://github.com/FreshRSS/FreshRSS/issues/1364)
	* Add curl user-agent to retrieve favicons [#1380](https://github.com/FreshRSS/FreshRSS/issues/1380)
	* Send login cookie only once [#1398](https://github.com/FreshRSS/FreshRSS/pull/1398)
	* Add a check for PHP extension fileinfo [#1375](https://github.com/FreshRSS/FreshRSS/issues/1375)


## 2016-11-02 FreshRSS 1.6.1

* Bug fixing
	* Fix regression introduced in 1.6.0 when refreshing articles with *Mark updated articles as unread* [#1349](https://github.com/FreshRSS/FreshRSS/issues/1349)


## 2016-10-30 FreshRSS 1.6.0

* CLI
	* New Command-Line Interface (CLI) [#1095](https://github.com/FreshRSS/FreshRSS/issues/1095)
		* Install, add/delete users, actualize, import/export. See [CLI documentation](./cli/README.md).
* API
	* Support for editing feeds and categories from client applications [#1254](https://github.com/FreshRSS/FreshRSS/issues/1254)
* Compatibility:
	* Support for PostgreSQL [#416](https://github.com/FreshRSS/FreshRSS/issues/416)
	* New client supporting FreshRSS on Linux: FeedReader 2.0+ [#1252](https://github.com/FreshRSS/FreshRSS/issues/1252)
* Features
	* Rework the “mark as read during scroll” option, enabled by default for new users [#1258](https://github.com/FreshRSS/FreshRSS/issues/1258), [#1309](https://github.com/FreshRSS/FreshRSS/pull/1309)
		* Including a *keep unread* function [#1327](https://github.com/FreshRSS/FreshRSS/pull/1327)
	* In a multi-user context, take better advantage of other users’ refreshes [#1280](https://github.com/FreshRSS/FreshRSS/pull/1280)
	* Better control of number of entries per page or RSS feed [#1249](https://github.com/FreshRSS/FreshRSS/issues/1249)
		* Since X hours: `https://freshrss.example/i/?a=rss&hours=3`
		* Explicit number: `https://freshrss.example/i/?a=rss&nb=10`
		* Limited by `min_posts_per_rss` and `max_posts_per_rss` in user config
	* Support custom ports `localhost:3306` for database servers [#1241](https://github.com/FreshRSS/FreshRSS/issues/1241)
	* Add date to exported files [#1240](https://github.com/FreshRSS/FreshRSS/issues/1240)
	* Auto-refresh favicons once or twice a month [#1181](https://github.com/FreshRSS/FreshRSS/issues/1181), [#1298](https://github.com/FreshRSS/FreshRSS/issues/1298)
		* Cron updates will also refresh favicons every 2 weeks [#1306](https://github.com/FreshRSS/FreshRSS/pull/1306)
* Bug fixing
	* Correction of bugs related to CSRF tokens introduced in version 1.5.0 [#1253](https://github.com/FreshRSS/FreshRSS/issues/1253), [44f22ab](https://github.com/FreshRSS/FreshRSS/pull/1261/commits/d9bf9b2c6f0b2cc9dec3b638841b7e3040dcf46f)
	* Fix bug in Global view introduced in version 1.5.0 [#1269](https://github.com/FreshRSS/FreshRSS/pull/1269)
	* Fix sharing bug [#1289](https://github.com/FreshRSS/FreshRSS/issues/1289)
	* Fix bug in auto-loading more articles after marking an article as un-read [#1318](https://github.com/FreshRSS/FreshRSS/issues/1318)
	* Fix bug during import of favourites [#1315](https://github.com/FreshRSS/FreshRSS/pull/1315), [#1312](https://github.com/FreshRSS/FreshRSS/issues/1312)
	* Fix bug not respecting language option for new users [#1273](https://github.com/FreshRSS/FreshRSS/issues/1273)
	* Bug in example of URL for FreshRSS RSS output with token [#1274](https://github.com/FreshRSS/FreshRSS/issues/1274)
* Security
	* Prevent `<a target="_blank">` attacks with `window.opener` [#1245](https://github.com/FreshRSS/FreshRSS/issues/1245)
	* Updated gitignore rules to keep user directories during a `git clean -f -d` [#1307](https://github.com/FreshRSS/FreshRSS/pull/1307)
* Extensions
	* Allow extensions for default account in anonymous mode [#1288](https://github.com/FreshRSS/FreshRSS/pull/1288)
	* Trigger a `freshrss:load-more` JavaScript event to help extensions [#1278](https://github.com/FreshRSS/FreshRSS/issues/1278)
* SQL
	* Slightly modified several SQL requests (MySQL, SQLite) to simplify support of PostgreSQL [#1195](https://github.com/FreshRSS/FreshRSS/pull/1195)
	* Increase performances by removing a superfluous category request [#1316](https://github.com/FreshRSS/FreshRSS/pull/1316)
* I18n
	* Fix some messages during installation [#1339](https://github.com/FreshRSS/FreshRSS/pull/1339)
* UI
	* Fix CSS line-height bug with `<sup>` in dates (English, Russian, Turkish) [#1340](https://github.com/FreshRSS/FreshRSS/pull/1340)
	* Disable *Mark all as read* before confirmation script is loaded [#1342](https://github.com/FreshRSS/FreshRSS/issues/1342)
	* Download icon 💾 for podcasts [#1236](https://github.com/FreshRSS/FreshRSS/issues/1236)
* SimplePie
	* Fix auto-discovery of RSS feeds in Web pages served as `text/xml` [#1264](https://github.com/FreshRSS/FreshRSS/issues/1264)
* Misc.
	* Removed *resource-priorities* attributes (`defer`, `lazyload`), deprecated by W3C [#1222](https://github.com/FreshRSS/FreshRSS/pull/1222)


## 2016-08-29 FreshRSS 1.5.0

* Compatibility
	* Require at least MySQL 5.5.3+ [#1153](https://github.com/FreshRSS/FreshRSS/issues/1153)
	* Require at least PHP 5.3.3+ [#1183](https://github.com/FreshRSS/FreshRSS/pull/1183)
		* Restore compatibility with PHP 5.3.3 [#1208](https://github.com/FreshRSS/FreshRSS/issues/1208)
	* Restore compatibility with Microsoft Internet Explorer 11 / Edge [#772](https://github.com/FreshRSS/FreshRSS/issues/772)
* Features
	* Mark a search as read [#608](https://github.com/FreshRSS/FreshRSS/issues/608)
	* Support for full Unicode such as emoji 💕 in MySQL with utf8mb4 [#1153](https://github.com/FreshRSS/FreshRSS/issues/1153)
		* FreshRSS will automatically migrate MySQL tables to utf8mb4 the first time it is needed.
* Security
	* Remove Mozilla Persona login (the service closes on 2016-11-30) [#1052](https://github.com/FreshRSS/FreshRSS/issues/1052)
	* Use Referrer Policy `<meta name="referrer" content="never" />` for anonymizing HTTP Referer [#955](https://github.com/FreshRSS/FreshRSS/issues/955)
	* Implement CSRF tokens for POST security [#570](https://github.com/FreshRSS/FreshRSS/issues/570)
* Bug fixing
	* Fixed scroll in log view [#1178](https://github.com/FreshRSS/FreshRSS/issues/1178)
	* Fixed JavaScript bug when articles were not always marked as read [#1123](https://github.com/FreshRSS/FreshRSS/issues/1123)
	* Fixed Apache Etag issue that prevented caching [#1199](https://github.com/FreshRSS/FreshRSS/pull/1199)
	* Fixed OPML import of categories [#1202](https://github.com/FreshRSS/FreshRSS/issues/1202)
	* Fixed PubSubHubbub callback address bug on some configurations [1229](https://github.com/FreshRSS/FreshRSS/pull/1229)
* UI
	* Use sticky category column [#1172](https://github.com/FreshRSS/FreshRSS/pull/1172)
	* Updated to jQuery 3.1.0 and several JavaScript fixes (e.g. drag & drop) [#1197](https://github.com/FreshRSS/FreshRSS/pull/1197)
* API
	* Add API link in FreshRSS profile settings to ease set-up [#1186](https://github.com/FreshRSS/FreshRSS/pull/1186)
* Misc.
	* Work-around for SuperFeeder time-outs during PubSubHubbub registration [#1184](https://github.com/FreshRSS/FreshRSS/pull/1184)
	* JSHint of JavaScript code and better initialisation [#1196](https://github.com/FreshRSS/FreshRSS/pull/1196)
	* Updated credits, and images in README [#1201](https://github.com/FreshRSS/FreshRSS/issues/1201)


## 2016-07-23 FreshRSS 1.4.0

## 2016-06-12 FreshRSS 1.3.2-beta

* Compatibility
	* Require at least PHP 5.3+ (drop PHP 5.2) [#1133](https://github.com/FreshRSS/FreshRSS/pull/1133)
* Features
	* Support for MySQL 5.7+ (e.g. Ubuntu 16.04 LTS) [#1132](https://github.com/FreshRSS/FreshRSS/pull/1132)
	* Speed optimization for HTTP/2 [#1133](https://github.com/FreshRSS/FreshRSS/pull/1133)
	* API support for REDIRECT_* HTTP headers (fcgi) [#1128](https://github.com/FreshRSS/FreshRSS/issues/1128)
* SimplePie
	* Support for feeds with invalid whitespace [#1142](https://github.com/FreshRSS/FreshRSS/issues/1142)
* Bug fixing
	* Fix bug when adding feeds with passwords [#1137](https://github.com/FreshRSS/FreshRSS/pull/1137)
	* Fix validator link [#1147](https://github.com/FreshRSS/FreshRSS/pull/1147)
	* Fix Favicon small bugs [#1135](https://github.com/FreshRSS/FreshRSS/pull/1135)
* Security
	* CSP compatibility for homepage [#1120](https://github.com/FreshRSS/FreshRSS/pull/1120)
* I18n
	* Draft of Russian [#1085](https://github.com/FreshRSS/FreshRSS/pull/1085)
* Misc.
	* Change default feed timeout to 15 seconds [#1146](https://github.com/FreshRSS/FreshRSS/pull/1146)
	* Updated Wallabag v2 [#1150](https://github.com/FreshRSS/FreshRSS/pull/1150)


## 2016-03-11 FreshRSS 1.3.1-beta

* Security
	* Added CSP `Content-Security-Policy: default-src 'self'; child-src *; frame-src *; img-src * data:; media-src *` [#1075](https://github.com/FreshRSS/FreshRSS/issues/1075), [#1114](https://github.com/FreshRSS/FreshRSS/issues/1114)
	* Added `X-Content-Type-Options: nosniff` [#1116](https://github.com/FreshRSS/FreshRSS/pull/1116)
	* Cookie with `Secure` tag when used over HTTPS [#1117](https://github.com/FreshRSS/FreshRSS/pull/1117)
	* Limit API post input to 1MB [#1118](https://github.com/FreshRSS/FreshRSS/pull/1118)
* Features
	* New list of domains for which to force HTTPS (for images, videos, iframes…) defined in `./data/force-https.default.txt` and `./data/force-https.txt` [#1083](https://github.com/FreshRSS/FreshRSS/issues/1083)
		* In particular useful for privacy and to avoid mixed content errors, e.g. to see YouTube videos when FreshRSS is in HTTPS
	* Add sharing with “Journal du Hacker” [#1056](https://github.com/FreshRSS/FreshRSS/pull/1056)
* UI
	* Updated to jQuery 2.2.1 and changed code for auto-load on scroll [#1050](https://github.com/FreshRSS/FreshRSS/pull/1050), [#1091](https://github.com/FreshRSS/FreshRSS/pull/1091)
* I18n
	* Turkish [#1073](https://github.com/FreshRSS/FreshRSS/issues/1073)
* Bug fixing
	* Fixed OPML import title bug [#1048](https://github.com/FreshRSS/FreshRSS/issues/1048)
	* Fixed upgrade bug with SQLite when articles were marked as unread [#1049](https://github.com/FreshRSS/FreshRSS/issues/1049)
	* Fixed error when deleting feeds from statistics page [#1047](https://github.com/FreshRSS/FreshRSS/issues/1047)
	* Fixed several small bugs in global and reader view [#1050](https://github.com/FreshRSS/FreshRSS/pull/1050)
	* Fixed sharing bug with PHP7 [#1072](https://github.com/FreshRSS/FreshRSS/issues/1072)
	* Fixed fall-back when php-json is not installed [#1092](https://github.com/FreshRSS/FreshRSS/issues/1092)
* API
	* Possibility to show only read items [#1035](https://github.com/FreshRSS/FreshRSS/pull/1035)
* Misc.
	* Filters `<img />` attributes `srcset` and `sizes` [#1077](https://github.com/FreshRSS/FreshRSS/issues/1077), [#1086](https://github.com/FreshRSS/FreshRSS/pull/1086)
	* Implement PubSubHubbub unsubscribe responses [#1058](https://github.com/FreshRSS/FreshRSS/issues/1058)
	* Restored some compatibility with PHP 5.2 [#1055](https://github.com/FreshRSS/FreshRSS/issues/1055)
	* Check for extension php-xml during install [#1094](https://github.com/FreshRSS/FreshRSS/issues/1094)
	* Updated the sharing with Movim [#1030](https://github.com/FreshRSS/FreshRSS/pull/1030)


## 2015-11-03 FreshRSS 1.2.0 / 1.3.0-beta

* Features
	* Share with Movim [#992](https://github.com/FreshRSS/FreshRSS/issues/992)
	* New option to allow robots / search engines [#938](https://github.com/FreshRSS/FreshRSS/issues/938)
* Security
	* Invalid logins now return HTTP 403, to be easier to catch (e.g. fail2ban) [#1015](https://github.com/FreshRSS/FreshRSS/issues/1015)
* UI
	* Remove "title" field during installation [#858](https://github.com/FreshRSS/FreshRSS/issues/858)
	* Visual alert on categories containing feeds in error [#984](https://github.com/FreshRSS/FreshRSS/pull/984)
* I18n
	* Italian [#1003](https://github.com/FreshRSS/FreshRSS/issues/1003)
* Misc.
	* Support reverse proxy [#975](https://github.com/FreshRSS/FreshRSS/issues/975)
	* Make auto-update server URL alterable [#1019](https://github.com/FreshRSS/FreshRSS/issues/1019)


## 2015-09-12 FreshRSS 1.1.3-beta

* UI
	* Configuration page for global settings such as limits [#958](https://github.com/FreshRSS/FreshRSS/pull/958)
	* Add feed ID in articles to ease styling [#953](https://github.com/FreshRSS/FreshRSS/issues/953)
* I18n
	* Dutch [#949](https://github.com/FreshRSS/FreshRSS/issues/949)
* Bug fixing
	* Session cookie bug [#924](https://github.com/FreshRSS/FreshRSS/issues/924)
	* Better error handling for PubSubHubbub [#939](https://github.com/FreshRSS/FreshRSS/issues/939)
	* Fix tag search link from articles [#970](https://github.com/FreshRSS/FreshRSS/issues/970)
	* Fix all queries deleted when deleting a feed or category [#982](https://github.com/FreshRSS/FreshRSS/pull/982)


## 2015-07-30 FreshRSS 1.1.2-beta

* Features
	* Support for PubSubHubbub for instant notifications from compatible Web sites. [#312](https://github.com/FreshRSS/FreshRSS/issues/312)
	* cURL options to use a proxy for retrieving feeds. [#897](https://github.com/FreshRSS/FreshRSS/issues/897) [#675](https://github.com/FreshRSS/FreshRSS/issues/675)
	* Allow anonymous users to create an account. [#679](https://github.com/FreshRSS/FreshRSS/issues/679)
* Security
	* cURL options to verify or not SSL/TLS certificates (now enabled by default). [#897](https://github.com/FreshRSS/FreshRSS/issues/897) [#502](https://github.com/FreshRSS/FreshRSS/issues/502)
	* Support for SSL connection to MySQL. [#868](https://github.com/FreshRSS/FreshRSS/issues/868)
	* Workaround for browsers that have disabled support for `<form autocomplete="off">`. [#880](https://github.com/FreshRSS/FreshRSS/issues/880)
* UI
	* Force UTF-8 for responses. [#870](https://github.com/FreshRSS/FreshRSS/issues/870)
	* Increased pagination limit to 500 articles. [#872](https://github.com/FreshRSS/FreshRSS/issues/872)
	* Improved UI for installation. [#855](https://github.com/FreshRSS/FreshRSS/issues/855)
* Misc.
	* PHP 7 officially supported (~70% speed improvements on early tests). [#889](https://github.com/FreshRSS/FreshRSS/issues/889)
	* Restore support for PHP 5.2.1+. [#214a5cc](https://github.com/Alkarex/FreshRSS/commit/214a5cc9a4c2b821961bc21f22b4b08e34b5be68) [#894](https://github.com/FreshRSS/FreshRSS/issues/894)
	* Support for data-src for images of articles retrieved via the full-content module. [#877](https://github.com/FreshRSS/FreshRSS/issues/877)
	* Add a couple of default feeds for fresh installations. [#886](https://github.com/FreshRSS/FreshRSS/issues/886)
	* Changed some log visibilities. [#885](https://github.com/FreshRSS/FreshRSS/issues/885)
	* Fix broken links for extension script / style files. [#862](https://github.com/FreshRSS/FreshRSS/issues/862)
	* Load default configuration during installation to avoid hard-coded values. [#890](https://github.com/FreshRSS/FreshRSS/issues/890)
	* Fix non-consistent behaviour in Minz_Request::getBaseUrl() and introduce Minz_Request::guessBaseUrl(). [#906](https://github.com/FreshRSS/FreshRSS/issues/906)
	* Generate `base_url` during the installation and add a `pubsubhubbub_enabled` configuration key. [#865](https://github.com/FreshRSS/FreshRSS/issues/865)
	* Load configuration by recursion to overwrite array values. [#923](https://github.com/FreshRSS/FreshRSS/issues/923)
	* Cast `$limits` configuration values in integer. [#925](https://github.com/FreshRSS/FreshRSS/issues/925)
	* Don’t hide errors in configuration. [#920](https://github.com/FreshRSS/FreshRSS/issues/920)


## 2015-05-31 FreshRSS 1.1.1 (beta)

* Features
	* New option to detect and mark updated articles as unread.
	* Support for internationalized domain name (IDN).
	* Improved logic for automatic deletion of old articles.
* API
	* Work-around for News+ bug when there is no unread article on the server.
* UI
	* New confirmation message when leaving a configuration page without saving the changes.
* Bug fixing
	* Corrected bug introduced in previous beta about handling of HTTP 301 (feeds that have changed address)
	* Corrected bug in FreshRSS RSS feeds.
* Security
	* Sanitize HTTP request header `Host`.
* Misc.
	* Attempt to better handle encoded article titles.


## 2015-01-31 FreshRSS 1.0.0 / 1.1.0 (beta)

* UI
	* Slider math with Dark theme
	* Add a message if request failed for mark as read / favourite
* I18n
	* Fix some sentences
	* Add German as a supported language
	* Add some indications on password format
* Bug fixing
	* Some shortcuts was never saved
	* Global view didn’t work if set by default
	* Minz_Error was badly raised
	* Feed update failed if nothing had changed (MySQL only)
	* CRON task failed with multiple users
	* Tricky bug caused by cookie path
	* Email sharing was badly supported (no urlencode())
* Misc.
	* Add a CREDIT file with contributor names
	* Update lib_opml
	* Default favicon is now served by HTTP code 200
	* Change calls to syslog by Minz_Log::notice
	* HTTP credentials are no longer logged


## 2015-01-15 FreshRSS 0.9.4 (beta)

* Feature
	* Extension system (!!): some extensions are available at [github.com/FreshRSS/Extensions](https://github.com/FreshRSS/Extensions)
* Refactoring
	* Front controller (FreshRSS class)
	* Configuration system
	* Sharing system
	* New data files organization
* Updates
	* Remove restriction of 1h for updates
	* Show the current version of FreshRSS and the next one
* UI
	* Remove the "sticky position" of the feed aside (moved into an extension)
	* "Show password" shows the password only while the user is pressing the mouse.


## 2014-12-12 FreshRSS 0.9.3 (beta)

* SimplePie
	* Support for content-type application/x-rss+xml
	* New force_feed option (for feeds sent with the wrong content-type / MIME) by adding #force_feed at the end of the feed URL
	* Improved error messages
* Statistics
	* Add information on feed repartition pages
	* Add percent repartition for the bigger feeds
* UI
	* New theme selector
	* Update Screwdriver theme
	* Add BlueLagoon theme by Mister aiR
* Misc.
	* Add option to remove articles after reading them
	* Add comments
	* Refactor i18n system to avoid loading unnecessary strings
	* Fix security issue in Minz_Error::error() method
	* Fix redirection after refreshing a given feed


## 2014-10-31 FreshRSS 0.9.2 (beta)

* UI
	* New subscription page (introduce .box items)
	* Change feed category by drag and drop
	* New feed aside on the main page
	* New configuration / administration organization
* Configuration
	* New options in config.php for cache duration, timeout, max inactivity, max number of feeds and categories per user.
* Refactoring
	* Refactor authentication system (introduce FreshRSS_Auth model)
	* Refactor indexController (introduce FreshRSS_Context model)
	* Use ```_t()```, ```_i()```, ```_url()```, ```Minz_Request::good()``` and ```Minz_Request::bad()``` as much as possible
	* Refactor javascript_vars.phtml
	* Better coding style
* I18n
	* Introduce a new system for i18n keys (not finished yet)
* Misc.
	* Fix global view (did not work anymore)
	* Add do_post_update for update system
	* Introduce ```checkInstallAction``` to test if FreshRSS installation is ok


## 2014-10-09 FreshRSS 0.8.1 / 0.9.1 (beta)

* UI
	* Add a space after tag icon
* Statistics
	* Add an average per day on the 30-day period graph
	* Add percent of total on top 10 feed
* Bug fixes
	* Fix "mark as read" in global view
	* Fix "read all" shortcut
	* Fix categories not appearing when adding a new feed (GET action)
	* Fix enclosure problem
	* Fix getExtension() on PHP < 5.3.7


## 2014-09-26 FreshRSS 0.8.0 / 0.9.0 (beta)

* UI
	* New interface for statistics
	* Fix filter buttons
	* Number of articles divided by 2 in reading view
	* Redesign of bigMarkAsRead
* Features
	* New automatic update system
	* New reset auth system
* Security
	* "Mark as read" requires POST requests for several articles
	* Test HTTP REFERER in install.php
* Configuration
	* New "Show all articles" / "Show only unread" / "Adjust viewing" option
	* New notification timeout option
* Misc.
	* Improve coding style + comments
	* Fix SQLite bug "ON DELETE CASCADE"
	* Improve performance when importing articles


## 2014-08-24 FreshRSS 0.7.4

* UI
	* Hide categories/feeds with unread articles when showing only unread articles
	* Dynamic favicon showing the number of unread articles
	* New theme: Screwdriver by Mister aiR
* Statistics
	* New page with article repartition
	* Improvements
* Security
	* Basic protection against XSRF (Cross-Site Request Forgery) based on HTTP Referer (POST requests only)
* API
	* Compatible with lighttpd
* Misc.
	* Changed lazyload implementation
	* Support of HTML5 notifications for new upcoming articles
	* Add option to stay logged in
* Bug fixes in export function, add/remove users, keyboard shortcuts, etc.


## 2014-07-21 FreshRSS 0.7.3

* New options
	* Add system of user queries which are shortcuts to filter the view
	* New TTL option to limit the frequency at which feeds are refreshed (by cron or manual refresh button).
		It is still possible to manually refresh an individual feed at a higher frequency.
* SQL
	* Add support for SQLite (beta) in addition to MySQL
* SimplePie
	* Complies with HTTP "301 Moved Permanently" responses by automatically updating the URL of feeds that have changed address.
* Themes
	* Flat and Dark designs are based on same template file as Origine
* Statistics
	* Refactor code
	* Add an idle feed page
* Misc
	* Several bug fixes
	* Add confirmation option when marking all articles as read
	* Fix some typo


## 2014-06-13 FreshRSS 0.7.2

* API compatible with Google Reader API level 2
	* FreshRSS can now be used from e.g.:
		* (Android) [News+](https://github.com/noinnion/newsplus/tree/master/extensions/GoogleReaderCloneExtension)
		* (Android) [EasyRSS](https://github.com/Alkarex/EasyRSS)
* Basic support for audio and video podcasts
* Searching
	* New search filters date: and pubdate: accepting ISO 8601 date intervals such as `date:2013-2014` or `pubdate:P1W`
	* Possibility to combine search filters, e.g. `date:2014-05 intitle:FreshRSS intitle:Open great reader #Internet`
* Change nav menu with more buttons instead of dropdown menus and add some filters
* New system of import / export
	* Support OPML, Json (like Google Reader) and ZIP archives
	* Can export and import articles (specific option for favourites)
* Refactor "Origine" theme
	* Some improvements
	* Based on a template file (other themes will use it too)


## Older

[See older changes (in French)](./CHANGELOG-old.md)
