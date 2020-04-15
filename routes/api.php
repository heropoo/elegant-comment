<?php

/**
 * @var \Moon\Routing\Router $router
 */

$router->get('comment', 'CommentController::index');
$router->post('comment/create', 'CommentController::create');