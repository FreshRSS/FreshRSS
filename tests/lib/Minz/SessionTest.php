<?php
declare(strict_types=1);

final class SessionTest extends \PHPUnit\Framework\TestCase {

	private string $originalSavePath = '';
	private string $testSavePath = '';

	#[\Override]
	protected function setUp(): void {
		$this->originalSavePath = (string)ini_get('session.save_path');
	}

	#[\Override]
	protected function tearDown(): void {
		if (is_dir($this->testSavePath)) {
			rmdir($this->testSavePath);
		}

		ini_set('session.save_path', $this->originalSavePath);
	}

	public function testRegenerateIDOnHealthyStorage(): void {
		$save_path = session_save_path() ?: sys_get_temp_dir();
		Minz_Session::init('FreshRSS', volatile: false);
		self::assertTrue(file_exists($save_path . '/sess_' . session_id()));
		$previous_id = session_id();
		Minz_Session::_param('probe', 'ok');
		Minz_Session::regenerateID('FreshRSS');
		self::assertNotSame($previous_id, session_id());
		self::assertFalse(file_exists($save_path . '/sess_' . $previous_id));
		self::assertTrue(file_exists($save_path . '/sess_' . session_id()));
		self::assertSame('ok', Minz_Session::paramString('probe'));
		session_unset();
		session_write_close();
		unlink($save_path . '/sess_' . session_id());
	}

	public function testRegenerateIDOnBrokenStorage(): void {
		$this->testSavePath = sys_get_temp_dir() . '/frss_test_sessions_' . bin2hex(random_bytes(4));
		self::assertNotFalse(mkdir($this->testSavePath, 0700));
		ini_set('session.save_path', $this->testSavePath . '/missing_subdir');

		$this->expectException(RuntimeException::class);
		Minz_Session::regenerateID('FreshRSS');
	}
}
