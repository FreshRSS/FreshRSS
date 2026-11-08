<?php
declare(strict_types=1);

final class FeedExceptionTest extends \PHPUnit\Framework\TestCase {

	public function test_keepsHttpStatusCode(): void {
		$previous = new RuntimeException('previous');
		$e = new FreshRSS_Feed_Exception('Gone', 410, $previous);
		self::assertSame(410, $e->getCode());	// feedController mutes a feed on HTTP 410 Gone
		self::assertSame('Gone', $e->getMessage());
		self::assertSame($previous, $e->getPrevious());
		self::assertSame(0, (new FreshRSS_Feed_Exception())->getCode());
	}
}
