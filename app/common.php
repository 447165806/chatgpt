<?php
// 应用公共文件

use app\utils\jwt\Jwt;
use think\response\Json;


//成功响应
function success($data = null, $message = 'ok', $code = 0, $httpCode = 200): Json
{
    $result_data = [
        'code' => $code,
        'message' => $message,
        'data' => $data,
    ];
    return json($result_data, $httpCode);
}

//失败响应
function fail($message = 'fail', $code = 1, $data = null, $httpCode = 200): Json
{
    $result_data = [
        'code' => $code,
        'message' => $message,
        'data' => $data,
    ];

    return json($result_data, $httpCode);
}

//创建jwt-token
function createJwt($data): string
{
    return Jwt::createJwt($data);
}

//验证jwt-token
function verifyJwt($token): array
{
    return Jwt::verifyJwt($token);
}

//返回当前13位的毫秒时间戳
function mistime()
{
    list($msec, $sec) = explode(' ', microtime());
    $msectime =  (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
    return substr($msectime,0,13);
}

//生成随机字符串
function getNonceStr($length = 32)
{

    $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
    $str ="";
    for ( $i = 0; $i < $length; $i++ )  {
        $str .= substr($chars, mt_rand(0, strlen($chars)-1), 1);
    }
    return $str;
}
