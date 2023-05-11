<?php

final class FreshRSS_ViewStats extends FreshRSS_View {

	/** @var FreshRSS_Category|null */
	public $default_category;
	/** @var array<FreshRSS_Category> */
	public $categories;
	/** @var FreshRSS_Feed|null */
	public $feed;
	/** @var array<FreshRSS_Feed> */
	public $feeds;
	/** @var bool */
	public $displaySlider;

	/** @var float */
	public $average;
	/** @var float */
	public $averageDayOfWeek;
	/** @var float */
	public $averageHour;
	/** @var float */
	public $averageMonth;
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
