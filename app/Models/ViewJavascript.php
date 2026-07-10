<?php
declare(strict_types=1);

namespace FreshRss\Models;

final class ViewJavascript extends View {

	/** @var array<int,Category> where the key is the category ID */
	public array $categories;
	/** @var array<int,Feed> where the key is the feed ID */
	public array $feeds;
	/** @var array<int,Tag> where the key is the label ID */
	public array $tags;

	public string $nonce;
	public string $salt1;
}
