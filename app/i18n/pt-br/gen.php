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
	'action' => array(
		'actualize' => 'Atualizar feeds',
		'add' => 'Adicionar',
		'back' => '← Voltar',
		'back_to_rss_feeds' => '← Volte para o seu feeds RSS',
		'cancel' => 'Cancelar',
		'create' => 'Criar',
		'demote' => 'Despromover',
		'disable' => 'Desabilitar',
		'empty' => 'Vazio',
		'enable' => 'Habilitar',
		'export' => 'Exportar',
		'filter' => 'Filtrar',
		'import' => 'Importar',
		'load_default_shortcuts' => 'Carregar mais atalhos',
		'manage' => 'Gerenciar',
		'mark_read' => 'Marcar como lido',
		'promote' => 'Promover',
		'purge' => 'Limpar',
		'remove' => 'Remover',
		'rename' => 'Renomear',
		'see_website' => 'Ver o site',
		'submit' => 'Enviar',
		'truncate' => 'Deletar todos os artigos',
		'update' => 'Atualizar',
	),
	'auth' => array(
		'accept_tos' => 'Eu aceito os <a href="%s">Termos de serviço</a>.',
		'email' => 'Endereço de e-mail',
		'keep_logged_in' => 'Mantenha logado por <small>(%s days)</small>',
		'login' => 'Entrar',
		'logout' => 'Sair',
		'password' => array(
			'_' => 'Senha',
			'format' => '<small>Ao menos 7 caracteres</small>',
		),
		'registration' => array(
			'_' => 'Nova conta',
			'ask' => 'Criar novoa conta?',
			'title' => 'Criação de conta',
		),
		'username' => array(
			'_' => 'Usuário',
			'format' => '<small>Máximo 16 caracteres alphanumericos</small>',
		),
	),
	'date' => array(
		'Apr' => '\\A\\b\\r\\i\\l',
		'Aug' => '\\A\\g\\o\\s\\t\\o',
		'Dec' => '\\D\\e\\z\\e\\m\\b\\r\\o',
		'Feb' => '\\F\\e\\v\\e\\r\\e\\i\\r\\o',
		'Jan' => '\\J\\a\\n\\e\\i\\r\\o',
		'Jul' => '\\J\\u\\l\\h\\o',
		'Jun' => '\\J\\u\\n\\h\\o',
		'Mar' => '\\M\\a\\r\\ç\\o',
		'May' => '\\M\\a\\i\\o',
		'Nov' => '\\N\\o\\v\\e\\m\\b\\r\\o',
		'Oct' => '\\O\\u\\t\\u\\b\\r\\o',
		'Sep' => '\\S\\e\\t\\e\\m\\b\\r\\o',
		'apr' => 'abr',
		'april' => 'Abr',
		'aug' => 'ago',
		'august' => 'Ago',
		'before_yesterday' => 'Antes de ontem',
		'dec' => 'dez',
		'december' => 'Dez',
		'feb' => 'fev',
		'february' => 'Fev',
		'format_date' => 'j \\d\\e %s \\d\\e Y',
		'format_date_hour' => 'j \\d\\e %s \\d\\e Y\\, H\\:i',
		'fri' => 'Sex',
		'jan' => 'jan',
		'january' => 'Jan',
		'jul' => 'jul',
		'july' => 'Jul',
		'jun' => 'jun',
		'june' => 'Jun',
		'last_2_year' => 'Últimos dois anos',
		'last_3_month' => 'Últimos três meses',
		'last_3_year' => 'Últimos três anos',
		'last_5_year' => 'Últimos cinco anos',
		'last_6_month' => 'Últimos seis meses',
		'last_month' => 'Últimos mês',
		'last_week' => 'Última semana',
		'last_year' => 'Último ano',
		'mar' => 'mar',
		'march' => 'Mar',
		'may' => 'Mai',
		'may_' => 'Mai',
		'mon' => 'Seg',
		'month' => 'meses',
		'nov' => 'nov',
		'november' => 'Nov',
		'oct' => 'out',
		'october' => 'Out',
		'sat' => 'Sab',
		'sep' => 'set',
		'september' => 'Set',
		'sun' => 'Dom',
		'thu' => 'Qui',
		'today' => 'Hoje',
		'tue' => 'Ter',
		'wed' => 'Qua',
		'yesterday' => 'Ontem',
	),
	'dir' => 'ltr',	// IGNORE
	'freshrss' => array(
		'_' => 'FreshRSS',	// IGNORE
		'about' => 'Sobre FreshRSS',
	),
	'js' => array(
		'category_empty' => 'Categoria vazia',
		'confirm_action' => 'Você tem certeza que deseja efetuar esta ação? Ela não poderá ser cancelada!',
		'confirm_action_feed_cat' => 'Você tem certeza que deseja efetuar esta ação ? Você irá perder favoritos e queries de usuários. Não poderá ser cancelado!',
		'feedback' => array(
			'body_new_articles' => 'Há %%d novos artigos para ler no FreshRSS.',
			'body_unread_articles' => '(unread: %%d)',	// TODO
			'request_failed' => 'Uma solicitação falhou, isto pode ter sido causado por problemas de conexão com a internet.',
			'title_new_articles' => 'FreshRSS: novos artigos!',
		),
		'new_article' => 'Há novos artigos disponíveis, clique para atualizar a página.',
		'should_be_activated' => 'O JavaScript precisa estar ativo',
	),
	'lang' => array(
		'cz' => 'Čeština',	// IGNORE
		'de' => 'Deutsch',	// IGNORE
		'en' => 'English',	// IGNORE
		'en-us' => 'English (United States)',	// IGNORE
		'es' => 'Español',	// IGNORE
		'fr' => 'Français',	// IGNORE
		'he' => 'עברית',	// IGNORE
		'it' => 'Italiano',	// IGNORE
		'ja' => '日本語',	// IGNORE
		'ko' => '한국어',	// IGNORE
		'nl' => 'Nederlands',	// IGNORE
		'oc' => 'Occitan',	// IGNORE
		'pl' => 'Polski',	// IGNORE
		'pt-br' => 'Português (Brasil)',	// IGNORE
		'ru' => 'Русский',	// IGNORE
		'sk' => 'Slovenčina',	// IGNORE
		'tr' => 'Türkçe',	// IGNORE
		'zh-cn' => '简体中文',	// IGNORE
	),
	'menu' => array(
		'about' => 'Sobre',
		'account' => 'Conta',
		'admin' => 'Administração',
		'archiving' => 'Arquivar',
		'authentication' => 'Autenticação',
		'check_install' => 'Verificação de instalação',
		'configuration' => 'Configuração',
		'display' => 'Visualização',
		'extensions' => 'Extensões',
		'logs' => 'Logs',	// IGNORE
		'queries' => 'Queries de usuário',
		'reading' => 'Leitura',
		'search' => 'Procurar por palavras ou #tags',
		'sharing' => 'Compartilhamento',
		'shortcuts' => 'Atalhos',
		'stats' => 'Estatísticas',
		'system' => 'Configuração do sistema',
		'update' => 'Atualização',
		'user_management' => 'Gerenciamento de usuários',
		'user_profile' => 'Perfil',
	),
	'pagination' => array(
		'first' => 'Primeiro',
		'last' => 'Último',
		'next' => 'Próximo',
		'previous' => 'Anterior',
	),
	'period' => array(
		'days' => 'dias',
		'hours' => 'horas',
		'months' => 'meses',
		'weeks' => 'semanas',
		'years' => 'anos',
	),
	'share' => array(
		'Known' => 'Sites no Known',
		'blogotext' => 'Blogotext',	// IGNORE
		'clipboard' => 'Área de transferência',
		'diaspora' => 'Diaspora*',	// IGNORE
		'email' => 'E-mail',
		'facebook' => 'Facebook',	// IGNORE
		'gnusocial' => 'GNU social',	// IGNORE
		'jdh' => 'Journal du hacker',	// IGNORE
		'lemmy' => 'Lemmy',	// IGNORE
		'linkedin' => 'LinkedIn',	// IGNORE
		'mastodon' => 'Mastodon',	// IGNORE
		'movim' => 'Movim',	// IGNORE
		'pinboard' => 'Pinboard',	// IGNORE
		'pocket' => 'Pocket',	// IGNORE
		'print' => 'Imprimir',
		'raindrop' => 'Raindrop.io',	// IGNORE
		'reddit' => 'Reddit',	// TODO
		'shaarli' => 'Shaarli',	// IGNORE
		'twitter' => 'Twitter',	// IGNORE
		'wallabag' => 'wallabag v1',	// IGNORE
		'wallabagv2' => 'wallabag v2',	// IGNORE
		'xing' => 'Xing',	// TODO
	),
	'short' => array(
		'attention' => 'Atenção!',
		'blank_to_disable' => 'Deixe em branco para desativar',
		'by_author' => 'Por:',
		'by_default' => 'Por padrão',
		'damn' => 'Buumm!',
		'default_category' => 'Sem categoria',
		'no' => 'Não',
		'not_applicable' => 'Não disponível',
		'ok' => 'Ok!',	// IGNORE
		'or' => 'ou',
		'yes' => 'Sim',
	),
	'stream' => array(
		'load_more' => 'Carregar mais artigos',
		'mark_all_read' => 'Marcar todos como lidos',
		'nothing_to_load' => 'Não há mais artigos',
	),
);
