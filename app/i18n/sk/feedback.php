<?php

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
			'failed' => 'Your password cannot be modified',	// TODO - Translation
			'updated' => 'Your password has been modified',	// TODO - Translation
		),
	),
	'auth' => array(
		'form' => array(
			'not_set' => 'Nastavl problém pri nastavovaní prihlasovacieho systému. Prosím, skúste to znova neskôr.',
			'set' => 'Webový formulár je teraz váš prednastavený prihlasovací spôsob.',
		),
		'login' => array(
			'invalid' => 'Nesprávne prihlasovacie údaje',
			'success' => 'Úspešne ste sa prihlásili',
		),
		'logout' => array(
			'success' => 'Boli ste odhlásený',
		),
		'no_password_set' => 'Heslo administrátora nebolo nastavené. Táto funkcia nie je dostupná.',
	),
	'conf' => array(
		'error' => 'Vyskytla sa chyba počas ukladania nastavaní',
		'query_created' => 'Dopyt "%s" bol vytvorený.',
		'shortcuts_updated' => 'Skratky boli aktualizované',
		'updated' => 'Nastavenia boli aktualizované',
	),
	'extensions' => array(
		'already_enabled' => '%s už je povolené',
		'cannot_remove' => '%s cannot be removed',	// TODO - Translation
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
		'removed' => '%s removed',	// TODO - Translation
	),
	'import_export' => array(
		'export_no_zip_extension' => 'ZIP rozšírenie sa na vašom serveri nenachádza. Prosím, skúste exportovať súbory pojednom.',
		'feeds_imported' => 'Váš kanál bol importovaný a bude aktualizovaný',
		'feeds_imported_with_errors' => 'Vaše kanály boli importované, ale vyskytli sa chyby',
		'file_cannot_be_uploaded' => 'Súbor sa nepodarilo nahrať!',
		'no_zip_extension' => 'ZIP rozšírenie sa na vašom serveri nenachádza.',
		'zip_error' => 'Počas importovania ZIP sa vyskytla chyba.',
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
			'cache_cleared' => '<em>%s</em> cache has been cleared',	// TODO - Translation
			'deleted' => 'Kanál bol vymazaný',
			'error' => 'Kanál sa nepodarilo aktualizovať',
			'internal_problem' => 'Kanál sa nepodarilo pridať. <a href="%s">Prečítajte si záznamy FreshRSS</a>, ak chcete poznať podrobnosti. Skúste pridať kanál pomocou <code>#force_feed</code> v odkaze (URL).',
			'invalid_url' => 'Odkaz <em>%s</em> je neplatný',
			'n_actualized' => 'Počet aktualizovaných kanálov: %d',
			'n_entries_deleted' => 'Počet vymazaných článkov: %d',
			'no_refresh' => 'Žiadny kanál sa neaktualizoval…',
			'not_added' => 'Kanál <em>%s</em> sa nepodarilo pridať',
			'not_found' => 'Feed cannot be found',	// TODO - Translation
			'over_max' => 'Dosiahli ste limit počtu kanálov (%d)',
			'reloaded' => '<em>%s</em> has been reloaded',	// TODO - Translation
			'selector_preview' => array(
				'http_error' => 'Failed to load website content.',	// TODO - Translation
				'no_entries' => 'There are no articles in this feed. You need at least one article to create a preview.',	// TODO - Translation
				'no_feed' => 'Internal error (feed cannot be found).',	// TODO - Translation
				'no_result' => 'The selector didn\'t match anything. As a fallback the original feed text will be displayed instead.',	// TODO - Translation
				'selector_empty' => 'The selector is empty. You need to define one to create a preview.',	// TODO - Translation
			),
			'updated' => 'Kanál bol aktualizovaný',
		),
		'purge_completed' => 'Čistenie ukončené. Počet vymazaných článkov: %d',
	),
	'tag' => array(
		'created' => 'Tag "%s" has been created.',	// TODO - Translation
		'name_exists' => 'Tag name already exists.',	// TODO - Translation
		'renamed' => 'Tag "%s" has been renamed to "%s".',	// TODO - Translation
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
