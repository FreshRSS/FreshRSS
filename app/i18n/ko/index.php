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
	'about' => array(
		'_' => '정보',
		'agpl3' => '<a href="https://www.gnu.org/licenses/agpl-3.0.html">AGPL 3</a>',	// IGNORE
		'bug_reports' => array(
			'environment_information' => array(
				'_' => 'System information',	// TODO
				'browser' => 'Browser',	// TODO
				'database' => 'Database',	// TODO
				'server_software' => 'Server software',	// TODO
				'version_curl' => 'cURL version',	// TODO
				'version_frss' => 'FreshRSS version',	// TODO
				'version_php' => 'PHP version',	// TODO
			),
		),
		'bugs_reports' => '버그 제보하기',
		'documentation' => '문서',
		'freshrss_description' => 'FreshRSS는 같은 셀프 호스팅 기반의 RSS 피드 수집기입니다. FreshRSS는 강력하고 다양한 설정을 할 수 있으면서도 가볍고 사용하기 쉽습니다.',
		'github' => '<a href="https://github.com/FreshRSS/FreshRSS/issues">GitHub 저장소에 제보</a>',
		'license' => '라이센스',
		'project_website' => '프로젝트 웹사이트',
		'title' => '정보',
		'version' => '버전',
	),
	'feed' => array(
		'empty' => '글이 없습니다.',
		'received' => array(
			'before_yesterday' => 'Received before yesterday',	// TODO
			'today' => 'Received today',	// TODO
			'yesterday' => 'Received yesterday',	// TODO
		),
		'rss_of' => '%s의 피드',
		'title' => '메인 스트림',
		'title_fav' => '즐겨찾기',
		'title_global' => '전체 모드',
	),
	'log' => array(
		'_' => '로그',
		'clear' => '로그 모두 지우기',
		'empty' => '로그 파일이 비어있습니다',
		'title' => '로그',
	),
	'menu' => array(
		'about' => 'FreshRSS 정보',
		'before_one_day' => '하루 전',
		'before_one_week' => '일주일 전',
		'bookmark_query' => '현재 쿼리 북마크',
		'favorites' => '즐겨찾기 (%s)',
		'global_view' => '전체 모드',
		'important' => '중요 피드',
		'main_stream' => '메인 스트림',
		'mark_all_read' => '모두 읽음으로 표시',
		'mark_cat_read' => '카테고리를 읽음으로 표시',
		'mark_feed_read' => '피드를 읽음으로 표시',
		'mark_selection_unread' => '선택된 글을 읽지 않음으로 표시',
		'mylabels' => '내 라벨',
		'newer_first' => '최근 글 먼저',
		'non-starred' => '즐겨찾기를 제외하고 표시',
		'normal_view' => '일반 모드',
		'older_first' => '오래된 글 먼저',
		'queries' => '사용자 쿼리',
		'read' => '읽은 글만 표시',
		'reader_view' => '읽기 모드',
		'rss_view' => 'RSS 피드',
		'search_short' => '검색',
		'sort' => array(
			'_' => 'Sorting criteria',	// TODO
			'c' => array(
				'name_asc' => 'Category, feed titles A→Z',	// TODO
				'name_desc' => 'Category, feed titles Z→A',	// TODO
			),
			'date_asc' => 'Publication date 1→9',	// TODO
			'date_desc' => 'Publication date 9→1',	// TODO
			'f' => array(
				'name_asc' => 'Feed title A→Z',	// TODO
				'name_desc' => 'Feed title Z→A',	// TODO
			),
			'id_asc' => 'Freshly received last',	// TODO
			'id_desc' => 'Freshly received first',	// TODO
			'link_asc' => 'Link A→Z',	// TODO
			'link_desc' => 'Link Z→A',	// TODO
			'rand' => 'Random order',	// TODO
			'title_asc' => 'Title A→Z',	// TODO
			'title_desc' => 'Title Z→A',	// TODO
		),
		'starred' => '즐겨찾기만 표시',
		'stats' => '통계',
		'subscription' => '구독 관리',
		'unread' => '읽지 않은 글만 표시',
	),
	'share' => '공유',
	'tag' => array(
		'related' => '관련 태그',
	),
	'tos' => array(
		'title' => '서비스 약관',
	),
);
