<?php

declare(strict_types=1);

final class ReadingTimeExtension extends Minz_Extension {
	#[\Override]
	public function init(): void {
		Minz_View::appendScript($this->getFileUrl('readingtime.js', 'js'));
	}
}
