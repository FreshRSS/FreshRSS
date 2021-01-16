<?php

return array(
	'add' => 'Feed and category creation has been moved <a href=\'%s\'>here</a>. It is also accessible from the menu on the left and from the ✚ icon available on the main page.',	// TODO - Translation
	'api' => array(
		'documentation' => 'Copie a seguinte URL para utilizar com uma ferramenta externa',
		'title' => 'API',
	),
	'bookmarklet' => array(
		'documentation' => 'Arraste este botão para sua barra de favoritos ou clique com o botão direito e escolha "Adicionar este link aos favoritos". Depois clique no no link da barra de favoritos "Inscrever-se" em qualquer página que você queira se inscrever.',
		'label' => 'Inscrever-se',
		'title' => 'Bookmarklet',	// TODO - Translation
	),
	'category' => array(
		'_' => 'Categoria',
		'add' => 'Adicionar uma categoria',
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
		'css_cookie' => 'Use Cookies when fetching the article content',	// TODO - Translation
		'css_cookie_help' => 'Example: <kbd>foo=bar; gdpr_consent=true; cookie=value</kbd>',	// TODO - Translation
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
		'proxy' => 'Set a proxy for fetching this feed',	// TODO - Translation
		'proxy_help' => 'Select a protocol (e.g: SOCKS5) and enter the proxy address (e.g: <kbd>127.0.0.1:1080</kbd>)',	// TODO - Translation
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
		'validator' => 'Verifique a validade do feed',
		'website' => 'URL do site',
		'websub' => 'Notificação instantânea com WebSub',
	),
	'firefox' => array(
		'documentation' => 'Siga as instruções descritas em <a href="https://developer.mozilla.org/en-US/Firefox/Releases/2/Adding_feed_readers_to_Firefox#Adding_a_new_feed_reader_manually">here</a> para adicionar o FreshRSS para o seu leitor de Feed do Firefox.',
		'obsolete_63' => 'A partir da versão 63, o Firefox removeu a capacidade de adicionar seus próprios serviços de assinatura que não são programas autônomos.',
		'title' => 'Leitor de feed do Firefox',
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
		'add' => 'Add a feed or category',	// TODO - Translation
		'add_feed' => 'Add a feed',	// TODO - Translation
		'bookmark' => 'Inscreva-se (FreshRSS favoritos)',
		'import_export' => 'Importar / exportar',
		'subscription_management' => 'Gerenciamento de inscrições',
		'subscription_tools' => 'Ferramentas de inscrição',
		'tag_management' => 'Tag management',	// TODO - Translation
	),
	'tag' => array(
		'name' => 'Name',	// TODO - Translation
		'new_name' => 'New name',	// TODO - Translation
		'old_name' => 'Old name',	// TODO - Translation
	),
	'title' => array(
		'_' => 'Gerenciamento de inscrições',
		'add' => 'Add a feed or category',	// TODO - Translation
		'add_category' => 'Add a category',	// TODO - Translation
		'add_feed' => 'Add a feed',	// TODO - Translation
		'add_tag' => 'Add a tag',	// TODO - Translation
		'delete_tag' => 'Delete a tag',	// TODO - Translation
		'feed_management' => 'Gerenciamento dos RSS feeds',
		'rename_tag' => 'Rename a tag',	// TODO - Translation
		'subscription_tools' => 'Ferramentas de inscrição',
	),
);
