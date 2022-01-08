# FreshRSS - Fever API implementation

See [Mobile access](../users/06_Mobile_access.md) for general aspects of API access.
Additionally [page about our Google Reader compatible API](06_GoogleReader_API.md) for another possibility.


## RSS clients

There are many RSS clients that support the Fever API, but they seem to understand the Fever API a bit differently.
If your favourite client doesn’t work properly with this API, please create an issue and we will have a look.
But we can **only** do that for free clients.

### Usage & Authentication

Before you can start using this API, you have to enable and setup API access, which is [documented here](../users/06_Mobile_access.md),
and then reset the user’s API password.

Then point your mobile application to the `fever.php` address (e.g. `https://freshrss.example.net/api/fever.php`).

## Compatible clients

| App                                                                                | Platform            | License                                            |
|:----------------------------------------------------------------------------------:|:-------------------:|:--------------------------------------------------------:|
|[Fluent Reader](https://hyliu.me/fluent-reader/)                                    |Windows, Linux, macOS|[BSD-3-Clause](https://github.com/yang991178/fluent-reader/blob/master/LICENSE)|
|[Fiery Feeds](https://apps.apple.com/app/fiery-feeds-rss-reader/id1158763303)       |iOS                  |Closed Source                                             |
|[Newsflash](https://gitlab.com/news-flash/news_flash_gtk/)                          |Linux                |[GPLv3](https://gitlab.com/news-flash/news_flash_gtk/-/blob/master/LICENSE)|
|[Unread](https://apps.apple.com/app/unread-rss-reader/id1252376153)                 |iOS                  |Closed Source                                             |
|[Reeder](https://www.reederapp.com/)                                                |iOS                  |Closed Source                                              |
|[ReadKit](https://apps.apple.com/app/readkit/id588726889)                           |macOS                |Closed Source                                              |

## Features

The following features are implemented:

* fetching categories
* fetching feeds
* fetching RSS items (new, favorites, unread, by_id, by_feed, by_category, since)
* fetching favicons
* setting read marker for item(s)
* setting starred marker for item(s)
* setting read marker for feed
* setting read marker for category
* supports FreshRSS extensions, which use the `entry_before_display` hook

The following features are not supported:

* **Hot Links** aka **hot** as there is nothing in FreshRSS yet that is similar or could be used to simulate it.

## Testing and debugging

If this API does not work as expected in your RSS reader, you can test it manually with a tool like [Postman](https://www.getpostman.com/).

Configure a POST request to the URL <https://freshrss.example.net/api/fever.php?api> which should give you the result:
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

This should give:
```json
{
	"api_version": 3,
	"auth": 1,
	"last_refreshed_on_time": "1520013061"
}
```
Perfect, you’re now authenticated and you can start testing the more advanced features. To do so, change the URL and append the possible API actions to your request parameters. Please refer to the [original Fever documentation](https://feedafever.com/api) for more information.

Some basic calls are:

* <https://freshrss.example.net/api/fever.php?api&items>
* <https://freshrss.example.net/api/fever.php?api&feeds>
* <https://freshrss.example.net/api/fever.php?api&groups>
* <https://freshrss.example.net/api/fever.php?api&unread_item_ids>
* <https://freshrss.example.net/api/fever.php?api&saved_item_ids>
* <https://freshrss.example.net/api/fever.php?api&items&since_id=some_id>
* <https://freshrss.example.net/api/fever.php?api&items&max_id=some_id>
* <https://freshrss.example.net/api/fever.php?api&mark=item&as=read&id=some_id>
* <https://freshrss.example.net/api/fever.php?api&mark=item&as=unread&id=some_id>

Replace `some_id` with a real ID from your `freshrss_username_entry` database.

### Debugging

If nothing helps and your client is still misbehaving, you can add the following lines to the beginning of the `fever.api` file to determine the cause of the problems:

```php
file_put_contents(__DIR__ . '/fever.log', $_SERVER['HTTP_USER_AGENT'] . ': ' . json_encode($_REQUEST) . PHP_EOL, FILE_APPEND);
```

Then use your RSS client to query the API and afterwards check the file `fever.log`.

## Credits

This plugin was inspired by the [tinytinyrss-fever-plugin](https://github.com/dasmurphy/tinytinyrss-fever-plugin).
