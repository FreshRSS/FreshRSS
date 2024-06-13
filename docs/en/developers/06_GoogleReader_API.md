# FreshRSS - Google Reader compatible API implementation

See [Mobile access](../users/06_Mobile_access.md) for general aspects of API access.

See also the [page about our Fever compatible API](06_Fever_API.md) for another possibility (less powerful).

## RSS clients

There are many RSS clients that support the Fever API, but they might understand the API a bit differently.
If your favourite client doesn’t work properly with this API, please create an issue and we’ll have a look.
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
|[News+](https://github.com/noinnion/newsplus/blob/master/apk/NewsPlus_202.apk) with [News+ Google Reader extension](https://github.com/noinnion/newsplus/blob/master/apk/GoogleReaderCloneExtension_101.apk) |Android|Closed Source (Free), [partially open source](https://github.com/noinnion/newsplus/blob/master/extensions/GoogleReaderCloneExtension/src/com/noinnion/android/newsplus/extension/google_reader/GoogleReaderClient.java)|
|[FeedMe 3.5.3+](https://play.google.com/store/apps/details?id=com.seazon.feedme) |Android                  |Closed Source (Free)                                             |
|[EasyRSS](https://github.com/Alkarex/EasyRSS)                          |Android                |[GPLv3](https://github.com/Alkarex/EasyRSS/blob/master/license.txt) ([F-Droid](https://f-droid.org/packages/org.freshrss.easyrss/))|
|[Readrops](https://github.com/readrops/Readrops) |Android                  |[GPLv3](https://github.com/readrops/Readrops/blob/develop/LICENSE)                                             |
|[Fluent Reader Lite](https://hyliu.me/fluent-reader-lite/) |Android, iOS            |[BSD-3](https://github.com/yang991178/fluent-reader-lite)                                             |
|[Read You](https://github.com/Ashinch/ReadYou/)                                     |Android              |[GPLv3](https://github.com/Ashinch/ReadYou/blob/main/LICENSE)|
|[FocusReader](https://play.google.com/store/apps/details?id=allen.town.focus.reader) |Android                  |Closed Source(Free)                                              |
|[Newsflash](https://gitlab.com/news-flash/news_flash_gtk/)                          |Linux                |[GPLv3](https://gitlab.com/news-flash/news_flash_gtk/) |
|[lire](https://lireapp.com/)                                                        |iOS, macOS           |Closed Source                                             |
|[Newsboat 2.24+](https://newsboat.org/)                           |Linux                |[MIT](https://github.com/newsboat/newsboat/blob/master/LICENSE)                                              |
|[Vienna RSS](http://www.vienna-rss.com/)                           |macOS                |[Apache-2.0](https://github.com/ViennaRSS/vienna-rss/blob/master/LICENCE.md)                                              |
|[Reeder](https://www.reederapp.com/)                           |macOS, iOS                |Closed Source                                              |
|[FreshRSS-Notify](https://addons.mozilla.org/firefox/addon/freshrss-notify-webextension/)                           |Firefox                |Open Source                                              |

> ℹ️ See a [better table of compatible clients in our main Readme](https://github.com/FreshRSS/FreshRSS/blob/edge/README.md#apis--native-apps).

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

# Unsubscribe from a feed
curl -H "Authorization:GoogleLogin auth=alice/8e6845e089457af25303abc6f53356eb60bdb5f8" \
  -d 'ac=unsubscribe&s=feed/52' 'https://freshrss.example.net/api/greader.php/reader/api/0/subscription/edit'
```

* [Source code of our API implementation](https://github.com/FreshRSS/FreshRSS/blob/edge/p/api/greader.php)

### API documentation from the original Google Reader

* [By Daniel Arowser](https://web.archive.org/web/20130710044440/http://undoc.in/api.html) ([source](https://github.com/arowser/google-reader-api))
* [By Martin Doms](https://web.archive.org/web/20210126115837/https://blog.martindoms.com/2009/10/16/using-the-google-reader-api-part-2/)
* [By Nick Bradbury](https://inessential.com/2013/03/14/google_reader_api_documentation)
* [By Niall Kennedy](https://web.archive.org/web/20170426184845/http://www.niallkennedy.com/blog/2005/12/google-reader-api.html)
* [By Mihai Parparita](https://web.archive.org/web/20140919042419/http://code.google.com/p/google-reader-api/w/list) ([source](https://github.com/mihaip/google-reader-api))

### API documentation from other compatible servers

* [FeedHQ](https://feedhq.readthedocs.io/en/latest/api/index.html)
* [Inoreader](https://www.inoreader.com/developers/)
* [The Old Reader](https://github.com/theoldreader/api)
* [pyrfeed](http://code.google.com/p/pyrfeed/wiki/GoogleReaderAPI)
* [BazQux](https://github.com/bazqux/bazqux-api)

### Synchronisation strategy

> ℹ️ If you are maintaining a client or planning to develop a new one, please read carefully the following pieces of advice,
as many clients start by having a very inneficient synchronisation strategy.

* [*Synchronisation recommendation* by Alkarex](https://github.com/FreshRSS/FreshRSS/issues/2566#issuecomment-541317776)
* [*The Right Way to Sync* by BazQux](https://github.com/bazqux/bazqux-api#user-content-the-right-way-to-sync)
