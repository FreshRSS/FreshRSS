# FreshRSS - API compatible Fever

Voir la page [sur notre API compatible Google Reader](06_Mobile_access.md)
pour une autre possibilitéet des généralités sur l’accès par API.

## Clients compatibles

De nombreux clients RSS prennent en charge l'API Fever, mais ils semblent
comprendre l'API Fever un peu différemment.Si votre client préféré ne
fonctionne pas correctement avec cette API, veuillez créer un problème et
nous y jetterons un oeil.Mais nous ne pouvons le faire que pour les clients
gratuits.

### Utilisation et authentification

Avant de pouvoir commencer à utiliser cette API, vous devez activer et
configurer l'API accès, qui est [documenté
ici](https://freshrss.github.io/FreshRSS/en/users/06_Mobile_access.html), et
réinitialisez ensuite le mot de passe API de l'utilisateur.

Dirigez ensuite votre application mobile vers l'adresse du fichier
(e.g. `https://freshrss.example.net/api/fever.php`).

## Clients compatibles

Testé avec :

* Android
  * [Readably](https://play.google.com/store/apps/details?id=com.isaiasmatewos.readably) (Propriétaire)

* iOS
  * [Fiery Feeds](https://apps.apple.com/app/fiery-feeds-rss-reader/id1158763303) (Propriétaire)
  * [Unread](https://apps.apple.com/app/unread-rss-reader/id1252376153) (Commercial)
  * [Reeder](https://www.reederapp.com/) (Commercial) (Connectez-vous plutôt par son option Google Reader API)

* MacOS
  * [ReadKit](https://apps.apple.com/app/readkit/id588726889) (Commercial)


## Fonctionnalités

Les fonctionnalités suivantes sont implémentées :

* fetching categories
* fetching feeds
* fetching RSS items (new, favorites, unread, by_id, by_feed, by_category,
  since)
* fetching favicons
* setting read marker for item(s)
* setting starred marker for item(s)
* setting read marker for feed
* setting read marker for category
* supports FreshRSS extensions, which use the `entry_before_display` hook

Les fonctionnalités suivantes ne sont pas implémentées :

* « Hot Links » car il n'y a encore rien dans FreshRSS qui soit similaire ou
  qui puisse être utilisé pour le simuler.

## Tester et déboguer

If this API does not work as expected in your RSS reader, you can test it
manually with a tool like [Postman](https://www.getpostman.com/).

Configure a POST request to the URL
https://freshrss.example.net/api/fever.php?api which should give you the
result:
```json
{
	"api_version": 3,
	"auth": 0
}
```
Great, the base setup seems to work!

Now lets try an authenticated call. Fever uses an `api_key`, which is the
MD5 hash of `"$username:$apiPassword"`.  Assuming the user is `kevin` and
the password `freshrss`, here is a command-line example to compute the
resulting `api_key`

```sh
api_key=`echo -n "kevin:freshrss" | md5sum | cut -d' ' -f1`
```

Add a body to your POST request encoded as `form-data` and one key named
`api_key` with the value `your-password-hash`:

```sh
curl -s -F "api_key=$api_key" 'https://freshrss.example.net/api/fever.php?api'
```

This should give:
```json
{
	"api_version": 3,
	"auth": 1,
	"last_refreshed_on_time": "1520013061"
}
```
Perfect, you're now authenticated and you can start testing the more
advanced features. To do so, change the URL and append the possible API
actions to your request parameters. Please refer to the [original Fever
documentation](https://feedafever.com/api) for more information.

Some basic calls are:

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

Si rien n'aide et que vos clients se conduisent toujours mal, ajoutez ces
lignes à la début de `fever.api` :

```php
file_put_contents(__DIR__ . '/fever.log', $_SERVER['HTTP_USER_AGENT'] . ': ' . json_encode($_REQUEST) . PHP_EOL, FILE_APPEND);
```

Utilisez ensuite votre client RSS pour interroger l'API et ensuite vérifier
le fichier `fever.log`.

## Remerciements

Ce plugin a été inspiré par le
[tinytinyrss-fever-plugin](https://github.com/dasmurphy/tinytinyrss-fever-plugin).
