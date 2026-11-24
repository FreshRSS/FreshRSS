<?php
declare(strict_types=1);
require_once dirname(__DIR__, 3) . '/cli/i18n/I18nFile.php';

final class I18nFileTest extends \PHPUnit\Framework\TestCase {
	public function testDirtyCommentsContainTheMatchingEnglishText(): void {
		$file = new I18nFile();
		$format = new ReflectionMethod(I18nFile::class, 'format');
		$translation = [
			'example.second' => new I18nValue('Identique -> dirty'),
			'example.first' => new I18nValue('Identique -> dirty'),
			'example.missing' => new I18nValue('Absent -> dirty'),
			'example.empty' => new I18nValue('Vide -> dirty'),
			'example.todo' => new I18nValue('Not translated -> todo'),
			'example.ignore' => new I18nValue('Ignored -> ignore'),
			'example.reviewed' => new I18nValue('Reviewed'),
		];
		$reference = [
			'example.first' => new I18nValue('First English string'),
			'example.second' => new I18nValue('Second English string'),
			'example.empty' => new I18nValue(" \t\r\n"),
			'example.todo' => new I18nValue('Not translated'),
			'example.ignore' => new I18nValue('Ignored'),
			'example.reviewed' => new I18nValue('Reviewed English string'),
		];
		$output = $format->invoke($file, $translation, $reference);
		self::assertIsString($output);
		self::assertStringContainsString("'first' => 'Identique',\t// DIRTY - First English string", $output);
		self::assertStringContainsString("'second' => 'Identique',\t// DIRTY - Second English string", $output);
		self::assertStringContainsString("'missing' => 'Absent',\t// DIRTY\n", $output);
		self::assertStringContainsString("'empty' => 'Vide',\t// DIRTY\n", $output);
		self::assertStringContainsString("'todo' => 'Not translated',\t// TODO\n", $output);
		self::assertStringContainsString("'ignore' => 'Ignored',\t// IGNORE\n", $output);
		self::assertStringContainsString("'reviewed' => 'Reviewed',\n", $output);
	}

	public function testDirtyCommentsAreSafeAndIdempotent(): void {
		$file = new I18nFile();
		$format = new ReflectionMethod(I18nFile::class, 'format');
		$process = new ReflectionMethod(I18nFile::class, 'process');
		$flatten = new ReflectionMethod(I18nFile::class, 'flatten');
		$translation = ['example.key' => new I18nValue("L’apostrophe ' et \\ -> dirty")];
		$reference = ['example.key' => new I18nValue("English ' and \\ %s <b>HTML</b>\r\nnext\tline ?> trailing  ")];
		$output = $format->invoke($file, $translation, $reference);
		self::assertIsString($output);
		self::assertStringContainsString("// DIRTY - English ' and \\ %s <b>HTML</b> next line ? > trailing\n", $output);
		self::assertStringNotContainsString('?>', $output);

		$filename = tempnam(sys_get_temp_dir(), 'freshrss-i18n-');
		self::assertIsString($filename);
		try {
			file_put_contents($filename, $output);
			$values = include $filename;
			self::assertSame(['key' => "L’apostrophe ' et \\"], $values);
			$loaded = $process->invoke($file, $filename);
			self::assertIsArray($loaded);
			$roundTrip = $flatten->invoke($file, $loaded, 'example');
			self::assertSame($output, $format->invoke($file, $roundTrip, $reference));
		} finally {
			unlink($filename);
		}

		$reference['example.key'] = new I18nValue('Updated English');
		$updated = $format->invoke($file, $translation, $reference);
		self::assertIsString($updated);
		self::assertStringContainsString('// DIRTY - Updated English', $updated);
		self::assertStringNotContainsString('trailing', $updated);
	}

	public function testDirtyCommentsUseEnglishFallbackForAdditionalPluralForms(): void {
		$format = new ReflectionMethod(I18nFile::class, 'format');
		$output = $format->invoke(new I18nFile(), [
			'example.count.0' => new I18nValue('Un article -> dirty'),
			'example.count.1' => new I18nValue('Des articles -> dirty'),
			'example.count.2' => new I18nValue('Plusieurs articles -> dirty'),
			'example.only.2' => new I18nValue('Autre forme -> dirty'),
		], [
			'example.count.0' => new I18nValue('One article'),
			'example.count.1' => new I18nValue('Many articles'),
			'example.only.0' => new I18nValue('One form'),
		]);
		self::assertIsString($output);
		self::assertStringContainsString("0 => 'Un article',\t// DIRTY - One article", $output);
		self::assertStringContainsString("1 => 'Des articles',\t// DIRTY - Many articles", $output);
		self::assertStringContainsString("2 => 'Plusieurs articles',\t// DIRTY - Many articles", $output);
		self::assertStringContainsString("2 => 'Autre forme',\t// DIRTY - One form", $output);
	}

	public function testDirtyCommentsShowBothEnglishFormsForSingleFormTranslations(): void {
		$format = new ReflectionMethod(I18nFile::class, 'format');
		$output = $format->invoke(new I18nFile(), [
			'example.count.0' => new I18nValue('記事が %d 件あります -> dirty'),
			'example.only.0' => new I18nValue('一つの形 -> dirty'),
			'example.fallback.0' => new I18nValue('別の形 -> dirty'),
		], [
			'example.count.0' => new I18nValue("One article\n?>"),
			'example.count.1' => new I18nValue("Many articles\t?>"),
			'example.only.0' => new I18nValue('One form'),
			'example.fallback.1' => new I18nValue('Plural only'),
		]);
		self::assertIsString($output);
		self::assertStringContainsString("0 => '記事が %d 件あります',\t// DIRTY - Singular: One article ? > | Plural: Many articles ? >\n", $output);
		self::assertStringContainsString("0 => '一つの形',\t// DIRTY - One form\n", $output);
		self::assertStringContainsString("0 => '別の形',\t// DIRTY - Plural only\n", $output);
	}

	public function test(): void {
		$before = $this->computeFilesHash();

		$file = new I18nFile();
		$data = $file->load();
		self::assertArrayNotHasKey('plurals.php', $data['en']);
		$file->dump($data);

		$after = $this->computeFilesHash();

		self::assertSame($before, $after);
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

				$hashes[$file->getPathname()] = sha1_file($file->getPathname());
			}
		}

		return $hashes;
	}
}
