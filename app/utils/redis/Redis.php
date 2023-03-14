<?php
/**
 * Created by PhpStorm.
 * User: lj
 * Date: 2021/12/29
 * Time: 11:43
 */

namespace app\utils\redis;


use Exception;

class Redis
{
    /** @var \Redis $redis  */
    public $redis;

    /** @var static 定义单例模式的变量  */
    private static $_instance = null;


    public static function getInstance() : Redis
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    private function __construct(){}

    /**
     * 获取Redis句柄
     * @return \Redis
     * @throws Exception
     */
    public static function getRedis(): \Redis
    {
        $self = static::getInstance();
        if (!isset($self->redis)){
            $self->setRedis();
        }
        return $self->redis;
    }


    /**
     * @throws Exception
     */
    public function setRedis(): void
    {
        $config = config('redis.redis');
        $this->redis = new \Redis();

        if($this->redis->connect($config['host'],$config['port']) == false){
            throw new Exception("redis 连接失败");
        }

        if(!empty($config['password']) && $this->redis->auth($config['password']) == false){
            throw new Exception("redis auth 认证失败");
        }
    }
}