<?php
declare(strict_types=1);
require_once dirname(__DIR__, 3) . '/cli/i18n/PluralFormsCompiler.php';

final class PluralFormsCompilerTest extends \PHPUnit\Framework\TestCase {
	public function testCompileFormulaToLambda(): void {
		$compiler = new PluralFormsCompiler();
		$compiled = $compiler->compileFormula('nplurals=3; plural=(n==1) ? 0 : (n>=2 && n<=4) ? 1 : 2;');

		self::assertSame('nplurals=3; plural=(n==1) ? 0 : (n>=2 && n<=4) ? 1 : 2;', $compiled['formula']);
		self::assertSame(3, $compiled['nplurals']);

		$lambda = eval('return ' . $compiled['lambda'] . ';');
		self::assertInstanceOf(Closure::class, $lambda);
		self::assertSame(0, $lambda(1));
		self::assertSame(1, $lambda(3));
		self::assertSame(2, $lambda(5));
	}

	public function testCompileFileMigratesLegacyPluralFile(): void {
		$compiler = new PluralFormsCompiler();
		$tempFile = tempnam(sys_get_temp_dir(), 'plural-forms-');
		self::assertNotFalse($tempFile);

		try {
			file_put_contents($tempFile, <<<'PHP'
<?php

return array(
	'plural-forms' => 'nplurals=2; plural=(n != 1);',
);
PHP);

			self::assertTrue($compiler->compileFile($tempFile));

			$fileContent = file_get_contents($tempFile);
			self::assertIsString($fileContent);
			self::assertStringContainsString('// Plural-Forms: nplurals=2; plural=(n != 1);', $fileContent);

			$pluralData = include $tempFile;
			self::assertIsArray($pluralData);
			self::assertSame(2, $pluralData['nplurals']);
			self::assertInstanceOf(Closure::class, $pluralData['plural']);
			self::assertSame(0, $pluralData['plural'](1));
			self::assertSame(1, $pluralData['plural'](2));
		} finally {
			@unlink($tempFile);
		}
	}
}
