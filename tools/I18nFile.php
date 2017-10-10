<?php

require_once __DIR__ . '/I18nData.php';

class i18nFile {

	private $i18nPath;

	public function __construct() {
		$this->i18nPath = __DIR__ . '/../app/i18n';
	}

	public function load() {
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

		return new I18nData($i18n);
	}

	public function dump(I18nData $i18n) {
		foreach ($i18n->getData() as $language => $file) {
			$dir = $this->i18nPath . DIRECTORY_SEPARATOR . $language;
			if (!file_exists($dir)) {
				mkdir($dir);
			}
			foreach ($file as $name => $content) {
				$filename = $dir . DIRECTORY_SEPARATOR . $name;
				$fullContent = var_export($this->unflatten($content), true);
				file_put_contents($filename, sprintf('<?php return %s;', $fullContent));
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

		ksort($translation);
		foreach ($translation as $compoundKey => $value) {
			$keys = explode('.', $compoundKey);
			array_shift($keys);
			eval("\$a['" . implode("']['", $keys) . "'] = '" . $value . "';");
		}

		return $a;
	}

}
