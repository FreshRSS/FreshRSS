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
		'denied' => ' não tem permissão para aceder a esta página',
		'not_found' => ' está a procurar por uma página que não existe',
	),
	'admin' => array(
		'optimization_complete' => 'Otimização Completa',
	),
	'api' => array(
		'password' => array(
			'failed' => 'A palavra-passe não pode ser modificada',
			'updated' => 'A palavra-passe foi alterada com sucesso',
		),
	),
	'auth' => array(
		'login' => array(
			'invalid' => 'O início de sessão está incorreto',
			'success' => ' está ligado',
		),
		'logout' => array(
			'success' => ' está desligado',
		),
	),
	'conf' => array(
		'error' => 'Ocorreu um erro ao guardar a configuração',
		'query_created' => 'A Query “%s” foi criada.',
		'shortcuts_updated' => 'Os atalhos foram criados',
		'updated' => 'A configuração foi atualizada',
	),
	'extensions' => array(
		'already_enabled' => '%s já está ativado',
		'cannot_remove' => '%s não pode ser removido',
		'disable' => array(
			'ko' => '%s não pode ser desativado. <a href="%s">verifique os registos do FreshRSS</a> para detalhes.',
			'ok' => '%s agora está desativado',
		),
		'enable' => array(
			'ko' => '%s não pode ser ativado. <a href="%s">verifique os registos do FreshRSS</a> para detalhes.',
			'ok' => '%s agora está ativado',
		),
		'invalid_view_mode' => 'Modo de visualização inválido “%s”! A reverter para “Visualização normal”.',
		'no_access' => ' não tem acesso a %s',
		'not_enabled' => '%s não está habilitado',
		'not_found' => '%s não existe',
		'removed' => '%s removido',
	),
	'import_export' => array(
		'export_no_zip_extension' => 'a extensão ZIP não está presente no seu servidor. Por favor, tente exportar os ficheiros um a um.',
		'feeds_imported' => 'Os seus feeds foram importados e serão atualizados, pode clicar no botão <i>atualizar feeds</i>.',
		'feeds_imported_with_errors' => 'Os seus feeds foram importados, mas ocorreram alguns erros. Clique no botão <i>atualizar feeds</i>.',
		'file_cannot_be_uploaded' => 'O ficheiro não pôde ser enviado',
		'no_zip_extension' => 'a extensão ZIP não está presente no seu servidor.',
		'zip_error' => 'Ocorreu um erro durante a importação do ficheiro ZIP.',
	),
	'profile' => array(
		'error' => 'O seu perfil não pode ser editado',
		'passwords_dont_match' => 'As palavras-passe não coincidem',
		'updated' => 'O seu perfil foi editado com sucesso',
	),
	'sub' => array(
		'actualize' => 'A atualizar…',
		'articles' => array(
			'marked_read' => 'Os artigos selecionados foram marcados como lidos.',
			'marked_unread' => 'Os artigos foram marcados como não lidos',
		),
		'category' => array(
			'created' => 'A categoria %s foi criada.',
			'deleted' => 'A categoria foi apagada.',
			'emptied' => 'A categoria foi limpa',
			'error' => 'A categoria não pode ser atualizada',
			'name_exists' => 'Este nome de categoria já existe.',
			'no_id' => ' precisa de especificar um id para a categoria.',
			'no_name' => 'O nome da categoria não pode estar vazio.',
			'not_delete_default' => ' não pode apagar uma categoria predefinida!',
			'not_exist' => 'A categoria não existe!',
			'over_max' => ' atingiu o seu limite de categorias (%d)',
			'updated' => 'A categoria foi atualizada.',
		),
		'feed' => array(
			'actualized' => '<em>%s</em> foi atualizado',
			'actualizeds' => 'Os feeds RSS foram atualizados',
			'added' => 'O feed RSS <em>%s</em> foi adicionado',
			'already_subscribed' => ' já está inscrito em <em>%s</em>',
			'cache_cleared' => 'A cache do feed <em>%s</em> foi limpa',
			'deleted' => 'O feed foi apagado',
			'error' => 'O feed não pode ser atualizado',
			'favicon' => array(
				'too_large' => 'O ícone enviado é demasiado grande. O tamanho máximo do ficheiro é <em>%s</em>.',
				'unsupported_format' => 'Formato de ficheiro de imagem não suportado!',
			),
			'internal_problem' => 'O feed RSS não pôde ser adicionado. <a href="%s">Verifique os registos do FreshRSS</a> para detalhes. Pode forçar a atualização no link <code>#force_feed</code>.',
			'invalid_url' => 'O URL <em>%s</em> é inválido',
			'n_actualized' => '%d feeds foram atualizados',
			'n_entries_deleted' => '%d artigos foram apagados',
			'no_refresh' => 'Não há feeds para atualizar…',
			'not_added' => '<em>%s</em> não pode ser atualizado',
			'not_found' => 'Não foi possível encontrar o feed',
			'over_max' => ' atingiu o seu limite de feeds (%d)',
			'reloaded' => 'O feed <em>%s</em> foi recarregado',
			'selector_preview' => array(
				'http_error' => 'Falha ao carregar o conteúdo do site.',
				'no_entries' => 'Não há nenhuma entrada nesse feed. Precisa de pelo menos um artigo para criar uma pré-visualização',
				'no_feed' => 'Erro interno (nenhum feed para verificar).',
				'no_result' => 'O seletor não teve correspondência. Por isso, foi exibido o texto do feed original.',
				'selector_empty' => 'O seletor está vazio. Precisa de definir um para criar uma pré-visualização.',
			),
			'updated' => 'Os feeds foram atualizados',
		),
		'purge_completed' => 'Limpeza completa (%d artigos apagados)',
	),
	'tag' => array(
		'created' => 'A Tag “%s” foi criada.',
		'error' => 'A etiqueta não pode ser atualizada!',
		'name_exists' => 'O nome da tag já existe.',
		'renamed' => 'A Tag “%s” foi renomeada para “%s”.',
		'updated' => 'A etiqueta foi atualizada.',
	),
	'update' => array(
		'can_apply' => 'O FreshRSS será atualizado para a <strong>versão %s</strong>.',
		'error' => 'O processo de atualização encontrou um erro: %s',
		'file_is_nok' => 'Nova <strong>versão %s</strong> disponível, mas verifique as permissões no diretório <em>%s</em>. O servidor HTTP deve ter direitos de escrita',
		'finished' => 'Atualização completa!',
		'none' => 'Nenhuma atualização para aplicar',
		'server_not_found' => 'O servidor de atualização não pôde ser localizado. [%s]',
	),
	'user' => array(
		'created' => array(
			'_' => 'O utilizador %s foi criado',
			'error' => 'O utilizador %s não pode ser criado',
		),
		'deleted' => array(
			'_' => 'O utilizador %s foi apagado',
			'error' => 'O utilizador %s não pode ser apagado',
		),
		'updated' => array(
			'_' => 'O utilizador %s foi atualizado com sucesso',
			'error' => 'O utilizador %s não foi atualizado',
		),
	),
);
