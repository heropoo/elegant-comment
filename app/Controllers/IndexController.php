<?php
/**
 * Created by PhpStorm.
 * User: ttt
 * Date: 2018/7/12
 * Time: 23:28
 */
namespace App\Controllers;

use App\Models\Test;
use App\Models\User;
use Moon\Controller;

class IndexController extends Controller
{
    public function index(){
        return '<p style="text-align: center;font-size: 2rem;margin-top: 3rem;">Welcome to use <a href="https://github.com/heropoo/comment-widget.git">comment-widget</a>.</p>';
    }

    public function test(){
        $model = new Test();
        $res = $model->save();
        echo $model->getLastSql();
        var_dump($res);exit;
        //$model->order = 11;
        //var_dump($model->toArray());
        $model = Test::find()->first();
        echo $model->getLastSql();
        //var_dump(json_encode($model));
        try{
            $model->order += 1;
            $res = $model->save();

        }catch (\Exception $e){
            echo $e->getMessage();
        }
        echo $model->getLastSql();
        //var_dump($res);
    }
}