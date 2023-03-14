<?php

namespace app\utils\rsa;

class RsaUtils
{

    /**
     * 私钥对数据签名
     * @param $data
     * @param $privateKey
     * @return mixed
     */
    public static function sign($data, $privateKey)
    {
        $data = self::str2utf8($data);
        $privateKey = "-----BEGIN RSA PRIVATE KEY-----\n" . wordwrap($privateKey, 64, "\n", true) . "\n-----END RSA PRIVATE KEY-----";
        $privateKeyId = openssl_get_privatekey($privateKey);
        openssl_sign($data, $sign, $privateKeyId, OPENSSL_ALGO_SHA1);
        //释放资源
        openssl_free_key($privateKeyId);
        return base64_encode($sign);
    }

    /**
     * 公钥对数据验签
     * @param $data
     * @param $signValue
     * @param $publicKey
     * @return int
     */
    public static function verify($data, $signValue, $publicKey)
    {
        $publicKey = "-----BEGIN PUBLIC KEY-----\n" . wordwrap($publicKey, 64, "\n", true) . "\n-----END PUBLIC KEY-----";
        $pub_id = openssl_get_publickey($publicKey);
        return openssl_verify($data, base64_decode($signValue), $pub_id);
    }


    /**
     * 公钥分段加密(针对要加密的数据过长,采用分段加密)
     * @param $data
     * @param $publicKey
     * @return string|null
     */
    public static function subEncryptByPublicKey($data, $publicKey)
    {
        $crypted = array();
        $publicKey = "-----BEGIN PUBLIC KEY-----\n" . wordwrap($publicKey, 64, "\n", true) . "\n-----END PUBLIC KEY-----";
        $publicKey = openssl_pkey_get_public($publicKey);
        $dataArray = str_split($data, 117);
        foreach ($dataArray as $subData) {
            $subCrypted = null;
            $flag = openssl_public_encrypt($subData, $subCrypted, $publicKey);
            if ($flag == false) {
                return false;
            }
            $crypted[] = $subCrypted;
        }
        $crypted = implode('', $crypted);
        return base64_encode($crypted);
    }

    /**
     * 私钥分段解密(针对要加密的数据过长,采用分段加密)
     * @param $data
     * @param $privateKey
     * @return bool|string
     */
    public static function subDecryptByPrivateKey($data, $privateKey)
    {
        $decrypted = '';
        $privateKey = "-----BEGIN RSA PRIVATE KEY-----\n" . wordwrap($privateKey, 64, "\n", true) . "\n-----END RSA PRIVATE KEY-----";
        $pi_key = openssl_pkey_get_private($privateKey);
        $plainData = str_split(base64_decode($data), 128);
        foreach ($plainData as $chunk) {
            $str = '';
            $decryptionOk = openssl_private_decrypt($chunk, $str, $pi_key);//私钥解密
            if ($decryptionOk === false) {
                return false;
            }
            $decrypted .= $str;
        }
        return $decrypted;
    }

    /**
     * 公钥加密
     * @param $data
     * @param $publicKey
     * @return mixed
     */
    public static function encryptByPublicKey($data, $publicKey)
    {
        $publicKey = "-----BEGIN PUBLIC KEY-----\n" . wordwrap($publicKey, 64, "\n", true) . "\n-----END PUBLIC KEY-----";
        openssl_public_encrypt($data, $encrypt_data, $publicKey);
        return base64_encode($encrypt_data);
    }

    /**
     * 私钥解密
     * @param $data
     * @param $privateKey
     * @return string
     */
    public static function decryptByPrivateKey($data, $privateKey)
    {
        $decrypted = '';
        $privateKey = "-----BEGIN RSA PRIVATE KEY-----\n" . wordwrap($privateKey, 64, "\n", true) . "\n-----END RSA PRIVATE KEY-----";
        $baseDecode = base64_decode($data);
        openssl_private_decrypt($baseDecode, $decrypted, $privateKey);
        return $decrypted;
    }

    /**
     * 私钥加密
     * @param $data
     * @param $privateKey
     * @return string
     */
    public static function subEncryptByPrivateKey($data, $privateKey): string
    {
        $crypted = array();
        $privateKey = "-----BEGIN PRIVATE KEY-----\n" . wordwrap($privateKey, 64, "\n", true) . "\n-----END PRIVATE KEY-----";
        $privateKey = openssl_pkey_get_private($privateKey);
        $dataArray = str_split($data, 117);
        foreach ($dataArray as $subData) {
            $subCrypted = null;
            $flag = openssl_private_encrypt($subData, $subCrypted, $privateKey);
            if ($flag == false) {
                return false;
            }
            $crypted[] = $subCrypted;
        }
        $crypted = implode('', $crypted);
        return base64_encode($crypted);
    }

    public static function encryptByPrivateKey($data, $privateKey): string
    {
        $privateKey = "-----BEGIN PRIVATE KEY-----\n" . wordwrap($privateKey, 64, "\n", true) . "\n-----END PRIVATE KEY-----";
        $data = base64_decode($data);
        openssl_private_encrypt($data, $encrypt_data, $privateKey);
        return base64_encode($encrypt_data);
    }

    /**
     * 将字符串编码转为 utf8
     * @param $str
     * @return string
     */
    private static function str2utf8($str)
    {
        $encode = mb_detect_encoding($str, array('ASCII', 'UTF-8', 'GB2312', 'GBK', 'BIG5'));
        $str = $str ? $str : mb_convert_encoding($str, 'UTF-8', $encode);
        $str = is_string($str) ? $str : '';
        return $str;
    }
}