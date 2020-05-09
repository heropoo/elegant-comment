<?php
/**
 * Date: 2020/5/9
 * Time: 11:38 上午
 */

namespace App\Commands;


use App\Models\User;
use Moon\Db\Connection;

class TestCommand
{
    protected $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function cmd(Connection $db, ...$args)
    {
//        var_dump($db);
//        var_dump($this->user);
        //var_dump($a);
//        global $argv;
//        var_dump($argv);
        var_dump($args);
    }
}