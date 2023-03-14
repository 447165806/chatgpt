<?php
/**
 * Created by PhpStorm.
 * User: lj
 * Date: 2022/7/12
 * Time: 15:20
 */

namespace app\utils\upload;

use app\exception\ApiException;


/**
 * 上传文件到本地
 * Class Upload
 * @package app\lib\upload
 */
class Upload
{

    /**
     * 图片支持格式
     * @var array
     */
    protected static $image_type = ['png', 'jpg', 'jpeg', 'gif'];

    /**
     * 音频支持格式
     * @var array
     */
    protected static $audio_type = ['mp3', 'mp4', 'wav', 'wma'];

    /**
     * 文件支持格式
     * @var array
     */
    protected static $file_type = ['pdf', 'docx'];

    /**
     * 允许最大上传字节，默认100M
     * @var array
     */
    protected static $upload_max_filesize = 1024 * 1024 * 100;


    /**
     *
     * 上传单个文件
     * @param array $file 上传的文件
     * @param string $upload_type 文件类型
     * author: lj
     * date: 2022/7/12 17:09
     * @return string
     * @throws ApiException
     */
    public static function uploadSingleFile(array $file, string $upload_type): string
    {
        static::checkFile($file);
        // 文件名
        $file_name = $file['name'];
        // 后缀名
        $file_ext = explode('/', $file['type'])[1];
        static::checkTypeAndExt($file_ext, $upload_type);
        static::checkSize($file['size']);
        // 设置上传后的文件
        $filename = 'uploads/'. $upload_type . '/' . date("Ymd") . '/' . date('YmdHis').rand(1000,9999) . '.' . $file_ext;
        if (!is_dir(dirname($filename))) {
            mkdir(dirname($filename), 0755, true);
        }
        //保存之前判断该文件是否存在
        if(file_exists($filename))
        {
            throw new ApiException("文件已存在");
        }
        // 中文名的文件出现问题，所以需要转换编码格式
//        $filename = iconv("utf-8","gb2312", $filename);
        // 移动临时文件到上传的文件存放的位置（核心代码）
        if ( !move_uploaded_file($file["tmp_name"], $filename) ){
            throw new ApiException("文件保存失败");
        }
        return $filename;
    }

    /**
     * 上传多个文件
     * @param array $file
     * @param string $upload_type
     * @return array
     * author: lj
     * date: 2022/7/13 9:50
     * @throws ApiException
     */
    public static function uploadMultipleFile(array $file, string $upload_type): array
    {
        $filename = [];
        foreach ($file['name'] as $k => $value){
            $single_file = [
                'name' => $value,
                'type' => $file['type'][$k],
                'tmp_name' => $file['tmp_name'][$k],
                'error' => $file['error'][$k],
                'size' => $file['size'][$k]
            ];
            $filename[] = static::uploadSingleFile($single_file, $upload_type);
        }
        return $filename;
    }

    /**
     * 验证文件
     */
    protected static function checkFile($file)
    {
        if (!isset($file['error'])){
            throw new ApiException("请上传有效的文件");
        }
        switch ($file['error']){
            case '0':
                break;
            case '1':
                throw new ApiException("文件超出服务端允许的大小");
            case '2':
                throw new ApiException("文件超出客户端端允许的大小");
            case '3':
                throw new ApiException("文件上传出现问题，只有部分被上传");
            case '4':
                throw new ApiException("没有文件被上传");
            case '5':
                throw new ApiException("文件上传大小为0");
            default:
                throw new ApiException("其他错误");
        }
    }

    /**
     * 验证文件格式
     */
    protected static function checkTypeAndExt($extension, $upload_type)
    {
        switch ($upload_type){
            case 'image':
                $type = self::$image_type;
                break;
            case 'audio':
                $type = self::$audio_type;
                break;
            case 'file':
                $type = self::$file_type;
                break;
            default:
                throw new ApiException("不支持的文件类型");
        }
        if (!in_array($extension, $type)){
            throw new ApiException("不支持的文件格式".$extension);
        }
    }

    /**
     * 验证文件大小
     */
    protected static function checkSize($size)
    {
        if ($size > self::$upload_max_filesize){
            throw new ApiException("文件超出接口设置允许的大小");
        }
    }


}