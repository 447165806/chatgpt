<?php
/**
 * Created by PhpStorm.
 * User: lj
 * Date: 2023/2/21
 * Time: 14:40
 */

namespace openapi\chatgpt;


class Config
{

    /**
     * 秘钥
     * @var string
     */
    protected $key = "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";

    /**
     * 接口地址
     * @var string
     */
    protected $apiUrl = "https://api.openai.com";

    /**
     * 模型名称
     * @var
     */
    protected $model = "text-davinci-003";

    /**
     * 问题
     * @var
     */
    protected $prompt;

    /**
     * 控制结果随机性，0.0表示结果固定，随机性大可以设置为0.9。
     * @var
     */
    protected $temperature = 0;

    /**
     * 最大返回字数（包括问题和答案），通常汉字占两个token。假设设置成100，如果prompt问题中有40个汉字，那么返回结果中最多包括10个汉字。
     * @var
     */
    protected $max_tokens = 2024;

    protected $top_p = 1;

    protected $frequency_penalty = 0;

    protected $presence_penalty = 0;


    public function setModel($model)
    {
        $this->model = $model;
    }

    public function setPrompt($prompt)
    {
        $this->prompt = $prompt;
    }

    public function setMaxTokens($max_tokens)
    {
        $this->max_tokens = $max_tokens;
    }
}

