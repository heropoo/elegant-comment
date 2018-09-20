<?php
/**
 * Created by PhpStorm.
 * User: ttt
 * Date: 2018/7/12
 * Time: 23:29
 */
namespace App\Models;

/**
 * Class User
 * @property string $nickname
 * @property string $head_img
 * @property int $sex
 * @property string $email
 * @property string $website
 * @property string $password
 * @property string $salt
 * @property int $status
 * @property int $account_id
 * @property string $created_at
 * @property string $updated_at
 * @package App\Models
 */
class User extends Model
{
    protected $tableName = '{{user}}';
    protected $primaryKey = 'id';
}