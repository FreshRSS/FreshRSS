<?php

/******************************************************************************/
/* Each entry of that file can be associated with a comment to indicate its   */
/* state. When there is no comment, it means the entry is fully translated.   */
/* The recognized comments are (comment matching is case-insensitive):        */
/*   + TODO: the entry has never been translated.                             */
/*   + DIRTY: the entry has been translated but needs to be updated.          */
/*   + IGNORE: the entry does not need to be translated.                      */
/* When a comment is not recognized, it is discarded.                         */
/******************************************************************************/

return array(
	'action' => array(
		'actualize' => '새 글 가져오기',
		'add' => '추가',
		'back_to_rss_feeds' => '← RSS 피드로 돌아가기',
		'cancel' => '취소',
		'close' => 'Close',	// TODO
		'create' => '생성',
		'delete_all_feeds' => 'Delete all feeds',	// TODO
		'delete_errored_feeds' => 'Delete feeds with errors',	// TODO
		'delete_muted_feeds' => '음소거된 피드 삭제',
		'demote' => '목록 수준 내리기',
		'disable' => '비활성화',
		'download' => 'Download',	// TODO
		'empty' => '비우기',
		'enable' => '활성화',
		'export' => '내보내기',
		'filter' => '해당하는 글 보기',
		'import' => '불러오기',
		'load_default_shortcuts' => '기본 단축키 불러오기',
		'manage' => '관리',
		'mark_read' => '읽음으로 표시',
		'menu' => array(
			'open' => 'Open menu',	// TODO
		),
		'nav_buttons' => array(
			'next' => 'Next article',	// TODO
			'prev' => 'Previous article',	// TODO
			'up' => 'Go up',	// TODO
		),
		'open_url' => 'URL 열기',
		'promote' => '목록 수준 올리기',
		'purge' => '제거',
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
			'header' => 'Reauthentication is required',	// TODO
			'tip' => 'You won’t be asked to sign in again for <u>%d minutes</u>',	// TODO
			'title' => 'Reauthentication',	// TODO
		),
		'registration' => array(
			'_' => '새 계정',
			'ask' => '새 계정을 만들까요?',
			'title' => '계정 생성',
		),
		'username' => array(
			'_' => '사용자 이름',
			'format' => '<small>알파벳과 숫자를 포함할 수 있고 최대 16 글자</small>',
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
	'flag' => '🇰🇷',
	'freshrss' => array(
		'_' => 'FreshRSS',	// IGNORE
		'about' => '정보',
	),
	'js' => array(
		'category_empty' => '빈 카테고리',
		'confirm_action' => '정말 이 작업을 수행하시겠습니까? 이 작업은 되돌릴 수 없습니다!',
		'confirm_action_feed_cat' => '정말 이 작업을 수행하시겠습니까? 관련된 즐겨찾기와 사용자 쿼리가 삭제됩니다. 이 작업은 되돌릴 수 없습니다!!',
		'confirm_exit_slider' => 'Are you sure you want to discard unsaved settings?',	// TODO
		'feedback' => array(
			'body_new_articles' => '%%d 개의 새 글이 FreshRSS에 있습니다.',
			'body_unread_articles' => '(%%d 개 읽지 않음)',
			'request_failed' => '요청한 작업을 수행할 수 없습니다. 인터넷 연결에 문제가 발생한 것 같습니다.',
			'title_new_articles' => 'FreshRSS: 새 글이 있습니다!',
		),
		'labels_empty' => '라벨 없음',
		'new_article' => '새 글이 있습니다. 여기를 클릭하면 페이지를 다시 불러옵니다.',
		'should_be_activated' => '자바스크립트를 사용하도록 설정해야합니다',
		'unsafe_csp_header' => 'The CSP header in use is unsafe and FreshRSS may be vulnerable to XSS attacks. <a target="_blank" href="https://freshrss.github.io/FreshRSS/en/admins/10_ServerConfig.html#security">See documentation</a>',	// TODO
	),
	'lang' => array(
		'cs' => 'Čeština',	// IGNORE
		'de' => 'Deutsch',	// IGNORE
		'el' => 'Ελληνικά',	// IGNORE
		'en' => 'English',	// IGNORE
		'en-us' => 'English (United States)',	// IGNORE
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
		'lv' => 'Latviešu',	// IGNORE
		'nl' => 'Nederlands',	// IGNORE
		'oc' => 'Occitan',	// IGNORE
		'pl' => 'Polski',	// IGNORE
		'pt-br' => 'Português (Brasil)',	// IGNORE
		'pt-pt' => 'Português (Portugal)',	// IGNORE
		'ru' => 'Русский',	// IGNORE
		'sk' => 'Slovenčina',	// IGNORE
		'tr' => 'Türkçe',	// IGNORE
		'zh-cn' => '简体中文',	// IGNORE
		'zh-tw' => '正體中文',	// IGNORE
	),
	'menu' => array(
		'about' => '정보',
		'account' => '계정',
		'admin' => '관리',
		'archiving' => '보관',
		'authentication' => '인증',
		'check_install' => '설치 요구사항 확인',
		'configuration' => '설정',
		'display' => '표시',
		'extensions' => '확장 기능',
		'logs' => '로그',
		'privacy' => 'Privacy',	// TODO
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
		'linkding' => 'Linkding',	// IGNORE
		'linkedin' => 'LinkedIn',	// IGNORE
		'mastodon' => 'Mastodon',	// IGNORE
		'movim' => 'Movim',	// IGNORE
		'omnivore' => 'Omnivore',	// IGNORE
		'pinboard' => 'Pinboard',	// IGNORE
		'pinterest' => 'Pinterest',	// IGNORE
		'pocket' => 'Pocket',	// IGNORE
		'print' => '인쇄',
		'raindrop' => 'Raindrop.io',	// IGNORE
		'reddit' => 'Reddit',	// IGNORE
		'shaarli' => 'Shaarli',	// IGNORE
		'telegram' => 'Telegram',	// IGNORE
		'twitter' => 'Twitter',	// IGNORE
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
