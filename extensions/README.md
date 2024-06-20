# FreshRSS extensions

This repository contains all the official [FreshRSS](https://github.com/FreshRSS/FreshRSS) extensions.

To install an extension, download [the extension archive](https://github.com/FreshRSS/Extensions/archive/master.zip) first and extract it on your PC.
Then, upload the specific extension(s) you want on your server.
Extensions must be in the `./extensions` directory of your FreshRSS installation.

## Commands for developers

```sh
# Test this repository and its extensions
make test-all

# Test compatibility between `../FreshRSS/` core and all known extensions from `./repositories.json`
./generate.php
composer run-script phpstan-third-party
```

## Third-party extensions

There are some FreshRSS extensions out there, developed by community members:

### By [@kevinpapst](https://github.com/kevinpapst), [Web](https://www.kevinpapst.de/)

* [Youtube](xExtension-YouTube) shows YouTube videos inline in the feed

### By [@oYoX](https://github.com/oyox), [Web](https://oyox.de/)

* [Keep Folder State](https://github.com/oyox/FreshRSS-extensions/tree/master/xExtension-KeepFolderState): Stores the state of the folders locally and expand them automatically if necessary.
* [Fixed Nav Menu](https://github.com/oyox/FreshRSS-extensions/tree/master/xExtension-FixedNavMenu): (desktop) Sets the position of the navigation menu to fixed when scrolling down.
* [Mobile Scroll Menu](https://github.com/oyox/FreshRSS-extensions/tree/master/xExtension-MobileScrollMenu): (mobile) Automatically hides the header menu when scrolling down and shows it when scrolling up.
* [Touch Control](https://github.com/oyox/FreshRSS-extensions/tree/master/xExtension-TouchControl): (mobile) Add touch gestures to FreshRSS.


### By [@Eisa01](https://github.com/Eisa01)

* [FreshRSS Auto Refresh](https://github.com/Eisa01/FreshRSS---Auto-Refresh-Extension): Automatically refreshes FreshRSS page once in a minute.


### By [@aledeg](https://github.com/aledeg)

* [Date Format](https://github.com/aledeg/FreshRSS-extensions/tree/master/xExtension-DateFormat): Change how dates are displayed in the interface
* [Latex Support](https://github.com/aledeg/FreshRSS-extensions/tree/master/xExtension-LatexSupport): Add support for LaTeX notation rendering
* [Reddit Image](https://github.com/aledeg/FreshRSS-extensions/tree/master/xExtension-RedditImage): Replace link to Reddit topic with resource link


### By [@Lapineige](https://github.com/lapineige)

* [Reading Time](https://framagit.org/Lapineige/FreshRSS_Extension-ReadingTime): Add a reading time estimation next to each article.


### By [@Korbak](https://github.com/Korbak)

* [Invidious](https://github.com/Korbak/freshrss-invidious): Displays videos from YouTube feeds inline and replaces every source by the Invidious instance of your choice for an enhanced privacy (no tracking or limitation)

### By [@CN-Tools](https://github.com/cn-tools)

* [Copy 2 Clipboard](https://github.com/cn-tools/cntools_FreshRssExtensions/tree/master/xExtension-Copy2Clipboard): Add a button in the navigation bar to copy the destination links of all visible entries into clipboard
* [Feed Title Builder](https://github.com/cn-tools/cntools_FreshRssExtensions/tree/master/xExtension-FeedTitleBuilder): Build your own feed title based on url, the original feed title and the date the feed was added
* [FilterTitle](https://github.com/cn-tools/cntools_FreshRssExtensions/tree/master/xExtension-FilterTitle): Filter out feed entries by keywords parsed by the feed entry title
* [RemoveEmojis](https://github.com/cn-tools/cntools_FreshRssExtensions/tree/master/xExtension-RemoveEmojis): Remove emojis in the title of newly added feed entries.
* [YouTube Channel 2 RSSFeed](https://github.com/cn-tools/cntools_FreshRssExtensions/tree/master/xExtension-YouTubeChannel2RssFeed): You can add a YouTube Channel URL and will get it as RSSFeed

### By [@DevonHess](https://github.com/DevonHess)

* [RSS-Bridge](https://github.com/DevonHess/FreshRSS-Extensions/tree/main/xExtension-RssBridge): Run URLs through [RSS-Bridge](https://github.com/rss-bridge/rss-bridge) detection

### By [@Kapdap](https://github.com/Kapdap)

* [Clickable Links](https://github.com/kapdap/freshrss-extensions/tree/master/xExtension-ClickableLinks): Replaces non-clickable plain text URLs found in articles with clickable HTML links

### By [@dohseven](https://framagit.org/dohseven)

* [Explosm](https://framagit.org/dohseven/freshrss-explosm): Directly displays the Explosm comic in FreshRSS

### By [@ImAReplicant](https://framagit.org/ImAReplicant)

* [Youtube/Peertube](https://framagit.org/ImAReplicant/freshrss-youtube): Display videos from YouTube/PeerTube feeds inline

### By [@christian-putzke](https://github.com/christian-putzke/)

* [Pocket Button](https://github.com/christian-putzke/freshrss-pocket-button): Add articles to Pocket with one simple button click or a keyboard shortcut.

### By [@printfuck](https://github.com/printfuck/)

* [Readable](https://github.com/printfuck/xExtension-Readable): Fetch article content for selected feeds with [Readability](https://github.com/mozilla/readability) or [Mercury](https://github.com/postlight/mercury-parser)

### By [@Victrid](https://github.com/Victrid/)

* [Image Cache](https://github.com/Victrid/freshrss-image-cache-plugin): Cache feed images on your own facility or Cloudflare cache.

### By [@aidistan](https://github.com/aidistan)

* [FeedPriorityShortcut](https://github.com/aidistan/freshrss-extensions#feed-priority-shortcut): Quick setter for your feed priorities.
* [ThemeModeSynchronizer](https://github.com/aidistan/freshrss-extensions#theme-mode-synchronizer): Synchronize the theme with your system light/dark mode.

### By [@balthisar](https://github.com/balthisar)

* [RedditSub](https://github.com/balthisar/xExtension-RedditSub): A FreshRSS Extension to Show a Reddit Subreddit as Part of the Article Title.

### By [@mgnsk](https://github.com/mgnsk)

* [AutoTTL](https://github.com/mgnsk/FreshRSS-AutoTTL): A FreshRSS extension for automatic feed refresh TTL based on the average frequency of entries.

### By [@giventofly](https://github.com/giventofly)

* [Comics In Feed](https://github.com/giventofly/freshrss-comicsinfeed): Display comicss directly in FreshRSS (currently for The awkward yeti and Butter Safe).

### By [@rudism](https://code.sitosis.com/rudism)

* [Kagi Summarizer](https://code.sitosis.com/rudism/freshrss-kagi-summarizer): Adds a "Summarize" button to the top of all entries that will fetch the summary of the entry using the [Kagi Universal Summarizer](https://kagi.com/summarizer/index.html).

### By [@shinemoon](https://github.com/shinemoon)

* [Colorful List](https://github.com/shinemoon/FreshRSS-Dev/tree/master/extensions/xExtension-ColorfulList): Generate light different background color for article list rows (relying on the feed name)

### By [@babico](https://github.com/babico)

* [Twitch Channel 2 Rss Feed](https://github.com/babico/xExtension-TwitchChannel2RssFeed): You can add a Twitch Channel URL and will get it as RSSFeed

### By [@ravenscroftj](https://github.com/ravenscroftj)

* [FreshRss FlareSolverr](https://github.com/ravenscroftj/freshrss-flaresolverr-extension): Use a Flaresolverr instance to bypass cloudflare security checks

### By [@tunbridgep](https://github.com/tunbridgep)

* [Invidious Video Feed](https://github.com/tunbridgep/freshrss-invidious/tree/master/xExtension-Invidious): Embed YouTube feeds inside article content, but with Invidious.

### By [@jacob2826](https://github.com/jacob2826)

* [TranslateTitlesCN](https://github.com/jacob2826/FreshRSS-TranslateTitlesCN): Translate article titles of the specified feed into Chinese, using [DeepLX](https://github.com/OwO-Network/DeepLX) or Google Translate.

### By [@kalvn](https://github.com/kalvn)

* [Mark Previous as Read](https://github.com/kalvn/freshrss-mark-previous-as-read): Adds a button in the footer of each entry. Clicking this button will mark all previous entries belonging to the current feed, as read.
