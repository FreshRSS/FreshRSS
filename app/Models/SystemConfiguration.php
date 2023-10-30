<?php

declare(strict_types=1);

/**
 * @property bool $allow_anonymous
 * @property bool $allow_anonymous_refresh
 * @property-read bool $allow_referrer
 * @property-read bool $allow_robots
 * @property bool $api_enabled
 * @property string $archiving
 * @property 'form'|'http_auth'|'none' $auth_type
 * @property string $auto_update_url
 * @property-read array<int,mixed> $curl_options
 * @property string $default_user
 * @property string $email_validation_token
 * @property bool $force_email_validation
 * @property-read bool $http_auth_auto_register
 * @property-read string $http_auth_auto_register_email_field
 * @property-read string $language
 * @property array<string,int> $limits
 * @property-read string $logo_html
 * @property-read string $meta_description
 * @property-read bool $pubsubhubbub_enabled
 * @property-read string $salt
 * @property-read bool $simplepie_syslog_enabled
 * @property bool $unsafe_autologin_enabled
 * @property array<string> $trusted_sources
 */
final class FreshRSS_SystemConfiguration extends Minz_Configuration {

	/** @throws Minz_ConfigurationNamespaceException */
	public static function init(string $config_filename, ?string $default_filename = null): FreshRSS_SystemConfiguration {
		parent::register('system', $config_filename, $default_filename);
		return parent::get('system');
	}
}
