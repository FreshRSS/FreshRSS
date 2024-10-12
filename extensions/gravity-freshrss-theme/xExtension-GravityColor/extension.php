<?php

declare(strict_types=1);

final class GravityColorExtension extends Minz_Extension {
	private const SCHEME_DEFAULT = 'Blue';

	#[\Override]
	public function init(): void {
		$this->registerTranslates();

		$save = false;
		if (is_null(FreshRSS_Context::userConf()->gravity_color)) {
			FreshRSS_Context::userConf()->gravity_color = self::SCHEME_DEFAULT;
			$save = true;
		}
		if ($save) {
			FreshRSS_Context::userConf()->save();
		}

		$set_color = FreshRSS_Context::userConf()->gravity_color;
		if ($set_color === NULL) {
			$set_color = 'Blue';
		}
		Minz_View::appendStyle($this->getFileUrl('color-' . strtolower($set_color) . '.css', 'css'));
	}

	#[\Override]
	public function handleConfigureAction(): void {
		$this->registerTranslates();

		if (Minz_Request::isPost()) {
			FreshRSS_Context::userConf()->gravity_color = Minz_Request::paramString('gravity_color') ?: self::SCHEME_DEFAULT;
			FreshRSS_Context::userConf()->save();
		}
	}
}
