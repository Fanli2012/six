<?php

namespace app\listener;

use think\facade\Log;

class SendEmail
{
    /**
     * 事件监听处理
     *
     * @return mixed
     */
    public function handle($event)
    {
        Log::info('邮件发送成功');
    }
}
