<?php
/**
 * Date: 2018/1/12
 * Time: 16:12
 */
namespace App\Models;


use Moon\Db\Table;

class User extends Table
{
    protected $primaryKey = 'id';

    public static function tableName()
    {
        return '{{user}}';
    }

    /**
     * @return \Moon\Db\Connection
     */
    public static function getDb()
    {
        return \App::$container->get('db');
    }
}