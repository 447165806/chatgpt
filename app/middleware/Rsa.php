<?php
/**
 * Created by PhpStorm.
 * User: lj
 * Date: 2023/3/13
 * Time: 17:43
 */

namespace app\middleware;


/**
 * 验证加密参数中间件
 * Class Rsa
 * @package app\middleware
 */
class Rsa
{

    protected $request;

    protected $isRsa = true; //是否验证加密参数

    public function handle($request, \Closure $next)
    {
        $params = request()->param();
        if ($this->isRsa){
            try {
                //模拟客户端加密参数-用于本地调试
                $str = \app\common\api\Rsa::encryptParams(json_encode($params));
                //解密参数
                $request->params = json_decode(\app\common\api\Rsa::decryptParams($str),true);
//                $request->params = json_decode(\app\common\api\Rsa::decryptParams($params['data']),true);
            } catch (\Exception $e){
                throw new \Exception("请求报文解密失败");
            }
        }
        return $next($request);
    }
}