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
$router = Moon::$app->get('router');

$router->get('/', 'IndexController::index');
$router->get('/test', 'IndexController::test');

$router->get('/comment/{article_id}', 'CommentController::index');
$router->post('/comment/{article_id}', 'CommentController::save');