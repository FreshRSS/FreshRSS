<?php
declare(strict_types=1);

/**
 * Manage configuration for the application.
 * @property string $base_url
 * @property array{type:'mysql'|'pgsql'|'sqlite',host:string,user:string,password:string,base:string,prefix:string,
 *  connection_uri_params:string,pdo_options:array<int,int|string|bool>} $db
 * @property bool $disable_update
 * @property string $environment
 * @property array<string,bool> $extensions_enabled
 * @property-read string $mailer
 * @property-read array{'hostname':string,'host':string,'auth':bool,'username':string,'password':string,'secure':string,'port':int,'from':string} $smtp
 * @property string $title
 */
class Minz_Configuration {
	/**
	 * The list of configurations.
	 * @var array<string,static>
	 */
	private static array $config_list = [];

	/**
	 * Add a new configuration to the list of configuration.
	 *
	 * @param string $namespace the name of the current configuration
	 * @param string $config_filename the filename of the configuration
	 * @param string $default_filename a filename containing default values for the configuration
	 * @param Minz_ConfigurationSetterInterface $configuration_setter an optional helper to set values in configuration @deprecated
	 * @throws Minz_FileNotExistException
	 */
	public static function register(string $namespace, string $config_filename, ?string $default_filename = null,
		?Minz_ConfigurationSetterInterface $configuration_setter = null): void {
		self::$config_list[$namespace] = new static(
			$namespace, $config_filename, $default_filename, $configuration_setter
		);
	}

	/**
	 * Parse a file and return its data.
	 *
	 * @param string $filename the name of the file to parse.
	 * @return array<string,mixed> of values
	 * @throws Minz_FileNotExistException if the file does not exist or is invalid.
	 */
	public static function load(string $filename): array {
		$data = @include $filename;
		if (is_array($data) && is_array_keys_string($data)) {
			return $data;
		} else {
			throw new Minz_FileNotExistException($filename);
		}
	}

	/**
	 * Return the configuration related to a given namespace.
	 *
	 * @param string $namespace the name of the configuration to get.
	 * @throws Minz_ConfigurationNamespaceException if the namespace does not exist.
	 */
	public static function get(string $namespace): static {
		if (!isset(self::$config_list[$namespace])) {
			throw new Minz_ConfigurationNamespaceException(
				$namespace . ' namespace does not exist'
			);
		}

		return self::$config_list[$namespace];
	}

	/**
	 * The namespace of the current configuration.
	 * Unused.
	 * @phpstan-ignore property.onlyWritten
	 */
	private string $namespace = '';

	/**
	 * The filename for the current configuration.
	 */
	private string $config_filename = '';

	/**
	 * The filename for the current default values, null by default.
	 */
	private ?string $default_filename = null;

	/**
	 * The configuration values, an empty array by default.
	 * @var array<string,mixed>
	 */
	private array $data = [];

	/**
	 * An object which help to set good values in configuration.
	 */
	private ?Minz_ConfigurationSetterInterface $configuration_setter = null;

	/**
	 * Create a new Minz_Configuration object.
	 *
	 * @param string $namespace the name of the current configuration.
	 * @param string $config_filename the file containing configuration values.
	 * @param string $default_filename the file containing default values, null by default.
	 * @param Minz_ConfigurationSetterInterface $configuration_setter an optional helper to set values in configuration @deprecated
	 * @throws Minz_FileNotExistException
	 */
	final private function __construct(string $namespace, string $config_filename, ?string $default_filename = null,
		?Minz_ConfigurationSetterInterface $configuration_setter = null) {
		$this->namespace = $namespace;
		$this->config_filename = $config_filename;
		$this->default_filename = $default_filename;
		$this->_configurationSetter($configuration_setter);

		if ($this->default_filename != null) {
			$this->data = self::load($this->default_filename);
		}

		try {
			$overloaded = array_replace_recursive(
				$this->data, self::load($this->config_filename)
			);
			$this->data = array_filter($overloaded, 'is_string', ARRAY_FILTER_USE_KEY);
		} catch (Minz_FileNotExistException $e) {
			if ($this->default_filename == null) {
				throw $e;
			}
		}
	}

	/**
	 * Set a configuration setter for the current configuration.
	 * @param Minz_ConfigurationSetterInterface|null $configuration_setter the setter to call when modifying data.
	 */
	public function _configurationSetter(?Minz_ConfigurationSetterInterface $configuration_setter): void {
		if (is_callable([$configuration_setter, 'handle'])) {
			$this->configuration_setter = $configuration_setter;
		}
	}

	#[Deprecated]
	public function configurationSetter(): ?Minz_ConfigurationSetterInterface {
		return $this->configuration_setter;
	}

	/**
	 * Check if a parameter is defined in the configuration
	 */
	public function hasParam(string $key): bool {
		return isset($this->data[$key]);
	}

	/**
	 * Return the value of the given param.
	 *
	 * @param string $key the name of the param.
	 * @param mixed $default default value to return if key does not exist.
	 * @return array|mixed value corresponding to the key.
	 */
	#[Deprecated('Use `attribute*()` methods instead.')]
	public function param(string $key, mixed $default = null): mixed {
		if (isset($this->data[$key])) {
			return $this->data[$key];
		} elseif ($default !== null) {
			return $default;
		} else {
			Minz_Log::warning($key . ' does not exist in configuration');
			return null;
		}
	}

	/**
	 * @return array|mixed
	 */
	public function __get(string $key): mixed {
		if (isset($this->data[$key])) {
			return $this->data[$key];
		}
		Minz_Log::warning($key . ' does not exist in configuration');
		return null;
	}

	/**
	 * Set or remove a param.
	 *
	 * @param string $key the param name to set.
	 * @param mixed $value the value to set. If null, the key is removed from the configuration.
	 */
	#[Deprecated('Use `_attribute()` instead.')]
	public function _param(string $key, mixed $value = null): void {
		if ($this->configuration_setter !== null && $this->configuration_setter->support($key)) {
			$this->configuration_setter->handle($this->data, $key, $value);
		} elseif (isset($this->data[$key]) && $value === null) {
			unset($this->data[$key]);
		} elseif ($value !== null) {
			$this->data[$key] = $value;
		}
	}

	/**
	 * {@see Minz_Configuration::_attribute()} instead.
	 * @param string $key the param name to set.
	 * @param mixed $value the value to set. If null, the key is removed.
	 */
	public function __set(string $key, mixed $value): void {
		if ($value === null) {
			unset($this->data[$key]);
		} else {
			$this->data[$key] = $value;
		}
	}

	/**
	 * Save the current configuration in the configuration file.
	 */
	public function save(): bool {
		$tmp_filename = $this->config_filename . '.tmp.php';
		$back_filename = $this->config_filename . '.bak.php';

		if (!file_put_contents($tmp_filename,
			"<?php\nreturn " . var_export($this->data, true) . ';', LOCK_EX)) {
			@unlink($tmp_filename);
			return false;
		}

		if (!copy($this->config_filename, $back_filename)) {
			@unlink($tmp_filename);
			return false;
		}

		@rename($tmp_filename, $this->config_filename);

		// Clear PHP cache for include
		if (function_exists('opcache_invalidate')) {
			opcache_invalidate($this->config_filename);
		}

		return true;
	}

	/**
	 * @param non-empty-string $key
	 * @return array<int|string,mixed>|null
	 */
	public function attributeArray(string $key): ?array {
		$a = $this->data[$key] ?? null;
		return is_array($a) ? $a : null;
	}

	/** @param non-empty-string $key */
	public function attributeBool(string $key): ?bool {
		$a = $this->data[$key] ?? null;
		return is_bool($a) ? $a : null;
	}

	/** @param non-empty-string $key */
	public function attributeInt(string $key): ?int {
		$a = $this->data[$key] ?? null;
		return is_numeric($a) ? (int)$a : null;
	}

	/** @param non-empty-string $key */
	public function attributeString(string $key): ?string {
		$a = $this->data[$key] ?? null;
		return is_string($a) ? $a : null;
	}

	/**
	 * @param non-empty-string $key
	 * @param array<string,mixed>|mixed|null $value Value, not HTML-encoded
	 */
	public function _attribute(string $key, $value = null): void {
		if (isset($this->data[$key]) && $value === null) {
			unset($this->data[$key]);
		} elseif ($value !== null) {
			$this->data[$key] = $value;
		}
	}
}
