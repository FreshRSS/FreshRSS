<?php
declare(strict_types=1);

final class FreshRSS_ViewJavascript extends FreshRSS_View {

	/** @var array<int,FreshRSS_Category> where the key is the category ID */
	public array $categories;
	/** @var array<int,FreshRSS_Feed> where the key is the feed ID */
	public array $feeds;
	/** @var array<int,FreshRSS_Tag> where the key is the label ID */
	public array $tags;

	public string $nonce;
	public string $salt1;
}
