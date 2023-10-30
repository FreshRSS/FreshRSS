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
	public array $categories;
	public ?FreshRSS_Category $category;
	public string $current_user;
	/** @var iterable<FreshRSS_Entry> */
	public $entries;
	public FreshRSS_Entry $entry;
	public ?FreshRSS_Feed $feed;
	/** @var array<FreshRSS_Feed> */
	public array $feeds;
	public int $nbUnreadTags;
	/** @var array<FreshRSS_Tag> */
	public array $tags;
	/** @var array<int,array{'id':int,'name':string,'id_entry':string,'checked':bool}> */
	public array $tagsForEntry;
	/** @var array<string,array<string>> */
	public array $tagsForEntries;
	/** @var array<string,string> */
	public array $notification;
	public bool $excludeMutedFeeds;

	// Substriptions
	public ?FreshRSS_Category $default_category;
	public bool $displaySlider = false;
	public bool $load_ok;
	public bool $onlyFeedsWithError;
	public bool $signalError;

	// Manage users
	/** @var array{'feed_count':int,'article_count':int,'database_size':int,'language':string,'mail_login':string,'enabled':bool,'is_admin':bool,'last_user_activity':string,'is_default':bool} */
	public array $details;
	public bool $disable_aside;
	public bool $show_email_field;
	public string $username;
	/** @var array<array{'language':string,'enabled':bool,'is_admin':bool,'enabled':bool,'article_count':int,'database_size':int,'last_user_activity':string,'mail_login':string,'feed_count':int,'is_default':bool}> */
	public array $users;

	// Updates
	public string $last_update_time;
	/** @var array<string,bool> */
	public array $status_files;
	/** @var array<string,bool> */
	public array $status_php;
	public bool $update_to_apply;
	/** @var array<string,bool> */
	public array $status_database;
	public bool $is_release_channel_stable;

	// Archiving
	public int $nb_total;
	public int $size_total;
	public int $size_user;

	// Display
	/** @var array<string,array{'id':string,'name':string,'author':string,'description':string,'version':float|string,'files':array<string>,'theme-color'?:string|array{'dark'?:string,'light'?:string,'default'?:string}}> */
	public array $themes;

	// Shortcuts
	/** @var array<int, string> */
	public array $list_keys;

	// User queries
	/** @var array<int,FreshRSS_UserQuery> */
	public array $queries;
	/**  @var FreshRSS_UserQuery|null */
	public ?FreshRSS_UserQuery $query = null;

	// Export / Import
	public string $content;
	/** @var array<string,array<string>> */
	public array $entryIdsTagNames;
	public string $list_title;
	public int $queryId;
	public string $type;

	// Form login
	public int $cookie_days;

	// Registration
	public bool $can_register;
	public string $preferred_language;
	public bool $show_tos_checkbox;
	public string $terms_of_service;
	public string $site_title;
	public string $validation_url;

	// Logs
	public int $currentPage;
	public Minz_Paginator $logsPaginator;
	public int $nbPage;

	// RSS view
	public string $rss_title = '';
	public string $rss_url = '';
	public string $rss_base = '';
	public bool $internal_rendering = false;

	// Content preview
	public string $fatalError;
	public string $htmlContent;
	public bool $selectorSuccess;

	// Extensions
	/** @var array<string,array{'name':string,'author':string,'description':string,'version':string,'entrypoint':string,'type':'system'|'user','url':string,'method':string,'directory':string}> */
	public array $available_extensions;
	public ?Minz_Extension $ext_details;
	/** @var array{'system':array<Minz_Extension>,'user':array<Minz_Extension>} */
	public array $extension_list;
	public ?Minz_Extension $extension;
	/** @var array<string,string> */
	public array $extensions_installed;

	// Errors
	public string $code;
	public string $errorMessage;
	/** @var array<string,string> */
	public array $message;

}
