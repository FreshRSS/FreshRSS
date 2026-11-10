<?php
declare(strict_types=1);

final class exportArticlesTest extends \PHPUnit\Framework\TestCase {
	private string $filename;

	#[\Override]
	public static function setUpBeforeClass(): void {
		// `FreshRSS_View` needs a system configuration; the shipped defaults are enough to render an export.
		Minz_Configuration::register('system', FRESHRSS_PATH . '/config.default.php', FRESHRSS_PATH . '/config.default.php');
	}

	#[\Override]
	protected function setUp(): void {
		$filename = tempnam(sys_get_temp_dir(), 'freshrss_test_');
		self::assertIsString($filename);
		$this->filename = $filename;
	}

	#[\Override]
	protected function tearDown(): void {
		@unlink($this->filename);
	}

	/** @return list<FreshRSS_Entry> */
	private static function entries(int $count): array {
		$entries = [];
		for ($i = 1; $i <= $count; $i++) {
			$entry = new FreshRSS_Entry(1, 'guid-' . $i, 'Title ' . $i, '', str_repeat('<p>Contenu exporté ' . $i . '</p>', 200),
				'https://example.net/' . $i, 1700000000 + $i);
			$entry->_id(1700000000000000 + $i);
			$entries[] = $entry;
		}
		return $entries;
	}

	/** @param iterable<FreshRSS_Entry> $entries */
	private static function view(iterable $entries): FreshRSS_View {
		$view = new FreshRSS_View();
		$view->internal_rendering = true;
		$view->list_title = 'Starred';
		$view->type = 'starred';
		$view->feed = new FreshRSS_Feed('https://example.net/feed.xml', false);
		$view->entries = $entries;
		return $view;
	}

	public function testHelperToFileWritesTheSameContentAsHelperToString(): void {
		$expected = self::view(self::entries(50))->helperToString('export/articles');
		self::assertGreaterThan(65536, strlen($expected), 'The export must be larger than one chunk of the output buffer');

		file_put_contents($this->filename, 'Previous content, to be overwritten');
		$this->expectOutputString('');	// Nothing must leak to the output
		self::view(self::entries(50))->helperToFile('export/articles', $this->filename);

		self::assertSame($expected, file_get_contents($this->filename));
		$json = json_decode($expected, true);
		self::assertIsArray($json);
		self::assertIsArray($json['items'] ?? null);
		self::assertCount(50, $json['items']);
	}

	public function testHelperToFileClosesTheOutputBufferOnError(): void {
		$entries = (static function (): Generator {
			yield from self::entries(1);
			throw new RuntimeException('Database error');
		})();
		$level = ob_get_level();
		try {
			self::view($entries)->helperToFile('export/articles', $this->filename);
			self::fail('The exception must be propagated');
		} catch (RuntimeException $e) {
			self::assertSame('Database error', $e->getMessage());
		}
		self::assertSame($level, ob_get_level());
	}
}
