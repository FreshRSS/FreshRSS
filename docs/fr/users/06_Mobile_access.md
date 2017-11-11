Cette page suppose que vous avez fini [l’installation du serveur](01_Installation.md).

# Activer l’API dans FreshRSS

1. Dans la section “Authentification”, cocher l’option “Autoriser l’accès par API (nécessaire pour les applis mobiles)”.
2. Dans la section “Profil”, remplir le champ “Mot de passe API (ex. : pour applis mobiles)”.
	a. Chaque utilisateur doit choisir son mot de passe API.
	b. La raison d’être d’un mot de passe API différent du mot de passe principal est que le mot de passe API est potentiellement utilisé de manière moins sûre, mais il permet aussi moins de choses.


# Tester

3. Dans la section “Profil”, cliquer sur le lien de la forme `https://rss.example.net/api/` à côté du champ “Mot de passe API”.
4. Cliquer sur le premier lien “Check full server configuration”:
	* Si vous obtenez `PASS`, tout est bon : passer à l’étape 6.
	* Si vous obtenez *Bad Request!* ou *Not Found*, alors votre serveur ne semble pas accepter les slashs `/` qui sont encodés `%2F`. Passer à l’étape 5.
	* Si vous obtenez un autre message d’erreur, passer à l’étape 5.


# Débogger la configuration du serveur

5. Cliquer sur le second lien “Check partial server configuration (without `%2F` support)”:
	* Si vous obtenez `PASS`, alors le problème est bien que votre serveur n’accepte pas les slashs `/` qui sont encodés `%2F`.
		* Avec Apache, vérifiez la directive [`AllowEncodedSlashes On`](http://httpd.apache.org/docs/trunk/mod/core.html#allowencodedslashes)
		* Ou utilisez un client qui n’encode pas les slashs (comme EasyRSS), auquel cas passer à l’étape 6.
	* Si vous obtenez *Service Unavailable!*, retourner à l’étape 6.
	* Avec _Apache_:
		* Si vous obtenez *FAIL getallheaders!*, alors la combinaison de votre version de PHP et de votre serveur Web ne permet pas l’accès à [`getallheaders`](http://php.net/getallheaders)
			* Utilisez au moins PHP 5.4+, ou utilisez PHP en tant que module plutôt que CGI. Sinon, activer Apache `mod_rewrite` :
				* Autoriser [`FileInfo` dans `.htaccess`](http://httpd.apache.org/docs/trunk/mod/core.html#allowoverride) : revoir [l’installation du serveur].
				* Activer [`mod_rewrite`](http://httpd.apache.org/docs/trunk/mod/mod_rewrite.html) :
					* Sur Debian / Ubuntu : `sudo a2enmod rewrite`
	* Avec _nginx_:
		* Si vous obtenez *Bad Request!*, vérifier la configuration `PATH_INFO` de votre serveur.
		* Si vous obtenez *File not found!*, vérifier la configuration `fastcgi_split_path_info` de votre serveur.
	* Si vous obtenez *FAIL 64-bit or GMP extension!*, alors votre installation PHP soit n’est pas en 64 bit, soit n’a pas l’extension PHP [GMP](http://php.net/gmp) activée.
		* Le plus simple est d’activer l’extension GMP. Sur Debian / Ubuntu : `sudo apt install php-gmp`
	* Mettre à jour et retourner à l’étape 3.


# Clients compatibles

Tout client supportant une API de type Google Reader. Sélection :

* Android
	* [News+](https://play.google.com/store/apps/details?id=com.noinnion.android.newsplus) avec [News+ Google Reader extension](https://play.google.com/store/apps/details?id=com.noinnion.android.newsplus.extension.google_reader) (Propriétaire)
	* [EasyRSS](https://github.com/Alkarex/EasyRSS) (Libre, F-Droid)
* Linux
	* [FeedReader 2.0+](https://jangernert.github.io/FeedReader/) (Libre)
