<?php
declare(strict_types=1);

final class UserCSSExtension extends Minz_Extension {
	protected array $csp_policies = [];
	public string $css_rules = '';
	private const FILENAME = 'style.css';
	private string $stylesheet_url = '';

	#[\Override]
	public function init(): void {
		parent::init();

		$this->registerTranslates();
		if ($this->hasFile(self::FILENAME)) {
			Minz_View::appendStyle($this->getFileUrl(self::FILENAME, isStatic: false));
		}

		$url = $this->getStylesheetUrl() ?: FreshRSS_Context::userConf()->attributeString('stylesheet_url');
		if ($url !== null && $this->hasValidStylesheetUrl($url)) {
			$this->csp_policies['style-src'] = "'self' {$url}";
			Minz_View::prependStyle($url);
		}
	}

	/**
	 * Initializes the extension configuration, if the user context is available.
	 */
	public function loadConfigValues(): void {
		if (!class_exists('FreshRSS_Context', false) || !FreshRSS_Context::hasUserConf()) {
			return;
		}

		$stylesheet_url = FreshRSS_Context::userConf()->attributeString('stylesheet_url');
		if ($stylesheet_url !== null) {
			$this->stylesheet_url = $stylesheet_url;
		}
	}

	/**
	 * Returns the stylesheet URL
	 */
	public function getStylesheetUrl(): string {
		return $this->stylesheet_url;
	}

	#[\Override]
	public function handleConfigureAction(): void {
		parent::init();

		$this->registerTranslates();

		if (Minz_Request::isPost()) {
			$css_rules = Minz_Request::paramString('css-rules', plaintext: true);
			$this->saveFile(self::FILENAME, $css_rules);

			FreshRSS_Context::userConf()->_attribute('stylesheet_url', Minz_Request::paramString('stylesheet_url'));
			FreshRSS_Context::userConf()->save();
		}

		$this->css_rules = '';
		if ($this->hasFile(self::FILENAME)) {
			$this->css_rules = htmlspecialchars($this->getFile(self::FILENAME) ?? '', ENT_NOQUOTES, 'UTF-8');
		}

		$this->loadConfigValues();
	}

	/**
	 * Checks if the given URL is a valid stylesheet URL.
	 *
	 * @param string $url The URL to validate. Defaults to an empty string.
	 * @return bool Returns true if the URL is valid, false otherwise.
	 */
	private function hasValidStylesheetUrl(string $url = '') {
		if ((bool)parse_url($url)) {
			return true;
		}

		return false;
	}
}
