<?php

declare(strict_types=1);

final class CustomJSExtension extends Minz_Extension {
	public string $js_rules;
	public string $permission_problem = '';

	#[\Override]
	public function init(): void {
		$this->registerTranslates();

		$current_user = Minz_Session::paramString('currentUser');
		$filename = 'script.' . $current_user . '.js';
		$filepath = join_path($this->getPath(), 'static', $filename);

		if (file_exists($filepath)) {
			Minz_View::appendScript($this->getFileUrl($filename, 'js'));
		}
	}

	#[\Override]
	public function handleConfigureAction(): void {
		$this->registerTranslates();

		$current_user = Minz_Session::paramString('currentUser');
		$filename = 'script.' . $current_user . '.js';
		$staticPath = join_path($this->getPath(), 'static');
		$filepath = join_path($staticPath, $filename);

		if (!file_exists($filepath) && !is_writable($staticPath)) {
			$tmpPath = explode(EXTENSIONS_PATH . '/', $staticPath);
			$this->permission_problem = $tmpPath[1] . '/';
		} elseif (file_exists($filepath) && !is_writable($filepath)) {
			$tmpPath = explode(EXTENSIONS_PATH . '/', $filepath);
			$this->permission_problem = $tmpPath[1];
		} elseif (Minz_Request::isPost()) {
			$js_rules = html_entity_decode(Minz_Request::paramString('js-rules'));
			file_put_contents($filepath, $js_rules);
		}

		$this->js_rules = '';
		if (file_exists($filepath)) {
			$this->js_rules = htmlentities(file_get_contents($filepath) ?: '');
		}
	}
}
