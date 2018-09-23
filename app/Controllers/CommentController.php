<?php
/**
 * Created by PhpStorm.
 * User: ttt
 * Date: 2018/9/23
 * Time: 23:27
 */

namespace App\Controllers;


use Moon\Controller;

class CommentController extends Controller
{
    public function index($article_id){
        var_dump($article_id);
    }

    public function save($article_id){

    }
}