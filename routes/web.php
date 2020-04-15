<?php
/**
 * Created by PhpStorm.
 * User: ttt
 * Date: 2018/7/10
 * Time: 10:58
 */

/**
 * @var \Moon\Routing\Router $router
 */

$router->get('/', 'IndexController::index');
$router->get('/test', 'IndexController::test');

$router->group(['middleware'=>\App\Middleware\CommentAuth::class, 'prefix'=>'comment'], function ($router){
    /**
     * @var \Moon\Routing\Router $router
     */
    $router->get('/{article_id}', 'CommentController::index');
    $router->post('/{article_id}', 'CommentController::save');
});

