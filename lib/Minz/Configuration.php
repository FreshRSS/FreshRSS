<?php

namespace Minz;

use Minz\Exception\ConfigurationNamespaceException;
use Minz\Exception\ConfigurationParamException;
use Minz\Exception\FileNotExistException;

/**
 * Manage configuration for the application.
 */
class Configuration {
	/**
	 * The list of configurations.
	 */
	private static $config_list = array();

	/**
	 * Add a new configuration to the list of configuration.
	 *
	 * @param $namespace the name of the current configuration
	 * @param $config_filename the filename of the configuration
	 * @param $default_filename a filename containing default values for the configuration
	 * @param $configuration_setter an optional helper to set values in configuration
	 */
	public static function register($namespace, $config_filename, $default_filename = null,
	                                $configuration_setter = null) {
		self::$config_list[$namespace] = new Configuration(
			$namespace, $config_filename, $default_filename, $configuration_setter
		);
	}

	/**
	 * Parse a file and return its data.
	 *
	 * @param $filename the name of the file to parse.
	 * @return an array of values
	 * @throws FileNotExistException if the file does not exist or is invalid.
	 */
	public static function load($filename) {
		$data = @include($filename);
		if (is_array($data)) {
			return $data;
		} else {
			throw new FileNotExistException($filename);
		}
	}

	/**
	 * Return the configuration related to a given namespace.
	 *
	 * @param $namespace the name of the configuration to get.
	 * @return a Configuration object
	 * @throws ConfigurationNamespaceException if the namespace does not exist.
	 */
	public static function get($namespace) {
		if (!isset(self::$config_list[$namespace])) {
			throw new ConfigurationNamespaceException(
				$namespace . ' namespace does not exist'
			);
		}

		return self::$config_list[$namespace];
	}

	/**
	 * The namespace of the current configuration.
	 */
	private $namespace = '';

	/**
	 * The filename for the current configuration.
	 */
	private $config_filename = '';

	/**
	 * The filename for the current default values, null by default.
	 */
	private $default_filename = null;

	/**
	 * The configuration values, an empty array by default.
	 */
	private $data = array();

	/**
	 * An object which help to set good values in configuration.
	 */
	private $configuration_setter = null;

	public function removeExtension($ext_name) {
		unset(self::$extensions_enabled[$ext_name]);
		$legacyKey = array_search($ext_name, self::$extensions_enabled, true);
		if ($legacyKey !== false) {	//Legacy format FreshRSS < 1.11.1
			unset(self::$extensions_enabled[$legacyKey]);
		}
	}
	public function addExtension($ext_name) {
		if (!isset(self::$extensions_enabled[$ext_name])) {
			self::$extensions_enabled[$ext_name] = true;
		}
	}

	/**
	 * Create a new Configuration object.
	 *
	 * @param $namespace the name of the current configuration.
	 * @param $config_filename the file containing configuration values.
	 * @param $default_filename the file containing default values, null by default.
	 * @param $configuration_setter an optional helper to set values in configuration
	 */
	private function __construct($namespace, $config_filename, $default_filename = null,
	                             $configuration_setter = null) {
		$this->namespace = $namespace;
		$this->config_filename = $config_filename;
		$this->default_filename = $default_filename;
		$this->_configurationSetter($configuration_setter);

		if ($this->default_filename != null) {
			$this->data = self::load($this->default_filename);
		}

		try {
			$this->data = array_replace_recursive(
				$this->data, self::load($this->config_filename)
			);
		} catch (FileNotExistException $e) {
			if ($this->default_filename == null) {
				throw $e;
			}
		}
	}

	/**
	 * Set a configuration setter for the current configuration.
	 * @param $configuration_setter the setter to call when modifying data. It
	 *        must implement an handle($key, $value) method.
	 */
	public function _configurationSetter($configuration_setter) {
		if (is_callable(array($configuration_setter, 'handle'))) {
			$this->configuration_setter = $configuration_setter;
		}
	}

	/**
	 * Return the value of the given param.
	 *
	 * @param $key the name of the param.
	 * @param $default default value to return if key does not exist.
	 * @return the value corresponding to the key.
	 * @throws ConfigurationParamException if the param does not exist
	 */
	public function param($key, $default = null) {
		if (isset($this->data[$key])) {
			return $this->data[$key];
		} elseif (!is_null($default)) {
			return $default;
		} else {
			Log::warning($key . ' does not exist in configuration');
			return null;
		}
	}

	/**
	 * A wrapper for param().
	 */
	public function __get($key) {
		return $this->param($key);
	}

	/**
	 * Set or remove a param.
	 *
	 * @param $key the param name to set.
	 * @param $value the value to set. If null, the key is removed from the configuration.
	 */
	public function _param($key, $value = null) {
		if (!is_null($this->configuration_setter) && $this->configuration_setter->support($key)) {
			$this->configuration_setter->handle($this->data, $key, $value);
		} elseif (isset($this->data[$key]) && is_null($value)) {
			unset($this->data[$key]);
		} elseif (!is_null($value)) {
			$this->data[$key] = $value;
		}
	}

	/**
	 * A wrapper for _param().
	 */
	public function __set($key, $value) {
		$this->_param($key, $value);
	}

	/**
	 * Save the current configuration in the configuration file.
	 */
	public function save() {
		$back_filename = $this->config_filename . '.bak.php';
		@rename($this->config_filename, $back_filename);

		if (file_put_contents($this->config_filename,
		                      "<?php\nreturn " . var_export($this->data, true) . ';',
		                      LOCK_EX) === false) {
			return false;
		}

		// Clear PHP cache for include
		if (function_exists('opcache_invalidate')) {
			opcache_invalidate($this->config_filename);
		}

		return true;
	}
}
