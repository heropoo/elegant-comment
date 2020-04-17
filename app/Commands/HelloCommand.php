<?php
/**
 * User: Heropoo
 * Date: 2018/7/14
 * Time: 1:40
 */
namespace App\Commands;



class HelloCommand
{
    public function run(){
        echo 'Hello Moon'.PHP_EOL;
        return 0;
    }
}