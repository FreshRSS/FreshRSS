<?php

declare(strict_types=1);

/*
 * This is a configuration file. You shouldn’t modify it unless you know what
 * you are doing. If you want to add a share type, this is where you need to do
 * it.
 *
 * For each share there is different configuration options. Here is the description
 * of those options:
 *   - 'deprecated' (optional) is a boolean. Default: 'false'.
 *     'true', if the sharing service is planned to remove in the future.
 *     Add more information into the documentation center.
 *   - 'HTMLtag' (optional). If it is 'button' then an HTML <button> is used,
 * 	   else an <a href=""> is used. Add a click event in main.js additionally.
 *   - 'url' is a mandatory option. It is a string representing the share URL. It
 *     supports 4 different placeholders for custom data. The ~URL~ placeholder
 *     represents the URL of the system used to share, it is configured by the
 *     user. The ~LINK~ placeholder represents the link of the shared article.
 *     The ~TITLE~ placeholder represents the title of the shared article. The
 *     ~ID~ placeholder represents the id of the shared article (only useful
 *     for internal use)
 *   - 'transform' is an array of transformation to apply on links and titles
 *   - 'help' is a URL to a help page (mandatory for form = 'advanced')
 *   - 'form' is the type of form to display during configuration. It’s either
 *     'simple' or 'advanced'. 'simple' is used when only the name is configurable,
 *     'advanced' is used when the name and the location are configurable.
 *   - 'method' is the HTTP method (POST or GET) used to share a link.
 */

return [
	'archiveORG' => [
		'url' => 'https://web.archive.org/save/~LINK~',
		'transform' => [],
		'help' => 'https://web.archive.org',
		'form' => 'simple',
		'method' => 'GET',
	],
	'archivePH' => [
		'url' => 'https://archive.ph/submit/?url=~LINK~',
		'transform' => [],
		'help' => 'https://archive.ph/',
		'form' => 'simple',
		'method' => 'GET',
	],
	'blogotext' => [
		'deprecated' => true,
		'url' => '~URL~/admin/links.php?url=~LINK~',
		'transform' => [],
		'help' => 'http://lehollandaisvolant.net/blogotext/fr/',
		'form' => 'advanced',
		'method' => 'GET',
	],
	'buffer' => [
		'url' => 'https://publish.buffer.com/compose?url=~LINK~&text=~TITLE~',
		'transform' => ['rawurlencode'],
		'help' => 'https://support.buffer.com/hc/en-us/articles/360035587394-Scheduling-posts',
		'form' => 'simple',
		'method' => 'GET',
	],
	'clipboard' => [
		'HTMLtag' => 'button',
		'url' => '~LINK~',
		'transform' => [],
		'form' => 'simple',
		'method' => 'GET',
	],
	'diaspora' => [
		'url' => '~URL~/bookmarklet?url=~LINK~&amp;title=~TITLE~',
		'transform' => ['rawurlencode'],
		'help' => 'https://diasporafoundation.org/',
		'form' => 'advanced',
		'method' => 'GET',
	],
	'email' => [
		'url' => 'mailto:?subject=~TITLE~&amp;body=~LINK~',
		'transform' => ['rawurlencode'],
		'form' => 'simple',
		'method' => 'GET',
	],
	'email-webmail-firefox-fix' => [ // see https://github.com/FreshRSS/FreshRSS/issues/2666
		'url' => 'mailto:?subject=~TITLE~&amp;body=~LINK~',
		'transform' => ['rawurlencode'],
		'form' => 'simple',
		'method' => 'GET',
	],
	'facebook' => [
		'url' => 'https://www.facebook.com/sharer.php?u=~LINK~&amp;t=~TITLE~',
		'transform' => ['rawurlencode'],
		'form' => 'simple',
		'method' => 'GET',
	],
	'gnusocial' => [
		'url' => '~URL~/notice/new?content=~TITLE~%20~LINK~',
		'transform' => ['urlencode'],
		'help' => 'https://gnu.io/social/',
		'form' => 'advanced',
		'method' => 'GET',
	],
	'jdh' => [
		'url' => 'https://www.journalduhacker.net/stories/new?url=~LINK~&title=~TITLE~',
		'transform' => ['rawurlencode'],
		'form' => 'simple',
		'method' => 'GET',
	],
	'Known' => [
		'url' => '~URL~/share?share_url=~LINK~&share_title=~TITLE~',
		'transform' => ['rawurlencode'],
		'help' => 'https://withknown.com/',
		'form' => 'advanced',
		'method' => 'GET',
	],
	'lemmy' => [
		'url' => '~URL~/create_post?url=~LINK~&title=~TITLE~',
		'transform' => ['rawurlencode'],
		'help' => 'https://join-lemmy.org/',
		'form' => 'advanced',
		'method' => 'GET',
	],
	'linkding' => [
		'url' => '~URL~/bookmarks/new?url=~LINK~&title=~TITLE~&auto_close',
		'transform' => ['rawurlencode'],
		'help' => 'https://github.com/sissbruecker/linkding/blob/master/docs/how-to.md',
		'form' => 'advanced',
		'method' => 'GET',
	],
	'linkedin' => [
		'url' => 'https://www.linkedin.com/shareArticle?url=~LINK~&amp;title=~TITLE~&amp;source=FreshRSS',
		'transform' => ['rawurlencode'],
		'form' => 'simple',
		'method' => 'GET',
	],
	'mastodon' => [
		'url' => '~URL~/share?title=~TITLE~&url=~LINK~',
		'transform' => ['rawurlencode'],
		'help' => 'https://joinmastodon.org/',
		'form' => 'advanced',
		'method' => 'GET',
	],
	'movim' => [
		'url' => '~URL~/?share/~LINK~',
		'transform' => ['urlencode'],
		'help' => 'https://movim.eu/',
		'form' => 'advanced',
		'method' => 'GET',
	],
	'omnivore' => [
		'url' => '~URL~/api/save?url=~LINK~',
		'transform' => ['urlencode'],
		'help' => 'https://omnivore.app/',
		'form' => 'advanced',
		'method' => 'GET',
	],
	'pinboard' => [
		'url' => 'https://pinboard.in/add?next=same&amp;url=~LINK~&amp;title=~TITLE~',
		'transform' => ['urlencode'],
		'help' => 'https://pinboard.in/api/',
		'form' => 'simple',
		'method' => 'GET',
	],
	'pinterest' => [
		'url' => 'https://pinterest.com/pin/create/button/?url=~LINK~',
		'transform' => ['rawurlencode'],
		'help' => 'https://pinterest.com/',
		'form' => 'simple',
		'method' => 'GET',
	],
	'pocket' => [
		'url' => 'https://getpocket.com/save?url=~LINK~&amp;title=~TITLE~',
		'transform' => ['rawurlencode'],
		'form' => 'simple',
		'method' => 'GET',
	],
	'print' => [
		'HTMLtag' => 'button',
		'url' => '#',
		'transform' => [],
		'form' => 'simple',
		'method' => 'GET',
	],
	'raindrop' => [
		'url' => 'https://app.raindrop.io/add?link=~LINK~&title=~TITLE~',
		'transform' => ['rawurlencode'],
		'form' => 'simple',
		'method' => 'GET',
	],
	'reddit' => [
		'url' => 'https://www.reddit.com/submit?url=~LINK~',
		'transform' => ['rawurlencode'],
		'help' => 'https://www.reddit.com/wiki/submitting?v=c2ae883a-04b9-11e4-a68c-12313b01a1fc',
		'form' => 'simple',
		'method' => 'GET',
	],
	'shaarli' => [
		'url' => '~URL~?post=~LINK~&amp;title=~TITLE~&amp;source=FreshRSS',
		'transform' => ['rawurlencode'],
		'help' => 'http://sebsauvage.net/wiki/doku.php?id=php:shaarli',
		'form' => 'advanced',
		'method' => 'GET',
	],
	'twitter' => [
		'url' => 'https://twitter.com/share?url=~LINK~&amp;text=~TITLE~',
		'transform' => ['rawurlencode'],
		'form' => 'simple',
		'method' => 'GET',
	],
	'wallabag' => [
		'url' => '~URL~?action=add&amp;url=~LINK~',
		'transform' => ['rawurlencode'],
		'help' => 'http://www.wallabag.org/',
		'form' => 'advanced',
		'method' => 'GET',
	],
	'wallabagv2' => [
		'url' => '~URL~/bookmarklet?url=~LINK~',
		'transform' => ['rawurlencode'],
		'help' => 'http://www.wallabag.org/',
		'form' => 'advanced',
		'method' => 'GET',
	],
	'web-sharing-api' => [
		'HTMLtag' => 'button',
		'url' => '~LINK~',
		'transform' => [],
		'form' => 'simple',
		'method' => 'GET',
	],
	'whatsapp' => [
		'url' => 'https://wa.me/?text=~TITLE~ | ~LINK~',
		'transform' => ['rawurlencode'],
		'help' => 'https://faq.whatsapp.com/iphone/how-to-link-to-whatsapp-from-a-different-app/?lang=en',
		'form' => 'simple',
		'method' => 'GET',
	],
	'xing' => [
		'url' => 'https://www.xing.com/spi/shares/new?url=~LINK~',
		'transform' => ['rawurlencode'],
		'help' => 'https://dev.xing.com/plugins/share_button/docs',
		'form' => 'simple',
		'method' => 'GET',
	],
];
