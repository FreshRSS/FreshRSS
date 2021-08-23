<?php

/*
 * This is a configuration file. You shouldn't modify it unless you know what
 * you are doing. If you want to add a share type, this is where you need to do
 * it.
 *
 * For each share there is different configuration options. Here is the description
 * of those options:
 *   - url is a mandatory option. It is a string representing the share URL. It
 *     supports 4 different placeholders for custom data. The ~URL~ placeholder
 *     represents the URL of the system used to share, it is configured by the
 *     user. The ~LINK~ placeholder represents the link of the shared article.
 *     The ~TITLE~ placeholder represents the title of the shared article. The
 *     ~ID~ placeholder represents the id of the shared article (only useful
 *     for internal use)
 *   - transform is an array of transformation to apply on links and titles
 *   - help is a URL to a help page
 *   - form is the type of form to display during configuration. It's either
 *     'simple' or 'advanced'. 'simple' is used when only the name is configurable,
 *     'advanced' is used when the name and the location are configurable.
 *   - method is the HTTP method (POST or GET) used to share a link.
 */

return array(
	'shaarli' => array(
		'url' => '~URL~?post=~LINK~&amp;title=~TITLE~&amp;source=FreshRSS',
		'transform' => array('rawurlencode'),
		'help' => 'http://sebsauvage.net/wiki/doku.php?id=php:shaarli',
		'form' => 'advanced',
		'method' => 'GET',
	),
	'wallabag' => array(
		'url' => '~URL~?action=add&amp;url=~LINK~',
		'transform' => array('rawurlencode'),
		'help' => 'http://www.wallabag.org/',
		'form' => 'advanced',
		'method' => 'GET',
	),
	'wallabagv2' => array(
		'url' => '~URL~/bookmarklet?url=~LINK~',
		'transform' => array('rawurlencode'),
		'help' => 'http://www.wallabag.org/',
		'form' => 'advanced',
		'method' => 'GET',
	),
	'diaspora' => array(
		'url' => '~URL~/bookmarklet?url=~LINK~&amp;title=~TITLE~',
		'transform' => array('rawurlencode'),
		'help' => 'https://diasporafoundation.org/',
		'form' => 'advanced',
		'method' => 'GET',
	),
	'movim' => array(
		'url' => '~URL~/?share/~LINK~',
		'transform' => array('urlencode'),
		'help' => 'https://movim.eu/',
		'form' => 'advanced',
		'method' => 'GET',
	),
	'twitter' => array(
		'url' => 'https://twitter.com/share?url=~LINK~&amp;text=~TITLE~',
		'transform' => array('rawurlencode'),
		'form' => 'simple',
		'method' => 'GET',
	),
	'facebook' => array(
		'url' => 'https://www.facebook.com/sharer.php?u=~LINK~&amp;t=~TITLE~',
		'transform' => array('rawurlencode'),
		'form' => 'simple',
		'method' => 'GET',
	),
	'email' => array(
		'url' => 'mailto:?subject=~TITLE~&amp;body=~LINK~',
		'transform' => array('rawurlencode'),
		'form' => 'simple',
		'method' => 'GET',
	),
	'print' => array(
		'url' => '#',
		'transform' => array(),
		'form' => 'simple',
		'method' => 'GET',
	),
	'jdh' => array(
		'url' => 'https://www.journalduhacker.net/stories/new?url=~LINK~&title=~TITLE~',
		'transform' => array('rawurlencode'),
		'form' => 'simple',
		'method' => 'GET',
	),
	'Known' => array(
		'url' => '~URL~/share?share_url=~LINK~&share_title=~TITLE~',
		'transform' => array('rawurlencode'),
		'help' => 'https://withknown.com/',
		'form' => 'advanced',
		'method' => 'GET',
	),
	'gnusocial' => array(
		'url' => '~URL~/notice/new?content=~TITLE~%20~LINK~',
		'transform' => array('urlencode'),
		'help' => 'https://gnu.io/social/',
		'form' => 'advanced',
		'method' => 'GET',
	),
	'mastodon' => array(
		'url' => '~URL~/share?title=~TITLE~&url=~LINK~',
		'transform' => array('rawurlencode'),
		'form' => 'advanced',
		'method' => 'GET',
	),
	'pocket' => array(
		'url' => 'https://getpocket.com/save?url=~LINK~&amp;title=~TITLE~',
		'transform' => array('rawurlencode'),
		'form' => 'simple',
		'method' => 'GET',
	),
	'linkedin' => array(
		'url' => 'https://www.linkedin.com/shareArticle?url=~LINK~&amp;title=~TITLE~&amp;source=FreshRSS',
		'transform' => array('rawurlencode'),
		'form' => 'simple',
		'method' => 'GET',
	),
	'pinboard' => array(
		'url' => 'https://pinboard.in/add?next=same&amp;url=~LINK~&amp;title=~TITLE~',
		'transform' => array('urlencode'),
		'help' => 'https://pinboard.in/api/',
		'form' => 'simple',
		'method' => 'GET',
	),
	'lemmy' => array(
		'url' => '~URL~/create_post?url=~LINK~&name=~TITLE~',
		'transform' => array('rawurlencode'),
		'form' => 'advanced',
		'method' => 'GET',
	),
	'clipboard' => array(
		'url' => '~LINK~',
		'transform' => array(),
		'form' => 'simple',
		'method' => 'GET',
	),
	'raindrop' => array(
		'url' => 'https://app.raindrop.io/add?link=~LINK~&title=~TITLE~',
		'transform' => array('rawurlencode'),
		'form' => 'simple',
		'method' => 'GET',
	),
);
