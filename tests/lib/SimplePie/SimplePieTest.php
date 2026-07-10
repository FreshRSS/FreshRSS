<?php
declare(strict_types=1);

final class SimplePieTest extends \PHPUnit\Framework\TestCase
{
	/** @var list<string> */
	private array $tempFiles = [];

	#[\Override]
	protected function setUp(): void {
		FreshRSS_Context::initSystem();
	}

	public function testSimplePieClassExists(): void {
		self::assertTrue(class_exists(\SimplePie\SimplePie::class));
	}

	public function testSimplePieMiscClassExists(): void {
		self::assertTrue(class_exists(\SimplePie\Misc::class));
	}

	public function testSimplePieFetchTrimsTrailingJunkAfterRssClosingTag(): void {
		$feedPath = $this->createTempFeedFile(<<<'XML'
<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0">
	<channel>
		<title>Example</title>
	</channel>
</rss>
<!-- trailing comment -->
<script>console.log('junk');</script>
XML);

		$fetch = new FreshRSS_SimplePieFetch($feedPath);

		self::assertSame(<<<'XML'
<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0">
	<channel>
		<title>Example</title>
	</channel>
</rss>
XML, $fetch->get_body_content());
	}

	public function testSimplePieFetchKeepsFeedWithoutTrailingJunk(): void {
		$feedBody = <<<'XML'
<?xml version="1.0" encoding="UTF-8"?>
<feed xmlns="http://www.w3.org/2005/Atom">
	<title>Example</title>
</feed>
XML;
		$feedPath = $this->createTempFeedFile($feedBody);

		$fetch = new FreshRSS_SimplePieFetch($feedPath);

		self::assertSame($feedBody, $fetch->get_body_content());
	}

	private function createTempFeedFile(string $body): string {
		$path = tempnam(sys_get_temp_dir(), 'freshrss-feed-');
		if (!is_string($path)) {
			self::fail('Failed to create temporary feed file.');
		}

		file_put_contents($path, $body);
		$this->tempFiles[] = $path;

		return $path;
	}

	#[\Override]
	protected function tearDown(): void {
		foreach ($this->tempFiles as $path) {
			@unlink($path);
		}
		$this->tempFiles = [];
	}
}
