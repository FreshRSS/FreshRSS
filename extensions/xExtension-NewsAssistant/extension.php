<?php

// doc: https://freshrss.github.io/FreshRSS/en/developers/03_Backend/05_Extensions.html
class NewsAssistantExtension extends Minz_Extension
{
	public function init()
	{
		$this->registerTranslates();

		$this->registerController('assistant');
		$this->registerViews();
		$this->registerHook('nav_menu', array($this, 'addSummaryBtn'));
	}

	public function addSummaryBtn()
	{
		$cat_id = $this->getCategoryId();
		$state = $this->getState();
		$url = Minz_Url::display(array('c' => 'assistant', 'a' => 'summary', 'params' => array('cat_id' => $cat_id, 'state' => $state)));
		$icon_url = $this->getFileUrl('filter.svg', 'svg');

		return '<a id="summary" class="btn" href="' . $url . '" title="Get the summary news">
					<img class="icon" src="' . $icon_url . '" loading="lazy" alt="️☀️">
				</a>';
	}

	public function handleConfigureAction()
	{
		$this->registerTranslates();

		if (Minz_Request::isPost()) {
			FreshRSS_Context::$system_conf->openai_base_url = rtrim(Minz_Request::param('openai_base_url', 'https://api.openai.com'), '/');
			FreshRSS_Context::$system_conf->openai_api_key = Minz_Request::param('openai_api_key', '');
			FreshRSS_Context::$system_conf->provider = Minz_Request::param('provider', '');
			FreshRSS_Context::$system_conf->max_tokens = filter_var(Minz_Request::param('max_tokens', 7), FILTER_VALIDATE_INT);
			FreshRSS_Context::$system_conf->temperature = filter_var(Minz_Request::param('temperature', 1), FILTER_VALIDATE_FLOAT);;
			FreshRSS_Context::$system_conf->limit = filter_var(Minz_Request::param('limit', 30), FILTER_VALIDATE_FLOAT);;
			FreshRSS_Context::$system_conf->model = Minz_Request::param('model', 'gpt-3.5-turbo-16k');
			FreshRSS_Context::$system_conf->prompt = Minz_Request::param('prompt', 'Summarize this as you are news editor, you should merge the similar topic.');
			FreshRSS_Context::$system_conf->field = Minz_Request::param('field', 'content');
			FreshRSS_Context::$system_conf->save();
		}
	}

	private function getCategoryId(): int {
		if (!FreshRSS_Context::isCategory()) return 0;

		return FreshRSS_Context::$current_get['category'];
	}

	private function getState(): int {
		if (FreshRSS_Context::$state == 0) return FreshRSS_Entry::STATE_NOT_READ;

		return FreshRSS_Context::$state;
	}
}
