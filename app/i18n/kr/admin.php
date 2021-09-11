<?php

return array(
	'auth' => array(
		'allow_anonymous' => '누구나 기본 사용자의 글을 읽을 수 있도록 합니다(%s)',
		'allow_anonymous_refresh' => '누구나 피드를 갱신할 수 있도록 합니다',
		'api_enabled' => '<abbr>API</abbr> 사용을 허가합니다<small>(모바일 애플리케이션을 사용할 때 필요합니다)</small>',
		'form' => '웹폼 (전통적인 방식, 자바스크립트 필요)',
		'http' => 'HTTP (HTTPS를 사용하는 고급 사용자용)',
		'none' => '사용하지 않음 (위험)',
		'title' => '인증',
		'title_reset' => '인증 초기화',
		'token' => '인증 토큰',
		'token_help' => '기본 사용자의 RSS에 인증 없이 접근할 수 있도록 합니다:',
		'type' => '인증',
		'unsafe_autologin' => '다음과 같은 안전하지 않은 방식의 로그인을 허가합니다: ',
	),
	'check_install' => array(
		'cache' => array(
			'nok' => '<em>./data/cache</em> 디렉토리의 권한을 확인하세요. HTTP 서버가 쓰기 권한을 가지고 있어야 합니다',
			'ok' => 'cache 디렉토리의 권한이 올바르게 설정되었습니다.',
		),
		'categories' => array(
			'nok' => 'category 테이블 설정이 잘못되었습니다.',
			'ok' => 'category 테이블이 올바르게 설정되었습니다.',
		),
		'connection' => array(
			'nok' => '데이터베이스에 연결할 수 없습니다.',
			'ok' => '데이터베이스와의 연결이 올바르게 설정되었습니다.',
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
			'nok' => '<em>./data</em> 디렉토리의 권한을 확인하세요. HTTP 서버가 쓰기 권한을 가지고 있어야 합니다',
			'ok' => 'data 디렉토리의 권한이 올바르게 설정되었습니다.',
		),
		'database' => '데이터베이스 설치 요구사항',
		'dom' => array(
			'nok' => 'DOM을 다룰 수 있는 라이브러리를 찾을 수 없습니다 (php-xml 패키지).',
			'ok' => 'DOM을 다룰 수 있는 라이브러리가 설치되어 있습니다.',
		),
		'entries' => array(
			'nok' => 'entry 테이블 설정이 잘못되었습니다.',
			'ok' => 'entry 테이블이 올바르게 설정되었습니다.',
		),
		'favicons' => array(
			'nok' => '<em>./data/favicons</em> 디렉토리의 권한을 확인하세요. HTTP 서버가 쓰기 권한을 가지고 있어야 합니다',
			'ok' => 'favicons 디렉토리의 권한이 올바르게 설정되어 있습니다.',
		),
		'feeds' => array(
			'nok' => 'feed 테이블 설정이 잘못되었습니다.',
			'ok' => 'feed 테이블이 올바르게 설정되었습니다',
		),
		'fileinfo' => array(
			'nok' => 'fileinfo 라이브러리를 찾을 수 없습니다 (fileinfo 패키지).',
			'ok' => 'fileinfo 라이브러리가 설치되어 있습니다.',
		),
		'files' => '파일 시스템 설치 요구사항',
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
			'_' => 'PHP 설치 요구사항',
			'nok' => 'PHP 버전은 %s 이지만, FreshRSS에는 최소 %s의 버전이 필요합니다.',
			'ok' => 'PHP 버전은 %s 이고, FreshRSS와 호환가능 합니다.',
		),
		'tables' => array(
			'nok' => '하나 이상의 테이블을 데이터베이스에서 찾을 수 없습니다.',
			'ok' => '데이터베이스에 모든 테이블이 존재합니다.',
		),
		'title' => '설치 요구사항 확인',
		'tokens' => array(
			'nok' => '<em>./data/tokens</em> 디렉토리의 권한을 확인하세요. HTTP 서버가 쓰기 권한을 가지고 있어야 합니다',
			'ok' => 'tokens 디렉토리의 권한이 올바르게 설정되어 있습니다',
		),
		'users' => array(
			'nok' => '<em>./data/users</em> 디렉토리의 권한을 확인하세요. HTTP 서버가 쓰기 권한을 가지고 있어야 합니다',
			'ok' => 'users 디렉토리의 권한이 올바르게 설정되어 있습니다.',
		),
		'zip' => array(
			'nok' => 'ZIP 확장 기능을 찾을 수 없습니다 (php-zip 패키지).',
			'ok' => 'ZIP 확장 기능이 설치되어 있습니다.',
		),
	),
	'extensions' => array(
		'author' => '제작자',
		'community' => '사용 가능한 커뮤니티 확장 기능들',
		'description' => '설명',
		'disabled' => '비활성화됨',
		'empty_list' => '설치된 확장 기능이 없습니다',
		'enabled' => '활성화됨',
		'latest' => '설치됨',
		'name' => '이름',
		'no_configure_view' => '이 확장 기능은 설정이 없습니다.',
		'system' => array(
			'_' => '시스템 확장 기능',
			'no_rights' => '시스템 확장 기능 (이 확장 기능에 대한 권한이 없습니다)',
		),
		'title' => '확장 기능',
		'update' => '업데이트 있음',
		'user' => '사용자 확장 기능',
		'version' => '버전',
	),
	'stats' => array(
		'_' => '통계',
		'all_feeds' => '모든 피드',
		'category' => '카테고리',
		'entry_count' => '글 개수',
		'entry_per_category' => '카테고리별 글 개수',
		'entry_per_day' => '일일 글 개수 (최근 30 일)',
		'entry_per_day_of_week' => '요일별 (평균: %.2f 개의 글)',
		'entry_per_hour' => '시간별 (평균: %.2f 개의 글)',
		'entry_per_month' => '월별 (평균: %.2f 개의 글)',
		'entry_repartition' => '글 분류',
		'feed' => '피드',
		'feed_per_category' => '카테고리별 피드 개수',
		'idle' => '유휴 피드',
		'main' => '주요 통계',
		'main_stream' => '메인 스트림',
		'no_idle' => '유휴 피드가 없습니다!',
		'number_entries' => '%d 개의 글',
		'percent_of_total' => '전체에서의 비율 (%%)',
		'repartition' => '글 분류',
		'status_favorites' => '즐겨찾기',
		'status_read' => '읽음',
		'status_total' => '전체',
		'status_unread' => '읽지 않음',
		'title' => '통계',
		'top_feed' => '상위 10 개 피드',
	),
	'system' => array(
		'_' => '시스템 설정',
		'auto-update-url' => '자동 업데이트 서버 URL',
		'cookie-duration' => array(
			'help' => '초',
			'number' => '로그인 유지 시간',
		),
		'force_email_validation' => 'Force email address validation',	// TODO - Translation
		'instance-name' => '인스턴스 이름',
		'max-categories' => '사용자별 카테고리 개수 제한',
		'max-feeds' => '사용자별 피드 개수 제한',
		'registration' => array(
			'help' => '0: 제한 없음',
			'number' => '계정 최대 개수',
		),
	),
	'update' => array(
		'_' => '업데이트',
		'apply' => '업데이트 적용하기',
		'check' => '새 업데이트 확인하기',
		'current_version' => '현재 FreshRSS 버전은 %s 입니다.',
		'last' => '마지막 확인: %s',
		'none' => '적용 가능한 업데이트가 없습니다',
		'title' => '업데이트',
	),
	'user' => array(
		'admin' => 'Administrator',	// TODO - Translation
		'article_count' => 'Articles',	// TODO - Translation
		'articles_and_size' => '%s 개의 글 (%s)',
		'back_to_manage' => '← Return to user list',	// TODO - Translation
		'create' => '새 사용자 생성',
		'database_size' => 'Database size',	// TODO - Translation
		'delete_users' => '사용자 삭제',
		'email' => 'Email address',	// TODO - Translation
		'enabled' => 'Enabled',	// TODO - Translation
		'feed_count' => 'Feeds',	// TODO - Translation
		'is_admin' => 'Is admin',	// TODO - Translation
		'language' => '언어',
		'last_user_activity' => 'Last user activity',	// TODO - Translation
		'list' => 'User list',	// TODO - Translation
		'number' => '%d 개의 계정이 생성되었습니다',
		'numbers' => '%d 개의 계정이 생성되었습니다',
		'password_form' => '암호<br /><small>(웹폼 로그인 방식 사용시)</small>',
		'password_format' => '7 글자 이상이어야 합니다',
		'selected' => '선택된 사용자',
		'title' => '사용자 관리',
		'update_users' => '사용자 정보 변경',
		'user_list' => '사용자 목록',
		'username' => '사용자 이름',
		'users' => '전체 사용자',
	),
);
