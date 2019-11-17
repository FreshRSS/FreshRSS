<?php

class FreshRSS_fever_Util {
	const FEVER_PATH = DATA_PATH . '/fever';

	/**
	 * Make sure the fever path exists and is writable.
	 *
	 * @return boolean true if the path is writable, else false.
	 */
	public static function checkFeverPath() {
		if (!file_exists(self::FEVER_PATH)) {
			@mkdir(self::FEVER_PATH, 0770, true);
		}

		return is_writable(self::FEVER_PATH);
	}

	/**
	 * Return the corresponding path for a fever key.
	 *
	 * @param string
	 * @return string
	 */
	public static function getKeyPath($feverKey) {
		$salt = sha1(FreshRSS_Context::$system_conf->salt);
		return self::FEVER_PATH . '/.key-' . $salt . '-' . $feverKey . '.txt';
	}

	/**
	 * Update the fever key of a user.
	 *
	 * @param string
	 * @param string
	 * @return string the Fever key, or false if the update failed
	 */
	public static function updateKey($username, $passwordPlain) {
		self::deleteKey($username);

		$feverKey = strtolower(md5("{$username}:{$passwordPlain}"));
		$feverKeyPath = self::getKeyPath($feverKey);
		$res = file_put_contents($feverKeyPath, $username);
		if ($res !== false) {
			return $feverKey;
		} else {
			return false;
		}
	}

	/**
	 * Delete the Fever key of a user.
	 *
	 * @param string
	 * @return boolean true if the deletion succeeded, else false.
	 */
	public static function deleteKey($username) {
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
