<?php

declare(strict_types=1);

class ImportServiceTest extends PHPUnit\Framework\TestCase {
	private $importService;
	protected function setUp(): void
	{
		$this->importService = new FreshRSS_Import_Service();
		var_dump($this->importService);
	}

	public function testLastStatus():void
	{
		self::assertIsBool($this->importService->lastStatus() );
	}

}
