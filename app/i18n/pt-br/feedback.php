<?php

return array(
	'access' => array(
		'denied' => 'Você não tem permissão para acessar esta página',
		'not_found' => 'VocÊ está buscando por uma página que não existe',
	),
	'admin' => array(
		'optimization_complete' => 'Otimização Completa',
	),
	'api' => array(
		'password' => array(
			'failed' => 'Your password cannot be modified',	// TODO - Translation
			'updated' => 'Your password has been modified',	// TODO - Translation
		),
	),
	'auth' => array(
		'form' => array(
			'not_set' => 'Um problema ocorreu durante o sistema de configuração para autenticação. Por favor tente mais tarde.',
			'set' => 'Formulário é agora seu sistema de autenticação padrão.',
		),
		'login' => array(
			'invalid' => 'Login está incorreto',
			'success' => 'Vocé está conectado',
		),
		'logout' => array(
			'success' => 'Você está desconectado',
		),
		'no_password_set' => 'A senha do administrador não foi definida. Este recurso não está disponível.',
	),
	'conf' => array(
		'error' => 'Um erro ocorreu durante o salvamento das configurações',
		'query_created' => 'Query "%s" foi criada.',
		'shortcuts_updated' => 'Atalhos foram criados',
		'updated' => 'Configuração foi atualizada',
	),
	'extensions' => array(
		'already_enabled' => '%s já está habilitado',
		'disable' => array(
			'ko' => '%s não pode ser desabilitado. <a href="%s">verifique os logs do FreshRSS</a> para detalhes.',
			'ok' => '%s agora está desabilitado',
		),
		'enable' => array(
			'ko' => '%s não pode ser habilitado. <a href="%s">verifique os logs do FreshRSS</a> para detalhes.',
			'ok' => '%s agora está habilitado',
		),
		'not_enabled' => '%s não está habilitado',
		'not_found' => '%s não existe',
		'no_access' => 'Você não tem acesso ao %s',
	),
	'import_export' => array(
		'export_no_zip_extension' => 'extensão ZIP não está presente em seu servidor. Por favor tente exportar os arquivos um por vez.',
		'feeds_imported' => 'Seus feeds foram importados e serão atualizados agora',
		'feeds_imported_with_errors' => 'Seus feeds foram importados, mas alguns erros ocorreram',
		'file_cannot_be_uploaded' => 'Arquivo não pôde ser enviado',
		'no_zip_extension' => 'extensão ZIP não está presente em seu servidor.',
		'zip_error' => 'Um erro ocorreu durante a importação do arquivo ZIP.',
	),
	'profile' => array(
		'error' => 'Your profile cannot be modified',	// TODO - Translation
		'updated' => 'Your profile has been modified',	// TODO - Translation
	),
	'sub' => array(
		'actualize' => 'Atualizando',
		'articles' => array(
			'marked_read' => 'The selected articles have been marked as read.',	// TODO - Translation
			'marked_unread' => 'The articles have been marked as unread.',	// TODO - Translation
		),
		'category' => array(
			'created' => 'Categoria %s foi criada.',
			'deleted' => 'Categoria foi deletada.',
			'emptied' => 'Categoria foi esvaziada',
			'error' => 'Categoria não pode ser atualizada',
			'name_exists' => 'Este nome de categoria já existe.',
			'not_delete_default' => 'Você não pode deletar uma categoria vazia!',
			'not_exist' => 'A categoria não existe!',
			'no_id' => 'Você precisa especificar um id para a categoria.',
			'no_name' => 'Nome da categoria não pode ser vazio.',
			'over_max' => 'Você atingiu seu limite de categorias (%d)',
			'updated' => 'Categoria foi atualizada.',
		),
		'feed' => array(
			'actualized' => '<em>%s</em> foi atualizado',
			'actualizeds' => 'RSS feeds foi atualizado',
			'added' => 'RSS feed <em>%s</em> foi adicionado',
			'already_subscribed' => 'Você já está inscrito no <em>%s</em>',
			'cache_cleared' => '<em>%s</em> cache has been cleared',	// TODO - Translation
			'deleted' => 'o Feed foi deletado',
			'error' => 'O feed não pode ser atualizado',
			'internal_problem' => 'O RSS feed não pôde ser adicionado. <a href="%s">Verifique os FreshRSS logs</a> para detalhes.',
			'invalid_url' => 'URL <em>%s</em> é inválida',
			'not_added' => '<em>%s</em> não pode ser atualizado',
			'not_found' => 'Feed cannot be found',	// TODO - Translation
			'no_refresh' => 'Não há feed para atualizar…',
			'n_actualized' => '%d feeds foram atualizados',
			'n_entries_deleted' => '%d artigos foram deletados',
			'over_max' => 'Você atingiu seu limite de feeds (%d)',
			'reloaded' => '<em>%s</em> has been reloaded',	// TODO - Translation
			'selector_preview' => array(
				'http_error' => 'Failed to load website content.',	// TODO - Translation
				'no_entries' => 'There is no entries in your feed. You need at least one entry to create a preview.',	// TODO - Translation
				'no_feed' => 'Internal error (no feed to entry).',	// TODO - Translation
				'no_result' => 'The selector didn\'t match anything. As a fallback the original feed text will be displayed instead.',	// TODO - Translation
				'selector_empty' => 'The selector is empty. You need to define one to create a preview.',	// TODO - Translation
			),
			'updated' => 'Feed foram atualizados',
		),
		'purge_completed' => 'Limpeza completa (%d artigos deletados)',
	),
	'update' => array(
		'can_apply' => 'FreshRSS será atualizado para a <strong>versão %s</strong>.',
		'error' => 'O processo de atualização encontrou um erro: %s',
		'file_is_nok' => 'Nova <strong>versão %s</strong> disponível, mas verifique as permissões no diretório <em>%s</em>. Servidor HTTP deve ter direitos para escrever dentro',
		'finished' => 'Atualização completa!',
		'none' => 'Nenhuma atualização para aplicar',
		'server_not_found' => 'Servidor de atualização não pôde ser localizado. [%s]',
	),
	'user' => array(
		'created' => array(
			'error' => 'Usuário %s não pode ser criado',
			'_' => 'Usuário %s foi criado',
		),
		'deleted' => array(
			'error' => 'Usuário %s não pode ser deletado',
			'_' => 'Usuário %s foi deletado',
		),
		'updated' => array(
			'error' => 'User %s has not been updated',	// TODO - Translation
			'_' => 'User %s has been updated',	// TODO - Translation
		),
	),
);
