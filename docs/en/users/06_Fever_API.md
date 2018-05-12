# FreshRSS - Fever API implementation

## RSS clients

There are many RSS clients existing supporting Fever APIs but they seem to understand the Fever API a bit differently.
If your favorite client doesn't work properly with this API, create an issue and we will have a look.
But we can **only** do that for free clients.

### Usage & Authentication

Before you can start to use this API, you have to enable and setup API access, which is [documented here](https://freshrss.github.io/FreshRSS/en/users/06_Mobile_access.html),
and then re-set the user’s API password.

Then point your mobile application to the URL of `fever.php` (e.g. `http://freshrss.example.net/api/fever.php`).

Special client implementation:
- The Press Android client needs (tested with 1.5.4) needs the additional file `fever-press.php` (use that file as endpoint in the Fever account setting)

## Compatibility

Tested with:

- iOS
  - [Fiery Feeds](https://itunes.apple.com/app/fiery-feeds-rss-reader/id1158763303)
  - [Unread](https://itunes.apple.com/app/unread-rss-reader/id1252376153)

MacOS:
  - [Readkit](https://itunes.apple.com/app/readkit/id588726889?ls=1&mt=12)

- Android
  - Press 1.5.4 (not available via PlayStore, but APK can still be found)

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
- **hot** is not supported as there is nothing in FreshRSS that is similar

### Limitations

- Does currently not support FreshRSS extensions (if they load additional content before displaying it - like the Youtube extension)

## Testing and error search

If this API doesn't work as expected in your RSS reader, you can test it manually with a tool like [Postman](https://www.getpostman.com/).

Configure a POST request to the URL http://freshrss.example.net/api/fever.php?api which  should give you the result:
```
{
    "api_version": 3,
    "auth": 0
}
```
Great, the base setup seems to work!

Now lets try an authenticated call, so add a body to your POST request encoded as `form-data` and one key named `api_key` with the value `your-password-hash`, that should give you:
```
{
    "api_version": 3,
    "auth": 1,                               <= 1 means you were successfully authenticated
    "last_refreshed_on_time": "1520013061"   <= depends on your installation
}
```
Perfect, you are authenticated and can now start testing the more advanced features. Therefor change the URL and append the possible API actions to your request parameters. Check the [original Fever documentation](https://feedafever.com/api) for more infos.

Some basic calls are:

- http://freshrss.example.net/api/fever.php?api&items
- http://freshrss.example.net/api/fever.php?api&feeds
- http://freshrss.example.net/api/fever.php?api&groups
- http://freshrss.example.net/api/fever.php?api&unread_item_ids
- http://freshrss.example.net/api/fever.php?api&saved_item_ids
- http://freshrss.example.net/api/fever.php?api&items&since_id=some_id
- http://freshrss.example.net/api/fever.php?api&items&max_id=some_id
- http://freshrss.example.net/api/fever.php?api&mark=item&as=read&id=some_id
- http://freshrss.example.net/api/fever.php?api&mark=item&as=unread&id=some_id

Replace `some_id` with a real ID from your `freshrss_username_entry` database.

### Debugging

If nothing helps and your clients still misbehaves, add these lines to the start of `fever.api`:

```php
file_put_contents(__DIR__ . '/fever.log', $_SERVER['HTTP_USER_AGENT'] . ': ' . json_encode($_REQUEST) . PHP_EOL, FILE_APPEND);
```

Then use your RSS client to query the API and afterwards check the file `fever.log`.

## Credits

This plugin was inspired by the [tinytinyrss-fever-plugin](https://github.com/dasmurphy/tinytinyrss-fever-plugin).
