<?php
/**
 * Created by PhpStorm.
 * User: ttt
 * Date: 2018/9/23
 * Time: 23:27
 */

namespace App\Controllers;

use App\Models\Comment;
use Moon\Controller;
use Moon\Pagination\Pagination;

class CommentController extends Controller
{
    public function index($article_id){
        $account = \Moon::$app->get('account');
        $total = Comment::find()->count();
        $page_size = request('page_size', 10);
        $page = new Pagination($total, $page_size);
        $list = Comment::find()->where('article_id=? and account_id=?', [$article_id, $account->id])
            ->limit($page_size)->offset($page->getOffset())->order('id desc')->all();
        return [
            'code'=>200,
            'msg'=>'ok',
            'data'=>[
                'list'=>$list,
                'current_page'=>$page->getCurrentPage(),
                'page_total'=>$page->getTotalPage(),
            ]
        ];
    }

    public function save($article_id){

    }
}