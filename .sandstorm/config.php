
<?php
return array (
  'environment' => 'production',
  'salt' => 'sandsalt',
  'title' => 'FreshRSS',
  'default_user' => 'sandcat',
  'auth_type' => 'http_auth',
  'db' =>
  array (
    'type' => 'mysql',
    'host' => 'localhost',
    'user' => 'root',
    'password' => '',
    'base' => 'freshrss',
    'prefix' => false,
  ),
  'allow_anonymous' => false,
  'allow_anonymous_refresh' => true,
  'unsafe_autologin_enabled' => false,
  'api_enabled' => true,
  'extensions_enabled' => array(),
);
