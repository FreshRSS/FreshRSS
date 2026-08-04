<?php
declare(strict_types=1);

namespace FreshRss\Minz;

/**
 * MINZ - Copyright 2011 Marien Fressinaud
 * Sous licence AGPL3 <http://www.gnu.org/licenses/>
*/

/**
 * The ActionController class is a controller in the MVC paradigm
 */
abstract class ActionController {

	/** @var array<string,string> */
	private static array $csp_default = [
		'default-src' => "'self'",
		'frame-ancestors' => "'none'",
	];

	/** @var array<string,string> */
	private array $csp_policies;

	/** @var View */
	protected $view;

	/**
	 * Gives the possibility to override the default view model type.
	 * @var class-string
	 * @deprecated Use constructor with view type instead
	 * @access private
	 * @internal
	 */
	public static string $defaultViewType = View::class;

	/**
	 * @phpstan-param class-string|'' $viewType
	 * @param string $viewType Name of the class (inheriting from View) to use for the view model
	 */
	public function __construct(string $viewType = '') {
		$this->csp_policies = self::$csp_default;
		$view = null;
		if ($viewType !== '' && class_exists($viewType)) {
			$view = new $viewType();
			if (!($view instanceof View)) {
				$view = null;
			}
		}
		if ($view === null && class_exists(self::$defaultViewType)) {	/// @phpstan-ignore staticProperty.deprecated
			$view = new self::$defaultViewType();	// @phpstan-ignore staticProperty.deprecated
			if (!($view instanceof View)) {
				$view = null;
			}
		}
		$this->view = $view ?? new View();
		$view_path = Request::controllerName() . '/' . Request::actionName() . '.phtml';
		$this->view->_path($view_path);
		$this->view->attributeParams();
	}

	/**
	 * Getteur
	 */
	public function view(): View {
		return $this->view;
	}

	/**
	 * Set default CSP policies.
	 * @param array<string,string> $policies An array where keys are directives and values are sources.
	 */
	public static function _defaultCsp(array $policies): void {
		if (!isset($policies['default-src']) || !isset($policies['frame-ancestors'])) {
			Log::warning('Default CSP policy is not declared', ADMIN_LOG);
		}
		self::$csp_default = $policies;
	}

	/**
	 * Set CSP policies.
	 *
	 * default-src and frame-ancestors directives should always be given.
	 *
	 * References:
	 * - https://developer.mozilla.org/en-US/docs/Web/HTTP/Guides/CSP
	 * - https://developer.mozilla.org/en-US/docs/Web/HTTP/Reference/Headers/Content-Security-Policy/default-src
	 * - https://developer.mozilla.org/en-US/docs/Web/HTTP/Reference/Headers/Content-Security-Policy/frame-ancestors
	 *
	 * @param array<string,string> $policies An array where keys are directives and values are sources.
	 */
	public function _csp(array $policies): void {
		if (!isset($policies['default-src']) || !isset($policies['frame-ancestors'])) {
			$action = Request::controllerName() . '#' . Request::actionName();
			Log::warning(
				"Default CSP policy is not declared for action {$action}.",
				ADMIN_LOG
			);
		}
		$this->csp_policies = $policies;
	}

	/**
	 * Send HTTP Content-Security-Policy header based on declared policies.
	 */
	public function declareCspHeader(): void {
		$policies = [];
		foreach (ExtensionManager::listExtensions(true) as $extension) {
			$extension->amendCsp($this->csp_policies);
		}
		foreach ($this->csp_policies as $directive => $sources) {
			$policies[] = $directive . ' ' . $sources;
		}
		header('Content-Security-Policy: ' . implode('; ', $policies));
	}

	/**
	 * Méthodes à redéfinir (ou non) par héritage
	 * firstAction est la première méthode exécutée par le Dispatcher
	 * lastAction est la dernière
	 */
	public function init(): void { }
	public function firstAction(): void { }
	public function lastAction(): void { }
}
