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
			'invalid' => '電子郵箱地址無效',
			'required' => '必須填寫郵箱地址',
		),
		'validation' => array(
			'change_email' => '您可以在 <a href="%s">使用者管理</a> 中變更您的郵箱地址',
			'email_sent_to' => '我們已通過 <strong>%s</strong> 發送驗證郵件給您，請按其中指示來驗證郵箱地址。',
			'feedback' => array(
				'email_failed' => '由於伺服器配置錯誤，我們無法向您發送郵件。',
				'email_sent' => '郵件已發送到您的郵箱中',
				'error' => '郵箱地址無法通過驗證',
				'ok' => '郵箱地址已成功通過驗證',
				'unnecessary' => '該郵箱地址已被驗證',
				'wrong_token' => '由於令牌錯誤，郵箱地址無法通過驗證。',
			),
			'need_to' => '您需要先驗證郵箱地址才能使用 %s',
			'resend_email' => '重發郵件',
			'title' => '驗證郵箱地址',
		),
	),
	'mailer' => array(
		'email_need_validation' => array(
			'body' => '%s,歡迎',
			'title' => '您需要驗證您的帳號',
			'welcome' => '您已註冊 %s 現在只需點擊下方連結通過郵箱驗證即可完成註冊:',
		),
	),
	'password' => array(
		'invalid' => '無效密碼',
	),
	'tos' => array(
		'feedback' => array(
			'invalid' => '您必須接受服務條款才能註冊',
		),
	),
	'username' => array(
		'invalid' => '無效用戶名',
		'taken' => '已存在此用戶名',
	),
);
