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
				'_' => 'Informação do sistema',
				'browser' => 'Navegador',
				'database' => 'Base de dados',
				'server_software' => 'Software do servidor',
				'version_curl' => 'Versão do cURL',
				'version_frss' => 'Versão do FreshRSS',
				'version_php' => 'Versão do PHP',
			),
		),
		'bugs_reports' => 'Reportar erros',
		'documentation' => 'Documentação',
		'freshrss_description' => 'O FreshRSS é um agregador de feeds RSS autoalojado. É leve e fácil de utilizar, sendo simultaneamente uma ferramenta poderosa e configurável.',
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
		'rss_of' => 'Feed RSS de %s',
		'title' => 'Stream principal',
		'title_fav' => 'Favoritos',
		'title_global' => 'Visualização global',
		'userModified' => array(
			'_' => 'Modificado pelo utilizador',
			'today' => 'Modificado pelo utilizador hoje',
			'yesterday' => 'Modificado pelo utilizador ontem',
		),
	),
	'log' => array(
		'_' => 'Logs',	// IGNORE
		'clear' => 'Limpar logs',
		'empty' => 'O ficheiro de log está vazio',
		'title' => 'Logs',	// IGNORE
	),
	'menu' => array(
		'about' => 'Sobre o FreshRSS',
		'before_one_day' => 'Antes de um dia',
		'before_one_week' => 'Antes de uma semana',
		'bookmark_query' => 'Guardar pesquisa atual',
		'favorites' => 'Favoritos (%s)',
		'global_view' => 'Visualização global',
		'important' => 'Feeds importantes',
		'main_stream' => 'Stream principal',
		'mark_all_read' => 'Marcar todos como lidos',
		'mark_cat_read' => 'Marcar categoria como lida',
		'mark_feed_read' => 'Marcar feed como lido',
		'mark_selection_unread' => 'Marcar seleção como não lida',
		'mylabels' => 'Os meus rótulos',
		'non-starred' => 'Mostrar todos, exceto favoritos',
		'normal_view' => 'Visualização normal',
		'queries' => 'Consultas de utilizador',
		'read' => 'Mostrar apenas lidos',
		'reader_view' => 'Visualização de leitura',
		'rss_view' => 'Feed RSS',
		'search_short' => 'Pesquisar',
		'sort' => array(
			'asc' => 'Ascendente',
			'c' => array(
				'name_asc' => 'Categoria, títulos de feeds A→Z',
				'name_desc' => 'Categoria, títulos de feeds Z→A',
			),
			'date_asc' => 'Data de publicação 1→9',
			'date_desc' => 'Data de publicação 9→1',
			'desc' => 'Descendente',
			'f' => array(
				'name_asc' => 'Título do feed A→Z',
				'name_desc' => 'Título do feed Z→A',
			),
			'id_asc' => 'Recebidos recentemente em último',
			'id_desc' => 'Recebidos recentemente em primeiro',
			'length_asc' => 'Tamanho do conteúdo 1→9',
			'length_desc' => 'Tamanho do conteúdo 9→1',
			'link_asc' => 'Link A→Z',	// IGNORE
			'link_desc' => 'Link Z→A',	// IGNORE
			'primary' => array(
				'_' => 'Critério de ordenação',
				'help' => 'Recomenda-se a ordenação por data de <em>receção</em> na maioria dos casos, para consistência e desempenho',
			),
			'rand' => 'Ordem aleatória',
			'secondary' => array(
				'_' => 'Critério de ordenação secundário',
				'help' => 'Apenas relevante quando o critério de ordenação principal são categorias ou títulos de feeds',
			),
			'title_asc' => 'Título A→Z',
			'title_desc' => 'Título Z→A',
			'user_modified_asc' => 'Modificado pelo utilizador 1→9',
			'user_modified_desc' => 'Modificado pelo utilizador 9→1',
		),
		'starred' => 'Mostrar apenas os favoritos',
		'stats' => 'Estatísticas',
		'subscription' => 'Gestão de subscrições',
		'unread' => 'Mostrar apenas os não lidos',
	),
	'share' => 'Partilhar',
	'tag' => array(
		'related' => 'Tags relacionadas',
	),
	'tos' => array(
		'title' => 'Termos de serviço',
	),
);
