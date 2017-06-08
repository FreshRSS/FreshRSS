<?php

return array(
	'admin' => array(
		'optimization_complete' => '최적화과 완료되었습니다',
	),
	'access' => array(
		'denied' => '이 페이지에 접근할 수 있는 권한이 없습니다',
		'not_found' => '이 페이지는 존재하지 않습니다',
	),
	'auth' => array(
		'form' => array(
			'not_set' => 'A problem occured during authentication system configuration. Please retry later.',
			'set' => 'Form is now your default authentication system.',
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
		'already_enabled' => '%s is already enabled',
		'disable' => array(
			'ko' => '%s cannot be disabled. <a href="%s">Check FressRSS logs</a> for details.',
			'ok' => '%s is now disabled',
		),
		'enable' => array(
			'ko' => '%s cannot be enabled. <a href="%s">Check FressRSS logs</a> for details.',
			'ok' => '%s is now enabled',
		),
		'no_access' => 'You have no access on %s',
		'not_enabled' => '%s is not enabled',
		'not_found' => '%s does not exist',
	),
	'import_export' => array(
		'export_no_zip_extension' => 'ZIP 확장 기능을 서버에서 찾을 수 없습니다. 파일을 하나씩 내보내세요.',
		'feeds_imported' => '피드를 성공적으로 불러왔습니다',
		'feeds_imported_with_errors' => '피드를 불러왔지만, 문제가 발생했습니다',
		'file_cannot_be_uploaded' => '파일을 업로드할 수 없습니다!',
		'no_zip_extension' => 'ZIP 확장 기능을 서버에서 찾을 수 없습니다.',
		'zip_error' => 'ZIP 파일을 불러오는 동안 문제가 발생했습니다.',
	),
	'sub' => array(
		'actualize' => 'Updating',
		'category' => array(
			'created' => 'Category %s has been created.',
			'deleted' => 'Category has been deleted.',
			'emptied' => 'Category has been emptied',
			'error' => 'Category cannot be updated',
			'name_exists' => 'Category name already exists.',
			'no_id' => 'You must specify the id of the category.',
			'no_name' => 'Category name cannot be empty.',
			'not_delete_default' => 'You cannot delete the default category!',
			'not_exist' => 'The category does not exist!',
			'over_max' => 'You have reached your limit of categories (%d)',
			'updated' => 'Category has been updated.',
		),
		'feed' => array(
			'actualized' => '<em>%s</em> has been updated',
			'actualizeds' => 'RSS feeds have been updated',
			'added' => 'RSS 피드 <em>%s</em> 가 추가되었습니다',
			'already_subscribed' => 'You have already subscribed to <em>%s</em>',
			'deleted' => 'Feed has been deleted',
			'error' => 'Feed cannot be updated',
			'internal_problem' => 'The RSS feed could not be added. <a href="%s">Check FressRSS logs</a> for details.',
			'invalid_url' => 'URL <em>%s</em> is invalid',
			'marked_read' => 'Feeds have been marked as read',
			'n_actualized' => '%d feeds have been updated',
			'n_entries_deleted' => '%d articles have been deleted',
			'no_refresh' => 'There is no feed to refresh…',
			'not_added' => '<em>%s</em> could not be added',
			'over_max' => 'You have reached your limit of feeds (%d)',
			'updated' => 'Feed has been updated',
		),
		'purge_completed' => 'Purge completed (%d articles deleted)',
	),
	'update' => array(
		'can_apply' => 'FreshRSS will now be updated to the <strong>version %s</strong>.',
		'error' => 'The update process has encountered an error: %s',
		'file_is_nok' => 'New <strong>version %s</strong> available, but check permissions on <em>%s</em> directory. HTTP server must have rights to write into',
		'finished' => 'Update completed!',
		'none' => 'No update to apply',
		'server_not_found' => 'Update server cannot be found. [%s]',
	),
	'user' => array(
		'created' => array(
			'_' => '사용자 %s 가 생성되었습니다',
			'error' => '사용자 %s 를 생성할 수 없습니다',
		),
		'deleted' => array(
			'_' => 'User %s has been deleted',
			'error' => 'User %s cannot be deleted',
		),
	),
	'profile' => array(
		'error' => 'Your profile cannot be modified',
		'updated' => 'Your profile has been modified',
	),
);
