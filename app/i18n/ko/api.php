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
	'information' => array(
		'address' => 'API 주소:',
		'output' => array(
			'encoding-support' => '⚠️ 경고: <code>%2F</code>를 지원하지 않아 일부 클라이언트가 작동하지 않을 수 있습니다!',
			'invalid-configuration' => '⚠️ 경고: ./data/config.php의 기본 URL이 잘못되었을 수 있습니다',
			'pass' => '✔️ 통과',
			'unknown-error' => '❌ ',	// IGNORE
		),
		'test' => array(
			'fever' => 'Fever API 설정 테스트:',
			'greader' => 'Google Reader API 설정 테스트:',
		),
		'title' => array(
			'_' => 'FreshRSS API 엔드포인트',
			'extension' => '확장 기능용 API',
			'fever' => 'Fever 호환 API',
			'greader' => 'Google Reader 호환 API',
		),
	),
);
