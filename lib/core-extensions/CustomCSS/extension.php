<?php

class CustomCSSExtension extends Minz_Extension {
	public function init() {
		$this->registerTranslates();

		$current_user = Minz_Session::param('currentUser');
		$filename = 'style.' . $current_user . '.css';
		$filepath = join_path($this->getPath(), 'static', $filename);

		if (file_exists($filepath)) {
			Minz_View::appendStyle($this->getFileUrl($filename, 'css'));
		}
	}

	public function handleConfigureAction() {
		$this->registerTranslates();

		$current_user = Minz_Session::param('currentUser');
		$filename = 'style.' . $current_user . '.css';
		$staticPath = join_path($this->getPath(), 'static');
		$filepath = join_path($staticPath, $filename);

		if (!file_exists($filepath) && !is_writable($staticPath)) {
			$tmpPath = explode(EXTENSIONS_PATH . '/', $staticPath);
			$this->permission_problem = $tmpPath[1] . '/';
		} elseif (file_exists($filepath) && !is_writable($filepath)) {
			$tmpPath = explode(EXTENSIONS_PATH . '/', $filepath);
			$this->permission_problem = $tmpPath[1];
		} elseif (Minz_Request::isPost()) {
			$css_rules = html_entity_decode(Minz_Request::param('css-rules', ''));
			file_put_contents($filepath, $css_rules);
		}

		$this->css_rules = '';
		if (file_exists($filepath)) {
			$this->css_rules = htmlentities(file_get_contents($filepath));
		}
	}
}
