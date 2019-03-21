<?php
namespace app\admin\controller;

use \app\common\model\Shop as ShopModel;

class Shop extends Base
{
    public function index() {
        $shops = ShopModel::all();
        return $this->fetch(
            'index', [
            'shops' => $shops,
            'admin' => $this->admin
        ]);
    }

    public function new() {
        // Show add form
        return $this->fetch('new');
    }

    public function add() {
        $data = $this->request->post();
        if (empty($data)) return;
        $result = ShopModel::create($data);
        if ($result) {
            $this->success('新增成功', 'Shop/index');
        } else {
            $this->error('新增失败');
        }
    }

    public function edit() {
        $shop = ShopModel::get($this->request->param('id'));
        return $this->fetch(
            'edit', 
            ['shop' => $shop]
        );
    }

    public function update() {
        $data = $this->request->only(['id', 'name']);
        $result = ShopModel::where('id', $data['id'])->update($data);
        if ($result) {
            $this->success('编辑成功', 'Shop/index');
        } else {
            $this->error('编辑失败');
        }
    }

    public function delete() {
        $id = $this->request->param('id');
        $shop = ShopModel::get($id);
        $result = $shop->delete();
        if ($result) {
            $this->success('删除成功', 'shop/index');
        } else {
            $this->error('删除失败');
        }
    }
}