<?php

return array(
	'auth' => array(
		'form' => array(
			'not_set' => 'A problem occured during authentication system configuration. Please retry later.',
			'set' => 'Form is now your default authentication system.',
		),
		'login' => array(
			'invalid' => 'Login is invalid',
			'success' => 'You are connected',
		),
		'logout' => array(
			'success' => 'You are disconnected',
		),
		'no_password_set' => 'Administrator password hasn’t been set. This feature isn’t available.',
		'not_persona' => 'Only Persona system can be reset.',
	),
	'configuration' => array(
		'updated' => 'Configuration has been updated',
		'error' => 'An error occurred during configuration saving',
	),
	'import_export' => array(
		'export_no_zip_extension' => 'Zip extension is not present on your server. Please try to export files one by one.',
		'feeds_imported' => 'Your feeds have been imported and will now be updated',
		'feeds_imported_with_errors' => 'Your feeds have been imported but some errors occurred',
		'file_cannot_be_uploaded' => 'File cannot be uploaded!',
		'no_zip_extension' => 'Zip extension is not present on your server.',
		'zip_error' => 'An error occured during Zip import.',
	),
	'sub' => array(
		'category' => array(
			'created' => 'Category %s has been created.',
			'deleted' => 'Category has been deleted.',
			'emptied' => 'Category has been emptied',
			'error' => 'Category cannot be updated',
			'name_exists' => 'Category name already exists.',
			'no_id' => 'You must precise the id of the category.',
			'no_name' => 'Category name cannot be empty.',
			'not_delete_default' => 'You cannot delete the default category!',
			'not_exist' => 'The category does not exist!',
			'over_max' => 'You have reached your limit of categories (%d)',
			'updated' => 'Category has been updated.',
		),
		'feed' => array(
			'error' => 'Feed cannot be updated',
			'over_max' => 'You have reached your limit of feeds (%d)',
			'updated' => 'Feed has been updated',
		),
	),
	'user_profile' => array(
		'updated' => 'Your profile has been modified',
	),
);
