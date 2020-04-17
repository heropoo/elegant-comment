<?php
/**
 * Date: 2020/4/15
 * Time: 15:11
 */

namespace App\Models;

use Moon\Db\Table;

/**
 * Class App\Models\Comment 
 * @property integer $id 
 * @property string $article_id 文章id
 * @property integer $parent_comment_id 回复评论的id
 * @property integer $user_id 用户id
 * @property string $user_nickname 昵称
 * @property string $user_head_img 头像
 * @property string $user_website 用户网站
 * @property string $content 内容
 * @property integer $account_id 账号id
 * @property string $created_at 
 * @property string $updated_at 
 */
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