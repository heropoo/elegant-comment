<?php
/**
 * Created by PhpStorm.
 * User: ttt
 * Date: 2018/9/24
 * Time: 11:45
 */

namespace App\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\Request;

class CommentAuth
{
    /**
     * @param Request $request
     * @param Closure $next
     */
    public function handle($request, Closure $next){

    }
}