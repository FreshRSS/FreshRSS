<?php

final class FreshRSS_ViewStats extends FreshRSS_View {

	public ?FreshRSS_Category $default_category;
	/** @var array<FreshRSS_Category> */
	public $categories;
	public ?FreshRSS_Feed $feed;
	/** @var array<FreshRSS_Feed> */
	public $feeds;
	public bool $displaySlider;

	public float $average;
	public float $averageDayOfWeek;
	public float $averageHour;
	public float $averageMonth;
	/** @var array<string> */
	public $days;
	/** @var array<string,array<int,int|string>> */
	public $entryByCategory;
	/** @var array<int,int> */
	public $entryCount;
	/** @var array<string,array<int,int|string>> */
	public $feedByCategory;
	/** @var array<int, string> */
	public $hours24Labels;
	/** @var array<string,array<int,array<string,int|string>>> */
	public $idleFeeds;
	/** @var array<int,string> */
	public $last30DaysLabel;
	/** @var array<int,string> */
	public $last30DaysLabels;
	/** @var array<string,string> */
	public $months;
	/** @var array{'total':int,'count_unreads':int,'count_reads':int,'count_favorites':int}|false */
	public $repartition;
	/** @var array{'main_stream':array{'total':int,'count_unreads':int,'count_reads':int,'count_favorites':int}|false,'all_feeds':array{'total':int,'count_unreads':int,'count_reads':int,'count_favorites':int}|false} */
	public $repartitions;
	/** @var array<int,int> */
	public $repartitionDayOfWeek;
	/** @var array<string,int>|array<int,int> */
	public $repartitionHour;
	/** @var array<int,int> */
	public $repartitionMonth;
	/** @var array<array{'id':int,'name':string,'category':string,'count':int}> */
	public $topFeed;

}
