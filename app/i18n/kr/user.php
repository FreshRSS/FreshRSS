<?php

return array(
	'email' => array(
		'feedback' => array(
			'invalid' => '이 이메일 주소는 유효하지 않습니다.',
			'required' => '이메일 주소가 필요합니다.',
		),
		'validation' => array(
			'change_email' => '<a href="%s">프로필 페이지</a>에서 이메일 주소를 변경 할 수 있습니다.',
			'email_sent_to' => '<strong>%s</strong>에 이메일을 보냈습니다. 이메일 주소를 인증하려면 전송 된 지침을 따라 주세요.',
			'feedback' => array(
				'email_failed' => '서버 설정 오류로 이메일을 전송하지 못했습니다.',
				'email_sent' => '귀하의 메일로 이메일이 전송되었습니다.',
				'error' => '이메일 주소 인증 실패.',
				'ok' => '이메일 주소가 인증되었습니다.',
				'unnecessary' => '이 이메일 주소는 이미 인증 되었습니다.',
				'wrong_token' => '이 이메일 주소는 잘못된 토큰으로 인해 인증에 실패했습니다.',
			),
			'need_to' => '%s 을(를) 사용하기 위해 이메일 주소를 인증 해야합니다',
			'resend_email' => '이메일 재발송',
			'title' => '이메일 주소 인증',
		),
	),
	'mailer' => array(
		'email_need_validation' => array(
			'body' => '%s 에 가입되었습니다, 하지만 메일 주소 확인이 필요합니다. 다음 링크를 클릭하여 가입을 완료하세요:',
			'title' => '계정을 인증 해야합니다',
			'welcome' => '%s 에 오신 것을 환영합니다,',
		),
	),
	'password' => array(
		'invalid' => '이 비밀번호는 유효하지 않습니다.',
	),
	'tos' => array(
		'feedback' => array(
			'invalid' => '가입하려면 서비스 약관에 동의해야합니다.',
		),
	),
	'username' => array(
		'invalid' => '이 사용자 이름은 유효하지 않습니다.',
		'taken' => '%s 은(는) 이미 시용되고 있는 사용자 이름입니다',
	),
);
