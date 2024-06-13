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
	'access' => array(
		'denied' => 'Na prístup k tejto stránke nemáte oprávnenie',
		'not_found' => 'Hľadáte stránku, ktorá neexistuje',
	),
	'admin' => array(
		'optimization_complete' => 'Optimalizácia dokončená',
	),
	'api' => array(
		'password' => array(
			'failed' => 'Vaše heslo sa nepodarilo zmeniť',
			'updated' => 'Vaše heslo bolo zmenené',
		),
	),
	'auth' => array(
		'login' => array(
			'invalid' => 'Nesprávne prihlasovacie údaje',
			'success' => 'Úspešne ste sa prihlásili',
		),
		'logout' => array(
			'success' => 'Boli ste odhlásený',
		),
	),
	'conf' => array(
		'error' => 'Vyskytla sa chyba počas ukladania nastavaní',
		'query_created' => 'Dopyt “%s” bol vytvorený.',
		'shortcuts_updated' => 'Skratky boli aktualizované',
		'updated' => 'Nastavenia boli aktualizované',
	),
	'extensions' => array(
		'already_enabled' => '%s už je povolené',
		'cannot_remove' => '%s sa nepodarilo odstrániť',
		'disable' => array(
			'ko' => '%s sa nepodarilo nainštalovať. <a href="%s">Prečítajte si záznamy FreshRSS</a>, ak chcete poznať podrobnosti.',
			'ok' => '%s je teraz zakázaný',
		),
		'enable' => array(
			'ko' => '%s sa nepodarilo povoliť. <a href="%s">Prečítajte si záznamy FreshRSS</a>, ak chcete poznať podrobnosti.',
			'ok' => '%s je teraz povolený',
		),
		'no_access' => 'Nemáte prístup k %s',
		'not_enabled' => '%s nie je povolený',
		'not_found' => '%s neexistuje',
		'removed' => '%s odstránené',
	),
	'import_export' => array(
		'export_no_zip_extension' => 'ZIP rozšírenie sa na vašom serveri nenachádza. Prosím, skúste exportovať súbory pojednom.',
		'feeds_imported' => 'Vaše kanály boli importované. Ak ste s importovaním skončili, kliknite na tlačidlo <i>Aktualizovať kanále</i>.',
		'feeds_imported_with_errors' => 'Vaše kanály boli importované, ale vyskytli sa chyby. Ak ste s importovaním skončili, kliknite na tlačidlo <i>Aktualizovať kanále</i>.',
		'file_cannot_be_uploaded' => 'Súbor sa nepodarilo nahrať!',
		'no_zip_extension' => 'ZIP rozšírenie sa na vašom serveri nenachádza.',
		'zip_error' => 'Počas importovania ZIP súboru sa vyskytla chyba.',
	),
	'profile' => array(
		'error' => 'Váš profil nie je možné upraviť',
		'updated' => 'Váš profil bol upravený',
	),
	'sub' => array(
		'actualize' => 'Aktualizácia',
		'articles' => array(
			'marked_read' => 'Vybraté články boli označené ako prečítané.',
			'marked_unread' => 'Články boli označené ako neprečítané.',
		),
		'category' => array(
			'created' => 'Kategória %s bola vytvorená.',
			'deleted' => 'Kategória bola odstránená.',
			'emptied' => 'Kategória bola vyprázdnená',
			'error' => 'Nepodarilo sa aktualizovať kategóriu',
			'name_exists' => 'Názov kategórie už existuje.',
			'no_id' => 'Musíte zadať ID kategórie.',
			'no_name' => 'Názov kategórie nemôže byť prázdny.',
			'not_delete_default' => 'Nemôžete odstrániť prednastavenú kategóriu!',
			'not_exist' => 'Kategória neexistuje!',
			'over_max' => 'Dosiahli ste limit počtu kategórií (%d)',
			'updated' => 'Kategória bola aktualizovaná.',
		),
		'feed' => array(
			'actualized' => '<em>%s</em> bol aktualizovaný',
			'actualizeds' => 'RSS kanál bol aktualizovaný',
			'added' => 'RSS kanál <em>%s</em> bol pridaný',
			'already_subscribed' => 'Tento RSS kanál už odoberáte: <em>%s</em>',
			'cache_cleared' => '<em>%s</em> vyrovnávacia pamäť bola vymazaná',
			'deleted' => 'Kanál bol vymazaný',
			'error' => 'Kanál sa nepodarilo aktualizovať',
			'internal_problem' => 'Kanál sa nepodarilo pridať. <a href="%s">Prečítajte si záznamy FreshRSS</a>, ak chcete poznať podrobnosti. Skúste pridať kanál pomocou <code>#force_feed</code> v odkaze (URL).',
			'invalid_url' => 'Odkaz <em>%s</em> je neplatný',
			'n_actualized' => 'Počet aktualizovaných kanálov: %d',
			'n_entries_deleted' => 'Počet vymazaných článkov: %d',
			'no_refresh' => 'Žiadny kanál sa neaktualizoval…',
			'not_added' => 'Kanál <em>%s</em> sa nepodarilo pridať',
			'not_found' => 'Kanál sa nepodarilo nájsť',
			'over_max' => 'Dosiahli ste limit počtu kanálov (%d)',
			'reloaded' => '<em>%s</em> bol obnovený',
			'selector_preview' => array(
				'http_error' => 'Nepodarilo sa načítať obsah stránky.',
				'no_entries' => 'V tomto kanáli nie sú články. Na vytvorenie náhľadu je potrebný aspoň jeden článok.',
				'no_feed' => 'Vnútorná chyba (kanál sa nepodarilo nájsť).',
				'no_result' => 'Selektor nič neoznačil. Bude sa zobrazovať pôvodný text kanála.',
				'selector_empty' => 'Selektor je prázdny. Na vytvorenie náhľadu je potrebné definovať selektor.',
			),
			'updated' => 'Kanál bol aktualizovaný',
		),
		'purge_completed' => 'Čistenie ukončené. Počet vymazaných článkov: %d',
	),
	'tag' => array(
		'created' => 'Štítok “%s” bol vytvorený.',
		'error' => 'Štítok sa nepodarilo aktualizovať!',
		'name_exists' => 'Názov štítku už existuje.',
		'renamed' => 'Štítok “%s” bol premenovaný na “%s”.',
		'updated' => 'Štítok bol aktualizovaný.',
	),
	'update' => array(
		'can_apply' => 'FreshRSS sa teraz aktualizuje <strong>na verziu %s</strong>.',
		'error' => 'Počas aktualizácie sa vyskytla chyba: %s',
		'file_is_nok' => 'Je dostupná nová <strong>verzia %s</strong>, ale skontrolujte prístupové práva priečinka <em>%s</em>. HTTP server musí mať právo doň zapisovať.',
		'finished' => 'Aktualizácia prebehla úspešne!',
		'none' => 'Žiadne aktualizácie',
		'server_not_found' => 'Nepodarilo sa nájsť server s aktualizáciami. [%s]',
	),
	'user' => array(
		'created' => array(
			'_' => 'Používateľ %s bol vytvorený',
			'error' => 'Používateľ %s nebol vytvorený',
		),
		'deleted' => array(
			'_' => 'Používateľ %s bol vymazaný',
			'error' => 'Používateľ %s nebol vymazaný',
		),
		'updated' => array(
			'_' => 'Používateľ %s bol aktualizovaný',
			'error' => 'Používateľ %s nebol aktualizovaný',
		),
	),
);
