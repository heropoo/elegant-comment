<?php
/**
 * Date: 2020/5/11
 * Time: 5:29 下午
 */

namespace App\Controllers;


use Moon\Db\Connection;

class TestController
{
    public function indexAction()
    {
        return 'test index';
    }

    public function dbAction(Connection $connection){
        $n = 10;
        while ($n){
            $res = $connection->fetch('select * from cw_account where id=1');
            sleep(1);
            $n--;
        }
        //var_dump($res);
        return $res;
    }
}