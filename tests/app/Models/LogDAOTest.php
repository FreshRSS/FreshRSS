<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class LogDAOTest extends TestCase {

	private const PATH_TO_LOG = APP_PATH.'/log.txt';
	private $logDAO;
	protected function setUp(): void {
		$this->logDAO = new FreshRSS_LogDAO();
		file_put_contents(self::PATH_TO_LOG, '[Wed, 08 Feb 2023 15:35:05 +0000] [notice] --- Migration 2019_12_22_FooBar: OK');
	}

	public function test_lines_is_array(): void {
		$this->assertIsArray($this->logDAO::lines());
		$this->assertInstanceOf(FreshRSS_Log::class, $this->logDAO::lines()[0]);
	}

}
