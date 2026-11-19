# The WebSub protocol

[WebSub](https://www.w3.org/TR/websub/) (formerly [PubSubHubbub](https://github.com/pubsubhubbub/PubSubHubbub)) is a standard protocol
to instantly receive (push) notifications when some new content is available on a remote server,
for instance when a new article is available via RSS / ATOM.

FreshRSS supports WebSub natively.
Just like for the FreshRSS API to work from a mobile phone, supporting WebSub requires that your FreshRSS instance is routable (that is to say, with a public IP, that can be accessed from third-party servers).

## WebSub terminology

There are tree main concepts:

* **publisher**: Web site publishing content such as RSS / ATOM feeds;
* **subscriber**: Feed aggregator such as FreshRSS;
* **hub**: Intermediate technical component in charge of notifying all subscribers instantly when a publisher has some new content.
The same hub can serve several publishers and their subscribers.
Some publishers have a built-in hub.

## Enabling WebSub in FreshRSS

FreshRSS supports WebSub natively, but requires a public address (read from the `base_url` configuration),
and requires the `./FreshRSS/p/api/` folder to be publicly accessible (just like for other FreshRSS APIs).

During the initial Web-based setup, support for WebSub is enabled if the server hosting FreshRSS appears to have a public address.
In any case, check your `./data/config.php` for:

```php
'base_url' => 'https://freshrss.example.net/',
'pubsubhubbub_enabled' => true,
```

Additional logs about WebSub are available in `./FreshRSS/data/users/_/log_pshb.txt`

## Test WebSub compatibility of your FreshRSS instance

You can test that WebSub works properly in your FreshRSS instance with a service such as:

* <http://push-tester.cweiske.de>

When you create a new article, it should instantly be available in your FreshRSS instance.

## Examples of feeds using WebSub

Many individual feeds and platforms already offer instant notifications through WebSub, such as:
[Friendica instances](https://friendi.ca), WordPress (from WordPress.com or with [an extension](https://wordpress.org/plugins/pubsubhubbub/)), Blogger sites, Medium sites, etc.

## Test WebSub compatibility of an RSS / ATOM feed

* <https://test.livewire.io> (for any feed)
* <https://websub.rocks/publisher> (for feeds you control)

## Add WebSub to your RSS / ATOM feeds

Your CMS (e.g. WordPress) might already offer WebSub as an option, such as:

* <https://wordpress.org/plugins/pushpress/>

Otherwise, you can make a solution that notifies a hub, such as:

* <https://websubhub.com>
* <https://pubsubhubbub.appspot.com>

Or even deploy your own hub, such as:

* <https://github.com/flusio/Webubbub>

## Test WebSub compatibility of a hub

* <https://websub.rocks/hub/100>
