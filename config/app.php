<?php
/**
 * Date: 2017/6/14
 * Time: 11:49
 */

$config = [
    'debug' => env('APP_DEBUG', false),
    'environment' => env('APP_ENV', 'production'),
    'url' => env('APP_URL', 'http://localhost'),
    'timezone' => 'Asia/Shanghai',
    'components' => [
        'redis' => [
            'class' => 'Moon\Cache\Redis',
            'host' => env('REDIS_HOST', 'localhost'),
            'port' => env('REDIS_PORT', 6379),
            'password' => env('REDIS_PASSWORD'),
            'database' => env('REDIS_DATABASE', 0)
        ]
    ]
];

$db = include __DIR__ . '/db.php';
$config['components'] = array_merge($config['components'], $db);

return $config;