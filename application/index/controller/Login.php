<?php
namespace app\index\controller;
use \app\common\model\Account;

class Login extends \think\Controller
{
    public function login() {
        // Show login form
        return $this->fetch('login');
    }

    public function verify() {
        $data = $this->request->only(['identifier', 'password']);
        $result = Account::verify($data);
        if ($result === TRUE) {
            \Session::set('admin_id', $data['identifier']);
            return \redirect('/admin/shop/index');
        } else {
            return $this->error($result['msg']);
        }
    }
}