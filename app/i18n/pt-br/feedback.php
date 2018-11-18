<?php

return array(
	'admin' => array(
		'optimization_complete' => 'Otimização Completa',
	),
	'access' => array(
		'denied' => 'Você não tem permissão para acessar esta página',
		'not_found' => 'VocÊ está buscando por uma página que não existe',
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
		'no_access' => 'Você não tem acesso ao %s',
		'not_enabled' => '%s não está habilitado',
		'not_found' => '%s não existe',
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
		'error' => 'Your profile cannot be modified',
		'updated' => 'Your profile has been modified',
	),
	'sub' => array(
		'actualize' => 'Atualizando',
		'articles' => array(
			'marked_read' => 'The selected articles have been marked as read.',	//TODO - Translation
			'marked_unread' => 'The articles have been marked as unread.',	//TODO - Translation
		),
		'category' => array(
			'created' => 'Categoria %s foi criada.',
			'deleted' => 'Categoria foi deletada.',
			'emptied' => 'Categoria foi esvaziada',
			'error' => 'Categoria não pode ser atualizada',
			'name_exists' => 'Este nome de categoria já existe.',
			'no_id' => 'Você precisa especificar um id para a categoria.',
			'no_name' => 'Nome da categoria não pode ser vazio.',
			'not_delete_default' => 'Você não pode deletar uma categoria vazia!',
			'not_exist' => 'A categoria não existe!',
			'over_max' => 'Você atingiu seu limite de categorias (%d)',
			'updated' => 'Categoria foi atualizada.',
		),
		'feed' => array(
			'actualized' => '<em>%s</em> foi atualizado',
			'actualizeds' => 'RSS feeds foi atualizado',
			'added' => 'RSS feed <em>%s</em> foi adicionado',
			'already_subscribed' => 'Você já está inscrito no <em>%s</em>',
			'deleted' => 'o Feed foi deletado',
			'error' => 'O feed não pode ser atualizado',
			'internal_problem' => 'O RSS feed não pôde ser adicionado. <a href="%s">Verifique os FreshRSS logs</a> para detalhes.',	//TODO - Translation
			'invalid_url' => 'URL <em>%s</em> é inválida',
			'n_actualized' => '%d feeds foram atualizados',
			'n_entries_deleted' => '%d artigos foram deletados',
			'no_refresh' => 'Não há feed para atualizar…',
			'not_added' => '<em>%s</em> não pode ser atualizado',
			'over_max' => 'Você atingiu seu limite de feeds (%d)',
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
			'_' => 'Usuário %s foi criado',
			'error' => 'Usuário %s não pode ser criado',
		),
		'deleted' => array(
			'_' => 'Usuário %s foi deletado',
			'error' => 'Usuário %s não pode ser deletado',
		),
		'updated' => array(
			'_' => 'User %s has been updated',	//TODO - Translation
			'error' => 'User %s has not been updated',	//TODO - Translation
		),
	),
);
