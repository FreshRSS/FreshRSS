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
		'denied' => 'Vous n’avez pas le droit d’accéder à cette page !',
		'not_found' => 'La page que vous cherchez n’existe pas !',
	),
	'admin' => array(
		'optimization_complete' => 'Optimisation terminée.',
	),
	'api' => array(
		'password' => array(
			'failed' => 'Votre mot de passe n’a pas pu être mis à jour',
			'updated' => 'Votre mot de passe a été mis à jour',
		),
	),
	'auth' => array(
		'login' => array(
			'invalid' => 'L’identifiant est invalide',
			'success' => 'Vous êtes désormais connecté',
		),
		'logout' => array(
			'success' => 'Vous avez été déconnecté',
		),
	),
	'conf' => array(
		'error' => 'Une erreur est survenue durant la sauvegarde de la configuration',
		'query_created' => 'Le filtre <em>%s</em> a bien été créé.',
		'shortcuts_updated' => 'Les raccourcis ont été mis à jour.',
		'updated' => 'La configuration a été mise à jour',
	),
	'extensions' => array(
		'already_enabled' => '%s est déjà activée',
		'cannot_remove' => '%s ne peut pas être supprimée',
		'disable' => array(
			'ko' => '%s ne peut pas être désactivée. <a href="%s">Consulter les logs de FreshRSS</a> pour plus de détails.',
			'ok' => '%s est désormais désactivée',
		),
		'enable' => array(
			'ko' => '%s ne peut pas être activée. <a href="%s">Consulter les logs de FreshRSS</a> pour plus de détails.',
			'ok' => '%s est désormais activée',
		),
		'no_access' => 'Vous n’avez aucun accès sur %s',
		'not_enabled' => '%s n’est pas encore activée',
		'not_found' => '%s n’existe pas',
		'removed' => '%s a été supprimée',
	),
	'import_export' => array(
		'export_no_zip_extension' => 'L’extension ZIP n’est pas présente sur votre serveur. Veuillez essayer d’exporter les fichiers un par un.',
		'feeds_imported' => 'Vos flux ont été importés.	Si vous avez fini vos importations, vous pouvez cliquer le bouton <i>Actualiser flux</i>.',
		'feeds_imported_with_errors' => 'Vos flux ont été importés mais des erreurs sont survenues.	Si vous avez fini vos importations, vous pouvez cliquer le bouton <i>Actualiser flux</i>.',
		'file_cannot_be_uploaded' => 'Le fichier ne peut pas être téléchargé !',
		'no_zip_extension' => 'L’extension ZIP n’est pas présente sur votre serveur.',
		'zip_error' => 'Une erreur est survenue durant le traitement du fichier ZIP.',
	),
	'profile' => array(
		'error' => 'Votre profil n’a pas pu être mis à jour',
		'updated' => 'Votre profil a été mis à jour',
	),
	'sub' => array(
		'actualize' => 'Actualiser',
		'articles' => array(
			'marked_read' => 'Les articles sélectionnés ont été marqués comme lus.',
			'marked_unread' => 'Les articles sélectionnés ont été marqués comme non-lus.',
		),
		'category' => array(
			'created' => 'La catégorie %s a été créée.',
			'deleted' => 'La catégorie a été supprimée.',
			'emptied' => 'La catégorie a été vidée.',
			'error' => 'La catégorie n’a pas pu être modifiée',
			'name_exists' => 'Une catégorie possède déjà ce nom.',
			'no_id' => 'Vous devez préciser l’id de la catégorie.',
			'no_name' => 'Vous devez préciser un nom pour la catégorie.',
			'not_delete_default' => 'Vous ne pouvez pas supprimer la catégorie par défaut !',
			'not_exist' => 'Cette catégorie n’existe pas !',
			'over_max' => 'Vous avez atteint votre limite de catégories (%d)',
			'updated' => 'La catégorie a été mise à jour.',
		),
		'feed' => array(
			'actualized' => '<em>%s</em> a été mis à jour.',
			'actualizeds' => 'Les flux ont été mis à jour.',
			'added' => 'Le flux <em>%s</em> a bien été ajouté.',
			'already_subscribed' => 'Vous êtes déjà abonné à <em>%s</em>',
			'cache_cleared' => 'Le cache de <em>%s</em> a été vidée.',
			'deleted' => 'Le flux a été supprimé.',
			'error' => 'Une erreur est survenue',
			'internal_problem' => 'Le flux ne peut pas être ajouté. <a href="%s">Consulter les logs de FreshRSS</a> pour plus de détails. Vous pouvez essayer de forcer l’ajout par addition de <code>#force_feed</code> à l’URL.',
			'invalid_url' => 'L’url <em>%s</em> est invalide.',
			'n_actualized' => '%d flux ont été mis à jour.',
			'n_entries_deleted' => '%d articles ont été supprimés.',
			'no_refresh' => 'Il n’y a aucun flux à actualiser…',
			'not_added' => '<em>%s</em> n’a pas pu être ajouté.',
			'not_found' => 'Le flux n’a pas pu être trouvé.',
			'over_max' => 'Vous avez atteint votre limite de flux (%d)',
			'reloaded' => '<em>%s</em> a été rechargé.',
			'selector_preview' => array(
				'http_error' => 'Échec lors du chargement du contenu du site web.',
				'no_entries' => 'Il n’y a pas d’articles dans ce flux. Vous devez avoir au moins un article pour générer une prévisualisation.',
				'no_feed' => 'Erreur interne (le flux n’a pas pu être trouvé).',
				'no_result' => 'Le sélecteur n’a produit aucune concordance. Dans ces circonstances, le texte original du flux sera affiché.',
				'selector_empty' => 'Le sélecteur est vide. Vous devez en définir un pour générer une prévisualisation.',
			),
			'updated' => 'Le flux a été mis à jour',
		),
		'purge_completed' => 'Purge effectuée (%d articles supprimés).',
	),
	'tag' => array(
		'created' => 'L’étiquette <em>%s</em> a été créée.',
		'error' => 'L’étiquette n’a pas pu être modifiée',
		'name_exists' => 'L’étiquette existe déjà!',
		'renamed' => 'L’étiquette <em>%s</em> a été renommée en <em>%s</em>.',
		'updated' => 'L’étiquette a été mise à jour.',
	),
	'update' => array(
		'can_apply' => 'FreshRSS va maintenant être mis à jour vers la <strong>version %s</strong>.',
		'error' => 'La mise à jour a rencontré un problème : %s',
		'file_is_nok' => 'Nouvelle <strong>version %s</strong> disponible, mais veuillez vérifier les droits sur le répertoire <em>%s</em>. Le serveur HTTP doit être capable d’écrire dedans',
		'finished' => 'La mise à jour est terminée !',
		'none' => 'Aucune mise à jour à appliquer',
		'server_not_found' => 'Le serveur de mise à jour n’a pas été trouvé. [%s]',
	),
	'user' => array(
		'created' => array(
			'_' => 'L’utilisateur %s a été créé.',
			'error' => 'L’utilisateur %s ne peut pas être créé.',
		),
		'deleted' => array(
			'_' => 'L’utilisateur %s a été supprimé.',
			'error' => 'L’utilisateur %s ne peut pas être supprimé.',
		),
		'updated' => array(
			'_' => 'L’utilisateur %s a été mis à jour',
			'error' => 'L’utilisateur %s n’a pas été mis à jour',
		),
	),
);
