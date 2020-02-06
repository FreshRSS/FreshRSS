<?php

return array(
	'already_exists' => 'The user %s already exists.',	// TODO - Translation
	'email' => array(
		'feedback' => array(
			'invalid' => '电子邮箱地址无效',
			'required' => '必须填写邮箱地址',
		),
		'validation' => array(
			'change_email' => '您可以在 <a href="%s">用户管理</a> 中变更您的邮箱地址',
			'email_sent_to' => '我们已通过 <strong>%s</strong> 发送验证邮件给您，请按其中指示来验证邮箱地址。',
			'feedback' => array(
				'email_failed' => '由于服务器配置错误，我们无法向您发送邮箱。',
				'email_sent' => '邮件已发送到您的邮箱中',
				'error' => '邮箱地址无法通过验证',
				'ok' => '邮箱地址已成功通过验证',
				'unneccessary' => '该邮箱地址已被验证',
				'wrong_token' => '由于令牌错误，邮箱地址无法通过验证。',
			),
			'need_to' => '您需要先验证邮箱地址才能使用 %s',
			'resend_email' => '重发邮件',
			'title' => '验证邮箱地址',
		),
	),
	'mailer' => array(
		'email_need_validation' => array(
			'body' => '您刚刚在 ％s 中注册，但仍然需要验证邮箱地址。为此，只需点击链接：',
			'title' => '您需要验证您的帐户',
			'welcome' => '欢迎来到 %s,',
		),
	),
	'password' => array(
		'invalid' => 'The password is invalid.',	// TODO - Translation
	),
	'tos' => array(
		'feedback' => array(
			'invalid' => '您必须接受服务条款才能注册',
		),
	),
);
