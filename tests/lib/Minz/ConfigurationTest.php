<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;

class ConfigurationTest extends TestCase {
	private string $dir = '';

	#[\Override]
	protected function setUp(): void {
		$this->dir = sys_get_temp_dir() . '/freshrss-configuration-' . bin2hex(random_bytes(8));
		if (!mkdir($this->dir, 0777, true)) {
			throw new RuntimeException('Could not create a temporary directory for the test');
		}
		file_put_contents($this->dir . '/config.php', "<?php\nreturn ['title' => 'FreshRSS'];\n");
		// A save that was interrupted leaves its temporary and backup files behind, so only the
		// replacement of the configuration file itself has to be possible.
		file_put_contents($this->dir . '/config.php.tmp.php', '');
		file_put_contents($this->dir . '/config.php.bak.php', '');
	}

	#[\Override]
	protected function tearDown(): void {
		chmod($this->dir, 0777);
		foreach (['config.php', 'config.php.tmp.php', 'config.php.bak.php'] as $filename) {
			@unlink($this->dir . '/' . $filename);
		}
		@rmdir($this->dir);
	}

	public function testSaveReportsFailureWhenTheFileIsNotReplaced(): void {
		if (function_exists('posix_geteuid') && posix_geteuid() === 0) {
			self::markTestSkipped('File permissions are not enforced for root');
		}

		Minz_Configuration::register('configuration_test', $this->dir . '/config.php');
		$conf = Minz_Configuration::get('configuration_test');
		// The files stay writable but the directory does not, so the configuration file cannot be replaced.
		self::assertTrue(chmod($this->dir, 0555));

		self::assertFalse($conf->save());
		self::assertSame("<?php\nreturn ['title' => 'FreshRSS'];\n", file_get_contents($this->dir . '/config.php'));
	}
}
