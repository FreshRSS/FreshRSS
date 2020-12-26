<?php

/**
 * This controller manage API-related features.
 */
class FreshRSS_api_Controller extends Minz\ActionController {

	/**
	 * Update the user API password.
	 * Return an error message, or `false` if no error.
	 */
	public static function updatePassword($apiPasswordPlain) {
		$username = Minz\Session::param('currentUser');
		$userConfig = FreshRSS_Context::$user_conf;

		$apiPasswordHash = FreshRSS_password_Util::hash($apiPasswordPlain);
		$userConfig->apiPasswordHash = $apiPasswordHash;

		$feverKey = FreshRSS_fever_Util::updateKey($username, $apiPasswordPlain);
		if (!$feverKey) {
			return _t('feedback.api.password.failed');
		}

		$userConfig->feverKey = $feverKey;
		if ($userConfig->save()) {
			return false;
		} else {
			return _t('feedback.api.password.failed');
		}
	}

	/**
	 * This action updates the user API password.
	 *
	 * Parameter is:
	 * - apiPasswordPlain: the new user password
	 */
	public function updatePasswordAction() {
		if (!FreshRSS_Auth::hasAccess()) {
			Minz\Error::error(403);
		}

		$return_url = array('c' => 'user', 'a' => 'profile');

		if (!Minz\Request::isPost()) {
			Minz\Request::forward($return_url, true);
		}

		$apiPasswordPlain = Minz\Request::param('apiPasswordPlain', '', true);
		$apiPasswordPlain = trim($apiPasswordPlain);
		if ($apiPasswordPlain == '') {
			Minz\Request::forward($return_url, true);
		}

		$error = self::updatePassword($apiPasswordPlain);
		if ($error) {
			Minz\Request::bad($error, $return_url);
		} else {
			Minz\Request::good(_t('feedback.api.password.updated'), $return_url);
		}
	}
}
