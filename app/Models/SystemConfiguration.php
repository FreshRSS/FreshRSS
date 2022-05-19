<?php

/**
 * @property bool $allow_anonymous
 * @property bool $allow_anonymous_refresh
 * @property-read bool $allow_referrer
 * @property-read bool $allow_robots
 * @property bool $api_enabled
 * @property string $archiving
 * @property string $auth_type
 * @property string $auto_update_url
 * @property-read array<int,mixed> $curl_options
 * @property string $default_user
 * @property string $email_validation_token
 * @property bool $force_email_validation
 * @property-read bool $http_auth_auto_register
 * @property-read string $http_auth_auto_register_email_field
 * @property-read string $language
 * @property array<string,int> $limits
 * @property-read string $meta_description
 * @property-read bool $pubsubhubbub_enabled
 * @property-read string $salt
 * @property-read bool $simplepie_syslog_enabled
 * @property string $unsafe_autologin_enabled
 * @property-read array<string> $trusted_sources
 */
class FreshRSS_SystemConfiguration extends Minz_Configuration {

}
