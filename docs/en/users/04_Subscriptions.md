# Adding a feed

**TODO**

# Import and export

**TODO**

# Use bookmarklet

Bookmarklets are little scripts that you can execute to perform useful or frivolous tasks. FreshRSS offers a bookmarklet for subscribing to newsfeeds.

 1. Open "Subscriptions management".
 2. Click on "Subscription tools".
 3. Drag the "Subscribe" button to your bookmark toolbar or right click and choose your browser's "Bookmark link" action.

# Feed management

**TODO**

# Firefox subscription service

NB: From version 63 and onwards Firefox has removed the ability to add your own subscription services that aren't standalone programs. This makes it impossible to add FreshRSS to the feed preview/subscription page, though this page is set to be removed from version 64 anyway (see [bugzilla](https://bugzilla.mozilla.org/show_bug.cgi?id=1477667)). You can use the bookmarklet mentioned above for an easy way to subscribe to feeds.

If you're using a version pre-63 you can manually add your FreshRSS app to the list of Firefox subscription services, which enables you to subscribe to sites which provide a feed link using the Firefox built-in "Subscribe" button. An in-depth process is described in the [official documentation](https://developer.mozilla.org/en-US/Firefox/Releases/2/Adding_feed_readers_to_Firefox) but you can use the following steps:

  1. Open about:config in Firefox

  2. Search for "browser.contentHandlers.types." and note the highest number following the returned strings (ie if yo see browser.contentHandlers.types.1.something up to browser.contentHandlers.types.5.somethingelse etc. the highest number is 5). Your contentHandler will have to have a free number so just pick one higher than currently registered (you would chose six in above example).

  3. You will have to add three new strings to your about config (replace %NUMBER% with the number from previous step and example.com with your installation address):

  | Preference name                              | Value                                                      | Note                                                      |
  | -------------------------------------------- | ---------------------------------------------------------- | --------------------------------------------------------- |
  | browser.contentHandlers.types.%NUMBER%.title | **FreshRSS**                                               | Use any name you would like (ie. "My feeds")              |
  | browser.contentHandlers.types.%NUMBER%.type  | **application/vnd.mozilla.maybe.feed**                     | Do not change this value!                                 |
  | browser.contentHandlers.types.%NUMBER%.uri   | **http://EXAMPLE.COM/FreshRss/i?c=feed&a=add&url_rss=%s** | Replace base url with yours and switch to https (if used) |

  4. Restart Firefox and you can subscribe to sites with the Firefox built-in "Subscribe" button. Just select the name you set under the first Preference name from the dropdown (you can also make it default with the checbox) and you will be redirected to FreshRSS subscription settings (you must be logged in).
