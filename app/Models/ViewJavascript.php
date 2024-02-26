<?php
declare(strict_types=1);

final class FreshRSS_ViewJavascript extends FreshRSS_View {

	/** @var array<int,FreshRSS_Category> */
	public array $categories;
	/** @var array<int,FreshRSS_Feed> */
	public array $feeds;
	/** @var array<int,FreshRSS_Tag> */
	public array $tags;

	public string $nonce;
	public string $salt1;
}
