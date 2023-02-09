<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class LogDAOTest extends TestCase {
	private $logDAO;
	protected function setUp(): void {
		$this->logDAO = new FreshRSS_LogDAO();
		file_put_contents(ADMIN_LOG, '[Wed, 08 Feb 2023 15:35:05 +0000] [notice] --- Migration 2019_12_22_FooBar: OK');
	}

	public function test_lines_is_array(): void {
		$this->assertIsArray($this->logDAO::lines());
		$line =  $this->logDAO::lines()[0];
		$this->assertInstanceOf(FreshRSS_Log::class, $line);
		$this->assertEquals('Wed, 08 Feb 2023 15:35:05 +0000', $line->date());
		$this->assertEquals('notice', $line->level());
		$this->assertEquals("Migration 2019_12_22_FooBar: OK", $line->info());
	}

}
