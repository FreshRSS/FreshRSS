# Website scraping

FreshRSS has a built-in [Web scraping](https://en.wikipedia.org/wiki/Web_scraping) engine that generates a feed from websites that have no RSS/Atom feed published.

## How to add

Go to “Subscription Management” where a new feed can be added.
Change the “Type of feed source” to “HTML + XPath (Web scraping)”.
An additional list of text boxes to configure the web scraping.
[XPath 1.0](https://www.w3.org/TR/xpath-10/) is used as traversing language.

### Get the XPath path

Firefox: the built-in “inspect” tool may be used to help create a valid XPath expression.
Select the node in the HTML, right click with your mouse and chose “Copy” and “XPath”.
The XPath is stored in your clipboard now.

## Tips & tricks

- [Timezone of date](https://github.com/FreshRSS/FreshRSS/discussions/5483)

## Recommended external manuals

- [XPath Scraping with FreshRSS, by Dan Q](https://danq.me/2022/09/27/freshrss-xpath/) (September 2022)
