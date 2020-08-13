# FreshRSS - API compatible Fever

Voir la page [sur notre API compatible Google Reader](06_Mobile_access.md)
pour une autre possibilité et des généralités sur l’accès par API.

## Clients compatibles

De nombreux clients RSS prennent en charge l'API Fever, mais ils semblent
comprendre l'API Fever un peu différemment. Si votre client préféré ne
fonctionne pas correctement avec cette API, veuiller créer un ticket et nous
y jetterons un oeil. Mais nous ne pouvons le faire que pour les clients
gratuits.

### Utilisation et authentification

Avant de pouvoir commencer à utiliser cette API, vvous devez activer et
configurer l'accès à l'API, qui est [documenté
ici](https://freshrss.github.io/FreshRSS/en/users/06_Mobile_access.html), et
réinitialisez ensuite le mot de passe API de l'utilisateur.

Connectez ensuite votre application mobile en utilisant l'adresse de l'API
(e.g. `https://freshrss.example.net/api/fever.php`).

## Clients compatibles

| App                                                                                | Platform            | License                                            |
|:----------------------------------------------------------------------------------:|:-------------------:|:--------------------------------------------------------:|
|[Fluent Reader](https://hyliu.me/fluent-reader/)                                    |Windows, Linux, macOS|[BSD-3-Clause](https://github.com/yang991178/fluent-reader/blob/master/LICENSE)|
|[Readably](https://play.google.com/store/apps/details?id=com.isaiasmatewos.readably)|Android              |Source fermée                                             |
|[Fiery Feeds](https://apps.apple.com/app/fiery-feeds-rss-reader/id1158763303)       |iOS                  |Source fermée                                             |
|[Unread](https://apps.apple.com/app/unread-rss-reader/id1252376153)                 |iOS                  |Source fermée                                             |
|[Reeder](https://www.reederapp.com/)                                                |iOS                  |Source fermée                                              |
|[ReadKit](https://apps.apple.com/app/readkit/id588726889)                           |macOS                |Source fermée                                              |

## Fonctionnalités

Les fonctionnalités suivantes sont implémentées :

* récupération des catégories
* récupération des flux
* récupération des entrées (new, favorites, unread, by_id, by_feed,
  by_category,since)
* récupération des favicons
* marquage des entrées comme lues
* marquage des entrées comme favoris
* marquage d'un flux comme lu
* marquage d'une catégorie comme lue
* support des extensions grace au hook `entry_before_display`

Les fonctionnalités suivantes ne sont pas implémentées :

* « Hot Links » car il n'y a encore rien dans FreshRSS qui soit similaire ou
  qui puisse être utilisé pour le simuler.

## Tester et déboguer

Si l'API ne fonctionne pas comme attendu dans votre lecteur, il est possible
de la tester manuellement avec un outil tel que
[Postman](https://www.getpostman.com/).

Envoyer une requête POST à l'adresse
https://freshrss.example.net/api/fever.php?api devrait vous renvoyer le
résultat suivant :
```json
{
	"api_version": 3,
	"auth": 0
}
```
Super, la configuration de base fonctionne !

Maintenant essayons de faire un appel authentifié. Fever utilise un
paramètre `api_key` qui contient le résultat de la fonction de hachage MD5
de la valeur `"$username:$apiPassword"`. En considérant que l'utilisateur
est `kevin` et que son mot de passe est `freshrss`, voici la commande à
lancer pour calculer la valeur du paramètre `api_key` :

```sh
api_key=`echo -n "kevin:freshrss" | md5sum | cut -d' ' -f1`
```

Ajoutez un contenu sous forme de `form-data`à votre requête POST ainsi que
le paramètre `api_key` contenant la valeur calculée à l'étape précédente :

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
Parfait, maintenant vous êtes autentifié et vous pouvez commencer à tester
les fonctions avancées. Pour cela, il suffit de changer l'adresse en lui
ajoutant les paramètres nécessaires à la réalisation des actions
supportées. Pour plus d'information, veuillez vous référer à la
[documentation officielle de Fever](https://feedafever.com/api).

Voici quelques exemples simples d'appels réalisables :

* https://freshrss.example.net/api/fever.php?api&items
* https://freshrss.example.net/api/fever.php?api&feeds
* https://freshrss.example.net/api/fever.php?api&groups
* https://freshrss.example.net/api/fever.php?api&unread_item_ids
* https://freshrss.example.net/api/fever.php?api&saved_item_ids
* https://freshrss.example.net/api/fever.php?api&items&since_id=some_id
* https://freshrss.example.net/api/fever.php?api&items&max_id=some_id
* https://freshrss.example.net/api/fever.php?api&mark=item&as=read&id=some_id
* https://freshrss.example.net/api/fever.php?api&mark=item&as=unread&id=some_id

Remplacez `some_id` par un identifiant réel de votre base de données
`freshrss_username_entry`.

### Déboguer

Si rien ne fonctionne correctement et que votre client se comporte
étrangement, vous pouvez ajouter les quelques lignes suivantes au début du
fichier `fever.api` pour déterminer la cause des problèmes rencontrés :

```php
file_put_contents(__DIR__ . '/fever.log', $_SERVER['HTTP_USER_AGENT'] . ': ' . json_encode($_REQUEST) . PHP_EOL, FILE_APPEND);
```

Utilisez ensuite votre client RSS pour interroger l'API et vérifier le
fichier `fever.log`.

## Remerciements

Ce plugin a été inspiré par le
[tinytinyrss-fever-plugin](https://github.com/dasmurphy/tinytinyrss-fever-plugin).
