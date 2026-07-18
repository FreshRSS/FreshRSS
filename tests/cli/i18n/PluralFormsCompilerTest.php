<?php
declare(strict_types=1);
require_once dirname(__DIR__, 3) . '/cli/i18n/PluralFormsCompiler.php';

final class PluralFormsCompilerTest extends \PHPUnit\Framework\TestCase {
	public function testCompileFormulaToLambda(): void {
		$compiler = new PluralFormsCompiler();
		$compiled = $compiler->compileFormula('nplurals=3; plural=(n==1) ? 0 : (n>=2 && n<=4) ? 1 : 2;');

		self::assertSame('nplurals=3; plural=(n==1) ? 0 : (n>=2 && n<=4) ? 1 : 2;', $compiled['formula']);
		self::assertSame(3, $compiled['nplurals']);
		self::assertSame(
			'static fn (int $n): int => ($n === 1 ? 0 : ($n >= 2 && $n <= 4 ? 1 : 2))',
			$compiled['lambda']
		);

		$lambda = eval('return ' . $compiled['lambda'] . ';');
		self::assertInstanceOf(Closure::class, $lambda);
		self::assertSame(0, $lambda(1));
		self::assertSame(1, $lambda(3));
		self::assertSame(2, $lambda(5));
	}

	public function testCompileFormulaNormalisesPluralFormsComment(): void {
		$compiler = new PluralFormsCompiler();
		$compiled = $compiler->compileFormula('// Plural-Forms: nplurals=2; plural=(n != 1);');

		self::assertSame('nplurals=2; plural=(n != 1);', $compiled['formula']);
		self::assertSame('static fn (int $n): int => (($n !== 1) ? 1 : 0)', $compiled['lambda']);

		$lambda = eval('return ' . $compiled['lambda'] . ';');
		self::assertInstanceOf(Closure::class, $lambda);
		self::assertSame(0, $lambda(1));
		self::assertSame(1, $lambda(2));
	}

	public function testCompileFormulaHandlesModuloAndLogicalOperators(): void {
		$compiler = new PluralFormsCompiler();
		$compiled = $compiler->compileFormula(
			'nplurals=3; plural=(n%10==1 && n%100!=11 ? 0 : n%10>=2 && n%10<=4 && (n%100<10 || n%100>=20) ? 1 : 2);'
		);

		$lambda = eval('return ' . $compiled['lambda'] . ';');
		self::assertInstanceOf(Closure::class, $lambda);
		self::assertSame(0, $lambda(1));
		self::assertSame(1, $lambda(2));
		self::assertSame(2, $lambda(5));
		self::assertSame(2, $lambda(11));
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
