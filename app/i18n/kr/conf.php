<?php

return array(
	'archiving' => array(
		'_' => '보관',
		'advanced' => '고급 설정',
		'delete_after' => '다음 기간보다 오래된 글 삭제',
		'help' => '더 자세한 옵션은 개별 피드 설정에 있습니다',
		'keep_history_by_feed' => '피드별 최소 유지 글 개수',
		'optimize' => '데이터베이스 최적화',
		'optimize_help' => '데이터베이스 크기를 줄이기 위해 가끔씩 수행해주세요',
		'purge_now' => '지금 삭제',
		'title' => '보관',
		'ttl' => '다음 시간이 지나기 전에 새로고침 금지',
	),
	'display' => array(
		'_' => '표시',
		'icon' => array(
			'bottom_line' => '하단',
			'entry' => '문서 아이콘',
			'publication_date' => '발행일',
			'related_tags' => '관련 태그',
			'sharing' => '공유',
			'top_line' => '상단',
		),
		'language' => '언어',
		'notif_html5' => array(
			'seconds' => '초 (0: 타임아웃 없음)',
			'timeout' => 'HTML5 알림 타임아웃',
		),
		'show_nav_buttons' => '내비게이션 버튼 보이기',
		'theme' => '테마',
		'title' => '표시',
		'width' => array(
			'content' => '내용 표시 너비',
			'large' => '넓음',
			'medium' => '보통',
			'no_limit' => '제한 없음',
			'thin' => '얇음',
		),
	),
	'profile' => array(
		'_' => '프로필 관리',
		'delete' => array(
			'_' => '계정 삭제',
			'warn' => '당신의 계정과 관련된 모든 데이터가 삭제됩니다.',
		),
		'password_api' => 'API 암호<br /><small>(예: 모바일 애플리케이션)</small>',
		'password_form' => '암호<br /><small>(웹폼 로그인 방식 사용시)</small>',
		'password_format' => '7 글자 이상이어야 합니다',
		'title' => '프로필',
	),
	'query' => array(
		'_' => '사용자 쿼리',
		'deprecated' => '이 쿼리는 더 이상 유효하지 않습니다. 해당하는 카테고리나 피드가 삭제되었습니다.',
		'display' => '사용자 쿼리 결과 표시',
		'filter' => '적용된 필터:',
		'get_all' => '모든 글 표시',
		'get_category' => '"%s" 카테고리 표시',
		'get_favorite' => '즐겨찾기에 등록된 글 표시',
		'get_feed' => '"%s" 피드 표시',
		'no_filter' => '필터가 없습니다',
		'none' => '아직 사용자 쿼리를 만들지 않았습니다.',
		'number' => '쿼리 #%d',
		'order_asc' => '오래된 글 먼저 표시',
		'order_desc' => '최근 글 먼저 표시',
		'remove' => '사용자 쿼리 삭제',
		'search' => '"%s"의 검색 결과',
		'state_0' => '모든 글 표시',
		'state_1' => '읽은 글 표시',
		'state_2' => '읽지 않은 글 표시',
		'state_3' => '모든 글 표시',
		'state_4' => '즐겨찾기에 등록된 글 표시',
		'state_5' => '즐겨찾기에 등록된 읽은 글 표시',
		'state_6' => '즐겨찾기에 등록된 읽지 않은 글 표시',
		'state_7' => '즐겨찾기에 등록된 글 표시',
		'state_8' => '즐겨찾기에 등록되지 않은 글 표시',
		'state_9' => '즐겨찾기에 등록되지 않고 읽은 글 표시',
		'state_10' => '즐겨찾기에 등록되지 않고 읽지 않은 글 표시',
		'state_11' => '즐겨찾기에 등록되지 않은 글 표시',
		'state_12' => '모든 글 표시',
		'state_13' => '읽은 글 표시',
		'state_14' => '읽지 않은 글 표시',
		'state_15' => '모든 글 표시',
		'title' => '사용자 쿼리',
	),
	'reading' => array(
		'_' => '읽기',
		'after_onread' => '“모두 읽음으로 표시” 후,',
		'articles_per_page' => '페이지당 글 수',
		'auto_load_more' => '페이지 하단에 다다르면 글 더 불러오기',
		'auto_remove_article' => '글을 읽은 후 숨기기',
		'confirm_enabled' => '“모두 읽음으로 표시” 실행시 확인 창 표시',
		'display_articles_unfolded' => '글을 펼쳐진 상태로 보여주기',
		'display_categories_unfolded' => '카테고리를 접힌 상태로 보여주기',
		'hide_read_feeds' => '읽지 않은 글이 없는 카테고리와 피드 감추기 (“모든 글 표시”가 설정된 경우 동작하지 않습니다)',
		'img_with_lazyload' => '그림을 불러오는 데에 "lazy load" 모드 사용하기',
		'jump_next' => '다음 읽지 않은 항목으로 이동 (피드 또는 카테고리)',
		'mark_updated_article_unread' => '갱신 된 글을 읽지 않음으로 표시',
		'number_divided_when_reader' => '읽기 모드에서는 절반만 표시됩니다.',
		'read' => array(
			'article_open_on_website' => '글이 게재된 웹사이트를 방문했을 때',
			'article_viewed' => '글을 읽었을 때',
			'scroll' => '스크롤을 하며 지나갈 때',
			'upon_reception' => '글을 가져오자마자',
			'when' => '읽음으로 표시…',
		),
		'show' => array(
			'_' => '글 표시 방식',
			'adaptive' => '읽지 않은 글이 없으면 모든 글 표시',
			'all_articles' => '모든 글 표시',
			'unread' => '읽지 않은 글만 표시',
		),
		'sides_close_article' => '글 영역 바깥을 클릭하면 글 접기',
		'sort' => array(
			'_' => '정렬 순서',
			'newer_first' => '최근 글 먼저',
			'older_first' => '오래된 글 먼저',
		),
		'sticky_post' => '글이 펼쳐진 경우 최상단에 고정하기',
		'title' => '읽기',
		'view' => array(
			'default' => '기본 보기 모드',
			'global' => '전체 모드',
			'normal' => '일반 모드',
			'reader' => '읽기 모드',
		),
	),
	'sharing' => array(
		'_' => '공유',
		'add' => '공유 방법 추가',
		'blogotext' => 'Blogotext',
		'diaspora' => 'Diaspora*',
		'email' => '메일',
		'facebook' => 'Facebook',
		'g+' => 'Google+',
		'more_information' => '자세한 정보',
		'print' => '인쇄',
		'remove' => '공유 방법 삭제',
		'shaarli' => 'Shaarli',
		'share_name' => '표시할 이름',
		'share_url' => '사용할 공유 URL',
		'title' => '공유',
		'twitter' => 'Twitter',
		'wallabag' => 'wallabag',
	),
	'shortcut' => array(
		'_' => '단축키',
		'article_action' => '글 관련 동작',
		'auto_share' => '공유',
		'auto_share_help' => '공유 옵션이 하나만 설정되어 있다면 해당 공유 옵션을 사용하고, 그렇지 않다면 공유 옵션을 번호로 선택할 수 있습니다.',
		'close_dropdown' => '메뉴 닫기',
		'collapse_article' => '접기',
		'first_article' => '첫 글 보기',
		'focus_search' => '검색창 사용하기',
		'global_view' => '전체 모드로 전환',
		'help' => '도움말 보기',
		'javascript' => '단축키를 사용하기 위해선 자바스크립트를 사용하도록 설정하여야 합니다',
		'last_article' => '마지막 글 보기',
		'load_more' => '글 더 불러오기',
		'mark_favorite' => '즐겨찾기에 등록',
		'mark_read' => '읽음으로 표시',
		'navigation' => '탐색',
		'navigation_help' => '"Shift" 키를 누른 상태에선 탐색 단축키가 피드에 적용됩니다.<br/>"Alt" 키를 누른 상태에선 탐색 단축키가 카테고리에 적용됩니다.',
		'next_article' => '다음 글 보기',
		'normal_view' => '일반 모드로 전환',
		'other_action' => '다른 동작',
		'previous_article' => '이전 글 보기',
		'reading_view' => '읽기 모드로 전환',
		'rss_view' => '새 탭에서 RSS 피드 열기',
		'see_on_website' => '글이 게재된 웹사이트에서 보기',
		'shift_for_all_read' => '+ <code>shift</code>를 누른 상태에선 모두 읽음으로 표시',
		'title' => '단축키',
		'user_filter' => '사용자 필터 사용하기',
		'user_filter_help' => '사용자 필터가 하나만 설정되어 있다면 해당 필터를 사용하고, 그렇지 않다면 필터를 번호로 선택할 수 있습니다.',
		'views' => '표시',
	),
	'user' => array(
		'articles_and_size' => '%s 개의 글 (%s)',
		'current' => '현재 사용자',
		'is_admin' => '관리자입니다',
		'users' => '전체 사용자',
	),
);
