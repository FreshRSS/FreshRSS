---
nav_order: 70
redirect_from:
  - /en/developers/06_Fever_API.html
---

# Fever API implementation

See [Mobile access](../users/mobile-access.md) for general aspects of API
access.  Additionally [page about our Google Reader compatible
API](googlereader-api.md) for another possibility.


## Clients compatibles

There are many RSS clients that support the Fever API, but they seem to
understand the Fever API a bit differently.  If your favourite client
doesn’t work properly with this API, please create an issue and we’ll have a
look.  But we can **only** do that for free clients.

### Utilisation et authentification

Before you can start using this API, you have to enable and setup API
access, which is [documented here](../users/mobile-access.md), and then
reset the user’s API password.

Connectez ensuite votre application mobile en utilisant l’adresse de l’API
(e.g. `https://freshrss.example.net/api/fever.php`).

## Clients compatibles

| App                                                                                | Platform            | License                                            |
|:----------------------------------------------------------------------------------:|:-------------------:|:--------------------------------------------------------:|
|[Fluent Reader](https://hyliu.me/fluent-reader/)                                    |Windows, Linux, macOS|[BSD-3-Clause](https://github.com/yang991178/fluent-reader/blob/master/LICENSE)|
|[Fluent Reader lite](https://hyliu.me/fluent-reader-lite/)                          |Android, iOS         |[BSD-3-Clause](https://github.com/yang991178/fluent-reader-lite)|
|[Read You](https://github.com/Ashinch/ReadYou/)                                     |Android              |[GPLv3](https://github.com/Ashinch/ReadYou/blob/main/LICENSE)|
|[Fiery Feeds](https://voidstern.net/fiery-feeds)       |iOS                  |Closed Source                                             |
|[Newsflash](https://gitlab.com/news-flash/news_flash_gtk/)                          |Linux                |[GPLv3](https://gitlab.com/news-flash/news_flash_gtk/)|
|[Unread](https://www.goldenhillsoftware.com/unread/)                 |iOS                  |Closed Source                                             |
|[Reeder Classic](https://www.reederapp.com/classic/)                                |iOS                  |Closed Source                                              |
|[ReadKit](https://readkit.app/)                           |macOS                |Closed Source                                              |
|[FreshRSS Python API Client](https://github.com/thiswillbeyourgithub/freshrss_python_api)                           |Python                |[GPLv3](https://github.com/thiswillbeyourgithub/freshrss_python_api)                                              |

## Fonctionnalités

Les fonctionnalités suivantes sont implémentées :

* récupération des catégories
* récupération des flux
* récupération des entrées (new, favorites, unread, by_id, by_feed,
  by_category,since)
* récupération des favicons
* marquage des entrées comme lues
* marquage des entrées comme favoris
* marquage d’un flux comme lu
* marquage d’une catégorie comme lue
* support des extensions grace au hook `entry_before_display`

Les fonctionnalités suivantes ne sont pas implémentées :

* « Hot Links » car il n’y a encore rien dans FreshRSS qui soit similaire ou
  qui puisse être utilisé pour le simuler.

## Tester et déboguer

If this API does not work as expected in your RSS reader, you can test it
manually with a tool like [Postman](https://www.getpostman.com/).

Configure a POST request to the URL
<https://freshrss.example.net/api/fever.php?api> which should give you the
result:
```json
{
	"api_version": 3,
	"auth": 0
}
```
Super, la configuration de base fonctionne !

Maintenant essayons de faire un appel authentifié. Fever utilise un
paramètre `api_key` qui contient le résultat de la fonction de hachage MD5
de la valeur `"$username:$apiPassword"`. En considérant que l’utilisateur
est `kevin` et que son mot de passe est `freshrss`, voici la commande à
lancer pour calculer la valeur du paramètre `api_key` :

```sh
api_key=`echo -n "kevin:freshrss" | md5sum | cut -d' ' -f1`
```

Ajoutez un contenu sous forme de `form-data`à votre requête POST ainsi que
le paramètre `api_key` contenant la valeur calculée à l’étape précédente :

```sh
curl -s -F "api_key=$api_key" 'https://freshrss.exemple.net/api/fever.php?api'
```

Vous devriez obtenir le résultat suivant :
```json
{
	"api_version": 3,
	"auth": 1,
	"last_refreshed_on_time": "1520013061"
}
```
Perfect, you’re now authenticated and you can start testing the more
advanced features. To do so, change the URL and append the possible API
actions to your request parameters. Please refer to the [original Fever
documentation](https://web.archive.org/web/20230616124016/https://feedafever.com/api)
for more information.

Voici quelques exemples simples d’appels réalisables :

* <https://freshrss.example.net/api/fever.php?api&items>
* <https://freshrss.example.net/api/fever.php?api&feeds>
* <https://freshrss.example.net/api/fever.php?api&groups>
* <https://freshrss.example.net/api/fever.php?api&unread_item_ids>
* <https://freshrss.example.net/api/fever.php?api&saved_item_ids>
* <https://freshrss.example.net/api/fever.php?api&items&since_id=some_id>
* <https://freshrss.example.net/api/fever.php?api&items&max_id=some_id>
* <https://freshrss.example.net/api/fever.php?api&mark=item&as=read&id=some_id>
* <https://freshrss.example.net/api/fever.php?api&mark=item&as=unread&id=some_id>

Remplacez `some_id` par un identifiant réel de votre base de données
`freshrss_username_entry`.

### Déboguer

Si rien ne fonctionne correctement et que votre client se comporte
étrangement, vous pouvez ajouter les quelques lignes suivantes au début du
fichier `fever.api` pour déterminer la cause des problèmes rencontrés :

```php
file_put_contents(__DIR__ . '/fever.log', $_SERVER['HTTP_USER_AGENT'] . ': ' . json_encode($_REQUEST) . PHP_EOL, FILE_APPEND);
```

Utilisez ensuite votre client RSS pour interroger l’API et vérifier le
fichier `fever.log`.

## Remerciements

Ce plugin a été inspiré par le
[tinytinyrss-fever-plugin](https://github.com/dasmurphy/tinytinyrss-fever-plugin).
