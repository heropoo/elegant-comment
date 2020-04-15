<?php
/**
 * Date: 2019-11-05
 * Time: 18:40
 */
$routes_path = dirname(__DIR__) . '/routes';
return [
    'namespace' => "App\\Controllers",
    'middleware' => [],
    'groups' => [
        'web' => [
            'file' => $routes_path . '/web.php',
            //'namespace' => '',
            //'prefix' => '',
//            'middleware' => [
//                'App\Middleware\SessionStart',
//            ]
        ],
        'api' => [
            'file' => $routes_path . '/api.php',
            'namespace' => 'Api',
            'prefix' => 'api',
            'middleware' => [],
        ],
    ]
];