<?php
/**
 * 评论小部件
 * @author Heropoo
 * @datetime 2018-09-20 18:25
 */

$origins = [
    'https://metmoon.com',
    'https://www.metmoon.com',
    'http://www.metmoon.com',
    'http://metmoon.com',
    'http://127.0.0.1:4000',
];

// 获取当前跨域域名
$origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';
error_log(__FILE__.':origin:'.$origin, 3, '/tmp/comment.log');
if (in_array($origin, $origins)) {
    // 允许 $originarr 数组内的 域名跨域访问
    header('Access-Control-Allow-Origin:' . $origin);
    // 响应类型
    header('Access-Control-Allow-Methods:POST,GET');
    // 带 cookie 的跨域访问
    header('Access-Control-Allow-Credentials: true');
    // 响应头设置
    header('Access-Control-Allow-Headers:x-requested-with,Content-Type,App-Id,App-Key');
}

require __DIR__ . '/../vendor/autoload.php';
$app = new \Moon\Application(dirname(__DIR__));
$app->run();

