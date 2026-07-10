<?php
declare(strict_types=1);

namespace FreshRss\Models;

use FreshRss\Controllers\ExtensionController;
use FreshRss\Minz\Extension;
use FreshRss\Minz\Paginator;
use FreshRss\Minz\View as MinzView;

/**
 * @phpstan-import-type ExtensionFullMetadata from ExtensionController
 */
class View extends MinzView {

	// Main views
	/** @var callable */
	public $callbackBeforeEntries;
	/** @var callable|null */
	public $callbackBeforeFeeds;
	/** @var callable */
	public $callbackBeforePagination;
	/** @var array<int,Category> where the key is the category ID */
	public array $categories;
	public ?Category $category = null;
	public ?Tag $tag = null;
	public string $current_user;
	/** @var iterable<Entry> */
	public $entries;
	public ?Entry $entry = null;
	public ?Feed $feed = null;
	/** @var array<int,Feed> where the key is the feed ID */
	public array $feeds;
	/**
	 * The keys are the feed IDs that have entries matching the current state and search filters (global view).
	 * @var array<int,int>|null
	 */
	public ?array $feedIdsMatching = null;
	public int $nbUnreadTags;
	/** @var array<int,Tag> where the key is the label ID */
	public array $tags;
	/** @var list<array{id:int,name:string,checked:bool}> */
	public array $tagsForEntry;
	/** @var array<string,array<string>> */
	public array $tagsForEntries;
	public bool $excludeMutedFeeds;
	public bool $includeSensitiveCurlParams = false;

	// Search
	/** @var array<int,Tag> where the key is the label ID */
	public array $labels;

	// Subscriptions
	public string $cfrom = '';
	public bool $displaySlider = false;
	public bool $load_ok;
	public bool $onlyFeedsWithError;
	public bool $signalError;

	// Manage users
	/** @var array{feed_count:?int,article_count:?int,database_size:?int,language:string,mail_login:string,enabled:bool,is_admin:bool,last_user_activity:string,is_default:bool} */
	public array $details;
	public bool $disable_aside;
	public bool $show_email_field;
	public string $username;
	/** @var array<array{language:string,enabled:bool,is_admin:bool,enabled:bool,article_count:?int,database_size:?int,last_user_activity:string,mail_login:string,feed_count:?int,is_default:bool}> */
	public array $users;

	// Updates
	public string $last_update_time;
	/** @var array<string,'ok'|'ko'|'warn'> */
	public array $status_files;
	/** @var array<string,'ok'|'ko'|'warn'> */
	public array $status_php;
	public bool $update_to_apply;
	/** @var array<string,array<string, bool>|bool> */
	public array $status_database;
	public bool $is_release_channel_stable;

	// Archiving
	public int $nb_total;
	public int $size_total;
	public int $size_user;

	// Display
	/** @var array<string,array{id:string,name:string,author:string,description:string,version:float|string,files:array<string>,theme-color?:string|array{dark?:string,light?:string,default?:string}}> */
	public array $themes;

	// Shortcuts
	/** @var array<int, string> */
	public array $list_keys;

	// User queries
	/** @var array<int,UserQuery> where the key is the query ID */
	public array $queries;
	/**  @var UserQuery|null */
	public ?UserQuery $query = null;

	// Export / Import
	public string $content;
	public int $feedCount;
	/** @var array<string,array<string>> */
	public array $entryIdsTagNames = [];
	public string $list_title;
	public int $queryId;
	public string $type;
	/** @var null|array<array{name:string,size:int,mtime:int}> */
	public ?array $sqliteArchives = null;
	public string $sqlitePath;
	public string $sqliteName;

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
	public Paginator $logsPaginator;
	public int $nbPage;
	public string $logSearch = '';

	// RSS view
	public UserQuery $userQuery;
	public string $html_url = '';
	public string $rss_title = '';
	public string $rss_url = '';
	public string $rss_base = '';
	public bool $internal_rendering = false;
	public string $description = '';
	public string $image_url = '';
	public bool $publishLabelsInsteadOfTags = false;

	// Content preview
	public string $fatalError;
	public string $htmlContent;
	public bool $selectorSuccess;

	// Extensions
	/** @var list<ExtensionFullMetadata> */
	public array $available_extensions;
	public ?Extension $ext_details = null;
	/** @var array{system:array<Extension>,user:array<Extension>} */
	public array $extension_list;
	public ?Extension $extension = null;
	/** @var array<string,string> */
	public array $extensions_installed;

	// Errors
	public string $code;
	public string $errorMessage;
	/** @var array<string,string> */
	public array $message;

	// View modes
	/** @var array<ViewMode> */
	public array $viewModes;
}
