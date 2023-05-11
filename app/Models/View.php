<?php

class FreshRSS_View extends Minz_View {

	// Main views
	/** @var callable */
	public $callbackBeforeEntries;
	/** @var callable|null */
	public $callbackBeforeFeeds;
	/** @var callable */
	public $callbackBeforePagination;
	/** @var array<FreshRSS_Category> */
	public $categories;
	/** @var FreshRSS_Category|null */
	public $category;
	/** @var string */
	public $current_user;
	/** @var iterable<FreshRSS_Entry> */
	public $entries;
	/** @var FreshRSS_Entry */
	public $entry;
	/** @var FreshRSS_Feed|null */
	public $feed;
	/** @var array<FreshRSS_Feed> */
	public $feeds;
	/** @var int */
	public $nbUnreadTags;
	/** @var array<FreshRSS_Tag> */
	public $tags;
	/** @var array<int,array{'id':int,'name':string,'id_entry':string,'checked':bool}> */
	public $tagsForEntry;
	/** @var array<string,array<string>> */
	public $tagsForEntries;
	/** @var array<string,string> */
	public $notification;
	/** @var bool */
	public $excludeMutedFeeds;

	// Substriptions
	/** @var FreshRSS_Category|null */
	public $default_category;
	/** @var bool */
	public $displaySlider;
	/** @var bool */
	public $load_ok;
	/** @var bool */
	public $onlyFeedsWithError;
	/** @var bool */
	public $signalError;

	// Manage users
	/** @var array{'feed_count':int|false,'article_count':int|false,'database_size':int,'language':string,'mail_login':string,'enabled':bool,'is_admin':bool,'last_user_activity':string,'is_default':bool} */
	public $details;
	/** @var bool */
	public $disable_aside;
	/** @var bool */
	public $show_email_field;
	/** @var string */
	public $username;
	/** @var array<array{'last_user_activity':int,'language':string,'enabled':bool,'is_admin':bool,'enabled':bool,'article_count':int,'database_size':int,'last_user_activity','mail_login':string,'feed_count':int,'is_default':bool}> */
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
	/** @var int */
	public $nb_total;
	/** @var int */
	public $size_total;
	/** @var int */
	public $size_user;

	// Display
	/** @var array<string,array{'id':string,'name':string,'author':string,'description':string,'version':float|string,'files':array<string>,'theme-color'?:string|array{'dark'?:string,'light'?:string,'default'?:string}}> */
	public $themes;

	// Shortcuts
	/** @var array<int, string> */
	public $list_keys;

	// User queries
	/** @var array<int,FreshRSS_UserQuery> */
	public $queries;
	/**  @var FreshRSS_UserQuery|null */
	public $query;

	// Export / Import
	/** @var string */
	public $content;
	/** @var array<string,array<string>> */
	public $entryIdsTagNames;
	/** @var string */
	public $list_title;
	/** @var int */
	public $queryId;
	/** @var string */
	public $type;

	// Form login
	/** @var int */
	public $cookie_days;

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

}
