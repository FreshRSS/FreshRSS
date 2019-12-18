<?php

require_once __DIR__ . '/I18nData.php';

interface I18nFileInterface {

	public function load();

	public function dump(array $i18n);
}
