<?php
/**
 * Created by PhpStorm.
 * User: lj
 * Date: 2023/1/30
 * Time: 10:00
 */

namespace app\utils\jwt;


use app\exception\ApiException;
use Exception;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT as FirebaseJwt;
use Firebase\JWT\Key;
use Firebase\JWT\SignatureInvalidException;

class Jwt
{

    /**
     * 创建jwt-token
     */
    public static function createJwt($data): string
    {
        $config = config('jwt');
        $payload = $config['payload'];
        $payload['data'] = $data;
        return FirebaseJwt::encode($payload, $config['key'], $config['alg']);
    }

    /**
     * 验证jwt-token
     */
    public static function verifyJwt($token): array
    {
        $config = config('jwt');
        try {
            $decoded = FirebaseJwt::decode($token, new Key($config['key'], $config['alg']));
            return (array)$decoded;
        } catch (SignatureInvalidException $e) { //签名不正确
            throw new ApiException('签名不正确');
        } catch (BeforeValidException $e) { //签名在某个时间点之后才能用
            throw new ApiException('token未生效');
        } catch (ExpiredException $e) { //token过期
            throw new ApiException('token失效');
        } catch (Exception $e) { //其他错误
            throw new ApiException('未知错误');
        }
    }

}