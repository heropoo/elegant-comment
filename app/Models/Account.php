<?php
/**
 * Date: 2018/1/12
 * Time: 16:12
 */

namespace App\Models;


use Moon\Db\Table;

class Account extends Table
{
    protected $primaryKey = 'id';

    public static function tableName()
    {
        return '{{account}}';
    }

    /**
     * @return \Moon\Db\Connection
     */
    public static function getDb()
    {
        return \App::$container->get('db');
    }
}