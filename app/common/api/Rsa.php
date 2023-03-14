<?php
/**
 * Created by PhpStorm.
 * User: lj
 * Date: 2023/3/13
 * Time: 15:54
 */

namespace app\common\api;

use app\utils\rsa\RsaUtils;

/**
 * 接口参数加密
 * Class Rsa
 * @package app\common\api
 */
class Rsa
{

    /**
     * 公钥加密参数[客户端使用]
     */
    public static function encryptParams($data = '')
    {
        $apiConfig = config('api.rsa');
        $rsa = new RsaUtils();
        return $rsa::encryptByPublicKey($data, $apiConfig['rsaPublic']);
    }

    /**
     * 私钥解密参数[服务端使用]
     */
    public static function decryptParams($data = '')
    {
        $apiConfig = config('api.rsa');
        $rsa = new RsaUtils();
        return $rsa::decryptByPrivateKey($data, $apiConfig['rsaPrivate']);
    }
}