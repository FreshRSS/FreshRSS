<?php

/*
 * This is a configuration file. You shouldn't modify it unless you know what
 * you are doing. If you want to add a share type, this is where you need to do
 * it.
 *
 * For each share there is different configuration options. Here is the description
 * of those options:
 *   - url is a mandatory option. It is a string representing the share URL. It
 *     supports 3 different placeholders for custom data. The ~URL~ placeholder
 *     represents the URL of the system used to share, it is configured by the
 *     user. The ~LINK~ placeholder represents the link of the shared article.
 *     The ~TITLE~ placeholder represents the title of the shared article.
 *   - transform is an array of transformation to apply on links and titles
 *   - help is a URL to a help page
 */

return array(
	'shaarli' => array(
		'url' => '~URL~?post=~LINK~&amp;title=~TITLE~&amp;source=FreshRSS',
		'transform' => array('rawurlencode'),
		'help' => 'http://sebsauvage.net/wiki/doku.php?id=php:shaarli',
		'form' => 'advanced',
	),
	'blogotext' => array(
		'url' => '~URL~/admin/links.php?url=~LINK~',
		'transform' => array(),
		'help' => 'http://lehollandaisvolant.net/blogotext/fr/',
		'form' => 'advanced',
	),
	'wallabag' => array(
		'url' => '~URL~?action=add&amp;url=~LINK~',
		'transform' => array(
			'link' => array('base64_encode'),
			'title' => array(),
		),
		'help' => 'http://www.wallabag.org/',
		'form' => 'advanced',
	),
	'wallabagv2' => array(
		'url' => '~URL~/bookmarklet?url=~LINK~',
		'transform' => array(
			'link' => array('rawurlencode'),
			'title' => array(),
		),
		'help' => 'http://www.wallabag.org/',
		'form' => 'advanced',
	),
	'diaspora' => array(
		'url' => '~URL~/bookmarklet?url=~LINK~&amp;title=~TITLE~',
		'transform' => array('rawurlencode'),
		'help' => 'https://diasporafoundation.org/',
		'form' => 'advanced',
	),
	'movim' => array(
		'url' => '~URL~/?share/~LINK~',
		'transform' => array('rawurlencode', 'urlencode'),
		'help' => 'https://github.com/edhelas/movim',
		'form' => 'advanced',
	),
	'twitter' => array(
		'url' => 'https://twitter.com/share?url=~LINK~&amp;text=~TITLE~',
		'transform' => array('rawurlencode'),
		'form' => 'simple',
	),
	'g+' => array(
		'url' => 'https://plus.google.com/share?url=~LINK~',
		'transform' => array('rawurlencode'),
		'form' => 'simple',
	),
	'facebook' => array(
		'url' => 'https://www.facebook.com/sharer.php?u=~LINK~&amp;t=~TITLE~',
		'transform' => array('rawurlencode'),
		'form' => 'simple',
	),
	'email' => array(
		'url' => 'mailto:?subject=~TITLE~&amp;body=~LINK~',
		'transform' => array('rawurlencode'),
		'form' => 'simple',
	),
	'print' => array(
		'url' => '#',
		'transform' => array(),
		'form' => 'simple',
	),
	'jdh' => array(
		'url' => 'https://www.journalduhacker.net/stories/new?url=~LINK~&title=~TITLE~',
		'transform' => array('rawurlencode'),
		'form' => 'simple',
	),
	'Known' => array(
		'url' => '~URL~/share?share_url=~LINK~&share_title=~TITLE~',
		'transform' => array('rawurlencode'),
		'help' => 'https://withknown.com/',
		'form' => 'advanced',
	),
	'gnusocial' => array(
		'url' => '~URL~/notice/new?content=~TITLE~%20~LINK~',
		'transform' => array('urlencode'),
		'help' => 'https://gnu.io/social/',
		'form' => 'advanced',
	),
);
