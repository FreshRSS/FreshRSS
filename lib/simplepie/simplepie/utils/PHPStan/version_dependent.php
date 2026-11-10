<?php

namespace SimplePieUtils\PHPStan;

$typeAliases = [];

if (PHP_VERSION_ID < 80000) {
    $typeAliases['\CurlHandle'] = 'resource';
}

return [
    'parameters' => [
        'typeAliases' => $typeAliases,
    ],
];
