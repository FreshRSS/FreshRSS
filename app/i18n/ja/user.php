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
			'invalid' => 'このメールアドレスは無効です。',
			'required' => 'メールアドレスが必要です。',
		),
		'validation' => array(
			'change_email' => 'メールアドレスは <a href="%s">プロフィールページ</a>で変更できます。',
			'email_sent_to' => '<strong>%s</strong>宛てにメールを送信しました。メールの案内に従ってアドレスを確認してください。',
			'feedback' => array(
				'email_failed' => 'サーバー設定にエラーがあるため、メールを送信できませんでした。',
				'email_sent' => '確認メールを送信しました。',
				'error' => 'メールアドレスの確認に失敗しました。',
				'ok' => 'メールアドレスを確認しました。',
				'unnecessary' => 'このメールアドレスは既に確認済みです。',
				'wrong_token' => 'トークンが正しくないため、メールアドレスを確認できませんでした。',
			),
			'need_to' => '%sを利用するにはメールアドレスの確認が必要です。',
			'resend_email' => 'メールを再送信',
			'title' => 'メールアドレス確認',
		),
	),
	'mailer' => array(
		'email_need_validation' => array(
			'body' => '%sへの登録を完了するには、メールアドレスの確認が必要です。次のリンクを開いてください：',
			'title' => 'アカウント確認',
			'welcome' => 'ようこそ %s さん',
		),
	),
	'password' => array(
		'invalid' => 'このパスワードは無効です。',
	),
	'tos' => array(
		'feedback' => array(
			'invalid' => '登録するには利用規約への同意が必要です。',
		),
	),
	'username' => array(
		'invalid' => 'このユーザー名は無効です。',
		'taken' => '%sは既に使われているユーザー名です。',
	),
);
