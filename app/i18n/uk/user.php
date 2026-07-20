<?php

/******************************************************************************
 * Each entry of that file can be associated with a comment to indicate its   *
 * state. When there is no comment, it means the entry is fully translated.   *
 * The recognized comments are (comment matching is case-insensitive):        *
 *   + TODO: the entry has never been translated.                             *
 *   + DIRTY: the entry has been translated but needs to be updated.          *
 *   + IGNORE: the entry does not need to be translated.                      *
 * When a comment is not recognized, it is discarded.                         *
 ******************************************************************************/

return array(
	'email' => array(
		'feedback' => array(
			'invalid' => 'Хибна адреса електронної пошти.',
			'required' => 'Адреса електронної пошти обовʼязкова.',
		),
		'validation' => array(
			'change_email' => 'Можете змінити адресу електронної пошти <a href="%s">на сторінці профілю</a>.',
			'email_sent_to' => 'На <strong>%s</strong> надіслано лист. Щоб підтвердити вашу адресу, виконайте інструкції з нього.',
			'feedback' => array(
				'email_failed' => 'Не вдалося надіслати вам лист через помилку налаштування сервера.',
				'email_sent' => 'На вашу адресу надіслано лист.',
				'error' => 'Не вдалося підтвердити адресу електронної пошти.',
				'ok' => 'Адресу електронної пошти підтверджено.',
				'unnecessary' => 'Цю адресу електронної пошти вже було підтверджено.',
				'wrong_token' => 'Не вдалося підтвердити адресу електронної пошти через хибний токен.',
			),
			'need_to' => 'Перш ніж почати користуватися %s, підтвердьте адресу електронної пошти %s.',
			'resend_email' => 'Надіслати лист повторно',
			'title' => 'Підтвердження адреси електронної пошти',
		),
	),
	'mailer' => array(
		'email_need_validation' => array(
			'body' => 'Ви щойно зареєструвались у %s, але спершу вам слід підтвердити адресу електронної пошти. Для цього перейдіть за посиланням:',
			'title' => 'Слід підтвердити реєстрацію',
			'welcome' => 'Вітаємо, %s,',
		),
	),
	'password' => array(
		'invalid' => 'Хибний пароль.',
	),
	'tos' => array(
		'feedback' => array(
			'invalid' => 'Щоб зареєструватись, необхідно прийняти умови надання послуг.',
		),
	),
	'username' => array(
		'invalid' => 'Хибне користувацьке імʼя.',
		'taken' => 'Користувацьке імʼя %s зайнято.',
	),
);
