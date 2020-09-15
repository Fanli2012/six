<?php

namespace app\job;

use think\queue\Job;
use think\facade\Db;
use think\facade\Log;

class Example
{
    public function fire(Job $job, $data)
    {
        // 这里执行具体的任务
        $data = json_decode($data, true);
        if ($this->jobDone($data)) {
            $job->delete();
        } else {
			if ($job->attempts() > 3) {
				// 通过这个方法可以检查这个任务已经重试了几次了
			}
            $job->release(3); // $delay为延迟时间
        }
        // 如果任务执行成功后 记得删除任务，不然这个任务会重复执行，直到达到最大重试次数后失败后，执行failed方法
        // $job->delete();
        // 也可以重新发布这个任务
        // $job->release($delay); // $delay为延迟时间
    }

    public function failed($data)
    {
        // 任务达到最大重试次数后，失败了
		Log::info('队列执行失败');
    }

    public function jobDone($data)
    {
        Log::info('队列执行成功');
		return true;
    }
}

// 示例
// 生成队列所需的表
// php think queue:table
// php think queue:failed-table
// php think migrate:run
// 监听任务并执行
// php think queue:listen
// php think queue:work

// 当前任务将由哪个类来负责处理，当轮到该任务时，系统将生成一个该类的实例，并调用其 fire 方法
// $jobHandlerClassName = 'app\job\Example'; 
// 当前任务归属的队列名称，如果为新队列，会自动创建
// $jobQueueName = null;
// 当前任务所需的业务数据不能为 resource 类型，其他类型最终将转化为json形式的字符串
// $data = json_encode($data);
// 将该任务推送到消息队列，等待对应的消费者去执行
// $isPushed = \think\facade\Queue::push($jobHandlerClassName, $data, $jobQueueName);
// database 驱动时，返回值为 1|false  ;   redis 驱动时，返回值为 随机字符串|false
// if ( $isPushed !== false ) {  
// 	echo date('Y-m-d H:i:s') . " a new Job is Pushed to the MQ";
// } else {
// 	echo 'Oops, something went wrong.';
// }