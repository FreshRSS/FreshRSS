<?php

/**
 * This controller manage API-related features.
 */
class FreshRSS_api_Controller extends Minz_ActionController {
	/**
	 * This action updates the user API password.
	 *
	 * Parameter is:
	 * - apiPasswordPlain: the new user password
	 */
	public function updatePasswordAction() {
		if (!FreshRSS_Auth::hasAccess()) {
			Minz_Error::error(403);
		}

		$return_url = array('c' => 'user', 'a' => 'profile');

		if (!Minz_Request::isPost()) {
			Minz_Request::forward($return_url, true);
		}

		$apiPasswordPlain = Minz_Request::param('apiPasswordPlain', '', true);
		if ($apiPasswordPlain == '') {
			Minz_Request::forward($return_url, true);
		}

		$username = Minz_Session::param('currentUser');
		$userConfig = FreshRSS_Context::$user_conf;

		$apiPasswordHash = FreshRSS_password_Util::hash($apiPasswordPlain);
		$userConfig->apiPasswordHash = $apiPasswordHash;

		$feverKey = FreshRSS_fever_Util::updateKey($username, $apiPasswordPlain);
		if (!$feverKey) {
			Minz_Request::bad(_t('feedback.api.password.failed'), $return_url);
		}

		$userConfig->feverKey = $feverKey;
		if ($userConfig->save()) {
			Minz_Request::good(_t('feedback.api.password.updated'), $return_url);
		} else {
			Minz_Request::bad(_t('feedback.api.password.failed'), $return_url);
		}
	}
}
