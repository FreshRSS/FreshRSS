<?php

require_once __DIR__ . '/../../../cli/i18n/I18nFile.php';

class I18nFileTest extends PHPUnit\Framework\TestCase {
	public function test(): void {
		$before = $this->computeFilesHash();

		$file = new I18nFile();
		$data = $file->load();
		$file->dump($data);

		$after = $this->computeFilesHash();

		$this->assertEquals($before, $after);
	}

	/** @return array<string,string|false> */
	private function computeFilesHash(): array {
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
