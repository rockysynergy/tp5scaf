<?php
namespace app\common\model;

use think\Model;
use think\Validate;

class Account extends Base
{
    protected static $rule = [
        'password' => 'require|min:6',
        'identifier' => 'require|min:4|unique',
    ];

    protected static $message = [
        'password.require' => '密码必须',
        'password.min' => '密码不能少于6个字符',
        'identifier.require' => '用户名必须',
        'identifier.min' => '用户名不能少于4个字符',
        'identifier.unique' => '该用户名已经注册'
    ];

    /**
     * 新增数据库记录
     * 
     * @param array $data
     * @return array
     */
    public static function addNew($data) {
        $result = self::validate($data, self::$rule, self::$message);
        if (is_array($result)) return $result;

        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        $account = new self($data);
        $result = $account->allowField(['identifier', 'password'])->save();
        if ($result === FALSE) return self::returnMsg('-1', '操作失败');
        return self::returnMsg('0', '操作成功', $account->id);
    }

    /**
     * 修改密码
     * 输入：['id' => '', 'identifier' => '', 'password' => '', 'new_password' => '']
     * 
     * @param array $data
     * @return array
     */
    public static function changePassword($data) {
        $rule = array_merge(self::$rule, ['new_password' => 'require|min:6']);
        $message = array_merge(self::$message, [
            'new_password.require' => '密码必须',
            'password.min' => '密码不能少于6个字符'
        ]);
        $result = self::validate($data, $rule, $message);
        if (is_array($result)) return $result;

        $result = self::verify($data);
        if (is_array($result)) return $result;
        
        $data['password'] = password_hash($data['new_password'], PASSWORD_DEFAULT);
        $account = new self();
        $result = $account->allowField(['password'])->save($data, ['id' => $data['id']]);
        if ($result === FALSe) return self::returnMsg('-1', '操作失败');
        else return self::returnMsg('0', '操作成功');
    }

    /**
     * 验证提交的数据
     * 
     * @param array $data 
     * @param array $rule 
     * @param array $message
     * 
     * @return true|array
     */
    protected static function validate($data, $rule, $message) {        
        $validate = Validate::make($rule, $message);
        $result = $valide->check($data);
        if (!$result) return self::returnMsg('-1', $validate->getError());
        return TRUE;
    }

    /**
     * 校验用户名和密码
     * 
     * @param array $data
     * @return TRUE|array
     */
    public static function verify($data) {
        $password = self::where('identifier', $data['identifier'])->value('password');
        if (!password_verify($data['password'], $password)) {
            return self::returnMsg('-1', '用户名或密码不正确!');
        }
        return TRUE;
    }

}