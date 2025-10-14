<?php
declare(strict_types=1);

final class FreshRSS_ViewStats extends FreshRSS_View {

	/** @var array<int,FreshRSS_Category> where the key is the category ID */
	public array $categories;
	public ?FreshRSS_Feed $feed = null;
	/** @var array<int,FreshRSS_Feed> where the key is the feed ID */
	public array $feeds;
	public bool $displaySlider = false;

	public float $average;
	public float $averageDayOfWeek;
	public float $averageHour;
	public float $averageMonth;
	/** @var list<string> */
	public array $days;
	/** @var array<string,array<int,int|string>> */
	public array $entryByCategory;
	/** @var array<int,int> */
	public array $entryCount;
	/** @var array<string,array<int,int|string>> */
	public array $feedByCategory;
	/** @var array<int, string> */
	public array $hours24Labels;
	/** @var array<string,array<int,array<string,int|string>>> */
	public array $idleFeeds;
	/** @var array<int,string> */
	public array $last30DaysLabel;
	/** @var array<int,string> */
	public array $last30DaysLabels;
	/** @var list<string> */
	public array $months;
	/** @var array{total:int,count_unreads:int,count_reads:int,count_favorites:int}|false */
	public $repartition;
	/** @var array{main_stream:array{total:int,count_unreads:int,count_reads:int,count_favorites:int}|false,all_feeds:array{total:int,count_unreads:int,count_reads:int,count_favorites:int}|false} */
	public array $repartitions;
	/** @var array<int,int> */
	public array $repartitionDayOfWeek;
	/** @var array<string,int>|array<int,int> */
	public array $repartitionHour;
	/** @var array<int,int> */
	public array $repartitionMonth;
	/** @var list<array{id:int,name:string,category:string,count:int}> */
	public array $topFeed;

	/** @var list<array{granularity:string,unread_count:int}> */
	public array $unreadDates;
}
