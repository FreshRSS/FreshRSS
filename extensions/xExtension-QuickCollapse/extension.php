<?php

declare(strict_types=1);

final class QuickCollapseExtension extends Minz_Extension {
	#[\Override]
	public function init(): void {
		$this->registerTranslates();
		$this->registerViews();
		$this->registerController('quickCollapse');

		Minz_View::appendStyle($this->getFileUrl('style.css', 'css'));
		Minz_View::appendScript(_url('quickCollapse', 'jsVars') ?: '', false, true, false);
		Minz_View::appendScript($this->getFileUrl('script.js', 'js'), false, true, false);
	}
}
