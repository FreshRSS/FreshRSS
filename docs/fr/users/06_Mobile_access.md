Cette page suppose que vous avez fini [l’installation du serveur](01_Installation.md).

# Activer l’API dans FreshRSS

1. Dans la section “Authentification”, cocher l’option “Autoriser l’accès par API (nécessaire pour les applis mobiles)”.
2. Dans la section “Profil”, remplir le champ “Mot de passe API (ex. : pour applis mobiles)”.
	* Chaque utilisateur doit choisir son mot de passe API.
	* La raison d’être d’un mot de passe API différent du mot de passe principal est que le mot de passe API est potentiellement utilisé de manière moins sûre, mais il permet aussi moins de choses.

Le reste de cette page concerne l’API compatible Google Reader.
Voir la [page sur l’API compatible Fever](06_Fever_API.md) pour une autre possibilité.


# Tester

3. Dans la section “Profil”, cliquer sur le lien de la forme `https://rss.example.net/api/` à côté du champ “Mot de passe API”.
4. Cliquer sur le premier lien “Check full server configuration”:
	* Si vous obtenez `PASS`, tout est bon : passer à l’étape 6.
	* Si vous obtenez *Bad Request!* ou *Not Found*, alors votre serveur ne semble pas accepter les slashs `/` qui sont encodés `%2F`. Passer à l’étape 5.
	* Si vous obtenez un autre message d’erreur, passer à l’étape 5.


# Déboguer la configuration du serveur

5. Cliquer sur le second lien “Check partial server configuration (without `%2F` support)”:
	* Si vous obtenez `PASS`, alors le problème est bien que votre serveur n’accepte pas les slashs `/` qui sont encodés `%2F`.
		* Avec Apache, vérifiez la directive [`AllowEncodedSlashes On`](http://httpd.apache.org/docs/trunk/mod/core.html#allowencodedslashes)
		* Ou utilisez un client qui n’encode pas les slashs (comme EasyRSS), auquel cas passer à l’étape 6.
	* Si vous obtenez *Service Unavailable!*, retourner à l’étape 6.
	* Avec __Apache__:
		* Si vous obtenez *FAIL getallheaders!*, alors la combinaison de votre version de PHP et de votre serveur Web ne permet pas l’accès à [`getallheaders`](http://php.net/getallheaders)
			* Utilisez au moins PHP 5.4+, ou utilisez PHP en tant que module plutôt que CGI. Sinon, activer Apache `mod_setenvif` (souvent activé par défault), ou `mod_rewrite` avec la procédure suivante :
				* Autoriser [`FileInfo` dans `.htaccess`](http://httpd.apache.org/docs/trunk/mod/core.html#allowoverride) : revoir [l’installation du serveur](01_Installation.md).
				* Activer [`mod_rewrite`](http://httpd.apache.org/docs/trunk/mod/mod_rewrite.html) :
					* Sur Debian / Ubuntu : `sudo a2enmod rewrite`
	* Avec __nginx__:
		* Si vous obtenez *Bad Request!*, vérifier la configuration `PATH_INFO` de votre serveur.
		* Si vous obtenez *File not found!*, vérifier la configuration `fastcgi_split_path_info` de votre serveur.
	* Si vous obtenez *FAIL 64-bit or GMP extension!*, alors votre installation PHP soit n’est pas en 64 bit, soit n’a pas l’extension PHP [GMP](http://php.net/gmp) activée.
		* Le plus simple est d’activer l’extension GMP. Sur Debian / Ubuntu : `sudo apt install php-gmp`
	* Mettre à jour et retourner à l’étape 3.


# Tests sur mobile

6. Vous pouvez maintenant tester sur une application mobile (News+, FeedMe, ou EasyRSS sur Android)
	* en utilisant comme adresse https://rss.example.net/api/greader.php ou http://example.net/FreshRSS/p/api/greader.php selon la configuration de votre site Web.
	* ⚠️ attention aux majuscules et aux espaces en tapant l’adresse avec le clavier du mobile ⚠️ 
	* avec votre nom d’utilisateur et le mot de passe enregistré au point 2 (mot de passe API).


# En cas de problèmes

 * Vous pouvez voir les logs API dans `./FreshRSS/data/users/_/log_api.txt`
 * Si vous avez une erreur 404 (fichier non trouvé) lors de l’étape de test, et que vous êtes sous Apache,
 voir http://httpd.apache.org/docs/trunk/mod/core.html#allowencodedslashes pour utiliser News+ 
(facultatif pour EasyRSS et FeedMe qui devraient fonctionner dès lors que vous obtenez un PASS au test *Check partial server configuration*).


# Clients compatibles

Tout client supportant une API de type Google Reader. Sélection :

* Android
	* [News+](https://play.google.com/store/apps/details?id=com.noinnion.android.newsplus) avec [News+ Google Reader extension](https://play.google.com/store/apps/details?id=com.noinnion.android.newsplus.extension.google_reader) (Propriétaire)
	* [FeedMe 3.5.3+](https://play.google.com/store/apps/details?id=com.seazon.feedme) (Propriétaire)
	* [EasyRSS](https://github.com/Alkarex/EasyRSS) (Libre, F-Droid)
* Linux
	* [FeedReader 2.0+](https://jangernert.github.io/FeedReader/) (Libre)
* MacOS
	* [Vienna RSS](http://www.vienna-rss.com/) (Libre)
* Firefox
	* [FreshRSS-Notify](https://addons.mozilla.org/fr/firefox/addon/freshrss-notify-webextension/) (Libre)

# API compatible Google Reader

Exemples de requêtes simples :

```sh
# Authentification utilisant le mot de passe API (Email et Passwd peuvent être passés en GET, ou POST - mieux)
curl 'https://freshrss.example.net/api/greader.php/accounts/ClientLogin?Email=alice&Passwd=Abcdef123456'
SID=alice/8e6845e089457af25303abc6f53356eb60bdb5f8
Auth=alice/8e6845e089457af25303abc6f53356eb60bdb5f8

# Exemples de requêtes en lecture
curl -s -H "Authorization:GoogleLogin auth=alice/8e6845e089457af25303abc6f53356eb60bdb5f8" \
  'https://freshrss.example.net/api/greader.php/reader/api/0/subscription/list?output=json'

curl -s -H "Authorization:GoogleLogin auth=alice/8e6845e089457af25303abc6f53356eb60bdb5f8" \
  'https://freshrss.example.net/api/greader.php/reader/api/0/unread-count?output=json'

curl -s -H "Authorization:GoogleLogin auth=alice/8e6845e089457af25303abc6f53356eb60bdb5f8" \
  'https://freshrss.example.net/api/greader.php/reader/api/0/tag/list?output=json'

# Demande de jeton pour faire de requêtes de modification
curl -H "Authorization:GoogleLogin auth=alice/8e6845e089457af25303abc6f53356eb60bdb5f8" \
  'https://freshrss.example.net/api/greader.php/reader/api/0/token'
8e6845e089457af25303abc6f53356eb60bdb5f8ZZZZZZZZZZZZZZZZZ

# Récupère les articles, envoyés à jq pour une lecture JSON plus facile
curl -s -H "Authorization:GoogleLogin auth=alice/8e6845e089457af25303abc6f53356eb60bdb5f8" \
  'https://freshrss.example.net/api/greader.php/reader/api/0/stream/contents/reading-list' | jq .
```
