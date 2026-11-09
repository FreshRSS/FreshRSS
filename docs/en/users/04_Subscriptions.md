# Adding a feed

1. To add a feed, copy the URL of its RSS or Atom file (for instance, the Framablog RSS URL is `https://framablog.org/feed/`). FreshRSS is able to automatically find the address of the feed for websites that are declaring it in a standard way.
2. In FreshRSS, click the "**+**" button next to “Subscriptions management”.
3. Paste the URL in the “Feed URL” field.
4. (optional): You can select the category for your feed. By default, it will be in “Uncategorized”.
5. (optional): If the subscription requires credentials, you can enter them in the "HTTP username" and "HTTP password" fields.
6. (optional): You can set a timeout for the feed request.
7. (optional): You can choose to ignore SSL certificate errors (such as with self-signed certificates) by setting "Verify SSL security" to "No". This is not recommended, and it is better to either add the root certificate to the FreshRSS server or to fix the SSL certificate problems on the feed hosting server.

## Subscription management

The "Subscription management" submenu allows categories and feeds to be configured. Feeds can be moved between categories by drag-and-drop, or in the individual feed’s settings. Hovering over a feed/category will cause a gear icon to appear. Clicking the icon will bring up the settings for that item.

## Category Settings

### Information

* **Title:** Name of category
* **Display position:** Defines the order of categories. Lower numbers get priority, non-numbered items come last, and equally numbered items will sort by alphabetical order.

### Archiving

If “Purge Policy” has “By default” selected, then the [default purge policy](./05_Configuration.md#archiving) is used and the other options are not displayed. Category options will override the default policy, but they will not override feed-specific options.

See [Archiving](./05_Configuration.md#archiving) for important details on when and how purging actually happens (it is not applied on every refresh, and it is based on the discovery date of articles, not their published date).

## Feed Settings

These fields will be auto-filled when adding a feed, but they can be modified later. **Visibility** will define if the feed is displayed in the main feed, only in specific categories, or not at all.

### Archival

This section will let you override the default settings for feed archiving and update frequency. When “By default” is selected here, the feed uses its category’s purge policy, falling back to the [global default](./05_Configuration.md#archiving) if the category also uses the default.

### Login

Some feeds require a username/password submitted over HTTP. These usually aren’t needed for feeds.

### Advanced

#### Retrieve a truncated feed from within FreshRSS

This question comes up regularly, so we’ll try to clarify how one can retrieve a truncated RSS feed with FreshRSS. Please note that the process is absolutely not user friendly, but it works. :)

Please be aware that this way you’ll generate much more traffic to the originating sites, and they might block you accordingly. FreshRSS performance is also negatively affected, because you’ll have to fetch the full article content one by one. So it’s a feature to use sparingly!

The options are in the “Content retrieval” and “Advanced” sections of the feed settings.
The main one, “Article CSS selector on original website”, is a [CSS selector](https://developer.mozilla.org/docs/Learn_web_development/Core/Styling_basics/Basic_selectors) matching the part of the article’s web page to retrieve.

##### Finding the CSS selector

1. Open one of the truncated articles in your browser.
2. Look at the source of the page (for instance with “View Page Source”).
	FreshRSS does not run JavaScript, so content added to the page by JavaScript is not available to FreshRSS.
3. Find the HTML element that contains the text of the article, and nothing else from the page.
	If the element is too large (for instance one that also contains the menu, the comments, or the whole page), all of that will be retrieved as well.
4. Write a CSS selector for this element, using its `id` or `class` attributes: `#main` matches `id="main"`, and `.entry-content` matches `class="entry-content"` (do not forget the leading `#` or `.`).
	Use an id or class that all the articles of the website have in common, not one that is specific to a single article (such as `#post-1234`).
5. Write the selector in “Article CSS selector on original website”, and click the preview button next to the field to check the result.
	The preview uses one of the articles already in the feed, and also applies “CSS selector of the elements to remove”.
6. Submit the form.

For instance, with the following web page:

```html
<body>
<nav>…</nav>
<div id="main">
	<article>
		<h1>Title of the article</h1>
		<div class="entry-content">
			<p>Text of the article…</p>
		</div>
		<div class="comments">…</div>
	</article>
</div>
<footer>…</footer>
</body>
```

The selector `#main .entry-content` retrieves only the text of the article.
The selector `article` would also retrieve the title (which FreshRSS already shows) and the comments.

##### How the retrieved content is used

* All the elements matching the selector are retrieved.
* The content is only retrieved for new articles, and for articles that are updated in the feed.
	To apply a new selector to the articles that are already in FreshRSS, submit the form first, then use “Reload articles” in the “Maintenance” section of the feed settings: it reloads as many of the most recent articles as the number entered next to the button (10 by default).
* By default, the retrieved content replaces the content of the feed.
	It can instead be added before or after it with “Content action when fetching the article content” in the “Advanced” section.
* “Conditions for content retrieval” restricts the retrieval to the articles matching at least one of the [search filters](./10_filter.md) (one per line).
	When empty, the content is retrieved for all the articles.
* When the selector does not match anything, the article keeps its current content (the content of the feed for a new article), and a warning is written in the logs.
* Like the content of the feeds, the retrieved content is sanitized: for instance, scripts are removed, and the `id` and `class` attributes are renamed `data-sanitized-id` and `data-sanitized-class`.
* Some websites show the full article only when some cookies are sent (such as a consent cookie), or only to some browsers.
	See “Use Cookies when fetching the article content” and “Set the user agent for fetching this feed” in the “Advanced” section.

##### Removing unwanted parts

Let’s say we have an article which contains ads, and we do not want to have those ads retrieved by FreshRSS. Example HTML:

```html
<div id="article">
<h2>wanted</h2>
<p class="content">wanted content</p>
<p class="ad">unwanted content</p>
<h2>wanted</h2>
<p class="content">wanted content</p>
<h2>wanted</h2>
<p class="ad">unwanted content</p>
<p class="content">wanted content</p>
</div>
```

In this case it’s possible to combine multiple CSS selectors with a comma: ```#article p.content, #article h2```

Alternatively, keep `#article` as the article CSS selector, and write `.ad` in “CSS selector of the elements to remove” in the “Advanced” section.

“CSS selector of the elements to remove” also works without an article CSS selector, to clean up the content provided by the feed itself.
Since this content is already sanitized, match its classes with `[data-sanitized-class~="ad"]` instead of `.ad`.

#### Retrieve a truncated feed with external tools

Complementary tools can be used to retrieve full article content, such as:

* [RSS-Bridge](https://github.com/RSS-Bridge/rss-bridge)
* [Full-Text RSS](https://bitbucket.org/fivefilters/full-text-rss)

### Filter

Articles can be automatically marked as read based on some search terms. See [filtering](./10_filter.md) for more information on how to create these filters.

## Import / export

See [SQLite export/import]( https://github.com/FreshRSS/FreshRSS/tree/edge/cli) as an alternative.

## Export

1. To export your list of feeds, go to “Subscriptions management”.
2. Click on “Import / export”
3. You can select for your export:
	1. the list of feeds
	2. labelled articles
	3. favourite articles
	4. and finally, you can select feeds you want to export (by default, all feeds are selected)
4. Click on “export”.

## Import

1. Go to the page “Import / export”.
2. Click on “Browse” and select your OPML or archive file on your computer.
3. Click on “Import”

> **Important**: you can not import directly a list of feeds from a text file.
> You need to convert it beforehand to _OPML_.
> Here is some tools you could use :
>
> * [Pandoc](https://pandoc.org/) available for most systems,
> * [opmlmaker](https://rssgizmos.com/opmlmaker.html) available online.

### Migrating from TT-RSS

The [TT-RSS exporter](https://github.com/robertdahlem/export_ttrss) converts
articles from Tiny Tiny RSS into JSON files that FreshRSS can import. It keeps
read and starred states and can create missing feeds and categories during the
import.

## Use bookmarklet

Bookmarklets are little scripts that you can execute to perform various tasks. FreshRSS offers a bookmarklet for subscribing to newsfeeds.

1. Open “Subscriptions management”.
2. Click on “Subscription tools”.
3. Drag the “Subscribe” button to your bookmark toolbar or right click and choose your browser’s “Bookmark link” action.
