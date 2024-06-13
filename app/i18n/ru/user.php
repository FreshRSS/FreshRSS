<?php

/******************************************************************************/
/* Each entry of that file can be associated with a comment to indicate its   */
/* state. When there is no comment, it means the entry is fully translated.   */
/* The recognized comments are (comment matching is case-insensitive):        */
/*   + TODO: the entry has never been translated.                             */
/*   + DIRTY: the entry has been translated but needs to be updated.          */
/*   + IGNORE: the entry does not need to be translated.                      */
/* When a comment is not recognized, it is discarded.                         */
/******************************************************************************/

return array(
	'email' => array(
		'feedback' => array(
			'invalid' => 'Этот адрес электронной почты неверный.',
			'required' => 'Требуется адрес электронной почты.',
		),
		'validation' => array(
			'change_email' => 'Вы можете изменить ваш адрес электронной почты <a href="%s">на странице профиля</a>.',
			'email_sent_to' => 'Мы отправили вам письмо по адресу <strong>%s</strong>. Пожалуйста, следуйте инструкциям в нём, чтобы подтвердить ваш адрес электронной почты.',
			'feedback' => array(
				'email_failed' => 'Мы не смогли отправить вам письмо из-за ошибки конфигурации сервера.',
				'email_sent' => 'Письмо отправлено на ваш адрес электронной почты.',
				'error' => 'Не удалось подтвердить адрес электронной почты.',
				'ok' => 'Адрес электронной почты подтверждён.',
				'unnecessary' => 'Этот адрес электронной почты уже подтверждён.',
				'wrong_token' => 'Не удалось подтвердить этот адрес электронной почты из-за неверного токена.',
			),
			'need_to' => 'Вам необходимо подтвердить адрес электронной почты, прежде чем вы сможете пользоваться %s.',
			'resend_email' => 'Отправить ещё раз',
			'title' => 'Подтверждение адреса электронной почты',
		),
	),
	'mailer' => array(
		'email_need_validation' => array(
			'body' => 'Вы зарегистрировались в %s, но вам всё ещё нужно подтвердить ваш адрес электронной почты. Для этого просто перейдите по ссылке:',
			'title' => 'Вам нужно подтвердить ваш аккаунт',
			'welcome' => 'Добро пожаловать, %s,',
		),
	),
	'password' => array(
		'invalid' => 'Неверный пароль.',
	),
	'tos' => array(
		'feedback' => array(
			'invalid' => 'Вы должны принять Условия предоставления услуг, чтобы зарегистрироваться.',
		),
	),
	'username' => array(
		'invalid' => 'Неверное имя пользователя.',
		'taken' => 'Имя пользователя %s занято.',
	),
);
