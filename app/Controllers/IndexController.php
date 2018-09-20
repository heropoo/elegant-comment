<?php
/**
 * Created by PhpStorm.
 * User: ttt
 * Date: 2018/7/12
 * Time: 23:28
 */
namespace App\Controllers;

use App\Models\User;
use Moon\Controller;

class IndexController extends Controller
{
    public function index(){
        return 'index';
    }

    public function test(){
        //var_dump(\Moon::$app->get('db'));
        //$user = new User();
        //$user->nickname = 'ttt1';
        //$user->email = 'ttt1@ttt.com';
        //$user->save();
        //var_dump($user);
        $list = User::find()->where('status=1')->all();
        $user = User::find()->first();
        var_dump($user->updated_at);
        //var_dump($list);
        foreach($list as $value){
            echo $value->id.' nickname:'.$value->nickname.' email:'.$value->email.' status:'.$value->status.' created_at:'.$value->created_at;
            echo '<br>';
            //var_dump($value->toArray());
            //$value->status = 1;
            //$value->save();
        }
    }
}