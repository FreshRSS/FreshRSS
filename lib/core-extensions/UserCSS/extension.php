<?php

declare(strict_types=1);

class UserCSSExtension extends Minz_Extension {
	public string $css_rules;
	public string $permission_problem = '';

	public function init(): void {
		$this->registerTranslates();

		$username = Minz_User::name();
		$dirpath = USERS_PATH . "/{$username}/extensions/{$this->getName()}";
		$filename = 'style.css';
		$filepath = "{$dirpath}/{$filename}";

		if (file_exists($filepath)) {
			Minz_View::appendStyle($this->getFileUrl($filename, 'css', false));
		}
	}

	public function handleConfigureAction(): void {
		$this->registerTranslates();

		$username = Minz_User::name();
		$dirpath = USERS_PATH . "/{$username}/extensions/{$this->getName()}";
		$filename = 'style.css';
		$filepath = "{$dirpath}/{$filename}";

		if (Minz_Request::isPost()) {
			$css_rules = html_entity_decode(Minz_Request::paramString('css-rules'));
			$this->saveFile($filename, $css_rules);
		}

		$this->css_rules = '';
		if (file_exists($filepath)) {
			$this->css_rules = htmlentities(file_get_contents($filepath) ?: '');
		}
	}
}
