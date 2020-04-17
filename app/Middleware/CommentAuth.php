<?php
/**
 * Date: 2018/9/24
 * Time: 11:45
 */

namespace App\Middleware;

use App\Models\Account;
use Closure;
use Moon\Controller;
use Moon\Request\Request;

class CommentAuth
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->headers->get('Comment-Auth-Token');
        if (empty($token)) {
            return [
                'code' => 400,
                'msg' => 'Unauthorized.'
            ];
        }

        // 5ba8f625a8aa95ba8f625a8aab5ba8f6
        //echo uniqid().uniqid().uniqid();

        $account = Account::find()->where('token=? and status=' . Account::STATUS_NORMAL, [$token])->first();
        if (empty($account)) {
            return [
                'code' => 401,
                'msg' => 'Unauthorized.'
            ];
        }

        //\Moon::$app->add('account', $account);
        //\App::$container->add('account')

        return $next($request);
    }
}