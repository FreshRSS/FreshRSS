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
			'invalid' => 'Endereço de email inválido',
			'required' => 'O endereço de email é obrigatório',
		),
		'validation' => array(
			'change_email' => 'Pode alterar o seu endereço de email <a href="%s">na página do perfil</a>.',
			'email_sent_to' => 'Enviámos um email para <strong>%s</strong>. Por favor, siga as instruções contidas no mesmo para verificar a sua conta.',
			'feedback' => array(
				'email_failed' => 'Não foi possível enviar o email devido a um erro de configuração no servidor.',
				'email_sent' => 'Foi enviado um email para o seu endereço',
				'error' => 'Falha na verificação do endereço de email',
				'ok' => 'O endereço de email foi verificado com sucesso.',
				'unnecessary' => 'Este endereço de email já foi verificado.',
				'wrong_token' => 'A verificação do endereço de email falhou devido a um token incorreto.',
			),
			'need_to' => 'Para poder utilizar o %s, deve verificar o seu endereço de email.',
			'resend_email' => 'Reenviar o email',
			'title' => 'Validação do endereço de email',
		),
	),
	'mailer' => array(
		'email_need_validation' => array(
			'body' => 'Registou-se no %s. No entanto, ainda é necessário verificar o seu endereço de email. Para o fazer, basta seguir o link:',
			'title' => 'Precisa de verificar a conta',
			'welcome' => 'Bem-vindo, %s,',
		),
	),
	'password' => array(
		'invalid' => 'Palavra-passe incorreta',
		'provided_password_too_long' => 'The provided password is too long.',	// TODO
	),
	'tos' => array(
		'feedback' => array(
			'invalid' => 'Para se registar, tem de aceitar os Termos de serviço.',
		),
	),
	'username' => array(
		'invalid' => 'Nome de utilizador inválido.',
		'taken' => 'O nome de utilizador %s já está a ser utilizado',
	),
);
