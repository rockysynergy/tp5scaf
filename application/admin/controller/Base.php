<?php
namespace app\admin\controller;
use \app\common\model\Account;
use \app\admin\model\BeuserAccount as BeuserAccountModel;
use \app\admin\model\ShopUser as ShopUserModel;
use \app\common\model\Account as AccountModel;

class Base extends \think\Controller
{
    /**
     * User information
     */
    protected $admin = [];

    public function initialize() {
        $account_identifier = \Session::get('admin_id');
        $account_id = AccountModel::where('identifier', $account_identifier)->value('id');
        $this->admin['account_id'] = $account_id;
        $user_id = BeuserAccountModel::where('account_id', $account_id)->value('user_id');
        $this->admin['user_id'] = $user_id;
        $this->admin['shop_id'] = ShopUserModel::where('user_id', $user_id)->value('shop_id');
    }


}