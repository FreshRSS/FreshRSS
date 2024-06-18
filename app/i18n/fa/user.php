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
			'invalid' => ' این آدرس ایمیل نامعتبر است.',
			'required' => ' یک آدرس ایمیل مورد نیاز است.',
		),
		'validation' => array(
			'change_email' => ' می‌توانید آدرس ایمیل خود را <a href="%s">در صفحه نمایه</a> تغییر دهید.',
			'email_sent_to' => ' ما یک ایمیل برای شما به آدرس <strong>%s</strong> ارسال کردیم. لطفاً دستورالعمل های آن را برای تأیید اعتبار آدرس خود دنبال کنید.',
			'feedback' => array(
				'email_failed' => ' به دلیل یک خطای پیکربندی سرور نتوانستیم برای شما ایمیل ارسال کنیم.',
				'email_sent' => ' یک ایمیل به آدرس شما ارسال شده است.',
				'error' => ' اعتبار آدرس ایمیل ناموفق بود.',
				'ok' => ' این آدرس ایمیل تایید شده است.',
				'unnecessary' => ' این آدرس ایمیل قبلاً تأیید شده است.',
				'wrong_token' => ' این آدرس ایمیل به دلیل یک توکن اشتباه تأیید نشد.',
			),
			'need_to' => ' قبل از اینکه بتوانید از %s استفاده کنید',
			'resend_email' => ' ایمیل را دوباره ارسال کنید',
			'title' => ' اعتبار سنجی آدرس ایمیل',
		),
	),
	'mailer' => array(
		'email_need_validation' => array(
			'body' => ' شما به تازگی در %s ثبت نام کرده اید',
			'title' => ' باید حساب خود را تأیید کنید',
			'welcome' => ' خوش آمدید %s',
		),
	),
	'password' => array(
		'invalid' => ' رمز عبور نامعتبر است.',
	),
	'tos' => array(
		'feedback' => array(
			'invalid' => ' برای اینکه بتوانید ثبت نام کنید باید شرایط خدمات را بپذیرید.',
		),
	),
	'username' => array(
		'invalid' => ' این نام کاربری نامعتبر است.',
		'taken' => ' این نام کاربری',
	),
);
