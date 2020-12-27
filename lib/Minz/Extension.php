<?php

namespace Minz;

use Minz\Exception\ExtensionException;

/**
 * The extension base class.
 */
class Extension {
	private $name;
	private $entrypoint;
	private $path;
	private $author;
	private $description;
	private $version;
	private $type;

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
	 * It must not be redefined by child classes.
	 *
	 * @param $meta_info contains information about the extension.
	 */
	public function __construct($meta_info) {
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
	 * It must be redefined by child classes.
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
	 * It must be redefined by child classes.
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
	 *
	 * It must be redefined by child classes.
	 */
	public function init() {}

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
	 * @return the html content from ext_dir/configure.phtml, false if it does
	 *         not exist.
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
	 *
	 * It must be redefined by child classes.
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
			throw new ExtensionException('invalid `type` info', $this->name);
		}
		$this->type = $type;
	}

	/**
	 * Return the url for a given file.
	 *
	 * @param $filename name of the file to serve.
	 * @param $type the type (js or css) of the file to serve.
	 * @return the url corresponding to the file.
	 */
	public function getFileUrl($filename, $type) {
		$dir = substr(strrchr($this->path, '/'), 1);
		$file_name_url = urlencode($dir . '/static/' . $filename);

		$absolute_path = $this->path . '/static/' . $filename;
		$mtime = @filemtime($absolute_path);

		$url = '/ext.php?f=' . $file_name_url .
		       '&amp;t=' . $type .
		       '&amp;' . $mtime;
		return Url::display($url, 'php');
	}

	/**
	 * Register a controller in the Dispatcher.
	 *
	 * @param @base_name the base name of the controller. Final name will be:
	 *                   FreshExtension_<base_name>_Controller.
	 */
	public function registerController($base_name) {
		Dispatcher::registerController($base_name, $this->path);
	}

	/**
	 * Register the views in order to be accessible by the application.
	 */
	public function registerViews() {
		View::addBasePathname($this->path);
	}

	/**
	 * Register i18n files from ext_dir/i18n/
	 */
	public function registerTranslates() {
		$i18n_dir = $this->path . '/i18n';
		Translate::registerPath($i18n_dir);
	}

	/**
	 * Register a new hook.
	 *
	 * @param $hook_name the hook name (must exist).
	 * @param $hook_function the function name to call (must be callable).
	 */
	public function registerHook($hook_name, $hook_function) {
		ExtensionManager::addHook($hook_name, $hook_function, $this);
	}
}
