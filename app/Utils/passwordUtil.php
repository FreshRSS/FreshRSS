<?php
declare(strict_types=1);

class FreshRSS_password_Util {
	// Will also have to be computed client side on mobile devices,
	// so do not use a too high cost
	public const BCRYPT_COST = 9;

	/**
	 * Return a hash of a plain password, using BCRYPT
	 */
	public static function hash(string $passwordPlain): string {
		$passwordHash = password_hash(
			$passwordPlain,
			PASSWORD_BCRYPT,
			['cost' => self::BCRYPT_COST]
		);
		return $passwordHash;
	}

	/**
	 * Verify the given password is valid.
	 *
	 * A valid password is a string of at least 7 characters.
	 *
	 * @return bool True if the password is valid, false otherwise
	 */
	public static function check(string $password): bool {
		return strlen($password) >= 7;
	}

	public static function cryptAvailable(): bool {
		$hash = '$2y$04$usesomesillystringfore7hnbRJHxXVLeakoG8K30oukPsA.ztMG';
		return $hash === @crypt('password', $hash);
	}
}
