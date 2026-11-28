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
	'action' => array(
		'actualize' => '새 글 가져오기',
		'add' => '추가',
		'back_to_rss_feeds' => '← RSS 피드로 돌아가기',
		'cancel' => '취소',
		'close' => '닫기',
		'create' => '생성',
		'delete_all_feeds' => '모든 피드 삭제',
		'delete_errored_feeds' => '오류가 있는 피드 삭제',
		'delete_muted_feeds' => '음소거된 피드 삭제',
		'demote' => '목록 수준 내리기',
		'disable' => '비활성화',
		'download' => '다운로드',
		'empty' => '비우기',
		'enable' => '활성화',
		'export' => '내보내기',
		'filter' => '해당하는 글 보기',
		'import' => '불러오기',
		'load_default_shortcuts' => '기본 단축키 불러오기',
		'manage' => '관리',
		'mark_read' => '읽음으로 표시',
		'menu' => array(
			'open' => '메뉴 열기',
		),
		'nav_buttons' => array(
			'next' => '다음 글',
			'prev' => '이전 글',
			'up' => '위로',
		),
		'open_url' => 'URL 열기',
		'promote' => '목록 수준 올리기',
		'purge' => '제거',
		'read_in_freshrss' => 'FreshRSS에서 읽기',
		'refresh_opml' => 'OPML 새로고침',
		'remove' => '삭제',
		'rename' => '이름 바꾸기',
		'see_website' => '웹사이트 열기',
		'submit' => '설정 저장',
		'truncate' => '모든 글 삭제',
		'update' => '변경',
	),
	'auth' => array(
		'accept_tos' => '<a href="%s">서비스 약관</a>에 동의합니다.',
		'email' => '메일 주소',
		'keep_logged_in' => '로그인 유지 <small>(%s 일)</small>',
		'login' => '로그인',
		'logout' => '로그아웃',
		'password' => array(
			'_' => '암호',
			'format' => '<small>7 글자 이상이어야 합니다</small>',
		),
		'reauth' => array(
			'header' => '다시 인증해야 합니다',
			'tip' => '<u>%d분</u> 동안은 다시 로그인하라는 요청을 받지 않습니다',
			'title' => '재인증',
		),
		'registration' => array(
			'_' => '새 계정',
			'ask' => '새 계정을 만들까요?',
			'title' => '계정 생성',
		),
		'username' => array(
			'_' => '사용자 이름',
			'format' => '<small>1~39자: 영문자, 숫자, <code>. _ @ -</code></small>',
		),
	),
	'date' => array(
		'Apr' => '\\4\\월',	// IGNORE
		'Aug' => '\\8\\월',	// IGNORE
		'Dec' => '\\1\\2\\월',	// IGNORE
		'Feb' => '\\2\\월',	// IGNORE
		'Jan' => '\\1\\월',	// IGNORE
		'Jul' => '\\7\\월',	// IGNORE
		'Jun' => '\\6\\월',	// IGNORE
		'Mar' => '\\3\\월',	// IGNORE
		'May' => '\\5\\월',	// IGNORE
		'Nov' => '\\1\\1\\월',	// IGNORE
		'Oct' => '\\1\\0\\월',	// IGNORE
		'Sep' => '\\9\\월',	// IGNORE
		'apr' => '4월',
		'april' => '4월',
		'aug' => '8월',
		'august' => '8월',
		'before_yesterday' => '그저께',
		'dec' => '12월',
		'december' => '12월',
		'feb' => '2월',
		'february' => '2월',
		'format_date' => 'Y\\년 n\\월 j\\일',
		'format_date_hour' => 'Y\\년 n\\월 j\\일 H\\:i',
		'fri' => '금',
		'jan' => '1월',
		'january' => '1월',
		'jul' => '7월',
		'july' => '7월',
		'jun' => '6월',
		'june' => '6월',
		'last_2_year' => '최근 2년',
		'last_3_month' => '최근 3개월',
		'last_3_year' => '최근 3년',
		'last_5_year' => '최근 5년',
		'last_6_month' => '최근 6개월',
		'last_month' => '최근 한 달',
		'last_week' => '최근 한 주',
		'last_year' => '최근 일 년',
		'mar' => '3월',
		'march' => '3월',
		'may' => '5월',
		'may_' => '5월',
		'mon' => '월',
		'month' => '개월',
		'nov' => '11월',
		'november' => '11월',
		'oct' => '10월',
		'october' => '10월',
		'sat' => '토',
		'sep' => '9월',
		'september' => '9월',
		'sun' => '일',
		'thu' => '목',
		'today' => '오늘',
		'tue' => '화',
		'wed' => '수',
		'yesterday' => '어제',
	),
	'dir' => 'ltr',	// IGNORE
	'freshrss' => array(
		'_' => 'FreshRSS',	// IGNORE
		'about' => '정보',
	),
	'interval' => array(
		'day' => array(
			0 => '%d일 전',
		),
		'hour' => array(
			0 => '%d시간 전',
		),
		'justnow' => '방금 전',
		'minute' => array(
			0 => '%d분 전',
		),
		'month' => array(
			0 => '%d개월 전',
		),
		'second' => array(
			0 => '%d초 전',
		),
		'year' => array(
			0 => '%d년 전',
		),
	),
	'js' => array(
		'category_empty' => '빈 카테고리',
		'confirm_action' => '정말 이 작업을 수행하시겠습니까? 이 작업은 되돌릴 수 없습니다!',
		'confirm_action_feed_cat' => '정말 이 작업을 수행하시겠습니까? 관련된 즐겨찾기와 사용자 쿼리가 삭제됩니다. 이 작업은 되돌릴 수 없습니다!!',
		'confirm_exit_slider' => '저장하지 않은 설정을 버릴까요?',
		'feedback' => array(
			'body_new_articles' => array(
				0 => 'FreshRSS에 읽을 새 글이 %d개 있습니다.',
			),
			'body_unread_articles' => array(
				0 => '(읽지 않음: %d)',
			),
			'request_failed' => '요청한 작업을 수행할 수 없습니다. 인터넷 연결에 문제가 발생한 것 같습니다.',
			'title_new_articles' => 'FreshRSS: 새 글이 있습니다!',
		),
		'labels_empty' => '라벨 없음',
		'new_article' => '새 글이 있습니다. 여기를 클릭하면 페이지를 다시 불러옵니다.',
		'should_be_activated' => '자바스크립트를 사용하도록 설정해야합니다',
		'unsafe_csp_header' => '사용 중인 CSP 헤더가 안전하지 않아 FreshRSS가 XSS 공격에 취약할 수 있습니다. <a target="_blank" href="https://freshrss.github.io/FreshRSS/en/admins/10_ServerConfig.html#security">문서 보기</a>',
	),
	'lang' => array(
		'ar' => 'العربية',	// IGNORE
		'az' => 'Azərbaycanca',	// IGNORE
		'be' => 'Беларуская',	// IGNORE
		'cs' => 'Čeština',	// IGNORE
		'de' => 'Deutsch',	// IGNORE
		'el' => 'Ελληνικά',	// IGNORE
		'en' => 'English',	// IGNORE
		'en-US' => 'English (United States)',	// IGNORE
		'es' => 'Español',	// IGNORE
		'fa' => 'فارسی',	// IGNORE
		'fi' => 'Suomi',	// IGNORE
		'fr' => 'Français',	// IGNORE
		'he' => 'עברית',	// IGNORE
		'hu' => 'Magyar',	// IGNORE
		'id' => 'Bahasa Indonesia',	// IGNORE
		'it' => 'Italiano',	// IGNORE
		'ja' => '日本語',	// IGNORE
		'ko' => '한국어',	// IGNORE
		'lt' => 'Lietuvių',	// IGNORE
		'lv' => 'Latviešu',	// IGNORE
		'nl' => 'Nederlands',	// IGNORE
		'oc' => 'Occitan',	// IGNORE
		'pl' => 'Polski',	// IGNORE
		'pt-BR' => 'Português (Brasil)',	// IGNORE
		'pt-PT' => 'Português (Portugal)',	// IGNORE
		'ru' => 'Русский',	// IGNORE
		'sk' => 'Slovenčina',	// IGNORE
		'tr' => 'Türkçe',	// IGNORE
		'uk' => 'Українська',	// IGNORE
		'zh-CN' => '简体中文',	// IGNORE
		'zh-TW' => '正體中文',	// IGNORE
	),
	'menu' => array(
		'about' => '정보',
		'account' => '계정',
		'admin' => '관리',
		'advanced_search' => '고급 검색',
		'archiving' => '보관',
		'authentication' => '인증',
		'check_install' => '설치 요구사항 확인',
		'configuration' => '설정',
		'display' => '표시',
		'extensions' => '확장 기능',
		'logs' => '로그',
		'privacy' => '개인정보 보호',
		'queries' => '사용자 쿼리',
		'reading' => '읽기',
		'search' => '단어 또는 #태그 검색',
		'search_help' => '문서에서 고급 <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">검색 인자</a> 알아보기',
		'sharing' => '공유',
		'shortcuts' => '단축키',
		'stats' => '통계',
		'system' => '시스템 설정',
		'update' => '업데이트',
		'user_management' => '사용자 관리',
		'user_profile' => '프로필',
	),
	'period' => array(
		'days' => '일',
		'hours' => '시',
		'months' => '월',
		'weeks' => '주',
		'years' => '년',
	),
	'readme' => array(
		'contribute' => 'contribute',	// IGNORE
		'language' => 'Language',	// IGNORE
		'translated' => 'Progress',	// IGNORE
	),
	'search' => array(
		'advanced_search_help' => '이 양식으로 검색 쿼리를 쉽게 만들 수 있지만, 직접 쓰는 쿼리가 더 강력합니다.',
		'authors' => '저자',
		'categories' => '카테고리',
		'content' => '내용',
		'date_from' => '시작',
		'date_modified' => '서버 수정 날짜',
		'date_past' => '지난 기간',
		'date_published' => '발행 날짜',
		'date_range' => '날짜 범위',
		'date_received' => '수신 날짜',
		'date_to' => '끝',
		'date_user' => '사용자 수정 날짜',
		'feeds' => '피드',
		'free_text' => '자유 텍스트',
		'free_text_help' => '제목과 내용 모두에서 검색',
		'full_documentation' => '<a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">전체 검색 문서</a> 보기',
		'labels' => '내 라벨',
		'multiple_help' => '하나 이상 선택하세요 (<kbd>Ctrl</kbd> 또는 <kbd>Cmd</kbd>를 누른 채로)',
		'sources' => '출처',
		'tags' => '글 태그',
		'text' => '텍스트 검색',
		'text_help' => '여러 줄은 논리 <i>or</i>로 결합됩니다. <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#regex" target="_blank">정규 표현식</a>도 지원합니다.',
		'text_placeholder' => '키워드',
		'title' => '제목',
		'url' => 'URL',	// IGNORE
		'user_queries' => '사용자 쿼리',
	),
	'share' => array(
		'Known' => 'Known based sites',	// IGNORE
		'archiveIS' => 'archive.is',	// IGNORE
		'archiveORG' => 'archive.org',	// IGNORE
		'archivePH' => 'archive.ph',	// IGNORE
		'bluesky' => 'Bluesky',	// IGNORE
		'buffer' => 'Buffer',	// IGNORE
		'clipboard' => '클립보드',
		'diaspora' => 'Diaspora*',	// IGNORE
		'email' => '메일',
		'email-webmail-firefox-fix' => '이메일 (웹메일 - Firefox 전용 수정)',
		'facebook' => 'Facebook',	// IGNORE
		'gnusocial' => 'GNU social',	// IGNORE
		'jdh' => 'Journal du hacker',	// IGNORE
		'lemmy' => 'Lemmy',	// IGNORE
		'linkace' => 'LinkAce',	// IGNORE
		'linkding' => 'Linkding',	// IGNORE
		'linkedin' => 'LinkedIn',	// IGNORE
		'mastodon' => 'Mastodon',	// IGNORE
		'movim' => 'Movim',	// IGNORE
		'nextcloud-bookmarks' => 'Nextcloud 북마크',
		'omnivore' => 'Omnivore',	// IGNORE
		'pinboard' => 'Pinboard',	// IGNORE
		'pinterest' => 'Pinterest',	// IGNORE
		'print' => '인쇄',
		'raindrop' => 'Raindrop.io',	// IGNORE
		'reddit' => 'Reddit',	// IGNORE
		'shaarli' => 'Shaarli',	// IGNORE
		'telegram' => 'Telegram',	// IGNORE
		'twitter' => 'X (Twitter)',	// IGNORE
		'wallabag' => 'wallabag v1',	// IGNORE
		'wallabagv2' => 'wallabag v2',	// IGNORE
		'web-sharing-api' => '기기 내장 공유 기능',
		'whatsapp' => 'Whatsapp',	// IGNORE
		'xing' => 'Xing',	// IGNORE
	),
	'short' => array(
		'attention' => '경고!',
		'blank_to_disable' => '빈 칸으로 두면 비활성화',
		'by_author' => '글쓴이:',
		'by_default' => '기본값',
		'damn' => '이런!',
		'default_category' => '분류 없음',
		'no' => '아니요',
		'not_applicable' => '사용할 수 없음',
		'ok' => '좋습니다!',
		'or' => '또는',
		'yes' => '네',
	),
	'stream' => array(
		'load_more' => '글 더 불러오기',
		'mark_all_read' => '모두 읽음으로 표시',
		'nothing_to_load' => '더 이상 글이 없습니다',
	),
);
