<?php

/**
 * An extension manager to load extensions present in CORE_EXTENSIONS_PATH and THIRDPARTY_EXTENSIONS_PATH.
 *
 * @todo see coding style for methods!!
 */
class Minz_ExtensionManager {
	private static $ext_metaname = 'metadata.json';
	private static $ext_entry_point = 'extension.php';
	private static $ext_list = array();
	private static $ext_list_enabled = array();

	private static $ext_auto_enabled = array();

	// List of available hooks. Please keep this list sorted.
	private static $hook_list = array(
		'check_url_before_add' => array(	// function($url) -> Url | null
			'list' => array(),
			'signature' => 'OneToOne',
		),
		'entry_before_display' => array(	// function($entry) -> Entry | null
			'list' => array(),
			'signature' => 'OneToOne',
		),
		'entry_before_insert' => array(	// function($entry) -> Entry | null
			'list' => array(),
			'signature' => 'OneToOne',
		),
		'entry_favorite' => array(	// function(array($ids, $is_favorite)) -> true | false | null
			'list' => array(),
			'signature' => 'OneToOne',
		),
		'entry_read' => array(	// function(array($ids_max, $is_read)) -> true | false | null | function(array($id_max, [$type], $is_read)) -> true | false | null
			'list' => array(),
			'signature' => 'OneToOne',
		),
		'feed_before_actualize' => array(	// function($feed) -> Feed | null
			'list' => array(),
			'signature' => 'OneToOne',
		),
		'feed_before_insert' => array(	// function($feed) -> Feed | null
			'list' => array(),
			'signature' => 'OneToOne',
		),
		'freshrss_init' => array(	// function() -> none
			'list' => array(),
			'signature' => 'NoneToNone',
		),
		'freshrss_user_maintenance' => array(	// function() -> none
			'list' => array(),
			'signature' => 'NoneToNone',
		),
		'js_vars' => array(	// function($vars = array) -> array | null
			'list' => array(),
			'signature' => 'OneToOne',
		),
		'menu_admin_entry' => array(	// function() -> string
			'list' => array(),
			'signature' => 'NoneToString',
		),
		'menu_configuration_entry' => array(	// function() -> string
			'list' => array(),
			'signature' => 'NoneToString',
		),
		'menu_other_entry' => array(	// function() -> string
			'list' => array(),
			'signature' => 'NoneToString',
		),
		'nav_menu' => array(	// function() -> string
			'list' => array(),
			'signature' => 'NoneToString',
		),
		'nav_reading_modes' => array(	// function($readingModes = array) -> array | null
			'list' => array(),
			'signature' => 'OneToOne',
		),
		'post_update' => array(	// function(none) -> none
			'list' => array(),
			'signature' => 'NoneToNone',
		),
		'simplepie_before_init' => array(	// function($simplePie, $feed) -> none
			'list' => array(),
			'signature' => 'PassArguments',
		)
	);
	private static $ext_to_hooks = array();

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
	 */
	public static function init() {
		$list_core_extensions = array_diff(scandir(CORE_EXTENSIONS_PATH), [ '..', '.' ]);
		$list_thirdparty_extensions = array_diff(scandir(THIRDPARTY_EXTENSIONS_PATH), [ '..', '.' ], $list_core_extensions);
		array_walk($list_core_extensions, function (&$s) { $s = CORE_EXTENSIONS_PATH . '/' . $s; });
		array_walk($list_thirdparty_extensions, function (&$s) { $s = THIRDPARTY_EXTENSIONS_PATH . '/' . $s; });

		$list_potential_extensions = array_merge($list_core_extensions, $list_thirdparty_extensions);

		$system_conf = Minz_Configuration::get('system');
		self::$ext_auto_enabled = $system_conf->extensions_enabled;

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
			$meta_raw_content = file_get_contents($metadata_filename);
			$meta_json = json_decode($meta_raw_content, true);
			if (!$meta_json || !self::isValidMetadata($meta_json)) {
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
	 * @param array $meta is an array of values.
	 * @return bool true if the array is valid, false else.
	 */
	public static function isValidMetadata($meta) {
		$valid_chars = array('_');
		return !(empty($meta['name']) || empty($meta['entrypoint']) || !ctype_alnum(str_replace($valid_chars, '', $meta['entrypoint'])));
	}

	/**
	 * Load the extension source code based on info metadata.
	 *
	 * @param array $info an array containing information about extension.
	 * @return Minz_Extension|null an extension inheriting from Minz_Extension.
	 */
	public static function load($info) {
		$entry_point_filename = $info['path'] . '/' . self::$ext_entry_point;
		$ext_class_name = $info['entrypoint'] . 'Extension';

		include_once($entry_point_filename);

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
	public static function register($ext) {
		$name = $ext->getName();
		self::$ext_list[$name] = $ext;

		if ($ext->getType() === 'system' &&
				(!empty(self::$ext_auto_enabled[$name]) ||
				in_array($name, self::$ext_auto_enabled, true))) {	//Legacy format < FreshRSS 1.11.1
			self::enable($ext->getName());
		}

		self::$ext_to_hooks[$name] = array();
	}

	/**
	 * Enable an extension so it will be called when necessary.
	 *
	 * The extension init() method will be called.
	 *
	 * @param Minz_Extension $ext_name is the name of a valid extension present in $ext_list.
	 */
	public static function enable($ext_name) {
		if (isset(self::$ext_list[$ext_name])) {
			$ext = self::$ext_list[$ext_name];
			self::$ext_list_enabled[$ext_name] = $ext;

			if (method_exists($ext, 'autoload')) {
				spl_autoload_register([$ext, 'autoload']);
			}
			$ext->enable();
			$ext->init();
		}
	}

	/**
	 * Enable a list of extensions.
	 *
	 * @param string[] $ext_list the names of extensions we want to load.
	 */
	public static function enableByList($ext_list) {
		if (!is_array($ext_list)) {
			return;
		}
		foreach ($ext_list as $ext_name => $ext_status) {
			if (is_int($ext_name)) {	//Legacy format int=>name
				self::enable($ext_status);
			} elseif ($ext_status) {	//New format name=>Boolean
				self::enable($ext_name);
			}
		}
	}

	/**
	 * Return a list of extensions.
	 *
	 * @param bool $only_enabled if true returns only the enabled extensions (false by default).
	 * @return Minz_Extension[] an array of extensions.
	 */
	public static function listExtensions($only_enabled = false) {
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
	public static function findExtension($ext_name) {
		if (!isset(self::$ext_list[$ext_name])) {
			return null;
		}

		return self::$ext_list[$ext_name];
	}

	/**
	 * Add a hook function to a given hook.
	 *
	 * The hook name must be a valid one. For the valid list, see self::$hook_list
	 * array keys.
	 *
	 * @param string $hook_name the hook name (must exist).
	 * @param callable $hook_function the function name to call (must be callable).
	 * @param Minz_Extension $ext the extension which register the hook.
	 */
	public static function addHook($hook_name, $hook_function, $ext) {
		if (isset(self::$hook_list[$hook_name]) && is_callable($hook_function)) {
			self::$hook_list[$hook_name]['list'][] = $hook_function;
			self::$ext_to_hooks[$ext->getName()][] = $hook_name;
		}
	}

	/**
	 * Call functions related to a given hook.
	 *
	 * The hook name must be a valid one. For the valid list, see self::$hook_list
	 * array keys.
	 *
	 * @param string $hook_name the hook to call.
	 * @param additional parameters (for signature, please see self::$hook_list).
	 * @return mixed final result of the called hook.
	 */
	public static function callHook($hook_name) {
		if (!isset(self::$hook_list[$hook_name])) {
			return;
		}

		$signature = self::$hook_list[$hook_name]['signature'];
		$args = func_get_args();
		if ($signature === 'PassArguments') {
			array_shift($args);
			foreach (self::$hook_list[$hook_name]['list'] as $function) {
				call_user_func_array($function, $args);
			}
		} else {
			return call_user_func_array('self::call' . $signature, $args);
		}
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
	 * @param $hook_name is the hook to call.
	 * @param $arg is the argument to pass to the first extension hook.
	 * @return mixed final chained result of the hooks. If nothing is changed,
	 *         the initial argument is returned.
	 */
	private static function callOneToOne($hook_name, $arg) {
		$result = $arg;
		foreach (self::$hook_list[$hook_name]['list'] as $function) {
			$result = call_user_func($function, $arg);

			if (is_null($result)) {
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
	 * @param string $hook_name is the hook to call.
	 * @return string concatenated result of the call to all the hooks.
	 */
	private static function callNoneToString($hook_name) {
		$result = '';
		foreach (self::$hook_list[$hook_name]['list'] as $function) {
			$result = $result . call_user_func($function);
		}
		return $result;
	}

	/**
	 * Call a hook which takes no argument and returns nothing.
	 *
	 * This case is simpler than callOneToOne because hooks are called one by
	 * one, without any consideration of argument nor result.
	 *
	 * @param $hook_name is the hook to call.
	 */
	private static function callNoneToNone($hook_name) {
		foreach (self::$hook_list[$hook_name]['list'] as $function) {
			call_user_func($function);
		}
	}
}
