<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class LogDAOTest extends TestCase {
	private $logDAO;
	protected function setUp(): void {
		$this->logDAO = new FreshRSS_LogDAO();
		$migrations_path = TESTS_PATH . '/fixtures/migrations/';
		new Minz_Migrator($migrations_path);
	}

	public function test_lines_is_array(): void {
		dump($this->logDAO::lines());
		$this->assertIsArray($this->logDAO::lines());
		$this->assertInstanceOf(FreshRSS_Log::class, $this->logDAO::lines()[0]);
	}

	protected function tearDown(): void
	{
		$this->logDAO::truncate();
	}

}
