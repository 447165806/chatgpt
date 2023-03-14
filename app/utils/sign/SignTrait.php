<?php
/**
 * Created by PhpStorm.
 * User: lj
 * Date: 2023/1/31
 * Time: 17:53
 */

namespace app\utils\sign;


trait SignTrait
{
    private $value;


    //设置value
    public function setValue($value){
        $this->value = $value;
        return $this;
    }

    //获取value
    public function getValue(){
        return $this->value;
    }

    //按照首字母大小写顺序排序
    public function sortValue()
    {
        sort($this->value,SORT_STRING);
        return $this;
    }

    //拼接成字符串
    public function strValue()
    {
        $this->value = implode($this->value);
        return $this;
    }

    //sha1进行加密
    public function sha1Value()
    {
        $this->value = sha1($this->value);
        return $this;
    }

    //md5进行加密
    public function md5Value()
    {
        $this->value = md5($this->value);
        return $this;
    }

    //转换成大写
    public function upperValue()
    {
        $this->value = strtoupper($this->value);
        return $this;
    }


}