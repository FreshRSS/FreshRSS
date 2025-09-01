<?php

/******************************************************************************/
/* Each entry of that file can be associated with a comment to indicate its   */
/* state. When there is no comment, it means the entry is fully translated.   */
/* The recognized comments are (comment matching is case-insensitive):        */
/*   + TODO: the entry has never been translated.                             */
/*   + DIRTY: the entry has been translated but needs to be updated.          */
/*   + IGNORE: the entry does not need to be translated.                      */
/* When a comment is not recognized, it is discarded.                         */
/******************************************************************************/

return array(
	'access' => array(
		'denied' => ' não tem permissão para acessar esta página',
		'not_found' => ' está a pesquisar por uma página que não existe',
	),
	'admin' => array(
		'optimization_complete' => 'Otimização Completa',
	),
	'api' => array(
		'password' => array(
			'failed' => 'A senha não pode ser modificada',
			'updated' => 'A senha foi alterada com sucesso',
		),
	),
	'auth' => array(
		'login' => array(
			'invalid' => 'Login está incorreto',
			'success' => ' está ligado',
		),
		'logout' => array(
			'success' => ' está desligado',
		),
	),
	'conf' => array(
		'error' => 'Um erro ocorreu durante o salvamento das configurações',
		'query_created' => 'A Query “%s” foi criada.',
		'shortcuts_updated' => 'Atalhos foram criados',
		'updated' => 'Configuração foi atualizada',
	),
	'extensions' => array(
		'already_enabled' => '%s já está activado',
		'cannot_remove' => '%s não pode ser removido',
		'disable' => array(
			'ko' => '%s não pode ser desactivado. <a href="%s">verifique os logs do FreshRSS</a> para detalhes.',
			'ok' => '%s agora está desactivado',
		),
		'enable' => array(
			'ko' => '%s não pode ser activado. <a href="%s">verifique os logs do FreshRSS</a> para detalhes.',
			'ok' => '%s agora está activado',
		),
		'invalid_view_mode' => 'Invalid view mode “%s”! Fall back to “Normal view”.',	// TODO
		'no_access' => ' não tem acesso ao %s',
		'not_enabled' => '%s não está habilitado',
		'not_found' => '%s não existe',
		'removed' => '%s removido',
	),
	'import_export' => array(
		'export_no_zip_extension' => 'extensão ZIP não está presente em seu servidor. Por favor tente exportar os arquivos um por vez.',
		'feeds_imported' => 'Seus feeds foram importados e serão atualizados pode clicar no butão<i>atualizar feeds</i>.',
		'feeds_imported_with_errors' => 'Seus feeds foram importados, mas alguns erros ocorreram Carregue no butão <i>atualizar feeds</i>.',
		'file_cannot_be_uploaded' => 'Arquivo não pôde ser enviado',
		'no_zip_extension' => 'extensão ZIP não está presente em seu servidor.',
		'zip_error' => 'Um erro ocorreu durante a importação do arquivo ZIP.',
	),
	'profile' => array(
		'error' => 'Seu perfil não pode ser editado',
		'passwords_dont_match' => 'Passwords don’t match',	// TODO
		'updated' => 'Seu perfil foi editado com sucesso',
	),
	'sub' => array(
		'actualize' => 'A atualizar…',
		'articles' => array(
			'marked_read' => 'Os artigos selecionados foram marcados como lidos.',
			'marked_unread' => 'Os artigos foram marcados como não lidos',
		),
		'category' => array(
			'created' => 'Categoria %s foi criada.',
			'deleted' => 'Categoria foi apagada.',
			'emptied' => 'Categoria foi limpa',
			'error' => 'Categoria não pode ser atualizada',
			'name_exists' => 'Este nome de categoria já existe.',
			'no_id' => ' precisa especificar um id para a categoria.',
			'no_name' => 'Nome da categoria não pode ser vazio.',
			'not_delete_default' => ' não pode apagar uma categoria vazia!',
			'not_exist' => 'A categoria não existe!',
			'over_max' => ' atingiu seu limite de categorias (%d)',
			'updated' => 'Categoria foi atualizada.',
		),
		'feed' => array(
			'actualized' => '<em>%s</em> foi atualizado',
			'actualizeds' => 'Os feeds RSS foram atualizados',
			'added' => 'O feed RSS <em>%s</em> foi adicionado',
			'already_subscribed' => ' já está inscrito no <em>%s</em>',
			'cache_cleared' => 'O cache do feed <em>%s</em> foi limpo',
			'deleted' => 'o feed foi apagado',
			'error' => 'O feed não pode ser atualizado',
			'favicon' => array(
				'too_large' => 'Uploaded icon is too large. The maximum file size is <em>%s</em>.',	// TODO
				'unsupported_format' => 'Unsupported image file format!',	// TODO
			),
			'internal_problem' => 'O feed RSS não pôde ser adicionado. <a href="%s">Verifique os logs do FreshRSS</a> para detalhes. Pode forçar a atualização no link <code>#force_feed</code> .',
			'invalid_url' => 'URL <em>%s</em> é inválida',
			'n_actualized' => '%d feeds foram atualizados',
			'n_entries_deleted' => '%d artigos foram apagados',
			'no_refresh' => 'Não há feed para atualizar…',
			'not_added' => '<em>%s</em> não pode ser atualizado',
			'not_found' => 'Não foi possível encontrar o feed',
			'over_max' => ' atingiu seu limite de feeds (%d)',
			'reloaded' => 'O feed <em>%s</em> foi recarregado',
			'selector_preview' => array(
				'http_error' => 'Falha ao carregar o conteúdo do site.',
				'no_entries' => 'Não há nenhuma entrada nesse feed.	precisa de pelo menos um artigo para criar uma pré-visualização',
				'no_feed' => 'Erro interno (nenhum feed para verificar).',
				'no_result' => 'O seletor não teve correspondência. Por isso foi exibido o texto do feed original.',
				'selector_empty' => 'O seletor está vazio.	precisa definir um para criar uma pré-visualização.',
			),
			'updated' => 'Os feeds foram atualizados',
		),
		'purge_completed' => 'Limpeza completa (%d artigos apagados)',
	),
	'tag' => array(
		'created' => 'A Tag “%s” foi criada.',
		'error' => 'Etiqueta não pode ser atualizada!',
		'name_exists' => 'O nome da tag já existe.',
		'renamed' => 'A Tag “%s” foi renomeada para “%s”.',
		'updated' => 'Etiqueta foi atualizada.',
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
			'_' => 'Utilizador %s foi criado',
			'error' => 'Utilizador %s não pode ser criado',
		),
		'deleted' => array(
			'_' => 'Utilizador %s foi deletado',
			'error' => 'Utilizador %s não pode ser deletado',
		),
		'updated' => array(
			'_' => 'O Utilizador %s foi atualizado com sucesso',
			'error' => 'O Utilizador %s não foi atualizado',
		),
	),
);
