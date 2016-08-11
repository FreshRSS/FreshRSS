# Changelog

## 2016-XX-XX FreshRSS 1.5.x-dev

* Compatibility
	* Require at least MySQL 5.5.3+ [#1153](https://github.com/FreshRSS/FreshRSS/issues/1153)
	* Require at least PHP 5.3.3+ [#1183](https://github.com/FreshRSS/FreshRSS/pull/1183)
	* Restore compatibility with Microsoft Internet Explorer 11 / Edge [#772](https://github.com/FreshRSS/FreshRSS/issues/772)
* Features
	* Support for full Unicode such as emoji 💕 in MySQL with utf8mb4 [#1153](https://github.com/FreshRSS/FreshRSS/issues/1153)
		* FreshRSS will automatically migrate MySQL tables to utf8mb4 the first time it is needed.
* Security
	* Remove Mozilla Persona login (the service closes on 2016-11-30) [#1052](https://github.com/FreshRSS/FreshRSS/issues/1052)
	* Use Referrer Policy `<meta name="referrer" content="origin" />` for limiting HTTP Referer [#1198](https://github.com/FreshRSS/FreshRSS/pull/1198)
* Bug fixing
	* Fixed scroll in log view [#1178](https://github.com/FreshRSS/FreshRSS/issues/1178)
	* Fixed JavaScript bug when articles were not always marked as read [#1123](https://github.com/FreshRSS/FreshRSS/issues/1123)
	* Fixed Apache Etag issue that prevented caching [#1199](https://github.com/FreshRSS/FreshRSS/pull/1199)
	* Fixed OPML import of categories [#1202](https://github.com/FreshRSS/FreshRSS/issues/1202)
* UI
	* Updated to jQuery 3.1.0 and several JavaScript fixes (e.g. drag & drop) [#1197](https://github.com/FreshRSS/FreshRSS/pull/1197)
* API
	* Add API link in FreshRSS profile settings to ease set-up [#1186](https://github.com/FreshRSS/FreshRSS/pull/1186)
* Mics.
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
	* Fix all quieries deleted when deleting a feed or category [#982](https://github.com/FreshRSS/FreshRSS/pull/982)


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
	* Support OPML, Json (like Google Reader) and Zip archives
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
* Correction bugs divers


## 2013-10-15 FreshRSS 0.5.1

* Correction bug des catégories disparues
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
* Améliorations CSS
* Changements dans la base de données
* Màj de la librairie SimplePie
* Flux sans auteurs gérés normalement
* Correction bugs divers


## 2013-04-08 FreshRSS 0.1.0

* “Première” version
