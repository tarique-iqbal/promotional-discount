<?php

declare(strict_types=1);

$config = [
    'data_source' => [
        'directory' => 'var/data',
        'file_name' => 'product.json'
    ],
    'error_log' => [
        'directory' => 'var/logs',
        'file_name' => 'errors.log'
    ],
];

return $config;
