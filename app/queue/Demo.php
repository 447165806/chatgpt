<?php
/**
 * Created by PhpStorm.
 * User: lj
 * Date: 2023/2/2
 * Time: 10:00
 */

namespace app\queue;


use think\facade\Db;
use think\queue\Job;

class Demo
{
    public function fire(Job $job, $data)
    {

        if($job->attempts() > 3){
            //检查任务重试次数
            print_r("这个任务已经重试了".$job->attempts()."次");

        }

        if(!$this->checkJob($data)){
            $job->delete();
        }else{
            if($this->doJob($data)){
                $job->delete();
            }
        }
    }

    /**
     * 任务是否仍需执行
     */
    private function checkJob($data)
    {
        //是否有待执行任务的数据
        return true;
    }

    /**
     * 任务业务处理
     */
    private function doJob($data)
    {
        // 实际业务流程处理
        return true;
    }
}