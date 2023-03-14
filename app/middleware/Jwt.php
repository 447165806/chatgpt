<?php
/**
 * Created by PhpStorm.
 * User: lj
 * Date: 2023/1/31
 * Time: 16:14
 */

namespace app\middleware;


use app\exception\ApiException;
use app\validate\HeaderValidate;
use think\exception\ValidateException;

/**
 * jwt中间件：用于登录成功后的接口
 * Class Jwt
 * @package app\middleware
 */
class Jwt
{

    /**
     * 是否验证jwt-token: jwt=false仅用于开发调试
     * @var bool
     */
    protected $isCheck = false;

    protected $request;

    public function handle($request, \Closure $next)
    {
        if ($this->isCheck){
            $header = $request->header();
            //$authorization = $request->header('authorization');//token以认证方式
            //list($type, $token) = explode(' ', $authorization);
            //验证参数token
            try {
                validate(HeaderValidate::class)
                    ->scene('checkToken')
                    ->check($header);
            } catch (ValidateException $e) {
                throw new ApiException($e->getMessage());
            }
            //验证jwt-token
            $jwt = new \app\utils\jwt\Jwt();
            $res = $jwt::verifyJwt($header['token']);
            $request->uid = $res['data']->id;//给请求对象赋值，控制器可直接使用:$this->request->uid
        }else{
            $request->uid = 1;
        }

        return $next($request);
    }
}