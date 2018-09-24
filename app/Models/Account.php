<?php
/**
 * Created by PhpStorm.
 * User: ttt
 * Date: 2018/9/24
 * Time: 22:28
 */

namespace App\Models;

/**
 * Class Account
 * @property string $email
 * @property string $token
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 * @package App\Models
 */
class Account extends Model
{
    protected $tableName = '{{account}}';

    const STATUS_NORMAL = 0;
    const STATUS_FORBIDDEN = -1;


}