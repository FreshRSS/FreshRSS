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

	public function testReqsCheckReturnsFalseIfLessThan7Utf8Bytes(): void {
		$password = str_repeat('é', 3);
		self::assertSame(6, strlen($password));

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

	public function testReqsCheckReturnsTrueIfAtExactly72Utf8Bytes(): void {
		$password = str_repeat('é', 36);
		self::assertSame(72, strlen($password));

		$ok = FreshRSS_FormAuth::passwordRequirementsMet($password);
		self::assertTrue($ok);
	}

	public function testReqsCheckReturnsFalseIfMoreThan72Utf8Bytes(): void {
		$password = str_repeat('é', 37);
		self::assertSame(74, strlen($password));

		$ok = FreshRSS_FormAuth::passwordRequirementsMet($password);
		self::assertFalse($ok);
	}

	public function testReqsCheckReturnsFalseIfAtExactly73Utf8Bytes(): void {
		$password = str_repeat('é', 36) . 'a';
		self::assertSame(73, strlen($password));

		$ok = FreshRSS_FormAuth::passwordRequirementsMet($password);
		self::assertFalse($ok);
	}

	public function testReqsCheckAcceptsOtherMultibyteBoundary(): void {
		$password = str_repeat('€', 24);
		self::assertSame(72, strlen($password));
		self::assertTrue(FreshRSS_FormAuth::passwordRequirementsMet($password));

		$password .= '€';
		self::assertSame(75, strlen($password));
		self::assertFalse(FreshRSS_FormAuth::passwordRequirementsMet($password));
	}

	public function testReqsCheckReturnsTrueIfLessThan7CharactersAndWithNoMinLengthEnforcement(): void {
		$password = '123456';
		$ok = FreshRSS_FormAuth::passwordRequirementsMet($password, ['enforceMinLength' => false]);
		self::assertTrue($ok);
	}

	public function testReqsCheckReturnsTrueIfLessThan7Utf8BytesAndWithNoMinLengthEnforcement(): void {
		$password = str_repeat('é', 3);
		self::assertSame(6, strlen($password));

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
		self::assertSame("Invalid credential parameters: user={$username}", Minz_Log::getLastLog());
	}

	public function testAuthWithValidUsernameAndWrongCredentialsFail(): void {
		$username = 'admin';
		$password = 'correctpassword';
		$hash = FreshRSS_password_Util::hash('badpassword');
		$ok = FreshRSS_FormAuth::checkCredentials(
			$username, $hash, $password
		);
		self::assertFalse($ok);
		self::assertSame('', Minz_Log::getLastLog());
	}

	public function testAuthWithValidUsernameAndCorrectCredentialsOk(): void {
		$username = 'admin';
		$password = 'correctpassword';
		$hash = FreshRSS_password_Util::hash($password);
		$ok = FreshRSS_FormAuth::checkCredentials(
			$username, $hash, $password
		);
		self::assertTrue($ok);
		self::assertSame('', Minz_Log::getLastLog());
	}

	public function testAuthWithValidUsernameAndCorrectCredentialsAndTooLongUtf8PasswordOk(): void {
		$username = 'admin';
		$password = str_repeat('a', 71) . 'é';
		self::assertSame(73, strlen($password));
		$hash = FreshRSS_password_Util::hash($password);
		$ok = FreshRSS_FormAuth::checkCredentials(
			$username, $hash, $password
		);
		self::assertTrue($ok); // Login is successful with a cut-off UTF-8 character at the end
		self::assertSame('', Minz_Log::getLastLog());

		$password .= 'é';
		$hash = FreshRSS_password_Util::hash($password);
		$ok = FreshRSS_FormAuth::checkCredentials(
			$username, $hash, $password
		);
		self::assertFalse($ok);
		self::assertSame("Exceeded maximum allowed password length during authentication: user={$username}", Minz_Log::getLastLog());
	}

	public function testAuthWithValidUsernameAndCorrectCredentialsAndTooLongUtf8PasswordWithCutOffCharacterFollowedByAnotherCharacterFail(): void {
		$username = 'admin';
		$password = str_repeat('a', 71) . 'éa';
		self::assertSame(74, strlen($password));
		$hash = FreshRSS_password_Util::hash($password);
		$ok = FreshRSS_FormAuth::checkCredentials(
			$username, $hash, $password
		);
		self::assertFalse($ok);
		self::assertSame("Exceeded maximum allowed password length during authentication: user={$username}", Minz_Log::getLastLog());
	}

	public function testAuthWithValidUsernameAndCorrectCredentialsAndTooLongUtf8PasswordWithThreeByteCharacterOk(): void {
		$username = 'admin';
		$password = str_repeat('a', 71) . '€';
		self::assertSame(74, strlen($password));
		$hash = FreshRSS_password_Util::hash($password);
		$ok = FreshRSS_FormAuth::checkCredentials(
			$username, $hash, $password
		);
		self::assertTrue($ok); // Login is successful with a cut-off UTF-8 character at the end
		self::assertSame('', Minz_Log::getLastLog());

		$password .= '€';
		$hash = FreshRSS_password_Util::hash($password);
		$ok = FreshRSS_FormAuth::checkCredentials(
			$username, $hash, $password
		);
		self::assertFalse($ok);
		self::assertSame("Exceeded maximum allowed password length during authentication: user={$username}", Minz_Log::getLastLog());
	}

	public function testAuthWithValidUsernameAndCorrectCredentialsAndTooLongUtf8PasswordWithFourByteCharacterOk(): void {
		$username = 'admin';
		$password = str_repeat('a', 71) . '😀';
		self::assertSame(75, strlen($password));
		$hash = FreshRSS_password_Util::hash($password);
		$ok = FreshRSS_FormAuth::checkCredentials(
			$username, $hash, $password
		);
		self::assertTrue($ok); // Login is successful with a cut-off UTF-8 character at the end
		self::assertSame('', Minz_Log::getLastLog());

		$password .= '😀';
		$hash = FreshRSS_password_Util::hash($password);
		$ok = FreshRSS_FormAuth::checkCredentials(
			$username, $hash, $password
		);
		self::assertFalse($ok);
		self::assertSame("Exceeded maximum allowed password length during authentication: user={$username}", Minz_Log::getLastLog());
	}

	public function testAuthWithValidUsernameAndCorrectCredentialsAndTooLongUtf8PasswordWithThreeByteCharacterCutOffAfterTwoBytesOk(): void {
		$username = 'admin';
		$password = str_repeat('a', 70) . '€';
		self::assertSame(73, strlen($password));
		$hash = FreshRSS_password_Util::hash($password);
		$ok = FreshRSS_FormAuth::checkCredentials(
			$username, $hash, $password
		);
		self::assertTrue($ok);
		self::assertSame('', Minz_Log::getLastLog());
	}

	public function testAuthWithValidUsernameAndCorrectCredentialsAndTooLongUtf8PasswordWithFourByteCharacterCutOffAfterTwoBytesOk(): void {
		$username = 'admin';
		$password = str_repeat('a', 70) . '😀';
		self::assertSame(74, strlen($password));
		$hash = FreshRSS_password_Util::hash($password);
		$ok = FreshRSS_FormAuth::checkCredentials(
			$username, $hash, $password
		);
		self::assertTrue($ok);
		self::assertSame('', Minz_Log::getLastLog());
	}

	public function testAuthWithValidUsernameAndCorrectCredentialsAndTooLongUtf8PasswordWithFourByteCharacterCutOffAfterThreeBytesOk(): void {
		$username = 'admin';
		$password = str_repeat('a', 69) . '😀';
		self::assertSame(73, strlen($password));
		$hash = FreshRSS_password_Util::hash($password);
		$ok = FreshRSS_FormAuth::checkCredentials(
			$username, $hash, $password
		);
		self::assertTrue($ok);
		self::assertSame('', Minz_Log::getLastLog());
	}

	public function testAuthWithValidUsernameAndCorrectCredentialsAndTooLongUtf8PasswordWithoutCutOffCharacter(): void {
		$username = 'admin';
		$password = str_repeat('a', 72) . 'é';
		self::assertSame(74, strlen($password));
		$hash = FreshRSS_password_Util::hash($password);
		$ok = FreshRSS_FormAuth::checkCredentials(
			$username, $hash, $password
		);
		self::assertFalse($ok);
		self::assertSame("Exceeded maximum allowed password length during authentication: user={$username}", Minz_Log::getLastLog());
	}

	public function testAuthWithValidUsernameAndCorrectCredentialsAndHugeUtf8Password(): void {
		$username = 'admin';
		$password = str_repeat('a', 10000) . 'é';
		$hash = FreshRSS_password_Util::hash($password);
		$ok = FreshRSS_FormAuth::checkCredentials(
			$username, $hash, $password
		);
		self::assertFalse($ok);
		self::assertSame("Exceeded maximum allowed password length during authentication: user={$username}", Minz_Log::getLastLog());
	}

	public function testAuthWithValidUsernameAndCorrectCredentialsAndEmptyPasswordFail(): void {
		$username = 'admin';
		$password = '';
		$hash = FreshRSS_password_Util::hash($password);
		$ok = FreshRSS_FormAuth::checkCredentials(
			$username, $hash, $password
		);
		self::assertFalse($ok);
		self::assertSame("Refusing authentication with empty zero-length password: user={$username}", Minz_Log::getLastLog());
	}

	public function testAuthWithValidUsernameAndCorrectCredentialsAndTooLongPasswordFail(): void {
		$username = 'admin';
		$password = str_repeat('a', 73);
		$hash = FreshRSS_password_Util::hash($password);
		$ok = FreshRSS_FormAuth::checkCredentials(
			$username, $hash, $password
		);
		self::assertFalse($ok);
		self::assertSame("Exceeded maximum allowed password length during authentication: user={$username}", Minz_Log::getLastLog());

		// It's fine if the user truncates their own password though
		// Note: There are separate tests for UTF-8 passwords to test the case
		// of a cut-off UTF-8 character at the end, which can't easily be truncated
		// by a user.
		$password = str_repeat('a', 72);
		$ok = FreshRSS_FormAuth::checkCredentials(
			$username, $hash, $password
		);
		self::assertTrue($ok);
		self::assertSame('', Minz_Log::getLastLog());

		// If truncated down to less than 72 characters, login should fail
		$password = str_repeat('a', 71);
		$ok = FreshRSS_FormAuth::checkCredentials(
			$username, $hash, $password
		);
		self::assertFalse($ok);
		self::assertSame('', Minz_Log::getLastLog());
	}

	public function testAuthWithValidUsernameAndCorrectCredentialsAndWrongPassAlgorithmFail(): void {
		$username = 'admin';
		$password = '1234567';
		$hash = crypt($password, 'ab'); // Uses `password_verify()` compatible algorithm
		$ok = FreshRSS_FormAuth::checkCredentials(
			$username, $hash, $password
		);
		self::assertFalse($ok);
		self::assertSame("Invalid hash format: user={$username}", Minz_Log::getLastLog());
	}

	public function testAuthWithValidUsernameAndAnyCredentialsAndMalformedBcryptHashFail(): void {
		$username = 'admin';
		$password = 'whatever';
		$hash = '$2y$04$00000000$'; // See: https://github.com/php/php-src/security/advisories/GHSA-7fj2-8x79-rjf4
		$ok = FreshRSS_FormAuth::checkCredentials(
			$username, $hash, $password
		);
		self::assertFalse($ok);
		self::assertSame("Invalid hash format: user={$username}", Minz_Log::getLastLog());
	}

	public function testAuthWithValidUsernameAndAnyCredentialsAndEmptyHashFail(): void {
		$username = 'admin';
		$password = 'whatever';
		$hash = '';
		$ok = FreshRSS_FormAuth::checkCredentials(
			$username, $hash, $password
		);
		self::assertFalse($ok);
		self::assertSame("Invalid credential parameters: user={$username}", Minz_Log::getLastLog()); // `ctype_graph($hash)` returns false on empty string values
	}

	public function testAuthWithValidUsernameAndCorrectHashAsPasswordFail(): void {
		$username = 'admin';
		$password = 'whatever';
		$hash = FreshRSS_password_Util::hash($password);
		$ok = FreshRSS_FormAuth::checkCredentials(
			$username, $hash, $hash
		);
		self::assertFalse($ok);
		self::assertSame('', Minz_Log::getLastLog());
	}
}
