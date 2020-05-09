<?php

/**
 * Date: 2018/7/14
 * Time: 0:20
 */

/**
 * @var \Moon\Console\Console $console
 */

$console->add('fmc', 'FillModelCommentCommand::run', 'Fill Model Comment');
$console->add('debug:routes', 'DebugCommand::routes', 'List all web routes');

$console->add('test:cmd', 'TestCommand::cmd', 'Test command');
$console->add('test:cmd1', function($a, $b){
    var_dump(1);
}, 'Test command');