<?php
namespace app\common\model;

use think\Model;

class Base extends Model {

    /**
     * 生产返回信息给客户程序
     * 
     * @param string $code 1|0
     * @param string $message
     * @param array $data
     * @return array
     */
    protected static function returnMsg($code, $message, $data = []) {
        return [
            'code' => $code,
            'msg' => $message,
            'data' => $data
        ];
    }
}