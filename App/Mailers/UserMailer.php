<?php

namespace Freshrss\Mailers;

/**
 * Manage the emails sent to the users.
 */
class User_Mailer extends Mailer {
	public function send_email_need_validation($username, $user_config) {
		$this->view->_path('user_mailer/email_need_validation.txt');

		$this->view->username = $username;
		$this->view->site_title = Context::$system_conf->title;
		$this->view->validation_url = Url::display(
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

		$subject_prefix = '[' . Context::$system_conf->title . ']';
		return $this->mail(
			$user_config->mail_login,
			$subject_prefix . ' ' ._t('user.mailer.email_need_validation.title')
		);
	}
}
