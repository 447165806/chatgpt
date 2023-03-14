<?php
/**
 * Created by PhpStorm.
 * User: lj
 * Date: 2023/1/30
 * Time: 10:15
 */

return [
    'key' => 'PAA-ThinkPHP6', // 授权key
    'type' => 'Bearer', // 授权类型
    'request' => 'header', // 请求方式
    'param' => 'authorization', //授权名称
    'alg' => 'HS256',
    'payload' => [
        'iss' => 'PAA-ThinkPHP6', //签发者
        'aud' => '', //接收该JWT的一方，可选
        'iat' => time(), //签发时间
        'nbf' => time(), //某个时间点后才能访问
        'exp' => time() + 84000 , //过期时间
    ],
];