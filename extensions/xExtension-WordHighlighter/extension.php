<?php

declare(strict_types=1);

final class WordHighlighterExtension extends Minz_Extension
{
	const JSON_ENCODE_CONF = JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR;

	public string $word_highlighter_conf = 'test';
	public string $permission_problem = '';
	public bool $enable_in_article = false;
	public bool $enable_logs = false;
	public bool $case_sensitive = false;
	public bool $separate_word_search = false;

	#[\Override]
	public function init(): void
	{
		$this->registerTranslates();

		// register CSS for WordHighlighter:
		Minz_View::appendStyle($this->getFileUrl('style.css', 'css'));

		Minz_View::appendScript($this->getFileUrl('mark.min.js', 'js'), false, false, false);

		$current_user = Minz_Session::paramString('currentUser');

		$staticPath = join_path($this->getPath(), 'static');
		$configFileJs = join_path($staticPath, ('config.' . $current_user . '.js'));

		if (file_exists($configFileJs)) {
			Minz_View::appendScript($this->getFileUrl(('config.' . $current_user . '.js'), 'js'));
		}

		Minz_View::appendScript($this->getFileUrl('word-highlighter.js', 'js'));
	}

	#[\Override]
	public function handleConfigureAction(): void
	{
		$this->registerTranslates();

		$current_user = Minz_Session::paramString('currentUser');
		$staticPath = join_path($this->getPath(), 'static');

		$configFileJson = join_path($staticPath, ('config.' . $current_user . '.json'));

		if (!file_exists($configFileJson) && !is_writable($staticPath)) {
			$tmpPath = explode(EXTENSIONS_PATH . '/', $staticPath);
			$this->permission_problem = $tmpPath[1] . '/';

		} elseif (file_exists($configFileJson) && !is_writable($configFileJson)) {
			$tmpPath = explode(EXTENSIONS_PATH . '/', $configFileJson);
			$this->permission_problem = $tmpPath[1];

		} elseif (Minz_Request::isPost()) {
			$configWordList = html_entity_decode(Minz_Request::paramString('words_list'));

			$this->word_highlighter_conf = $configWordList;
			$this->enable_in_article = (bool) Minz_Request::paramString('enable-in-article');
			$this->enable_logs = (bool) Minz_Request::paramString('enable_logs');
			$this->case_sensitive = (bool) Minz_Request::paramString('case_sensitive');
			$this->separate_word_search = (bool) Minz_Request::paramString('separate_word_search');

			$configObj = [
				'enable_in_article' => $this->enable_in_article,
				'enable_logs' => $this->enable_logs,
				'case_sensitive' => $this->case_sensitive,
				'separate_word_search' => $this->separate_word_search,
				'words' => preg_split("/\r\n|\n|\r/", $configWordList),
			];
			$configJson = json_encode($configObj, WordHighlighterExtension::JSON_ENCODE_CONF);
			file_put_contents(join_path($staticPath, ('config.' . $current_user . '.json')), $configJson . PHP_EOL);
			file_put_contents(join_path($staticPath, ('config.' . $current_user . '.js')), $this->jsonToJs($configJson) . PHP_EOL);
		}

		if (file_exists($configFileJson)) {
			try {
				$confJson = json_decode(file_get_contents($configFileJson) ?: '', true, 8, JSON_THROW_ON_ERROR);
				if (json_last_error() !== JSON_ERROR_NONE || !is_array($confJson)) {
					return;
				}
				$this->enable_in_article = (bool) ($confJson['enable_in_article'] ?? false);
				$this->enable_logs = (bool) ($confJson['enable_logs'] ?? false);
				$this->case_sensitive = (bool) ($confJson['case_sensitive'] ?? false);
				$this->separate_word_search = (bool) ($confJson['separate_word_search'] ?? false);
				$this->word_highlighter_conf = implode("\n", (array) ($confJson['words'] ?? []));

			} catch (Exception $exception) {
				// probably nothing to do needed
			}
		}
	}

	private function jsonToJs(string $jsonStr): string
	{
		$js = "window.WordHighlighterConf = " .
		$jsonStr . ";\n" .
		"window.WordHighlighterConf.enable_logs && console.log('WordHighlighter: loaded user config:', window.WordHighlighterConf);";
		return $js;
	}
}
