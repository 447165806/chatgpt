<?php
/**
 * Created by PhpStorm.
 * User: lj
 * Date: 2023/1/31
 * Time: 16:39
 */

namespace app\middleware;


use app\exception\ApiException;


class Ip
{

    protected $isCheck = false; //是否开启ip验证

    protected $blackIps = [
        '127.0.0.1'
    ];


    public function handle($request, \Closure $next)
    {
        if ($this->isCheck){
            if (in_array($this->getIp(), $this->blackIps)){
                throw new ApiException('非法ip访问');
            }
        }

        return $next($request);
    }

    public function getIp()
    {
        return $_SERVER["HTTP_X_FORWARDED_FOR"] ?? ($_SERVER["HTTP_CLIENT_IP"] ?? $_SERVER["REMOTE_ADDR"]);
    }

}