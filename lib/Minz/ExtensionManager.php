<?php

/**
 * An extension manager to load extensions present in EXTENSIONS_PATH.
 */
class Minz_ExtensionManager {
	private static $ext_metaname = 'metadata.json';
	private static $ext_entry_point = 'extension.php';
	private static $ext_list = array();
	private static $ext_list_enabled = array();

	private static $ext_auto_enabled = array();

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
		$list_potential_extensions = array_values(array_diff(
			scandir(EXTENSIONS_PATH),
			array('..', '.')
		));

		self::$ext_auto_enabled = Minz_Configuration::extensionsEnabled();

		foreach ($list_potential_extensions as $ext_dir) {
			$ext_pathname = EXTENSIONS_PATH . '/' . $ext_dir;
			$metadata_filename = $ext_pathname . '/' . self::$ext_metaname;

			// Try to load metadata file.
			if (!file_exists($metadata_filename)) {
				// No metadata file? Invalid!
				continue;
			}
			$meta_raw_content = file_get_contents($metadata_filename);
			$meta_json = json_decode($meta_raw_content, true);
			if (!$meta_json || !self::is_valid_metadata($meta_json)) {
				// metadata.json is not a json file? Invalid!
				// or metadata.json is invalid (no required information), invalid!
				Minz_Log::warning('`' . $metadata_filename . '` is not a valid metadata file');
				continue;
			}

			$meta_json['path'] = $ext_pathname;

			// Try to load extension itself
			$extension = self::load($meta_json);
			if (!is_null($extension)) {
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
	 * @param $meta is an array of values.
	 * @return true if the array is valid, false else.
	 */
	public static function is_valid_metadata($meta) {
		return !(empty($meta['name']) ||
		         empty($meta['entrypoint']) ||
		         !ctype_alnum($meta['entrypoint']));
	}

	/**
	 * Load the extension source code based on info metadata.
	 *
	 * @param $info an array containing information about extension.
	 * @return an extension inheriting from Minz_Extension.
	 */
	public static function load($info) {
		$entry_point_filename = $info['path'] . '/' . self::$ext_entry_point;
		$ext_class_name = $info['entrypoint'] . 'Extension';

		include($entry_point_filename);

		// Test if the given extension class exists.
		if (!class_exists($ext_class_name)) {
			Minz_Log::warning('`' . $ext_class_name .
			                  '` cannot be found in `' . $entry_point_filename . '`');
			return null;
		}

		// Try to load the class.
		$extension = null;
		try {
			$extension = new $ext_class_name($info);
		} catch (Minz_ExtensionException $e) {
			// We cannot load the extension? Invalid!
			Minz_Log::warning('In `' . $metadata_filename . '`: ' . $e->getMessage());
			return null;
		}

		// Test if class is correct.
		if (!($extension instanceof Minz_Extension)) {
			Minz_Log::warning('`' . $ext_class_name .
			                  '` is not an instance of `Minz_Extension`');
			return null;
		}

		return $extension;
	}

	/**
	 * Add the extension to the list of the known extensions ($ext_list).
	 *
	 * If the extension is present in $ext_auto_enabled and if its type is "system",
	 * it will be enabled in the same time.
	 *
	 * @param $ext a valid extension.
	 */
	public static function register($ext) {
		$name = $ext->getName();
		self::$ext_list[$name] = $ext;

		if ($ext->getType() === 'system' &&
				in_array($name, self::$ext_auto_enabled)) {
			self::enable($ext->getName());
		}
	}

	/**
	 * Enable an extension so it will be called when necessary.
	 *
	 * The extension init() method will be called.
	 *
	 * @param $ext_name is the name of a valid extension present in $ext_list.
	 */
	public static function enable($ext_name) {
		if (isset(self::$ext_list[$ext_name])) {
			$ext = self::$ext_list[$ext_name];
			self::$ext_list_enabled[$ext_name] = $ext;
			$ext->enable();
			$ext->init();
		}
	}

	/**
	 * Enable a list of extensions.
	 *
	 * @param $ext_list the names of extensions we want to load.
	 */
	public static function enable_by_list($ext_list) {
		foreach ($ext_list as $ext_name) {
			self::enable($ext_name);
		}
	}



	/**
	 * Returns a list of extensions.
	 *
	 * @param $only_enabled if true returns only the enabled extensions (false by default).
	 * @return an array of extensions.
	 */
	public static function list_extensions($only_enabled = false) {
		if ($only_enabled) {
			return self::$ext_list_enabled;
		} else {
			return self::$ext_list;
		}
	}
}
