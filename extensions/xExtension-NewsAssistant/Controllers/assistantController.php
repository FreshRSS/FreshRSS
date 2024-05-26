<?php

require(dirname(__DIR__) . '/helper.php');

class FreshExtension_assistant_Controller extends Minz_ActionController
{
	const NEWS_CATEGORY_TYPE = 'c';
	const DEFAULT_OPENAI_BASE_URL = 'https://api.openai.com';
	const DEFAULT_PROVIDER = 'openai';

	private $config = array();
	private $entryDAO = null;

	public function __construct()
	{
		parent::__construct();

		$system_conf = Minz_Configuration::get('system');
		$openai_base_url = $system_conf->openai_base_url;
		$provider = $system_conf->provider;
		$this->config = (object) array(
			'limit' => $system_conf->limit,
			'openai_base_url' => empty($openai_base_url) ? self::DEFAULT_OPENAI_BASE_URL : $openai_base_url,
			'provider' => empty($provider) ? self::DEFAULT_PROVIDER : $provider,
			'model' => $system_conf->model,
			'temperature' => $system_conf->temperature,
			'max_tokens' => $system_conf->max_tokens,
			'openai_api_key' => $system_conf->openai_api_key,
			'prompt' => $system_conf->prompt,
			'field' => $system_conf->field,
		);
		$this->entryDAO = FreshRSS_Factory::createEntryDao();
	}

	public final function getFileUrl(string $filename, string $type): string
	{
		$assistantExtensionPath = dirname(__DIR__);
		$assistantExtensionDirName = basename($assistantExtensionPath);
		$file_name_url = urlencode($assistantExtensionDirName . "/static/{$filename}");
		$mtime = @filemtime($assistantExtensionPath . "/static/{$filename}");

		return Minz_Url::display("/ext.php?f={$file_name_url}&amp;t={$type}&amp;{$mtime}", 'php');
	}

	public function summaryAction()
	{
		Minz_View::appendStyle($this->getFileUrl('style.css', 'css'));
		Minz_View::appendScript($this->getFileUrl('script.js', 'js'));
		Minz_View::appendScript($this->getFileUrl('marked.min.js', 'js'));
	}

	private function _echoData(string $data, string $event_name = '')
	{
		if (strlen($event_name) > 0) {
			echo "event: " . $event_name . "\n";
		}

		echo 'data: ' . $data . "\n\n";

		ob_flush();
		flush();
	}

	public function streamAction()
	{
		header('Cache-Control: no-cache');
		header('Content-Type: text/event-stream');
		header('Connection: keep-alive');
		header('X-Accel-Buffering: no');

		$cat_id = filter_var(Minz_Request::param('cat_id', 0), FILTER_VALIDATE_INT);
		$state = filter_var(Minz_Request::param('state', FreshRSS_Entry::STATE_NOT_READ), FILTER_VALIDATE_INT);

		$news = $this->getNews($cat_id, $state, $this->config->limit);

		$summary_ids = array_map(function ($newsItem) {
			return $newsItem['id'];
		}, $news);

		$this->_echoData(json_encode(array('summary_ids' => $summary_ids)), 'load_summary_ids');

		if (count($news) > 0) {
			$content = self::buildNewsContent($this->config->field, $news);

			streamOpenAiApi(
				$this->config,
				$this->config->prompt,
				$content,
				function ($msg) {
					if ($msg == null) return;
					$this->_echoData(encodeURIComponent($msg));
				},
				function () {
					$this->_echoData('', 'done');
					exit();
				}
			);
		} else {
			$this->_echoData(_t('gen.holder.empty_content'), 'empty');
			exit();
		}
	}

	public static function buildNewsContent(string $field, array $news)
	{
		$pickTitleFn = function ($newsItem) use ($field) {
			$title = $newsItem[$field];

			if (endsWithPunctuation($title)) return $title;
			return $title . '.';
		};

		return implode('', array_map($pickTitleFn, $news));
	}

	private function getNews(int $cat_id = 0, int $state = FreshRSS_Entry::STATE_NOT_READ, int $limit = 30)
	{
		$generator = $this->entryDAO->listWhere(self::NEWS_CATEGORY_TYPE, $cat_id, $state, 'DESC', $limit, '', null);
		$result = array();
		foreach ($generator as $entry) {
			$result[] = $entry->toArray();
		}

		return $result;
	}
}
