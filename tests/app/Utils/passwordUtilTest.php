<?php
declare(strict_types=1);

use PHPUnit\Framework\Attributes\DataProvider;

final class passwordUtilTest extends \PHPUnit\Framework\TestCase {
	public function testCheck(): void {
		$password = '1234567';

		$ok = FreshRSS_password_Util::check($password);

		self::assertTrue($ok);
	}

	public function testCheckReturnsFalseIfEmpty(): void {
		$password = '';

		$ok = FreshRSS_password_Util::check($password);

		self::assertFalse($ok);
	}

	public function testCheckReturnsFalseIfLessThan7Characters(): void {
		$password = '123456';

		$ok = FreshRSS_password_Util::check($password);

		self::assertFalse($ok);
	}

	private const NOW = 1_800_000_000;

	public function testNewResetToken(): void {
		$result = FreshRSS_password_Util::newResetToken(null, self::NOW);

		self::assertNotNull($result);
		self::assertMatchesRegularExpression('/^[0-9a-f]{64}$/', $result['token']);
		self::assertSame(hash('sha256', $result['token']), $result['data']['hash']);
		self::assertSame(self::NOW, $result['data']['issued']);
		self::assertSame(self::NOW + FreshRSS_password_Util::RESET_TOKEN_LIFETIME, $result['data']['expires']);
	}

	public function testNewResetTokenDoesNotStorePlainToken(): void {
		$result = FreshRSS_password_Util::newResetToken(null, self::NOW);

		self::assertNotNull($result);
		self::assertNotContains($result['token'], $result['data']);
	}

	public function testNewResetTokenIsRandom(): void {
		$first = FreshRSS_password_Util::newResetToken(null, self::NOW);
		$second = FreshRSS_password_Util::newResetToken(null, self::NOW);

		self::assertNotNull($first);
		self::assertNotNull($second);
		self::assertNotSame($first['token'], $second['token']);
	}

	public function testNewResetTokenIsThrottled(): void {
		$first = FreshRSS_password_Util::newResetToken(null, self::NOW);
		self::assertNotNull($first);

		$tooSoon = self::NOW + FreshRSS_password_Util::RESET_TOKEN_THROTTLE - 1;
		self::assertNull(FreshRSS_password_Util::newResetToken($first['data'], $tooSoon));

		$later = self::NOW + FreshRSS_password_Util::RESET_TOKEN_THROTTLE;
		self::assertNotNull(FreshRSS_password_Util::newResetToken($first['data'], $later));
	}

	public function testNewResetTokenIgnoresInvalidCurrentData(): void {
		self::assertNotNull(FreshRSS_password_Util::newResetToken(['issued' => 'garbage'], self::NOW));
	}

	public function testCheckResetToken(): void {
		$result = FreshRSS_password_Util::newResetToken(null, self::NOW);
		self::assertNotNull($result);

		self::assertTrue(FreshRSS_password_Util::checkResetToken($result['data'], $result['token'], self::NOW));
		self::assertTrue(FreshRSS_password_Util::checkResetToken($result['data'], $result['token'], $result['data']['expires']));
	}

	public function testCheckResetTokenExpired(): void {
		$result = FreshRSS_password_Util::newResetToken(null, self::NOW);
		self::assertNotNull($result);

		self::assertFalse(FreshRSS_password_Util::checkResetToken($result['data'], $result['token'], $result['data']['expires'] + 1));
	}

	public function testCheckResetTokenWrongToken(): void {
		$result = FreshRSS_password_Util::newResetToken(null, self::NOW);
		self::assertNotNull($result);

		self::assertFalse(FreshRSS_password_Util::checkResetToken($result['data'], strrev($result['token']), self::NOW));
		self::assertFalse(FreshRSS_password_Util::checkResetToken($result['data'], '', self::NOW));
		// The stored hash must not be usable as a token
		self::assertFalse(FreshRSS_password_Util::checkResetToken($result['data'], $result['data']['hash'], self::NOW));
	}

	/** @return list<array{array<int|string,mixed>|null}> */
	public static function provideInvalidResetData(): array {
		return [
			[null],
			[[]],
			[['hash' => hash('sha256', 'token')]],
			[['expires' => self::NOW + 60]],
			[['hash' => 123, 'expires' => self::NOW + 60]],
			[['hash' => hash('sha256', 'token'), 'expires' => (string)(self::NOW + 60)]],
		];
	}

	/** @param array<int|string,mixed>|null $data */
	#[DataProvider('provideInvalidResetData')]
	public function testCheckResetTokenInvalidData(?array $data): void {
		self::assertFalse(FreshRSS_password_Util::checkResetToken($data, 'token', self::NOW));
	}
}
