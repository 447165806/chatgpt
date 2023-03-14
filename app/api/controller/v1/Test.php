<?php
/**
 * Created by PhpStorm.
 * User: lj
 * Date: 2023/1/28
 * Time: 17:41
 */

namespace app\api\controller\v1;


use app\BaseController;
use app\utils\guzzle\Http;
use openapi\chatgpt\Request;


class Test extends BaseController
{

    protected $middleware = ['api','rsa', 'jwt', 'ip'];

    public function t1()
    {
        $params = $this->params;var_dump($this->request->params);
        $token = createJwt(['id'=>11,'name'=>2]);
//        $data = verifyJwt($token)['data'];
        return $token;
    }
}