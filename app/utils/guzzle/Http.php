<?php
/**
 * Created by PhpStorm.
 * User: lj
 * Date: 2023/1/31
 * Time: 10:00
 */

namespace app\utils\guzzle;


use app\exception\ApiException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class Http
{

    /**
     * 发送get请求
     */
    public function getRequest($url, $params)
    {
        $requestData = ['query' => $params];
        try {
            $client = new Client();
            return $client->get($url, $requestData)
                ->getbody()
                ->getcontents();
        } catch (GuzzleException $e){
            throw new ApiException($e->getMessage());
        }
    }

    /**
     * 发送post json格式http请求
     */
    public function postJsonRequest($url, $params = [])
    {
        $options = json_encode($params, JSON_UNESCAPED_UNICODE);
        $requestData = [
            'body' => $options,
            'headers' => ['content-type' => 'application/json']
        ];
        try {
            $client = new Client();
            return $client->post($url, $requestData)
                ->getbody()
                ->getcontents();
        } catch (GuzzleException $e){
            throw new ApiException($e->getMessage());
        }
    }

    /**
     * 发送post 表单http请求
     */
    public function postFormRequest($url, $params = [])
    {
        $requestData = [
            'form_params' => $params,
        ];
        try {
            $client = new Client();
            return $client->post($url, $requestData)
                ->getbody()
                ->getcontents();
        } catch (GuzzleException $e){
            throw new ApiException($e->getMessage());
        }
    }

}