<?php
/**
 * Date: 2020/4/15
 * Time: 15:11
 */

namespace App\Models;

use Moon\Db\Table;

class Comment extends Table
{
    protected $primaryKey = 'id';

    public static function tableName()
    {
        return '{{comment}}';
    }

    /**
     * @return \Moon\Db\Connection
     */
    public static function getDb()
    {
        return \App::$container->get('db');
    }
}