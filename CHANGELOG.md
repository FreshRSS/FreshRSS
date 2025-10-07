# FreshRSS changelog

See also [the FreshRSS releases](https://github.com/FreshRSS/FreshRSS/releases).

## 2025-1X-XX FreshRSS 1.27.2-dev


## 2025-09-27 FreshRSS 1.27.1

* Features
	* Automatic database recovery: skip broken entries during CLI export/import [#7949](https://github.com/FreshRSS/FreshRSS/pull/7949)
	* Add security option for CSP `frame-ancestors` [#7857](https://github.com/FreshRSS/FreshRSS/pull/7857), [#8021](https://github.com/FreshRSS/FreshRSS/pull/8021)
	* Lazy-load `<track src>` [#7997](https://github.com/FreshRSS/FreshRSS/pull/7997)
* Security
	* Regenerate session ID on login [#7829](https://github.com/FreshRSS/FreshRSS/pull/7829)
	* Disallow setting non-existent language [#7878](https://github.com/FreshRSS/FreshRSS/pull/7878), [#7934](https://github.com/FreshRSS/FreshRSS/pull/7934)
	* Safer calling of `install.php` [#7971](https://github.com/FreshRSS/FreshRSS/pull/7971)
	* Prevent log CR/LF injection [#7883](https://github.com/FreshRSS/FreshRSS/pull/7883)
	* Restrict allowed cURL parameters [#7979](https://github.com/FreshRSS/FreshRSS/pull/7979), [#8009](https://github.com/FreshRSS/FreshRSS/pull/8009)
	* Fix reauthentication while updating [#7989](https://github.com/FreshRSS/FreshRSS/pull/7989)
	* Fix some CSRFs [#8000](https://github.com/FreshRSS/FreshRSS/pull/8000)
* Bug fixing
	* Include port number for HTTP `Retry-After` [#7875](https://github.com/FreshRSS/FreshRSS/pull/7875)
	* Fix logic for searching labels [#7863](https://github.com/FreshRSS/FreshRSS/pull/7863)
	* Fix cURL response parsing for HTTP redirections [#7866](https://github.com/FreshRSS/FreshRSS/pull/7866)
	* Fix fetching OPML URL with special characters [#7843](https://github.com/FreshRSS/FreshRSS/pull/7843)
	* Fix validation when creating a new user label [#7890](https://github.com/FreshRSS/FreshRSS/pull/7890)
	* Fix bug in user self-deletion [#7877](https://github.com/FreshRSS/FreshRSS/pull/7877)
	* Fix displaying of current date in main statistics [#7892](https://github.com/FreshRSS/FreshRSS/pull/7892)
	* Fix default values on stat processing [#7891](https://github.com/FreshRSS/FreshRSS/pull/7891)
	* Fix UI JavaScript error when navigating to last article with keyboard [#7957](https://github.com/FreshRSS/FreshRSS/pull/7957)
	* Fix some links in anonymous mode [#8011](https://github.com/FreshRSS/FreshRSS/pull/8011), [#8012](https://github.com/FreshRSS/FreshRSS/pull/8012)
	* Fixes for `no-cache.txt` [#7907](https://github.com/FreshRSS/FreshRSS/pull/7907)
	* Fix Docker Traefik `.yml` and `SERVER_DNS` example [#7858](https://github.com/FreshRSS/FreshRSS/pull/7858)
* SimplePie
	* Upstream contribution: Normalize encoding uppercase [simplepie#936](https://github.com/simplepie/simplepie/pull/936), [#7967](https://github.com/FreshRSS/FreshRSS/pull/7967)
	* Sync upstream, including bump to 1.9.0 with better PHP 8.5+ support [#7955](https://github.com/FreshRSS/FreshRSS/pull/7955)
* Deployment
	* Docker improve `CMD` compatibility [#7861](https://github.com/FreshRSS/FreshRSS/pull/7861)
	* Add possibility of Docker healthcheck [#7945](https://github.com/FreshRSS/FreshRSS/pull/7945)
* UI
	* Keep sort and order after marking as read [#7974](https://github.com/FreshRSS/FreshRSS/pull/7974)
	* Improve leave validation [#7830](https://github.com/FreshRSS/FreshRSS/pull/7830)
	* Improve *Origine* theme visibility of toggle buttons [#7956](https://github.com/FreshRSS/FreshRSS/pull/7956)
	* Improve *Dark pink* theme [#8020](https://github.com/FreshRSS/FreshRSS/pull/8020)
	* Improve *Mapco* and *Ansum* themes: read all button in mobile view [#7873](https://github.com/FreshRSS/FreshRSS/pull/7873)
	* Improve *Swage* theme [#7608](https://github.com/FreshRSS/FreshRSS/pull/7608)
	* Use standard CSS `overflow-wrap` instead of `word-wrap` [#7898](https://github.com/FreshRSS/FreshRSS/pull/7898)
	* Various UI and style improvements: [#7868](https://github.com/FreshRSS/FreshRSS/pull/7868), [#7872](https://github.com/FreshRSS/FreshRSS/pull/7872),
		[#7882](https://github.com/FreshRSS/FreshRSS/pull/7882), [#7893](https://github.com/FreshRSS/FreshRSS/pull/7893), [#7904](https://github.com/FreshRSS/FreshRSS/pull/7904),
		[#7952](https://github.com/FreshRSS/FreshRSS/pull/7952)
* I18n
	* Clarify the concepts of *visibility hidden* vs. *archived* in feeds settings [#7970](https://github.com/FreshRSS/FreshRSS/pull/7970)
	* Translate the API information page [#7922](https://github.com/FreshRSS/FreshRSS/pull/7922)
	* Add a default language constant [#7933](https://github.com/FreshRSS/FreshRSS/pull/7933)
	* Label config delete label [#7871](https://github.com/FreshRSS/FreshRSS/pull/7871)
	* Add Ukrainian [#7961](https://github.com/FreshRSS/FreshRSS/pull/7961)
	* Improve Dutch [#7940](https://github.com/FreshRSS/FreshRSS/pull/7940)
	* Improve German [#7833](https://github.com/FreshRSS/FreshRSS/pull/7833)
	* Improve Hungarian [#7986](https://github.com/FreshRSS/FreshRSS/pull/7986)
	* Improve Japanese [#7903](https://github.com/FreshRSS/FreshRSS/pull/7903), [#7918](https://github.com/FreshRSS/FreshRSS/pull/7918)
	* Improve Polish [#7963](https://github.com/FreshRSS/FreshRSS/pull/7963)
	* Improve Simplified Chinese [#7943](https://github.com/FreshRSS/FreshRSS/pull/7943), [#7944](https://github.com/FreshRSS/FreshRSS/pull/7944)
	* Minor improvements [#7881](https://github.com/FreshRSS/FreshRSS/pull/7881)
	* Add CLI command to add i18n file [#7917](https://github.com/FreshRSS/FreshRSS/pull/7917)
	* Add `make` target to generate the translation progress [#7905](https://github.com/FreshRSS/FreshRSS/pull/7905)
* Extensions
	* Add `entry_before_update` and `entry_before_add` hooks for extensions [#7977](https://github.com/FreshRSS/FreshRSS/pull/7977)
* Misc.
	* Improve `make` [#7901](https://github.com/FreshRSS/FreshRSS/pull/7901)
	* Improve PHP code [#7906](https://github.com/FreshRSS/FreshRSS/pull/7906), [#7916](https://github.com/FreshRSS/FreshRSS/pull/7916), [#7939](https://github.com/FreshRSS/FreshRSS/pull/7939),
		[#7941](https://github.com/FreshRSS/FreshRSS/pull/7941), [#7960](https://github.com/FreshRSS/FreshRSS/pull/7960), [#7991](https://github.com/FreshRSS/FreshRSS/pull/7991)
	* Upgrade to PHP_CodeSniffer 4 [#7993](https://github.com/FreshRSS/FreshRSS/pull/7993)
	* Update dev dependencies [#7902](https://github.com/FreshRSS/FreshRSS/pull/7902), [#7895](https://github.com/FreshRSS/FreshRSS/pull/7895), [#7896](https://github.com/FreshRSS/FreshRSS/pull/7896),
		[#7899](https://github.com/FreshRSS/FreshRSS/pull/7899), [#7966](https://github.com/FreshRSS/FreshRSS/pull/7966), [#7969](https://github.com/FreshRSS/FreshRSS/pull/7969)


## 2025-08-18 FreshRSS 1.27.0

* Features
	* Implement support for HTTP `429 Too Many Requests` and `503 Service Unavailable`, obey `Retry-After` [#7760](https://github.com/FreshRSS/FreshRSS/pull/7760)
	* Add sort by category title, or by feed title [#7702](https://github.com/FreshRSS/FreshRSS/pull/7702)
	* Add search operator `c:` for categories like `c:23,34` or `!c:45,56` [#7696](https://github.com/FreshRSS/FreshRSS/pull/7696)
	* Custom feed favicons [#7646](https://github.com/FreshRSS/FreshRSS/pull/7646), [#7704](https://github.com/FreshRSS/FreshRSS/pull/7704), [#7717](https://github.com/FreshRSS/FreshRSS/pull/7717),
		[#7792](https://github.com/FreshRSS/FreshRSS/pull/7792)
	* Rework fetch favicons for fewer HTTP requests [#7767](https://github.com/FreshRSS/FreshRSS/pull/7767)
	* Add more unicity criteria based on title and/or content [#7789](https://github.com/FreshRSS/FreshRSS/pull/7789)
	* Automatically restore user configuration from backup [#7682](https://github.com/FreshRSS/FreshRSS/pull/7682)
	* API add support for states in `s` parameter of `streamId` [#7695](https://github.com/FreshRSS/FreshRSS/pull/7695)
	* Improve sharing via Print [#7728](https://github.com/FreshRSS/FreshRSS/pull/7728)
	* Redirect to the login page from bookmarklet instead of 403 [#7782](https://github.com/FreshRSS/FreshRSS/pull/7782)
	* Clean local cache more often, when refreshing feeds [#7827](https://github.com/FreshRSS/FreshRSS/pull/7827)
* Security
	* Implement reauthentication (*sudo* mode) [#7753](https://github.com/FreshRSS/FreshRSS/pull/7753)
	* Add `Content-Security-Policy: frame-ancestors` [#7677](https://github.com/FreshRSS/FreshRSS/pull/7677)
	* Ensure CSP everywhere [#7810](https://github.com/FreshRSS/FreshRSS/pull/7810)
	* Show warning when unsafe CSP policy is in use [#7804](https://github.com/FreshRSS/FreshRSS/pull/7804)
	* Fix access rights when creating a new user [#7783](https://github.com/FreshRSS/FreshRSS/pull/7783)
	* Improve security of form for user details [#7771](https://github.com/FreshRSS/FreshRSS/pull/7771), [#7786](https://github.com/FreshRSS/FreshRSS/pull/7786)
	* Disallow setting non-existent theme [#7722](https://github.com/FreshRSS/FreshRSS/pull/7722)
	* Regenerate cookie ID after logging out [#7762](https://github.com/FreshRSS/FreshRSS/pull/7762)
	* Require current password when setting new password [#7763](https://github.com/FreshRSS/FreshRSS/pull/7763)
	* Add missing access checks for feed-related actions [#7768](https://github.com/FreshRSS/FreshRSS/pull/7768)
	* Strip more unsafe attributes such as `referrerpolicy`, `ping` [#7770](https://github.com/FreshRSS/FreshRSS/pull/7770)
	* Remove unneeded execution permissions [#7802](https://github.com/FreshRSS/FreshRSS/pull/7802)
* Bug fixing
	* Fix redirections when scraping from HTML [#7654](https://github.com/FreshRSS/FreshRSS/pull/7654), [#7741](https://github.com/FreshRSS/FreshRSS/pull/7741)
	* Fix multiple authentication HTTP headers [#7703](https://github.com/FreshRSS/FreshRSS/pull/7703)
	* Fix HTML queries with a single feed [#7730](https://github.com/FreshRSS/FreshRSS/pull/7730)
	* WebSub: only perform a redirection when coming from WebSub [#7738](https://github.com/FreshRSS/FreshRSS/pull/7738)
	* Include enclosures in entries’ hash [#7719](https://github.com/FreshRSS/FreshRSS/pull/7719)
		* Negative side-effect: users of the option to *automatically mark updated articles as unread* will once have some articles with enclosures re-appear as unread
	* Fix cancellation of slider exit UI [#7705](https://github.com/FreshRSS/FreshRSS/pull/7705)
	* Honor *disable update* on update page [#7733](https://github.com/FreshRSS/FreshRSS/pull/7733)
	* Fix no registration limit setting [#7751](https://github.com/FreshRSS/FreshRSS/pull/7751)
	* Fix XML encoding of sharing functions [#7822](https://github.com/FreshRSS/FreshRSS/pull/7822)
* SimplePie
	* Fix propagation of HTTP error codes [#7670](https://github.com/FreshRSS/FreshRSS/pull/7670)
	* Fix support for XML feeds with HTML entities [#7689](https://github.com/FreshRSS/FreshRSS/pull/7689), [simplepie#915](https://github.com/simplepie/simplepie/pull/915)
	* Fix feeds encoded in UTF-16LE [#7691](https://github.com/FreshRSS/FreshRSS/pull/7691), [simplepie#916](https://github.com/simplepie/simplepie/pull/916)
	* Various upstream contributions [simplepie#917](https://github.com/simplepie/simplepie/pull/917), [simplepie#924](https://github.com/simplepie/simplepie/pull/924),
		[simplepie#926](https://github.com/simplepie/simplepie/pull/926), [simplepie#932](https://github.com/simplepie/simplepie/pull/932), [simplepie#933](https://github.com/simplepie/simplepie/pull/933)
	* Sync upstream [#7706](https://github.com/FreshRSS/FreshRSS/pull/7706), [FreshRSS/simplepie#45](https://github.com/FreshRSS/simplepie/pull/45), [#7775](https://github.com/FreshRSS/FreshRSS/pull/7775),
		[FreshRSS/simplepie#50](https://github.com/FreshRSS/simplepie/pull/50), [#7824](https://github.com/FreshRSS/FreshRSS/pull/7824), [#7825](https://github.com/FreshRSS/FreshRSS/pull/7825),
	* Fix regex *Backtrack limit was exhausted* in `clean_hash()` [#7813](https://github.com/FreshRSS/FreshRSS/pull/7813), [FreshRSS/simplepie#48](https://github.com/FreshRSS/simplepie/pull/48)
* Deployment
	* Docker default image (Debian 12 Bookworm) updated to PHP 8.2.29 [#7805](https://github.com/FreshRSS/FreshRSS/pull/7805)
	* Docker alternative image updated to Alpine 3.22 with PHP 8.4.11 and Apache 2.4.65 [#7740](https://github.com/FreshRSS/FreshRSS/pull/7740), [#7740](https://github.com/FreshRSS/FreshRSS/pull/7740),
		[#7803](https://github.com/FreshRSS/FreshRSS/pull/7803)
	* Start supporting PHP 8.5+ [#7787](https://github.com/FreshRSS/FreshRSS/pull/7787), [#7826](https://github.com/FreshRSS/FreshRSS/pull/7826)
		* Docker Alpine dev image `:newest` updated to PHP 8.5-alpha and Apache 2.4.65 [#7773](https://github.com/FreshRSS/FreshRSS/pull/7773)
	* Docker: interpolate `FRESHRSS_INSTALL` and `FRESHRSS_USER` variables [#7725](https://github.com/FreshRSS/FreshRSS/pull/7725)
	* Docker: Reduce how much data needs to be chown/chmod’ed on container startup [#7793](https://github.com/FreshRSS/FreshRSS/pull/7793)
	* Test for database PDO typing support during install (relevant for MySQL / MariaDB with obsolete driver) [#7651](https://github.com/FreshRSS/FreshRSS/pull/7651)
* Extensions
	* Add API endpoint for extensions [#7576](https://github.com/FreshRSS/FreshRSS/pull/7576)
	* Expose the reading modes for extensions [#7668](https://github.com/FreshRSS/FreshRSS/pull/7668), [#7688](https://github.com/FreshRSS/FreshRSS/pull/7688)
	* New extension hook `before_login_btn` [#7761](https://github.com/FreshRSS/FreshRSS/pull/7761)
* UI
	* Improve *mark as read* request showing popup due to `onbeforeunload` [#7554](https://github.com/FreshRSS/FreshRSS/pull/7554)
	* Fix lazy-loading for `<video poster="...">` and `<image>` [#7636](https://github.com/FreshRSS/FreshRSS/pull/7636)
	* Avoid styling `<code>` inside of `<pre>` [#7797](https://github.com/FreshRSS/FreshRSS/pull/7797)
	* Improve confirmation logic with `data-auto-leave-validation` [#7785](https://github.com/FreshRSS/FreshRSS/pull/7785)
	* Update `chart.js` to 4.5.0 [#7752](https://github.com/FreshRSS/FreshRSS/pull/7752), [#7816](https://github.com/FreshRSS/FreshRSS/pull/7816)
	* Various UI and style improvements: [#7616](https://github.com/FreshRSS/FreshRSS/pull/7616), [#7811](https://github.com/FreshRSS/FreshRSS/pull/7811)
* I18n
	* Show translation status in README [#7715](https://github.com/FreshRSS/FreshRSS/pull/7715)
	* Improve Indonesian [#7654](https://github.com/FreshRSS/FreshRSS/pull/7654), [#7721](https://github.com/FreshRSS/FreshRSS/pull/7721)
	* Improve Persian [#7795](https://github.com/FreshRSS/FreshRSS/pull/7795)
* Misc.
	* Improve PHP code [#7642](https://github.com/FreshRSS/FreshRSS/pull/7642), [#7665](https://github.com/FreshRSS/FreshRSS/pull/7665), [#7761](https://github.com/FreshRSS/FreshRSS/pull/7761),
		[#7781](https://github.com/FreshRSS/FreshRSS/pull/7781), [#7794](https://github.com/FreshRSS/FreshRSS/pull/7794)
	* Update dev dependencies [#7708](https://github.com/FreshRSS/FreshRSS/pull/7708), [#7709](https://github.com/FreshRSS/FreshRSS/pull/7709), [#7710](https://github.com/FreshRSS/FreshRSS/pull/7710),
		[#7711](https://github.com/FreshRSS/FreshRSS/pull/7711), [#7776](https://github.com/FreshRSS/FreshRSS/pull/7776), [#7777](https://github.com/FreshRSS/FreshRSS/pull/7777)


## 2025-06-02 FreshRSS 1.26.3

* Features
	* Keep sort and order criteria during navigation [#7585](https://github.com/FreshRSS/FreshRSS/pull/7585)
	* Add info about `PDO::ATTR_CLIENT_VERSION` (relevant for MySQL / MariaDB with obsolete driver) [#7591](https://github.com/FreshRSS/FreshRSS/pull/7591)
* Bug fixing
	* Fix SQL request for user labels with custom sort (affecting PostgreSQL) [#7588](https://github.com/FreshRSS/FreshRSS/pull/7588)
	* Fix regression for favicon in GReader and Fever APIs [#7573](https://github.com/FreshRSS/FreshRSS/pull/7573)
	* Fix newest articles (within last second) not shown [#7577](https://github.com/FreshRSS/FreshRSS/pull/7577)
	* Fix duplicate HTTP header for POST [#7556](https://github.com/FreshRSS/FreshRSS/pull/7556)
	* Fix important articles on reader view [#7602](https://github.com/FreshRSS/FreshRSS/pull/7602)
	* Fix remove last share method [#7613](https://github.com/FreshRSS/FreshRSS/pull/7613)
	* Fix API handling of default category [#7610](https://github.com/FreshRSS/FreshRSS/pull/7610)
	* Fix user self-deletion [#7626](https://github.com/FreshRSS/FreshRSS/pull/7626)
	* Move PHP minimum version check [#7560](https://github.com/FreshRSS/FreshRSS/pull/7560)
* Security
	* Fix encoding of themes [#7565](https://github.com/FreshRSS/FreshRSS/pull/7565)
	* Fix `.htaccess.dist` for access to `/scripts/vendor/` [#7598](https://github.com/FreshRSS/FreshRSS/pull/7598)
* SimplePie
	* Strip more HTML deprecated styles attributes: `bgcolor, text, background, link, alink, vlink` [#7606](https://github.com/FreshRSS/FreshRSS/pull/7606)
* UI
	* Implement loading spinner for marking as favourite/read [#7564](https://github.com/FreshRSS/FreshRSS/pull/7564)
	* Provide theme class for CSS [#7559](https://github.com/FreshRSS/FreshRSS/pull/7559)
* Deployment
	* Use HTTP `Cache-Control: immutable` for some files [#7552](https://github.com/FreshRSS/FreshRSS/pull/7552)
	* Drop Apache 2.2 (only support Apache 2.4+) [#7561](https://github.com/FreshRSS/FreshRSS/pull/7561)
* I18n
	* Improve Indonesian [#7622](https://github.com/FreshRSS/FreshRSS/pull/7622)
	* Improve Polish [#7587](https://github.com/FreshRSS/FreshRSS/pull/7587)
* Misc.
	* Update to PHPMailer 6.10.0 [#7542](https://github.com/FreshRSS/FreshRSS/pull/7542)
	* Update dev dependencies [#7630](https://github.com/FreshRSS/FreshRSS/pull/7630), [#7631](https://github.com/FreshRSS/FreshRSS/pull/7631), [#7632](https://github.com/FreshRSS/FreshRSS/pull/7632)
		[#7633](https://github.com/FreshRSS/FreshRSS/pull/7633), [#7634](https://github.com/FreshRSS/FreshRSS/pull/7634), [#7635](https://github.com/FreshRSS/FreshRSS/pull/7635)


## 2025-05-03 FreshRSS 1.26.2

* Features
	* Implement JSON string concatenation with & operator [#7414](https://github.com/FreshRSS/FreshRSS/pull/7414)
	* Support multiple JSON fragments in HTML+XPath+JSON mode [#7369](https://github.com/FreshRSS/FreshRSS/pull/7369)
* Bug fixing
	* Fix escaping of tag search [#7468](https://github.com/FreshRSS/FreshRSS/pull/7468)
	* Fix CLI parsing of Boolean flags [#7430](https://github.com/FreshRSS/FreshRSS/pull/7430)
	* Fix API for labels with slash [#7437](https://github.com/FreshRSS/FreshRSS/pull/7437)
* SimplePie
	* Fix support for feeds with XML preamble + DTD [#7515](https://github.com/FreshRSS/FreshRSS/pull/7515), [simplepie#914](https://github.com/simplepie/simplepie/pull/914)
	* Merged upstream [#7434](https://github.com/FreshRSS/FreshRSS/pull/7434)
		* Upstream fix [simplepie#912](https://github.com/simplepie/simplepie/pull/912)
* Security
	* Disallow `<iframe srcdoc="">` [#7494](https://github.com/FreshRSS/FreshRSS/pull/7494), [CVE-2025-32015](https://github.com/FreshRSS/FreshRSS/security/advisories/GHSA-wgrq-mcwc-8f8v)
	* Disallow `<button formaction="">` [#7506](https://github.com/FreshRSS/FreshRSS/pull/7506)
	* Improve favicons hash to avoid favicon pollution [#7505](https://github.com/FreshRSS/FreshRSS/pull/7505), [CVE-2025-46339](https://github.com/FreshRSS/FreshRSS/security/advisories/GHSA-8f79-3q3w-43c4)
	* Add `Content-Security-Policy` HTTP headers to favicons [#7471](https://github.com/FreshRSS/FreshRSS/pull/7471), [CVE-2025-31136](https://github.com/FreshRSS/FreshRSS/security/advisories/GHSA-f6r4-jrvc-cfmr)
	* Web scraping forbid security HTTP headers in cURL [#7496](https://github.com/FreshRSS/FreshRSS/pull/7496), [CVE-2025-46341](https://github.com/FreshRSS/FreshRSS/security/advisories/GHSA-w3m8-wcf4-h8vm)
	* Add some HTTP headers `Referrer-Policy: same-origin` [#6303](https://github.com/FreshRSS/FreshRSS/pull/6303), [#7478](https://github.com/FreshRSS/FreshRSS/pull/7478)
	* Use HTTP POST for logout [#7489](https://github.com/FreshRSS/FreshRSS/pull/7489), [CVE-2025-31482](https://github.com/FreshRSS/FreshRSS/security/advisories/GHSA-vpmc-3fv2-jmgp)
	* Make update URL read-only [#7477](https://github.com/FreshRSS/FreshRSS/pull/7477)
	* Fix for extensions: Restrict valid paths in `ext.php` [#7479](https://github.com/FreshRSS/FreshRSS/pull/7479), [CVE-2025-31134](https://github.com/FreshRSS/FreshRSS/security/advisories/GHSA-jjm2-4hf7-9x65)
	* Fix for extensions: Secure serving of user files [#7495](https://github.com/FreshRSS/FreshRSS/pull/7495)
* Extensions
	* Fix file serving for symlinked extensions [#7545](https://github.com/FreshRSS/FreshRSS/pull/7545)
	* Catch extension exceptions in override [#7475](https://github.com/FreshRSS/FreshRSS/pull/7475)
	* JavaScript: new event to detect context loaded [#7452](https://github.com/FreshRSS/FreshRSS/pull/7452)
* Deployment
	* Apache: add check for `mod_filter` to ensure that `AddOutputFilterByType` works [#7419](https://github.com/FreshRSS/FreshRSS/pull/7419)
* UI
	* Accessibility: Add `:focus` style to some dropdown menus [#7491](https://github.com/FreshRSS/FreshRSS/pull/7491)
	* New size option for the *Mark as read* button [#7314](https://github.com/FreshRSS/FreshRSS/pull/7314)
	* Update `bcrypt.js` from 2.4.4 to 3.0.2 [#7449](https://github.com/FreshRSS/FreshRSS/pull/7449)
	* Various UI and style improvements: [#7168](https://github.com/FreshRSS/FreshRSS/pull/7168), [#7526](https://github.com/FreshRSS/FreshRSS/pull/7526)
* I18n
	* Rework credits [#7426](https://github.com/FreshRSS/FreshRSS/pull/7426)
	* Improve French [#7432](https://github.com/FreshRSS/FreshRSS/pull/7432)
	* Improve Italian [#7540](https://github.com/FreshRSS/FreshRSS/pull/7540)
	* Improve Polish [#7508](https://github.com/FreshRSS/FreshRSS/pull/7508)
	* Improve Turkish [#7442](https://github.com/FreshRSS/FreshRSS/pull/7442)
* Misc.
	* Improve PHP code [#7431](https://github.com/FreshRSS/FreshRSS/pull/7431), [#7488](https://github.com/FreshRSS/FreshRSS/pull/7488), [#7534](https://github.com/FreshRSS/FreshRSS/pull/7534)
	* Update dev dependencies [#7480](https://github.com/FreshRSS/FreshRSS/pull/7480), [#7482](https://github.com/FreshRSS/FreshRSS/pull/7482), [#7483](https://github.com/FreshRSS/FreshRSS/pull/7483),
		[#7484](https://github.com/FreshRSS/FreshRSS/pull/7484), [#7485](https://github.com/FreshRSS/FreshRSS/pull/7485), [#7486](https://github.com/FreshRSS/FreshRSS/pull/7486),
		[#7487](https://github.com/FreshRSS/FreshRSS/pull/7487), [#7533](https://github.com/FreshRSS/FreshRSS/pull/7533), [#7535](https://github.com/FreshRSS/FreshRSS/pull/7535),
		[#7536](https://github.com/FreshRSS/FreshRSS/pull/7536), [#7537](https://github.com/FreshRSS/FreshRSS/pull/7537), [#7538](https://github.com/FreshRSS/FreshRSS/pull/7538)


## 2025-03-13 FreshRSS 1.26.1

* Features
	* Add cURL version to page about system information [#7409](https://github.com/FreshRSS/FreshRSS/pull/7409)
* Bug fixing
	* Fix regression with cURL HTTP headers breaking conditional HTTP requests [#7403](https://github.com/FreshRSS/FreshRSS/pull/7403), [FreshRSS/simplepie#33](https://github.com/FreshRSS/simplepie/pull/33)
	* Fix regression with saving states of user queries [#7400](https://github.com/FreshRSS/FreshRSS/pull/7400)
	* Fix regression with dynamic OPML [#7394](https://github.com/FreshRSS/FreshRSS/pull/7394)
	* Fix update of the user’s last activity on login action [#7406](https://github.com/FreshRSS/FreshRSS/pull/7406)
	* Fix setting category option *Maximum number of articles to keep per feed* [#7416](https://github.com/FreshRSS/FreshRSS/pull/7416)
	* Fix priority field when processing a new feed from an extension [#7354](https://github.com/FreshRSS/FreshRSS/pull/7354)
* Deployment
	* Fix regression with 64-bit timestamps on 32-bit platforms [#7375](https://github.com/FreshRSS/FreshRSS/pull/7375)
	* Fix back-compatibility with cURL 7.51 (we require cURL 7.52+ for `CURLPROXY_HTTPS`) [#7409](https://github.com/FreshRSS/FreshRSS/pull/7409)
* UI
	* Use case-insensitive sort for categories [#7402](https://github.com/FreshRSS/FreshRSS/pull/7402)
	* Improve dark mode of *Origine* theme [#7413](https://github.com/FreshRSS/FreshRSS/pull/7413)
	* Added API password indicator [#7340](https://github.com/FreshRSS/FreshRSS/pull/7340)
* I18n
	* Fix (es, fa, sk): do not translate XPath code [#7404](https://github.com/FreshRSS/FreshRSS/pull/7404)
	* Fix date bug in Finish [#7423](https://github.com/FreshRSS/FreshRSS/pull/7423)
	* Add Portuguese from Portugal [#7329](https://github.com/FreshRSS/FreshRSS/pull/7329)
	* Improve Hungarian [#7391](https://github.com/FreshRSS/FreshRSS/pull/7391)
* Misc.
	* Improve PHP code [#7339](https://github.com/FreshRSS/FreshRSS/pull/7339)
	* Update dev dependencies [#7386](https://github.com/FreshRSS/FreshRSS/pull/7386), [#7387](https://github.com/FreshRSS/FreshRSS/pull/7387), [#7388](https://github.com/FreshRSS/FreshRSS/pull/7388)


## 2025-02-23 FreshRSS 1.26.0

* Features
	* Add order-by options to sort articles by received date (existing, default), publication date, title, link, random [#7149](https://github.com/FreshRSS/FreshRSS/pull/7149)
	* Allow searching in all feeds, also feeds only visible at category level with `&get=A`, and also those archived with `&get=Z` [#7144](https://github.com/FreshRSS/FreshRSS/pull/7144)
		* UI accessible from user-query view
	* Add search operator `intext:` [#7228](https://github.com/FreshRSS/FreshRSS/pull/7228)
	* New shortcuts for adding user labels to articles [#7274](https://github.com/FreshRSS/FreshRSS/pull/7274)
	* New *About* page with system information [#7161](https://github.com/FreshRSS/FreshRSS/pull/7161)
* Bug fixing
	* Fix regression denying access to app manifest [#7158](https://github.com/FreshRSS/FreshRSS/pull/7158)
	* Fix unwanted feed description updates [#7269](https://github.com/FreshRSS/FreshRSS/pull/7269)
	* Ensure no PHP buffer for SQLite download (some setups would first put the file in memory) [#7230](https://github.com/FreshRSS/FreshRSS/pull/7230)
	* Fix XML encoding regression in HTML+XPath mode [#7345](https://github.com/FreshRSS/FreshRSS/pull/7345)
	* Improve cURL proxy options and fix some constants [#7231](https://github.com/FreshRSS/FreshRSS/pull/7231)
	* Fix UI of global view unread articles counter [#7247](https://github.com/FreshRSS/FreshRSS/pull/7247)
	* Hide base theme in carrousel [#7234](https://github.com/FreshRSS/FreshRSS/pull/7234)
* Deployment
	* Require cURL 7.52.0+ [#7231](https://github.com/FreshRSS/FreshRSS/pull/7231)
	* Reduce superfluous Docker builds [#7137](https://github.com/FreshRSS/FreshRSS/pull/7137)
	* Docker default image (Debian 12 Bookworm) updated to PHP 8.2.26 and Apache 2.4.62
	* Docker alternative image (Alpine 3.21) updated to PHP 8.3.16
* UI
	* Add footer icons to reader view [#7133](https://github.com/FreshRSS/FreshRSS/pull/7133)
	* Remove local reference to font *Open Sans* to avoid bugs with some local versions [#7215](https://github.com/FreshRSS/FreshRSS/pull/7215)
	* Improve stats page layout [#7243](https://github.com/FreshRSS/FreshRSS/pull/7243)
	* Smaller *mark as read* button in mobile view [#5220](https://github.com/FreshRSS/FreshRSS/pull/5220)
	* Add CSS class to various types of notifications to allow custom styling [#7287](https://github.com/FreshRSS/FreshRSS/pull/7287)
	* Various UI and style improvements: [#7162](https://github.com/FreshRSS/FreshRSS/pull/7162), [#7268](https://github.com/FreshRSS/FreshRSS/pull/7268)
Security
	* Better authorization label for OIDC in the UI [#7264](https://github.com/FreshRSS/FreshRSS/pull/7264)
	* Allow comments in `force-https.txt` [#7259](https://github.com/FreshRSS/FreshRSS/pull/7259)
* I18n:
	* Improve German [#7177](https://github.com/FreshRSS/FreshRSS/pull/7177), [#7275](https://github.com/FreshRSS/FreshRSS/pull/7275), [#7278](https://github.com/FreshRSS/FreshRSS/pull/7278)
	* Improve Japanese [#7187](https://github.com/FreshRSS/FreshRSS/pull/7187), [#7195](https://github.com/FreshRSS/FreshRSS/pull/7195), [#7332](https://github.com/FreshRSS/FreshRSS/pull/7332)
* Misc.
	* Improve PHP code [#7191](https://github.com/FreshRSS/FreshRSS/pull/7191), [#7204](https://github.com/FreshRSS/FreshRSS/pull/7204)
		* Upgrade to PHPStan 2 [#7131](https://github.com/FreshRSS/FreshRSS/pull/7131), [#7164](https://github.com/FreshRSS/FreshRSS/pull/7164), [#7224](https://github.com/FreshRSS/FreshRSS/pull/7224),
		[#7270](https://github.com/FreshRSS/FreshRSS/pull/7270), [#7281](https://github.com/FreshRSS/FreshRSS/pull/7281), [#7282](https://github.com/FreshRSS/FreshRSS/pull/7282)
	* Update to CssXPath 1.3.0 (no change) [#7211](https://github.com/FreshRSS/FreshRSS/pull/7211)
	* Update dev dependencies [#7165](https://github.com/FreshRSS/FreshRSS/pull/7165), [#7166](https://github.com/FreshRSS/FreshRSS/pull/7166), [#7167](https://github.com/FreshRSS/FreshRSS/pull/7167),
		[#7279](https://github.com/FreshRSS/FreshRSS/pull/7279), [#7280](https://github.com/FreshRSS/FreshRSS/pull/7280), [#7283](https://github.com/FreshRSS/FreshRSS/pull/7283),
		[#7284](https://github.com/FreshRSS/FreshRSS/pull/7284), [#7285](https://github.com/FreshRSS/FreshRSS/pull/7285), [#7347](https://github.com/FreshRSS/FreshRSS/pull/7347)
	* Update GitHub Actions to Ubuntu 24.04 [#7207](https://github.com/FreshRSS/FreshRSS/pull/7207)


## 2024-12-23 FreshRSS 1.25.0

* Features
	* Add support for [regex search (regular expressions)](https://freshrss.github.io/FreshRSS/en/users/10_filter.html#regex) [#6706](https://github.com/FreshRSS/FreshRSS/pull/6706), [#6926](https://github.com/FreshRSS/FreshRSS/pull/6926)
		* ⚠️ Advanced regex syntax for searches depends on the database used (SQLite, PostgreSQL, MariaDB, MySQL),
		but FreshRSS filter actions such as auto-mark-as-read and auto-favourite always use [PHP PCRE2 syntax](https://php.net/regexp.introduction).
	* Allow dynamic search operator in user queries, like `search:UserQueryA date:P1d` [#6851](https://github.com/FreshRSS/FreshRSS/pull/6851)
	* New feed mode *HTML+XPath+JSON dot notation* (JSON in HTML) [#6888](https://github.com/FreshRSS/FreshRSS/pull/6888)
	* Better HTTP compliance with support for HTTP response headers `Cache-Control: max-age` and `Expires` [#6812](https://github.com/FreshRSS/FreshRSS/pull/6812), [FreshRSS/simplepie#26](https://github.com/FreshRSS/simplepie/pull/26)
	* Support custom HTTP request headers per feed (e.g. for `Authorization`) [#6820](https://github.com/FreshRSS/FreshRSS/pull/6820)
	* New unicity policies and heuristic for feeds with bad article IDs [#4487](https://github.com/FreshRSS/FreshRSS/pull/4487), [#6900](https://github.com/FreshRSS/FreshRSS/pull/6900)
	* Fallback to GUID if article link is empty [#7051](https://github.com/FreshRSS/FreshRSS/pull/7051)
	* New option to automatically mark new articles as read if an identical title already exists in the same category [#6922](https://github.com/FreshRSS/FreshRSS/pull/6922)
	* New reading view option to display unread articles + favourites [#7088](https://github.com/FreshRSS/FreshRSS/pull/7088)
		* And corresponding new filter state `&state=96` (no UI button yet)
	* Add ability to remove content from articles with CSS selectors, also when not using full content [#6786](https://github.com/FreshRSS/FreshRSS/pull/6786), [#6807](https://github.com/FreshRSS/FreshRSS/pull/6807)
	* Update `phpgt/cssxpath` library with improved CSS selectors [#6618](https://github.com/FreshRSS/FreshRSS/pull/6618)
		* Support for `:last-child`, `:first-of-type`, `:last-of-type`, `^=`, `|=`
	* New condition option to selectively retrieve full content of articles
		[#33fd07f6f26310d4806077cc87bcdf9b8b940e35](https://github.com/FreshRSS/FreshRSS/commit/33fd07f6f26310d4806077cc87bcdf9b8b940e35), [#7082](https://github.com/FreshRSS/FreshRSS/pull/7082)
	* Allow parentheses in quoted search [#7055](https://github.com/FreshRSS/FreshRSS/pull/7055)
	* New UI feature to download a user’ SQLite database or a database SQLite export (to be produced by CLI) [#6931](https://github.com/FreshRSS/FreshRSS/pull/6931)
	* New button to delete errored feeds from a category [#7030](https://github.com/FreshRSS/FreshRSS/pull/7030)
	* Better import of Inoreader user labels [#6791](https://github.com/FreshRSS/FreshRSS/pull/6791)
	* Rebuild feed favicon on cache clear [#6961](https://github.com/FreshRSS/FreshRSS/pull/6961)
	* New sharing with Bluesky [#7116](https://github.com/FreshRSS/FreshRSS/pull/7116)
	* New sharing with Telegram [#6838](https://github.com/FreshRSS/FreshRSS/pull/6838)
* Bug fixing
	* Fix searches with a parenthesis before an operator like `("a b")` or `(!c)` [#6818](https://github.com/FreshRSS/FreshRSS/pull/6818)
	* Fix auto-read tags [#6790](https://github.com/FreshRSS/FreshRSS/pull/6790)
	* Fix CSS selector for removing elements [#7037](https://github.com/FreshRSS/FreshRSS/pull/7037), [#7073](https://github.com/FreshRSS/FreshRSS/pull/7073),
		[#7081](https://github.com/FreshRSS/FreshRSS/pull/7081), [#7091](https://github.com/FreshRSS/FreshRSS/pull/7091), [#7083](https://github.com/FreshRSS/FreshRSS/pull/7083)
	* Fix redirection error after creating a new user [#6995](https://github.com/FreshRSS/FreshRSS/pull/6995)
	* Fix favicon error in case of wrong URL [#6899](https://github.com/FreshRSS/FreshRSS/pull/6899)
	* Use cURL to fetch extensions list (allows e.g. IPv6) [#6767](https://github.com/FreshRSS/FreshRSS/pull/6767)
	* Fix XML encoding in cURL options [#6821](https://github.com/FreshRSS/FreshRSS/pull/6821)
	* Fix initial UI scroll for some browsers [#7059](https://github.com/FreshRSS/FreshRSS/pull/7059)
	* Fix menu for article tags in some cases [#6990](https://github.com/FreshRSS/FreshRSS/pull/6990)
	* Fix share menu shortcut [#6825](https://github.com/FreshRSS/FreshRSS/pull/6825)
	* Fix HTML regex pattern during install for compatibility with `v` mode [#7009](https://github.com/FreshRSS/FreshRSS/pull/7009)
	* More robust creation of user data folder [#7000](https://github.com/FreshRSS/FreshRSS/pull/7000)
* API
	* Fix API for categories and labels containing a `+` [#7033](https://github.com/FreshRSS/FreshRSS/pull/7033)
		* Compatibility with FocusReader
	* Supported by [Capy Reader](https://github.com/jocmp/capyreader) (Android, open source) [capyreader#492](https://github.com/jocmp/capyreader/discussions/492)
	* Improved UI for API [#7048](https://github.com/FreshRSS/FreshRSS/pull/7048)
	* Allow adding multiple feeds to a category via API [#7017](https://github.com/FreshRSS/FreshRSS/pull/7017)
	* API support edit multiple tags [#7060](https://github.com/FreshRSS/FreshRSS/pull/7060)
	* API return all categories also those without any feed [#7020](https://github.com/FreshRSS/FreshRSS/pull/7020)
* Compatibility
	* Require PHP 8.1+ (drop PHP 7.4) [#6711](https://github.com/FreshRSS/FreshRSS/pull/6711)
	* Improved support of PHP 8.4+ [#6618](https://github.com/FreshRSS/FreshRSS/pull/6618), [PhpGt/CssXPath#227](https://github.com/PhpGt/CssXPath/pull/227),
		[#6781](https://github.com/FreshRSS/FreshRSS/pull/6781), [#4374](https://github.com/FreshRSS/FreshRSS/pull/4374)
	* Require PostgreSQL 10+ (drop PostgreSQL 9.5) [#6705](https://github.com/FreshRSS/FreshRSS/pull/6705)
	* Require MariaDB 10.0.5+ (drop MariaDB 5.5) [#6706](https://github.com/FreshRSS/FreshRSS/pull/6706)
	* Require MySQL 8+ (drop MySQL 5.5.3) [#6706](https://github.com/FreshRSS/FreshRSS/pull/6706)
* Deployment
	* Docker: dev image `freshrss/freshrss:oldest` updated to Alpine 3.16 with PHP 8.1.22 and Apache 2.4.59 [#6711](https://github.com/FreshRSS/FreshRSS/pull/6711)
	* Docker alternative image updated to Alpine 3.21 with PHP 8.3.14 and Apache 2.4.62 [#5383](https://github.com/FreshRSS/FreshRSS/pull/5383)
	* Update Dockerfiles to newer key-value format [#6819](https://github.com/FreshRSS/FreshRSS/pull/6819)
	* Docker minor improvement of entrypoint [#6827](https://github.com/FreshRSS/FreshRSS/pull/6827)
* SimplePie
	* Refactor [our embedding](lib/README.md) of SimplePie [#4374](https://github.com/FreshRSS/FreshRSS/pull/4374)
		* Our fork is maintained in its [own repository](https://github.com/FreshRSS/simplepie/tree/freshrss).
	* Remove HTTP `Referer` [#6822](https://github.com/FreshRSS/FreshRSS/pull/6822), [FreshRSS/simplepie#27](https://github.com/FreshRSS/simplepie/pull/27)
		* If some sites require it, add `Referer: https://example.net/` to the custom HTTP headers of the feed [#6820](https://github.com/FreshRSS/FreshRSS/pull/6820)
	* Upstream fixes [simplepie#878](https://github.com/simplepie/simplepie/pull/878), [simplepie#883](https://github.com/simplepie/simplepie/pull/883)
	* Sync upstream [#6840](https://github.com/FreshRSS/FreshRSS/pull/6840), [#7067](https://github.com/FreshRSS/FreshRSS/pull/7067)
* Security
	* Apache protect more non-public folders and files [#6881](https://github.com/FreshRSS/FreshRSS/pull/6881), [#6893](https://github.com/FreshRSS/FreshRSS/pull/6893), [#7008](https://github.com/FreshRSS/FreshRSS/pull/7008)
	* Add privacy settings on extension list retrieval [#4603](https://github.com/FreshRSS/FreshRSS/pull/4603), [#7132](https://github.com/FreshRSS/FreshRSS/pull/7132)
	* Fix login in unsafe mode when using a password with special XML characters [#6797](https://github.com/FreshRSS/FreshRSS/pull/6797)
	* Fix login in e.g. Brave browser by avoiding synchronous XHR [#7023](https://github.com/FreshRSS/FreshRSS/pull/7023)
	* Fix invalid login message [#7066](https://github.com/FreshRSS/FreshRSS/pull/7066)
	* Modernise `windows.open noopener` (to avoid flash of white page in dark mode) [#7077](https://github.com/FreshRSS/FreshRSS/pull/7077), [#7089](https://github.com/FreshRSS/FreshRSS/pull/7089)
* UI
	* Searchable *My Labels* field [#6753](https://github.com/FreshRSS/FreshRSS/pull/6753)
	* Add subscription management button to reading view [#6946](https://github.com/FreshRSS/FreshRSS/pull/6946)
	* New option for showing label menu in article row [#6984](https://github.com/FreshRSS/FreshRSS/pull/6984)
	* Move to next unread label on mark as read [#6886](https://github.com/FreshRSS/FreshRSS/pull/6886)
	* Improved article footer for small / mobile screens [#7031](https://github.com/FreshRSS/FreshRSS/pull/7031)
	* Improve Web accessibility: fix `aria-hidden` bug, and use HTML5 `hidden` [#6910](https://github.com/FreshRSS/FreshRSS/pull/6910)
	* Default styles for `<pre>` and `<code>` [#6770](https://github.com/FreshRSS/FreshRSS/pull/6770)
	* Refactor the sharing menu to use a `<template>` instead of duplicated HTML code [#6751](https://github.com/FreshRSS/FreshRSS/pull/6751), [#7113](https://github.com/FreshRSS/FreshRSS/pull/7113)
	* Refactor the label menu to use a `<template>` [#6864](https://github.com/FreshRSS/FreshRSS/pull/6864)
	* Rework UI for authors [#7054](https://github.com/FreshRSS/FreshRSS/pull/7054)
		* Avoid Unicode escape of authors in HTML UI [#7056](https://github.com/FreshRSS/FreshRSS/pull/7056)
	* Improved subscription management page [#6816](https://github.com/FreshRSS/FreshRSS/pull/6816)
	* Improve user query management page [#7062](https://github.com/FreshRSS/FreshRSS/pull/7062)
	* Restore JavaScript form validation compatibility with Web browsers using older engines (SeaMonkey) [#6777](https://github.com/FreshRSS/FreshRSS/pull/6777)
	* Reorganise some options [#6920](https://github.com/FreshRSS/FreshRSS/pull/6920)
	* New shortcut `?` to show shortcut page and help [#6981](https://github.com/FreshRSS/FreshRSS/pull/6981)
	* Use of consistent colours in statistics [#7090](https://github.com/FreshRSS/FreshRSS/pull/7090)
	* Various UI and style improvements [#6959](https://github.com/FreshRSS/FreshRSS/pull/6959)
* Extensions
	* New extension hook `simplepie_after_init` [#7007](https://github.com/FreshRSS/FreshRSS/pull/7007)
* I18n
	* Add Finnish [#6954](https://github.com/FreshRSS/FreshRSS/pull/6954)
	* Improve English [#7049](https://github.com/FreshRSS/FreshRSS/pull/7049), [#7053](https://github.com/FreshRSS/FreshRSS/pull/7053)
	* Improve German [#6847](https://github.com/FreshRSS/FreshRSS/pull/6847), [#7068](https://github.com/FreshRSS/FreshRSS/pull/7068), [#7128](https://github.com/FreshRSS/FreshRSS/pull/7128)
	* Improve Italian [#6872](https://github.com/FreshRSS/FreshRSS/pull/6872), [#7069](https://github.com/FreshRSS/FreshRSS/pull/7069), [#7086](https://github.com/FreshRSS/FreshRSS/pull/7086)
	* Improve Spanish [#6894](https://github.com/FreshRSS/FreshRSS/pull/6894), [#6908](https://github.com/FreshRSS/FreshRSS/pull/6908)
	* Improve Turkish [#6960](https://github.com/FreshRSS/FreshRSS/pull/6960)
* Misc.
	* Better cache name for JSON feeds [#6768](https://github.com/FreshRSS/FreshRSS/pull/6768)
	* Fix inversed encoding logic in `Minz_Request::paramArray()` [#6800](https://github.com/FreshRSS/FreshRSS/pull/6800)
	* Pass PHPStan `booleansInConditions` [#6793](https://github.com/FreshRSS/FreshRSS/pull/6793)
	* Rename PHPStan configuration file to `phpstan.dist.neon` to allow custom configuration in `phpstan.neon` [#6892](https://github.com/FreshRSS/FreshRSS/pull/6892)
	* Code improvements [#6800](https://github.com/FreshRSS/FreshRSS/pull/6800), [#6809](https://github.com/FreshRSS/FreshRSS/pull/6809), [#6983](https://github.com/FreshRSS/FreshRSS/pull/6983)
	* Makefile improvements [#6913](https://github.com/FreshRSS/FreshRSS/pull/6913)
	* Fix PHPCS `ControlSignature` [#6896](https://github.com/FreshRSS/FreshRSS/pull/6896)
	* Update *PHPMailer* [#6968](https://github.com/FreshRSS/FreshRSS/pull/6968), [#7046](https://github.com/FreshRSS/FreshRSS/pull/7046)
	* Code updates to PHP 8.1 syntax [#6748](https://github.com/FreshRSS/FreshRSS/pull/6748)
	* Update dev dependencies [#6780](https://github.com/FreshRSS/FreshRSS/pull/6780), [#6964](https://github.com/FreshRSS/FreshRSS/pull/6964), , [#6965](https://github.com/FreshRSS/FreshRSS/pull/6965),
		[#6966](https://github.com/FreshRSS/FreshRSS/pull/6966), [#6967](https://github.com/FreshRSS/FreshRSS/pull/6967), [#6970](https://github.com/FreshRSS/FreshRSS/pull/6970),
		[#7042](https://github.com/FreshRSS/FreshRSS/pull/7042), [#7043](https://github.com/FreshRSS/FreshRSS/pull/7043), [#7044](https://github.com/FreshRSS/FreshRSS/pull/7044),
		[#7045](https://github.com/FreshRSS/FreshRSS/pull/7045), [#7047](https://github.com/FreshRSS/FreshRSS/pull/7047), [#7052](https://github.com/FreshRSS/FreshRSS/pull/7052)


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
	* Docker alternative image updated to Alpine 3.20 with PHP 8.3.10 and Apache 2.4.62 [#5383](https://github.com/FreshRSS/FreshRSS/pull/5383)
	* Docker: Alpine dev image `freshrss/freshrss:newest` updated to PHP 8.4.0beta3 and Apache 2.4.62 [#5764](https://github.com/FreshRSS/FreshRSS/pull/5764)
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
	* Fix absolutize URL for several cases [#6270](https://github.com/FreshRSS/FreshRSS/pull/6270), [simplepie#861](https://github.com/simplepie/simplepie/pull/861)
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


## Older

[See older changes](./docs/CHANGELOG-old2.md)
