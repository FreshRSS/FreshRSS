# FreshRSS - Google Reader compatible API implementation

See [Mobile access](../users/06_Mobile_access.md) for general aspects of API access.
Additionally [page about our Fever compatible API](06_Fever_API.md) for another possibility.

## RSS clients

There are many RSS clients that support the Fever API, but they might understand the API a bit differently.
If your favourite client does not work properly with this API, please create an issue and we will have a look.
But we can **only** do that for free clients.

## Usage & Authentication

Before you can start using this API, you have to enable and setup API access, which is [documented here](../users/06_Mobile_access.md),
and then reset the user’s API password.

Then point your mobile application to the `greader.php` address (e.g. `https://freshrss.example.net/api/greader.php`).

## Compatible clients

1. On the same FreshRSS API page, note the address given under “Your API address”, like `https://freshrss.example.net/api/greader.php`
2. Type the API address in a client, together with your FreshRSS username, and the corresponding special API password.

| App                                                                                | Platform            | License                                            |
|:----------------------------------------------------------------------------------:|:-------------------:|:--------------------------------------------------------:|
|[News+](https://play.google.com/store/apps/details?id=com.noinnion.android.newsplus) with [News+ Google Reader extension](https://github.com/noinnion/newsplus/blob/master/apk/GoogleReaderCloneExtension_101.apk) |Android|Closed Source (Free)|
|[FeedMe 3.5.3+](https://play.google.com/store/apps/details?id=com.seazon.feedme) |Android                  |Closed Source (Free)                                             |
|[EasyRSS](https://github.com/Alkarex/EasyRSS)                          |Android                |[GPLv3](https://github.com/Alkarex/EasyRSS/blob/master/license.txt) ([F-Droid](https://f-droid.org/packages/org.freshrss.easyrss/))|
|[Readrops](https://github.com/readrops/Readrops) |Android                  |[GPLv3](https://github.com/readrops/Readrops/blob/develop/LICENSE)                                             |
|[FocusReader](https://play.google.com/store/apps/details?id=allen.town.focus.reader) |Android                  |Closed Source(Free)                                              |
|[FeedReader 2.0+](https://jangernert.github.io/FeedReader/)                           |Linux                |[GPLv3](https://github.com/jangernert/FeedReader/blob/master/LICENSE)                                              |
|[Newsboat 2.24+](https://newsboat.org/)                           |Linux                |[MIT](https://github.com/newsboat/newsboat/blob/master/LICENSE)                                              |
|[Vienna RSS](http://www.vienna-rss.com/)                           |MacOS                |[Apache-2.0](https://github.com/ViennaRSS/vienna-rss/blob/master/LICENCE.md)                                              |
|[Reeder](https://www.reederapp.com/)                           |MacOS, iOS                |Closed Source                                              |
|[FreshRSS-Notify](https://addons.mozilla.org/firefox/addon/freshrss-notify-webextension/)                           |Firefox                |Open Source                                              |

## Google Reader compatible API

Examples of basic queries:

```sh
# Initial login, using API password (Email and Passwd can be given either as GET, or POST - better)
curl 'https://freshrss.example.net/api/greader.php/accounts/ClientLogin?Email=alice&Passwd=Abcdef123456'
SID=alice/8e6845e089457af25303abc6f53356eb60bdb5f8
Auth=alice/8e6845e089457af25303abc6f53356eb60bdb5f8

# Examples of read-only requests
curl -s -H "Authorization:GoogleLogin auth=alice/8e6845e089457af25303abc6f53356eb60bdb5f8" \
  'https://freshrss.example.net/api/greader.php/reader/api/0/subscription/list?output=json'

curl -s -H "Authorization:GoogleLogin auth=alice/8e6845e089457af25303abc6f53356eb60bdb5f8" \
  'https://freshrss.example.net/api/greader.php/reader/api/0/unread-count?output=json'

curl -s -H "Authorization:GoogleLogin auth=alice/8e6845e089457af25303abc6f53356eb60bdb5f8" \
  'https://freshrss.example.net/api/greader.php/reader/api/0/tag/list?output=json'

# Retrieve a token for requests making modifications
curl -H "Authorization:GoogleLogin auth=alice/8e6845e089457af25303abc6f53356eb60bdb5f8" \
  'https://freshrss.example.net/api/greader.php/reader/api/0/token'
8e6845e089457af25303abc6f53356eb60bdb5f8ZZZZZZZZZZZZZZZZZ

# Get articles, piped to jq for easier JSON reading
curl -s -H "Authorization:GoogleLogin auth=alice/8e6845e089457af25303abc6f53356eb60bdb5f8" \
  'https://freshrss.example.net/api/greader.php/reader/api/0/stream/contents/reading-list' | jq .
```
