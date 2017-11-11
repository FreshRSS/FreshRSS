# Server configuration

See the [section about server setup](01_Installation.md).
In particular, for Apache, remember the directive [`AllowEncodedSlashes On`](http://httpd.apache.org/docs/trunk/mod/core.html#allowencodedslashes),
for the best compatibility with clients (such as News+, but not needed for EasyRSS).

# Enable the API in FreshRSS


# Testing


# Compatible clients

Any client supporting a Google Reader-like API. Selection:

* Android
	* [News+](https://play.google.com/store/apps/details?id=com.noinnion.android.newsplus) with [News+ Google Reader extension](https://play.google.com/store/apps/details?id=com.noinnion.android.newsplus.extension.google_reader) (Closed source)
	* [EasyRSS](https://github.com/Alkarex/EasyRSS) (Open source, F-Droid)
* Linux
	* [FeedReader 2.0+](https://jangernert.github.io/FeedReader/) (Open source)
