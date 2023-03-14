<?php
/**
 * Created by PhpStorm.
 * User: lj
 * Date: 2023/1/31
 * Time: 14:25
 */

namespace app\middleware;

use app\validate\HeaderValidate;

/**
 * 接口安全中间件
 * Class ApiSign
 * @package app\middleware
 */
class Api
{

    protected $request;

    protected $isCheck = true; //是否验证header参数

    public function handle($request, \Closure $next)
    {
        $header = request()->header();
        if ($this->isCheck){
            //验证参数
            validate(HeaderValidate::class)
                ->scene('checkHeader')
                ->check($header);
            //验证签名
            \app\common\api\Api::verify($header);
        }
        return $next($request);
    }

}