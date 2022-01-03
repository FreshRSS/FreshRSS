<?php

class FreshRSS_View extends Minz_View {

	// Main views
	public $callbackBeforeEntries;
	public $callbackBeforePagination;
	public $categories;
	public $category;
	public $entries;
	public $entry;
	public $feed;
	public $feeds;
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

	// Archiving
	public $nb_total;
	public $size_total;
	public $size_user;

	// Display
	public $themes;

	// Shortcuts
	public $list_keys;

	// User queries
	public $queries;
	public $query;

	// Export / Import
	public $content;
	public $entriesRaw;
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
	public $rss_title;
	public $url;

	// Content preview
	public $fatalError;
	public $htmlContent;
	public $selectorSuccess;

	// Extensions
	public $ext_details;
	public $extension_list;
	public $extension;
	public $extensions_installed;

	// Errors
	public $code;
	public $errorMessage;

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
