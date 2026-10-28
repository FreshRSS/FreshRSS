<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class LogDAOTest extends TestCase {
	private const LOG_FILE_TEST = 'logFileTest.txt';

	private FreshRSS_LogDAO $logDAO;

	private string $logPath;

	#[\Override]
	protected function setUp(): void {
		$this->logDAO = new FreshRSS_LogDAO();
		$this->logPath = FreshRSS_LogDAO::logPath(self::LOG_FILE_TEST);

		file_put_contents(
			$this->logPath,
			'[Wed, 08 Feb 2023 15:35:05 +0000] [notice] --- Migration 2019_12_22_FooBar: OK'
		);
	}

	public function test_lines_is_array_and_truncate_function_work(): void {
		self::assertSame(USERS_PATH . '/' . Minz_User::INTERNAL_USER . '/' . self::LOG_FILE_TEST, $this->logPath);

		$line = $this->logDAO::lines(self::LOG_FILE_TEST);

		self::assertCount(1, $line);
		self::assertSame('Wed, 08 Feb 2023 15:35:05 +0000', $line[0]->date());
		self::assertSame('notice', $line[0]->level());
		self::assertSame("Migration 2019_12_22_FooBar: OK", $line[0]->info());

		$this->logDAO::truncate(self::LOG_FILE_TEST);

		self::assertStringContainsString('', file_get_contents($this->logPath) ?: '');
	}

	#[\Override]
	protected function tearDown(): void {
		unlink($this->logPath);
	}
}
