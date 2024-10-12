<?php

declare(strict_types=1);

final class ShareByEmailExtension extends Minz_Extension {

	#[\Override]
	public function init(): void {
		$this->registerTranslates();

		$this->registerController('shareByEmail');
		$this->registerViews();

		FreshRSS_Share::register([
			'type' => 'email',
			'url' => Minz_Url::display(['c' => 'shareByEmail', 'a' => 'share']) . '&amp;id=~ID~',
			'transform' => [],
			'form' => 'simple',
			'method' => 'GET',
		]);

		spl_autoload_register(array($this, 'loader'));
	}

	public function loader(string $class_name): void {
		if (strpos($class_name, 'ShareByEmail') === 0) {
			$class_name = substr($class_name, 13);
			$base_path = $this->getPath() . '/';
			include($base_path . str_replace('\\', '/', $class_name) . '.php');
		}
	}
}
