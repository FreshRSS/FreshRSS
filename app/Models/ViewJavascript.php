<?php

declare(strict_types=1);

final class FreshRSS_ViewJavascript extends FreshRSS_View {

	/** @var array<FreshRSS_Category> */
	public array $categories;
	/** @var array<FreshRSS_Feed> */
	public array $feeds;
	/** @var array<FreshRSS_Tag> */
	public array $tags;

	public string $nonce;
	public string $salt1;
}
