<?php

declare(strict_types=1);

final class FreshRSS_ViewJavascript extends FreshRSS_View {

	/** @var array<FreshRSS_Category> */
	public $categories;
	/** @var array<FreshRSS_Feed> */
	public $feeds;
	/** @var array<FreshRSS_Tag> */
	public $tags;

	/** @var string */
	public $nonce;
	/** @var string */
	public $salt1;
}
