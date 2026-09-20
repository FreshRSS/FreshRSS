<?php
declare(strict_types=1);

final class SessionTest extends \PHPUnit\Framework\TestCase {

	private string $originalSavePath;

	#[\Override]
	protected function setUp(): void {
		$this->originalSavePath = (string)ini_get('session.save_path');
	}

	#[\Override]
	protected function tearDown(): void {
		ini_set('session.save_path', $this->originalSavePath);
	}

	public function testRegenerateIDOnHealthyStorage(): void {
		$previous = $_SESSION ?? [];

		Minz_Session::regenerateID('FreshRSS');

		$_SESSION['probe'] = 'ok';
		self::assertSame('ok', $_SESSION['probe']);
		$_SESSION = $previous;
		session_write_close();
	}

	public function testRegenerateIDOnBrokenStorage(): void {
		$save_path = sys_get_temp_dir() . '/frss_test_sessions_' . bin2hex(random_bytes(4));
		self::assertNotFalse(mkdir($save_path, 0700));
		$broken_path = $save_path . '/missing_subdir';
		ini_set('session.save_path', $broken_path);

		$this->expectException(RuntimeException::class);
		Minz_Session::regenerateID('FreshRSS');
	}
}
