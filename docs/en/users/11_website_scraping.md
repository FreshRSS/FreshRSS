# Website scraping

FreshRSS has a built-in scraping engine that generates a feed on websites that has no RSS/Atom feed published.

## How to Add

Go to Subscription Management where a new feed can be added. Change the "Type of feed source" to "HTML + XPath (Web scrapping)". An additonal list of text boxes to configure the web scraping. XPath 1.0 is used as traversing language.

### Get the XPath Path

Firefox: use the built-in "inspect" tool. Select the node in the HTML, right click with your mouse and chose "Copy" and "Xpath". The XPath is stored in your clipboard now.

## Tipps and Tricks

- [Timezone of date](https://github.com/FreshRSS/FreshRSS/discussions/5483)

## Recommended External Manuals

- [https://danq.me/2022/09/27/freshrss-xpath/](https://danq.me/2022/09/27/freshrss-xpath/) (published September 2022)
