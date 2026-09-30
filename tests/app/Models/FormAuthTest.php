<?php
declare(strict_types=1);

final class FormAuthTest extends \PHPUnit\Framework\TestCase {
	public function testCheck(): void {
		$password = '1234567';
		$ok = FreshRSS_FormAuth::passwordRequirementsMet($password);
		self::assertTrue($ok);
	}

	public function testReqsCheckReturnsFalseIfEmpty(): void {
		$password = '';
		$ok = FreshRSS_FormAuth::passwordRequirementsMet($password);
		self::assertFalse($ok);
	}

	public function testReqsCheckReturnsFalseIfLessThan7Characters(): void {
		$password = '123456';
		$ok = FreshRSS_FormAuth::passwordRequirementsMet($password);
		self::assertFalse($ok);
	}

	public function testReqsCheckReturnsTrueIfAtExactly72Characters(): void {
		$password = str_repeat('A', 72);
		$ok = FreshRSS_FormAuth::passwordRequirementsMet($password);
		self::assertTrue($ok);
	}

	public function testReqsCheckReturnsFalseIfMoreThan72Characters(): void {
		$password = str_repeat('A', 73);
		$ok = FreshRSS_FormAuth::passwordRequirementsMet($password);
		self::assertFalse($ok);
	}

	public function testReqsCheckReturnsTrueIfLessThan7CharactersAndWithNoMinLengthEnforcement(): void {
		$password = '123456';
		$ok = FreshRSS_FormAuth::passwordRequirementsMet($password, ['enforceMinLength' => false]);
		self::assertTrue($ok);
	}

	public function testAuthWithInvalidUsernameAndCorrectCredentialsFail(): void {
		$username = ':-)';
		$password = '1234567';
		$hash = FreshRSS_password_Util::hash($password);
		$ok = FreshRSS_FormAuth::checkCredentials(
			$username, $hash, $password
		);
		self::assertFalse($ok);
		self::assertSame(Minz_Log::getLastLog(), "Invalid credential parameters: user={$username}");
	}

	public function testAuthWithValidUsernameAndWrongCredentialsFail(): void {
		$username = 'admin';
		$password = 'correctpassword';
		$hash = FreshRSS_password_Util::hash('badpassword');
		$ok = FreshRSS_FormAuth::checkCredentials(
			$username, $hash, $password
		);
		self::assertFalse($ok);
		self::assertSame(Minz_Log::getLastLog(), '');
	}

	public function testAuthWithValidUsernameAndCorrectCredentialsOk(): void {
		$username = 'admin';
		$password = 'correctpassword';
		$hash = FreshRSS_password_Util::hash($password);
		$ok = FreshRSS_FormAuth::checkCredentials(
			$username, $hash, $password
		);
		self::assertTrue($ok);
		self::assertSame(Minz_Log::getLastLog(), '');
	}

	public function testAuthWithValidUsernameAndCorrectCredentialsAndEmptyPasswordFail(): void {
		$username = 'admin';
		$password = '';
		$hash = FreshRSS_password_Util::hash($password);
		$ok = FreshRSS_FormAuth::checkCredentials(
			$username, $hash, $password
		);
		self::assertFalse($ok);
		self::assertSame(Minz_Log::getLastLog(), "Refusing authentication with empty zero-length password: user={$username}");
	}

	public function testAuthWithValidUsernameAndCorrectCredentialsAndTooLongPasswordFail(): void {
		$username = 'admin';
		$password = str_repeat('a', 73);
		$hash = FreshRSS_password_Util::hash($password);
		$ok = FreshRSS_FormAuth::checkCredentials(
			$username, $hash, $password
		);
		self::assertFalse($ok);
		self::assertSame(Minz_Log::getLastLog(), "Exceeded maximum allowed password length during authentication: user={$username}");

		// It's fine if the user truncates their own password though
		$password = str_repeat('a', 72);
		$ok = FreshRSS_FormAuth::checkCredentials(
			$username, $hash, $password
		);
		self::assertTrue($ok);
		self::assertSame(Minz_Log::getLastLog(), '');

		// If truncated down to less than 72 characters, login should fail
		$password = str_repeat('a', 71);
		$ok = FreshRSS_FormAuth::checkCredentials(
			$username, $hash, $password
		);
		self::assertFalse($ok);
		self::assertSame(Minz_Log::getLastLog(), '');
	}

	public function testAuthWithValidUsernameAndCorrectCredentialsAndWrongPassAlgorithmFail(): void {
		$username = 'admin';
		$password = '1234567';
		$hash = crypt($password, 'ab'); // Uses `password_verify()` compatible algorithm
		$ok = FreshRSS_FormAuth::checkCredentials(
			$username, $hash, $password
		);
		self::assertFalse($ok);
		self::assertSame(Minz_Log::getLastLog(), "Invalid hash format: user={$username}");
	}

	public function testAuthWithValidUsernameAndAnyCredentialsAndMalformedBcryptHashFail(): void {
		$username = 'admin';
		$password = 'whatever';
		$hash = '$2y$04$00000000$'; // See: https://github.com/php/php-src/security/advisories/GHSA-7fj2-8x79-rjf4
		$ok = FreshRSS_FormAuth::checkCredentials(
			$username, $hash, $password
		);
		self::assertFalse($ok);
		self::assertSame(Minz_Log::getLastLog(), "Invalid hash format: user={$username}");
	}

	public function testAuthWithValidUsernameAndAnyCredentialsAndEmptyHashFail(): void {
		$username = 'admin';
		$password = 'whatever';
		$hash = '';
		$ok = FreshRSS_FormAuth::checkCredentials(
			$username, $hash, $password
		);
		self::assertFalse($ok);
		self::assertSame(Minz_Log::getLastLog(), "Invalid credential parameters: user={$username}"); // `ctype_graph($hash)` returns false on empty string values
	}

	public function testAuthWithValidUsernameAndCorrectHashAsPasswordFail(): void {
		$username = 'admin';
		$password = 'whatever';
		$hash = FreshRSS_password_Util::hash($password);
		$ok = FreshRSS_FormAuth::checkCredentials(
			$username, $hash, $hash
		);
		self::assertFalse($ok);
		self::assertSame(Minz_Log::getLastLog(), '');
	}
}
