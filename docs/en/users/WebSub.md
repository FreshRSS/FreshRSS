# The WebSub protocol

[WebSub](https://www.w3.org/TR/websub/) (formerly [PubSubHubbub](https://github.com/pubsubhubbub/PubSubHubbub)) is a standard protocol
to instantly receive (push) notifications when some new content is available on a remote server,
for instance when a new article is available via RSS / ATOM.

FreshRSS supports WebSub natively.
Just like for the FreshRSS API to work from a mobile phone, supporting WebSub requires that your FreshRSS instance is routable (that is to say, with a public IP, that can be accessed from third-party servers).

## Examples of feeds

Many individual feeds and platforms already offer instant notifications through WebSub, such as:
[Friendica instances](https://friendi.ca), WordPress (from WordPress.com or with [an extension](https://wordpress.org/plugins/pubsubhubbub/)), Blogger sites, Medium sites, etc.

## Test WebSub

You can test that WebSub works properly in your FreshRSS instance with a service such as:

* <http://push-tester.cweiske.de>

## Add WebSub to your RSS / ATOM feeds

Your CMS (e.g. WordPress) might already offer WebSub as an option. Otherwise, you can make a solution that notifies a hub such as:

* <https://websubhub.com>
* <https://pubsubhubbub.appspot.com>
