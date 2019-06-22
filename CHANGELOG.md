# FreshRSS changelog

## 2019-0X-XX FreshRSS 1.14.3-dev

* Security
	* Allow `@-` as valid characters in usernames (i.e. allow most e-mails) [#2391](https://github.com/FreshRSS/FreshRSS/issues/2391)
* UI
	* New configuration page for each category [#2369](https://github.com/FreshRSS/FreshRSS/issues/2369)
	* Update shortcut configuration page [#2405](https://github.com/FreshRSS/FreshRSS/issues/2405)
	* CSS style for printing [#2149](https://github.com/FreshRSS/FreshRSS/issues/2149)
	* Fix refresh icon in Swage theme [#2375](https://github.com/FreshRSS/FreshRSS/issues/2375)
	* Fix message banner in Swage theme [#2379](https://github.com/FreshRSS/FreshRSS/issues/2379)
	* Updated to jQuery 3.4.1 [#2424](https://github.com/FreshRSS/FreshRSS/pull/2424)
* Bug fixing
	* Fix API call for removing a category [#2411](https://github.com/FreshRSS/FreshRSS/issues/2411)
* Deployment
	* Docker: Ubuntu image updated to 19.04 with PHP 7.2.19 and Apache 2.4.38 [#2422](https://github.com/FreshRSS/FreshRSS/pull/2422)
	* Docker: Alpine image updated to 3.10 with PHP 7.3.6 and Apache 2.4.39 [#2238](https://github.com/FreshRSS/FreshRSS/pull/2238)
* I18n
	* Improve Occitan [#2358](https://github.com/FreshRSS/FreshRSS/pull/2358)
* Misc.
	* New parameter `?maxFeeds=10` to control the max number of feeds to refresh manually [#2388](https://github.com/FreshRSS/FreshRSS/pull/2388)


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
	* Fix manual / Web actualize for which the final commit coud be done too early [#2081](https://github.com/FreshRSS/FreshRSS/pull/2081)
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
		* iOS: [Fiery Feeds](https://itunes.apple.com/app/fiery-feeds-rss-reader/id1158763303), [Unread](https://itunes.apple.com/app/unread-rss-reader/id1252376153)
		* MacOS: [Readkit](https://itunes.apple.com/app/readkit/id588726889)
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
	* Remove some warnings during parsing attemps of some bad feeds [#1909](https://github.com/FreshRSS/FreshRSS/pull/1909)
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
	* Added Spanish language [#1631] (https://github.com/FreshRSS/FreshRSS/pull/1631/) 
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
	* Share with Ⓚnown [#1420](https://github.com/FreshRSS/FreshRSS/pull/1420)
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
	* Don't hide errors in configuration. [#920](https://github.com/FreshRSS/FreshRSS/issues/920)


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
	* Global view didn't work if set by default
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
	* Extension system (!!): some extensions are available at https://github.com/FreshRSS/Extensions
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
		* (Android) News+ https://play.google.com/store/apps/details?id=com.noinnion.android.newsplus.extension.google_reader
		* (Android) EasyRSS https://github.com/Alkarex/EasyRSS
* Basic support for audio and video podcasts
* Searching
	* New search filters date: and pubdate: accepting ISO 8601 date intervals such as `date:2013-2014` or `pubdate:P1W`
	* Possibility to combine search filters, e.g. `date:2014-05 intitle:FreshRSS intitle:Open great reader #Internet`
* Change nav menu with more buttons instead of dropdown menus and add some filters
* New system of import / export
	* Support OPML, Json (like Google Reader) and ZIP archives
	* Can export and import articles (specific option for favorites)
* Refactor "Origine" theme
	* Some improvements
	* Based on a template file (other themes will use it too)


## 2014-02-19 FreshRSS 0.7.1

* Mise à jour des flux plus rapide grâce à une meilleure utilisation du cache
	* Utilisation d’une signature MD5 du contenu intéressant pour les flux n’implémentant pas les requêtes conditionnelles
* Modification des raccourcis
	* "s" partage directement si un seul moyen de partage
	* Moyens de partage accessibles par "1", "2", "3", etc.
	* Premier article : Home ; Dernier article : End
	* Ajout du déplacement au sein des catégories / flux (via modificateurs shift et alt)
* UI
	* Séparation des descriptions des raccourcis par groupes
	* Revue rapide de la page de connexion
	* Amélioration de l'affichage des notifications sur mobile
* Revue du système de rafraîchissement des flux
	* Meilleure gestion de la file de flux à rafraîchir en JSON
	* Rafraîchissement uniquement pour les flux non rafraîchis récemment
	* Possibilité donnée aux anonymes de rafraîchir les flux
* SimplePie
	* Mise à jour de la lib
	* Corrige fuite de mémoire
	* Meilleure tolérance aux flux invalides
* Corrections divers
	* Ne déplie plus l'article lors du clic sur l'icône lien externe
	* Ne boucle plus à la fin de la navigation dans les articles
	* Suppression du champ category.color inutile
	* Corrige bug redirection infinie (Persona)
	* Amélioration vérification de la requête POST
	* Ajout d'un verrou lorsqu'une action mark_read ou mark_favorite est en cours


## 2014-01-29 FreshRSS 0.7

* Nouveau mode multi-utilisateur
	* L’utilisateur par défaut (administrateur) peut créer et supprimer d’autres utilisateurs
	* Nécessite un contrôle d’accès, soit :
		* par le nouveau mode de connexion par formulaire (nom d’utilisateur + mot de passe)
			* relativement sûr même sans HTTPS (le mot de passe n’est pas transmis en clair)
			* requiert JavaScript et PHP 5.3+
		* par HTTP (par exemple sous Apache en créant un fichier ./p/i/.htaccess et .htpasswd)
			* le nom d’utilisateur HTTP doit correspondre au nom d’utilisateur FreshRSS
		* par Mozilla Persona, en renseignant l’adresse courriel des utilisateurs
* Installateur supportant les mises à jour :
	* Depuis une v0.6, placer application.ini et Configuration.array.php dans le nouveau répertoire “./data/”
		(voir réorganisation ci-dessous)
	* Pour les versions suivantes, juste garder le répertoire “./data/”
* Rafraîchissement automatique du nombre d’articles non lus toutes les deux minutes (utilise le cache HTTP à bon escient)
	* Permet aussi de conserver la session valide, surtout dans le cas de Persona
* Nouvelle page de statistiques (nombres d’articles par jour / catégorie)
* Importation OPML instantanée et plus tolérante
* Nouvelle gestion des favicons avec téléchargement en parallèle
* Nouvelles options
	* Réorganisation des options
	* Gestion des utilisateurs
	* Améliorations partage vers Shaarli, Poche, Diaspora*, Facebook, Twitter, Google+, courriel
		* Raccourci ‘s’ par défaut
	* Permet la suppression de tous les articles d’un flux
	* Option pour marquer les articles comme lus dès la réception
	* Permet de configurer plus finement le nombre d’articles minimum à conserver par flux
	* Permet de modifier la description et l’adresse d’un flux RSS ainsi que le site Web associé
	* Nouveau raccourci pour ouvrir/fermer un article (‘c’ par défaut)
	* Boutons pour effacer les logs et pour purger les vieux articles
	* Nouveaux filtres d’affichage : seulement les articles favoris, et seulement les articles lus
* SQL :
	* Nouveau moteur de recherche, aussi accessible depuis la vue mobile
		* Mots clefs de recherche “intitle:”, “inurl:”, “author:”
	* Les articles sont triés selon la date de leur ajout dans FreshRSS plutôt que la date déclarée (souvent erronée)
		* Permet de marquer tout comme lu sans affecter les nouveaux articles arrivés en cours de lecture
		* Permet une pagination efficace
	* Refactorisation
		* Les tables sont préfixées avec le nom d’utilisateur afin de permettre le mode multi-utilisateurs
		* Amélioration des performances
		* Tolère un beaucoup plus grand nombre d’articles
		* Compression des données côté MySQL plutôt que côté PHP
		* Incompatible avec la version 0.6 (nécessite une mise à jour grâce à l’installateur)
	* Affichage de la taille de la base de données dans FreshRSS
	* Correction problème de marquage de tous les favoris comme lus
* HTML5 :
	* Support des balises HTML5 audio, video, et éléments associés
		* Utilisation de preload="none", et réécriture correcte des adresses, aussi en HTTPS
	* Protection HTML5 des iframe (sandbox="allow-scripts allow-same-origin")
	* Filtrage des object et embed
	* Chargement différé HTML5 (postpone="") pour iframe et video
	* Chargement différé JavaScript pour iframe
* CSS :
	* Nouveau thème sombre
		* Chargement plus robuste des thèmes
	* Meilleur support des longs titres d’articles sur des écrans étroits
	* Meilleure accessibilité
		* FreshRSS fonctionne aussi en mode dégradé sans images (alternatives Unicode) et/ou sans CSS
	* Diverses améliorations
* PHP :
	* Encore plus tolérant pour les flux comportant des erreurs
	* Mise à jour automatique de l’URL du flux (en base de données) lorsque SimplePie découvre qu’elle a changé
	* Meilleure gestion des caractères spéciaux dans différents cas
	* Compatibilité PHP 5.5+ avec OPcache
	* Amélioration des performances
	* Chargement automatique des classes
	* Alternative dans le cas d’absence de librairie JSON
	* Pour le développement, le cache HTTP peut être désactivé en créant un fichier “./data/no-cache.txt”
* Réorganisation des fichiers et répertoires, en particulier :
	* Tous les fichiers utilisateur sont dans “./data/” (y compris “cache”, “favicons”, et “log”)
	* Déplacement de “./app/configuration/application.ini” vers “./data/config.php”
		* Meilleure sécurité et compatibilité
	* Déplacement de “./public/data/Configuration.array.php” vers “./data/*_user.php”
	* Déplacement de “./public/” vers “./p/”
		* Déplacement de “./public/index.php” vers “./p/i/index.php” (voir cookie ci-dessous)
	* Déplacement de “./actualize_script.php” vers “./app/actualize_script.php” (pour une meilleure sécurité)
		* Pensez à mettre à jour votre Cron !
* Divers :
	* Nouvelle politique de cookie de session (témoin de connexion)
		* Utilise un nom poli “FreshRSS” (évite des problèmes avec certains filtres)
		* Se limite au répertoire “./FreshRSS/p/i/” pour de meilleures performances HTTP
			* Les images, CSS, scripts sont servis sans cookie
		* Utilise “HttpOnly” pour plus de sécurité
	* Nouvel “agent utilisateur” exposé lors du téléchargement des flux, par exemple :
		* “FreshRSS/0.7 (Linux; http://freshrss.org) SimplePie/1.3.1”
	* Script d’actualisation avec plus de messages
		* Sur la sortie standard, ainsi que dans le log système (syslog)
	* Affichage du numéro de version dans "À propos"


## 2013-11-21 FreshRSS 0.6.1

* Corrige bug chargement du JavaScript
* Affiche un message d’erreur plus explicite si fichier de configuration inaccessible


## 2013-11-17 FreshRSS 0.6

* Nettoyage du code JavaScript + optimisations
* Utilisation d’adresses relatives
* Amélioration des performances coté client
* Mise à jour automatique du nombre d’articles non lus
* Corrections traductions
* Mise en cache de FreshRSS
* Amélioration des retours utilisateur lorsque la configuration n’est pas bonne
* Actualisation des flux après une importation OPML
* Meilleure prise en charge des flux RSS invalides
* Amélioration de la vue globale
* Possibilité de personnaliser les icônes de lecture
* Suppression de champs lors de l’installation (base_url et sel)
* Correction de bugs divers


## 2013-10-15 FreshRSS 0.5.1

* Correction du bug des catégories disparues
* Correction traduction i18n/fr et i18n/en
* Suppression de certains appels à la feuille de style fallback.css


## 2013-10-12 FreshRSS 0.5.0

* Possibilité d’interdire la lecture anonyme
* Option pour garder l’historique d’un flux
* Lors d’un clic sur “Marquer tous les articles comme lus”, FreshRSS peut désormais sauter à la prochaine catégorie / prochain flux avec des articles non lus.
* Ajout d’un token pour accéder aux flux RSS générés par FreshRSS sans nécessiter de connexion
* Possibilité de partager vers Facebook, Twitter et Google+
* Possibilité de changer de thème
* Le menu de navigation (article précédent / suivant / haut de page) a été ajouté à la vue non mobile
* La police OpenSans est désormais appliquée
* Amélioration de la page de configuration
* Une meilleure sortie pour l’imprimante
* Quelques retouches du design par défaut
* Les vidéos ne dépassent plus du cadre de l’écran
* Nouveau logo
* Possibilité d’ajouter un préfixe aux tables lors de l’installation
* Ajout d’un champ en base de données keep_history à la table feed
* Si possible, création automatique de la base de données si elle n’existe pas lors de l’installation
* L’utilisation d’UTF-8 est forcée
* Le marquage automatique au défilement de la page a été amélioré
* La vue globale a été énormément améliorée et est beaucoup plus utile
* Amélioration des requêtes SQL
* Amélioration du JavaScript
* Correction bugs divers


## 2013-07-02 FreshRSS 0.4.0

* Correction bug et ajout notification lors de la phase d’installation
* Affichage d’erreur si fichier OPML invalide
* Les tags sont maintenant cliquables pour filtrer dessus
* Amélioration vue mobile (boutons plus gros et ajout d’une barre de navigation)
* Possibilité d’ajouter directement un flux dans une catégorie dès son ajout
* Affichage des flux en erreur (injoignable par exemple) en rouge pour les différencier
* Possibilité de changer les noms des flux
* Ajout d’une option (désactivable donc) pour charger les images en lazyload permettant de ne pas charger toutes les images d’un coup
* Le framework Minz est maintenant directement inclus dans l’archive (plus besoin de passer par ./build.sh)
* Amélioration des performances pour la récupération des flux tronqués
* Possibilité d’importer des flux sans catégorie lors de l’import OPML
* Suppression de “l’API” (qui était de toute façon très basique) et de la fonctionnalité de “notes”
* Amélioration de la recherche (garde en mémoire si l’on a sélectionné une catégorie) par exemple
* Modification apparence des balises hr et pre
* Meilleure vérification des champs de formulaire
* Remise en place du mode “endless” (permettant de simplement charger les articles qui suivent plutôt que de charger une nouvelle page)
* Ajout d’une page de visualisation des logs
* Ajout d’une option pour optimiser la BDD (diminue sa taille)
* Ajout des vues lecture et globale (assez basique)
* Les vidéos YouTube ne débordent plus du cadre sur les petits écrans
* Ajout d’une option pour marquer les articles comme lus lors du défilement (et suppression de celle au chargement de la page)


## 2013-05-05 FreshRSS 0.3.0

* Fallback pour les icônes SVG (utilisation de PNG à la place)
* Fallback pour les propriétés CSS3 (utilisation de préfixes)
* Affichage des tags associés aux articles
* Internationalisation de l’application (gestion des langues anglaise et française)
* Gestion des flux protégés par authentification HTTP
* Mise en cache des favicons
* Création d’un logo *temporaire*
* Affichage des vidéos dans les articles
* Gestion de la recherche et filtre par tags pleinement fonctionnels
* Création d’un vrai script CRON permettant de mettre tous les flux à jour
* Correction bugs divers


## 2013-04-17 FreshRSS 0.2.0

* Création d’un installateur
* Actualisation des flux en Ajax
* Partage par mail et Shaarli ajouté
* Export par flux RSS
* Possibilité de vider une catégorie
* Possibilité de sélectionner les catégories en vue mobile
* Les flux peuvent être sortis du flux principal (système de priorité)
* Amélioration ajout / import / export des flux
* Amélioration actualisation (meilleure gestion des erreurs)
* Améliorations du CSS
* Changements dans la base de données
* MàJ de la librairie SimplePie
* Flux sans auteurs gérés normalement
* Correction bugs divers


## 2013-04-08 FreshRSS 0.1.0

* “Première” version
