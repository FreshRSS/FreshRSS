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
	'about' => array(
		'_' => 'Sobre',
		'agpl3' => '<a href="https://www.gnu.org/licenses/agpl-3.0.html">AGPL 3</a>',	// IGNORE
		'bug_reports' => array(
			'environment_information' => array(
				'_' => 'System information',	// TODO
				'browser' => 'Browser',	// TODO
				'database' => 'Database',	// TODO
				'server_software' => 'Server software',	// TODO
				'version_curl' => 'cURL version',	// TODO
				'version_frss' => 'FreshRSS version',	// TODO
				'version_php' => 'PHP version',	// TODO
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
		'received' => array(
			'before_yesterday' => 'Received before yesterday',	// TODO
			'today' => 'Received today',	// TODO
			'yesterday' => 'Received yesterday',	// TODO
		),
		'rss_of' => 'RSS feed do %s',
		'title' => 'Stream principal',
		'title_fav' => 'Favoritos',
		'title_global' => 'Visualização Global',
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
		'newer_first' => 'Novos primeiro',
		'non-starred' => 'Mostrar todos, exceto favoritos',
		'normal_view' => 'visualização normal',
		'older_first' => 'Antigos primeiro',
		'queries' => 'Queries do usuário',
		'read' => 'Mostrar apenas lidos',
		'reader_view' => 'Visualização de leitura',
		'rss_view' => 'Feed RSS',
		'search_short' => 'Buscar',
		'sort' => array(
			'_' => 'Sorting criteria',	// TODO
			'c' => array(
				'name_asc' => 'Category, feed titles A→Z',	// TODO
				'name_desc' => 'Category, feed titles Z→A',	// TODO
			),
			'date_asc' => 'Publication date 1→9',	// TODO
			'date_desc' => 'Publication date 9→1',	// TODO
			'f' => array(
				'name_asc' => 'Feed title A→Z',	// TODO
				'name_desc' => 'Feed title Z→A',	// TODO
			),
			'id_asc' => 'Freshly received last',	// TODO
			'id_desc' => 'Freshly received first',	// TODO
			'link_asc' => 'Link A→Z',	// TODO
			'link_desc' => 'Link Z→A',	// TODO
			'rand' => 'Random order',	// TODO
			'title_asc' => 'Title A→Z',	// TODO
			'title_desc' => 'Title Z→A',	// TODO
		),
		'starred' => 'Mostrar apenas os favoritos',
		'stats' => 'Estatísticas',
		'subscription' => 'Gerenciamento de inscrições',
		'unread' => 'Mostrar apenas os não lidos',
	),
	'share' => 'Compartilhar',
	'tag' => array(
		'related' => 'Tags relacionadas',
	),
	'tos' => array(
		'title' => 'Termos do serviço',
	),
);
