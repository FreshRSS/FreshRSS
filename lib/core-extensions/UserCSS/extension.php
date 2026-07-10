<?php
declare(strict_types=1);

use FreshRss\Minz\Extension;
use FreshRss\Minz\Request;
use FreshRss\Minz\View;
use FreshRss\Models\UserDAO;

final class UserCSSExtension extends Extension {
	public string $css_rules = '';
	private const FILENAME = 'style.css';

	#[\Override]
	public function init(): void {
		parent::init();

		$this->registerTranslates();
		if ($this->hasFile(self::FILENAME)) {
			View::appendStyle($this->getFileUrl(self::FILENAME, isStatic: false));
		}
	}

	#[\Override]
	public function handleConfigureAction(): void {
		parent::init();

		$this->registerTranslates();

		if (Request::isPost()) {
			$css_rules = Request::paramString('css-rules', plaintext: true);
			$this->saveFile(self::FILENAME, $css_rules);
			UserDAO::touch();
			// Redirect (Post/Redirect/Get) so the next page is built after the save,
			// with a fresh cache-busting URL for the updated stylesheet
			Request::good(_t('feedback.conf.updated'), [
				'c' => 'extension', 'a' => 'configure', 'params' => ['e' => $this->getName()],
			]);
		}

		$this->css_rules = '';
		if ($this->hasFile(self::FILENAME)) {
			$this->css_rules = htmlspecialchars($this->getFile(self::FILENAME) ?? '', ENT_NOQUOTES, 'UTF-8');
		}
	}
}
