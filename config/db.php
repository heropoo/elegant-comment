<?php
/**
 * Created by PhpStorm.
 * User: ttt
 * Date: 2018/7/12
 * Time: 23:14
 */

return [
    'class'=>\Moon\Db\Connection::class,
    'dsn' => 'mysql:host='.env('DB_HOST', 'localhost').';dbname='.env('DB_NAME', 'test').';port=3306',
    'username' => env('DB_USER','root'),
    'password' => env('DB_PWD', ''),
    'charset' => 'utf8mb4',
    'tablePrefix' => env('DB_TABLE_PREFIX', ''),
    'emulatePrepares' => false,
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]
];