<?php

namespace Freshrss\Cli\I18n;

require_once __DIR__ . '/I18nData.php';

interface I18nFileInterface {

	public function load();

	public function dump(I18nData $i18n);
}
