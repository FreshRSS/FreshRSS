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
		'_' => 'Informazioni',
		'agpl3' => '<a href="https://www.gnu.org/licenses/agpl-3.0.html">AGPL 3</a>',	// IGNORE
		'bug_reports' => array(
			'environment_information' => array(
				'_' => 'Informazioni sul sistema',
				'browser' => 'Browser',	// IGNORE
				'database' => 'Database',	// IGNORE
				'server_software' => 'Software server',
				'version_curl' => 'Versione cURL',
				'version_frss' => 'Versione FreshRSS',
				'version_php' => 'Versione PHP',
			),
		),
		'bugs_reports' => 'Bugs',
		'documentation' => 'Documentazione',
		'freshrss_description' => 'FreshRSS è un aggregatore di feeds RSS da installare sul proprio host. Leggero e facile da mantenere pur essendo molto configurabile e potente.',
		'github' => '<a href="https://github.com/FreshRSS/FreshRSS/issues">su GitHub</a>',
		'license' => 'Licenza',
		'project_website' => 'Sito del progetto',
		'title' => 'Informazioni',
		'version' => 'Versione',
	),
	'feed' => array(
		'empty' => 'Non ci sono articoli da mostrare.',
		'published' => array(
			'_' => 'Pubblicato',
			'future' => 'Pubblicato nel futuro',
			'today' => 'Pubblicato oggi',
			'yesterday' => 'Pubblicato ieri',
		),
		'received' => array(
			'_' => 'Ricevuto',
			'today' => 'Ricevuto oggi',
			'yesterday' => 'Ricevuto ieri',
		),
		'rss_of' => 'RSS feed di %s',
		'title' => 'Flusso principale',
		'title_fav' => 'Preferiti',
		'title_global' => 'Vista globale per categorie',
		'userModified' => array(
			'_' => 'Modificato dall’utente',
			'today' => 'Modificato dall’utente oggi',
			'yesterday' => 'Modificato dall’utente ieri',
		),
	),
	'log' => array(
		'_' => 'Log',
		'clear' => 'Svuota logs',
		'empty' => 'File di log vuoto',
		'title' => 'Log',
	),
	'menu' => array(
		'about' => 'Informazioni',
		'before_one_day' => 'Giorno precedente',
		'before_one_week' => 'Settimana precedente',
		'bookmark_query' => 'Inserisci la ricerca corrente nei segnalibri',
		'favorites' => 'Preferiti (%s)',
		'global_view' => 'Vista globale per categorie',
		'important' => 'Feed importanti',
		'main_stream' => 'Flusso principale',
		'mark_all_read' => 'Segna tutto come letto',
		'mark_cat_read' => 'Segna la categoria come letta',
		'mark_feed_read' => 'Segna il feed come letto',
		'mark_selection_unread' => 'Segna i selezionati come non letti',
		'mylabels' => 'Le mie etichette',
		'non-starred' => 'Escludi preferiti',
		'normal_view' => 'Vista elenco',
		'queries' => 'Chiavi di ricerca',
		'read' => 'Mostra solo letti',
		'reader_view' => 'Modalità di lettura',
		'rss_view' => 'Feed RSS',
		'search_short' => 'Cerca',
		'sort' => array(
			'asc' => 'Ascending',	// TODO
			'c' => array(
				'name_asc' => 'Categoria, titolo del feed A→Z',
				'name_desc' => 'Categoria, titolo del feed Z→A',
			),
			'date_asc' => 'Data di pubblicazione 1→9',
			'date_desc' => 'Data di pubblicazione 9→1',
			'desc' => 'Descending',	// TODO
			'f' => array(
				'name_asc' => 'Titolo del feed A→Z',
				'name_desc' => 'Titolo del feed Z→A',
			),
			'id_asc' => 'Dal meno recente',
			'id_desc' => 'Dal più recente',
			'length_asc' => 'Lunghezza contenuto 1→9',
			'length_desc' => 'Lunghezza contenuto 9→1',
			'link_asc' => 'Link A→Z',	// IGNORE
			'link_desc' => 'Link Z→A',	// IGNORE
			'primary' => array(
				'_' => 'Sorting criterion',	// TODO
				'help' => 'Sorting by <em>received</em> date is recommended in most cases, for consistency and performance',	// TODO
			),
			'rand' => 'Ordine casuale',
			'secondary' => array(
				'_' => 'Secondary sorting criterion',	// TODO
				'help' => 'Only relevant when the primary sorting criterion is categories or feeds titles',	// TODO
			),
			'title_asc' => 'Titolo A→Z',
			'title_desc' => 'Titolo Z→A',
			'user_modified_asc' => 'Modificato dall’utente 1→9',
			'user_modified_desc' => 'Modificato dall’utente 9→1',
		),
		'starred' => 'Mostra solo preferiti',
		'stats' => 'Statistiche',
		'subscription' => 'Gestione sottoscrizioni',
		'unread' => 'Mostra solo non letti',
	),
	'share' => 'Condividi',
	'tag' => array(
		'related' => 'Tags correlati',
	),
	'tos' => array(
		'title' => 'Termini e condizioni del servizio',
	),
);
