<?php
declare(strict_types=1);

enum Minz_HookType: string {
	case ApiMisc = 'api_misc';	// function(): void
	case BeforeLoginBtn = 'before_login_btn';	// function(): string
	case CheckUrlBeforeAdd = 'check_url_before_add';	// function(string $url) -> string | null
	case CustomFaviconBtnUrl = 'custom_favicon_btn_url';	// function(FreshRSS_Feed $feed): string | null
	case CustomFaviconHash = 'custom_favicon_hash';	// function(FreshRSS_Feed $feed): string | null
	case EntriesFavorite = 'entries_favorite';	// function(array $ids, bool $is_favorite): void
	case EntryAutoRead = 'entry_auto_read';	// function(FreshRSS_Entry $entry, string $why): void
	case EntryAutoUnread = 'entry_auto_unread';	// function(FreshRSS_Entry $entry, string $why): void
	case EntryBeforeDisplay = 'entry_before_display';	// function(FreshRSS_Entry $entry) -> FreshRSS_Entry | null
	case EntryBeforeInsert = 'entry_before_insert';	// function(FreshRSS_Entry $entry) -> FreshRSS_Entry | null
	case EntryBeforeAdd = 'entry_before_add';	// function(FreshRSS_Entry $entry) -> FreshRSS_Entry | null
	case EntryBeforeUpdate = 'entry_before_update';	// function(FreshRSS_Entry $entry) -> FreshRSS_Entry | null
	case FeedBeforeActualize = 'feed_before_actualize';	// function(FreshRSS_Feed $feed) -> FreshRSS_Feed | null
	case FeedBeforeInsert = 'feed_before_insert';	// function(FreshRSS_Feed $feed) -> FreshRSS_Feed | null
	case FreshrssInit = 'freshrss_init';	// function() -> none
	case FreshrssUserMaintenance = 'freshrss_user_maintenance';	// function() -> none
	case JsVars = 'js_vars';	// function($vars = array) -> array | null
	case MenuAdminEntry = 'menu_admin_entry';	// function() -> string
	case MenuConfigurationEntry = 'menu_configuration_entry';	// function() -> string
	case MenuOtherEntry = 'menu_other_entry';	// function() -> string
	case NavMenu = 'nav_menu';	// function() -> string
	case NavReadingModes = 'nav_reading_modes';	// function($readingModes = array) -> array | null
	case PostUpdate = 'post_update';	// function(none) -> none
	case SimplepieAfterInit = 'simplepie_after_init';	// function(\SimplePie\SimplePie $simplePie, FreshRSS_Feed $feed, bool $result): void
	case SimplepieBeforeInit = 'simplepie_before_init';	// function(\SimplePie\SimplePie $simplePie, FreshRSS_Feed $feed): void
	case ViewModes = 'view_modes';	// function($viewModes = array) -> array | null

	public function signature(): Minz_HookSignature {
		switch ($this) {
			case Minz_HookType::ApiMisc:
			case Minz_HookType::FreshrssInit:
			case Minz_HookType::FreshrssUserMaintenance:
			case Minz_HookType::PostUpdate:
				return Minz_HookSignature::NoneToNone;
			case Minz_HookType::BeforeLoginBtn:
			case Minz_HookType::MenuAdminEntry:
			case Minz_HookType::MenuConfigurationEntry:
			case Minz_HookType::MenuOtherEntry:
			case Minz_HookType::NavMenu:
				return Minz_HookSignature::NoneToString;
			case Minz_HookType::CheckUrlBeforeAdd:
			case Minz_HookType::EntryBeforeDisplay:
			case Minz_HookType::EntryBeforeInsert:
			case Minz_HookType::EntryBeforeAdd:
			case Minz_HookType::EntryBeforeUpdate:
			case Minz_HookType::FeedBeforeActualize:
			case Minz_HookType::FeedBeforeInsert:
			case Minz_HookType::JsVars:
			case Minz_HookType::NavReadingModes:
			case Minz_HookType::ViewModes:
				return Minz_HookSignature::OneToOne;
			case Minz_HookType::CustomFaviconBtnUrl:
			case Minz_HookType::CustomFaviconHash:
			case Minz_HookType::EntriesFavorite:
			case Minz_HookType::EntryAutoRead:
			case Minz_HookType::EntryAutoUnread:
			case Minz_HookType::SimplepieAfterInit:
			case Minz_HookType::SimplepieBeforeInit:
				return Minz_HookSignature::PassArguments;
			default:
				throw new \RuntimeException('The hook is not configured!');
		}
	}
}
