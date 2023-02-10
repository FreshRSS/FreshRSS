<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class LogDAOTest extends TestCase {
	private const LOG_FILE_TEST = 'logFileTest.txt';
	private $logDAO;
	protected function setUp(): void {
		$this->logDAO = new FreshRSS_LogDAO();
		file_put_contents(
			USERS_PATH . '/_/'  . self::LOG_FILE_TEST,
			'[Wed, 08 Feb 2023 15:35:05 +0000] [notice] --- Migration 2019_12_22_FooBar: OK'
		);
	}

	public function test_lines_is_array_and_truncate_function_work(): void {
		$line = $this->logDAO::lines(self::LOG_FILE_TEST);

		$this->assertIsArray($line);
		$this->assertInstanceOf(FreshRSS_Log::class, $line[0]);
		$this->assertEquals('Wed, 08 Feb 2023 15:35:05 +0000', $line[0]->date());
		$this->assertEquals('notice', $line[0]->level());
		$this->assertEquals("Migration 2019_12_22_FooBar: OK", $line[0]->info());

		$this->logDAO::truncate( self::LOG_FILE_TEST);

		$this->assertStringContainsString('', file_get_contents(USERS_PATH . '/_/'  . self::LOG_FILE_TEST));
	}

	protected function tearDown(): void {
		unlink(USERS_PATH . '/_/'  . self::LOG_FILE_TEST);
	}
}
