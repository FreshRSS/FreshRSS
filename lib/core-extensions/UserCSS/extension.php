<?php
declare(strict_types=1);

final class UserCSSExtension extends Minz_Extension {
	public string $css_rules = '';
	private const FILENAME = 'style.css';

	#[\Override]
	public function init(): void {
		parent::init();

		$this->registerTranslates();
		if ($this->hasFile(self::FILENAME)) {
			Minz_View::appendStyle($this->getFileUrl(self::FILENAME, 'css', false));
		}
	}

	#[\Override]
	public function handleConfigureAction(): void {
		parent::init();

		$this->registerTranslates();

		if (Minz_Request::isPost()) {
			$css_rules = Minz_Request::paramString('css-rules', plaintext: true);
			$this->saveFile(self::FILENAME, $css_rules);
		}

		$this->css_rules = '';
		if ($this->hasFile(self::FILENAME)) {
			$this->css_rules = htmlspecialchars($this->getFile(self::FILENAME) ?? '', ENT_NOQUOTES, 'UTF-8');
		}
	}
}
