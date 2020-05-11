<?php
/**
 * Date: 2018/7/10
 * Time: 10:58
 */

/**
 * @var \Moon\Routing\Router $router
 */

$router->get('/', 'IndexController::index');
$router->controller('/test', 'TestController');


