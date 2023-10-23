<?php

final class FreshRSS_ViewJavascript extends FreshRSS_View {

	/** @var array<FreshRSS_Category> */
	public $categories;
	/** @var array<FreshRSS_Feed> */
	public $feeds;
	/** @var array<FreshRSS_Tag> */
	public $tags;

	public string $nonce;
	public string $salt1;
}
