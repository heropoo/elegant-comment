<?php
/**
 * Date: 2020/5/14
 * Time: 2:32 下午
 */

//$timerId = \Swoole\Timer::tick(1000, function () {
//    echo "Swoole 很棒\n";
//});
//
//\Swoole\Timer::after(3000, function () use ($timerId) {
//    echo "Laravel 也很棒\n";
//    \Swoole\Timer::clear($timerId);
//});

$count = 0;
\Swoole\Timer::tick(1000, function ($timerId, $count) {
    global $count;
    echo "Swoole 很棒\n";
    $count++;
    if ($count == 3) {
        \Swoole\Timer::clear($timerId);
    }
}, $count);