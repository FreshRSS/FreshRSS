# FreshRSS - Fever API implementation

## RSS clients

There are many RSS clients existing supporting Fever APIs but they seem to understand the Fever API a bit differently. 
If your favorite client doesn't work properly with this API, create an issue and we will have a look. 
But we can ONLY do that for free clients, as we are am not willing to buy any RSS client. 

### Usage & Authentication

Before you can start to use this API you have to enable and setup API access, which is [documented here](https://freshrss.github.io/FreshRSS/en/users/06_Mobile_access.html).

Please point your application to the URL of `fever.php` (e.g. `http://your-freshrss-url/api/fever.php`).

Special client implementation:
- The Press Android client needs (tested with 1.5.4) needs the additional file `fever-press.php` (use that file as endpoint in the Fever account setting)

There is a drawback when using this plugin: the username and password combination that you have to use.
You have to set the API password as **lowercased** md5 sum from the string 'username:password' (this limitation exists, because the Fever API was designed in a way which is incompatible with the authentication system used by FreshRSS).

So if you use **kevin** as username and **freshrss** as password you have to set your FreshRSS API password to **4a6911fb47a87a77f4de285f4fac856d** (it MUST be lowercased, some tools seem to create it in uppercase which will not work!).

You can create the hash like this:
```bash
$ md5 -s "kevin:freshrss"
MD5 ("kevin:freshrss") = 4a6911fb47a87a77f4de285f4fac856d
```
You can also use online tools for calculating ypu API password hash if you don't have a md5 binary available.

In your favorite RSS reader you configure `fever.php`* as endpoint, **kevin** as username and **freshrss** as password.  

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

Configure a POST request to the URL http://your-freshrss-url/api/fever.php?api which  should give you the result:
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

- http://your-freshrss-url/api/fever.php?api&items
- http://your-freshrss-url/api/fever.php?api&feeds
- http://your-freshrss-url/api/fever.php?api&groups
- http://your-freshrss-url/api/fever.php?api&unread_item_ids
- http://your-freshrss-url/api/fever.php?api&saved_item_ids
- http://your-freshrss-url/api/fever.php?api&items&since_id=some_id
- http://your-freshrss-url/api/fever.php?api&items&max_id=some_id
- http://your-freshrss-url/api/fever.php?api&mark=item&as=read&id=some_id
- http://your-freshrss-url/api/fever.php?api&mark=item&as=unread&id=some_id

Replace `some_id` with a real ID from your `freshrss_username_entry` database.

### Debugging

If nothing helps and your clients still misbehaves, add these lines to the start of `fever.api`:

```php
file_put_contents(__DIR__ . '/fever.log', $_SERVER['HTTP_USER_AGENT'] . ': ' . json_encode($_REQUEST) . PHP_EOL, FILE_APPEND);
```

Then use your RSS client to query the API and afterwards check the file `fever.log`.

## Credits

This plugin was inspired by the [tinytinyrss-fever-plugin](https://github.com/dasmurphy/tinytinyrss-fever-plugin).
Thanks to @dasmurphy for sharing it!
