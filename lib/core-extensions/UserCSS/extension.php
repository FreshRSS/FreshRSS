<?php
declare(strict_types=1);

final class UserCSSExtension extends Minz_Extension {
	public string $css_rules = '';
	private const FILENAME = 'style.css';

	public function init(): void {
		$this->registerTranslates();
		if ($this->hasFile(self::FILENAME)) {
			Minz_View::appendStyle($this->getFileUrl(self::FILENAME, 'css', false));
		}
	}

	public function handleConfigureAction(): void {
		$this->registerTranslates();

		if (Minz_Request::isPost()) {
			$css_rules = html_entity_decode(Minz_Request::paramString('css-rules'));
			$this->saveFile(self::FILENAME, $css_rules);
		}

		$this->css_rules = '';
		if ($this->hasFile(self::FILENAME)) {
			$this->css_rules = htmlentities($this->getFile(self::FILENAME) ?? '');
		}
	}
}
