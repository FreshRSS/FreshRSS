<?php

declare(strict_types=1);

final class StickyFeedsExtension extends Minz_Extension {
	#[\Override]
	public function init(): void {
		Minz_View::appendStyle($this->getFileUrl('style.css', 'css'));
		Minz_View::appendScript($this->getFileUrl('script.js', 'js'));
	}
}
