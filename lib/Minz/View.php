<?php
declare(strict_types=1);

/**
 * MINZ - Copyright 2011 Marien Fressinaud
 * Sous licence AGPL3 <http://www.gnu.org/licenses/>
*/

/**
 * The Minz_View represents a view in the MVC paradigm
 */
class Minz_View {
	private const VIEWS_PATH_NAME = '/views';
	private const LAYOUT_PATH_NAME = '/layout/';
	private const LAYOUT_DEFAULT = 'layout';

	private string $view_filename = '';
	private string $layout_filename = '';
	/** @var array<string> */
	private static array $base_pathnames = [APP_PATH];
	private static string $title = '';
	/** @var array<array{media:string,url:string}> */
	private static array $styles = [];
	/** @var array<array{url:string,id:string,defer:bool,async:bool}> */
	private static array $scripts = [];
	/** @var string|array{dark?:string,light?:string,default?:string} */
	private static $themeColors;
	/** @var array<string,mixed> */
	private static array $params = [];

	/**
	 * Determines if a layout is used or not
	 * @throws Minz_ConfigurationException
	 */
	public function __construct() {
		$this->_layout(self::LAYOUT_DEFAULT);
		$conf = Minz_Configuration::get('system');
		self::$title = $conf->title;
	}

	/**
	 * @deprecated Change the view file based on controller and action.
	 */
	public function change_view(string $controller_name, string $action_name): void {
		Minz_Log::warning('Minz_View::change_view is deprecated, it will be removed in a future version. Please use Minz_View::_path instead.');
		$this->_path($controller_name . '/' . $action_name . '.phtml');
	}

	/**
	 * Change the view file based on a pathname relative to VIEWS_PATH_NAME.
	 *
	 * @param string $path the new path
	 */
	public function _path(string $path): void {
		$this->view_filename = self::VIEWS_PATH_NAME . '/' . $path;
	}

	/**
	 * Add a base pathname to search views.
	 *
	 * New pathnames will be added at the beginning of the list.
	 *
	 * @param string $base_pathname the new base pathname.
	 */
	public static function addBasePathname(string $base_pathname): void {
		array_unshift(self::$base_pathnames, $base_pathname);
	}

	/**
	 * Builds the view filename based on controller and action.
	 */
	public function build(): void {
		if ($this->layout_filename !== '') {
			$this->buildLayout();
		} else {
			$this->render();
		}
	}

	/**
	 * Include a view file.
	 *
	 * The file is searched inside list of $base_pathnames.
	 *
	 * @param string $filename the name of the file to include.
	 * @return bool true if the file has been included, false else.
	 */
	private function includeFile(string $filename): bool {
		// We search the filename in the list of base pathnames. Only the first view
		// found is considered.
		foreach (self::$base_pathnames as $base) {
			$absolute_filename = $base . $filename;
			if (file_exists($absolute_filename)) {
				include $absolute_filename;
				return true;
			}
		}

		return false;
	}

	/**
	 * Builds the layout
	 */
	public function buildLayout(): void {
		header('Content-Type: text/html; charset=UTF-8');
		if (!$this->includeFile($this->layout_filename)) {
			Minz_Log::notice('File not found: `' . $this->layout_filename . '`');
		}
	}

	/**
	 * Displays the View itself
	 */
	public function render(): void {
		if (!$this->includeFile($this->view_filename)) {
			Minz_Log::notice('File not found: `' . $this->view_filename . '`');
		}
	}

	public function renderToString(): string {
		ob_start();
		$this->render();
		return ob_get_clean() ?: '';
	}

	/**
	 * Adds a layout element
	 * @param string $part the partial element to be added
	 */
	public function partial(string $part): void {
		$fic_partial = self::LAYOUT_PATH_NAME . '/' . $part . '.phtml';
		if (!$this->includeFile($fic_partial)) {
			Minz_Log::warning('File not found: `' . $fic_partial . '`');
		}
	}

	/**
	 * Displays a graphic element located in APP./views/helpers/
	 * @param string $helper the element to be displayed
	 */
	public function renderHelper(string $helper): void {
		$fic_helper = '/views/helpers/' . $helper . '.phtml';
		if (!$this->includeFile($fic_helper)) {
			Minz_Log::warning('File not found: `' . $fic_helper . '`');
		}
	}

	/**
	 * Returns renderHelper() in a string
	 * @param string $helper the element to be treated
	 */
	public function helperToString(string $helper): string {
		ob_start();
		$this->renderHelper($helper);
		return ob_get_clean() ?: '';
	}

	/**
	 * Choose the current view layout.
	 * @param string|null $layout the layout name to use, null to use no layouts.
	 */
	public function _layout(?string $layout): void {
		if ($layout != null) {
			$this->layout_filename = self::LAYOUT_PATH_NAME . $layout . '.phtml';
		} else {
			$this->layout_filename = '';
		}
	}

	/**
	 * Choose if we want to use the layout or not.
	 * @deprecated Please use the `_layout` function instead.
	 * @param bool $use true if we want to use the layout, false else
	 */
	public function _useLayout(bool $use): void {
		Minz_Log::warning('Minz_View::_useLayout is deprecated, it will be removed in a future version. Please use Minz_View::_layout instead.');
		if ($use) {
			$this->_layout(self::LAYOUT_DEFAULT);
		} else {
			$this->_layout(null);
		}
	}

	/**
	 * Title management
	 */
	public static function title(): string {
		return self::$title;
	}
	public static function headTitle(): string {
		return '<title>' . self::$title . '</title>' . "\n";
	}
	public static function _title(string $title): void {
		self::$title = $title;
	}
	public static function prependTitle(string $title): void {
		self::$title = $title . self::$title;
	}
	public static function appendTitle(string $title): void {
		self::$title = self::$title . $title;
	}

	/**
	 * Style sheet management
	 */
	public static function headStyle(): string {
		$styles = '';
		foreach (self::$styles as $style) {
			$styles .= '<link rel="stylesheet" ' .
				($style['media'] === 'all' ? '' : 'media="' . $style['media'] . '" ') .
				'href="' . $style['url'] . '" />';
			$styles .= "\n";
		}

		return $styles;
	}

	/**
	 * Prepends a <link> element referencing stylesheet.
	 * @param bool $cond Conditional comment for IE, now deprecated and ignored @deprecated
	 */
	public static function prependStyle(string $url, string $media = 'all', bool $cond = false): void {
		if ($url === '') {
			return;
		}
		array_unshift(self::$styles, [
			'url' => $url,
			'media' => $media,
		]);
	}

	/**
	 * Append a `<link>` element referencing stylesheet.
	 * @param bool $cond Conditional comment for IE, now deprecated and ignored @deprecated
	 */
	public static function appendStyle(string $url, string $media = 'all', bool $cond = false): void {
		if ($url === '') {
			return;
		}
		self::$styles[] = [
			'url' => $url,
			'media' => $media,
		];
	}

	/**
	 * @param string|array{dark?:string,light?:string,default?:string} $themeColors
	 */
	public static function appendThemeColors(string|array $themeColors): void {
		self::$themeColors = $themeColors;
	}

	/**
	 * https://developer.mozilla.org/en-US/docs/Web/HTML/Element/meta/name/theme-color
	 */
	public static function metaThemeColor(): string {
		$meta = '';
		if (is_array(self::$themeColors)) {
			if (!empty(self::$themeColors['light'])) {
				$meta .= '<meta name="theme-color" media="(prefers-color-scheme: light)" content="' . htmlspecialchars(self::$themeColors['light']) . '" />';
			}
			if (!empty(self::$themeColors['dark'])) {
				$meta .= '<meta name="theme-color" media="(prefers-color-scheme: dark)" content="' . htmlspecialchars(self::$themeColors['dark']) . '" />';
			}
			if (!empty(self::$themeColors['default'])) {
				$meta .= '<meta name="theme-color" content="' . htmlspecialchars(self::$themeColors['default']) . '" />';
			}
		} elseif (is_string(self::$themeColors)) {
			$meta .= '<meta name="theme-color" content="' . htmlspecialchars(self::$themeColors) . '" />';
		}
		return $meta;
	}

	/**
	 * JS script management
	 */
	public static function headScript(): string {
		$scripts = '';
		foreach (self::$scripts as $script) {
			$scripts .= '<script src="' . $script['url'] . '"';
			if (!empty($script['id'])) {
				$scripts .= ' id="' . $script['id'] . '"';
			}
			if ($script['defer']) {
				$scripts .= ' defer="defer"';
			}
			if ($script['async']) {
				$scripts .= ' async="async"';
			}
			$scripts .= '></script>';
			$scripts .= "\n";
		}

		return $scripts;
	}
	/**
	 * Prepend a `<script>` element.
	 * @param bool $cond Conditional comment for IE, now deprecated and ignored @deprecated
	 * @param bool $defer Use `defer` flag
	 * @param bool $async Use `async` flag
	 * @param string $id Add a script `id` attribute
	 */
	public static function prependScript(string $url, bool $cond = false, bool $defer = true, bool $async = true, string $id = ''): void {
		if ($url === '') {
			return;
		}
		array_unshift(self::$scripts, [
			'url' => $url,
			'defer' => $defer,
			'async' => $async,
			'id' => $id,
		]);
	}

	/**
	 * Append a `<script>` element.
	 * @param bool $cond Conditional comment for IE, now deprecated and ignored @deprecated
	 * @param bool $defer Use `defer` flag
	 * @param bool $async Use `async` flag
	 * @param string $id Add a script `id` attribute
	 */
	public static function appendScript(string $url, bool $cond = false, bool $defer = true, bool $async = true, string $id = ''): void {
		if ($url === '') {
			return;
		}
		self::$scripts[] = [
			'url' => $url,
			'defer' => $defer,
			'async' => $async,
			'id' => $id,
		];
	}

	/**
	 * Management of parameters added to the view
	 */
	public static function _param(string $key, mixed $value): void {
		self::$params[$key] = $value;
	}

	public function attributeParams(): void {
		foreach (Minz_View::$params as $key => $value) {
			// @phpstan-ignore property.dynamicName
			$this->$key = $value;
		}
	}
}
