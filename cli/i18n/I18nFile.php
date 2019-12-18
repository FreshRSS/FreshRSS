<?php

require_once __DIR__ . '/I18nFileInterface.php';

class I18nFile implements I18nFileInterface{

	private $i18nPath;

	public function __construct() {
		$this->i18nPath = __DIR__ . '/../../app/i18n';
	}

	public function load() {
		$i18n = array();
		$dirs = new DirectoryIterator($this->i18nPath);
		foreach ($dirs as $dir) {
			if ($dir->isDot()) {
				continue;
			}
			$files = new DirectoryIterator($dir->getPathname());
			foreach ($files as $file) {
				if (!$file->isFile()) {
					continue;
				}
				$i18n[$dir->getFilename()][$file->getFilename()] = $this->flatten(include $file->getPathname(), $file->getBasename('.php'));
			}
		}

		return $i18n;
	}

	public function dump(array $i18n) {
		foreach ($i18n as $language => $file) {
			$dir = $this->i18nPath . DIRECTORY_SEPARATOR . $language;
			if (!file_exists($dir)) {
				mkdir($dir);
			}
			foreach ($file as $name => $content) {
				$filename = $dir . DIRECTORY_SEPARATOR . $name;
				file_put_contents($filename, $this->format($content));
			}
		}
	}

	/**
	 * Flatten an array of translation
	 *
	 * @param array $translation
	 * @param string $prefix
	 * @return array
	 */
	private function flatten($translation, $prefix = '') {
		$a = array();

		if ('' !== $prefix) {
			$prefix .= '.';
		}

		foreach ($translation as $key => $value) {
			if (is_array($value)) {
				$a += $this->flatten($value, $prefix . $key);
			} else {
				$a[$prefix . $key] = $value;
			}
		}

		return $a;
	}

	/**
	 * Unflatten an array of translation
	 *
	 * The first key is dropped since it represents the filename and we have
	 * no use of it.
	 *
	 * @param array $translation
	 * @return array
	 */
	private function unflatten($translation) {
		$a = array();

		ksort($translation, SORT_NATURAL | SORT_FLAG_CASE);
		foreach ($translation as $compoundKey => $value) {
			$keys = explode('.', $compoundKey);
			array_shift($keys);
			eval("\$a['" . implode("']['", $keys) . "'] = '" . addcslashes($value, "'") . "';");
		}

		return $a;
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
		$translation = var_export($this->unflatten($translation), true);
		$patterns = array(
			'/array \(/',
			'/=>\s*array/',
			'/(\w) {2}/',
			'/ {2}/',
			'/ -> todo\',/',
		);
		$replacements = array(
			'array(',
			'=> array',
			'$1 ',
			"\t", // Double quoting is mandatory to have a tab instead of the \t string
			"',\t// TODO - Translation", // Double quoting is mandatory to have a tab instead of the \t string
		);
		$translation = preg_replace($patterns, $replacements, $translation);

		// Double quoting is mandatory to have new lines instead of \n strings
		return sprintf("<?php\n\nreturn %s;\n", $translation);
	}
}
