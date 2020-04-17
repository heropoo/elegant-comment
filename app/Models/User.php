<?php
/**
 * Date: 2018/1/12
 * Time: 16:12
 */
namespace App\Models;


use Moon\Db\Table;

/**
 * Class App\Models\User 
 * @property integer $id 
 * @property string $nickname 昵称
 * @property string $head_img 头像
 * @property string $email E-mail
 * @property string $website 网址
 * @property integer $account_id 账号id
 * @property string $created_at 
 * @property string $updated_at 
 */
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