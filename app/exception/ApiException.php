<?php
/**
 * Created by PhpStorm.
 * User: lj
 * Date: 2023/1/30
 * Time: 11:37
 */

namespace app\exception;


/**
 * 自定义异常
 * Class ApiException
 * @package app\exception
 */
class ApiException extends  \Exception
{
    private $errorCode;
    private $httpCode;


    public function __construct(string $message = '', $errorCode = 9999, int $httpCode = 200)
    {
        $this->errorCode = $errorCode;
        $this->httpCode = $httpCode;

        parent::__construct($message, $errorCode);
    }

    public function getHttpCode()
    {
        return $this->httpCode;
    }

    public function getErrorCode()
    {
        return $this->errorCode;
    }

}