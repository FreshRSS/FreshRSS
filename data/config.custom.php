<?php

# Do not modify this file, which defines default values,
# but instead edit `./data/config.php` after the install process is completed,
# or edit `./data/config.custom.php` before the install process.
return array(
	# Specify address of the FreshRSS instance,
	# used when building absolute URLs, e.g. for WebSub.
	# Examples:
	# https://example.net/FreshRSS/p/
	# https://freshrss.example.net/
	'base_url' => 'https://lindenrss.fly.dev/',

	# Natural language of the user interface, e.g. `en`, `fr`.
	'language' => 'cn',

	# Allow or not the use of the API, used for mobile apps.
	#	End-point is https://freshrss.example.net/api/greader.php
	#	You need to set the user’s API password.
	'api_enabled' => true,

	# Enable or not support of PubSubHubbub.
	# /!\ It should NOT be enabled if base_url is not reachable by an external server.
	'pubsubhubbub_enabled' => true,

	'db' => [

		# Type of database: `sqlite` or `mysql` or 'pgsql'
		'type' => 'pgsql',

		# Database server
		'host' => 'freshrss-lindenxing.k.aivencloud.com',

		# Database user
		'user' => '',

		# Database password
		'password' => '',

		# Database name
		'base' => 'defaultdb',

		# Tables prefix (useful if you use the same database for multiple things)
		'prefix' => 'freshrss_',

		# Additional connection string parameters, such as PostgreSQL 'sslmode=??;sslrootcert=??'
		# https://www.postgresql.org/docs/current/libpq-connect.html#LIBPQ-PARAMKEYWORDS
		'connection_uri_params' => '',

		# Additional PDO parameters, such as offered by MySQL https://php.net/ref.pdo-mysql
		'pdo_options' => [
			//PDO::MYSQL_ATTR_SSL_KEY	=> '/path/to/client-key.pem',
			//PDO::MYSQL_ATTR_SSL_CERT	=> '/path/to/client-cert.pem',
			//PDO::MYSQL_ATTR_SSL_CA	=> '/path/to/ca-cert.pem',
		],

	],
);
