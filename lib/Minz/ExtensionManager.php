<?php
declare(strict_types=1);

/**
 * An extension manager to load extensions present in CORE_EXTENSIONS_PATH and THIRDPARTY_EXTENSIONS_PATH.
 *
 * @todo see coding style for methods!!
 */
final class Minz_ExtensionManager {

	private static string $ext_metaname = 'metadata.json';
	private static string $ext_entry_point = 'extension.php';
	/** @var array<string,Minz_Extension> */
	private static array $ext_list = [];
	/** @var array<string,Minz_Extension> */
	private static array $ext_list_enabled = [];
	/** @var array<string,bool> */
	private static array $ext_auto_enabled = [];

	/**
	 * List of available hooks. Please keep this list sorted.
	 * @var array<value-of<Minz_HookType>,array{'list':list<Minz_Hook>,'signature':Minz_HookSignature}>
	 */
	private static array $hook_list = [];

	/** Remove extensions and hooks from a previous initialisation */
	private static function reset(): void {
		$hadAny = !empty(self::$ext_list_enabled);
		self::$ext_list = [];
		self::$ext_list_enabled = [];
		self::$ext_auto_enabled = [];
		foreach (Minz_HookType::cases() as $hook_type) {
			$hadAny |= !empty(self::$hook_list[$hook_type->value]['list']);
			self::$hook_list[$hook_type->value] = [
				'list' => [],
				'signature' => $hook_type->signature(),
			];
		}
		if ($hadAny) {
			gc_collect_cycles();
		}
	}

	/**
	 * Initialize the extension manager by loading extensions in EXTENSIONS_PATH.
	 *
	 * A valid extension is a directory containing metadata.json and
	 * extension.php files.
	 * metadata.json is a JSON structure where the only required fields are
	 * `name` and `entry_point`.
	 * extension.php should contain at least a class named <name>Extension where
	 * <name> must match with the entry point in metadata.json. This class must
	 * inherit from Minz_Extension class.
	 * @throws Minz_ConfigurationNamespaceException
	 */
	public static function init(): void {
		self::reset();

		$list_core_extensions = array_diff(scandir(CORE_EXTENSIONS_PATH) ?: [], [ '..', '.' ]);
		$list_thirdparty_extensions = array_diff(scandir(THIRDPARTY_EXTENSIONS_PATH) ?: [], [ '..', '.' ], $list_core_extensions);
		array_walk($list_core_extensions, function (&$s) { $s = CORE_EXTENSIONS_PATH . '/' . $s; });
		array_walk($list_thirdparty_extensions, function (&$s) { $s = THIRDPARTY_EXTENSIONS_PATH . '/' . $s; });

		$list_potential_extensions = array_merge($list_core_extensions, $list_thirdparty_extensions);

		$system_conf = Minz_Configuration::get('system');
		self::$ext_auto_enabled = array_filter(
			$system_conf->attributeArray('extensions_enabled') ?? [],
			fn($value, $key): bool => is_string($key) && is_bool($value),
			ARRAY_FILTER_USE_BOTH);

		foreach ($list_potential_extensions as $ext_pathname) {
			if (!is_dir($ext_pathname)) {
				continue;
			}
			$metadata_filename = $ext_pathname . '/' . self::$ext_metaname;

			// Try to load metadata file.
			if (!file_exists($metadata_filename)) {
				// No metadata file? Invalid!
				continue;
			}
			$meta_raw_content = file_get_contents($metadata_filename) ?: '';
			/** @var array{'name':string,'entrypoint':string,'path':string,'author'?:string,'description'?:string,'version'?:string,'type'?:'system'|'user'}|null $meta_json */
			$meta_json = json_decode($meta_raw_content, true);
			if (!is_array($meta_json) || !self::isValidMetadata($meta_json)) {
				// metadata.json is not a json file? Invalid!
				// or metadata.json is invalid (no required information), invalid!
				Minz_Log::warning('`' . $metadata_filename . '` is not a valid metadata file');
				continue;
			}

			$meta_json['path'] = $ext_pathname;

			// Try to load extension itself
			$extension = self::load($meta_json);
			if ($extension != null) {
				self::register($extension);
			}
		}
	}

	/**
	 * Indicates if the given parameter is a valid metadata array.
	 *
	 * Required fields are:
	 * - `name`: the name of the extension
	 * - `entry_point`: a class name to load the extension source code
	 * If the extension class name is `TestExtension`, entry point will be `Test`.
	 * `entry_point` must be composed of alphanumeric characters.
	 *
	 * @param array{'name':string,'entrypoint':string,'path':string,'author'?:string,'description'?:string,'version'?:string,'type'?:'system'|'user'} $meta
	 * is an array of values.
	 * @return bool true if the array is valid, false else.
	 */
	private static function isValidMetadata(array $meta): bool {
		$valid_chars = ['_'];
		return !(empty($meta['name']) || empty($meta['entrypoint']) || !ctype_alnum(str_replace($valid_chars, '', $meta['entrypoint'])));
	}

	/**
	 * Load the extension source code based on info metadata.
	 *
	 * @param array{'name':string,'entrypoint':string,'path':string,'author'?:string,'description'?:string,'version'?:string,'type'?:'system'|'user'} $info
	 * an array containing information about extension.
	 * @return Minz_Extension|null an extension inheriting from Minz_Extension.
	 */
	private static function load(array $info): ?Minz_Extension {
		$entry_point_filename = $info['path'] . '/' . self::$ext_entry_point;
		$ext_class_name = $info['entrypoint'] . 'Extension';

		include_once $entry_point_filename;

		// Test if the given extension class exists.
		if (!class_exists($ext_class_name)) {
			Minz_Log::warning("`{$ext_class_name}` cannot be found in `{$entry_point_filename}`");
			return null;
		}

		// Try to load the class.
		$extension = null;
		try {
			$extension = new $ext_class_name($info);
		} catch (Exception $e) {
			// We cannot load the extension? Invalid!
			Minz_Log::warning("Invalid extension `{$ext_class_name}`: " . $e->getMessage());
			return null;
		}

		// Test if class is correct.
		if (!($extension instanceof Minz_Extension)) {
			Minz_Log::warning("`{$ext_class_name}` is not an instance of `Minz_Extension`");
			return null;
		}

		return $extension;
	}

	/**
	 * Add the extension to the list of the known extensions ($ext_list).
	 *
	 * If the extension is present in $ext_auto_enabled and if its type is "system",
	 * it will be enabled at the same time.
	 *
	 * @param Minz_Extension $ext a valid extension.
	 */
	private static function register(Minz_Extension $ext): void {
		$name = $ext->getName();
		self::$ext_list[$name] = $ext;

		if ($ext->getType() === 'system' && !empty(self::$ext_auto_enabled[$name])) {
			self::enable($ext->getName(), 'system');
		}
	}

	/**
	 * Enable an extension so it will be called when necessary.
	 *
	 * The extension init() method will be called.
	 *
	 * @param string $ext_name is the name of a valid extension present in $ext_list.
	 * @param 'system'|'user'|null $onlyOfType only enable if the extension matches that type. Set to null to load all.
	 */
	private static function enable(string $ext_name, ?string $onlyOfType = null): void {
		if (isset(self::$ext_list[$ext_name])) {
			$ext = self::$ext_list[$ext_name];

			if ($onlyOfType !== null && $ext->getType() !== $onlyOfType) {
				// Do not enable an extension of the wrong type
				return;
			}

			self::$ext_list_enabled[$ext_name] = $ext;

			if (method_exists($ext, 'autoload')) {
				spl_autoload_register([$ext, 'autoload']);
			}
			$ext->enable();
			try {
				$ext->init();
			} catch (Minz_Exception $e) {	// @phpstan-ignore catch.neverThrown (Thrown by extensions)
				Minz_Log::warning('Error while enabling extension ' . $ext->getName() . ': ' . $e->getMessage());
				$ext->disable();
				unset(self::$ext_list_enabled[$ext_name]);
			}
		}
	}

	/**
	 * Enable a list of extensions.
	 *
	 * @param array<string,bool> $ext_list the names of extensions we want to load.
	 * @param 'system'|'user'|null $onlyOfType limit the extensions to load to those of those type. Set to null string to load all.
	 */
	public static function enableByList(?array $ext_list, ?string $onlyOfType = null): void {
		if (empty($ext_list)) {
			return;
		}
		foreach ($ext_list as $ext_name => $ext_status) {
			if ($ext_status && is_string($ext_name)) {
				self::enable($ext_name, $onlyOfType);
			}
		}
	}

	/**
	 * Return a list of extensions.
	 *
	 * @param bool $only_enabled if true returns only the enabled extensions (false by default).
	 * @return Minz_Extension[] an array of extensions.
	 */
	public static function listExtensions(bool $only_enabled = false): array {
		if ($only_enabled) {
			return self::$ext_list_enabled;
		} else {
			return self::$ext_list;
		}
	}

	/**
	 * Return an extension by its name.
	 *
	 * @param string $ext_name the name of the extension.
	 * @return Minz_Extension|null the corresponding extension or null if it doesn't exist.
	 */
	public static function findExtension(string $ext_name): ?Minz_Extension {
		if (!isset(self::$ext_list[$ext_name])) {
			return null;
		}

		return self::$ext_list[$ext_name];
	}

	/**
	 * Add a hook function to a given hook.
	 *
	 * The hook name must be a valid one. For the valid list, see Minz_HookType enum.
	 *
	 * @param string|Minz_HookType $hook_type the hook name (must exist).
	 * @param callable $hook_function the function name to call (must be callable).
	 * @param int $priority the priority of the hook, default priority is 0, the higher the value the lower the priority
	 */
	public static function addHook(string|Minz_HookType $hook_type, $hook_function, int $priority = Minz_Hook::DEFAULT_PRIORITY): void {
		if (null === $hook_type = self::extractHookType($hook_type)) {
			return;
		}
		$hook_type_name = $hook_type->value;

		if (is_callable($hook_function)) {
			self::$hook_list[$hook_type_name]['list'][] = new Minz_Hook(\Closure::fromCallable($hook_function), $priority);
		}
	}

	/**
	 * @param string|Minz_HookType $hook_type the hook type or its name
	 * @return Minz_HookType|null
	 */
	private static function extractHookType(string|Minz_HookType $hook_type) {
		if ($hook_type instanceof Minz_HookType) {
			return $hook_type;
		}

		return Minz_HookType::tryFrom($hook_type);
	}

	/**
	 * @param Minz_HookType $hook_type the hook type or its name
	 * @return list<Minz_Hook>
	 */
	private static function retrieveHookList(Minz_HookType $hook_type): array {
		$list = self::$hook_list[$hook_type->value]['list'] ?? [];
		usort($list, static fn (Minz_Hook $a, Minz_Hook $b): int => $a->getPriority() <=> $b->getPriority());

		return $list;
	}

	/**
	 * Call functions related to a given hook.
	 *
	 * The hook name must be a valid one. For the valid list, see Minz_HookType enum.
	 *
	 * @param string|Minz_HookType $hook_type the hook to call.
	 * @param mixed ...$args additional parameters (for signature, please see Minz_HookType enum).
	 * @return mixed|void|null final result of the called hook.
	 */
	public static function callHook(string|Minz_HookType $hook_type, ...$args) {
		if (null === $hook_type = self::extractHookType($hook_type)) {
			return;
		}

		$signature = $hook_type->signature();
		if ($signature === Minz_HookSignature::OneToOne) {
			return self::callOneToOne($hook_type, $args[0] ?? null);
		} elseif ($signature === Minz_HookSignature::PassArguments) {
			foreach (self::retrieveHookList($hook_type) as $hook) {
				$result = call_user_func($hook->getFunction(), ...$args);
				if ($result !== null) {
					return $result;
				}
			}
		} elseif ($signature === Minz_HookSignature::NoneToString) {
			return self::callHookString($hook_type);
		} elseif ($signature === Minz_HookSignature::NoneToNone) {
			self::callHookVoid($hook_type);
		}
		return;
	}

	/**
	 * Call a hook which takes one argument and return a result.
	 *
	 * The result is chained between the extension, for instance, first extension
	 * hook will receive the initial argument and return a result which will be
	 * passed as an argument to the next extension hook and so on.
	 *
	 * If a hook return a null value, the method is stopped and return null.
	 *
	 * @param Minz_HookType $hook_type is the hook type to call.
	 * @param mixed $arg is the argument to pass to the first extension hook.
	 * @return mixed|null final chained result of the hooks. If nothing is changed,
	 *         the initial argument is returned.
	 */
	private static function callOneToOne(Minz_HookType $hook_type, mixed $arg): mixed {
		$result = $arg;
		foreach (self::retrieveHookList($hook_type) as $hook) {
			$result = call_user_func($hook->getFunction(), $arg);

			if ($result === null) {
				break;
			}

			$arg = $result;
		}
		return $result;
	}

	/**
	 * Call a hook which takes no argument and returns a string.
	 *
	 * The result is concatenated between each hook and the final string is
	 * returned.
	 *
	 * @param string|Minz_HookType $hook_type is the hook to call.
	 * @return string concatenated result of the call to all the hooks.
	 */
	public static function callHookString(string|Minz_HookType $hook_type): string {
		if (null === $hook_type = self::extractHookType($hook_type)) {
			return '';
		}

		$result = '';
		foreach (self::retrieveHookList($hook_type) as $hook) {
			$return = call_user_func($hook->getFunction());
			if (is_scalar($return)) {
				$result .= $return;
			}
		}
		return $result;
	}

	/**
	 * Call a hook which takes no argument and returns nothing.
	 *
	 * This case is simpler than callOneToOne because hooks are called one by
	 * one, without any consideration of argument nor result.
	 *
	 * @param string|Minz_HookType $hook_type is the hook to call.
	 */
	public static function callHookVoid(string|Minz_HookType $hook_type): void {
		if (null === $hook_type = self::extractHookType($hook_type)) {
			return;
		}

		foreach (self::retrieveHookList($hook_type) as $hook) {
			call_user_func($hook->getFunction());
		}
	}

	/**
	 * Call a hook which takes no argument and returns nothing.
	 * Same as callHookVoid but only calls the first extension.
	 *
	 * @param string|Minz_HookType $hook_type is the hook to call.
	 */
	public static function callHookUnique(string|Minz_HookType $hook_type): bool {
		if (null === $hook_type = self::extractHookType($hook_type)) {
			throw new \RuntimeException("The “{$hook_type}” does not exist!");
		}

		foreach (self::retrieveHookList($hook_type) as $hook) {
			call_user_func($hook->getFunction());
			return true;
		}
		return false;
	}

	/**
	 * Check if a extension is enabled
	 *
	 * @param string $ext_name is the extension's name as provided in metadata.json
	 */
	public static function isExtensionEnabled(string $ext_name): bool {
		return isset(self::$ext_list_enabled[$ext_name]);
	}
}
