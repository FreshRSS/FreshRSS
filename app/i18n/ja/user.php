<?php

return array(
	'email' => array(
		'feedback' => array(
			'invalid' => 'このEメールアドレスは無効です。',
			'required' => 'このEメールアドレスは必要です。',
		),
		'validation' => array(
			'change_email' => 'Eメールアドレスは <a href="%s">プロフィールページで変更できます</a>.',
			'email_sent_to' => 'あなたのメールボックス<strong>%s</strong>にメールを送りました。有効性を確認するためにメールを確かめてください。',
			'feedback' => array(
				'email_failed' => 'サーバー設定にエラーがあるためEメールを送信できませんでした。',
				'email_sent' => 'Eメールはあなたのメールボックスに送信されました',
				'error' => 'Eメールアドレスの確認は失敗しました。',
				'ok' => 'このEメールアドレスは確認されました。',
				'unneccessary' => 'このEメールアドレスは既に確認済みです。',
				'wrong_token' => 'このEメールアドレスのトークンは誤っています。',
			),
			'need_to' => '%s を使うためには、Eメールアドレスの認証が必要です。',
			'resend_email' => 'Eメールの再送',
			'title' => 'Eメールアドレス確認',
		),
	),
	'mailer' => array(
		'email_need_validation' => array(
			'body' => 'あなたは %s で登録されましたが、Eメールアドレスを確認する必要があります。このリンクに従ってください:',
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
