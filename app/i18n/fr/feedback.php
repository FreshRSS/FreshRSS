<?php

return array(
	'auth' => array(
		'form' => array(
			'not_set' => 'Un problème est survenu lors de la configuration de votre système d’authentification. Veuillez réessayer plus tard.',
			'set' => 'Le formulaire est désormais votre système d’authentification.',
		),
		'login' => array(
			'invalid' => 'L’identifiant est invalide',
			'success' => 'Vous êtes désormais connecté',
		),
		'logout' => array(
			'success' => 'Vous avez été déconnecté',
		),
		'no_password_set' => 'Aucun mot de passe administrateur n’a été précisé. Cette fonctionnalité n’est pas disponible.',
		'not_persona' => 'Seul le système d’authentification Persona peut être réinitialisé.',
	),
	'configuration' => array(
		'updated' => 'La configuration a été mise à jour',
		'error' => 'Une erreur est survenue en sauvegardant la configuration',
	),
	'import_export' => array(
		'export_no_zip_extension' => 'L’extension Zip n’est pas présente sur votre serveur. Veuillez essayer d’exporter les fichiers un par un.',
		'feeds_imported' => 'Vos flux ont été importés et vont maintenant être actualisés.',
		'feeds_imported_with_errors' => 'Vos flux ont été importés mais des erreurs sont survenues.',
		'file_cannot_be_uploaded' => 'Le fichier ne peut pas être téléchargé !',
		'no_zip_extension' => 'L’extension Zip n’est pas présente sur votre serveur.',
		'zip_error' => 'Une erreur est survenue durant l’import du fichier Zip.',
	),
	'sub' => array(
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
			'error' => 'Le flux n’a pas pu être modifié',
			'over_max' => 'Vous avez atteint votre limite de flux (%d)',
			'updated' => 'Le flux a été mis à jour',
		),
	),
	'user_profile' => array(
		'updated' => 'Votre profil a été mis à jour',
	),
);
