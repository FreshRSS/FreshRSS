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
	'api' => array(
		'documentation' => '외부 도구에서 API를 사용하기 위해서 아래 URL을 사용하세요.',
		'title' => 'API',	// IGNORE
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
		'position' => '표시 위치',
		'position_help' => '정렬 순서 제어',
		'title' => '제목',
	),
	'feed' => array(
		'add' => 'RSS 피드 추가',
		'advanced' => '고급 설정',
		'archiving' => '보관',
		'auth' => array(
			'configuration' => '로그인',
			'help' => 'HTTP 접속이 제한되는 RSS 피드에 접근합니다',
			'http' => 'HTTP 인증',
			'password' => 'HTTP 암호',
			'username' => 'HTTP 사용자 이름',
		),
		'clear_cache' => '항상 캐시 지우기',
		'content_action' => array(
			'_' => '글 콘텐츠를 가져올 때의 동작',
			'append' => '이미 존재하는 콘텐츠 다음에 추가',
			'prepend' => '이미 존재하는 콘텐츠 이전에 추가',
			'replace' => '이미 존재하는 콘텐츠 대체',
		),
		'css_cookie' => '글 콘텐츠를 가져올 때 쿠키를 사용',
		'css_cookie_help' => '예시: <kbd>foo=bar; gdpr_consent=true; cookie=value</kbd>',
		'css_help' => '글의 일부가 포함된 RSS 피드를 가져옵니다 (주의, 시간이 좀 더 걸립니다!)',
		'css_path' => '웹사이트 상의 글 본문에 해당하는 CSS 경로',
		'description' => '설명',
		'empty' => '이 피드는 비어있습니다. 피드가 계속 운영되고 있는지 확인하세요.',
		'error' => '이 피드에 문제가 발생했습니다. 이 피드에 접근 권한이 있는지 확인하세요.',
		'filteractions' => array(
			'_' => '필터 동작',
			'help' => '한 줄에 한 검색 필터를 작성해 주세요.',
		),
		'information' => '정보',
		'keep_min' => '최소 유지 글 개수',
		'kind' => array(
			'_' => 'Type of feed source',	// TODO
			'html_xpath' => array(
				'_' => 'HTML + XPath (Web scraping)',	// TODO
				'feed_title' => array(
					'_' => 'feed title',	// TODO
					'help' => 'Example: <code>//title</code> or a static string: <code>"My custom feed"</code>',	// TODO
				),
				'help' => '<dfn><a href="https://www.w3.org/TR/xpath-10/">XPath 1.0</a></dfn> is a standard query language for advanced users, and which FreshRSS supports to enable Web scraping.',	// TODO
				'item' => array(
					'_' => 'finding news <strong>items</strong><br /><small>(most important)</small>',	// TODO
					'help' => 'Example: <code>//div[@class="news-item"]</code>',	// TODO
				),
				'item_author' => array(
					'_' => 'item author',	// TODO
					'help' => 'Can also be a static string. Example: <code>"Anonymous"</code>',	// TODO
				),
				'item_categories' => 'items tags',	// TODO
				'item_content' => array(
					'_' => 'item content',	// TODO
					'help' => 'Example to take the full item: <code>.</code>',	// TODO
				),
				'item_thumbnail' => array(
					'_' => 'item thumbnail',	// TODO
					'help' => 'Example: <code>descendant::img/@src</code>',	// TODO
				),
				'item_timestamp' => array(
					'_' => 'item date',	// TODO
					'help' => 'The result will be parsed by <a href="https://php.net/strtotime"><code>strtotime()</code></a>',	// TODO
				),
				'item_title' => array(
					'_' => 'item title',	// TODO
					'help' => 'Use in particular the <a href="https://developer.mozilla.org/docs/Web/XPath/Axes">XPath axis</a> <code>descendant::</code> like <code>descendant::h2</code>',	// TODO
				),
				'item_uri' => array(
					'_' => 'item link (URL)',	// TODO
					'help' => 'Example: <code>descendant::a/@href</code>',	// TODO
				),
				'relative' => 'XPath (relative to item) for:',	// TODO
				'xpath' => 'XPath for:',	// TODO
			),
			'rss' => 'RSS / Atom (default)',	// TODO
		),
		'maintenance' => array(
			'clear_cache' => '캐쉬 지우기',
			'clear_cache_help' => '이 피드의 캐쉬 지우기.',
			'reload_articles' => '글 다시 로드',
			'reload_articles_help' => '글 다시 로드하고 셀렉터가 정의 되었을 경우에 모든 컨텐츠 가져오기.',
			'title' => '유지 보수',
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
		'proxy' => '이 피드를 가져올 때 사용할 프록시 설정',
		'proxy_help' => '프로토콜 선택 (예: SOCKS5) 그리고 프록시 주소 입력 (예: <kbd>127.0.0.1:1080</kbd>)',
		'selector_preview' => array(
			'show_raw' => '소스코드 표시',
			'show_rendered' => '콘텐츠 표시',
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
		'useragent' => '이 피드를 가져올 때 사용할 유저 에이전트 설정',
		'useragent_help' => '예시: <kbd>Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:86.0)</kbd>',
		'validator' => '피드 유효성 검사',
		'website' => '웹사이트 URL',
		'websub' => 'WebSub을 사용한 즉시 알림',
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
		'add' => '피드 혹은 카테고리 추가',
		'import_export' => '불러오기 / 내보내기',
		'label_management' => '라벨 관리',
		'stats' => array(
			'idle' => '유휴 피드',
			'main' => '주요 통계',
			'repartition' => '글 분류',
		),
		'subscription_management' => '구독 관리',
		'subscription_tools' => '구독 도구',
	),
	'tag' => array(
		'name' => '이름',
		'new_name' => '새 이름',
		'old_name' => '이전 이름',
	),
	'title' => array(
		'_' => '구독 관리',
		'add' => '피드 혹은 카테고리 추가',
		'add_category' => '카테고리 추가',
		'add_feed' => '피드 추가',
		'add_label' => '라벨 추가',
		'delete_label' => '라벨 삭제',
		'feed_management' => 'RSS 피드 관리',
		'rename_label' => '라벨 이름 바꾸기',
		'subscription_tools' => '구독 도구',
	),
);
