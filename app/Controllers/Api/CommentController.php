<?php
/**
 * Date: 2018/9/23
 * Time: 23:27
 */

namespace App\Controllers\Api;

use App\Models\Comment;
use Moon\Request\Request;

class CommentController
{
    public function index(Request $request)
    {
//        $account = \Moon::$app->get('account');
//        $total = Comment::find()->count();
//        $page_size = request('page_size', 10);
//        $page = new Pagination($total, $page_size);
//        $list = Comment::find()->where('article_id=? and account_id=?', [$article_id, $account->id])
//            ->limit($page_size)->offset($page->getOffset())->order('id desc')->all();
//        return [
//            'code' => 200,
//            'msg' => 'ok',
//            'data' => [
//                'list' => $list,
//                'current_page' => $page->getCurrentPage(),
//                'page_total' => $page->getTotalPage(),
//            ]
//        ];

        return format_json_response(200);
    }

    public function create(Request $request)
    {
        //var_dump($request->getRawContent());
        $data = json_decode($request->getRawContent(), 1);
        var_dump($data);
    }
}