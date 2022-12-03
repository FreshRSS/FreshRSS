<?php

require_once __DIR__ . '/../../../cli/i18n/I18nFile.php';

class I18nFileTest extends PHPUnit\Framework\TestCase {
	public function test() {
		$before = $this->computeFilesHash();

		$file = new I18nFile();
		$data = $file->load();
		$file->dump($data);

		$after = $this->computeFilesHash();

		$this->assertEquals($before, $after);
	}

	private function computeFilesHash() {
		$hashes = [];

		$dirs = new DirectoryIterator(I18N_PATH);
		foreach ($dirs as $dir) {
			if ($dir->isDot()) {
				continue;
			}
			$files = new DirectoryIterator($dir->getPathname());
			foreach ($files as $file) {
				if (!$file->isFile()) {
					continue;
				}

				$hashes[$file->getPathName()] = sha1_file($file->getPathName());
			}
		}

		return $hashes;
	}
}
