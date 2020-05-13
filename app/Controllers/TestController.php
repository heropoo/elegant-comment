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

    public function dbAction(Connection $connection)
    {
        $res = $connection->fetch('select id,app_id from cw_account where id=1');
        return format_json_response(0, 'ok', ['test' => $res]);
    }
}