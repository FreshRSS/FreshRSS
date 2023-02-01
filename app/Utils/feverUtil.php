<?php

class FreshRSS_fever_Util {
	private const FEVER_PATH = DATA_PATH . '/fever';

	/**
	 * Make sure the fever path exists and is writable.
	 *
	 * @return bool true if the path is writable, else false.
	 */
	public static function checkFeverPath(): bool {
		if (!file_exists(self::FEVER_PATH)) {
			@mkdir(self::FEVER_PATH, 0770, true);
		}

		$isOk = touch(self::FEVER_PATH . '/index.html');	// is_writable() is not reliable for a folder on NFS
		if (false === $isOk) {
			Minz_Log::error("Could not save Fever API credentials. The directory does not have write access.");
		}
		return $isOk;
	}

	/**
	 * Return the corresponding path for a fever key.
	 */
	public static function getKeyPath(string $feverKey): string {
		$salt = sha1(FreshRSS_Context::$system_conf->salt);
		return self::FEVER_PATH . '/.key-' . $salt . '-' . $feverKey . '.txt';
	}

	/**
	 * Update the fever key of a user.
	 * @return string|false the Fever key, or false if the update failed
	 */
	public static function updateKey(string $username, string $passwordPlain) {
		if (self::checkFeverPath() === false) {
			return false;
		}

		self::deleteKey($username);

		$feverKey = strtolower(md5("{$username}:{$passwordPlain}"));
		$feverKeyPath = self::getKeyPath($feverKey);
		$result = file_put_contents($feverKeyPath, $username);
		if (is_int($result) === true) {
			return $feverKey;
		}
		Minz_Log::warning('Could not save Fever API credentials. Unknown error.', ADMIN_LOG);
		return false;
	}

	/**
	 * Delete the Fever key of a user.
	 *
	 * @return bool true if the deletion succeeded, else false.
	 */
	public static function deleteKey(string $username) {
		$userConfig = get_user_configuration($username);
		if ($userConfig === null) {
			return false;
		}

		$feverKey = $userConfig->feverKey;
		if (!ctype_xdigit($feverKey)) {
			return false;
		}

		$feverKeyPath = self::getKeyPath($feverKey);
		return @unlink($feverKeyPath);
	}
}
