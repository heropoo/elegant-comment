<?php
/**
 * Date: 2018/9/24
 * Time: 11:45
 */

namespace App\Middleware;

use App\Models\Account;
use Closure;
use Monolog\Logger;
use Moon\Request\Request;

class CommentAccountAuth
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $app_id = $request->header('app-id');
        $app_key = $request->header('app-key');

        if (empty($app_id) || empty($app_key)) {
            return [
                'code' => 401,
                'msg' => 'Unauthorized.'
            ];
        }

        //todo token

        /** @var Logger $logger */
        $logger = \App::$container->get('logger');
        $logger->info('request-server: ' . var_export($request->server, 1));
        $logger->info('request-header: ' . var_export($request->header, 1));

        $account = Account::find()
            ->where('app_id=? and app_key=? and status=' . Account::STATUS_NORMAL, [$app_id, $app_key])
            ->first();
        if (empty($account)) {
            return [
                'code' => 401,
                'msg' => 'Unauthorized.'
            ];
        }

        if (!$this->checkOrigin($account, $request->header('origin'))) {
            return [
                'code' => 403,
                'msg' => 'Origin not allow'
            ];
        }

        \App::$container->add('account', $account);

        return $next($request);
    }

    protected function checkOrigin(Account $account, $origin)
    {
        if (!empty($origin)) {
            $allow_origin = explode(',', $account->allow_origin);
            //header('Access-Control-Allow-Origin:' . $origin);
            if (!in_array($origin, $allow_origin)) {
                return false;
            }
        }
        return true;
    }
}