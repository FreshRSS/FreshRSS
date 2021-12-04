<?php

return array(
	'access' => array(
		'denied' => 'Você não tem permissão para acessar esta página',
		'not_found' => 'Você está buscando por uma página que não existe',
	),
	'admin' => array(
		'optimization_complete' => 'Otimização Completa',
	),
	'api' => array(
		'password' => array(
			'failed' => 'Sua senha não pode ser modificada',
			'updated' => 'Sua senha foi alterada com sucesso',
		),
	),
	'auth' => array(
		'login' => array(
			'invalid' => 'Login está incorreto',
			'success' => 'Você está conectado',
		),
		'logout' => array(
			'success' => 'Você está desconectado',
		),
	),
	'conf' => array(
		'error' => 'Um erro ocorreu durante o salvamento das configurações',
		'query_created' => 'A query "%s" foi criada.',
		'shortcuts_updated' => 'Atalhos foram criados',
		'updated' => 'Configuração foi atualizada',
	),
	'extensions' => array(
		'already_enabled' => '%s já está habilitado',
		'cannot_remove' => '%s não pode ser removido',
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
		'removed' => '%s removido',
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
		'error' => 'Seu perfil não pode ser editado',
		'updated' => 'Seu perfil foi editado com sucesso',
	),
	'sub' => array(
		'actualize' => 'Atualizando',
		'articles' => array(
			'marked_read' => 'Os artigos selecionados foram marcados como lidos.',
			'marked_unread' => 'Os artigos foram marcados como não lidos',
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
			'actualizeds' => 'Os feeds RSS foram atualizados',
			'added' => 'O feed RSS <em>%s</em> foi adicionado',
			'already_subscribed' => 'Você já está inscrito no <em>%s</em>',
			'cache_cleared' => 'O cache do feed <em>%s</em> foi limpo',
			'deleted' => 'o Feed foi deletado',
			'error' => 'O feed não pode ser atualizado',
			'internal_problem' => 'O feed RSS não pôde ser adicionado. <a href="%s">Verifique os logs do FreshRSS</a> para detalhes. You can try force adding by appending <code>#force_feed</code> to the URL.',
			'invalid_url' => 'URL <em>%s</em> é inválida',
			'n_actualized' => '%d feeds foram atualizados',
			'n_entries_deleted' => '%d artigos foram deletados',
			'no_refresh' => 'Não há feed para atualizar…',
			'not_added' => '<em>%s</em> não pode ser atualizado',
			'not_found' => 'Não foi possível encontrar o feed',
			'over_max' => 'Você atingiu seu limite de feeds (%d)',
			'reloaded' => 'O feed <em>%s</em> foi recarregado',
			'selector_preview' => array(
				'http_error' => 'Falha ao carregar o conteúdo do site.',
				'no_entries' => 'Não há nenhuma entrada nesse feed. Você precisa de pelo menos um artigo para criar uma pré-visualização',
				'no_feed' => 'Erro interno (nenhum feed para verificar).',
				'no_result' => 'O seletor não teve correspondência. Por isso foi exibido o texto do feed original.',
				'selector_empty' => 'O seletor está vazio. Você precisa definir um para criar uma pré-visualização.',
			),
			'updated' => 'Os feeds foram atualizados',
		),
		'purge_completed' => 'Limpeza completa (%d artigos deletados)',
	),
	'tag' => array(
		'created' => 'A tag "%s" foi criada.',
		'name_exists' => 'O nome da tag já existe.',
		'renamed' => 'A tag "%s" foi renomeada para "%s".',
	),
	'update' => array(
		'can_apply' => 'O FreshRSS será atualizado para a <strong>versão %s</strong>.',
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
			'_' => 'O usuário %s foi atualizado com sucesso',
			'error' => 'O usuário %s não foi atualizado',
		),
	),
);
