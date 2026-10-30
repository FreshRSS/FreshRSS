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
			'invalid' => 'Bu e-poçt ünvanı yanlışdır.',
			'required' => 'E-poçt ünvanı tələb olunur.',
		),
		'validation' => array(
			'change_email' => 'E-poçt ünvanınızı <a href="%s">profil səhifəsində</a> dəyişə bilərsiniz.',
			'email_sent_to' => 'Sizə <strong>%s</strong> ünvanına e-poçt göndərdik. Zəhmət olmasa, ünvanınızı doğrulamaq üçün onun təlimatlarına əməl edin.',
			'feedback' => array(
				'email_failed' => 'Server konfiqurasiyasındakı xəta səbəbindən sizə e-poçt göndərə bilmədik.',
				'email_sent' => 'Ünvanınıza e-poçt göndərildi.',
				'error' => 'E-poçt ünvanının doğrulanması alınmadı.',
				'ok' => 'Bu e-poçt ünvanı doğrulandı.',
				'unnecessary' => 'Bu e-poçt ünvanı artıq doğrulanmışdı.',
				'wrong_token' => 'Yanlış token səbəbindən bu e-poçt ünvanı doğrulanmadı.',
			),
			'need_to' => '%s-dən istifadə edə bilməzdən əvvəl e-poçt ünvanınızı doğrulamalısınız.',
			'resend_email' => 'E-poçtu yenidən göndər',
			'title' => 'E-poçt ünvanının doğrulanması',
		),
	),
	'mailer' => array(
		'email_need_validation' => array(
			'body' => 'Siz indicə %s-də qeydiyyatdan keçdiniz, lakin hələ də e-poçt ünvanınızı doğrulamalısınız. Bunun üçün sadəcə keçidi izləyin:',
			'title' => 'Hesabınızı doğrulamalısınız',
			'welcome' => 'Xoş gəlmisiniz %s,',
		),
	),
	'password' => array(
		'invalid' => 'Parol yanlışdır.',
	),
	'tos' => array(
		'feedback' => array(
			'invalid' => 'Qeydiyyatdan keçə bilmək üçün Xidmət Şərtlərini qəbul etməlisiniz.',
		),
	),
	'username' => array(
		'invalid' => 'Bu istifadəçi adı yanlışdır.',
		'taken' => 'Bu istifadəçi adı, %s, tutulub.',
	),
);
