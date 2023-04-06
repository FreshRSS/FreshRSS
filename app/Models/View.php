<?php

class FreshRSS_View extends Minz_View {

	// Main views
	/** @var callable */
	public $callbackBeforeEntries;
	/** @var callable */
	public $callbackBeforeFeeds;
	/** @var callable */
	public $callbackBeforePagination;
	/** @var array<FreshRSS_Category> */
	public $categories;
	/** @var FreshRSS_Category|null */
	public $category;
	/** @var string */
	public $current_user;
	/** @var array<FreshRSS_Entry> */
	public $entries;
	/** @var FreshRSS_Entry */
	public $entry;
	/** @var FreshRSS_Feed|null */
	public $feed;
	/** @var array<FreshRSS_Feed> */
	public $feeds;
	/** @var int */
	public $nbUnreadTags;
	/** @var array<string> */
	public $tags;
	/** @var array<string,string> */
	public $notification;
	/** @var bool */
	public $excludeMutedFeeds;

	// Substriptions
	/** @var string */
	public $default_category;
	/** @var string|bool */
	public $displaySlider;
	/** @var bool */
	public $load_ok;
	/** @var bool|null */
	public $onlyFeedsWithError;
	/** @var float */
	public $signalError;

	// Manage users
	/** @var array<string> */
	public $details;
	/** @var bool */
	public $disable_aside;
	/** @var bool */
	public $show_email_field;
	/** @var string */
	public $username;
	/** @var array<string> */
	public $users;

	// Updates
	/** @var string */
	public $last_update_time;
	/** @var array<string,bool> */
	public $status_files;
	/** @var array<string,bool> */
	public $status_php;
	/** @var bool */
	public $update_to_apply;
	/** @var array<string,bool> */
	public $status_database;

	// Archiving
	/** @var string */
	public $nb_total;
	/** @var int */
	public $size_total;
	/** @var int */
	public $size_user;

	// Display
	/** @var string */
	public $themes;

	// Shortcuts
	/** @var array<string> */
	public $list_keys;

	// User queries
	/** @var array<int,FreshRSS_UserQuery> */
	public $queries;
	/**  @var FreshRSS_UserQuery|null */
	public $query;

	// Export / Import
	/** @var array<string,array<string,string>> */
	public $content;
	/** @var array<string> */
	public $entryIdsTagNames;
	/** @var string */
	public $list_title;
	/** @var string */
	public $queryId;
	/** @var string */
	public $type;

	// Form login
	/** @var int */
	public $cookie_days;
	/** @var string */
	public $nonce;
	/** @var string */
	public $salt1;

	// Registration
	/** @var bool */
	public $can_register;
	/** @var string */
	public $preferred_language;
	/** @var bool */
	public $show_tos_checkbox;
	/** @var string */
	public $terms_of_service;
	/** @var string */
	public $site_title;
	/** @var string */
	public $validation_url;

	// Logs
	/** @var int */
	public $currentPage;
	/** @var Minz_Paginator */
	public $logsPaginator;
	/** @var int */
	public $nbPage;

	// RSS view
	/** @var string */
	public $rss_title = '';
	/** @var string */
	public $rss_url = '';
	/** @var string */
	public $rss_base = '';
	/** @var bool */
	public $internal_rendering = false;

	// Content preview
	/** @var string */
	public $fatalError;
	/** @var string */
	public $htmlContent;
	/** @var bool */
	public $selectorSuccess;

	// Extensions
	/** @var array<string,array{'name':string,'author':string,'description':string,'version':string,'entrypoint':string,'type':'system'|'user','url':string,'method':string,'directory':string}> */
	public $available_extensions;
	/** @var ?Minz_Extension */
	public $ext_details;
	/** @var array{'system':array<Minz_Extension>,'user':array<Minz_Extension>} */
	public $extension_list;
	/** @var ?Minz_Extension */
	public $extension;
	/** @var array<string,string> */
	public $extensions_installed;

	// Errors
	/** @var string */
	public $code;
	/** @var string */
	public $errorMessage;
	/** @var array<string,string> */
	public $message;

	// Statistics
	/** @var string */
	public $average;
	/** @var float */
	public $averageDayOfWeek;
	/** @var float */
	public $averageHour;
	/** @var float */
	public $averageMonth;
	/** @var array<string> */
	public $days;
	/** @var array<string,string> */
	public $entryByCategory;
	/** @var array<int,int> */
	public $entryCount;
	/** @var array<string,string> */
	public $feedByCategory;
	/** @var array<string,string> */
	public $hours24Labels;
	/** @var array<string,string> */
	public $idleFeeds;
	/** @var array<int,string> */
	public $last30DaysLabel;
	/** @var array<int,string> */
	public $last30DaysLabels;
	/** @var array<string,string> */
	public $months;
	/** @var array<string,string> */
	public $repartition;
	/** @var array<int,int> */
	public $repartitionDayOfWeek;
	/** @var array<int,int> */
	public $repartitionHour;
	/** @var array<int,int> */
	public $repartitionMonth;
	/** @var array<string> */
	public $topFeed;

}
