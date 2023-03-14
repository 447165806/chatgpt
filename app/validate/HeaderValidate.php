<?php
/**
 * Created by PhpStorm.
 * User: lj
 * Date: 2023/1/31
 * Time: 14:27
 */

namespace app\validate;


use think\Validate;

class HeaderValidate extends Validate
{

    //验证字段以及规则
    protected $rule =   [
        'timestamp|请求时间' => 'require',
        'nonce|随机数' => 'require',
        'sign|签名' => 'require',
        'token' => 'require'
    ];

    //提示信息
    protected $message  =   [

    ];

    //验证场景
    protected $scene = [
        'checkHeader' => ['timestamp','nonce','sign'],
        'checkToken' => ['token']
    ];

}