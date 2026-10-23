<?php
declare(strict_types=1);

use PHPUnit\Framework\Attributes\DataProvider;

final class dotNotationUtilTest extends \PHPUnit\Framework\TestCase {

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
		yield [$array, '"Hello " & hello & \'!\'', 'Hello world!'];
		yield [$array, '"Hello & goodbye " & hello & \'!\'', 'Hello & goodbye world!'];
		yield [$array, '"Hello " & hello & deeper.hello & "!"', 'Hello worldagain!'];
	}

	/**
	 * @param array<string,mixed> $array
	 */
	#[DataProvider('provideJsonDots')]
	public static function testJsonDots(array $array, string $key, string $expected): void {
		$value = FreshRSS_dotNotation_Util::get($array, $key);
		self::assertSame($expected, $value);
	}

	public static function testConvertJsonToRssEscapesCategories(): void {
		FreshRSS_Context::initSystem();
		Minz_Translate::init('en');
		$json = <<<json
		{
			"items": [
				{"title": "First", "url": "https://example.net/1", "categories": ["News & Politics", "Arts & Culture"]},
				{"title": "Second", "url": "https://example.net/2", "categories": "Science & Tech"}
			]
		}
		json;
		$jf = json_decode($json, true);
		self::assertIsArray($jf);
		$rss = FreshRSS_dotNotation_Util::convertJsonToRss($jf, 'https://example.net/', [
			'item' => 'items',
			'itemTitle' => 'title',
			'itemUri' => 'url',
			'itemCategories' => 'categories',
		], 'Test');
		self::assertIsString($rss);
		self::assertStringContainsString('<category>News &amp; Politics</category>', $rss);
		self::assertStringContainsString('<category>Arts &amp; Culture</category>', $rss);
		self::assertStringContainsString('<category>Science &amp; Tech</category>', $rss);
		self::assertNotFalse(simplexml_load_string($rss), 'Output must be valid XML');
	}
}
