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
	'about' => array(
		'_' => '정보',
		'agpl3' => '<a href="https://www.gnu.org/licenses/agpl-3.0.html">AGPL 3</a>',	// IGNORE
		'bug_reports' => array(
			'environment_information' => array(
				'_' => '시스템 정보',
				'browser' => '브라우저',
				'database' => '데이터베이스',
				'server_software' => '서버 소프트웨어',
				'version_curl' => 'cURL 버전',
				'version_frss' => 'FreshRSS 버전',
				'version_php' => 'PHP 버전',
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
		'published' => array(
			'_' => '발행됨',
			'future' => '미래 날짜로 발행됨',
			'today' => '오늘 발행됨',
			'yesterday' => '어제 발행됨',
		),
		'received' => array(
			'_' => '수신됨',
			'today' => '오늘 수신됨',
			'yesterday' => '어제 수신됨',
		),
		'rss_of' => '%s의 피드',
		'title' => '메인 스트림',
		'title_fav' => '즐겨찾기',
		'title_global' => '전체 모드',
		'userModified' => array(
			'_' => '사용자가 수정함',
			'today' => '오늘 사용자가 수정함',
			'yesterday' => '어제 사용자가 수정함',
		),
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
		'non-starred' => '즐겨찾기를 제외하고 표시',
		'normal_view' => '일반 모드',
		'queries' => '사용자 쿼리',
		'read' => '읽은 글만 표시',
		'reader_view' => '읽기 모드',
		'rss_view' => 'RSS 피드',
		'search_short' => '검색',
		'sort' => array(
			'asc' => '오름차순',
			'c' => array(
				'name_asc' => '카테고리, 피드 제목 A→Z',
				'name_desc' => '카테고리, 피드 제목 Z→A',
			),
			'date_asc' => '발행일 1→9',
			'date_desc' => '발행일 9→1',
			'desc' => '내림차순',
			'f' => array(
				'name_asc' => '피드 제목 A→Z',
				'name_desc' => '피드 제목 Z→A',
			),
			'id_asc' => '최근 수신한 글을 마지막에',
			'id_desc' => '최근 수신한 글을 먼저',
			'length_asc' => '내용 길이 1→9',
			'length_desc' => '내용 길이 9→1',
			'link_asc' => '링크 A→Z',
			'link_desc' => '링크 Z→A',
			'primary' => array(
				'_' => '정렬 기준',
				'help' => '일관성과 성능을 위해 대부분의 경우 <em>수신</em> 날짜로 정렬하는 것을 권장합니다',
			),
			'rand' => '무작위 순서',
			'secondary' => array(
				'_' => '보조 정렬 기준',
				'help' => '기본 정렬 기준이 카테고리나 피드 제목일 때만 적용됩니다',
			),
			'title_asc' => '제목 A→Z',
			'title_desc' => '제목 Z→A',
			'user_modified_asc' => '사용자 수정일 1→9',
			'user_modified_desc' => '사용자 수정일 9→1',
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
