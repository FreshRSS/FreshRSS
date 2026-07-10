<?php
declare(strict_types=1);

use FreshRss\Minz\Extension;
use FreshRss\Minz\Request;
use FreshRss\Minz\View;
use FreshRss\Models\Auth;
use FreshRss\Models\UserDAO;

final class UserJSExtension extends Extension {
	public string $js_rules = '';
	private const FILENAME = 'script.js';

	#[\Override]
	public function init(): void {
		parent::init();

		$this->registerTranslates();
		if ($this->hasFile(self::FILENAME)) {
			View::appendScript($this->getFileUrl(self::FILENAME, isStatic: false));
		}
	}

	#[\Override]
	public function handleConfigureAction(): void {
		parent::init();

		$this->registerTranslates();

		if (Auth::requestReauth()) {
			return;
		}

		if (Request::isPost()) {
			$js_rules = Request::paramString('js-rules', plaintext: true);
			$this->saveFile(self::FILENAME, $js_rules);
			UserDAO::touch();
			// Redirect (Post/Redirect/Get) so the next page is built after the save,
			// with a fresh cache-busting URL for the updated script
			Request::good(_t('feedback.conf.updated'), [
				'c' => 'extension', 'a' => 'configure', 'params' => ['e' => $this->getName()],
			]);
		}

		$this->js_rules = '';
		if ($this->hasFile(self::FILENAME)) {
			$this->js_rules = htmlspecialchars($this->getFile(self::FILENAME) ?? '', ENT_NOQUOTES, 'UTF-8');
		}
	}
}
