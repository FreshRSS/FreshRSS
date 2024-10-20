<?php
declare(strict_types=1);

final class UserJSExtension extends Minz_Extension {
	public string $js_rules = '';
	private const FILENAME = 'script.js';

	#[\Override]
	public function init(): void {
		parent::init();

		$this->registerTranslates();
		if ($this->hasFile(self::FILENAME)) {
			Minz_View::appendScript($this->getFileUrl(self::FILENAME, 'js', false));
		}
	}

	#[\Override]
	public function handleConfigureAction(): void {
		parent::init();

		$this->registerTranslates();

		if (Minz_Request::isPost()) {
			$js_rules = Minz_Request::paramString('js-rules', plaintext: true);
			$this->saveFile(self::FILENAME, $js_rules);
		}

		$this->js_rules = '';
		if ($this->hasFile(self::FILENAME)) {
			$this->js_rules = htmlspecialchars($this->getFile(self::FILENAME) ?? '', ENT_NOQUOTES, 'UTF-8');
		}
	}
}
