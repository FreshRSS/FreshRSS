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
	'access' => array(
		'denied' => '이 페이지에 접근할 수 있는 권한이 없습니다',
		'not_found' => '이 페이지는 존재하지 않습니다',
	),
	'admin' => array(
		'optimization_complete' => '최적화가 완료되었습니다',
	),
	'api' => array(
		'password' => array(
			'failed' => '비밀번호가 변경될 수 없습니다',
			'updated' => '비밀번호가 변경되었습니다',
		),
	),
	'auth' => array(
		'login' => array(
			'invalid' => '유효하지 않은 로그인입니다',
			'success' => '접속되었습니다',
		),
		'logout' => array(
			'success' => '접속이 해제되었습니다',
		),
	),
	'conf' => array(
		'error' => '설정을 저장하는 동안 문제가 발생했습니다',
		'query_created' => '쿼리 “%s” 가 생성되었습니다.',
		'shortcuts_updated' => '단축키가 갱신되었습니다',
		'updated' => '설정이 저장되었습니다',
	),
	'extensions' => array(
		'already_enabled' => '%s 확장 기능은 이미 활성화되어 있습니다',
		'cannot_remove' => '%s 은(는) 삭제될 수 없습니다',
		'disable' => array(
			'ko' => '%s 확장 기능을 비활성화 할 수 없습니다. 자세한 내용은 <a href="%s">FreshRSS 로그</a>를 참고하세요.',
			'ok' => '%s 확장 기능이 비활성화되었습니다',
		),
		'enable' => array(
			'ko' => '%s 확장 기능을 활성화 할 수 없습니다. 자세한 내용은 <a href="%s">FreshRSS 로그</a>를 참고하세요.',
			'ok' => '%s 확장 기능이 활성화되었습니다',
		),
		'no_access' => '%s 확장 기능에 접근 권한이 없습니다',
		'not_enabled' => '%s 확장 기능이 활성화되지 않았습니다',
		'not_found' => '%s 확장 기능이 존재하지 않습니다',
		'removed' => '%s 삭제 됨',
	),
	'import_export' => array(
		'export_no_zip_extension' => 'ZIP 확장 기능을 서버에서 찾을 수 없습니다. 파일을 하나씩 내보내세요.',
		'feeds_imported' => '피드 불러오기가 완료됐습니다. 불러오기가 끝났다면 이제 <i>피드 업데이트</i> 버튼을 클릭해도 됩니다.',
		'feeds_imported_with_errors' => '피드를 불러왔지만, 문제가 발생했습니다. 불러오기가 끝났다면 이제 <i>피드 업데이트</i> 버튼을 클릭해도 됩니다.',
		'file_cannot_be_uploaded' => '파일을 업로드할 수 없습니다!',
		'no_zip_extension' => 'ZIP 확장 기능을 서버에서 찾을 수 없습니다.',
		'zip_error' => 'ZIP 처리 중 문제가 발생했습니다.',
	),
	'profile' => array(
		'error' => '프로필을 변경할 수 없습니다',
		'updated' => '프로필을 변경했습니다',
	),
	'sub' => array(
		'actualize' => '피드를 가져오는 중입니다',
		'articles' => array(
			'marked_read' => '선택된 글들을 읽음으로 표시하였습니다.',
			'marked_unread' => '선택된 글들을 읽지 않음으로 표시하였습니다.',
		),
		'category' => array(
			'created' => '%s 카테고리가 생성되었습니다.',
			'deleted' => '카테고리가 삭제되었습니다.',
			'emptied' => '카테고리를 비웠습니다',
			'error' => '카테고리를 변경할 수 없습니다',
			'name_exists' => '같은 카테고리 이름이 이미 존재합니다.',
			'no_id' => '카테고리 id를 명시해야 합니다.',
			'no_name' => '카테고리 이름을 명시해야 합니다.',
			'not_delete_default' => '기본 카테고리는 삭제할 수 없습니다!',
			'not_exist' => '카테고리가 존재하지 않습니다!',
			'over_max' => '카테고리 개수 제한에 다다랐습니다 (%d)',
			'updated' => '카테고리가 변경되었습니다.',
		),
		'feed' => array(
			'actualized' => '<em>%s</em> 피드에서 새 글을 가져왔습니다',
			'actualizeds' => 'RSS 피드에서 새 글을 가져왔습니다',
			'added' => '<em>%s</em> 피드가 추가되었습니다',
			'already_subscribed' => '이미 <em>%s</em> 피드를 구독 중입니다',
			'cache_cleared' => '<em>%s</em> 캐쉬 지움',
			'deleted' => '피드가 삭제되었습니다',
			'error' => '피드를 변경할 수 없습니다',
			'internal_problem' => 'RSS 피드를 추가할 수 없습니다. 자세한 내용은 <a href="%s">FreshRSS 로그</a>를 참고하세요. <code>#force_feed</code>를 URL에 추가하여 강제로 추가 시도 할 수 있습니다.',
			'invalid_url' => 'URL (<em>%s</em>)이 유효하지 않습니다',
			'n_actualized' => '%d 개의 피드에서 새 글을 가져왔습니다',
			'n_entries_deleted' => '%d 개의 글을 삭제했습니다',
			'no_refresh' => '새 글을 가져올 피드가 없습니다…',
			'not_added' => '<em>%s</em> 피드를 추가할 수 없습니다',
			'not_found' => '피드를 찾을 수 없습니다',
			'over_max' => '피드 개수 제한에 다다랐습니다 (%d)',
			'reloaded' => '<em>%s</em> 이(가) 다시 로드 되었습니다',
			'selector_preview' => array(
				'http_error' => '웹사이트 콘텐츠 로드 실패.',
				'no_entries' => '이 피드에는 아무런 글이 없습니다. 미리보기를 하려면 최소한 하나의 글이 필요합니다.',
				'no_feed' => '내부 오류 (피드를 찾을 수 없습니다).',
				'no_result' => '셀렉터와 일치하는 항목이 없습니다. 대체로 원본 피드 텍스트가 대신 표시됩니다.',
				'selector_empty' => '셀렉터가 비어있습니다. 미리보기를 생성하려면 셀렉터를 정의 해주세요.',
			),
			'updated' => '피드가 변경되었습니다',
		),
		'purge_completed' => '삭제 완료 (%d 개의 글을 삭제했습니다)',
	),
	'tag' => array(
		'created' => '“%s” 태그가 생성되었습니다.',
		'error' => '라벨 업데이트 실패!',
		'name_exists' => '같은 이름의 태그가 이미 존재합니다.',
		'renamed' => '“%s” 태그가 “%s” (으)로 이름이 변경되었습니다.',
		'updated' => '라벨이 업데이트 됐습니다.',
	),
	'update' => array(
		'can_apply' => 'FreshRSS가 <strong>%s</strong> 버전으로 업데이트됩니다.',
		'error' => '업데이트 과정에서 문제가 발생했습니다: %s',
		'file_is_nok' => '<strong>%s</strong> 버전을 사용할 수 있지만, <em>%s</em> 디렉토리의 권한을 확인하세요. HTTP 서버가 쓰기 권한을 가지고 있어야 합니다',
		'finished' => '업데이트를 완료했습니다!',
		'none' => '적용할 업데이트가 없습니다',
		'server_not_found' => '업데이트 서버를 찾을 수 없습니다. [%s]',
	),
	'user' => array(
		'created' => array(
			'_' => '%s 사용자가 생성되었습니다',
			'error' => '%s 사용자를 생성할 수 없습니다',
		),
		'deleted' => array(
			'_' => '%s 사용자를 삭제했습니다',
			'error' => '%s 사용자를 삭제할 수 없습니다',
		),
		'updated' => array(
			'_' => '사용자 %s의 정보가 변경되었습니다',
			'error' => '사용자 %s의 정보가 변경되지 않았습니다',
		),
	),
);
