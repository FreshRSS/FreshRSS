<?php
declare(strict_types=1);

require_once LIB_PATH . '/lib_install.php';

use PHPUnit\Framework\Attributes\DataProvider;

final class InstallTest extends \PHPUnit\Framework\TestCase {
	/**
	 * @return list<array{int,bool,'ok'|'ko'|null}>
	 */
	public static function provideGmpRequirementStatus(): array {
		return [
			[8, false, null],
			[4, true, 'ok'],
			[4, false, 'ko'],
		];
	}

	#[DataProvider('provideGmpRequirementStatus')]
	public function testGmpRequirementStatus(int $integerSize, bool $gmpLoaded, ?string $expected): void {
		self::assertSame($expected, gmpRequirementStatus($integerSize, $gmpLoaded));
	}

	/**
	 * @return list<array{string,string,string,string,bool}>
	 */
	public static function provideDbParameters(): array {
		return [
			['localhost', 'freshrss', 'freshrss', 'freshrss_', true],
			['db.example.net:5432', 'fresh.rss@example-net', 'fresh-rss_1', '', true],
			['/var/run/postgresql', 'freshrss', 'freshrss', 'freshrss_', true],
			// Additional libpq connection parameters
			['/ host=127.0.0.1 sslkey=/proc/self/fd/10:key', 'freshrss', 'freshrss', 'freshrss_', false],
			['localhost', 'freshrss', 'x sslcert=/lib/ssl/cert.pem sslkey=/dev/fd/10:k', 'freshrss_', false],
			// Additional PDO connection parameters
			['localhost;unix_socket=/tmp/mysql.sock', 'freshrss', 'freshrss', 'freshrss_', false],
			['localhost', 'freshrss', 'freshrss;charset=latin1', 'freshrss_', false],
			["localhost\n", 'freshrss', 'freshrss', 'freshrss_', false],
			['', 'freshrss', 'freshrss', 'freshrss_', false],
			['localhost', "fresh'rss", 'freshrss', 'freshrss_', false],
			['localhost', 'freshrss', 'fresh"rss', 'freshrss_', false],
			['localhost', 'freshrss', 'freshrss', 'fresh`rss_', false],
			['localhost', 'freshrss', 'freshrss', 'a_prefix_too_long', false],
		];
	}

	#[DataProvider('provideDbParameters')]
	public function testCheckDbParameters(string $host, string $user, string $base, string $prefix, bool $expected): void {
		self::assertSame($expected, checkDbParameters($host, $user, $base, $prefix));
	}
}
