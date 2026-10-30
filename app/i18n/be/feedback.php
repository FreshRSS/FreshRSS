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
	'access' => array(
		'denied' => 'У вас няма дазволу на доступ да гэтай старонкі',
		'not_found' => 'Вы шукаеце старонку, якой не існуе',
	),
	'admin' => array(
		'optimization_complete' => 'Аптымізацыя завершана',
	),
	'api' => array(
		'password' => array(
			'failed' => 'Немагчыма змяніць пароль',
			'updated' => 'Пароль зменены',
		),
	),
	'auth' => array(
		'login' => array(
			'invalid' => 'Няправільны лагін',
			'success' => 'Вы падключаныя',
		),
		'logout' => array(
			'success' => 'Вы адключаныя',
		),
	),
	'conf' => array(
		'error' => 'Падчас захавання канфігурацыі адбылася памылка',
		'query_created' => 'Запыт «%s» створаны.',
		'shortcuts_updated' => 'Спалучэнні клавіш абноўлены',
		'updated' => 'Канфігурацыя абноўлена',
	),
	'extensions' => array(
		'already_enabled' => '%s ужо ўключана',
		'cannot_remove' => '%s нельга выдаліць',
		'disable' => array(
			'ko' => '%s нельга адключыць. <a href="%s">Праверце журналы FreshRSS</a>, каб даведацца падрабязнасці.',
			'ok' => '%s цяпер адключана',
		),
		'enable' => array(
			'ko' => '%s нельга ўключыць. <a href="%s">Праверце журналы FreshRSS</a>, каб даведацца падрабязнасці.',
			'ok' => '%s цяпер уключана',
		),
		'invalid_view_mode' => 'Няправільны рэжым выгляду «%s»! Вяртанне да «Звычайнага выгляду».',
		'no_access' => 'У вас няма доступу да %s',
		'not_enabled' => '%s не ўключана',
		'not_found' => '%s не існуе',
		'removed' => '%s выдалена',
	),
	'import_export' => array(
		'export_no_zip_extension' => 'На серверы адсутнічае пашырэнне ZIP. Паспрабуйце экспартаваць файлы па адным.',
		'feeds_imported' => 'Стужкі імпартаваны. Калі імпарт завершаны, можна націснуць кнопку <i>Абнавіць стужкі</i>.',
		'feeds_imported_with_errors' => 'Стужкі імпартаваны, але ўзніклі некаторыя памылкі. Калі імпарт завершаны, можна націснуць кнопку <i>Абнавіць стужкі</i>.',
		'file_cannot_be_uploaded' => 'Не ўдалося запампаваць файл!',
		'no_zip_extension' => 'На серверы адсутнічае пашырэнне ZIP.',
		'zip_error' => 'Падчас апрацоўкі ZIP узнікла памылка.',
	),
	'profile' => array(
		'error' => 'Немагчыма змяніць профіль',
		'passwords_dont_match' => 'Паролі не супадаюць',
		'updated' => 'Профіль зменены',
	),
	'sub' => array(
		'actualize' => 'Абнаўленне',
		'articles' => array(
			'marked_read' => 'Выбраныя артыкулы пазначаны як прачытаныя.',
			'marked_unread' => 'Артыкулы пазначаны як непрачытаныя.',
		),
		'category' => array(
			'created' => 'Катэгорыя %s створана.',
			'deleted' => 'Катэгорыя выдалена.',
			'emptied' => 'Катэгорыя ачышчана',
			'error' => 'Немагчыма абнавіць катэгорыю',
			'name_exists' => 'Назва катэгорыі ўжо існуе.',
			'no_id' => 'Трэба ўказаць ідэнтыфікатар катэгорыі.',
			'no_name' => 'Назва катэгорыі не можа быць пустой.',
			'not_delete_default' => 'Нельга выдаліць прадвызначаную катэгорыю!',
			'not_exist' => 'Катэгорыя не існуе!',
			'over_max' => 'Вы дасягнулі ліміту катэгорый (%d)',
			'updated' => 'Катэгорыя абноўлена.',
		),
		'feed' => array(
			'actualized' => '<em>%s</em> абноўлена',
			'actualizeds' => 'RSS-стужкі абноўлены',
			'added' => 'RSS-стужка <em>%s</em> дададзена',
			'already_subscribed' => 'Вы ўжо падпісаліся на <em>%s</em>',
			'cache_cleared' => 'Кэш <em>%s</em> ачышчаны',
			'deleted' => 'Стужка выдалена',
			'error' => 'Немагчыма абнавіць стужку',
			'favicon' => array(
				'too_large' => 'Запампаваны значок занадта вялікі. Максімальны памер файла — <em>%s</em>.',
				'unsupported_format' => 'Фармат файла відарыса не падтрымліваецца!',
			),
			'internal_problem' => 'Не ўдалося дадаць стужку навін. <a href="%s">Праверце журнал FreshRSS</a>, каб даведацца падрабязнасці. Паспрабуйце прымусова дадаць стужку, дадаўшы <code>#force_feed</code> да URL-адраса.',
			'invalid_url' => 'Няправільны URL-адрас <em>%s</em>',
			'n_actualized' => '%d стужак абноўлена',
			'n_entries_deleted' => '%d артыкулаў выдалена',
			'no_refresh' => 'Няма стужак для абнаўлення',
			'not_added' => 'Не ўдалося дадаць <em>%s</em>',
			'not_found' => 'Стужку немагчыма знайсці',
			'over_max' => 'Вы дасягнулі ліміту стужак (%d)',
			'reloaded' => '<em>%s</em> перазагружана',
			'selector_preview' => array(
				'http_error' => 'Не ўдалося загрузіць змесціва сайта.',
				'no_entries' => 'У гэтай стужцы няма артыкулаў. Для стварэння перадпрагляду патрэбны як мінімум адзін артыкул.',
				'no_feed' => 'Унутраная памылка (стужка не знойдзена).',
				'no_result' => 'Селектар не адпавядае ніводнаму элементу. Замест гэтага будзе паказаны зыходны тэкст стужкі.',
				'selector_empty' => 'Селектар пусты. Для стварэння перадпрагляду трэба задаць селектар.',
			),
			'updated' => 'Стужка абноўлена',
		),
		'purge_completed' => 'Ачыстка завершана (%d артыкулаў выдалена)',
	),
	'tag' => array(
		'created' => 'Метка «%s» створана.',
		'error' => 'Не ўдалося абнавіць метку!',
		'name_exists' => 'Назва меткі ўжо існуе.',
		'renamed' => 'Метка «%s» перайменавана ў «%s».',
		'updated' => 'Метка абноўлена.',
	),
	'update' => array(
		'can_apply' => 'Даступна абнаўленне FreshRSS: <strong>версія %s</strong>.',
		'error' => 'Падчас абнаўлення ўзнікла памылка: %s',
		'file_is_nok' => 'Даступна абнаўленне FreshRSS (<strong>версія %s</strong>), але праверце правы доступу да каталога <em>%s</em>. HTTP-сервер павінен мець права на запіс.',
		'finished' => 'Абнаўленне завершана!',
		'none' => 'Абнаўленняў няма',
		'server_not_found' => 'Сервер абнаўленняў не знойдзены. [%s]',
	),
	'user' => array(
		'created' => array(
			'_' => 'Карыстальнік %s створаны',
			'error' => 'Немагчыма стварыць карыстальніка %s',
		),
		'deleted' => array(
			'_' => 'Карыстальнік %s выдалены',
			'error' => 'Немагчыма выдаліць карыстальніка %s',
		),
		'updated' => array(
			'_' => 'Карыстальнік %s абноўлены',
			'error' => 'Карыстальнік %s не абноўлены',
		),
	),
);
