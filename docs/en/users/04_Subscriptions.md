# Adding a feed

 1. To add a feed, copy the URL of its RSS or Atom file (for instance, the Framablog RSS URL is `https://framablog.org/feed/`). FreshRSS is able to automatically find the address of the feed for websites that are declaring it in a standard way.
 2. On FreshRSS, click “Subscriptions management”.
 3. Paste the URL in “Add an RSS feed” below the page title.
 4. (optional): You can select the category for your feed. By default, it will be in “Uncategorized”.

# Feed management

You can manage your feeds within different categories. A feed cannot be in multiple categories.

 1. Open “Subscriptions management”.
 2. You can add a category:
    1. Type the name of your category in “New category”
    2. Click on “Submit”
 3. You can move a feed on the category you want with drag & drop
 4. (optional): If you want the articles of a feed to be visible solely within its category and not in the main view, in the “Visibility” option, select “Show in its category”.

# Subscription management

## Information

**TODO**

## Archival

**TODO**

## Login

**TODO**

## Advanced

### Retrieve a truncated stream from within FreshRSS

This question comes up regularly, so we'll try to clarify how one can retrieve a truncated RSS feed with FreshRSS. Please note that the process is absolutely not user friendly, but it works. :)

Please be aware that this way you'll generate much more traffic to the originating sites, and they might block you accordingly. FreshRSS performance is also negatively affected, because you'll have to fetch the full article content one by one. So it's a feature to use sparingly!

What's meant by "CSS path of articles on the original site" actually corresponds to the "path" consisting of IDs and classes (which in HTML, matches the id and class attributes) to retrieve only the interesting part that corresponds to the article. Ideally, this path starts with an id (which is unique to the page).

#### Example: Rue89

To find this path, you have to go to the address of one of the truncated articles (for example, http://www.rue89.com/2013/10/15/prof-maths-jai-atteint-lextase-dihn-pedagogie-inversee-246635). You look have to look for the "block" of HTML that corresponds to article content (in the source code!).

Here we find that the block that encompasses nothing but the content of the article is ```<div class="content clearfix">```. We'll only use the `.content` class here. Nevertheless, as said above, it's best to start the path with an id. If we go back to the parent block, we find ```<div id="article">``` and that's perfect! The path will be ```#article .content```.

#### Add the corresponding classes to the article CSS path on the feed configuration page. Examples:

*  Rue89: ```#article .content```
*  PCINpact: ```#actu_content```
*  Lesnumériques: ```article#body div.text.clearfix```
*  Phoronix: ```#main .content```

#### Combining CSS Classes
Let's say we have an article which contains ads within its content, and we do not want to have those ads retrieved by FreshRSS. Example Source Code:
```
<div id='article'>
<h2>wanted</h2>
<p class='content'>wanted content</p>
<p class='ad'>unwanted content</p>
<h2>wanted</h2>
<p class='content'>wanted content</p>
<h2>wanted</h2>
<p class='ad'>unwanted content</p>
<p class='content'>wanted content</p>
</div>
```
In this case it's possible to combine multiple CSS selectors with a comma: ```#article p.content, #article h2```

### Retrieve a truncated stream with external tools

Complimentary tools can be used to retrieve full article content, such as:

* [RSS-Bridge](https://github.com/RSS-Bridge/rss-bridge)
* [Full-Text RSS](https://bitbucket.org/fivefilters/full-text-rss)

# Import and export
See [SQLite export/import]( https://github.com/FreshRSS/FreshRSS/tree/master/cli) as an alternative.

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
> - [Pandoc](https://pandoc.org/) available for most systems,
> - [OPML generator](https://opml-gen.ovh/) available online,
> - [txt2opml](https://alterfiles.com/convert/txt/opml) available online.
  
# Use bookmarklet

Bookmarklets are little scripts that you can execute to perform various tasks. FreshRSS offers a bookmarklet for subscribing to newsfeeds.

 1. Open “Subscriptions management”.
 2. Click on “Subscription tools”.
 3. Drag the “Subscribe” button to your bookmark toolbar or right click and choose your browser’s “Bookmark link” action.

