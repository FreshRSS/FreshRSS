<?php

return array(
	'admin' => array(
		'optimization_complete' => '최적화가 완료되었습니다',
	),
	'access' => array(
		'denied' => '이 페이지에 접근할 수 있는 권한이 없습니다',
		'not_found' => '이 페이지는 존재하지 않습니다',
	),
	'auth' => array(
		'form' => array(
			'not_set' => '인증 시스템을 설정하는 동안 문제가 발생했습니다. 잠시 후 다시 시도하세요.',
			'set' => '웹폼이 이제 기본 인증 시스템으로 설정되었습니다.',
		),
		'login' => array(
			'invalid' => '유효하지 않은 로그인입니다',
			'success' => '접속되었습니다',
		),
		'logout' => array(
			'success' => '접속이 해제되었습니다',
		),
		'no_password_set' => '관리자 암호가 설정되지 않았습니다. 이 기능은 사용할 수 없습니다.',
	),
	'conf' => array(
		'error' => '설정을 저장하는 동안 문제가 발생했습니다',
		'query_created' => '쿼리 "%s" 가 생성되었습니다.',
		'shortcuts_updated' => '단축키가 갱신되었습니다',
		'updated' => '설정이 저장되었습니다',
	),
	'extensions' => array(
		'already_enabled' => '%s 확장 기능은 이미 활성화되어 있습니다',
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
	),
	'import_export' => array(
		'export_no_zip_extension' => 'ZIP 확장 기능을 서버에서 찾을 수 없습니다. 파일을 하나씩 내보내세요.',
		'feeds_imported' => '피드를 성공적으로 불러왔습니다',
		'feeds_imported_with_errors' => '피드를 불러왔지만, 문제가 발생했습니다',
		'file_cannot_be_uploaded' => '파일을 업로드할 수 없습니다!',
		'no_zip_extension' => 'ZIP 확장 기능을 서버에서 찾을 수 없습니다.',
		'zip_error' => 'ZIP 파일을 불러오는 동안 문제가 발생했습니다.',
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
			'deleted' => '피드가 삭제되었습니다',
			'error' => '피드를 변경할 수 없습니다',
			'internal_problem' => 'RSS 피드를 추가할 수 없습니다. 자세한 내용은 <a href="%s">FreshRSS 로그</a>를 참고하세요.',
			'invalid_url' => 'URL (<em>%s</em>)이 유효하지 않습니다',
			'n_actualized' => '%d 개의 피드에서 새 글을 가져왔습니다',
			'n_entries_deleted' => '%d 개의 글을 삭제했습니다',
			'no_refresh' => '새 글을 가져올 피드가 없습니다…',
			'not_added' => '<em>%s</em> 피드를 추가할 수 없습니다',
			'over_max' => '피드 개수 제한에 다다랐습니다 (%d)',
			'updated' => '피드가 변경되었습니다',
		),
		'purge_completed' => '삭제 완료 (%d 개의 글을 삭제했습니다)',
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
