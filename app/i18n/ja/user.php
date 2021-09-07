<?php

return array(
	'email' => array(
		'feedback' => array(
			'invalid' => 'このemailアドレスは無効です。',	// TODO - Translation
			'required' => 'このemailアドレスは必要です。',	// TODO - Translation
		),
		'validation' => array(
			'change_email' => 'emailアドレスは <a href="%s">プロフィールページで変更できます</a>.',	// TODO - Translation
			'email_sent_to' => 'あなたのメールボックス<strong>%s</strong>にメールを送りました。有効性を確認するためにメールを確かめてください。',	// TODO - Translation
			'feedback' => array(
				'email_failed' => 'サーバー設定にエラーがあるためemailを送信できませんでした。',	// TODO - Translation
				'email_sent' => 'emailはあなたのメールボックスに送信されました',	// TODO - Translation
				'error' => 'Emailアドレスの確認は失敗しました。',	// TODO - Translation
				'ok' => 'この email アドレスは確認されました。',	// TODO - Translation
				'unneccessary' => 'この email アドレスは既に確認済みです。',	// TODO - Translation
				'wrong_token' => 'この email アドレスのトークンは誤っています。',	// TODO - Translation
			),
			'need_to' => '%s が使えるようになるには、emailアドレスの認証が必要です。',	// TODO - Translation
			'resend_email' => 'emailの再送',	// TODO - Translation
			'title' => 'Email アドレス確認',	// TODO - Translation
		),
	),
	'mailer' => array(
		'email_need_validation' => array(
			'body' => 'あなたは %s で登録されましたが、emailアドレスを確認する必要があります。このリンクに従ってください:',	// TODO - Translation
			'title' => 'あなたのアカウントを確認する必要があります',	// TODO - Translation
			'welcome' => 'ようこそ %s,',	// TODO - Translation
		),
	),
	'password' => array(
		'invalid' => 'このパスワードは無効です',	// TODO - Translation
	),
	'tos' => array(
		'feedback' => array(
			'invalid' => 'あなたが使うには利用規約に同意する必要があります。',	// TODO - Translation
		),
	),
	'username' => array(
		'invalid' => 'このユーザー名は無効です。',	// TODO - Translation
		'taken' => '%s は既に使われているユーザー名です。',	// TODO - Translation
	),
);
