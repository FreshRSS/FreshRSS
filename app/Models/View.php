<?php

class FreshRSS_View extends Minz_View {

	// Main views
	public $callbackBeforeEntries;
	public $callbackBeforeFeeds;
	public $callbackBeforePagination;
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
	public $tags;

	// Substriptions
	public $default_category;
	public $displaySlider;
	public $load_ok;
	public $onlyFeedsWithError;
	public $signalError;

	// Manage users
	public $details;
	public $disable_aside;
	public $show_email_field;
	public $username;
	public $users;

	// Updates
	public $last_update_time;
	public $status_files;
	public $status_php;
	public $update_to_apply;
	public $status_database;

	// Archiving
	public $nb_total;
	public $size_total;
	public $size_user;

	// Display
	public $themes;

	// Shortcuts
	public $list_keys;

	// User queries
	/**
	 * @var array<int,FreshRSS_UserQuery>
	 */
	public $queries;
	/**
	 * @var FreshRSS_UserQuery|null
	 */
	public $query;

	// Export / Import
	public $content;
	public $entriesRaw;
	public $entriesId;
	public $entryIdsTagNames;
	public $list_title;
	public $queryId;
	public $type;

	// Form login
	public $cookie_days;
	public $nonce;
	public $salt1;

	// Registration
	public $can_register;
	public $preferred_language;
	public $show_tos_checkbox;
	public $terms_of_service;

	// Email validation
	public $site_title;
	public $validation_url;

	// Logs
	public $currentPage;
	public $logsPaginator;
	public $nbPage;

	// RSS view
	/** @var string */
	public $rss_title = '';
	/** @var string */
	public $rss_url = '';
	/** @var boolean */
	public $internal_rendering = false;

	// Content preview
	public $fatalError;
	public $htmlContent;
	public $selectorSuccess;

	// Extensions
	public $available_extensions;
	public $ext_details;
	public $extension_list;
	public $extension;
	public $extensions_installed;

	// Errors
	public $code;
	public $errorMessage;
	public $message;

	// Statistics
	public $average;
	public $averageDayOfWeek;
	public $averageHour;
	public $averageMonth;
	public $days;
	public $entryByCategory;
	public $entryCount;
	public $feedByCategory;
	public $hours24Labels;
	public $idleFeeds;
	public $last30DaysLabel;
	public $last30DaysLabels;
	public $months;
	public $repartition;
	public $repartitionDayOfWeek;
	public $repartitionHour;
	public $repartitionMonth;
	public $topFeed;

}
