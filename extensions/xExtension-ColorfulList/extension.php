<?php

declare(strict_types=1);

final class ColorfulListExtension extends Minz_Extension
{
	#[\Override]
	public function init(): void {
		Minz_View::appendScript($this->getFileUrl('script.js', 'js'));
	}
}
