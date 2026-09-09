<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;

class LogTest extends TestCase {
	private string $logFile = '';

	#[\Override]
	protected function setUp(): void {
		$this->logFile = self::createTempFile('freshrss-log-test-');
		putenv('FRESHRSS_ENV=development');
	}

	#[\Override]
	protected function tearDown(): void {
		putenv('FRESHRSS_ENV');
		@unlink($this->logFile);
	}

	private static function createTempFile(string $prefix): string {
		$path = tempnam(sys_get_temp_dir(), $prefix);
		if ($path === false) {
			throw new RuntimeException('Could not create a temporary file for the test');
		}
		return $path;
	}

	/** @return list<string> */
	private function loggedLines(): array {
		$content = @file_get_contents($this->logFile);
		return $content === false || $content === '' ? [] : explode("\n", rtrim($content, "\n"));
	}

	public function testDevelopmentEnvironmentLogsDebugMessages(): void {
		Minz_Log::debug('some debug message', $this->logFile);

		self::assertCount(1, $this->loggedLines());
	}

	public function testProductionEnvironmentDiscardsDebugAndNoticeMessages(): void {
		putenv('FRESHRSS_ENV=production');

		Minz_Log::debug('discarded', $this->logFile);
		Minz_Log::notice('discarded too', $this->logFile);
		Minz_Log::warning('kept', $this->logFile);
		Minz_Log::error('kept too', $this->logFile);

		$lines = $this->loggedLines();
		self::assertCount(2, $lines);
		self::assertStringContainsString('[warning]', $lines[0]);
		self::assertStringContainsString('[error]', $lines[1]);
	}

	public function testSilentEnvironmentDiscardsEverything(): void {
		putenv('FRESHRSS_ENV=silent');

		Minz_Log::error('should not be written', $this->logFile);

		self::assertSame([], $this->loggedLines());
	}

	public function testLogLevelOverridesEnvironmentVerbosity(): void {
		$this->withSystemConf(['environment' => 'development', 'log_level' => 'notice'], function (): void {
			Minz_Log::debug('discarded, too verbose for notice', $this->logFile);
			Minz_Log::notice('kept, matches the threshold', $this->logFile);
			Minz_Log::error('kept, more severe than the threshold', $this->logFile);
		});

		$lines = $this->loggedLines();
		self::assertCount(2, $lines);
		self::assertStringContainsString('[notice]', $lines[0]);
		self::assertStringContainsString('[error]', $lines[1]);
	}

	public function testLogLevelCanRelaxProductionVerbosity(): void {
		$this->withSystemConf(['environment' => 'production', 'log_level' => 'info'], function (): void {
			Minz_Log::debug('discarded, more verbose than info', $this->logFile);
			Minz_Log::record('kept, an info message', LOG_INFO, $this->logFile);
		});

		self::assertCount(1, $this->loggedLines());
	}

	/**
	 * Temporarily registers a `system` configuration namespace so that `log_level` can be exercised,
	 * then restores the previous state to avoid leaking configuration into other tests.
	 * @param array<string,mixed> $overrides
	 */
	private function withSystemConf(array $overrides, callable $test): void {
		putenv('FRESHRSS_ENV');	// Let Minz_Log fall back to the registered `system` configuration.

		$configFile = self::createTempFile('freshrss-config-test-');
		file_put_contents($configFile, '<?php return ' . var_export($overrides, true) . ';');

		Minz_Configuration::register('system', $configFile, FRESHRSS_PATH . '/config.default.php');
		try {
			$test();
		} finally {
			@unlink($configFile);
		}
	}
}
