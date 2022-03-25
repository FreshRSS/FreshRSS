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
	'archiving' => array(
		'_' => 'Arquivar',
		'exception' => 'Regras de exceção da limpeza',
		'help' => 'Mais opções estão disponíveis nas configurações individuais do Feed',
		'keep_favourites' => 'Nunca deletar os favoritos',
		'keep_labels' => 'Nunca deletar etiquetas',
		'keep_max' => 'Número máximo de artigos para manter',
		'keep_min_by_feed' => 'Número mínimo de artigos para deixar no feed',
		'keep_period' => 'Idade máxima dos artigos a serem mantidos',
		'keep_unreads' => 'Nunca apagar os não lidos',
		'maintenance' => 'Manutenção',
		'optimize' => 'Otimizar banco de dados',
		'optimize_help' => 'Faça ocasionalmente para reduzir o tamanho do banco de dados',
		'policy' => 'Política de limpeza',
		'policy_warning' => 'Se nenhuma política de limpeza for selecionada, todos os artigos serão mantidos.',
		'purge_now' => 'Limpar agora',
		'title' => 'Arquivar',
		'ttl' => 'Não atualize automaticamente mais frequente que',
	),
	'display' => array(
		'_' => 'Exibição',
		'icon' => array(
			'bottom_line' => 'Linha inferior',
			'display_authors' => 'Autores',
			'entry' => 'Ícones de artigos',
			'publication_date' => 'Data da publicação',
			'related_tags' => 'Tags relacionadas',
			'sharing' => 'Compartilhar',
			'summary' => 'Sumário',
			'top_line' => 'Linha superior',
		),
		'language' => 'Idioma',
		'notif_html5' => array(
			'seconds' => 'segundos (0 significa sem timeout)',
			'timeout' => 'Notificação em HTML5 de timeout',
		),
		'show_nav_buttons' => 'Mostrar botões de navegação',
		'theme' => 'Tema',
		'theme_not_available' => 'O tema “%s” não está mais disponível. Por favor escolha outro tema.',
		'thumbnail' => array(
			'label' => 'Miniatura',
			'landscape' => 'Modo paisagem',
			'none' => 'Nenhum',
			'portrait' => 'Modo retrato',
			'square' => 'Modo quadrado',
		),
		'title' => 'Exibição',
		'width' => array(
			'content' => 'Largura do conteúdo',
			'large' => 'Largo',
			'medium' => 'Médio',
			'no_limit' => 'Sem limite',
			'thin' => 'Fino',
		),
	),
	'logs' => array(
		'loglist' => array(
			'level' => 'Log Level',	// TODO
			'message' => 'Log Message',	// TODO
			'timestamp' => 'Timestamp',	// TODO
		),
		'pagination' => array(
			'first' => 'Primeiro',
			'last' => 'Último',
			'next' => 'Próximo',
			'previous' => 'Anterior',
		),
	),
	'profile' => array(
		'_' => 'Gerenciamento de perfil',
		'api' => 'Administração da API',
		'delete' => array(
			'_' => 'Remover conta',
			'warn' => 'Sua conta e todos os dados relacionados serão removidos.',
		),
		'email' => 'Endereço de e-mail',
		'password_api' => 'Senha da API<br /><small>(p.s., para aplicativos móveis)</small>',
		'password_form' => 'Senha<br /><small>(para o método de formulário web)</small>',
		'password_format' => 'Ao menos 7 caracteres',
		'title' => 'Perfil',
	),
	'query' => array(
		'_' => 'Queries do usuário',
		'deprecated' => 'Esta não é mais válida. A categoria ou feed relacionado foi deletado.',
		'filter' => array(
			'_' => 'Filtro aplicado:',
			'categories' => 'Exibir por categoria',
			'feeds' => 'Exibir por feed',
			'order' => 'Ordenar por data',
			'search' => 'Expressão',
			'state' => 'Estado',
			'tags' => 'Exibir por tag',
			'type' => 'Tipo',
		),
		'get_all' => 'Mostrar todos os artigos',
		'get_category' => 'Visualizar "%s" categoria',
		'get_favorite' => 'Visualizar artigos favoritos',
		'get_feed' => 'Visualizar "%s" feed',
		'name' => 'Nome',
		'no_filter' => 'Sem filtro',
		'number' => 'Query n°%d',	// IGNORE
		'order_asc' => 'Exibir artigos mais antigos primeiro',
		'order_desc' => 'Exibir artigos mais novos primeiro',
		'search' => 'Busca por "%s"',
		'state_0' => 'Exibir todos os artigos',
		'state_1' => 'Exibir artigos lidos',
		'state_2' => 'Exibir artigos não lidos',
		'state_3' => 'Exibir todos os artigos',
		'state_4' => 'Exibir artigos favoritos',
		'state_5' => 'Exibir artigos favoritos lidos',
		'state_6' => 'Exibir artigos favoritos não lidos',
		'state_7' => 'Exibir artigos favoritos',
		'state_8' => 'Exibir artigos que não são favoritos',
		'state_9' => 'Exibir artigos que não são favoritos lidos',
		'state_10' => 'Exibir artigos que não são favoritos não lidos',
		'state_11' => 'Exibir artigos que não são favoritos',
		'state_12' => 'Exibir todos os artigos',
		'state_13' => 'Exibir artigos lidos',
		'state_14' => 'Exibir artigos não lidos',
		'state_15' => 'Exibir todos os artigos',
		'title' => 'Queries de usuários',
	),
	'reading' => array(
		'_' => 'Leitura',
		'after_onread' => 'Depois de "marcar todos como lido",',
		'always_show_favorites' => 'Mostrar todos os artivos nos favoritos por padrão',
		'articles_per_page' => 'Número de artigos por página',
		'auto_load_more' => 'Carregar mais artigos no final da página',
		'auto_remove_article' => 'Esconder artigos depois de lidos',
		'confirm_enabled' => 'Exibir uma caixa de diálogo de confirmação quando acionar "marcar todos como lido"',
		'display_articles_unfolded' => 'Mostrar artigos abertos por padrão',
		'display_categories_unfolded' => 'Categorias abertas',
		'headline' => array(
			'articles' => 'Articles: Open/Close',	// TODO
			'categories' => 'Left navigation: Categories',	// TODO
			'mark_as_read' => 'Mark article as read',	// TODO
			'misc' => 'Miscellaneous',	// TODO
			'view' => 'View',	// TODO
		),
		'hide_read_feeds' => 'Esconder categorias e feeds com nenhum artigo não lido (não funciona com a configuração "Mostrar todos os artigos”)',
		'img_with_lazyload' => 'Utilizar o modo "lazy load" para carregar as imagens',
		'jump_next' => 'Vá para o próximo irmão não lido (feed ou categoria)',
		'mark_updated_article_unread' => 'Marcar artigos atualizados como não lidos',
		'number_divided_when_reader' => 'Dividido por 2 no modo de leitura .',
		'read' => array(
			'article_open_on_website' => 'quando o artigo é aberto no site original',
			'article_viewed' => 'Quando o artigo é visualizado',
			'keep_max_n_unread' => 'Número máximo de artigos para manter como não lido',
			'scroll' => 'enquanto scrolling',
			'upon_reception' => 'ao receber um artigo',
			'when' => 'Marcar artigo como lido…',
			'when_same_title' => 'Se um título idêntico já existir nos últimos<i>n</i> artigos mais novos',
		),
		'show' => array(
			'_' => 'Artigos para exibir',
			'active_category' => 'Categoria ativa',
			'adaptive' => 'Ajustar visualização',
			'all_articles' => 'Exibir todos os artigos',
			'all_categories' => 'Exibir todas as categorias',
			'no_category' => 'Nenhuma categoria',
			'remember_categories' => 'lembrar de abrir as categorias',
			'unread' => 'Exibir apenas não lido',
		),
		'show_fav_unread_help' => 'Aplicar também nas etiquetas',
		'sides_close_article' => 'Clicando fora da área do texto do artigo fecha o mesmo',
		'sort' => array(
			'_' => 'Ordem de visualização',
			'newer_first' => 'Novos primeiro',
			'older_first' => 'Antigos primeiro',
		),
		'sticky_post' => 'Coloque o artigo no topo quando aberto',
		'title' => 'Lendo',
		'view' => array(
			'default' => 'Visualização padrão',
			'global' => 'Visualização global',
			'normal' => 'Visualização normal',
			'reader' => 'Visualização de leitura',
		),
	),
	'sharing' => array(
		'_' => 'Compartilhando',
		'add' => 'Adicionar um método de compartilhamento',
		'blogotext' => 'Blogotext',	// IGNORE
		'deprecated' => 'This service is deprecated and will be removed from FreshRSS in a <a href="https://freshrss.github.io/FreshRSS/en/users/08_sharing_services.html" title="Open documentation for more information" target="_blank">future release</a>.',	// TODO
		'diaspora' => 'Diaspora*',	// IGNORE
		'email' => 'E-mail',
		'facebook' => 'Facebook',	// IGNORE
		'more_information' => 'Mais informação',
		'print' => 'Imprimir',	// IGNORE
		'raindrop' => 'Raindrop.io',	// IGNORE
		'remove' => 'Remover método de compartilhamento',
		'shaarli' => 'Shaarli',	// IGNORE
		'share_name' => 'Nome de visualização para compartilhar',
		'share_url' => 'URL utilizada para compartilhar',
		'title' => 'Compartilhando',
		'twitter' => 'Twitter',	// IGNORE
		'wallabag' => 'wallabag',	// IGNORE
	),
	'shortcut' => array(
		'_' => 'Atalhos',
		'article_action' => 'Ações no artigo',
		'auto_share' => 'Compartilhar',
		'auto_share_help' => 'Se há apenas um modo de compartilhamento, ele é usado. Caso contrário, serão acessíveis pelo seu número.',
		'close_dropdown' => 'Fechar menus',
		'collapse_article' => 'Fechar',
		'first_article' => 'Ir para o primeiro artigo',
		'focus_search' => 'Acessar a caixa de busca',
		'global_view' => 'Mudar para visualização global',
		'help' => 'Mostrar documentação',
		'javascript' => 'JavaScript deve ser habilitado para utilizar atalhos',
		'last_article' => 'Ir para o último artigo',
		'load_more' => 'Carregar mais artigos',
		'mark_favorite' => 'Marcar como favorito',
		'mark_read' => 'Marcar como lido',
		'navigation' => 'Navegação',
		'navigation_help' => 'Com o modificador <kbd>⇧ Shift</kbd>, atalhos de navegação aplicam aos feeds.<br/>Com o <kbd>Alt ⎇</kbd> modificador, atalhos de navegação aplicam as categorias.',
		'navigation_no_mod_help' => 'Os seguintes atalhos de navegação não suportam modificadores.',
		'next_article' => 'Pule para o próximo artigo',
		'next_unread_article' => 'Abrir o próximo artigo não lido',
		'non_standard' => 'Algumas teclas (<kbd>%s</kbd>) podem não funcionar como atalhos.',
		'normal_view' => 'Mudar para a visualização normal',
		'other_action' => 'Outras ações',
		'previous_article' => 'Pule para o artigo anterior',
		'reading_view' => 'Mudar para o modo de leitura',
		'rss_view' => 'Abrir como feed RSS ',
		'see_on_website' => 'Visualize o site original',
		'shift_for_all_read' => '+ <kbd>Alt ⎇</kbd> para marcar artigos anteriores como lido<br />+ <kbd>⇧ Shift</kbd> para marcar todos os artigos como lido',
		'skip_next_article' => 'Focar o próximo sem abri-lo',
		'skip_previous_article' => 'Focar o anterior sem abri-lo',
		'title' => 'Atalhos',
		'toggle_media' => 'Reproduzir/pausar mídia',
		'user_filter' => 'Acesse filtros de usuário',
		'user_filter_help' => 'Se há apenas um filtro, ele é utilizado. Caso contrário, os filtros serão acessíveis pelos seus números.',
		'views' => 'Visualizações',
	),
	'user' => array(
		'articles_and_size' => '%s artigos (%s)',
		'current' => 'Usuário atual',
		'is_admin' => 'é administrador',
		'users' => 'Usuários',
	),
);
