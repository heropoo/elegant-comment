<?php
/**
 * Date: 2018/7/12
 * Time: 23:14
 */

return [
    'db' => [
        'class' => 'Moon\Db\Connection',
        'master' => [
            'dsn' => 'mysql:host=' . env('DB_HOST', 'localhost')
                . ';dbname=' . env('DB_NAME', 'test') . ';port=' . env('DB_PORT', '3306'),
            'username' => env('DB_USER', 'root'),
            'password' => env('DB_PWD', ''),
            'charset' => 'utf8mb4',
            'tablePrefix' => env('DB_TABLE_PREFIX', ''),
            'emulatePrepares' => false,
            'options' => [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                //PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"
            ]
        ]
    ],
];