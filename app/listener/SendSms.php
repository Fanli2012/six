<?php

namespace app\listener;

use think\facade\Log;

class SendSms
{
    /**
     * 事件监听处理
     *
     * @return mixed
     */
    public function handle($event)
    {
        Log::info('短信发送成功');
		Log::info(json_encode($event));
    }
}
