<?php

class FreshRSS_FormAuth {
	public static function checkCredentials($username, $hash, $nonce, $challenge) {
		if (!FreshRSS_user_Controller::checkUsername($username) ||
				!ctype_graph($hash) ||
				!ctype_graph($challenge) ||
				!ctype_alnum($nonce)) {
			Minz_Log::debug('Invalid credential parameters:' .
			                ' user=' . $username .
			                ' challenge=' . $challenge .
			                ' nonce=' . $nonce);
			return false;
		}

		return password_verify($nonce . $hash, $challenge);
	}

	public static function getCredentialsFromCookie() {
		$token = Minz_Session::getLongTermCookie('FreshRSS_login');
		if (!ctype_alnum($token)) {
			return array();
		}

		$token_file = DATA_PATH . '/tokens/' . $token . '.txt';
		$mtime = @filemtime($token_file);
		$limits = FreshRSS_Context::$system_conf->limits;
		$cookie_duration = empty($limits['cookie_duration']) ? FreshRSS_Auth::DEFAULT_COOKIE_DURATION : $limits['cookie_duration'];
		if ($mtime + $cookie_duration < time()) {
			// Token has expired (> cookie_duration) or does not exist.
			@unlink($token_file);
			return array();
		}

		$credentials = @file_get_contents($token_file);
		if ($credentials !== false && self::renewCookie($token)) {
			return explode("\t", $credentials, 2);
		}
		return [];
	}

	private static function renewCookie($token) {
		$token_file = DATA_PATH . '/tokens/' . $token . '.txt';
		if (touch($token_file)) {
			$limits = FreshRSS_Context::$system_conf->limits;
			$cookie_duration = empty($limits['cookie_duration']) ? FreshRSS_Auth::DEFAULT_COOKIE_DURATION : $limits['cookie_duration'];
			$expire = time() + $cookie_duration;
			Minz_Session::setLongTermCookie('FreshRSS_login', $token, $expire);
			return $token;
		}
		return false;
	}

	public static function makeCookie($username, $password_hash) {
		do {
			$token = sha1(FreshRSS_Context::$system_conf->salt . $username . uniqid(mt_rand(), true));
			$token_file = DATA_PATH . '/tokens/' . $token . '.txt';
		} while (file_exists($token_file));

		if (@file_put_contents($token_file, $username . "\t" . $password_hash) === false) {
			return false;
		}

		return self::renewCookie($token);
	}

	public static function deleteCookie() {
		$token = Minz_Session::getLongTermCookie('FreshRSS_login');
		if (ctype_alnum($token)) {
			Minz_Session::deleteLongTermCookie('FreshRSS_login');
			@unlink(DATA_PATH . '/tokens/' . $token . '.txt');
		}

		if (rand(0, 10) === 1) {
			self::purgeTokens();
		}
	}

	public static function purgeTokens() {
		$limits = FreshRSS_Context::$system_conf->limits;
		$cookie_duration = empty($limits['cookie_duration']) ? FreshRSS_Auth::DEFAULT_COOKIE_DURATION : $limits['cookie_duration'];
		$oldest = time() - $cookie_duration;
		foreach (new DirectoryIterator(DATA_PATH . '/tokens/') as $file_info) {
			$extension = $file_info->getExtension();
			if ($extension === 'txt' && $file_info->getMTime() < $oldest) {
				@unlink($file_info->getPathname());
			}
		}
	}
}
