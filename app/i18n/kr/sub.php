<?php

return array(
	'add' => 'Feed and category creation has been moved <a href=\'%s\'>here</a>. It is also accessible from the menu on the left and from the ✚ icon available on the main page.',	// TODO - Translation
	'api' => array(
		'documentation' => '외부 도구에서 API를 사용하기 위해서 아래 URL을 사용하세요.',
		'title' => 'API',
	),
	'bookmarklet' => array(
		'documentation' => '이 버튼을 즐겨찾기 막대로 끌어다 놓거나 마우스 오른쪽 클릭으로 나타나는 메뉴에서 "이 링크를 즐겨찾기에 추가"를 선택하세요. 그리고 피드를 구독하길 원하는 페이지에서 "구독하기" 버튼을 클릭하세요.',
		'label' => '구독하기',
		'title' => '북마클릿',
	),
	'category' => array(
		'_' => '카테고리',
		'add' => '카테고리 추가',
		'archiving' => '보관',
		'empty' => '빈 카테고리',
		'information' => '정보',
		'position' => 'Display position',	// TODO - Translation
		'position_help' => 'To control category sort order',	// TODO - Translation
		'title' => '제목',
	),
	'feed' => array(
		'add' => 'RSS 피드 추가',
		'advanced' => '고급 설정',
		'archiving' => '보관',
		'auth' => array(
			'help' => 'HTTP 접속이 제한되는 RSS 피드에 접근합니다',
			'http' => 'HTTP 인증',
			'password' => 'HTTP 암호',
			'username' => 'HTTP 사용자 이름',
		),
		'clear_cache' => '항상 캐시 지우기',
		'content_action' => array(
			'_' => 'Content action when fetching the article content',	// TODO - Translation
			'append' => 'Add after existing content',	// TODO - Translation
			'prepend' => 'Add before existing content',	// TODO - Translation
			'replace' => 'Replace existing content',	// TODO - Translation
		),
		'css_cookie' => 'Use Cookies when fetching the article content',	// TODO - Translation
		'css_cookie_help' => 'Example: <kbd>foo=bar; gdpr_consent=true; cookie=value</kbd>',	// TODO - Translation
		'css_help' => '글의 일부가 포함된 RSS 피드를 가져옵니다 (주의, 시간이 좀 더 걸립니다!)',
		'css_path' => '웹사이트 상의 글 본문에 해당하는 CSS 경로',
		'description' => '설명',
		'empty' => '이 피드는 비어있습니다. 피드가 계속 운영되고 있는지 확인하세요.',
		'error' => '이 피드에 문제가 발생했습니다. 이 피드에 접근 권한이 있는지 확인하세요.',
		'filteractions' => array(
			'_' => 'Filter actions',	// TODO - Translation
			'help' => 'Write one search filter per line.',	// TODO - Translation
		),
		'information' => '정보',
		'keep_min' => '최소 유지 글 개수',
		'maintenance' => array(
			'clear_cache' => 'Clear cache',	// TODO - Translation
			'clear_cache_help' => 'Clear the cache for this feed.',	// TODO - Translation
			'reload_articles' => 'Reload articles',	// TODO - Translation
			'reload_articles_help' => 'Reload articles and fetch complete content if a selector is defined.',	// TODO - Translation
			'title' => 'Maintenance',	// TODO - Translation
		),
		'moved_category_deleted' => '카테고리를 삭제하면, 해당 카테고리 아래에 있던 피드들은 자동적으로 <em>%s</em> 아래로 분류됩니다.',
		'mute' => '무기한 새로고침 금지',
		'no_selected' => '선택된 피드가 없습니다.',
		'number_entries' => '%d 개의 글',
		'priority' => array(
			'_' => '표시',
			'archived' => '표시하지 않음 (보관됨)',
			'main_stream' => '메인 스트림에 표시하기',
			'normal' => '피드가 속한 카테고리에만 표시하기',
		),
		'proxy' => 'Set a proxy for fetching this feed',	// TODO - Translation
		'proxy_help' => 'Select a protocol (e.g: SOCKS5) and enter the proxy address (e.g: <kbd>127.0.0.1:1080</kbd>)',	// TODO - Translation
		'selector_preview' => array(
			'show_raw' => 'Show source code',	// TODO - Translation
			'show_rendered' => 'Show content',	// TODO - Translation
		),
		'show' => array(
			'all' => '모든 피드 보기',
			'error' => '오류가 발생한 피드만 보기',
		),
		'showing' => array(
			'error' => '오류가 발생한 피드만 보여주고 있습니다',
		),
		'ssl_verify' => 'SSL 유효성 검사',
		'stats' => '통계',
		'think_to_add' => '피드를 추가할 수 있습니다.',
		'timeout' => '타임아웃 (초)',
		'title' => '제목',
		'title_add' => 'RSS 피드 추가',
		'ttl' => '다음 시간이 지나기 전에 새로고침 금지',
		'url' => '피드 URL',
		'useragent' => 'Set the user agent for fetching this feed',	// TODO - Translation
		'useragent_help' => 'Example: <kbd>Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:86.0)</kbd>',	// TODO - Translation
		'validator' => '피드 유효성 검사',
		'website' => '웹사이트 URL',
		'websub' => 'WebSub을 사용한 즉시 알림',
	),
	'firefox' => array(
		'documentation' => 'FreshRSS를 Firefox 피드 리더에 추가하기 위해서는 <a href="https://developer.mozilla.org/en-US/Firefox/Releases/2/Adding_feed_readers_to_Firefox#Adding_a_new_feed_reader_manually">여기</a>의 설명을 따르세요.',
		'obsolete_63' => 'From version 63 and onwards, Firefox has removed the ability to add your own subscription services that are not standalone programs.',	// TODO - Translation
		'title' => 'Firefox 피드 리더',
	),
	'import_export' => array(
		'export' => '내보내기',
		'export_labelled' => '라벨이 표시된 글들 내보내기',
		'export_opml' => '피드 목록 내보내기 (OPML)',
		'export_starred' => '즐겨찾기 내보내기',
		'feed_list' => '%s 개의 글 목록',
		'file_to_import' => '불러올 파일<br />(OPML, JSON 또는 ZIP)',
		'file_to_import_no_zip' => '불러올 파일<br />(OPML 또는 JSON)',
		'import' => '불러오기',
		'starred_list' => '즐겨찾기에 등록된 글 목록',
		'title' => '불러오기 / 내보내기',
	),
	'menu' => array(
		'add' => 'Add a feed or category',	// TODO - Translation
		'add_feed' => 'Add a feed',	// TODO - Translation
		'bookmark' => '구독하기 (FreshRSS 북마클릿)',
		'import_export' => '불러오기 / 내보내기',
		'label_management' => 'Label management',	// TODO - Translation
		'subscription_management' => '구독 관리',
		'subscription_tools' => '구독 도구',
	),
	'tag' => array(
		'name' => 'Name',	// TODO - Translation
		'new_name' => 'New name',	// TODO - Translation
		'old_name' => 'Old name',	// TODO - Translation
	),
	'title' => array(
		'_' => '구독 관리',
		'add' => 'Add a feed or category',	// TODO - Translation
		'add_category' => 'Add a category',	// TODO - Translation
		'add_feed' => 'Add a feed',	// TODO - Translation
		'add_label' => 'Add a label',	// TODO - Translation
		'delete_label' => 'Delete a label',	// TODO - Translation
		'feed_management' => 'RSS 피드 관리',
		'rename_label' => 'Rename a label',	// TODO - Translation
		'subscription_tools' => '구독 도구',
	),
);
