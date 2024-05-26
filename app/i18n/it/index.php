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
		'_' => 'Informazioni',
		'agpl3' => '<a href="https://www.gnu.org/licenses/agpl-3.0.html">AGPL 3</a>',	// IGNORE
		'bugs_reports' => 'Bugs',
		'credits' => 'Crediti',
		'credits_content' => 'Alcuni elementi di design provengono da <a href="http://twitter.github.io/bootstrap/">Bootstrap</a> sebbene FreshRSS non usi questo framework. Le <a href="https://gitlab.gnome.org/Archive/gnome-icon-theme-symbolic">icone</a> provengono dal progetto <a href="https://www.gnome.org/">GNOME</a>. Il carattere <em>Open Sans</em> è stato creato da <a href="https://fonts.google.com/specimen/Open+Sans">Steve Matteson</a>. FreshRSS è basato su <a href="https://framagit.org/marienfressinaud/MINZ">Minz</a>, un framework PHP.',
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
		'rss_of' => 'RSS feed di %s',
		'title' => 'Flusso principale',
		'title_fav' => 'Preferiti',
		'title_global' => 'Vista globale per categorie',
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
		'newer_first' => 'Mostra prima i recenti',
		'non-starred' => 'Escludi preferiti',
		'normal_view' => 'Vista elenco',
		'older_first' => 'Ordina per meno recenti',
		'queries' => 'Chiavi di ricerca',
		'read' => 'Mostra solo letti',
		'reader_view' => 'Modalità di lettura',
		'rss_view' => 'Feed RSS',
		'search_short' => 'Cerca',
		'starred' => 'Mostra solo preferiti',
		'stats' => 'Statistiche',
		'subscription' => 'Gestione sottoscrizioni',
		'tags' => 'Le mie etichette',
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
