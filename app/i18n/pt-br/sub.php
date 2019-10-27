<?php

return array(
	'api' => array(
		'documentation' => 'Copy the following URL to use it within an external tool.',	//TODO - Translation
		'title' => 'API',	//TODO - Translation
	),
	'bookmarklet' => array(
		'documentation' => 'Drag this button to your bookmarks toolbar or right-click it and choose "Bookmark This Link". Then click "Subscribe" button in any page you want to subscribe to.',	//TODO - Translation
		'label' => 'Subscribe',	//TODO - Translation
		'title' => 'Bookmarklet',	//TODO - Translation
	),
	'category' => array(
		'_' => 'Categoria',
		'add' => 'Adicionar uma categoria',
		'archiving' => 'Arquivar',
		'empty' => 'Categoria vazia',
		'information' => 'Informações',
		'new' => 'Nova categoria',
		'position' => 'Display position',	//TODO - Translation
		'position_help' => 'To control category sort order',	//TODO - Translation
		'title' => 'Título',
	),
	'feed' => array(
		'add' => 'Adicionar um RSS feed',
		'advanced' => 'Avançado',
		'archiving' => 'Arquivar',
		'auth' => array(
			'configuration' => 'Login',
			'help' => 'Permite acesso a feeds RSS protegidos por HTTP',
			'http' => 'Autenticação HTTP',
			'password' => 'Senha HTTP',
			'username' => 'Usuário HTTP',
		),
		'clear_cache' => 'Always clear cache',	//TODO - Translation
		'css_help' => 'Retorna RSS feeds truncados (atenção, requer mais tempo!)',
		'css_path' => 'Caminho do CSS do artigo no site original',
		'description' => 'Descrição',
		'empty' => 'Este feed está vazio. Por favor verifique ele ainda é mantido.',
		'error' => 'Este feed encontra-se com problema. Por favor verifique se ele ainda está disponível e atualize-o.',
		'filteractions' => array(
			'_' => 'Filter actions',	//TODO - Translation
			'help' => 'Write one search filter per line.',	//TODO - Translation
		),
		'information' => 'Informações',
		'keep_min' => 'Número mínimo de artigos para manter',
		'moved_category_deleted' => 'Quando você deleta uma categoria, seus feeds são automaticamente classificados como <em>%s</em>.',
		'mute' => 'mute',	//TODO - Translation
		'no_selected' => 'Nenhum feed selecionado.',
		'number_entries' => '%d artigos',
		'priority' => array(
			'_' => 'Visibility',	//TODO - Translation
			'archived' => 'Do not show (archived)',	//TODO - Translation
			'main_stream' => 'Mostrar na tela principal',
			'normal' => 'Show in its category',	//TODO - Translation
		),
		'websub' => 'Notificação instantânea com WebSub',
		'show' => array(
			'all' => 'Show all feeds',	//TODO - Translation
			'error' => 'Show only feeds with error',	//TODO - Translation
		),
		'showing' => array(
			'error' => 'Showing only feeds with error',	//TODO - Translation
		),
		'ssl_verify' => 'Verify SSL security',	//TODO - Translation
		'stats' => 'Estatísticas',
		'think_to_add' => 'Você deve adicionar alguns feeds.',
		'timeout' => 'Timeout in seconds',	//TODO - Translation
		'title' => 'Título',
		'title_add' => 'Adicionar o RSS feed',
		'ttl' => 'Não atualize automáticamente mais que',
		'url' => 'Feed URL',
		'validator' => 'Verifique a validade do feed',
		'website' => 'URL do site',
	),
	'firefox' => array(
		'documentation' => 'Follow the steps described <a href="https://developer.mozilla.org/en-US/Firefox/Releases/2/Adding_feed_readers_to_Firefox#Adding_a_new_feed_reader_manually">here</a> to add FreshRSS to Firefox feed reader list.',// TODO
		'obsolete_63' => 'From version 63 and onwards, Firefox has removed the ability to add your own subscription services that are not standalone programs.',	//TODO - Translation
		'title' => 'Firefox feed reader',	//TODO - Translation
	),
	'import_export' => array(
		'export' => 'Exportar',
		'export_opml' => 'Exporta a lista dos feeds (OPML)',
		'export_starred' => 'Exportar seus favoritos',
		'export_labelled' => 'Export your labelled articles',	//TODO
		'feed_list' => 'Lista dos %s artigos',
		'file_to_import' => 'Arquivo para importar<br />(OPML, JSON or ZIP)',
		'file_to_import_no_zip' => 'Arquivo para importar<br />(OPML or JSON)',
		'import' => 'Importar',
		'starred_list' => 'Listar artigos favoritos',
		'title' => 'Importar / exportar',
	),
	'menu' => array(
		'bookmark' => 'Inscreva-se (FreshRSS favoritos)',
		'import_export' => 'Importar / exportar',
		'subscription_management' => 'Gerenciamento de inscrições',
	),
	'title' => array(
		'_' => 'Gerenciamento de inscrições',
		'feed_management' => 'Gerenciamento dos RSS feeds',
	),
);
