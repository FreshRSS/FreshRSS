<?php
declare(strict_types=1);

class FreshRSS_password_Util {
	// Will also have to be computed client side on mobile devices,
	// so do not use a too high cost
	public const BCRYPT_COST = 9;

	/**
	 * Return a hash of a plain password, using BCRYPT
	 */
	public static function hash(#[\SensitiveParameter] string $passwordPlain): string {
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
	public static function check(#[\SensitiveParameter] string $password): bool {
		return strlen($password) >= 7;
	}

	/** Validity of a password reset link, in seconds */
	public const RESET_TOKEN_LIFETIME = 3600;
	/** Minimum delay between two password reset emails for the same user, in seconds */
	public const RESET_TOKEN_THROTTLE = 300;

	/**
	 * Generate a new password reset token.
	 * Only the SHA-256 hash of the token is meant to be stored.
	 *
	 * @param array<int|string,mixed>|null $current The currently stored reset data, if any
	 * @return array{token:string,data:array{hash:string,issued:int,expires:int}}|null
	 * 	The plain token (to be sent to the user) and the data to store, or null if throttled
	 */
	public static function newResetToken(?array $current, int $now): ?array {
		$issued = $current['issued'] ?? null;
		if (is_int($issued) && $now - $issued < self::RESET_TOKEN_THROTTLE) {
			return null;
		}
		$token = bin2hex(random_bytes(32));
		return [
			'token' => $token,
			'data' => [
				'hash' => hash('sha256', $token),
				'issued' => $now,
				'expires' => $now + self::RESET_TOKEN_LIFETIME,
			],
		];
	}

	/**
	 * @param array<int|string,mixed>|null $data The stored reset data, if any
	 * @param string $token The plain token received from the user
	 */
	public static function checkResetToken(?array $data, #[\SensitiveParameter] string $token, int $now): bool {
		$hash = $data['hash'] ?? null;
		$expires = $data['expires'] ?? null;
		if ($token === '' || !is_string($hash) || !is_int($expires)) {
			return false;
		}
		return $now <= $expires && hash_equals($hash, hash('sha256', $token));
	}

	public static function cryptAvailable(): bool {
		$hash = '$2y$04$usesomesillystringfore7hnbRJHxXVLeakoG8K30oukPsA.ztMG';
		return $hash === @crypt('password', $hash);
	}
}
