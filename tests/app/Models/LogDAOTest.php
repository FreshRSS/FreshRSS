<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class LogDAOTest extends TestCase {

	private $logDAO;
	protected function setUp(): void {
		$this->logDAO = new FreshRSS_LogDAO();
	}

	public function test_lines_is_array(): void {
		$this->assertIsArray($this->logDAO::lines());
		$this->assertInstanceOf(FreshRSS_Log::class, $this->logDAO::lines()[0]);
	}
}
