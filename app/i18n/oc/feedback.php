<?php

return array(
	'access' => array(
		'denied' => 'Avètz pas l’autorizacion d’accedir a aquesta pagina',
		'not_found' => 'La pagina que cercatz existís pas',
	),
	'admin' => array(
		'optimization_complete' => 'Optimizacion acabada',
	),
	'api' => array(
		'password' => array(
			'failed' => 'Vòstre senhal pòt pas èsser modificat',
			'updated' => 'Vòstre senhal es estat modificat',
		),
	),
	'auth' => array(
		'form' => array(
			'not_set' => 'Un problèma es aparegut pendent la configuracion del sistèma d’autentificacion. Tonatz ensajar ai tard.',
			'set' => 'Lo sistèma d’autentificacion per defaut es ara lo formulari.',
		),
		'login' => array(
			'invalid' => 'L’identificant es invalid',
			'success' => 'Sètz connectat',
		),
		'logout' => array(
			'success' => 'Sètz desconnectat',
		),
		'no_password_set' => 'Pas de senhal es pas configurat. Aquesta foncionalitat es pas disponibla.',
	),
	'conf' => array(
		'error' => 'Una error es apareguda pendent la salvagarda de la configuracion',
		'query_created' => 'Lo filtre « %s » es estat creat.',
		'shortcuts_updated' => 'Los acorchis son actualizats',
		'updated' => 'La configuracion es estada actualizada',
	),
	'extensions' => array(
		'already_enabled' => '%s es ja activada',
		'cannot_delete' => '%s cannot be deleted',	// TODO - Translation
		'disable' => array(
			'ko' => '%s pòt pas èsser desactivada. <a href="%s">Consultatz los jornals d’audit de FreshRSS logs</a> per mai de detalhs.',
			'ok' => '%s es ara desactivada',
		),
		'enable' => array(
			'ko' => '%s pòt pas èsser activada. <a href="%s">Consultatz los jornals d’audit de FreshRSS logs</a> per mai de detalhs.',
			'ok' => '%s es ara activada',
		),
		'no_access' => 'Avètz pas accès sus %s',
		'not_enabled' => '%s es pas encara activada',
		'not_found' => '%s existís pas',
		'removed' => '%s removed',	// TODO - Translation
	),
	'import_export' => array(
		'export_no_zip_extension' => 'L\'extension ZIP es pas presenta sul servidor. Volgatz ensajar d\'exportar los fichièrs un per un.',
		'feeds_imported' => 'Vòstres fluxes son estats importats seràn actualizats en seguida',
		'feeds_imported_with_errors' => 'Vòstres fluxes son estats importats mas i a agut d’errors',
		'file_cannot_be_uploaded' => 'Telecargament del fichièr impossible',
		'no_zip_extension' => 'L\'extension es pas presenta sul servidor.',
		'zip_error' => 'Una error s’es producha pendent l’importacion del fichièr ZIP.',
	),
	'profile' => array(
		'error' => 'Impossible d’actualizar vòstre perfil',
		'updated' => 'Vòstre perfil es estat actualizat',
	),
	'sub' => array(
		'actualize' => 'Actualizar',
		'articles' => array(
			'marked_read' => 'Los articles seleccionats son estats marcats coma legits.',
			'marked_unread' => 'Los articles seleccionats son estats marcats coma pas legits.',
		),
		'category' => array(
			'created' => 'La categoria « %s » es estada creada.',
			'deleted' => 'La categoria es estada suprimida.',
			'emptied' => 'La categoria es estada voidada',
			'error' => 'Actualizacion de la categoria impossibla',
			'name_exists' => 'Una categoria se ditz ja atal.',
			'no_id' => 'Vos cal precisar l’id de la categoria.',
			'no_name' => 'Vos cal donar un nom a la categoria.',
			'not_delete_default' => 'Podètz pas suprimir la categoria per defaut !',
			'not_exist' => 'Aquesta categoria existís pas !',
			'over_max' => 'Avètz atengut la limita de categoria (%d)',
			'updated' => 'La categoria es estada actualizada.',
		),
		'feed' => array(
			'actualized' => '<em>%s</em> es a jorn',
			'actualizeds' => 'Los fluxes son estats actualizats',
			'added' => 'Lo flux RSS <em>%s</em> es ajustat',
			'already_subscribed' => 'Seguissètz ja <em>%s</em>',
			'cache_cleared' => '<em>%s</em> cache has been cleared',	// TODO - Translation
			'deleted' => 'Lo flux es suprimit',
			'error' => 'Error en actualizar',
			'internal_problem' => 'Lo flux pòt pas èsser ajustat. <a href="%s">Consultatz los jornals d’audit de FreshRSS</a> per ne saber mai. Podètz forçar l’apondon en ajustant <code>#force_feed</code> a l’URL.',
			'invalid_url' => 'L\'URL <em>%s</em> es invalida',
			'n_actualized' => '%s fluxes son estats actualizats',
			'n_entries_deleted' => '%d articles son estats suprimits',
			'no_refresh' => 'I a pas cap de flux d’actualizar…',
			'not_added' => '<em>%s</em> a pas pogut èsser ajustat',
			'not_found' => 'Flux introbable',
			'over_max' => 'Avètz atengut vòstra limita de fluxes (%d)',
			'reloaded' => '<em>%s</em> es estat recargat',
			'selector_preview' => array(
				'http_error' => 'Fracàs del cargament del contengut del site web.',
				'no_entries' => 'I a pas cap d’entrada dins lo flux. Vos cal almens una entrada per crear un apercebut.',
				'no_feed' => 'Error inèrna (cap d’entrada a l’entrada).',
				'no_result' => 'Lo selecctor a pas atrapat res. Coma solucion alternativa lo flux original serà mostrat.',
				'selector_empty' => 'Lo selecctor es void. Vos cal ne definir un per crear un apercebut.',
			),
			'updated' => 'Lo flux es actualizat',
		),
		'purge_completed' => 'Purga realizada (%s articles suprimits)',
	),
	'update' => array(
		'can_apply' => 'FreshRSS es per èsser mes a jorn en <strong>version %s</strong>.',
		'error' => 'La mesa a jorn a conegut un problèma : %s',
		'file_is_nok' => 'Nòva <strong>version %s</strong> disponibla, mas volgatz verificar los dreches sul repertòri <em>%s</em>. Lo servidor HTTP deu poder escriure dedins',
		'finished' => 'Mesa a jorn acabada !',
		'none' => 'Cap de mesa a jorn d’aplicar',
		'server_not_found' => 'Impossible de trobar lo servidor de mesa a jorn. [%s]',
	),
	'user' => array(
		'created' => array(
			'_' => 'L’utilizaire %s es estat creat',
			'error' => 'L’utilizaire %s pòt pas èsser creat',
		),
		'deleted' => array(
			'_' => 'L’utilizaire %s es estat suprimit',
			'error' => 'L’utilizaire %s pòt pas èsser suprimit',
		),
		'updated' => array(
			'_' => 'L’utilizaire %s es estat actualizat',
			'error' => 'L’utilizaire %s es pas estat actualizat',
		),
	),
);
