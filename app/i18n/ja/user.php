<?php

return array(
	'email' => array(
		'feedback' => array(
			'invalid' => 'このemailアドレスは無効です。',
			'required' => 'このemailアドレスは必要です。',
		),
		'validation' => array(
			'change_email' => 'emailアドレスは <a href="%s">プロフィールページで変更できます</a>.',
			'email_sent_to' => 'あなたのメールボックス<strong>%s</strong>にメールを送りました。有効性を確認するためにメールを確かめてください。',
			'feedback' => array(
				'email_failed' => 'サーバー設定にエラーがあるためemailを送信できませんでした。',
				'email_sent' => 'emailはあなたのメールボックスに送信されました',
				'error' => 'Emailアドレスの確認は失敗しました。',
				'ok' => 'この email アドレスは確認されました。',
				'unneccessary' => 'この email アドレスは既に確認済みです。',
				'wrong_token' => 'この email アドレスのトークンは誤っています。',
			),
			'need_to' => '%s が使えるようになるには、emailアドレスの認証が必要です。',
			'resend_email' => 'emailの再送',
			'title' => 'Email アドレス確認',
		),
	),
	'mailer' => array(
		'email_need_validation' => array(
			'body' => 'あなたは %s で登録されましたが、emailアドレスを確認する必要があります。このリンクに従ってください:',
			'title' => 'あなたのアカウントを確認する必要があります',
			'welcome' => 'ようこそ %s,',
		),
	),
	'password' => array(
		'invalid' => 'このパスワードは無効です',
	),
	'tos' => array(
		'feedback' => array(
			'invalid' => 'あなたが使うには利用規約に同意する必要があります。',
		),
	),
	'username' => array(
		'invalid' => 'このユーザー名は無効です。',
		'taken' => '%s は既に使われているユーザー名です。',
	),
);
