<?php

declare(strict_types=1);

class UserJSExtension extends Minz_Extension {
	public string $js_rules;
	public string $permission_problem = '';

	public function init(): void {
		$this->registerTranslates();

		$username = Minz_User::name();
		$dirpath = USERS_PATH . "/{$username}/extensions/{$this->getName()}";
		$filename = 'script.js';
		$filepath = "{$dirpath}/{$filename}";

		if (file_exists($filepath)) {
			Minz_View::appendScript($this->getFileUrl($filename, 'js', false));
		}
	}

	public function handleConfigureAction(): void {
		$this->registerTranslates();

		$username = Minz_User::name();
		$dirpath = USERS_PATH . "/{$username}/extensions/{$this->getName()}";
		$filename = 'script.js';
		$filepath = "{$dirpath}/{$filename}";

		if (Minz_Request::isPost()) {
			$js_rules = html_entity_decode(Minz_Request::paramString('js-rules'));
			$this->saveFile($filename, $js_rules);
		}

		$this->js_rules = '';
		if (file_exists($filepath)) {
			$this->js_rules = htmlentities(file_get_contents($filepath) ?: '');
		}
	}
}
