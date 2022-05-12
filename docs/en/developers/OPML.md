# OPML in FreshRSS

FreshRSS supports the [OPML](https://en.wikipedia.org/wiki/OPML) format to export and import lists of RSS/Atom feeds in a standard way, compatible with several other RSS aggregators.

However, FreshRSS also supports several additional features not covered by the basic OPML specification.
Luckily, the [OPML specification](http://opml.org/spec2.opml) allows extensions:

> *An OPML file may contain elements and attributes not described on this page, only if those elements are defined in a namespace.*

and:

> *OPML can also be extended by the addition of new values for the type attribute.*

## FreshRSS OPML extension

FreshRSS uses the XML namespace <https://freshrss.org/opml> to export/import extended information not covered by the basic OPML specification.

The list of the custom FreshRSS attributes can be seen in [the source code](https://github.com/FreshRSS/FreshRSS/blob/edge/app/views/helpers/export/opml.phtml), and here is an overview:

### HTML+XPath

* `<outline type="HTML+XPath" ...`: Additional type of source, which is not RSS/Atom, but HTML Web Scraping using [XPath](https://www.w3.org/TR/xpath-10/) 1.0.

> ℹ️ [XPath 1.0](https://en.wikipedia.org/wiki/XPath) is a standard query language, which FreshRSS supports to enable [Web scraping](https://en.wikipedia.org/wiki/Web_scraping).

The following attributes are using similar naming conventions than [RSS-Bridge](https://rss-bridge.github.io/rss-bridge/Bridge_API/XPathAbstract.html).

* `frss:xPathItem`: XPath expression for extracting the feed items from the source page.
	* Example: `//div[@class="news-item"]`
* `frss:xPathItemTitle`: XPath expression for extracting the feed title from the source page.
	* Example: `descendant::h2`
* `frss:xPathItemContent`: XPath expression for extracting an item’s content from the item context.
	* Example: `.`
* `frss:xPathItemUri`: XPath expression for extracting an item link from the item context.
	* Example: `descendant::a/@href`
* `frss:xPathItemAuthor`: XPath expression for extracting an item author from the item context.
	* Example: `"Anonymous"`
* `frss:xPathItemTimestamp`: XPath expression for extracting an item timestamp from the item context. The result will be parsed by [`strtotime()`](https://php.net/strtotime).
* `frss:xPathItemThumbnail`: XPath expression for extracting an item’s thumbnail (image) URL from the item context.
	* Example: `descendant::img/@src`
* `frss:xPathItemCategories`: XPath expression for extracting a list of categories (tags) from the item context.

### Miscellaneous

* `frss:cssFullContent`: [CSS Selector](https://developer.mozilla.org/en-US/docs/Web/CSS/CSS_Selectors) to enable the download and extraction of the matching HTML section of each articles’ Web address.
	* Example: `div.main`
* `frss:filtersActionRead`: List (separated by a new line) of search queries to automatically mark a new article as read.

### Example

```xml
<?xml version="1.0" encoding="UTF-8"?>
<opml version="2.0">
	<head>
		<title>FreshRSS OPML extension example</title>
	</head>
	<body>
		<outline xmlns:frss="https://freshrss.org/opml"
			text="Example"
			type="HTML+XPath"
			xmlUrl="https://www.example.net/page.html"
			htmlUrl="https://www.example.net/page.html"
			description="Example of Web scraping"
			frss:xPathItem="//a[contains(@href, '/interesting/')]/ancestor::article"
			frss:xPathItemTitle="descendant::h2"
			frss:xPathItemContent="."
			frss:xPathItemUri="descendant::a[string-length(@href)&gt;0]/@href"
			frss:xPathItemThumbnail="descendant::img/@src"
			frss:cssFullContent="article"
			frss:filtersActionRead="intitle:⚡️ OR intitle:🔥&#10;something"
		/>
	</body>
</opml>
```
