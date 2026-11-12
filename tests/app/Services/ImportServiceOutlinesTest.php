<?php
declare(strict_types=1);

final class ImportServiceOutlinesTest extends PHPUnit\Framework\TestCase {

	#[\Override]
	protected function setUp(): void {
		if (!FreshRSS_Context::hasSystemConf()) {
			FreshRSS_Context::initSystem();
		}
		// Prevents any actual database connection
		FreshRSS_DatabaseDAO::$dummyConnection = true;
	}

	/**
	 * @return array{0:array<array-key,array<string,string>>,1:array<array-key,list<array<string,string>>>}
	 */
	private static function loadFromOutlines(string $opml): array {
		$libopml = new \marienfressinaud\LibOpml\LibOpml(strict: false);
		$opml_array = $libopml->parseString($opml);
		$importService = new FreshRSS_Import_Service();
		$method = new ReflectionMethod($importService, 'loadFromOutlines');
		/** @var array{0:array<array-key,array<string,string>>,1:array<array-key,list<array<string,string>>>} */
		return $method->invoke($importService, $opml_array['body'], '');
	}

	/**
	 * numeric-string names for categories and feeds must survive OPML parsing and the merging of sibling outlines.
	 */
	public function test_numeric_names_are_preserved(): void {
		[$categories_elements, $categories_to_feeds] = self::loadFromOutlines(<<<'XML'
			<?xml version="1.0" encoding="UTF-8"?>
			<opml version="2.0">
				<head><title>Test</title></head>
				<body>
					<outline text="90">
						<outline text="Feed 90" type="rss" xmlUrl="https://example.net/90.xml" />
					</outline>
					<outline text="42">
						<outline text="42 feed" type="rss" xmlUrl="https://example.net/42.xml" />
					</outline>
					<outline text="Github">
						<outline text="12345" type="rss" xmlUrl="https://example.net/gh.xml" />
					</outline>
				</body>
			</opml>
			XML);

		self::assertCount(3, $categories_elements);
		self::assertCount(3, $categories_to_feeds);
		self::assertSame([90, 42, 'Github'], array_keys($categories_elements), 'Numeric category keys are preserved while merging sibling outlines');
		self::assertSame('90', $categories_elements[90]['text']);
		self::assertSame('42', $categories_elements[42]['text']);

		foreach ($categories_to_feeds as $category_name => $feeds) {
			self::assertCount(1, $feeds, "Category `{$category_name}` keeps its feed");
		}
		self::assertSame('Feed 90', $categories_to_feeds[90][0]['text']);
		self::assertSame('42 feed', $categories_to_feeds[42][0]['text']);
		self::assertSame('12345', $categories_to_feeds['Github'][0]['text'], 'Numeric feed name is preserved');
		self::assertSame('https://example.net/90.xml', $categories_to_feeds[90][0]['xmlUrl']);
		self::assertSame('https://example.net/42.xml', $categories_to_feeds[42][0]['xmlUrl']);
		self::assertSame('https://example.net/gh.xml', $categories_to_feeds['Github'][0]['xmlUrl']);
	}
}
