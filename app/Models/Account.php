<?php
/**
 * Date: 2018/1/12
 * Time: 16:12
 */

namespace App\Models;


use Moon\Db\Table;

/**
 * Class App\Models\Account 
 * @property integer $id 
 * @property string $app_id APP_ID
 * @property string $app_key APP_KEY
 * @property string $allow_origin 允许访问的域名
 * @property integer $status 0正常 -1禁止
 * @property string $created_at 
 * @property string $updated_at 
 */
class Account extends Table
{
    protected $primaryKey = 'id';

    const STATUS_NORMAL = 0;

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