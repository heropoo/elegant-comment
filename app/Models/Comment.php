<?php
/**
 * Created by PhpStorm.
 * User: ttt
 * Date: 2018/9/24
 * Time: 22:39
 */

namespace App\Models;

/**
 * Class Comment
 * @property int $article_id
 * @property int $parent_comment_id
 * @property int $user_id
 * @property string $user_nickname
 * @property string $user_head_img
 * @property int $user_sex
 * @property string $content
 * @property int $account_id
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 * @package App\Models
 */
class Comment extends Model
{
    protected $tableName = '{{comment}}';
    protected $primaryKey = 'id';
}