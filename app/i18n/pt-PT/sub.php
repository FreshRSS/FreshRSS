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
	'api' => array(
		'documentation' => 'Copie o seguinte URL para utilizar com uma ferramenta externa',
		'title' => 'API',	// IGNORE
	),
	'bookmarklet' => array(
		'documentation' => 'Arraste este botão para a sua barra de favoritos ou clique com o botão direito e escolha “Adicionar este link aos favoritos”. Depois, clique no link “Inscrever-se” na barra de favoritos em qualquer página a que queira subscrever.',
		'label' => 'Inscrever-se',
		'title' => 'Bookmarklet',	// IGNORE
	),
	'category' => array(
		'_' => 'Categoria',
		'add' => 'Adicionar categoria',
		'archiving' => 'Arquivar',
		'dynamic_opml' => array(
			'_' => 'OPML dinâmico',
			'help' => 'Forneça um URL para <a href="https://opml.org/" target="_blank">o ficheiro OPML</a> para preencher dinamicamente esta categoria com feeds',
		),
		'empty' => 'Categoria vazia',
		'error' => 'Esta categoria OPML dinâmica encontrou um problema. Verifique se o URL OPML ainda está acessível e se o número máximo de feeds por utilizador não foi excedido.',
		'expand' => 'Expandir categoria',
		'information' => 'Informações',
		'open' => 'Abrir categoria',
		'opml_url' => 'URL OPML',
		'position' => 'Posição de visualização',
		'position_help' => 'Para controlar a ordem de visualização',
		'title' => 'Título',
	),
	'feed' => array(
		'accept_cookies' => 'Aceitar cookies',
		'accept_cookies_help' => 'Permitir que o servidor do feed defina cookies (armazenados na memória apenas durante o pedido)',
		'add' => 'Adicionar um feed',
		'advanced' => 'Avançado',
		'archiving' => 'Arquivar',
		'auth' => array(
			'configuration' => 'Entrar',
			'help' => 'Permite o acesso a feeds RSS protegidos por HTTP',
			'http' => 'Autenticação HTTP',
			'password' => 'Palavra-passe HTTP',
			'username' => 'Utilizador HTTP',
		),
		'change_favicon' => 'Alterar…',
		'clear_cache' => 'Limpar sempre a cache',
		'content_action' => array(
			'_' => 'Ações ao obter o conteúdo dos artigos',
			'append' => 'Adicionar após o conteúdo existente',
			'prepend' => 'Adicionar antes do conteúdo existente',
			'replace' => 'Substituir o conteúdo existente',
		),
		'content_retrieval' => 'Obtenção de conteúdo',
		'css_cookie' => 'Utilizar cookies ao pesquisar o conteúdo dos artigos',
		'css_cookie_help' => 'Exemplo: <kbd>foo=bar; gdpr_consent=true; cookie=value</kbd>',
		'css_help' => 'Devolve feeds RSS truncados (atenção: requer mais tempo!)',
		'css_path' => 'Caminho CSS do artigo no site original',
		'css_path_filter' => array(
			'_' => 'Seletor CSS dos elementos a remover',
			'help' => 'O seletor CSS pode ser uma lista com: <kbd>footer, aside, p[data-sanitized-class~="menu"]</kbd>',
		),
		'description' => 'Descrição',
		'empty' => 'Este feed está vazio. Por favor, verifique se ainda é mantido.',
		'error' => 'Este feed encontra-se com um problema. Por favor, verifique se ainda está disponível.',
		'export-as-opml' => array(
			'download' => 'Download',	// IGNORE
			'help' => 'Ficheiro XML (<a href="https://freshrss.github.io/FreshRSS/en/developers/OPML.html" target="_blank">Ver documentação</a>)',
			'label' => 'Exportar como OPML',
		),
		'ext_favicon' => 'Definir automaticamente',
		'favicon_changed_by_ext' => 'O ícone foi definido pela extensão <b>%s</b>.',
		'filteractions' => array(
			'_' => 'Ações de filtro',
			'help' => 'Escreva um filtro de pesquisa por linha. <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">Ver documentação</a>.',
			'view_filter' => 'Pré-visualizar filtros em artigos existentes (nova janela)',
		),
		'global_hint' => 'Utilize <a href="%s">a visualização global</a> para ver quantos artigos em cada feed correspondem a um estado ou a uma expressão de pesquisa',
		'http_headers' => 'Cabeçalhos HTTP',
		'http_headers_help' => 'Os cabeçalhos são separados por uma mudança de linha, e o nome e o valor de cada cabeçalho são separados por dois pontos (p. ex.: <kbd><code>Accept: application/atom+xml<br />Authorization: Bearer some-token</code></kbd>).',
		'icon' => 'Ícone',
		'information' => 'Informações',
		'keep_adding_feed' => 'Adicionar mais feeds',
		'keep_min' => 'Número mínimo de artigos a manter',
		'kind' => array(
			'_' => 'Tipo de fonte do feed',
			'html_json' => array(
				'_' => 'HTML + XPath + Notação de ponto JSON (JSON em HTML)',
				'xpath' => array(
					'_' => 'XPath para JSON em HTML',
					'help' => 'Exemplo: <code>normalize-space(//script[@type="application/json"])</code> (JSON único)<br />ou: <code>//script[@type="application/ld+json"]</code> (um objeto JSON por artigo)',
				),
			),
			'html_xpath' => array(
				'_' => 'HTML + XPath (Web scraping)',	// IGNORE
				'feed_title' => array(
					'_' => 'Título do feed',
					'help' => 'Exemplo: <code>//title</code> ou uma string estática: <code>"O meu feed personalizado"</code>',
				),
				'help' => '<dfn><a href="https://www.w3.org/TR/xpath-10/" target="_blank">XPath 1.0</a></dfn> é uma linguagem de consulta padrão para utilizadores avançados que o FreshRSS suporta para permitir web scraping.',
				'item' => array(
					'_' => 'encontrar os <strong>itens</strong> das notícias<br /><small>(mais importante)</small>',
					'help' => 'Exemplo: <code>//div[@class="news-item"]</code>',
				),
				'item_author' => array(
					'_' => 'Autor do item',
					'help' => 'Também pode ser uma string estática. Exemplo: <code>"Anónimo"</code>',
				),
				'item_categories' => 'Etiquetas do item',
				'item_content' => array(
					'_' => 'Conteúdo do item',
					'help' => 'Exemplo para obter o item completo: <code>.</code>',
				),
				'item_thumbnail' => array(
					'_' => 'Miniatura do item',
					'help' => 'Exemplo: <code>descendant::img/@src</code>',
				),
				'item_timeFormat' => array(
					'_' => 'Formato de data/hora personalizado',
					'help' => 'Opcional. Um formato suportado por <a href="https://www.php.net/datetime.createfromformat" target="_blank"><code>DateTime::createFromFormat()</code></a> tal como <code>d-m-Y H:i:s</code>',
				),
				'item_timestamp' => array(
					'_' => 'Data do item',
					'help' => 'O resultado será analisado por <a href="https://www.php.net/strtotime" target="_blank"><code>strtotime()</code></a>',
				),
				'item_title' => array(
					'_' => 'Título do item',
					'help' => 'Utilize especialmente o <a href="https://developer.mozilla.org/docs/Web/XML/XPath/Reference/Axes" target="_blank">eixo XPath</a> <code>descendant::</code> tal como <code>descendant::h2</code>',
				),
				'item_uid' => array(
					'_' => 'ID único do item',
					'help' => 'Opcional. Exemplo: <code>descendant::div/@data-uri</code>',
				),
				'item_uri' => array(
					'_' => 'Link do item (URL)',
					'help' => 'Exemplo: <code>descendant::a/@href</code>',
				),
				'relative' => 'XPath (relativo ao item) para:',
				'xpath' => 'XPath para:',
			),
			'json_dotnotation' => array(
				'_' => 'JSON (notação de ponto)',
				'feed_title' => array(
					'_' => 'título do feed',
					'help' => 'Exemplo: <code>meta.title</code> ou uma string estática: <code>"O meu feed personalizado"</code>',
				),
				'help' => 'Um JSON em notação de ponto utiliza pontos entre objetos e chavetas/parênteses rectos para matrizes (p. ex., <code>data.items[0].title</code>)',
				'item' => array(
					'_' => 'encontrar os <strong>itens</strong> das notícias<br /><small>(mais importante)</small>',
					'help' => 'Caminho JSON para a matriz que contém os itens, p. ex., <code>$</code> ou <code>newsItems</code>',
				),
				'item_author' => 'autor do item',
				'item_categories' => 'tags dos itens',
				'item_content' => array(
					'_' => 'conteúdo do item',
					'help' => 'Chave sob a qual o conteúdo é encontrado, p. ex., <code>content</code>',
				),
				'item_thumbnail' => array(
					'_' => 'miniatura do item',
					'help' => 'Exemplo: <code>image</code>',
				),
				'item_timeFormat' => array(
					'_' => 'Formato de data/hora personalizado',
					'help' => 'Opcional. Um formato suportado por <a href="https://www.php.net/datetime.createfromformat" target="_blank"><code>DateTime::createFromFormat()</code></a> tal como <code>d-m-Y H:i:s</code>',
				),
				'item_timestamp' => array(
					'_' => 'data do item',
					'help' => 'O resultado será analisado por <a href="https://www.php.net/strtotime" target="_blank"><code>strtotime()</code></a>',
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
			'rss' => 'RSS / Atom (predefinição)',
			'xml_xpath' => 'XML + XPath',	// IGNORE
		),
		'last-entry-publication-date' => 'Último artigo publicado a <time datetime="%1$s" title="%1$s">%2$s</time>.',
		'last-entry-received-date' => 'Último artigo recebido a <time datetime="%1$s" title="%1$s">%2$s</time>.',
		'last-error-date' => 'Última atualização com erro a <time datetime="%1$s" title="%1$s">%2$s</time>.',
		'last-update' => 'Última atualização bem-sucedida a <time datetime="%1$s" title="%1$s">%2$s</time>.',
		'maintenance' => array(
			'clear_cache' => 'Limpar cache',
			'clear_cache_help' => 'Limpar a cache em disco deste feed',
			'reload_articles' => 'Recarregar artigos',
			'reload_articles_help' => 'Recarregar artigos e obter o conteúdo completo',
			'title' => 'Manutenção',
		),
		'max_http_redir' => 'Número máximo de redirecionamentos HTTP',
		'max_http_redir_help' => 'Defina como 0 ou deixe em branco para desativar, -1 para redirecionamentos ilimitados',
		'method' => array(
			'_' => 'Método HTTP',
		),
		'method_help' => 'O conteúdo POST suporta automaticamente <code>application/x-www-form-urlencoded</code> e <code>application/json</code>',
		'method_postparams' => 'Conteúdo POST',
		'moved_category_deleted' => 'Quando elimina uma categoria, os seus feeds são automaticamente classificados como <em>%s</em>.',
		'mute' => array(
			'_' => 'silenciar',
			'state_is_muted' => 'Este feed está silenciado',
		),
		'no_selected' => 'Nenhum feed selecionado.',
		'number_entries' => '%d artigos',
		'open_feed' => 'Abrir feed %s',
		'path_entries_conditions' => 'Condições para a obtenção de conteúdo',
		'priority' => array(
			'_' => 'Visibilidade',
			'category' => 'Mostrar na sua categoria',
			'feed' => 'Mostrar no seu feed',
			'hidden' => 'Não exibir',
			'important' => 'Mostrar feeds importantes',
			'main_stream' => 'Mostrar na stream principal',
		),
		'proxy' => 'Definir um proxy para obter este feed',
		'proxy_help' => 'Selecione um protocolo (p. ex.: SOCKS5) e introduza o endereço do proxy (p. ex.: <kbd>127.0.0.1:1080</kbd> ou <kbd>username:password@127.0.0.1:1080</kbd>)',
		'reset_favicon' => 'Repor predefinição',
		'selector_preview' => array(
			'show_raw' => 'Mostrar código-fonte',
			'show_rendered' => 'Mostrar conteúdo',
		),
		'show' => array(
			'all' => 'Mostrar todos os feeds',
			'error' => 'Mostrar apenas feeds com erros',
		),
		'showing' => array(
			'error' => 'Mostrar apenas os feeds com erros',
		),
		'ssl_verify' => 'Verificar segurança SSL',
		'stats' => 'Estatísticas',
		'think_to_add' => 'Pense em adicionar alguns feeds.',
		'timeout' => 'Tempo limite (timeout) em segundos',
		'title' => 'Título',
		'title_add' => 'Adicionar feed RSS',
		'ttl' => 'Não atualizar automaticamente com mais frequência do que',
		'unicityCriteria' => array(
			'_' => 'Critérios de unicidade do artigo',
			'forced' => '<span title="Bloquear os critérios de unicidade, mesmo quando o feed tem artigos duplicados">forçado</span>',
			'help' => 'Relevante para feeds inválidos.<br />⚠️ Alterar a política criará duplicados.',
			'id' => 'ID padrão (predefinição)',
			'link' => 'Ligação',
			'sha1:content' => 'Conteúdo',
			'sha1:content_published' => 'Conteúdo + Data',
			'sha1:link_published' => 'Link + Data',
			'sha1:link_published_title' => 'Link + Data + Título',
			'sha1:link_published_title_content' => 'Link + Data + Título + Conteúdo',
			'sha1:published' => 'Data',
			'sha1:title' => 'Título',
			'sha1:title_published' => 'Título + Data',
			'sha1:title_published_content' => 'Título + Data + Conteúdo',
		),
		'url' => 'URL do feed',
		'useragent' => 'Definir um agente de utilizador (user agent) para obter este feed',
		'useragent_help' => 'Exemplo: <kbd>Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:86.0)</kbd>',
		'validator' => 'Verificar a validade do feed',
		'website' => 'URL do site',
		'websub' => 'Notificação instantânea com WebSub',
		'websub_pending' => 'Subscrito ao WebSub. À espera da primeira notificação.',
	),
	'import_export' => array(
		'export' => array(
			'_' => 'Exportar',
			'sqlite' => 'Transferir base de dados do utilizador como SQLite',
		),
		'export_labelled' => 'Exportar os seus artigos etiquetados',
		'export_opml' => 'Exportar a lista de feeds (OPML)',
		'export_starred' => 'Exportar os seus favoritos',
		'feed_list' => 'Lista de %s artigos',
		'file_to_import' => 'Ficheiro a importar<br />(OPML, JSON ou ZIP)',
		'file_to_import_no_zip' => 'Ficheiro a importar<br />(OPML ou JSON)',
		'import' => 'Importar',
		'starred_list' => 'Listar artigos favoritos',
		'title' => 'Importar / exportar',
	),
	'menu' => array(
		'add' => 'Adicionar um feed ou categoria',
		'import_export' => 'Importar / exportar',
		'label_management' => 'Gerir etiquetas',
		'stats' => array(
			'idle' => 'Feeds inativos',
			'main' => 'Estatísticas principais',
			'repartition' => 'Repartição de artigos',
			'unread_dates' => 'Datas de não lidos',
		),
		'subscription_management' => 'Gerir subscrições',
		'subscription_tools' => 'Ferramentas de subscrição',
	),
	'tag' => array(
		'auto_label' => 'Adicionar esta etiqueta a novos artigos',
		'name' => 'Nome',
		'new_name' => 'Novo nome',
		'old_name' => 'Nome antigo',
	),
	'title' => array(
		'_' => 'Gerir subscrições',
		'add' => 'Adicionar um feed ou categoria',
		'add_category' => 'Adicionar uma categoria',
		'add_dynamic_opml' => 'Adicionar OPML dinâmico',
		'add_feed' => 'Adicionar um feed',
		'add_label' => 'Adicionar uma etiqueta',
		'add_opml_category' => 'Nome da categoria OPML',
		'delete_label' => 'Apagar uma etiqueta',
		'feed_management' => 'Gerir feeds RSS',
		'subscription_tools' => 'Ferramentas de subscrição',
	),
);
