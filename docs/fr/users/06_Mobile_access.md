Cette page suppose que vous avez fini [l’installation du
serveur](01_Installation.md).

# Activer l’API dans FreshRSS

1. Dans la section “Authentification”, cocher l’option “Autoriser l’accès
   par API (nécessaire pour les applis mobiles)”.
2. Dans la section “Profil”, remplir le champ “Mot de passe API (ex. : pour applis mobiles)”.
	* Chaque utilisateur doit choisir son mot de passe API.
	* La raison d’être d’un mot de passe API
 différent du mot de passe principal est que le mot de passe API est potentiellement utilisé de manière moins sûre, mais il permet aussi moins de choses.

Le reste de cette page concerne l’API compatible Google Reader.Voir la [page
sur l’API compatible Fever](06_Fever_API.md) pour une autre possibilité.


# Tester

3. Dans la section “Profil”, cliquer sur le lien de la forme
   `https://rss.example.net/api/` à côté du champ “Mot de passe API”.
4. Cliquer sur le premier lien “Check full server configuration”:
	* Si vous obtenez `PASS`, tout est bon : passer à l’étape 6.
	* Si vous obtenez *Bad Request!* ou *Not Found*, alors votre serveur ne semble pas accepter les slashs `/` qui sont encodés `%2F`. Passer à l’étape 5.
	* Si vous obtenez un autre message d’erreur, passer à l’étape 5.


# Déboguer la configuration du serveur

5. Click on the second link “Check partial server configuration (without `%2F` support)”:
	* If you get `PASS`, then the problem is indeed that your server does not accept slashes `/` that are escaped `%2F`.
		* With Apache, remember the directive [`AllowEncodedSlashes On`](http://httpd.apache.org/docs/trunk/mod/core.html#allowencodedslashes)
		* Or use a client that does not escape slashes (such as EasyRSS), in which case proceed to step 6.
	* If you get *Service Unavailable!*, then check from step 1 again.
	* With __Apache__:
		* If you get *FAIL getallheaders!*, the combination of your PHP version and your Web server does not provide access to [`getallheaders`](http://php.net/getallheaders)
			* Turn on Apache `mod_setenvif` (often enabled by default), or `mod_rewrite` with the following procedure:
				* Allow [`FileInfo` in `.htaccess`](http://httpd.apache.org/docs/trunk/mod/core.html#allowoverride): see the [server setup](../admins/02_Installation.md) again.
				* Enable [`mod_rewrite`](http://httpd.apache.org/docs/trunk/mod/mod_rewrite.html):
					* With Debian / Ubuntu: `sudo a2enmod rewrite`
	* With __nginx__:
		* If you get *Bad Request!*, check your server `PATH_INFO` configuration.
		* If you get *File not found!*, check your server `fastcgi_split_path_info`.
	* If you get *FAIL 64-bit or GMP extension!*, then your PHP version does not pass the requirement of being 64-bit and/or have PHP [GMP](http://php.net/gmp) extension.
		* The easiest is to add the GMP extension. On Debian / Ubuntu: `sudo apt install php-gmp`
	* Update and try again from step 3.


# Clients compatibles

6. On the same FreshRSS API page, note the address given under “Your API address”, like `https://freshrss.example.net/api/greader.php`
	* You will type it in a client, together with your FreshRSS username, and the corresponding special API password.

7. Pick a client supporting a Google Reader-like API. Selection:
	* Android
		* [News+](https://play.google.com/store/apps/details?id=com.noinnion.android.newsplus) with [News+ Google Reader extension](https://play.google.com/store/apps/details?id=com.noinnion.android.newsplus.extension.google_reader) (Closed source)
		* [FeedMe 3.5.3+](https://play.google.com/store/apps/details?id=com.seazon.feedme) (Closed source)
		* [EasyRSS](https://github.com/Alkarex/EasyRSS) (Open source, [F-Droid](https://f-droid.org/packages/org.freshrss.easyrss/))
	* Linux
		* [FeedReader 2.0+](https://jangernert.github.io/FeedReader/) (Open source)
	* MacOS
		* [Vienna RSS](http://www.vienna-rss.com/) (Open source)
		* [Reeder](https://www.reederapp.com/) (Commercial)
	* iOS
		* [Reeder](https://www.reederapp.com/) (Commercial)
	* Firefox
		* [FreshRSS-Notify](https://addons.mozilla.org/firefox/addon/freshrss-notify-webextension/) (Open source)


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
