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
			'invalid' => '此電子郵件位址無效。',
			'required' => '需要電子郵件位址。',
		),
		'validation' => array(
			'change_email' => '您可以 <a href="%s">在簡介頁面</a> 變更電子郵件位址。',
			'email_sent_to' => '我們已發送一封電子郵件到 <strong>%s</strong>。請遵循其說明驗證您的位址。',
			'feedback' => array(
				'email_failed' => '因為伺服器配置錯誤，我們無法給您發送電子郵件。',
				'email_sent' => '一封電子郵件已發送到您的位址。',
				'error' => '電子郵件位址驗證失敗。',
				'ok' => '此電子郵件位址已驗證。',
				'unnecessary' => '此電子郵件位址已驗證過。',
				'wrong_token' => '由於錯誤的權杖，此電子郵件位址驗證失敗。',
			),
			'need_to' => '您需要先驗證電子郵件位址才能使用 %s。',
			'resend_email' => '重新發送電子郵件',
			'title' => '電子郵件位址驗證',
		),
	),
	'mailer' => array(
		'email_need_validation' => array(
			'body' => '您剛剛在 %s 註冊，但仍需要驗證電子郵件位址。請點擊以下連結:',
			'title' => '您需要驗證您的帳號',
			'welcome' => '歡迎 %s，',
		),
	),
	'password' => array(
		'invalid' => '密碼無效',
	),
	'tos' => array(
		'feedback' => array(
			'invalid' => '您必須接受服務條款才能註冊。',
		),
	),
	'username' => array(
		'invalid' => '此使用者名稱無效。',
		'taken' => '此使用者名稱，%s，已被使用。',
	),
);
