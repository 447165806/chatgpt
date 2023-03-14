<?php
/**
 * Created by PhpStorm.
 * User: lj
 * Date: 2023/3/13
 * Time: 15:32
 */

namespace app\common\api;

use app\utils\redis\Redis;
use app\utils\sign\Sign;
use Exception;

/**
 * 接口安全验证
 * Class Sign
 * @package app\common\sign
 */
class Api
{

    /**
     * 接口安全验证：[密钥 + 时间戳 + 随机数]
     */
    public static function verify($header = [])
    {
        $redis = Redis::getRedis();
        //验证防重(防止重复调用)
        if ($redis->get($header['nonce'])){
            throw new Exception("API验证失败：非法请求");
        }
        //验证有效性
        $apiConfig = config('api.sign');
        $expire_time = $apiConfig['expire_time'];
        if($header['timestamp'] + $expire_time < time()){
            throw new Exception("API验证失败：请求已过期");
        }
        //验证签名
        $sign = new Sign();
        $signData['appKey'] = $apiConfig['appKey'];
        $signData['timestamp'] = $header['timestamp'];
        $signData['nonce'] = $header['nonce'];
        $s = $sign->signature($signData);
        if($s != $header['sign']){
            throw new Exception("API验证失败：签名验证失败");
        }
        //随机数加入redis，用于验证防重
        $redis->set($header['nonce'], $header['nonce'], $expire_time);
    }
}