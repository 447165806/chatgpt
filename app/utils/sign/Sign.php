<?php
/**
 * Created by PhpStorm.
 * User: lj
 * Date: 2023/1/31
 * Time: 11:25
 */

namespace app\utils\sign;


/**
 * sign签名
 * Class Sign
 * @package app\utils\sign
 */
class Sign
{
    use SignTrait;

    /**
     * 生成签名
     */
    public function signature($signData): string
    {
        return $this->setValue($signData)
            ->sortValue()
            ->strValue()
            ->sha1Value()
            ->md5Value()
            ->upperValue()
            ->getValue();
    }


}