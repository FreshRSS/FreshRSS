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
	'email' => array(
		'feedback' => array(
			'invalid' => 'Няправільны адрас электроннай пошты.',
			'required' => 'Патрабуецца адрас электроннай пошты.',
		),
		'validation' => array(
			'change_email' => 'Вы можаце змяніць адрас электроннай пошты <a href="%s">на старонцы профілю</a>.',
			'email_sent_to' => 'Мы даслалі вам электронны ліст на адрас <strong>%s</strong>. Выканайце інструкцыі з яго, каб пацвердзіць адрас.',
			'feedback' => array(
				'email_failed' => 'Не ўдалося адправіць вам электронны ліст праз памылку канфігурацыі сервера.',
				'email_sent' => 'На адрас адпраўлены электронны ліст.',
				'error' => 'Не ўдалося пацвердзіць адрас электроннай пошты.',
				'ok' => 'Гэты адрас электроннай пошты пацверджаны.',
				'unnecessary' => 'Гэты адрас электроннай пошты ўжо быў пацверджаны.',
				'wrong_token' => 'Не ўдалося пацвердзіць гэты адрас электроннай пошты праз няправільны токен.',
			),
			'need_to' => 'Вам трэба пацвердзіць адрас электроннай пошты, перш чым вы зможаце выкарыстоўваць %s.',
			'resend_email' => 'Паўторна адправіць электронны ліст',
			'title' => 'Праверка адраса электроннай пошты',
		),
	),
	'mailer' => array(
		'email_need_validation' => array(
			'body' => 'Вы толькі што зарэгістраваліся на %s, але вам усё яшчэ трэба пацвердзіць адрас электроннай пошты. Для гэтага проста перайдзіце па спасылцы:',
			'title' => 'Вам трэба пацвердзіць уліковы запіс',
			'welcome' => 'Вітаем, %s,',
		),
	),
	'password' => array(
		'invalid' => 'Няправільны пароль.',
	),
	'tos' => array(
		'feedback' => array(
			'invalid' => 'Вы павінны прыняць умовы выкарыстання, каб зарэгістравацца.',
		),
	),
	'username' => array(
		'invalid' => 'Няправільнае імя карыстальніка.',
		'taken' => 'Гэта імя карыстальніка, %s, ужо занята.',
	),
);
