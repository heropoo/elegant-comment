<?php
/**
 * Date: 2018/7/12
 * Time: 23:14
 */

return [
    'db' => [
        'class' => 'Moon\Db\Connection',
        //'auto_inject_by_class'=> true, // default true
        'master' => [
            'dsn' => 'mysql:host=' . env('DB_HOST', 'localhost')
                . ';dbname=' . env('DB_NAME', 'test') . ';port=' . env('DB_PORT', '3306'),
            'username' => env('DB_USER', 'root'),
            'password' => env('DB_PWD', ''),
            'charset' => 'utf8mb4',
            'tablePrefix' => 'tt_',
            'emulatePrepares' => false,
            'options' => [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                //PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"
            ]
        ]
    ],
    'db2' => [
        'class' => 'Moon\Db\Connection',
        'auto_inject_by_class'=> false, // default true  // If you components have duplicate class name like above "db"
        'master' => [
            'dsn' => 'mysql:host=' . env('DB2_HOST', 'localhost')
                . ';dbname=' . env('DB2_NAME', 'test') . ';port=' . env('DB2_PORT', '3306'),
            'username' => env('DB2_USER', 'root'),
            'password' => env('DB2_PWD', ''),
            'charset' => 'utf8mb4',
            'tablePrefix' => 'tt_',
            'emulatePrepares' => false,
            'options' => [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                //PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"
            ]
        ]
    ],

];