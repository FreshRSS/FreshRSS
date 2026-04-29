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
	'auth' => array(
		'allow_anonymous' => '누구나 기본 사용자의 글을 읽을 수 있도록 합니다(%s)',
		'allow_anonymous_refresh' => '누구나 피드를 갱신할 수 있도록 합니다',
		'api_enabled' => '<abbr>API</abbr> 사용을 허가합니다<small>(모바일 애플리케이션을 사용할 때 필요합니다	and sharing user queries)</small>',	// DIRTY
		'form' => '웹폼 (전통적인 방식, 자바스크립트 필요)',
		'http' => 'HTTP (advanced: managed by Web server, OIDC, SSO…)',	// TODO
		'none' => '사용하지 않음 (위험)',
		'title' => '인증',
		'token' => '마스터 인증 토큰',
		'token_help' => '인증 없이 사용자의 모든 RSS 내용과 피드 새로고침 권한을 허용합니다.:',
		'type' => '인증',
	),
	'extensions' => array(
		'author' => '제작자',
		'community' => '사용 가능한 커뮤니티 확장 기능들',
		'description' => '설명',
		'disabled' => '비활성화됨',
		'empty_list' => '설치된 확장 기능이 없습니다',
		'empty_list_help' => 'Check the logs to determine the reason behind the empty extension list.',	// TODO
		'enabled' => '활성화됨',
		'is_compatible' => 'Is compatible',	// TODO
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
		'date_published' => 'Publication date',	// TODO
		'date_received' => 'Received date',	// TODO
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
		'nb_unreads' => 'Number of unread articles',	// TODO
		'no_idle' => '유휴 피드가 없습니다!',
		'number_entries' => '%d 개의 글',
		'overview' => 'Overview',	// TODO
		'percent_of_total' => '전체에서의 비율 (%)',
		'repartition' => '글 분류: %s',	// DIRTY
		'status_favorites' => '즐겨찾기',
		'status_read' => '읽음',
		'status_total' => '전체',
		'status_unread' => '읽지 않음',
		'title' => '통계',
		'top_feed' => '상위 10 개 피드',
		'unread_dates' => 'Dates with most unread articles',	// TODO
	),
	'system' => array(
		'_' => '시스템 설정',
		'auto-update-url' => '자동 업데이트 서버 URL',
		'base-url' => array(
			'_' => 'Base URL',	// IGNORE
			'recommendation' => '자동 추천: <kbd>%s</kbd>',
		),
		'closed_registration_message' => 'Message if registrations are closed',	// TODO
		'cookie-duration' => array(
			'help' => '초',
			'number' => '로그인 유지 시간',
		),
		'default_closed_registration_message' => 'This server does not accept new registrations at the moment.',	// TODO
		'force_email_validation' => '이메일 주소 확인 강제화',
		'instance-name' => '인스턴스 이름',
		'max-categories' => '사용자별 카테고리 개수 제한',
		'max-feeds' => '사용자별 피드 개수 제한',
		'registration' => array(
			'number' => '계정 최대 개수',
			'select' => array(
				'label' => '회원가입 양식',
				'option' => array(
					'noform' => '비활성화: 회원가입 양식 없음',
					'nolimit' => '활성화: 계정 개수 제한 없음',
					'setaccountsnumber' => '최대 계정 개수 설정',
				),
			),
			'status' => array(
				'disabled' => '양식 비활성화됨',
				'enabled' => '양식 활성화됨',
			),
			'title' => '사용자 회원가입 양식',
		),
		'sensitive-parameter' => 'Sensitive parameter. <kbd>./data/config.php</kbd>에서 직접 수정',	// DIRTY
		'tos' => array(
			'disabled' => '주어지지 않음',
			'enabled' => '<a href="./?a=tos">활성화됨</a>',
			'help' => '<a href="https://freshrss.github.io/FreshRSS/en/admins/12_User_management.html#enable-terms-of-service-tos" target="_blank">이용 약관 활성화</a> 하는 방법',
		),
		'websub' => array(
			'help' => '<a href="https://freshrss.github.io/FreshRSS/en/users/WebSub.html" target="_blank">WebSub</a> 살펴보기',
		),
	),
	'update' => array(
		'_' => '업데이트',
		'apply' => '업데이트 적용하기',
		'changelog' => '변경사항',
		'check' => '새 업데이트 확인하기',
		'copiedFromURL' => 'update.php가 %s 에서 ./data 으로 복사됨',
		'current_version' => '현버전은 입니다',
		'last' => '마지막 확인',
		'loading' => '업데이트 중…',
		'none' => '적용 가능한 업데이트가 없습니다',
		'releaseChannel' => array(
			'_' => '릴리즈 채널',
			'edge' => '롤링 릴리즈 (“edge”)',
			'latest' => '안정 릴리즈 (“latest”)',
		),
		'title' => '업데이트',
		'viaGit' => 'Git 및 GitHub.com을 통한 업데이트 시작 됨',
	),
	'user' => array(
		'admin' => '관리자',
		'article_count' => '글 개수',
		'back_to_manage' => '← 사용자 목록으로 돌아가기',
		'create' => '새 사용자 생성',
		'database_size' => '데이터 베이스 크기',
		'email' => '이메일 주소',
		'enabled' => '사용 가능',
		'feed_count' => '피드',
		'is_admin' => '관리자 유무',
		'language' => '언어',
		'last_user_activity' => '마지막 사용자 활동',
		'list' => '사용자 목록',
		'number' => '%d 개의 계정이 생성되었습니다',
		'numbers' => '%d 개의 계정이 생성되었습니다',
		'password_form' => '암호<br /><small>(웹폼 로그인 방식 사용시)</small>',
		'password_format' => '7 글자 이상이어야 합니다',
		'title' => '사용자 관리',
		'username' => '사용자 이름',
	),
);
