<?php
/**
 * Date: 2018/9/23
 * Time: 23:27
 */

namespace App\Controllers\Api;

use App\Models\Account;
use App\Models\Comment;
use App\Models\User;
use Carbon\Carbon;
use Moon\Pagination\Pagination;
use Moon\Request\Request;

class CommentController
{
    public function index(Request $request)
    {
        /** @var Account $account */
        $account = \App::$container->get('account');

        $article_id = $request->get('article_id');
        if (strlen($article_id) == 0) {
            return format_json_response(400, '请输入文章ID');
        }

        $total = Comment::find()->where('article_id=? and account_id=?', [$article_id, $account->id])->count();

        $page_size = $request->get('page_size', 10);

        $paginate = new Pagination($total, $page_size);

        $url = 'http://pc.metmoon.com';
        $list = Comment::find()->select('user_nickname,user_head_img,user_website,content,created_at')
            ->where('article_id=? and account_id=?', [$article_id, $account->id])
            ->limit($page_size)->offset($paginate->getOffset())->order('id desc')->all();
        foreach ($list as $row) {
            $row->user_head_img = $url . $row->user_head_img;
        }
        return format_json_response(0, 'OK', [
            'list' => $list,
            'current_page' => $paginate->getCurrentPage(),
            'page_total' => $paginate->getTotalPage(),
            'total' => $total
        ]);
    }

    public function create(Request $request)
    {
        /** @var Account $account */
        $account = \App::$container->get('account');

        $data = json_decode($request->getRawContent(), 1);

        $article_id = isset($data['article_id']) ? trim($data['article_id']) : '';
        if (strlen($article_id) == 0) {
            return format_json_response(400, '请输入文章ID');
        }

        $nickname = isset($data['nickname']) ? trim($data['nickname']) : '';
        if (strlen($nickname) == 0) {
            return format_json_response(400, '请输入昵称');
        }

        $email = isset($data['email']) ? trim($data['email']) : '';
        if (strlen($email) == 0 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return format_json_response(400, '请输入正确的Email');
        }

        $website = isset($data['website']) ? trim($data['website']) : '';

        $content = isset($data['content']) ? trim($data['content']) : '';
        if (strlen($content) == 0) {
            return format_json_response(400, '请输入评论内容');
        }

        $now = Carbon::now()->toDateTimeString();

        $user = User::find()->where('email=?', [$email])->first();
        if (!$user) {
            $user = new User();
            $user->email = $email;
            $user->account_id = $account->id;
            $user->head_img = '/images/' . mt_rand(1, 10) . '.jpeg';
            $user->created_at = $now;
        }

        $user->nickname = $nickname;
        if (strlen($website) > 0) {
            $user->website = $website;
        } else {
            if ($user->website) {
                $website = $user->website;
            }
        }
        $user->updated_at = $now;
        $res = $user->save();
        if (!$res) {
            return format_json_response(500, '评论失败');
        }

        $comment = new Comment();
        $comment->article_id = $article_id;
        //todo $comment->parent_comment_id
        $comment->user_id = $user->id;
        $comment->account_id = $user->account_id;
        $comment->user_nickname = $nickname;
        $comment->user_head_img = $user->head_img;
        $comment->user_website = $website;
        $comment->content = $content;
        $comment->created_at = $comment->updated_at = $now;

        $res = $comment->save();
        if (!$res) {
            return format_json_response(501, '评论失败');
        }

        return format_json_response(0, '评论成功', [
            'comment' => [
                'created_at' => $comment->created_at,
                'content' => $comment->content,
            ],
            'user' => [
                'nickname' => $user->nickname,
                'head_img' => $user->head_img,
                'website' => $user->website,
            ]
        ]);
    }
}