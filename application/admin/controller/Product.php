<?php
namespace app\admin\controller;

class Product extends \think\Controller
{
    public function index() {
        return $this->fetch('index' ,[
            'name' => 'Product rky'
        ]);
    }
}