<?php
declare(strict_types=1);

use FreshRss\Minz\Request;
use FreshRss\Minz\Url;
use FreshRss\Models\Context;
use PHPUnit\Framework\Attributes\DataProvider;

final class ContextTest extends \PHPUnit\Framework\TestCase {

	/** @return Traversable<string,array{array<string,mixed>,int}> */
	public static function provideRedirectStates(): Traversable {
		yield 'default preference' => [[], 0];
		yield 'legacy unread filter' => [['state' => '2'], 2];
		yield 'legacy favourite filter' => [['state' => '4'], 4];
		yield 'legacy all articles' => [['state' => '3'], 3];
		yield 'automatic unread view' => [['state' => '2', 'stateForRedirect' => '0'], 0];
		yield 'automatic all view' => [['state' => '3', 'stateForRedirect' => '0'], 0];
		yield 'explicit unread view' => [['state' => '2', 'stateForRedirect' => '2'], 2];
		yield 'explicit favourite view' => [['state' => '4', 'stateForRedirect' => '4'], 4];
		yield 'original filter takes precedence' => [['state' => '2', 'stateForRedirect' => '4'], 4];
		yield 'integer zero remains automatic' => [['state' => 2, 'stateForRedirect' => 0], 0];
		yield 'invalid origin falls back' => [['state' => '2', 'stateForRedirect' => 'invalid'], 2];
		yield 'array origin falls back' => [['state' => '4', 'stateForRedirect' => ['0']], 4];
	}

	/** @param array<string,mixed> $params */
	#[DataProvider('provideRedirectStates')]
	public static function testStateForRedirect(array $params, int $expected): void {
		$original = Request::params();
		try {
			Request::_params($params);
			self::assertSame($expected, Context::getStateForRedirect());
			self::assertSame($params, Request::params());
		} finally {
			Request::_params($original);
		}
	}

	public static function testAutomaticStateSurvivesUrlEncoding(): void {
		$url = Url::display(['params' => ['state' => 2, 'stateForRedirect' => 0]], 'ascii');
		self::assertStringContainsString('state=2&stateForRedirect=0', $url);
	}
}
