<?php

return array(
	'action' => array(
		'finish' => '설치 완료',
		'fix_errors_before' => '다음 단계로 가기 전에 문제를 해결하세요.',
		'keep_install' => '이전 설정 유지',
		'next_step' => '다음 단계',
		'reinstall' => 'FreshRSS 다시 설치',
	),
	'auth' => array(
		'form' => '웹폼 (전통적인 방식, 자바스크립트 필요)',
		'http' => 'HTTP (HTTPS를 사용하는 고급 사용자용)',
		'none' => '사용하지 않음 (위험)',
		'password_form' => '암호<br /><small>(웹폼 로그인 방식 사용시)</small>',
		'password_format' => '7 글자 이상이어야 합니다',
		'type' => '인증 방식',
	),
	'bdd' => array(
		'_' => '데이터베이스',
		'conf' => array(
			'_' => '데이터베이스 설정',
			'ko' => '데이터베이스 정보를 확인하세요.',
			'ok' => '데이터베이스 설정이 저장되었습니다.',
		),
		'host' => '데이터베이스 서버',
		'password' => '데이터베이스 암호',
		'prefix' => '테이블 접두어',
		'type' => '데이터베이스 종류',
		'username' => '데이터베이스 사용자 이름',
	),
	'check' => array(
		'_' => '설치 요구사항 확인',
		'already_installed' => 'FreshRSS가 이미 설치되어 있는 것을 감지했습니다!',
		'cache' => array(
			'nok' => '<em>%s</em> 디렉토리의 권한을 확인하세요. HTTP 서버가 쓰기 권한을 가지고 있어야 합니다',
			'ok' => 'cache 디렉토리의 권한이 올바르게 설정되었습니다.',
		),
		'ctype' => array(
			'nok' => '문자열 타입 검사에 필요한 라이브러리를 찾을 수 없습니다 (php-ctype).',
			'ok' => '문자열 타입 검사에 필요한 라이브러리가 설치되어 있습니다 (ctype).',
		),
		'curl' => array(
			'nok' => 'cURL 라이브러리를 찾을 수 없습니다 (php-curl 패키지).',
			'ok' => 'cURL 라이브러리가 설치되어 있습니다.',
		),
		'data' => array(
			'nok' => '<em>%s</em> 디렉토리의 권한을 확인하세요. HTTP 서버가 쓰기 권한을 가지고 있어야 합니다',
			'ok' => 'data 디렉토리의 권한이 올바르게 설정되었습니다.',
		),
		'dom' => array(
			'nok' => 'DOM을 다룰 수 있는 라이브러리를 찾을 수 없습니다 (php-xml 패키지).',
			'ok' => 'DOM을 다룰 수 있는 라이브러리가 설치되어 있습니다.',
		),
		'favicons' => array(
			'nok' => '<em>%s</em> 디렉토리의 권한을 확인하세요. HTTP 서버가 쓰기 권한을 가지고 있어야 합니다',
			'ok' => 'favicons 디렉토리의 권한이 올바르게 설정되어 있습니다.',
		),
		'fileinfo' => array(
			'nok' => 'fileinfo 라이브러리를 찾을 수 없습니다 (fileinfo 패키지).',
			'ok' => 'fileinfo 라이브러리가 설치되어 있습니다.',
		),
		'json' => array(
			'nok' => 'JSON 확장 기능을 찾을 수 없습니다 (php-json 패키지).',
			'ok' => 'JSON 확장 기능이 설치되어 있습니다.',
		),
		'mbstring' => array(
			'nok' => '유니코드 지원을 위한 mbstring 라이브러리를 찾을 수 없습니다.',
			'ok' => '유니코드 지원을 위한 mbstring 라이브러리가 설치되어 있습니다.',
		),
		'pcre' => array(
			'nok' => '정규표현식을 위한 라이브러리를 찾을 수 없습니다 (php-pcre).',
			'ok' => '정규표현식을 위한 라이브러리가 설치되어 있습니다 (PCRE).',
		),
		'pdo' => array(
			'nok' => '지원가능한 드라이버나 PDO를 찾을 수 없습니다 (pdo_mysql, pdo_sqlite, pdo_pgsql).',
			'ok' => '최소 하나의 지원가능한 드라이버와 PDO가 설치되어 있습니다 (pdo_mysql, pdo_sqlite, pdo_pgsql).',
		),
		'php' => array(
			'nok' => 'PHP 버전은 %s 이지만, FreshRSS에는 최소 %s의 버전이 필요합니다.',
			'ok' => 'PHP 버전은 %s 이고, FreshRSS와 호환가능 합니다.',
		),
		'tmp' => array(
			'nok' => '<em>%s</em> 디렉토리의 권한을 확인하세요. HTTP 서버가 쓰기 권한을 가지고 있어야 합니다.',
			'ok' => 'Permissions on the temp directory are good.',	// TODO - Translation
		),
		'unknown_process_username' => 'unknown',	// TODO - Translation
		'users' => array(
			'nok' => '<em>%s</em> 디렉토리의 권한을 확인하세요. HTTP 서버가 쓰기 권한을 가지고 있어야 합니다.',
			'ok' => 'users 디렉토리의 권한이 올바르게 설정되어 있습니다.',
		),
		'xml' => array(
			'nok' => 'XML 해석을 위한 라이브러리르 찾을 수 없습니다.',
			'ok' => 'XML 해석을 위한 라이브러리가 설치되어 있습니다.',
		),
	),
	'conf' => array(
		'_' => '일반 설정',
		'ok' => '일반 설정이 저장되었습니다.',
	),
	'congratulations' => '축하합니다!',
	'default_user' => '기본 사용자 이름<small>(알파벳과 숫자를 포함할 수 있고 최대 16 글자)</small>',
	'delete_articles_after' => '다음 기간보다 오래된 글 삭제',
	'fix_errors_before' => '다음 단계로 가기 전에 문제를 해결하세요.',
	'javascript_is_better' => 'FreshRSS는 자바스크립트를 사용할 때 더욱 쾌적하고 강력합니다',
	'js' => array(
		'confirm_reinstall' => 'FreshRSS을 다시 설치하면 이전 설정이 사라집니다. 계속하시겠습니까?',
	),
	'language' => array(
		'_' => '언어',
		'choose' => 'FreshRSS에서 사용할 언어를 고르세요',
		'defined' => '언어가 설정되었습니다.',
	),
	'not_deleted' => '무언가 잘못되었습니다; <em>%s</em> 파일을 직접 삭제해주세요.',
	'ok' => '설치 과정이 성공적으로 끝났습니다.',
	'session' => array(
		'nok' => 'The web server seems to be incorrectly configured for cookies required for PHP sessions!',	// TODO - Translation
	),
	'step' => '단계 %d',
	'steps' => '단계',
	'this_is_the_end' => '마침',
	'title' => '설치 · FreshRSS',
);
