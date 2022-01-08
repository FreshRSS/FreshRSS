<?php

require_once __DIR__ . '/I18nValue.php';

class I18nFile {

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

				$i18n[$dir->getFilename()][$file->getFilename()] = $this->flatten($this->process($file->getPathname()), $file->getBasename('.php'));
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
	 * Process the content of an i18n file
	 *
	 * @param string $filename
	 * @return array
	 */
	private function process(string $filename) {
		$content = file_get_contents($filename);
		$content = str_replace('<?php', '', $content);

		$content = preg_replace([
			"#',\s*//\s*TODO#i",
			"#',\s*//\s*DIRTY#i",
			"#',\s*//\s*IGNORE#i",
		], [
			' -> todo\',',
			' -> dirty\',',
			' -> ignore\',',
		], $content);

		$content = eval($content);

		if (is_array($content)) {
			return $content;
		}

		return [];
	}

	/**
	 * Flatten an array of translation
	 *
	 * @param array $translation
	 * @param string $prefix
	 * @return array
	 */
	private function flatten(array $translation, string $prefix = '') {
		$a = array();

		if ('' !== $prefix) {
			$prefix .= '.';
		}

		foreach ($translation as $key => $value) {
			if (is_array($value)) {
				$a += $this->flatten($value, $prefix . $key);
			} else {
				$a[$prefix . $key] = new I18nValue($value);
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
	private function unflatten(array $translation) {
		$a = array();

		ksort($translation, SORT_NATURAL);
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
	private function format(array $translation) {
		$translation = var_export($this->unflatten($translation), true);
		$patterns = array(
			'/ -> todo\',/',
			'/ -> dirty\',/',
			'/ -> ignore\',/',
			'/array \(/',
			'/=>\s*array/',
			'/(\w) {2}/',
			'/ {2}/',
		);
		$replacements = array(
			"',\t// TODO", // Double quoting is mandatory to have a tab instead of the \t string
			"',\t// DIRTY", // Double quoting is mandatory to have a tab instead of the \t string
			"',\t// IGNORE", // Double quoting is mandatory to have a tab instead of the \t string
			'array(',
			'=> array',
			'$1 ',
			"\t", // Double quoting is mandatory to have a tab instead of the \t string
		);
		$translation = preg_replace($patterns, $replacements, $translation);

		return <<<OUTPUT
		<?php

		/******************************************************************************/
		/* Each entry of that file can be associated with a comment to indicate its   */
		/* state. When there is no comment, it means the entry is fully translated.   */
		/* The recognized comments are (comment matching is case-insensitive):        */
		/*   + TODO: the entry has never been translated.                             */
		/*   + DIRTY: the entry has been translated but needs to be updated.          */
		/*   + IGNORE: the entry does not need to be translated.                      */
		/* When a comment is not recognized, it is discarded.                         */
		/******************************************************************************/

		return {$translation};

		OUTPUT;
	}
}
