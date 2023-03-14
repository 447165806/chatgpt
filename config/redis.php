<?php
/**
 * Created by PhpStorm.
 * User: laijian
 * Date: 2020/9/16
 * Time: 15:53
 */

return [
    //本地配置
    'redis'    => [
        'type'       => 'redis',
        'queue'      => 'default',
        'host'       => '127.0.0.1',
        'port'       => 16379,
        'password'   => 'paramita@WY',
        'select'     => 0,
        'timeout'    => 60,
        'persistent' => false,
    ],


];