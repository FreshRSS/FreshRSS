<?php

return array(
	'email' => array(
		'feedback' => array(
			'invalid' => 'Endereço de email inválido',
			'required' => 'O endereço de email é necessário',
		),
		'validation' => array(
			'change_email' => 'Você pode mudar seu endereço de email <a href="%s">na página do perfil</a>.',
			'email_sent_to' => 'Enviamos um email para <strong>%s</strong>. Por favor, siga as instruções contidas nele para verificar sua conta.',
			'feedback' => array(
				'email_failed' => 'Não foi possível enviar um email para você devido a um erro de configuração no servidor.',
				'email_sent' => 'Um email foi enviado para o seu endereço',
				'error' => 'Falha na verificação do endereço de email',
				'ok' => 'O endereço de email foi verificado com sucesso.',
				'unnecessary' => 'Esse endereço de email já foi verificado.',
				'wrong_token' => 'A verificação do endereço de email falhou por causa do token incorreto.',
			),
			'need_to' => 'Para poder utilizar o %s, você deve verificar seu endereço de email.',
			'resend_email' => 'Reenviar o email',
			'title' => 'Validação do endereço de email',
		),
	),
	'mailer' => array(
		'email_need_validation' => array(
			'body' => 'Você se registrou no %s. Mas ainda é necessário verificar seu endereço de email. Para isso, basta seguir o link:',
			'title' => 'Você precisa verificar sua conta',
			'welcome' => 'Bem vindo %s,',
		),
	),
	'password' => array(
		'invalid' => 'Senha incorreta',
	),
	'tos' => array(
		'feedback' => array(
			'invalid' => 'Para se registrar, você deve aceitar os Termos do serviço.',
		),
	),
	'username' => array(
		'invalid' => 'Nome de usuário inválido.',
		'taken' => 'O nome de usuário %s já está sendo utilizado',
	),
);
