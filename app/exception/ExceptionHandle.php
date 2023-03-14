<?php
/**
 * Created by PhpStorm.
 * User: lj
 * Date: 2023/1/30
 * Time: 10:44
 */

namespace app\exception;

use Exception;
use think\exception\Handle;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\exception\HttpException;
use think\exception\HttpResponseException;
use think\exception\ValidateException;
use think\facade\Request;
use think\Response;
use Throwable;

/**
 * 自定义异常处理
 * Class ExceptionHandle
 * @package app\exception
 */
class ExceptionHandle extends Handle
{
    /**
     * 不需要记录信息（日志）的异常类列表
     * @var array
     */
    protected $ignoreReport = [
        HttpException::class,
        HttpResponseException::class,
        ModelNotFoundException::class,
        DataNotFoundException::class,
        ValidateException::class,
    ];

    /**
     * 记录异常信息（包括日志或者其它方式记录）
     * @access public
     * @param  Throwable $exception
     * @return void
     */
    public function report(Throwable $exception): void
    {
        if (!$this->isIgnoreReport($exception)) {
            $this->log($exception);
        }
    }

    public function render($request, Throwable $e): Response
    {
//        var_dump($e);
        //预请求
        if (strtoupper(Request::method()) == 'OPTIONS') {
            return response();
        }
        //自定义异常
        if ($e instanceof ApiException) {
            return fail($e->getMessage(), $e->getErrorCode());
        }
        //参数验证错误
        if ($e instanceof ValidateException) {
            return fail($e->getError(), 1000, null, 422);
        }
        //请求异常
        if ($e instanceof HttpException) {
            return fail('请求异常', 500, null, 404);
        }
        if ($e instanceof Exception) {
            return fail($e->getMessage(), 9999);
        }
        //其他错误
        return fail('系统异常', 500, null, 500);
    }

    public function log(Throwable $e)
    {
        //日志类型
        $type = 'error';
        if ($e instanceof ApiException) {
            $type = 'api';
        }
        if ($e instanceof Exception) {
            $type = 'exception';
        }
        $header = request()->header();
        $log = [
            'url'     => Request::url(),
            'file'    => $e->getFile(),
            'line'    => $e->getLine(),
            'message' => $this->getMessage($e),
            'method'  => request()->method(),
            'header'  => [
                'timestamp' => $header['timestamp'],
                'nonce' => $header['nonce'],
                'sign' => $header['sign'],
                'date' => date('Y-m-d H:i:s', $header['timestamp'])
            ],
            'body'  =>request()->param(),
        ];
        trace($log, $type);
    }
}