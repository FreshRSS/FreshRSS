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
	'api' => array(
		'documentation' => 'Copie a seguinte URL para utilizar com uma ferramenta externa',
		'title' => 'API',	// IGNORE
	),
	'bookmarklet' => array(
		'documentation' => 'Arraste este botão para sua barra de favoritos ou clique com o botão direito e escolha "Adicionar este link aos favoritos". Depois clique no no link da barra de favoritos "Inscrever-se" em qualquer página que você queira se inscrever.',
		'label' => 'Inscrever-se',
		'title' => 'Bookmarklet',	// IGNORE
	),
	'category' => array(
		'_' => 'Categoria',
		'add' => 'Adicionar categoria',
		'archiving' => 'Arquivar',
		'empty' => 'Categoria vazia',
		'information' => 'Informações',
		'position' => 'Posição de exibição',
		'position_help' => 'Para controlar a ordem de exibição',
		'title' => 'Título',
	),
	'feed' => array(
		'add' => 'Adicionar um RSS feed',
		'advanced' => 'Avançado',
		'archiving' => 'Arquivar',
		'auth' => array(
			'configuration' => 'Entrar',
			'help' => 'Permite acesso a feeds RSS protegidos por HTTP',
			'http' => 'Autenticação HTTP',
			'password' => 'Senha HTTP',
			'username' => 'Usuário HTTP',
		),
		'clear_cache' => 'Sempre limpar o cache',
		'content_action' => array(
			'_' => 'Ações ao buscar pelo conteúdo de artigos',
			'append' => 'Adicionar depois conteúdo existente',
			'prepend' => 'Adicionar antes do conteúdo existente',
			'replace' => 'Substituir o conteúdo existente',
		),
		'css_cookie' => 'Usar cookies ao buscar pelo conteúdo de artigos',
		'css_cookie_help' => 'Exemplo: <kbd>foo=bar; gdpr_consent=true; cookie=value</kbd>',
		'css_help' => 'Retorna RSS feeds truncados (atenção, requer mais tempo!)',
		'css_path' => 'Caminho do CSS do artigo no site original',
		'description' => 'Descrição',
		'empty' => 'Este feed está vazio. Por favor verifique ele ainda é mantido.',
		'error' => 'Este feed encontra-se com problema. Por favor verifique se ele ainda está disponível e atualize-o.',
		'filteractions' => array(
			'_' => 'Ações do filtro',
			'help' => 'Escreva um filtro de pesquisa por linha.',
		),
		'information' => 'Informações',
		'keep_min' => 'Número mínimo de artigos para manter',
		'kind' => array(
			'_' => 'Type of feed source',	// TODO
			'html_xpath' => array(
				'_' => 'HTML + XPath (Web scraping)',	// TODO
				'feed_title' => array(
					'_' => 'feed title',	// TODO
					'help' => 'Example: <code>//title</code>',	// TODO
				),
				'help' => '<dfn><a href="https://www.w3.org/TR/xpath-10/">XPath 1.0</a></dfn> is a standard query language for advanced users, and which FreshRSS supports to enable Web scraping.',	// TODO
				'item' => array(
					'_' => 'finding news <strong>items</strong><br /><small>(most important)</small>',	// TODO
					'help' => 'Example: <code>//li[@class="news-item"]</code>',	// TODO
				),
				'item_author' => array(
					'_' => 'item author',	// TODO
					'help' => 'Can also be a static string. Example: <code>"Anonymous"</code>',	// TODO
				),
				'item_categories' => 'items tags',	// TODO
				'item_content' => array(
					'_' => 'item content',	// TODO
					'help' => 'Example: <code>descendant::span[@class="summary"]</code>',	// TODO
				),
				'item_thumbnail' => array(
					'_' => 'item thumbnail',	// TODO
					'help' => 'Example: <code>descendant::img/@src</code>',	// TODO
				),
				'item_timestamp' => array(
					'_' => 'item date',	// TODO
					'help' => 'The result will be parsed by <a href="https://php.net/strtotime"><code>strtotime()</code></a>',	// TODO
				),
				'item_title' => array(
					'_' => 'item title',	// TODO
					'help' => 'Use in particular the <a href="https://developer.mozilla.org/docs/Web/XPath/Axes">XPath axis</a> <code>descendant::</code>',	// TODO
				),
				'item_uri' => array(
					'_' => 'item link (URL)',	// TODO
					'help' => 'Example: <code>descendant::a/@href</code>',	// TODO
				),
				'relative' => 'XPath (relative to item) for:',	// TODO
				'xpath' => 'XPath for:',	// TODO
			),
			'rss' => 'RSS / Atom (default)',	// TODO
		),
		'maintenance' => array(
			'clear_cache' => 'Limpar o cache',
			'clear_cache_help' => 'Limpar o cache em disco deste feed',
			'reload_articles' => 'Recarregar artigos',
			'reload_articles_help' => 'Recarregar artigos e buscar conteúdo completo',
			'title' => 'Manutenção',
		),
		'moved_category_deleted' => 'Quando você deleta uma categoria, seus feeds são automaticamente classificados como <em>%s</em>.',
		'mute' => 'silenciar',
		'no_selected' => 'Nenhum feed selecionado.',
		'number_entries' => '%d artigos',
		'priority' => array(
			'_' => 'Visibilidade',
			'archived' => 'Não exibir (arquivado)',
			'main_stream' => 'Mostrar na tela principal',
			'normal' => 'Mostrar na sua categoria',
		),
		'proxy' => 'Defina um proxy para buscar esse feed',
		'proxy_help' => 'Selecione um protocolo (e.g: SOCKS5) e digite o endereço do proxy (e.g: <kbd>127.0.0.1:1080</kbd>)',
		'selector_preview' => array(
			'show_raw' => 'Mostrar fonte',
			'show_rendered' => 'Mostrar conteúdo',
		),
		'show' => array(
			'all' => 'Mostrar todos os Feeds',
			'error' => 'Somente mostrar Feeds com erros',
		),
		'showing' => array(
			'error' => 'Exibir apenas os feeds com erros',
		),
		'ssl_verify' => 'Verificar segurança SSL',
		'stats' => 'Estatísticas',
		'think_to_add' => 'Você deve adicionar alguns feeds.',
		'timeout' => 'Timeout em segundos',
		'title' => 'Título',
		'title_add' => 'Adicionar o RSS feed',
		'ttl' => 'Não atualize automaticamente mais que',
		'url' => 'URL do Feed',
		'useragent' => 'Defina um usuário para buscar este feed',
		'useragent_help' => 'Exemplo: <kbd>Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:86.0)</kbd>',
		'validator' => 'Verifique a validade do feed',
		'website' => 'URL do site',
		'websub' => 'Notificação instantânea com WebSub',
	),
	'import_export' => array(
		'export' => 'Exportar',
		'export_labelled' => 'Exportar seus artigos etiquetados',
		'export_opml' => 'Exporta a lista dos feeds (OPML)',
		'export_starred' => 'Exportar seus favoritos',
		'feed_list' => 'Lista dos %s artigos',
		'file_to_import' => 'Arquivo para importar<br />(OPML, JSON or ZIP)',
		'file_to_import_no_zip' => 'Arquivo para importar<br />(OPML or JSON)',
		'import' => 'Importar',
		'starred_list' => 'Listar artigos favoritos',
		'title' => 'Importar / exportar',
	),
	'menu' => array(
		'add' => 'Adicionar um feed ou categoria',
		'import_export' => 'Importar / exportar',
		'label_management' => 'Gerenciar etiquetas',
		'stats' => array(
			'idle' => 'Feeds inativos',
			'main' => 'Estatísticas principais',
			'repartition' => 'Repartição de artigos',
		),
		'subscription_management' => 'Gerenciamento de inscrições',
		'subscription_tools' => 'Ferramentas de inscrição',
	),
	'tag' => array(
		'name' => 'Nome',
		'new_name' => 'Nome novo',
		'old_name' => 'Nome antigo',
	),
	'title' => array(
		'_' => 'Gerenciamento de inscrições',
		'add' => 'Adicionar um feed ou categoria',
		'add_category' => 'Adicionar uma categoria',
		'add_feed' => 'Adicionar um feed',
		'add_label' => 'Adicionar uma etiqueta',
		'delete_label' => 'Deletar uma etiqueta',
		'feed_management' => 'Gerenciamento dos RSS feeds',
		'rename_label' => 'Renomear uma etiqueta',
		'subscription_tools' => 'Ferramentas de inscrição',
	),
);
