# Configuration du serveur

Voir la [section sur l’installation du serveur](01_Installation.md).
En particulier, pour Apache, bien penser à la directive [`AllowEncodedSlashes On`](http://httpd.apache.org/docs/trunk/mod/core.html#allowencodedslashes),
pour une compatibilité maximale avec les clients (comme News+, mais inutile pour EasyRSS).

# Activer l’API dans FreshRSS


# Tester


# Clients compatibles

Tout client supportant une API de type Google Reader. Sélection :

* Android
	* [News+](https://play.google.com/store/apps/details?id=com.noinnion.android.newsplus) avec [News+ Google Reader extension](https://play.google.com/store/apps/details?id=com.noinnion.android.newsplus.extension.google_reader) (Propriétaire)
	* [EasyRSS](https://github.com/Alkarex/EasyRSS) (Libre, F-Droid)
* Linux
	* [FeedReader 2.0+](https://jangernert.github.io/FeedReader/) (Libre)
