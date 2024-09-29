<?php
declare(strict_types=1);

use PHPUnit\Framework\Attributes\DataProvider;

class dotNotationUtilTest extends PHPUnit\Framework\TestCase {

	/**
	 * @return Traversable<array{array<string,mixed>,string,string}>
	 */
	public static function provideJsonDots(): Traversable {
		$json = <<<json
		{
			"hello": "world",
			"deeper": {
				"hello": "again"
			},
			"items": [
				{
					"meta": {"title": "first"}
				},
				{
					"meta": {"title": "second"}
				}
			]
		}
		json;
		$array = json_decode($json, true);

		yield [$array, 'hello', 'world'];
		yield [$array, 'deeper.hello', 'again'];
		yield [$array, 'items.0.meta.title', 'first'];
		yield [$array, 'items[0].meta.title', 'first'];
		yield [$array, 'items.1.meta.title', 'second'];
		yield [$array, 'items[1].meta.title', 'second'];
	}

	/**
	 * @param array<string,mixed> $array
	 */
	#[DataProvider('provideJsonDots')]
	public static function testJsonDots(array $array, string $key, string $expected): void {
		$value = FreshRSS_dotNotation_Util::get($array, $key);
		self::assertEquals($expected, $value);
	}
}
