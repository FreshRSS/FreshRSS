<?php
declare(strict_types=1);

final class UserJSExtension extends Minz_Extension {
	public string $js_rules = '';
	private const FILENAME = 'script.js';

	public function init(): void {
		$this->registerTranslates();
		if ($this->hasFile(self::FILENAME)) {
			Minz_View::appendScript($this->getFileUrl(self::FILENAME, 'js', false));
		}
	}

	public function handleConfigureAction(): void {
		$this->registerTranslates();

		if (Minz_Request::isPost()) {
			$js_rules = html_entity_decode(Minz_Request::paramString('js-rules'));
			$this->saveFile(self::FILENAME, $js_rules);
		}

		$this->js_rules = '';
		if ($this->hasFile(self::FILENAME)) {
			$this->js_rules = htmlentities($this->getFile(self::FILENAME) ?? '');
		}
	}
}
