<?php

namespace Freshrss\Cli\I18n;

require_once __DIR__ . '/I18nData.php';
require_once __DIR__ . '/I18nFileInterface.php';

class I18nIgnoreFile implements I18nFileInterface {

	private $i18nPath;

	public function __construct() {
		$this->i18nPath = __DIR__ . '/ignore';
	}

	public function dump(I18nData $i18n) {
		foreach ($i18n->getData() as $language => $content) {
			$filename = $this->i18nPath . DIRECTORY_SEPARATOR . $language . '.php';
			file_put_contents($filename, $this->format($content));
		}
	}

	public function load() {
		$i18n = array();
		$files = new DirectoryIterator($this->i18nPath);
		foreach ($files as $file) {
			if (!$file->isFile()) {
				continue;
			}
			$i18n[$file->getBasename('.php')] = (include $file->getPathname());
		}

		return new I18nData($i18n);
	}

	/**
	 * Format an array of translation
	 *
	 * It takes an array of translation and format it to be dumped in a
	 * translation file. The array is first converted to a string then some
	 * formatting regexes are applied to match the original content.
	 *
	 * @param array $translation
	 * @return string
	 */
	private function format($translation) {
		$translation = var_export(($translation), true);
		$patterns = array(
			'/array \(/',
			'/=>\s*array/',
			'/ {2}/',
			'/\d+ => /',
		);
		$replacements = array(
			'array(',
			'=> array',
			"\t", // Double quoting is mandatory to have a tab instead of the \t string
			'',
		);
		$translation = preg_replace($patterns, $replacements, $translation);

		// Double quoting is mandatory to have new lines instead of \n strings
		return sprintf("<?php\n\nreturn %s;\n", $translation);
	}

}
