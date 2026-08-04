<?php

declare(strict_types=1);

/**
 * Backward-compatibility shims mapping legacy global class names (e.g. `Minz_Extension`,
 * `FreshRSS_Entry`) to their namespaced `FreshRss\...` equivalents, for third-party
 * extensions that still reference the old names.
 *
 * This file is populated as classes are migrated to the `FreshRss` namespace; it is
 * required directly by `lib/lib_rss.php` (also declared in `composer.json` `autoload.files`,
 * for the benefit of dev tooling that loads `vendor/autoload.php` without going through
 * `lib/lib_rss.php`).
 *
 * Only classes forming the documented extension API (see
 * `docs/en/developers/03_Backend/05_Extensions.md`) or plausibly used by third-party
 * extension code are aliased here. Purely internal `Minz_*`/`FreshRSS_*` classes are not
 * aliased: nothing outside this codebase is expected to reference them by their old name.
 *
 * Aliasing is done lazily via an autoloader, not eagerly with `class_alias()`: this file
 * runs very early (right after `freshRssPsr4Autoloader` registers in `lib/lib_rss.php`,
 * before that same file registers the legacy `classAutoloader` that classes such as
 * `FreshRss\Models\SimplePieCustom` need in order to resolve their `extends \SimplePie\SimplePie`).
 * Eagerly aliasing would trigger that resolution too early and fatal. Deferring to first
 * use, by which point the whole autoload chain is registered, avoids the ordering problem
 * entirely.
 */

use FreshRss\Minz\ActionController;
use FreshRss\Minz\Dispatcher;
use FreshRss\Minz\Extension;
use FreshRss\Minz\ExtensionException;
use FreshRss\Minz\ExtensionManager;
use FreshRss\Minz\HookSignature;
use FreshRss\Minz\HookType;
use FreshRss\Minz\Request;
use FreshRss\Minz\Session;
use FreshRss\Minz\Translate;
use FreshRss\Minz\View;
use FreshRss\Models\Context;
use FreshRss\Models\Entry;
use FreshRss\Models\Feed;
use FreshRss\Models\SimplePieCustom;
use FreshRss\Models\UserConfiguration;
use FreshRss\Models\ViewMode;

spl_autoload_register(static function (string $class): void {
	/** @var array<string,class-string> */
	static $legacyAliases = [
		// lib/Minz -> FreshRss\Minz
		'Minz_ActionController' => ActionController::class,
		'Minz_Dispatcher' => Dispatcher::class,
		'Minz_Exception' => \FreshRss\Minz\Exception::class,
		'Minz_Extension' => Extension::class,
		'Minz_ExtensionException' => ExtensionException::class,
		'Minz_ExtensionManager' => ExtensionManager::class,
		'Minz_HookSignature' => HookSignature::class,
		'Minz_HookType' => HookType::class,
		'Minz_Request' => Request::class,
		'Minz_Session' => Session::class,
		'Minz_Translate' => Translate::class,
		'Minz_View' => View::class,

		// app/Models -> FreshRss\Models (classes type-hinted in the documented hook API,
		// see lib/Minz/HookType.php, plus Context/UserConfiguration which extensions
		// commonly access directly for system/user settings)
		'FreshRSS_Context' => Context::class,
		'FreshRSS_Entry' => Entry::class,
		'FreshRSS_Feed' => Feed::class,
		'FreshRSS_SimplePieCustom' => SimplePieCustom::class,
		'FreshRSS_UserConfiguration' => UserConfiguration::class,
		'FreshRSS_ViewMode' => ViewMode::class,
	];

	if (isset($legacyAliases[$class])) {
		class_alias($legacyAliases[$class], $class);
	}
});
