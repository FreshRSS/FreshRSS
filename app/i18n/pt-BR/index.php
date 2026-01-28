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
	'about' => array(
		'_' => 'Sobre',
		'agpl3' => '<a href="https://www.gnu.org/licenses/agpl-3.0.html">AGPL 3</a>',	// IGNORE
		'bug_reports' => array(
			'environment_information' => array(
				'_' => 'Informações do sistema',
				'browser' => 'Navegador',
				'database' => 'Banco de dados',
				'server_software' => 'Software do servidor',
				'version_curl' => 'Versão do cURL',
				'version_frss' => 'Versão do FreshRSS',
				'version_php' => 'Versão do PHP',
			),
		),
		'bugs_reports' => 'Reportar Bugs',
		'documentation' => 'Documentação',
		'freshrss_description' => 'FreshRSS é um RSS feeds aggregator para um host próprio. É leve e fácil de utilizar enquanto é uma ferramenta poderosa e configurável. ',
		'github' => '<a href="https://github.com/FreshRSS/FreshRSS/issues">no GitHub</a>',
		'license' => 'licença',
		'project_website' => 'Site do projeto',
		'title' => 'Sobre',
		'version' => 'Versão',
	),
	'feed' => array(
		'empty' => 'Não há nenhum artigo para mostrar.',
		'published' => array(
			'_' => 'Publicado',
			'future' => 'Publicado no futuro',
			'today' => 'Publicado hoje',
			'yesterday' => 'Publicado ontem',
		),
		'received' => array(
			'_' => 'Recebido',
			'today' => 'Recebido hoje',
			'yesterday' => 'Recebido ontem',
		),
		'rss_of' => 'RSS feed do %s',
		'title' => 'Stream principal',
		'title_fav' => 'Favoritos',
		'title_global' => 'Visualização Global',
		'userModified' => array(
			'_' => 'Modificado pelo usuário',
			'today' => 'Modificado pelo usuário hoje',
			'yesterday' => 'Modificado pelo usuário ontem',
		),
	),
	'log' => array(
		'_' => 'Logs',	// IGNORE
		'clear' => 'Limpar logs',
		'empty' => 'Arquivo de log está vazio',
		'title' => 'Logs',	// IGNORE
	),
	'menu' => array(
		'about' => 'Sobre o FreshRSS',
		'before_one_day' => 'Antes de um dia',
		'before_one_week' => 'Antes de uma semana',
		'bookmark_query' => 'Salvar pesquisa atual',
		'favorites' => 'Favoritos (%s)',
		'global_view' => 'Visualização global',
		'important' => 'Feeds importantes',
		'main_stream' => 'Stream principal',
		'mark_all_read' => 'Marcar todos como lidos',
		'mark_cat_read' => 'Marcar categoria como lida',
		'mark_feed_read' => 'Marcar feed com lido',
		'mark_selection_unread' => 'Marcar seleção como não lida',
		'mylabels' => 'Minhas etiquetas',
		'non-starred' => 'Mostrar itens que não são favoritos',
		'normal_view' => 'visualização normal',
		'queries' => 'Queries do usuário',
		'read' => 'Mostrar leitura',
		'reader_view' => 'Visualização de leitura',
		'rss_view' => 'Feed RSS',
		'search_short' => 'Buscar',
		'sort' => array(
			'asc' => 'Ascending',	// TODO
			'c' => array(
				'name_asc' => 'Categoria, títulos dos feeds A→Z',
				'name_desc' => 'Categoria, títulos dos feeds Z→A',
			),
			'date_asc' => 'Data de publicação 1→9',
			'date_desc' => 'Data de publicação 9→1',
			'desc' => 'Descending',	// TODO
			'f' => array(
				'name_asc' => 'Título do feed A→Z',
				'name_desc' => 'Título do feed Z→A',
			),
			'id_asc' => 'Recebido recentemente por último',
			'id_desc' => 'Recebido recentemente primeiro',
			'length_asc' => 'Comprimento do conteúdo 1→9',
			'length_desc' => 'Comprimento do conteúdo 9→1',
			'link_asc' => 'Link A→Z',	// IGNORE
			'link_desc' => 'Link Z→A',	// IGNORE
			'primary' => array(
				'_' => 'Sorting criterion',	// TODO
				'help' => 'Sorting by <em>received</em> date is recommended in most cases, for consistency and performance',	// TODO
			),
			'rand' => 'Ordem aleatória',
			'secondary' => array(
				'_' => 'Secondary sorting criterion',	// TODO
				'help' => 'Only relevant when the primary sorting criterion is categories or feeds titles',	// TODO
			),
			'title_asc' => 'Título A→Z',
			'title_desc' => 'Título Z→A',
			'user_modified_asc' => 'Modificado pelo usuário 1→9',
			'user_modified_desc' => 'Modificado pelo usuário 9→1',
		),
		'starred' => 'Mostrar favoritos',
		'stats' => 'Estatísticas',
		'subscription' => 'Gerenciamento de inscrições',
		'unread' => 'Mostrar não lido',
	),
	'share' => 'Compartilhar',
	'tag' => array(
		'related' => 'Tags relacionadas',
	),
	'tos' => array(
		'title' => 'Termos do serviço',
	),
);
