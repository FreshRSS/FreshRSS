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
		'documentation' => 'Arraste este botão para sua barra de favoritos ou clique com o botão direito e escolha “Adicionar este link aos favoritos”. Depois clique no no link da barra de favoritos “Inscrever-se” em qualquer página que você queira se inscrever.',
		'label' => 'Inscrever-se',
		'title' => 'Bookmarklet',	// IGNORE
	),
	'category' => array(
		'_' => 'Categoria',
		'add' => 'Adicionar categoria',
		'archiving' => 'Arquivar',
		'dynamic_opml' => array(
			'_' => 'OPML Dinâmico',
			'help' => 'Forneça uma URL para <a href="http://opml.org/" target="_blank">o arquivo OPML </a> para preencher dinamicamente esta categoria com feeds',
		),
		'empty' => 'Categoria vazia',
		'information' => 'Informações',
		'opml_url' => 'URL de OPML',
		'position' => 'Posição de exibição',
		'position_help' => 'Para controlar a ordem de exibição',
		'title' => 'Título',
	),
	'feed' => array(
		'accept_cookies' => 'Aceitar cookies',
		'accept_cookies_help' => 'Permitir que o servidor de Feed defina os cookies (sarmazenados na memória apenas durante a solicitação)',
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
		'css_path_filter' => array(
			'_' => 'Seletor CSS dos elementos a serem removidos',
			'help' => 'O seletor CSS pode ser uma lista com: <kbd>.footer, .aside</kbd>',
		),
		'description' => 'Descrição',
		'empty' => 'Este feed está vazio. Por favor verifique ele ainda é mantido.',
		'error' => 'Este feed encontra-se com problema. Por favor verifique se ele ainda está disponível e atualize-o.',
		'export-as-opml' => array(
			'download' => 'Download',	// IGNORE
			'help' => 'Arquivo XML (data subset. <a href="https://freshrss.github.io/FreshRSS/en/developers/OPML.html" target="_blank">See documentation</a>)',	// DIRTY
			'label' => 'Exportar como OPML',
		),
		'filteractions' => array(
			'_' => 'Ações do filtro',
			'help' => 'Escreva um filtro de pesquisa por linha. Operators <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">see documentation</a>.',	// DIRTY
		),
		'information' => 'Informações',
		'keep_min' => 'Número mínimo de artigos para manter',
		'kind' => array(
			'_' => 'Tipo de fonte de alimentação do Feed',
			'html_xpath' => array(
				'_' => 'HTML + XPath (Web scraping)',	// IGNORE
				'feed_title' => array(
					'_' => 'Título do Feed',
					'help' => 'Exemplo: <code>//title</code> ou uma string estática: <code>"Meu feed customizado"</code>',
				),
				'help' => '<dfn><a href="https://www.w3.org/TR/xpath-10/" target="_blank">XPath 1.0</a></dfn>é uma linguagem de consulta padrão para usuários avançados e que o FreshRSS suporta para habilitar o Web scraping.',
				'item' => array(
					'_' => 'encontrar notícias <strong>items</strong><br /><small>(mais importantes)</small>',
					'help' => 'Exemplo: <code>//div[@class="news-item"]</code>',
				),
				'item_author' => array(
					'_' => 'Autor do item',
					'help' => 'Também pode ser uma string estática. Exemplo: <code>"Anônimo"</code>',
				),
				'item_categories' => 'Etiquetas do item',
				'item_content' => array(
					'_' => 'Conteúdo do item',
					'help' => 'Exemplo para pegar o item completo: <code>.</code>',
				),
				'item_thumbnail' => array(
					'_' => 'Miniatura do item',
					'help' => 'Exemplo: <code>descendant::img/@src</code>',
				),
				'item_timeFormat' => array(
					'_' => 'Custom date/time format',	// TODO
					'help' => 'Optional. A format supported by <a href="https://php.net/datetime.createfromformat" target="_blank"><code>DateTime::createFromFormat()</code></a> such as <code>d-m-Y H:i:s</code>',	// TODO
				),
				'item_timestamp' => array(
					'_' => 'Data do Item',
					'help' => 'O resultado será parecido com: <a href="https://php.net/strtotime" target="_blank"><code>strtotime()</code></a>',
				),
				'item_title' => array(
					'_' => 'Titulo do Item',
					'help' => 'Utilize especialmente <a href="https://developer.mozilla.org/docs/Web/XPath/Axes" target="_blank">XPath axis</a> <code>descendant::</code> like <code>descendant::h2</code>',
				),
				'item_uid' => array(
					'_' => 'ID único do item',
					'help' => 'Opcional. Exemplo: <code>descendant::div/@data-uri</code>',
				),
				'item_uri' => array(
					'_' => 'Link do item (URL)',
					'help' => 'Exemplo: <code>descendant::a/@href</code>',
				),
				'relative' => 'XPath (relativo do item) para:',
				'xpath' => 'XPath para:',
			),
			'json_dotnotation' => array(
				'_' => 'JSON (notação de ponto)',
				'feed_title' => array(
					'_' => 'título do feed',
					'help' => 'Exemplo: <code>meta.title</code> ou uma string estática: <code>"Meu feed customizado"</code>',
				),
				'help' => 'Um JSON na notação de ponto usa pontos entre os objetos e colchetes para arrays (e.g. <code>data.items[0].title</code>)',
				'item' => array(
					'_' => 'encontrando novidades <strong>itens</strong><br /><small>(mais importante)</small>',
					'help' => 'Caminho do JSON para o array contendo os itens, e.g. <code>newsItems</code>',
				),
				'item_author' => 'autor do item',
				'item_categories' => 'tags dos itens',
				'item_content' => array(
					'_' => 'conteúdo do item',
					'help' => 'Chave sob na qual o conteúdo é encontrado, e.g. <code>content</code>',
				),
				'item_thumbnail' => array(
					'_' => 'miniatura do item',
					'help' => 'Exemplo: <code>image</code>',
				),
				'item_timeFormat' => array(
					'_' => 'Formato de data/hora customizado',
					'help' => 'Opcional. Um formato suportado por <a href="https://php.net/datetime.createfromformat" target="_blank"><code>DateTime::createFromFormat()</code></a> assim como <code>d-m-Y H:i:s</code>',
				),
				'item_timestamp' => array(
					'_' => 'data do item',
					'help' => 'The result will be parsed by <a href="https://php.net/strtotime" target="_blank"><code>strtotime()</code></a>',	// TODO
				),
				'item_title' => 'título do item',
				'item_uid' => 'ID único do item',
				'item_uri' => array(
					'_' => 'Link do item (URL)',
					'help' => 'Exemplo: <code>permalink</code>',
				),
				'json' => 'notação de ponto para:',
				'relative' => 'notação de ponto (relativa ao item) para:',
			),
			'jsonfeed' => 'JSON Feed',	// IGNORE
			'rss' => 'RSS / Atom (padrão)',
			'xml_xpath' => 'XML + XPath',	// IGNORE
		),
		'maintenance' => array(
			'clear_cache' => 'Limpar o cache',
			'clear_cache_help' => 'Limpar o cache em disco deste feed',
			'reload_articles' => 'Recarregar artigos',
			'reload_articles_help' => 'Recarregar artigos e buscar conteúdo completo',
			'title' => 'Manutenção',
		),
		'max_http_redir' => 'Quantidade máxima de redirecionamentos HTTP',
		'max_http_redir_help' => 'Defina como 0 ou deixe em branco para desabilitar, -1 para redirecionamentos ilimitados',
		'method' => array(
			'_' => 'Método HTTP',
		),
		'method_help' => 'O conteúdo do POST tem suporte automático para <code>application/x-www-form-urlencoded</code> e <code>application/json</code>',
		'method_postparams' => 'Conteúdo do POST',
		'moved_category_deleted' => 'Quando você deleta uma categoria, seus feeds são automaticamente classificados como <em>%s</em>.',
		'mute' => 'silenciar',
		'no_selected' => 'Nenhum feed selecionado.',
		'number_entries' => '%d artigos',
		'priority' => array(
			'_' => 'Visibilidade',
			'archived' => 'Não exibir (arquivado)',
			'category' => 'Mostrar na sua categoria',
			'important' => 'Mostrar feeds importantes',
			'main_stream' => 'Mostrar na tela principal',
		),
		'proxy' => 'Defina um proxy para buscar esse feed',
		'proxy_help' => 'Selecione um protocolo (e.g: SOCKS5) e digite o endereço do proxy (e.g: <kbd>127.0.0.1:1080</kbd> or <kbd>username:password@127.0.0.1:1080</kbd>)',
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
		'auto_label' => 'Adicione esta etiqueta para novos artigos',
		'name' => 'Nome',
		'new_name' => 'Nome novo',
		'old_name' => 'Nome antigo',
	),
	'title' => array(
		'_' => 'Gerenciamento de inscrições',
		'add' => 'Adicionar um feed ou categoria',
		'add_category' => 'Adicionar uma categoria',
		'add_dynamic_opml' => 'Adicionar OPML dinâmico',
		'add_feed' => 'Adicionar um feed',
		'add_label' => 'Adicionar uma etiqueta',
		'delete_label' => 'Deletar uma etiqueta',
		'feed_management' => 'Gerenciamento dos RSS feeds',
		'rename_label' => 'Renomear uma etiqueta',
		'subscription_tools' => 'Ferramentas de inscrição',
	),
);
