# FreshRSS - Fever API implementation

See the [page about our Google Reader compatible API](06_Mobile_access.md) for another possibility
and general aspects of API access.

## RSS clients

There are many RSS clients existing supporting Fever APIs but they seem to understand the Fever API a bit differently.
If your favourite client does not work properly with this API, create an issue and we will have a look.
But we can **only** do that for free clients.

### Usage & Authentication

Before you can start to use this API, you have to enable and setup API access, which is [documented here](https://freshrss.github.io/FreshRSS/en/users/06_Mobile_access.html),
and then re-set the user’s API password.

Then point your mobile application to the URL of `fever.php` (e.g. `https://freshrss.example.net/api/fever.php`).

## Compatibility

Tested with:

- Android
  - [Readably](https://play.google.com/store/apps/details?id=com.isaiasmatewos.readably)

- iOS
  - [Fiery Feeds](https://itunes.apple.com/app/fiery-feeds-rss-reader/id1158763303)
  - [Unread](https://itunes.apple.com/app/unread-rss-reader/id1252376153)
  - [Reeder-3](https://itunes.apple.com/app/reeder-3/id697846300)

- MacOS
  - [Readkit](https://itunes.apple.com/app/readkit/id588726889)


## Features

Following features are implemented:

- fetching categories
- fetching feeds
- fetching RSS items (new, favorites, unread, by_id, by_feed, by_category, since)
- fetching favicons
- setting read marker for item(s)
- setting starred marker for item(s)
- setting read marker for feed
- setting read marker for category
- supports FreshRSS extensions, which use the `entry_before_display` hook

Following features are not supported:
- **Hot Links** aka **hot** as there is nothing in FreshRSS yet that is similar or could be used to simulate it

## Testing and error search

If this API does not work as expected in your RSS reader, you can test it manually with a tool like [Postman](https://www.getpostman.com/).

Configure a POST request to the URL https://freshrss.example.net/api/fever.php?api which should give you the result:
```json
{
	"api_version": 3,
	"auth": 0
}
```
Great, the base setup seems to work!

Now lets try an authenticated call. Fever uses an `api_key`, which is the MD5 hash of `"$username:$apiPassword"`.
Assuming the user is `kevin` and the password `freshrss`, here is a command-line example to compute the resulting `api_key`

```sh
api_key=`echo -n "kevin:freshrss" | md5sum | cut -d' ' -f1`
```

Add a body to your POST request encoded as `form-data` and one key named `api_key` with the value `your-password-hash`:

```sh
curl -s -F "api_key=$api_key" 'https://freshrss.example.net/api/fever.php?api'
```

This shoud give:
```json
{
	"api_version": 3,
	"auth": 1,
	"last_refreshed_on_time": "1520013061"
}
```
Perfect, you are authenticated and can now start testing the more advanced features. Therefor change the URL and append the possible API actions to your request parameters. Check the [original Fever documentation](https://feedafever.com/api) for more infos.

Some basic calls are:

- https://freshrss.example.net/api/fever.php?api&items
- https://freshrss.example.net/api/fever.php?api&feeds
- https://freshrss.example.net/api/fever.php?api&groups
- https://freshrss.example.net/api/fever.php?api&unread_item_ids
- https://freshrss.example.net/api/fever.php?api&saved_item_ids
- https://freshrss.example.net/api/fever.php?api&items&since_id=some_id
- https://freshrss.example.net/api/fever.php?api&items&max_id=some_id
- https://freshrss.example.net/api/fever.php?api&mark=item&as=read&id=some_id
- https://freshrss.example.net/api/fever.php?api&mark=item&as=unread&id=some_id

Replace `some_id` with a real ID from your `freshrss_username_entry` database.

### Debugging

If nothing helps and your clients still misbehaves, add these lines to the start of `fever.api`:

```php
file_put_contents(__DIR__ . '/fever.log', $_SERVER['HTTP_USER_AGENT'] . ': ' . json_encode($_REQUEST) . PHP_EOL, FILE_APPEND);
```

Then use your RSS client to query the API and afterwards check the file `fever.log`.

## Credits

This plugin was inspired by the [tinytinyrss-fever-plugin](https://github.com/dasmurphy/tinytinyrss-fever-plugin).
