<?php

/**
 * Manage the emails sent to the users.
 */
class FreshRSS_User_Mailer extends Minz_Mailer {
	public function send_email_need_validation($username, $user_config) {
		Minz_Translate::reset($user_config->language);

		$this->view->_path('user_mailer/email_need_validation.txt.php');

		$this->view->username = $username;
		$this->view->site_title = FreshRSS_Context::$system_conf->title;
		$this->view->validation_url = Minz_Url::display(
			array(
				'c' => 'user',
				'a' => 'validateEmail',
				'params' => array(
					'username' => $username,
					'token' => $user_config->email_validation_token
				)
			),
			'txt',
			true
		);

		$subject_prefix = '[' . FreshRSS_Context::$system_conf->title . ']';
		return $this->mail(
			$user_config->mail_login,
			$subject_prefix . ' ' ._t('user.mailer.email_need_validation.title')
		);
	}
}
