<?php

/**
 * The extension base class.
 */
abstract class Minz_Extension {
	private $name;
	private $entrypoint;
	private $path;
	private $author;
	private $description;
	private $version;
	private $type;
	private $config_key = 'extensions';
	private $user_configuration;
	private $system_configuration;

	public static $authorized_types = array(
		'system',
		'user',
	);

	private $is_enabled;

	/**
	 * The constructor to assign specific information to the extension.
	 *
	 * Available fields are:
	 * - name: the name of the extension (required).
	 * - entrypoint: the extension class name (required).
	 * - path: the pathname to the extension files (required).
	 * - author: the name and / or email address of the extension author.
	 * - description: a short description to describe the extension role.
	 * - version: a version for the current extension.
	 * - type: "system" or "user" (default).
	 *
	 * @param $meta_info contains information about the extension.
	 */
	final public function __construct($meta_info) {
		$this->name = $meta_info['name'];
		$this->entrypoint = $meta_info['entrypoint'];
		$this->path = $meta_info['path'];
		$this->author = isset($meta_info['author']) ? $meta_info['author'] : '';
		$this->description = isset($meta_info['description']) ? $meta_info['description'] : '';
		$this->version = isset($meta_info['version']) ? $meta_info['version'] : '0.1';
		$this->setType(isset($meta_info['type']) ? $meta_info['type'] : 'user');

		$this->is_enabled = false;
	}

	/**
	 * Used when installing an extension (e.g. update the database scheme).
	 *
	 * @return true if the extension has been installed or a string explaining
	 *         the problem.
	 */
	public function install() {
		return true;
	}

	/**
	 * Used when uninstalling an extension (e.g. revert the database scheme to
	 * cancel changes from install).
	 *
	 * @return true if the extension has been uninstalled or a string explaining
	 *         the problem.
	 */
	public function uninstall() {
		return true;
	}

	/**
	 * Call at the initialization of the extension (i.e. when the extension is
	 * enabled by the extension manager).
	 */
	abstract public function init();

	/**
	 * Set the current extension to enable.
	 */
	public function enable() {
		$this->is_enabled = true;
	}

	/**
	 * Return if the extension is currently enabled.
	 *
	 * @return true if extension is enabled, false else.
	 */
	public function isEnabled() {
		return $this->is_enabled;
	}

	/**
	 * Return the content of the configure view for the current extension.
	 *
	 * @return string html content from ext_dir/configure.phtml, false if it does not exist.
	 */
	public function getConfigureView() {
		$filename = $this->path . '/configure.phtml';
		if (!file_exists($filename)) {
			return false;
		}

		ob_start();
		include($filename);
		return ob_get_clean();
	}

	/**
	 * Handle the configure action.
	 */
	public function handleConfigureAction() {}

	/**
	 * Getters and setters.
	 */
	public function getName() {
		return $this->name;
	}
	public function getEntrypoint() {
		return $this->entrypoint;
	}
	public function getPath() {
		return $this->path;
	}
	public function getAuthor() {
		return $this->author;
	}
	public function getDescription() {
		return $this->description;
	}
	public function getVersion() {
		return $this->version;
	}
	public function getType() {
		return $this->type;
	}
	private function setType($type) {
		if (!in_array($type, self::$authorized_types)) {
			throw new Minz_ExtensionException('invalid `type` info', $this->name);
		}
		$this->type = $type;
	}

	/**
	 * Return the url for a given file.
	 *
	 * @param $filename name of the file to serve.
	 * @param $type the type (js or css) of the file to serve.
	 * @param $isStatic indicates if the file is a static file or a user file. Default is static.
	 * @return string url corresponding to the file.
	 */
	public function getFileUrl($filename, $type, $isStatic = true) {
		if ($isStatic) {
			$dir = basename($this->path);
			$file_name_url = urlencode("{$dir}/static/{$filename}");
			$mtime = @filemtime("{$this->path}/static/{$filename}");
		} else {
			$username = Minz_Session::param('currentUser');
			$path = USERS_PATH . "/{$username}/{$this->config_key}/{$this->getName()}/{$filename}";
			$file_name_url = urlencode("{$username}/{$this->config_key}/{$this->getName()}/{$filename}");
			$mtime = @filemtime($path);
		}

		return Minz_Url::display("/ext.php?f={$file_name_url}&amp;t={$type}&amp;{$mtime}", 'php');
	}

	/**
	 * Register a controller in the Dispatcher.
	 *
	 * @param @base_name the base name of the controller. Final name will be:
	 *                   FreshExtension_<base_name>_Controller.
	 */
	public function registerController($base_name) {
		Minz_Dispatcher::registerController($base_name, $this->path);
	}

	/**
	 * Register the views in order to be accessible by the application.
	 */
	public function registerViews() {
		Minz_View::addBasePathname($this->path);
	}

	/**
	 * Register i18n files from ext_dir/i18n/
	 */
	public function registerTranslates() {
		$i18n_dir = $this->path . '/i18n';
		Minz_Translate::registerPath($i18n_dir);
	}

	/**
	 * Register a new hook.
	 *
	 * @param $hook_name the hook name (must exist).
	 * @param $hook_function the function name to call (must be callable).
	 */
	public function registerHook($hook_name, $hook_function) {
		Minz_ExtensionManager::addHook($hook_name, $hook_function, $this);
	}

	/**
	 * @return bool
	 */
	private function isConfigurationEnabled(string $type) {
		if (!class_exists('FreshRSS_Context', false)) {
			return false;
		}

		$conf = "{$type}_conf";
		if (null === FreshRSS_Context::$$conf) {
			return false;
		}

		return true;
	}

	/**
	 * @return bool
	 */
	private function isExtensionConfigured(string $type) {
		$conf = "{$type}_conf";

		if (!FreshRSS_Context::$$conf->hasParam($this->config_key)) {
			return false;
		}

		$extensions = FreshRSS_Context::$$conf->{$this->config_key};
		return array_key_exists($this->getName(), $extensions);
	}

	/**
	 * @return array
	 */
	private function getConfiguration(string $type) {
		if (!$this->isConfigurationEnabled($type)) {
			return [];
		}

		if (!$this->isExtensionConfigured($type)) {
			return [];
		}

		$conf = "{$type}_conf";
		return FreshRSS_Context::$$conf->{$this->config_key}[$this->getName()];
	}

	/**
	 * @return array
	 */
	public function getSystemConfiguration() {
		return $this->getConfiguration('system');
	}

	/**
	 * @return array
	 */
	public function getUserConfiguration() {
		return $this->getConfiguration('user');
	}

	/**
	 * @param mixed $default
	 * @return mixed
	 */
	public function getSystemConfigurationValue(string $key, $default = null) {
		if (!is_array($this->system_configuration)) {
			$this->system_configuration = $this->getSystemConfiguration();
		}

		if (array_key_exists($key, $this->system_configuration)) {
			return $this->system_configuration[$key];
		}
		return $default;
	}

	/**
	 * @param mixed $default
	 * @return mixed
	 */
	public function getUserConfigurationValue(string $key, $default = null) {
		if (!is_array($this->user_configuration)) {
			$this->user_configuration = $this->getUserConfiguration();
		}

		if (array_key_exists($key, $this->user_configuration)) {
			return $this->user_configuration[$key];
		}
		return $default;
	}

	private function setConfiguration(string $type, array $configuration) {
		$conf = "{$type}_conf";

		if (FreshRSS_Context::$$conf->hasParam($this->config_key)) {
			$extensions = FreshRSS_Context::$$conf->{$this->config_key};
		} else {
			$extensions = [];
		}
		$extensions[$this->getName()] = $configuration;

		FreshRSS_Context::$$conf->{$this->config_key} = $extensions;
		FreshRSS_Context::$$conf->save();
	}

	public function setSystemConfiguration(array $configuration) {
		$this->setConfiguration('system', $configuration);
		$this->system_configuration = $configuration;
	}

	public function setUserConfiguration(array $configuration) {
		$this->setConfiguration('user', $configuration);
		$this->user_configuration = $configuration;
	}

	private function removeConfiguration(string $type) {
		if (!$this->isConfigurationEnabled($type)) {
			return;
		}

		if (!$this->isExtensionConfigured($type)) {
			return;
		}

		$conf = "{$type}_conf";
		$extensions = FreshRSS_Context::$$conf->{$this->config_key};
		unset($extensions[$this->getName()]);
		if (empty($extensions)) {
			$extensions = null;
		}

		FreshRSS_Context::$$conf->{$this->config_key} = $extensions;
		FreshRSS_Context::$$conf->save();
	}

	public function removeSystemConfiguration() {
		$this->removeConfiguration('system');
		$this->system_configuration = null;
	}

	public function removeUserConfiguration() {
		$this->removeConfiguration('user');
		$this->user_configuration = null;
	}

	public function saveFile(string $filename, string $content) {
		$username = Minz_Session::param('currentUser');
		$path = USERS_PATH . "/{$username}/{$this->config_key}/{$this->getName()}";

		if (!file_exists($path)) {
			mkdir($path, 0777, true);
		}

		file_put_contents("{$path}/{$filename}", $content);
	}

	public function removeFile(string $filename) {
		$username = Minz_Session::param('currentUser');
		$path = USERS_PATH . "/{$username}/{$this->config_key}/{$this->getName()}/{$filename}";

		if (file_exists($path)) {
			unlink($path);
		}
	}
}
